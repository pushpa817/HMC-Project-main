<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | HMC</title>
    <link rel="stylesheet" href="styles.css">
    <!--Box icon-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>

     <div class="form-container">
        <div class="form-header">
            <h3>Please login to continue</h3>
        </div>
        
        <form action="#" method="post" id="loginForm">
            <div class="txt_field">
                <select id="userType" name="user_type" class="custom-select" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="student">Student</option>
                    <option value="chairman">Chairman</option>
                    <option value="warden">Warden</option>
                    <option value="mess_manager">Mess Manager</option>
                    <option value="staff_manager">Staff Manager</option>
                </select>
                <i class='bx bxs-down-arrow custom-icon'></i>
                <span></span>
            </div>
            <div class="txt_field">
                <input type="text" id="username" name="username" placeholder="username" required autocomplete="username">
                <i class='bx bxs-user custom-icon' ></i>
                <span></span>
            </div>
            <div class="txt_field">
                <input type="password" id="password" name="password" placeholder="password" required autocomplete="current-password">
                <i class="bx bxs-hide custom-icon" id="togglePassword" style="cursor: pointer;"></i> 
                <span></span>
            </div>
            <div class="forgot_password">
                <a href="#">Forgot Password?</a>
            </div>
            <button type="submit" class="log-btn"><span>Login</span></button>
        </form>
     </div>

      <div class="cover">
        <img src="images/7.jpg" alt="">
        <div class="text">
          <span class="text-1">Welcome to IIT</span>
          <span class="text-2">Hall Management Centre</span>
        </div>
      </div>



    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const icon = this;

            // Toggle the password visibility
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
            icon.classList.toggle('bxs-show'); 
        });
    </script>
</body>
</html>