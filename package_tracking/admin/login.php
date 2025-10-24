<?php
session_start();
include('../includes/db.php');

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $_SESSION['admin'] = $username;
    header("Location: dashboard.php");
  } else {
    $error = "Invalid username or password";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
</head>
<body>
  <h2>Admin Login</h2>
  <form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="login">Login</button>
  </form>
  <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html>
