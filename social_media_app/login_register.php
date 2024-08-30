<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        /* Additional styles can be added here if needed */
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <!-- Login Form -->
            <div id="login-form">
                <h1>Login</h1>
                <form method="POST" action="login.php">
                    Email: <input type="email" name="email" required><br>
                    Password: <input type="password" name="password" required><br>
                    <button type="submit">Login</button>
                </form>
                <div class="toggle">
                    <button onclick="toggleForm()">Don't have an account? Register</button>
                </div>
            </div>

            <!-- Register Form -->
            <div id="register-form" style="display:none;">
                <h1>Register</h1>
                <form method="POST" action="register.php">
                    Username: <input type="text" name="username" required><br>
                    Email: <input type="email" name="email" required><br>
                    Password: <input type="password" name="password" required><br>
                    <button type="submit">Register</button>
                </form>
                <div class="toggle">
                    <button onclick="toggleForm()">Already have an account? Login</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleForm() {
            var loginForm = document.getElementById('login-form');
            var registerForm = document.getElementById('register-form');

            if (loginForm.style.display === 'none') {
                loginForm.style.display = 'block';
                registerForm.style.display = 'none';
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            }
        }
    </script>
</body>
</html>
