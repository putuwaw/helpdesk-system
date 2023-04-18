<?php
if (isset($_SESSION["username"])) {
  $username = $_SESSION["username"];
} else if (isset($_COOKIE["username"])) {
  $username = $_COOKIE["username"];
}

$username = trim($username);
$sql = "SELECT * FROM ticket WHERE id_user = '$username'";

$ticket = query_to_array($sql);
$fold = 5;
$total_ticket = count($ticket);
$total_page = ceil($total_ticket / $fold);
$active_page = isset($_GET["s"]) ? $_GET["s"] : 1;
$start = $fold * ($active_page - 1);
$sql = "SELECT * FROM ticket WHERE id_user = '$username' ORDER BY created DESC LIMIT $start, $fold";
$ticket = query_to_array($sql);


$sql = "SELECT id FROM ticket WHERE status = 'Pending' ORDER BY created ASC";
$queue_ticket = query_to_array($sql);

$sql = "SELECT id FROM ticket ORDER BY created ASC";
$all_ticket = query_to_array($sql);

$counter = 0;
foreach ($all_ticket as $t) {
  if ($t["id"] == $queue_ticket[0]["id"]) {
    break;
  } else {
    $counter++;
  }
}

?>
<h3 class="text-center mb-3">Ticket History</h3>
<h6 class="lead text-center mb-3">Current Queue: <?= $counter + 1; ?></h6>
<table class="table table-hover table-bordered table-striped text-center">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Queue</th>
      <th scope="col">Ticket ID</th>
      <th scope="col">Submitted</th>
      <th scope="col">Status</th>
      <th scope="col">Information</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if (count($ticket) > 0) {
      $num = $start;
      foreach ($ticket as $t) {
        $num += 1; ?>
        <tr>
          <th class="text-center" scope="row"><?= $num; ?></th>
          <td class="text-center">
            <?php
            if ($t["status"] == "Pending") {
              echo $counter + (int)get_queue($t['id']);
            } else {
              echo "-";
            }
            ?>
            <?php if (get_queue($t['id']) != "-") {
              echo "(" . 6 * ((int)get_queue($t['id']) - 1)  . " min)";
            }
            ?>
          </td>
          <td class="text-center"><?= $t["id"]; ?></td>
          <td class="text-center"><?= $t["created"]; ?></td>
          <td class="text-center">
            <button class="btn 
              <?php
              if ($t["status"] == "Pending") {
                echo "btn-warning";
              } else {
                echo "btn-success";
              } ?>">
              <?= $t["status"]; ?>
            </button>
          </td>
          <td>
            <a href="/index.php?p=detail&id=<?= $t['id']; ?>">
              <button class="btn btn-primary">Detail</button>
            </a>
          </td>
        </tr>
    <?php }
    }
    ?>
  </tbody>
</table>
<?php
if (count($ticket) == 0) {
  echo "No data";
}
?>
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">
    <li class="page-item">
      <a class="page-link 
        <?php
        if ($active_page == 1) {
          echo "disabled";
        }
        ?>" href="/index.php?p=history&s=<?= $active_page - 1; ?>">Previous</a>
    </li>
    <?php
    for ($i = 1; $i <= $total_page; $i++) {
      if ($i == $active_page) { ?>
        <li class="page-item"><a class="page-link active" href="/index.php?p=history&s=<?= $i; ?>"><?= $i; ?></a></li>
      <?php } else { ?>
        <li class="page-item"><a class="page-link" href="/index.php?p=history&s=<?= $i; ?>"><?= $i; ?></a></li>
    <?php }
    } ?>
    <a class="page-link 
      <?php
      if ($active_page == $total_page || count($ticket) == 0) {
        echo "disabled";
      }
      ?>" href="/index.php?p=history&s=<?= $active_page + 1; ?>">Next</a>
    </li>
  </ul>
</nav>