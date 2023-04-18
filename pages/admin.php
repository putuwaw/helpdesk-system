<?php

$sql = "SELECT * FROM ticket WHERE status = 'Pending'";
$ticket = query_to_array($sql);
$fold = 6;
$total_ticket = count($ticket);
$total_page = ceil($total_ticket / $fold);
$active_page = isset($_GET["s"]) ? $_GET["s"] : 1;
$start = $fold * ($active_page - 1);
$sql = "SELECT * FROM ticket WHERE status = 'Pending' LIMIT $start, $fold";
$ticket = query_to_array($sql);
$counter = $start;


$sql = "SELECT COUNT(id) AS sum FROM ticket WHERE status = 'Pending'";
$pending_ticket = query_to_array($sql);
$sql = "SELECT COUNT(id) AS sum FROM ticket WHERE status != 'Pending'";
$success_ticket = query_to_array($sql);
$sql = "SELECT COUNT(username) AS sum FROM user";
$total_users = query_to_array($sql);
?>


<section>
  <div class="container overflow-hidden text-center text-white">
    <div class="row">
      <div class="col mx-2 rounded bg-warning">
        <div class="p-3 d-flex justify-content-between align-items-center">
          <i class="fa-solid fa-triangle-exclamation"></i>
          <div>
            <p>Pending Ticket</p>
            <h1><?= $pending_ticket[0]['sum']; ?></h1>
          </div>
        </div>
      </div>
      <div class="col mx-2 rounded bg-success">
        <div class="p-3 d-flex justify-content-between align-items-center">
          <i class="fa-solid fa-circle-check"></i>
          <div>
            <p>Answered Ticket</p>
            <h1><?= $success_ticket[0]['sum']; ?></h1>
          </div>
        </div>
      </div>
      <div class="col mx-2 rounded bg-primary">
        <div class="p-3 d-flex justify-content-between align-items-center">
          <i class="fa-solid fa-user"></i>
          <div>
            <p>Total User</p>
            <h1><?= $total_users[0]['sum']; ?></h1>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!-- table -->
  <table class="table table-striped table-bordered">
    <h3 class="mt-4">Recent Tickets</h3>
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Username</th>
        <th scope="col">Subject</th>
        <th scope="col">Assigned</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($ticket as $t) {
        $counter++;
      ?>
        <tr>
          <th scope="row"><?= $counter; ?></th>
          <td><?= $t['id_user']; ?></td>
          <td><?= $t['subject']; ?></td>
          <td>
            <?= get_assignee($t['id']); ?>
          </td>
          <td>
            <button class="btn 
            <?php if ($t['status'] == "Pending") {
              echo "btn-warning";
            } else {
              echo "btn-success";
            } ?>"><?= $t['status']; ?></button>
          </td>
          <td>
            <a class="text-decoration-none" href="?p=detailadmin&id=<?= $t['id']; ?>">
              <button class="btn btn-primary"><i class="fa-solid fa-comment-dots"></i>
              </button>
            </a>
            <a class="text-decoration-none" href="">
              <form class="d-inline" action="" method="post" onsubmit="return confirm('Are you sure to closed this ticket?');">
                <input type="text" name="id" class="d-none" value="<?= $t['id']; ?>">
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-square-check"></i></button>
              </form>
            </a>
            <a class="text-decoration-none" href="?p=assign&id=<?= $t['id']; ?>">
              <button class="btn btn-warning text-white"><i class="fa-solid fa-rotate"></i></button>
            </a>
          </td>
        </tr>
      <?php }
      ?>
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
      echo "?s=" . ($active_page - 1);
      ?>">Previous</a></li>
      <?php

      for ($i = 1; $i <= $total_page; $i++) { ?>
        <li class="page-item 
        <?php
        if ($i == $active_page) {
          echo "active";
        }
        ?>"><a class="page-link" href="<?php echo "?s=" . $i; ?>"><?= $i; ?></a></li>
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
      echo "?s=" . ($active_page + 1);
      ?>">Next</a></li>
    </ul>
  </nav>
</section>


<?php
if (isset($_POST['id'])) {
  $id = $_POST['id'];
  $sql = "UPDATE ticket SET status = 'Closed' WHERE id = '$id'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Ticket has been closed!');</script>";
    header("Refresh:0");
  } else {
    echo "<script>alert('Failed to closed ticket!');</script>";
    header("Refresh:0");
  }
}


?>