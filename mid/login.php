<?php
// Include the database connection file
include 'database.php';  // Assuming database.php contains the connection code

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : null;
    $action = $_POST['action']; // Either 'login' or 'signup'

    if ($action === 'signup') {
        // Signup logic
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@gmail.com')) {
            echo "<script>alert('Please enter a valid email address ending with @gmail.com.'); history.back();</script>";
            exit;
        }
        if (strlen($password) < 8 || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            echo "<script>alert('Password must be at least 8 characters long and contain a special character.'); history.back();</script>";
            exit;
        }
        if ($password !== $confirmPassword) {
            echo "<script>alert('Passwords do not match.'); history.back();</script>";
            exit;
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "<script>alert('Signup successful! You can now log in.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Email already exists or an error occurred.'); history.back();</script>";
        }
        $stmt->close();
    } elseif ($action === 'login') {
        // Login logic
        $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);

        if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
            echo "<script>alert('Login successful!'); window.location.href = 'mainpage.html';</script>";
        } else {
            echo "<script>alert('Invalid email or password.'); history.back();</script>";
        }
        $stmt->close();
    }
    $conn->close();
    exit;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('https://mindfuldesignconsulting.com/wp-content/uploads/2021/08/Women-Clothing-Boutique-Store-Interior.jpg');
            background-size: cover;
            background-position: center;
            filter: blur(8px);
            z-index: 0;
        }

        .container {
            background: #F3CFC6;
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 300px;
            position: relative;
            z-index: 1;
        }

        h2 {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
            width: 93%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: white;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .link {
            margin-top: 10px;
            display: block;
            text-align: center;
            cursor: pointer;
        }
        .error {
            color: red;
            text-align: center;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container" id="auth-container">
        <h2 id="form-title">Login</h2>
        <div class="error" id="error-message"></div>
        <form id="auth-form" method="POST" action="login.php">
            <input type="text" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" style="display: none;">
            <button type="submit">Login</button>
            <input type="hidden" name="action" value="login">
        </form>
        <span class="link" id="toggle-link">Need an account? Sign up</span>
    </div>

    <script>
        const authContainer = document.getElementById('auth-container');
        const formTitle = document.getElementById('form-title');
        const errorMessage = document.getElementById('error-message');
        const toggleLink = document.getElementById('toggle-link');
        const authForm = document.getElementById('auth-form');
        const confirmPasswordField = document.getElementById('confirm-password');

        toggleLink.addEventListener('click', () => {
            if (formTitle.textContent === 'Login') {
                formTitle.textContent = 'Sign Up';
                authForm.querySelector('button').textContent = 'Sign Up';
                confirmPasswordField.style.display = 'block';
                toggleLink.textContent = 'Already have an account? Login';
                errorMessage.textContent = '';
                document.getElementById('email').placeholder = 'Email (must contain @gmail.com)';
                document.getElementById('password').placeholder = 'Password (8+ characters, special character required)';
                authForm.querySelector('input[name="action"]').value = 'signup';
            } else {
                formTitle.textContent = 'Login';
                authForm.querySelector('button').textContent = 'Login';
                confirmPasswordField.style.display = 'none';
                toggleLink.textContent = 'Need an account? Sign up';
                errorMessage.textContent = '';
                document.getElementById('email').placeholder = 'Email';
                document.getElementById('password').placeholder = 'Password';
                authForm.querySelector('input[name="action"]').value = 'login';
            }
        });
    </script>
</body>
</html>
