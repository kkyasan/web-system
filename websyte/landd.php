<?php
require 'config.php';

if (is_logged_in()) {
    header('Location: home.php');
    exit;
}

$errors = [];
$username = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    if (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $username)) {
        $errors[] = 'Username must be 3-20 characters: letters, numbers and underscores only.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirm) {
        $errors[] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, 'SELECT id FROM users WHERE username = ? OR email = ?');
        mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = 'That username or email is already registered.';
        }
        mysqli_stmt_close($stmt);
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);   // never store plain passwords
        $stmt = mysqli_prepare($conn, 'INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'sss', $username, $email, $hash);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header('Location: login.php?registered=1');
            exit;
        }
        $errors[] = 'Something went wrong. Please try again.';
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>The Bookhive - Dystopian Reads</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Montserrat&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="header">
    <h1><strong>THE BOOKHIVE</strong></h1>
    <img class="logo" src="logo.svg" alt="The Bookhive logo">
  </div>

  <div class="body">
    <h2>Step into the worlds bereft of reason.<br>Keep track of your reads.</h2>
    <p>Log the futures you're afraid of. Review the ones you survive.</p>

    <?php if (!empty($errors)): ?>
      <div class="msg error">
        <?php foreach ($errors as $err): ?>
          <p><?= e($err) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form class="sign auth-form" method="post" action="landd.php">
      <input type="text" name="username" placeholder="Username" value="<?= e($username) ?>" required>
      <input type="email" name="email" placeholder="Email address" value="<?= e($email) ?>" required>
      <input type="password" name="password" placeholder="Password" minlength="6" required>
      <input type="password" name="confirm" placeholder="Confirm password" minlength="6" required>
      <button type="submit">START LIBRARY</button>
    </form>
    <p class="log">Already have an account? <a href="login.php">Log in</a></p>

    <div class="cover-row">
      <img src="books/pb3.jpg" alt="The Maze Runner">
      <img src="books/rb9.jpg" alt="Snowpiercer">
      <img src="books/pb1.jpg" alt="Sunrise on the Reaping">
    </div>
  </div>

  <div class="footer">
    <footer>
      <p>&copy; 2026 The Bookhive. All rights reserved.<br>
      Explore dystopian worlds.</p>
    </footer>
  </div>
</body>
</html>
