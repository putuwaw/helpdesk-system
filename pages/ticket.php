<form method="post">
  <div class="text-center">
    <h4>New Ticket Form</h4>
    <label>Field with <span class="text-danger">*</span> mark are required.</label>
  </div>
  <div class="mb-3">
    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
    <input name="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" required>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" required>
  </div>
  <label for="" class="form-label">Subject <span class="text-danger">*</span></label>
  <select name="subject" class="form-select mb-3" aria-label="Default select example" required>
    <option selected disabled value="">-- Select your subject --</option>
    <option value="AISO">AISO</option>
    <option value="Hairisma">Hairisma</option>
    <option value="SLIK">SLIK</option>
    <option value="Hanoman">Hanoman</option>
    <option value="Prochain">ProChain</option>
    <option value="Sedana">Sedana</option>
    <option value="Others">Others</option>
  </select>
  <div class="mb-3">
    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
    <textarea name="message" class="form-control" id="message" rows="5"></textarea>
  </div>
  <label class="form-label" for="inputGroupFile01">Attachment</label>
  <div class="input-group mb-3">
    <input type="file" name="attachment" class="form-control" id="inputGroupFile01">
  </div>
  <input type="text" name="username" class="d-none" value="
  <?php
  if (isset($_SESSION["username"])) {
    echo $_SESSION["username"];
  } else if (isset($_COOKIE["username"])) {
    echo $_COOKIE["username"];
  }
  ?>">
  <button type="submit" value="submit" name="submit" class="btn btn-primary">Submit</button>
</form>

<?php
if (isset($_POST["submit"])) {
  $result = add_ticket($_POST);
  if ($result > 0) {
    echo "<script>alert('Ticket successfully created!');</script>";
    echo "<script>window.location.href='index.php?p=history';</script>";
  } else {
    echo "<script>alert('Failed to create ticket!');</script>";
  }
}
?>