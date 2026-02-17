<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | HMC</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

<div class="form-container" id="login-form">
    <div class="form-header">
        <h3>Please login to continue</h3>
    </div>

    <form id="loginForm" action="" method="post">
        <div class="txt_field">
            <select id="userType" name="user_type" class="custom-select" required>
                <option value="" disabled selected>Select your role</option>
                <option value="student">Student</option>
                <option value="warden">Warden</option>
                <option value="mess_manager">Mess Manager</option>
                <option value="chairman">Chairman</option>
                <option value="staff_manager">Staff Manager</option>
            </select>
            <i class='bx bxs-down-arrow custom-icon'></i>
            <span></span>
        </div>
        <div class="txt_field">
            <input type="text" id="userID" name="userID" placeholder="Your ID" required autocomplete="userID">
            <i class='bx bxs-user custom-icon'></i>
            <span></span>
        </div>
        <div class="txt_field">
            <input type="password" id="password" name="password" placeholder="Password" required autocomplete="current-password">
            <i class="bx bxs-hide custom-icon" id="togglePassword" style="cursor: pointer;"></i> 
            <span></span>
        </div>
        <div class="forgot_password">
            <a href="#" onclick="showForm('forgot-form')">Forgot Password?</a>
        </div>
        <p id="error-message" class="error-message"></p>
        <button type="submit" class="log-btn"><span>Login</span></button>
    </form>
</div>

    <div class="form-container" id="forgot-form" style="display: none;">
        <div class="form-header">
            <h3>Forgot password?</h3>
        </div>
        <form id="forgotForm">
            <div class="txt_field">
                <select id="forgotUserType" name="forgotUserType" class="custom-select" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="student">Student</option>
                    <option value="warden">Warden</option>
                    <option value="mess_manager">Mess Manager</option>
                    <option value="chairman">Chairman</option>
                    <option value="staff_manager">Staff Manager</option>
                </select>
                <i class='bx bxs-down-arrow custom-icon'></i>
                <span></span>
            </div>
            <div class="txt_field">
                <input type="text" id="forgotUsername" name="username" placeholder="Your ID" required autocomplete="username">
                <i class='bx bxs-user custom-icon'></i>
                <span></span>
            </div>
            <p id="forgot-error-message" class="error-message"></p>
            <button type="button" class="log-btn" onclick="requestCode()"><span>Request code</span></button>
            <button type="button" class="back-btn" onclick="showForm('login-form')"><span>Back to login</span></button>
        </form>
    </div>

    <div class="form-container" id="verify-form" style="display: none;">
        <div class="form-header">
            <h3>Verify Code</h3>
        </div>
        <div class="email_info" style="font-size:0.85rem;">
            Verification code is sent to your registered email
        </div>
        <form id="verifyForm">    
            <div class="txt_field">
                <input type="text" id="verificationCode" name="verificationCode" placeholder="Enter code" required>
                <i class='bx bxs-lock custom-icon'></i>
                <span></span>
            </div>
            <p id="verify-error-message" class="error-message"></p>
            <button type="button" class="log-btn" onclick="verifyCode()"><span>Verify code</span></button>
            <button type="button" class="back-btn" onclick="showForm('forgot-form')"><span>Back</span></button>
        </form>
    </div>

    <div class="form-container" id="reset-form" style="display: none;">
        <div class="form-header">
            <h3>Reset Password</h3>
        </div>
        <form id="resetForm">
            <div class="txt_field">
                <input type="password" id="newPassword" name="newPassword" placeholder="New password" required>
                <i class='bx bxs-key custom-icon'></i> 
                <span></span>
            </div>
            <div class="txt_field">
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Retype password" required>
                <i class="bx bxs-hide custom-icon" id="toggleConfirmPassword" style="cursor: pointer;"></i> 
                <span></span>
            </div>
            <p id="reset-error-message" class="error-message"></p>
            <button type="button" class="log-btn" onclick="resetPassword()"><span>Confirm</span></button>
        </form>
    </div>

    <div class="cover">
        <img src="images/7.jpg" alt="">
        <div class="text">
            <span class="text-1">Welcome to IIT</span>
            <span class="text-2">Hall Management Center</span>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
