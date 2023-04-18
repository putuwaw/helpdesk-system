<?php
ob_start();

session_start();
require "db.php";
require "functions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= "Home"; ?></title>
  <link rel="stylesheet" href="public/styles/bootstrap.min.css">
  <link rel="stylesheet" href="public/styles/login.css">
</head>

<body>
  <main class="form-signin w-100 mx-auto text-center">
    <form method="post">
      <img class="mb-4 w-50 h-50" src="public/images/Logo-Dimata.png" alt="Contoh Logo">
      <h1 class="h3 mb-3 fw-normal">Login</h1>

      <div class="form-floating">
        <input required type="text" name="username" class="form-control" id="floatingInput">
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating">
        <input required type="password" name="password" class="form-control" id="floatingPassword">
        <label for="floatingPassword">Password</label>
      </div>

      <div class="checkbox mb-3 text-start">
        <label>
          <input type="checkbox" name="remember" value="remember-me"> Remember me
        </label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Sign in</button>
      <label class="mt-1" for="">Don't have account? <a href="register.php">Register</a></label>
      <p class="mt-5 mb-3 text-body-secondary">&copy; 2023 Dimata IT Solutions</p>
    </form>
  </main>
  <script src="public/scripts/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
if (isset($_POST['submit'])) {
  $username = strtolower($_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
  if (mysqli_num_rows($query) == 1) {
    $row = mysqli_fetch_assoc($query);
    if (password_verify($password, $row['password'])) {
      if (isset($_POST['remember'])) {
        $_SESSION['remember'] = true;
      }
      $_SESSION['username'] = $row['username'];
      setcookie('username', $row['username'], time() + 60 * 60 * 24 * 30);
      echo "<script>alert('Login success!')</script>";
      if (is_admin($username)) {
        echo "<script>window.location.href='dashboard.php';</script>";
      } else {
        echo "<script>window.location.href='index.php';</script>";
      }
    } else {
      echo "<script>alert('Invalid username or password!')</script>";
    }
  } else {
    echo "<script>alert('Username not found!')</script>";
  }
}
?>