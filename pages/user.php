<?php
$sql = "SELECT * FROM user";
$users = query_to_array($sql);
$fold = 5;
$total_users = count($users);
$total_page = ceil($total_users / $fold);
$active_page = isset($_GET["s"]) ? $_GET["s"] : 1;
$start = $fold * ($active_page - 1);
$sql = "SELECT * FROM user  LIMIT $start, $fold";
$users = query_to_array($sql);
$counter = $start;
?>


<div>
  <h3 class="text-center mb-3">User Management</h3>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Role</th>
        <th scope="col">Option</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $user) {
        $counter++; ?>
        <tr>
          <th scope="row"><?= $counter; ?></th>
          <td><?= $user['username']; ?></td>
          <td>
            <?php if ($user['role'] == '1') {
              echo "Admin";
            } else {
              echo "User";
            } ?></td>
          <td>
            <a href="?p=manage&username=<?= $user['username']; ?>" class="text-decoration-none">
              <button class="btn btn-primary">Manage</button>
            </a>
            <form action="" method="post" class="d-inline" onsubmit="return confirm('Are you sure to delete?');">
              <input type="text" name="username" class="d-none" value="<?= $user['username']; ?>">
              <button class="btn btn-danger" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      <?php
      } ?>
    </tbody>
  </table>
  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-end">
      <li class="page-item
      <?php
      if ($active_page == 1 || $total_page == 0) {
        echo "disabled";
      }
      ?>
      "><a class="page-link" href="
      <?php
      echo "?p=user&s=" . ($active_page - 1);
      ?>">Previous</a></li>
      <?php
      for ($i = 1; $i <= $total_page; $i++) { ?>
        <li class="page-item"><a class="page-link 
        <?php
        if ($i == $active_page) {
          echo "active";
        }
        ?>" href="?p=user&s=<?= $i; ?>"><?= $i; ?></a></li>
      <?php }
      ?>
      <li class="page-item
      <?php
      if ($active_page == $total_page || $total_page == 0) {
        echo "disabled";
      }
      ?>
      "><a class="page-link" href="
      <?php
      echo "?p=user&s=" . ($active_page + 1);
      ?>">Next</a></li>
    </ul>
  </nav>
</div>


<?php
if (isset($_POST['username'])) {
  $username = $_POST['username'];
  $sql = "DELETE FROM user WHERE username = '$username'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('User deleted successfully!');window.location='?p=user';</script>";
  } else {
    echo "<script>alert('Failed to delete user!');window.location='?p=user';</script>";
  }
}

?>