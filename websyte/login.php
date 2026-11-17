<?php
require 'config.php';

if (is_logged_in()) {
    header('Location: home.php');
    exit;
}

$error = '';
$login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login    = trim($_POST['username'] ?? '');   
    $password = $_POST['password'] ?? '';

    if ($login === '' || $password === '') {
        $error = 'Please fill in both fields.';
    } else {
        $stmt = mysqli_prepare($conn, 'SELECT id, username, email, password FROM users WHERE username = ? OR email = ?');
        mysqli_stmt_bind_param($stmt, 'ss', $login, $login);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);           
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email']    = $user['email'];
            header('Location: home.php');
            exit;
        }
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Log in - The Bookhive</title>
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
    <h2>YOUR LIBRARY IS WAITING</h2>
    <p>Log in to see your reads.</p>

    <?php if (isset($_GET['registered'])): ?>
      <div class="msg success"><p>Account created! You can log in now.</p></div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
      <div class="msg error"><p><?= e($error) ?></p></div>
    <?php endif; ?>

    <form class="sign auth-form" method="post" action="login.php">
      <input type="text" name="username" placeholder="Username or email" value="<?= e($login) ?>" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">LOG IN</button>
    </form>
    <p class="switch">No account yet? <a href="landd.php">Sign up</a></p>
  </div>

  <div class="footer">
    <footer>
      <p>&copy; 2026 The Bookhive. All rights reserved.<br>
      Explore dystopian worlds.</p>
    </footer>
  </div>
</body>
</html>
