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
  <title>DokanX - Admin Login</title>
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
    }

    .login-container {
      display: flex;
      min-height: 100vh;
      animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    /* Left Brand Section */
    .brand-section {
      flex: 1;
      background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 60px;
      position: relative;
      overflow: hidden;
    }

    /* Animated particles background */
    .particles {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      z-index: 0;
    }

    .particle {
      position: absolute;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      animation: float 15s infinite ease-in-out;
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0) translateX(0) scale(1);
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      90% {
        opacity: 1;
      }
      100% {
        transform: translateY(-100vh) translateX(50px) scale(1.5);
        opacity: 0;
      }
    }

    .brand-section::before {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
      border-radius: 50%;
      top: -250px;
      right: -250px;
      animation: pulse 8s ease-in-out infinite;
    }

    .brand-section::after {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      border-radius: 50%;
      bottom: -200px;
      left: -200px;
      animation: pulse 6s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% {
        transform: scale(1);
        opacity: 0.5;
      }
      50% {
        transform: scale(1.1);
        opacity: 0.8;
      }
    }

    .brand-content {
      position: relative;
      z-index: 1;
      text-align: center;
    }

    .brand-logo {
      font-size: 72px;
      font-weight: 800;
      color: #ffffff;
      margin-bottom: 20px;
      letter-spacing: -2px;
      text-transform: uppercase;
      animation: slideInDown 0.8s ease-out;
      position: relative;
      display: inline-block;
    }

    .brand-logo::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 0;
      height: 4px;
      background: linear-gradient(90deg, #ffffff, transparent);
      animation: expandLine 1s ease-out 0.5s forwards;
    }

    @keyframes expandLine {
      to {
        width: 100%;
      }
    }

    @keyframes slideInDown {
      from {
        opacity: 0;
        transform: translateY(-50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .brand-logo span {
      color: #ffffff;
      font-weight: 300;
      display: inline-block;
      animation: letterGlow 2s ease-in-out infinite;
    }

    @keyframes letterGlow {
      0%, 100% {
        text-shadow: 0 0 10px rgba(255,255,255,0.5);
      }
      50% {
        text-shadow: 0 0 20px rgba(255,255,255,0.8), 0 0 30px rgba(255,255,255,0.6);
      }
    }

    .brand-logo-mobile {
      font-size: 32px;
      font-weight: 800;
      color: #000000ff;
      margin-bottom: 20px;
      letter-spacing: -2px;
      text-transform: uppercase;
      text-align: center;
      display: none;
      animation: slideInDown 0.8s ease-out;
    }

    .brand-logo-mobile::after {
      content: '';
      display: block;
      width: 60px;
      height: 4px;
      background: #000000ff;
      margin: 2px auto 0;
      border-radius: 2px;
    }

    .brand-logo-mobile span {
      color: #000000ff;
      font-weight: 300;
    }

    .brand-tagline {
      color: rgba(255, 255, 255, 0.7);
      font-size: 18px;
      margin-bottom: 40px;
      letter-spacing: 2px;
      text-transform: uppercase;
      animation: slideInUp 0.8s ease-out 0.2s backwards;
    }

    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .brand-features {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 25px;
      margin-top: 60px;
      width: 100%;
      max-width: 600px;
    }

    @media only screen and (max-width: 1395px) {
      .brand-features {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    .feature-item {
      text-align: center;
      color: #ffffff;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: 20px;
      padding: 30px 20px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      opacity: 0;
      animation: fadeInScale 0.6s ease-out forwards;
    }

    .feature-item:nth-child(1) { animation-delay: 0.4s; }
    .feature-item:nth-child(2) { animation-delay: 0.5s; }
    .feature-item:nth-child(3) { animation-delay: 0.6s; }

    @keyframes fadeInScale {
      from {
        opacity: 0;
        transform: scale(0.8);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
    }

    .feature-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
      opacity: 0;
      transition: opacity 0.4s ease;
    }

    .feature-item::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      transform: translate(-50%, -50%);
      transition: width 0.6s ease, height 0.6s ease;
    }

    .feature-item:hover::after {
      width: 300px;
      height: 300px;
    }

    .feature-item:hover {
      transform: translateY(-10px) scale(1.05);
      background: rgba(255, 255, 255, 0.15);
      border-color: rgba(255, 255, 255, 0.4);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .feature-item:hover::before {
      opacity: 1;
    }

    .feature-icon {
      width: 60px;
      height: 60px;
      margin: 0 auto 20px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(5px);
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      z-index: 1;
    }

    .feature-item:hover .feature-icon {
      background: rgba(255, 255, 255, 0.2);
      border-color: #ffffff;
      transform: scale(1.1) rotate(360deg);
      box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
    }

    .feature-icon i {
      color: #ffffff;
    }

    .feature-text {
      font-size: 15px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      position: relative;
      z-index: 1;
    }

    .feature-description {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.7);
      margin-top: 8px;
      font-weight: 400;
      letter-spacing: 0.5px;
      position: relative;
      z-index: 1;
    }

    /* Right Login Section */
    .login-section {
      flex: 1;
      background: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px;
      animation: slideInRight 0.8s ease-out;
    }

    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .login-form-wrapper {
      width: 100%;
      max-width: 450px;
    }

    .login-header {
      margin-bottom: 50px;
    }

    .login-title {
      font-size: 36px;
      font-weight: 700;
      color: #000000;
      margin-bottom: 5px;
      animation: slideInLeft 0.6s ease-out;
      background: linear-gradient(135deg, #000000 0%, #333333 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-30px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .login-subtitle {
      color: #666666;
      font-size: 16px;
      font-weight: 400;
      margin-bottom: 20px;
      animation: slideInLeft 0.6s ease-out 0.1s backwards;
    }

    .msg-box {
      background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
      color: #c62828;
      padding: 15px 20px;
      border-radius: 8px;
      margin-bottom: 25px;
      font-size: 14px;
      border-left: 4px solid #c62828;
      display: none;
      animation: shake 0.5s ease;
      box-shadow: 0 4px 12px rgba(198, 40, 40, 0.2);
    }

    .credentials-box {
      background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
      color: #1565c0;
      padding: 15px 20px;
      border-radius: 8px;
      margin-bottom: 25px;
      font-size: 14px;
      border-left: 4px solid #1565c0;
      animation: shake 0.5s ease;
      box-shadow: 0 4px 12px rgba(21, 101, 192, 0.2);
      display: none;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-10px); }
      75% { transform: translateX(10px); }
    }

    .input-group {
      margin-bottom: 25px;
      animation: slideInLeft 0.6s ease-out backwards;
    }

    .input-group:nth-child(1) { animation-delay: 0.2s; }
    .input-group:nth-child(2) { animation-delay: 0.3s; }

    .input-group label {
      display: block;
      color: #333333;
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 10px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      transition: color 0.3s ease;
    }

    .input-wrapper {
      position: relative;
    }

    .input-group input {
      width: 100%;
      padding: 16px 20px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 15px;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: #ffffff;
      font-family: 'Poppins', sans-serif;
    }

    .input-group input:focus {
      outline: none;
      border-color: #000000;
      background: #fafafa;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .input-group input:focus + .input-line {
      width: 100%;
    }

    .input-group input::placeholder {
      color: #999999;
    }

    .password-wrapper {
      position: relative;
    }

    .password-wrapper input {
      padding-right: 50px;
    }

    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      font-size: 20px;
      color: #666666;
      padding: 5px;
      transition: all 0.3s ease;
    }

    .toggle-password:hover {
      color: #000000;
      transform: translateY(-50%) scale(1.1);
    }

    .password-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 18px;
    }

    /* Remember Me Checkbox */
    .remember-me {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .remember-me input[type="checkbox"] {
      /* appearance: none; */
      width: 20px;
      height: 20px;
      border: 2px solid #e0e0e0;
      border-radius: 4px;
      cursor: pointer;
      position: relative;
      transition: all 0.3s ease;
    }

    .remember-me input[type="checkbox"]:checked {
      background: #000000;
      border-color: #000000;
    }

    .remember-me input[type="checkbox"]:checked::after {
      content: '\f00c';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: #ffffff;
      font-size: 12px;
      animation: checkPop 0.3s ease;
    }

    @keyframes checkPop {
      0% {
        transform: translate(-50%, -50%) scale(0);
      }
      50% {
        transform: translate(-50%, -50%) scale(1.2);
      }
      100% {
        transform: translate(-50%, -50%) scale(1);
      }
    }

    .remember-me label {
      color: #666666;
      font-size: 13px;
      font-weight: 500;
      cursor: pointer;
      transition: color 0.3s ease;
      margin: 0;
      text-transform: none;
      letter-spacing: normal;
    }

    .remember-me label:hover {
      color: #000000;
    }

    .forgot-password {
      color: #666666;
      font-size: 13px;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      position: relative;
    }

    .forgot-password::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: #000000;
      transition: width 0.3s ease;
    }

    .forgot-password:hover {
      color: #000000;
    }

    .forgot-password:hover::after {
      width: 100%;
    }

    .login-btn {
      width: 100%;
      padding: 18px;
      background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
      color: #ffffff;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      cursor: pointer;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      margin-top: 10px;
      font-family: 'Poppins', sans-serif;
      position: relative;
      overflow: hidden;
      animation: slideInLeft 0.6s ease-out 0.4s backwards;
    }

    .login-btn::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: translate(-50%, -50%);
      transition: width 0.6s ease, height 0.6s ease;
    }

    .login-btn:hover::before {
      width: 400px;
      height: 400px;
    }

    .login-btn:hover {
      background: linear-gradient(135deg, #1a1a1a 0%, #333333 100%);
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    .login-btn:active {
      transform: translateY(0);
    }

    .login-btn span {
      position: relative;
      z-index: 1;
    }

    .login-footer {
      margin-top: 30px;
      text-align: center;
      color: #999999;
      font-size: 13px;
      animation: slideInLeft 0.6s ease-out 0.5s backwards;
    }

    /* Loading Animation */
    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      backdrop-filter: blur(5px);
    }

    .loading-spinner {
      width: 60px;
      height: 60px;
      border: 4px solid rgba(255, 255, 255, 0.3);
      border-top: 4px solid #ffffff;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 968px) {
      .login-container {
        background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        justify-content: center;
        align-items: center;
        padding: 20px;
      }

      .brand-section {
        display: none;
      }

      .login-section {
        padding: 0;
        background: transparent;
        max-width: 500px;
        width: 100%;
      }

      .login-form-wrapper {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
      }

      .login-title {
        font-size: 28px;
      }

      .login-subtitle {
        font-size: 14px;
      }

      .login-header {
        margin-bottom: 35px;
      }

      .brand-logo-mobile {
        display: block;
      }

      .password-footer {
        /* flex-direction: column;
        align-items: flex-start; */
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
    <!-- Left Brand Section -->
    <div class="brand-section">
      <div class="particles" id="particles"></div>
      <div class="brand-content">
        <div class="brand-logo">
          DOKAN<span>X</span>
        </div>
        <div class="brand-tagline">Admin Dashboard</div>
        
        <div class="brand-features">
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-bolt"></i>
            </div>
            <div class="feature-text">Lightning Fast</div>
            <div class="feature-description">Optimized Performance</div>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-shield-halved"></i>
            </div>
            <div class="feature-text">Ultra Secure</div>
            <div class="feature-description">Military Grade Security</div>
          </div>
          <div class="feature-item">
            <div class="feature-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <div class="feature-text">Powerful</div>
            <div class="feature-description">Advanced Analytics</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Login Section -->
    <div class="login-section">
      <div class="login-form-wrapper">
        <div class="login-header-mobile">
          <div class="brand-logo-mobile">
            DOKAN<span>X</span>
          </div>

          <h1 class="login-title">Welcome Back</h1>
          <p class="login-subtitle">Please enter your credentials to continue</p>
        </div>

        <div class="msg-box"></div>

        <div class="credentials-box">
          <strong>Demo Credentials:</strong><br/>
          <em>USERNAME</em>: <strong>admin_39_</strong><br/>
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

          <button type="submit" class="login-btn">
            <span>Log In</span>
          </button>
        </form>

        <div class="login-footer">
          &copy; 2025 DokanX. All rights reserved.
        </div>
      </div>
    </div>
  </div>

  <script>
    // Create animated particles
    function createParticles() {
      const particlesContainer = document.getElementById('particles');
      if (!particlesContainer) return;
      
      for (let i = 0; i < 50; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        particle.style.width = Math.random() * 5 + 2 + 'px';
        particle.style.height = particle.style.width;
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDuration = Math.random() * 10 + 10 + 's';
        particle.style.animationDelay = Math.random() * 5 + 's';
        particlesContainer.appendChild(particle);
      }
    }

    // Toggle password visibility
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

    // Form submission handler
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const loadingOverlay = document.querySelector('.loading-overlay');
      loadingOverlay.style.display = 'flex';
    });

    // Input focus animation
    document.querySelectorAll('.input-group input').forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.parentElement.querySelector('label').style.color = '#000000';
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.parentElement.querySelector('label').style.color = '#333333';
      });
    });

    // Initialize particles
    createParticles();
  </script>

<?php

include('database/dbConnection.php'); // Include database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Fetch hashed password and role from the database
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
            // Password is correct
            $_SESSION['admin'] = $username;
            $_SESSION['role'] = $row['role_name'];

            // Handle Remember Me
            if ($remember) {
                // Set cookie for 30 days
                setcookie('remember_user', $username, time() + (86400 * 30), "/");
                setcookie('remember_role', $row['role_name'], time() + (86400 * 30), "/");
            } else {
                // Clear cookies if remember me is not checked
                if (isset($_COOKIE['remember_user'])) {
                    setcookie('remember_user', '', time() - 3600, "/");
                    setcookie('remember_role', '', time() - 3600, "/");
                }
            }

            echo "<script>window.location.href = 'index.php';</script>";
            exit();
        }
    }

    // If we reach here, authentication failed
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