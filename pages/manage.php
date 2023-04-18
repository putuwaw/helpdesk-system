<?php
if (isset($_GET['username'])) {
  $username = $_GET['username'];
} else {
  header("Location: dashboard.php?p=user");
  exit;
}


$sql = "SELECT * FROM user WHERE username = '$username'";
$user = query_to_array($sql);
$role = ["User", "Admin"];
$value = ["User" => "0", "Admin" => "1"];
?>
<a href="/dashboard.php?p=user">
  <button class="btn btn-primary">Back to User</button>
</a>

<form action="" method="post">
  <h3 class="text-center">User Management</h3>
  <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input disabled id="username" type="text" name="username" class="form-control" value="<?= $user[0]['username']; ?>">
  </div>
  <div class="mb-3">
    <label for="role" class="form-label">Role</label>
    <select id="role" name="role" class="form-select">
      <?php
      $counter = 0;
      foreach ($role as $r) {
        if ($value[$r] == $user[0]['role']) { ?>
          <option value="<?= $value[$r]; ?>" selected><?= $r; ?></option>
        <?php } else { ?>
          <option value="<?= $value[$r]; ?>"><?= $r; ?></option>
      <?php }
      } ?>
    </select>
  </div>
  <button class="btn btn-primary" name="submit" type="submit" value="submit">Update</button>
</form>


<?php
if (isset($_POST['submit'])) {
  $role = $_POST['role'];

  $sql = "UPDATE user SET username = '$username', role = '$role' WHERE username = '$username'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('User updated!');</script>";
  } else {
    echo "<script>alert('User not updated!');</script>";
  }
}

?>