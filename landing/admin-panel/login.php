<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <link rel="stylesheet" href="css/login.css" />
  <style>
        .msg-box {
            max-width: 500px;
            margin: auto;
            color: red;
            background: #ebebeb;
            padding: 10px;
            margin-bottom: 10px;
            transition: width 3s linear;
            display: none;
        }
        .credentials {
            background: #f1f1f1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
  <div class="login_form">
    <!-- Login form container -->
    <form action="#" method="post">
      <h3>Admin Login</h3>

      <br>
      <!-- <div class="credentials">
        <p>username: admin_39_</p>
        <p>password: 87654321</p>
      </div> -->

      <br><br>
      <h3 class="msg-box"></h3>
      <!-- username input box -->
      <div class="input_box">
        <label for="username">Username</label>
        <input name="username" type="username" id="username" placeholder="Enter username address" required />
      </div>
      <!-- Paswwrod input box -->
      <div class="input_box">
        <div class="password_title">
          <label for="password">Password</label>
        </div>
        <input name="password" type="password" id="password" placeholder="Enter your password" required />
      </div>
      <!-- Login button -->
      <button type="submit">Log In</button>
    </form>
  </div>

<?php

include('../dbConnection.php'); // Include database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the admin exists
    $query = "SELECT * FROM admin_info WHERE admin_username = ? AND admin_password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Admin authenticated successfully
        $_SESSION['admin'] = $username;
        ?>
        <META http-equiv="refresh" content="0;url=index.php"> 
        <?php
        exit();
    } else {
        // Authentication failed
        ?>
          <script>
            const msg_box = document.querySelector(".msg-box");
            msg_box.style.display = 'block';
            msg_box.innerHTML = "Wrong Credentials!";
            setTimeout(() => {
                msg_box.style.display = 'none';
            }, 2000); // Hide after 3 seconds
          </script>
        <?php
    }
}
?>

</body>
</html>