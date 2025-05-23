<?php
// session_start();
// include 'db.php';

// $error = '';

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     // Prepare and execute statement
//     $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
//     mysqli_stmt_bind_param($stmt, "s", $email);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);

//     if ($result && mysqli_num_rows($result) > 0) {
//         $user = mysqli_fetch_assoc($result);

//         if (password_verify($password, $user['password'])) {
//             $_SESSION['user_id'] = $user['id'];
//             $_SESSION['user_role'] = $user['role'];

//             if ($user['role'] == 'admin') {
//                 header("Location: admin/dashboard.php");
//             } elseif ($user['role'] == 'instructor') {
//                 header("Location: instructor/dashboard.php");
//             } elseif ($user['role'] == 'student') {
//                 header("Location: student/dashboard.php");
//             } else {
//                 header("Location: index.php");
//             }
//             exit;
//         } else {
//             $error = "Invalid email or password.";
//         }
//     } else {
//         $error = "Invalid email or password.";
//     }
// }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="register.php" class="btn btn-link">Don't have an account?</a>
    </form>
</div>
</body>
</html>
