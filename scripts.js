document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('password');
    const icon = this;
    passwordField.type = (passwordField.type === 'password') ? 'text' : 'password';
    icon.classList.toggle('bxs-show'); 
});

// Toggle password visibility for the new password input
document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
    const confirmPasswordField = document.getElementById('confirmPassword');
    const icon = this;
    confirmPasswordField.type = (confirmPasswordField.type === 'password') ? 'text' : 'password';
    icon.classList.toggle('bxs-show'); 
});

function showForm(formId) {
    const forms = ['login-form', 'forgot-form', 'verify-form', 'reset-form'];
    forms.forEach(id => {
        document.getElementById(id).style.display = (id === formId) ? 'flex' : 'none';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(loginForm);

        const errorMessage = document.getElementById('error-message');

        errorMessage.textContent = " ";


        fetch('login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.href = data.redirect;
            } else {
                errorMessage.textContent = data.message; // Show error message
            }
        })
        .catch(error => {
            console.error('Error:', error); // Log any errors
        });
    });
});


function requestCode() {
    const username = document.getElementById('forgotUsername').value.trim();
    const userType = document.getElementById('forgotUserType').value;
    const forgotErrorMessage = document.getElementById('forgot-error-message'); // Element for showing messages
    if(userType === ""){
        forgotErrorMessage.textContent = "Select your role!";
        return;
    }

    if(username === ""){
        forgotErrorMessage.textContent = "Enter your ID!";
        return;
    }


    // Display 'Processing...' to indicate the request is being handled
    forgotErrorMessage.textContent = "Processing...";

    fetch('forgot_password.php', {
        method: 'POST',
        body: JSON.stringify({ username, user_type: userType }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            // If the request is successful, switch to the verification form
            forgotErrorMessage.textContent = "";
            showForm('verify-form');
        } else {
            // If an error occurred, display the error message
            forgotErrorMessage.textContent = data.message;
        }
    })
    .catch(error => {
        // Handle network or other unexpected errors
        forgotErrorMessage.textContent = "An error occurred: " + error.message;
    });
}



function verifyCode() {
    const code = document.getElementById('verificationCode').value;
    fetch('verify_code.php', {
        method: 'POST',
        body: JSON.stringify({ code }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const verifyErrorMessage = document.getElementById('verify-error-message');
        if (data.status === 'success') {
            showForm('reset-form');
        } else {
            verifyErrorMessage.textContent = data.message;
        }
    });
}


function resetPassword() {
    const newPassword = document.getElementById('newPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const resetErrorMessage = document.getElementById('reset-error-message');

    // Validate passwords
    if (newPassword.length < 6) {
        resetErrorMessage.textContent = "Password must be at least 6 characters long!";
        return;
    }
    
    if (newPassword !== confirmPassword) {
        resetErrorMessage.textContent = "Passwords do not match!";
        return;
    }
    
    fetch('reset_password.php', {
        method: 'POST',
        body: JSON.stringify({ newPassword }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const resetErrorMessage = document.getElementById('reset-error-message');
        if (data.status === 'success') {
            alert('Password reset successfully. Please log in.');
            window.location.href = "index.php";
        } else {
            resetErrorMessage.textContent = data.message;
        }
    });
}
