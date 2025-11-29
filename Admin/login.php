<?php
session_start();

// Handle Remember Me Cookie
if (isset($_COOKIE['remember_user']) && !isset($_SESSION['admin'])) {
    $_SESSION['admin'] = $_COOKIE['remember_user'];
    $_SESSION['role'] = $_COOKIE['remember_role'];
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>
  <link rel="shortcut icon" href="img/dokanx-fav-white.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      background: #f5f5f5;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .login-container {
      background: #ffffff;
      border-radius: 10px;
      padding: 40px;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .login-title {
      color: #333;
      font-size: 28px;
      font-weight: 600;
      text-align: center;
      margin-bottom: 20px;
      position: relative; 
    }
    .login-title::after {
      content: "";
      position: absolute;
      left: 50%;
      bottom: -5px;
      transform: translateX(-50%);
      width: 40px;    
      height: 4px;
      background: #28a745;
    }

    .login-subtitle {
      color: #666;
      font-size: 14px;
      text-align: center;
      margin-bottom: 30px;
    }

    .msg-box {
      background: #ffebee;
      border-left: 4px solid #f44336;
      color: #c62828;
      padding: 12px 15px;
      border-radius: 4px;
      margin-bottom: 20px;
      font-size: 14px;
      display: none;
    }

    .credentials-box {
      background: #f9f9f9;
      border-left: 4px solid #4caf50;
      color: #555;
      padding: 12px 15px;
      border-radius: 4px;
      margin-bottom: 25px;
      font-size: 13px;
      line-height: 1.8;
      display: none;
    }

    .input-group {
      margin-bottom: 20px;
    }

    .input-group label {
      display: block;
      color: #333;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 8px;
    }

    .input-group input {
      width: 100%;
      padding: 12px 15px;
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 6px;
      color: #333;
      font-size: 14px;
      font-family: 'Poppins', sans-serif;
      transition: border-color 0.3s ease;
    }

    .input-group input:focus {
      outline: none;
      border-color: #4caf50;
    }

    .input-group input::placeholder {
      color: #999;
    }

    .password-wrapper {
      position: relative;
    }

    .password-wrapper input {
      padding-right: 45px;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      font-size: 16px;
      color: #999;
      padding: 5px;
      transition: color 0.3s ease;
    }

    .toggle-password:hover {
      color: #4caf50;
    }

    .password-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 12px;
      gap: 10px;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .remember-me input[type="checkbox"] {
      width: 16px;
      height: 16px;
      cursor: pointer;
      accent-color: #4caf50;
    }

    .remember-me label {
      color: #666;
      font-size: 13px;
      font-weight: 400;
      cursor: pointer;
      margin: 0;
    }

    .forgot-password {
      color: #666;
      font-size: 13px;
      text-decoration: none;
      transition: color 0.3s ease;
      white-space: nowrap;
    }

    .forgot-password:hover {
      color: #4caf50;
    }

    .login-btn {
      width: 100%;
      padding: 14px;
      background: #4caf50;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
      margin-top: 10px;
      transition: background 0.3s ease;
    }

    .login-btn:hover {
      background: #45a049;
    }

    .login-btn:active {
      transform: scale(0.98);
    }

    .login-footer {
      margin-top: 25px;
      text-align: center;
      color: #999;
      font-size: 12px;
    }

    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.9);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .loading-spinner {
      width: 50px;
      height: 50px;
      border: 4px solid #f0f0f0;
      border-top: 4px solid #4caf50;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @media (max-width: 500px) {
      .login-container {
        padding: 30px 25px;
      }

      .password-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="loading-overlay">
    <div class="loading-spinner"></div>
  </div>

  <div class="login-container">
    <h1 class="login-title">ADMIN LOGIN</h1>
    <p class="login-subtitle">Enter your credentials to continue</p>

    <div class="msg-box"></div>

    <div class="credentials-box">
      <strong>Demo Credentials:</strong><br/>
      <em>USERNAME:</em> <strong>admin_39_</strong><br/>
      <em>PASSWORD:</em> <strong>87654321</strong>
    </div>

    <form action="#" method="post" id="loginForm">
      <div class="input-group">
        <label for="username">Username</label>
        <input 
          type="text" 
          id="username" 
          name="username" 
          placeholder="Enter your username" 
          required 
        />
      </div>

      <div class="input-group">
        <label for="password">Password</label>
        <div class="password-wrapper">
          <input 
            type="password" 
            id="password" 
            name="password" 
            placeholder="Enter your password" 
            required 
          />
          <button type="button" class="toggle-password" onclick="togglePassword()">
            <i class="far fa-eye"></i>
          </button>
        </div>
        <div class="password-footer">
          <div class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember Me</label>
          </div>
          <a href="#" class="forgot-password">Forgot Password?</a>
        </div>
      </div>

      <button type="submit" class="login-btn">Log In</button>
    </form>

    <div class="login-footer">
      &copy; 2025 Admin Panel. All rights reserved.
    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const toggleBtn = document.querySelector('.toggle-password i');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleBtn.classList.remove('fa-eye');
        toggleBtn.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        toggleBtn.classList.remove('fa-eye-slash');
        toggleBtn.classList.add('fa-eye');
      }
    }

    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const loadingOverlay = document.querySelector('.loading-overlay');
      loadingOverlay.style.display = 'flex';
    });
  </script>

<?php

include('database/dbConnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    $stmt = $conn->prepare("SELECT 
                                admin_info.admin_password, 
                                admin_info.role_id, 
                                roles.role_name
                            FROM 
                                admin_info
                            JOIN 
                                roles ON admin_info.role_id = roles.id
                            WHERE 
                                admin_info.admin_username = ?
                            ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPwd = $row['admin_password'];

        if (password_verify($password, $hashedPwd)) {
            $_SESSION['admin'] = $username;
            $_SESSION['role'] = $row['role_name'];

            if ($remember) {
                setcookie('remember_user', $username, time() + (86400 * 30), "/");
                setcookie('remember_role', $row['role_name'], time() + (86400 * 30), "/");
            } else {
                if (isset($_COOKIE['remember_user'])) {
                    setcookie('remember_user', '', time() - 3600, "/");
                    setcookie('remember_role', '', time() - 3600, "/");
                }
            }

            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        }
    }

    echo '<script>
        const msg_box = document.querySelector(".msg-box");
        if (msg_box) {
            msg_box.style.display = "block";
            msg_box.innerHTML = "<i class=\"fas fa-exclamation-circle\"></i> Wrong Credentials!";
            setTimeout(() => {
                msg_box.style.display = "none";
            }, 3000);
        }
        const loadingOverlay = document.querySelector(".loading-overlay");
        if (loadingOverlay) {
            loadingOverlay.style.display = "none";
        }
    </script>';
}
?>

</body>
</html>