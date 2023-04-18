<?php
require "db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="public/styles/bootstrap.min.css">
  <link rel="stylesheet" href="public/styles/register.css">
</head>

<body>
  <main class="form-signin w-100 mx-auto text-center">
    <form action="" method="post">
      <img class="mb-4 w-50 h-50" src="public/images/Logo-Dimata.png" alt="Contoh Logo">
      <h1 class="h3 mb-3 fw-normal">Register</h1>
      <div class="form-floating">
        <input required name="username" type="text" class="form-control" id="floatingInput">
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating ">
        <input required name="password" type="password" class="form-control mid-password" id="floatingPassword">
        <label for="floatingPassword">Password</label>
      </div>
      <div class="form-floating">
        <input required name="repeatPass" type="password" class="form-control last-password" id="floatingRepeatPassword">
        <label for="floatingRepeatPassword">Repeat Password</label>
      </div>
      <div class="checkbox mb-3 text-start">
        <label>
          <input required type="checkbox" value="remember-me"> I have read and agree to the <a href="#">terms and condition</a>
        </label>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit" name="submit">Sign up</button>
      <label class="mt-1" for="">Already have account? <a href="login.php">Login</a></label>
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
  $repeatPass = mysqli_real_escape_string($conn, $_POST['repeatPass']);
  $query = mysqli_query(
    $conn,
    "SELECT username FROM user WHERE username = '$username'"
  );
  if ($password != $repeatPass) {
    echo "<script>alert('Password not match!')</script>";
  } else if (mysqli_num_rows($query) > 0) {
    echo "<script>alert('Username already exist!')</script>";
  } else {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = mysqli_query(
      $conn,
      "INSERT INTO user VALUES('$username', '$password', '0')"
    );
    if (mysqli_affected_rows($conn) == 1) {
      echo "<script>alert('Register success!');</script>";
      echo "<script>window.location.href='login.php';</script>";
    } else {
      echo "<script>alert('Register failed!');</script>";
    }
  }
}

?>