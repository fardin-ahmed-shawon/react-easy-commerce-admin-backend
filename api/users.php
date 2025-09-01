<?php
session_start();
require_once './config.php';


// Set a custom error handler to return JSON for errors
set_exception_handler(function ($exception) {
    $response = array(
        "success" => false,
        "message" => $exception->getMessage()
    );
    echo json_encode($response);
    exit();
});


// Receive the action type
$action = $_GET['action'] ?? '';

// Check if the 'action' parameter is set in the URL
if ($action == '') {
    $response = array(
        "success" => false,
        "message" => "No action specified!"
    );
    echo json_encode($response);
    exit();
}



//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////// Handle the 'add-user' action ///////////////////////////
////////////////////////////////////////////////////////////////////////////////////
if ($action == 'add-user') {

    // Post data from the request
    $full_name = $_POST['full_name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';     // optional email field
    $role = $_POST['role'] ?? '';
    $status = $_POST['status'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $profile_img = '';    // optional profile image field


    // Check if user already exists by phone
    $stmt = $con->prepare("SELECT id FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $response = array(
            "success" => false,
            "message" => "A user with this phone already exists."
        );
        echo json_encode($response);
        exit();
    }


    // check if the password and confirm password match
    if ($password !== $confirm_password) {
        $response = array(
            "success" => false,
            "message" => "Password and Confirm Password do not match."
        );
        echo json_encode($response);
        exit();
    }

    
    // Image compression and upload ------------------------
    // END ------------------------------------------------


    // Validate required fields
    if (empty($full_name) || empty($phone) || empty($password) || empty($role) || empty($status)) {
        $response = array(
            "success" => false,
            "message" => "Fill up the required fields."
        );
        echo json_encode($response);
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement to insert the user into the database
    $stmt = $con->prepare("INSERT INTO users (full_name, phone, email, role, status, password, profile_img) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $full_name, $phone, $email, $role, $status, $hashed_password, $profile_img);
    if ($stmt->execute()) {
        $response = array(
            "success" => true,
            "message" => "User successfully added"
        );
    }

    echo json_encode($response);
    exit();
}
////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// END ///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////
//////////////////////// Handle the 'update-user-info' action ////////////////////////
////////////////////////////////////////////////////////////////////////////////
else if ($action == 'update-user-info') {

    $user_id = $_POST['user_id'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';
    $status = $_POST['status'] ?? '';

    //$password = $_POST['password'] ?? '';


    // Validate required fields
    if (empty($user_id) || empty($full_name) || empty($phone) || empty($role) || empty($status)) {
        $response = array(
            "success" => false,
            "message" => "All fields are required."
        );
        echo json_encode($response);
        exit();
    }

    // Hash the password
    //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement to update the user in the database
    $stmt = $con->prepare("UPDATE users SET full_name = ?, phone = ?, email = ?, role = ?, status = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $full_name, $phone, $email, $role, $status, $user_id);
    if ($stmt->execute()) {
        $response = array(
            "success" => true,
            "message" => "User successfully updated"
        );
    }

    echo json_encode($response);
    exit();
}
////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// END ///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////
//////////////////////// Handle the 'update-user-password' action ////////////////////////
////////////////////////////////////////////////////////////////////////////////
else if ($action == 'update-user-password') {
    
    $user_id = $_POST['user_id'] ?? '';
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_new_password = $_POST['confirm_new_password'] ?? '';

    // Validate required fields
    if (empty($user_id) || empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        echo json_encode([
            "success" => false,
            "message" => "All fields are required."
        ]);
        exit();
    }

    if ($new_password !== $confirm_new_password) {
        echo json_encode([
            "success" => false,
            "message" => "New passwords do not match."
        ]);
        exit();
    }

    // Fetch current password hash from database
    $stmt = $con->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows == 0) {
        echo json_encode([
            "success" => false,
            "message" => "User not found."
        ]);
        exit();
    }

    $user = $result->fetch_assoc();
    if (!password_verify($current_password, $user['password'])) {
        echo json_encode([
            "success" => false,
            "message" => "Current password is incorrect."
        ]);
        exit();
    }

    // Hash new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in database
    $stmt = $con->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $hashed_password, $user_id);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Password updated successfully."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update password."
        ]);
    }

    exit();
}
////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// END ///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////
/////////////////////////// Handle the 'user-login' action //////////////////////////
////////////////////////////////////////////////////////////////////////////////////
if ($action == 'user-login') {

    // Get the phone and password from POST data
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate the phone and password
    if (empty($phone) || empty($password)) {
        $response = array(
            "success" => false,
            "message" => "You must provide both phone and password."
        );
        echo json_encode($response);
        exit();
    }

    // Fetch user by phone
    $stmt = $con->prepare("SELECT * FROM users WHERE phone = ?");
    $stmt->bind_param("s", $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variables for the user
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];

            $response = array(
                "success" => true,
                "message" => "Login Successful.",
                "user" => array(
                    "id" => $user['id'],
                    "user_full_name" => $user['full_name'],
                    "user_phone" => $user['phone'],
                    "user_role" => $user['role']
                )
            );
        } else {
            $response = array(
                "success" => false,
                "message" => "Your password is incorrect!"
            );
        }
    } else {
        $response = array(
            "success" => false,
            "message" => "Invalid phone or password."
        );
    }

    echo json_encode($response);
    exit();
}
////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////// END ///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////



// Handle wrong/invalid action
else {
    $response = array(
        "success" => false,
        "message" => "Invalid action specified!"
    );
    echo json_encode($response);
    exit();
}

?>