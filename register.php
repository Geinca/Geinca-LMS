<?php
session_start();
require 'db.php'; // Changed to require for critical file

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($fullname)) {
        $errors[] = "Full name is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if (!in_array($role, ['student', 'instructor'])) {
        $errors[] = "Invalid user role selected.";
    }

    if (empty($errors)) {
        // Check if email exists using prepared statement
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $errors[] = "Email already registered.";
        }
        $stmt->close();

        if (empty($errors)) {
            // Hash password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user with prepared statement
            $stmt = $conn->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fullname, $email, $password_hash, $role);
            
            if ($stmt->execute()) {
                $_SESSION['registration_success'] = true;
                header("Location: login.php");
                exit();
            } else {
                $errors[] = "Database error: " . $conn->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Educational Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .register-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            background-color: white;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .password-strength {
            height: 5px;
            margin-top: 5px;
            background: #eee;
        }
        .password-strength-bar {
            height: 100%;
            width: 0%;
            background: transparent;
            transition: width 0.3s, background 0.3s;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="register-container">
        <h2 class="text-center mb-4">Create Your Account</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p class="mb-1"><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate>
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required
                       value="<?php echo isset($fullname) ? htmlspecialchars($fullname) : ''; ?>"
                       placeholder="Enter your full name">
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required
                       value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                       placeholder="Enter your email">
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required
                       placeholder="At least 8 characters" minlength="8"
                       oninput="checkPasswordStrength(this.value)">
                <div class="password-strength">
                    <div class="password-strength-bar" id="password-strength-bar"></div>
                </div>
                <div class="form-text">Password must be at least 8 characters long.</div>
            </div>
            
            <div class="mb-4">
                <label for="role" class="form-label">I am a:</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="">Select your role</option>
                    <option value="student" <?php echo (isset($role) && $role === 'student') ? 'selected' : ''; ?>>Student</option>
                    <option value="instructor" <?php echo (isset($role) && $role === 'instructor') ? 'selected' : ''; ?>>Instructor</option>
                </select>
            </div>
            
            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn btn-primary btn-lg">Register</button>
            </div>
            
            <div class="text-center">
                <p>Already have an account? <a href="login.php">Log in</a></p>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function checkPasswordStrength(password) {
        const strengthBar = document.getElementById('password-strength-bar');
        let strength = 0;
        
        if (password.length >= 8) strength += 1;
        if (password.match(/[a-z]+/)) strength += 1;
        if (password.match(/[A-Z]+/)) strength += 1;
        if (password.match(/[0-9]+/)) strength += 1;
        if (password.match(/[!@#$%^&*()_+]+/)) strength += 1;
        
        switch(strength) {
            case 0:
                strengthBar.style.width = '0%';
                strengthBar.style.background = 'transparent';
                break;
            case 1:
                strengthBar.style.width = '20%';
                strengthBar.style.background = '#dc3545';
                break;
            case 2:
                strengthBar.style.width = '40%';
                strengthBar.style.background = '#fd7e14';
                break;
            case 3:
                strengthBar.style.width = '60%';
                strengthBar.style.background = '#ffc107';
                break;
            case 4:
                strengthBar.style.width = '80%';
                strengthBar.style.background = '#28a745';
                break;
            case 5:
                strengthBar.style.width = '100%';
                strengthBar.style.background = '#20c997';
                break;
        }
    }
</script>
</body>
</html>