<?php
if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  header("Location: index.php");
  exit;
}

$sql = "SELECT * FROM ticket WHERE id = '$id'";
$ticket = query_to_array($sql);

$sql = "SELECT * FROM chat WHERE id_ticket = '$id'";
$message = query_to_array($sql);

?>

<div>
  <a href="/index.php?p=history">
    <button class="btn btn-primary">Back to History</button>
  </a>
  <section>
    <div class="text-center">
      <h4>Ticket Detail</h4>
      <label for="">ID <?= $ticket[0]["id"]; ?></label>
    </div>
    <div class="mb-3">
      <label class="form-label">Name</span></label>
      <input class="form-control" value="<?= $ticket[0]["name"]; ?>" disabled>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</span></label>
      <input class="form-control" value="<?= $ticket[0]['email']; ?>" disabled>
    </div>
    <div class="mb-3">
      <label class="form-label">Subject</span></label>
      <input class="form-control" value="<?= $ticket[0]['subject']; ?>" disabled>
    </div>
    <div class="mb-3">
      <label class="form-label">Message</span></label>
      <textarea class="form-control" disabled><?= $ticket[0]['message']; ?></textarea>
    </div>
  </section>
  <hr>
  <?php
  $author = "";
  $prevAuthor = "";
  $count = 0;
  foreach ($message as $msg) {
    $count++;
    if ($count == 1) {
      $author = $msg['id_user'];
      $prevAuthor = $msg['id_user'];
    } else {
      $author = $msg['id_user'];
    } ?>
    <div>
      <?php
      if ($author != $prevAuthor) {
      ?>
        <div class="text-end">
          <h6><?= $prevAuthor; ?></h6>
        </div>
        <textarea class="form-control my-2" disabled><?= $msg['message']; ?></textarea>
      <?php
        $prevAuthor = $author;
      } else { ?>
        <textarea class="form-control my-2" disabled><?= $msg['message']; ?></textarea>
      <?php } ?>
      <?php
      if ($count == count($message)) { ?>
        <div class="text-end">
          <h6><?= $author; ?></h6>
        </div>
      <?php } ?>
    </div>
  <?php }
  ?>
  <form action="" method="post">
    <label class="form-label" for="">Reply</label>
    <textarea class="form-control" name="message" id="" rows="5"></textarea>
    <div class="d-flex flex-row-reverse mt-2">
      <button class="btn btn-primary" type="submit" name="submit">Send</button>
    </div>
  </form>
</div>


<?php
if (isset($_POST['submit'])) {
  $id_ticket = $_GET['id'];
  $id_user = $_SESSION['username'];
  $message = $_POST['message'];
  $id_chat = uniqid();

  $sql = "INSERT INTO chat VALUES ('$id_ticket', '$id_chat', '$id_user', '$message')";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Success!');</script>";
    header("Refresh:0");
  } else {
    echo mysqli_error($conn);
  }
}
?>