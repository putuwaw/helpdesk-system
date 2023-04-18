<?php
if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  header("Location: admin.php");
  exit;
}

$sql = "SELECT * FROM ticket WHERE id = '$id'";
$ticket = query_to_array($sql);

$sql = "SELECT * FROM assignee WHERE id_ticket = '$id' ORDER BY level ASC";
$assignee = query_to_array($sql);

// var_dump($assignee[1]['id_user']);
?>

<a href="dashboard.php">
  <button class="btn btn-primary">Back to Dashboard</button>
</a>

<form method="post">
  <h4 class="text-center">Change Assignee</h4>
  <div class="mb-3">
    <label for="" class="form-label">Username</label>
    <input type="text" class="form-control" disabled value="<?= $ticket[0]["id_user"]; ?>">
  </div>
  <div class="mb-3">
    <label for="" class="form-label">Message</label>
    <textarea name="" class="form-control" cols="30" rows="5" disabled><?= $ticket[0]["message"]; ?></textarea>
  </div>
  <hr>

  <?php
  for ($i = 0; $i < 3; $i++) { ?>
    <div class="mb-3">
      <label class="mb-2" for="">Assignee <?= $i + 1; ?></label>
      <select class="form-select" name="assignee<?= $i + 1; ?>">
        <?php
        $admin_list = get_all_admin();
        if (!isset($assignee[$i])) {
          echo "<option selected>None</option>";
          foreach ($admin_list as $admin) { ?>
            <option value="<?= $admin["username"]; ?>"><?= $admin["username"]; ?></option>
            <?php }
        } else {
          foreach ($admin_list as $admin) {
            if ($admin["username"] == $assignee[$i]["id_user"]) { ?>
              <option value="<?= $admin["username"]; ?>" selected><?= $admin["username"]; ?></option>
            <?php } else { ?>
              <option value="<?= $admin["username"]; ?>"><?= $admin["username"]; ?></option>
            <?php } ?>
        <?php }
        } ?>
      </select>
    </div>
  <?php }
  ?>

  <button type="submit" name="submit" value="submit" class="btn btn-primary">Update</button>
</form>



<?php
if (isset($_POST['submit'])) {
  $sql = "DELETE FROM assignee WHERE id_ticket = '$id'";
  $isSuccess = true;
  $result = mysqli_query($conn, $sql);
  if (!$result) {
    $isSuccess = false;
  }
  for ($i = 0; $i < 3; $i++) {
    if (($_POST['assignee' . ($i + 1)]) != "None") {
      $assignee = $_POST['assignee' . ($i + 1)];
      $level = $i + 1;
      $sql = "INSERT INTO assignee (id_ticket, id_user, level) VALUES ('$id', '$assignee', '$level')";
      $result = mysqli_query($conn, $sql);
      if (!$result) {
        $isSuccess = false;
      }
    }
  }

  if ($isSuccess) {
    echo "<script>alert('Assignee updated');</script>";
    header("Location: dashboard.php");
    exit;
  } else {
    echo "<script>alert('Failed to update assignee');</script>";
  }
}



?>