<?php

require "db.php";

function query_to_array($arg)
{
  global $conn;
  $query = mysqli_query($conn, $arg);
  if (!$query) {
    echo mysqli_errno($conn);
  }
  $arrQuery = [];
  while ($row = mysqli_fetch_assoc($query)) {
    $arrQuery[] = $row;
  }
  return $arrQuery;
}


function add_ticket($data)
{
  global $conn;
  $id = uniqid();
  $idUser = trim($data["username"]);
  $name = $data["name"];
  $email = $data["email"];
  $subject = $data["subject"];
  $message = $data["message"];
  $attachment = "";
  $status = "Pending";
  $rawDate = new DateTime('now');
  $datetime =  $rawDate->format('Y-m-d H:i:s');
  $query = mysqli_query(
    $conn,
    "INSERT INTO ticket VALUES (
      '$id', 
      '$idUser', 
      '$name', 
      '$email', 
      '$subject', 
      '$message', 
      '$attachment', 
      '$status', 
      '$datetime'
      )"
  );
  return mysqli_affected_rows($conn);
}


function get_queue($id)
{
  $sql = "SELECT id FROM ticket WHERE status = 'Pending' ORDER BY created ASC";
  $query_ticket = query_to_array($sql);

  // var_dump($query_ticket);

  $isFound = false;
  $counter = 0;
  foreach ($query_ticket as $t) {
    $counter++;
    if ($t["id"] == $id) {
      $isFound = true;
      break;
    }
  }
  if ($isFound == true) {
    return $counter;
  } else {
    return "-";
  }
}

function get_queue_time($id)
{
  $sql = "SELECT id FROM ticket WHERE status = 'Pending' ORDER BY created ASC";
  $query_ticket = query_to_array($sql);
  $isFound = false;
  $counter = 0;
  foreach ($query_ticket as $t) {
    $counter++;
    if ($t["id"] == $id) {
      $isFound = true;
      break;
    }
  }
  if ($isFound == true) {
    return $counter;
  } else {
    return "-";
  }
}


function is_admin($id)
{
  $sql = "SELECT * FROM user WHERE username = '$id'";
  $query_user = query_to_array($sql);
  if ($query_user[0]["role"] == "1") {
    return true;
  }
  return false;
}

function get_all_admin()
{
  $sql = "SELECT * FROM user WHERE role = '1'";
  $query_user = query_to_array($sql);
  return $query_user;
}

function get_assignee($id)
{
  $sql = "SELECT * FROM assignee WHERE id_ticket = '$id' ORDER BY level ASC";
  $query_assignee = query_to_array($sql);
  $result = "";
  for ($i = 0; $i < count($query_assignee); $i++) {
    $result .= $query_assignee[$i]["id_user"];
    if ($i < count($query_assignee) - 1) {
      $result .= ", ";
    }
  }

  if ($result == "") {
    return "-";
  }
  return $result;
}


function close_ticket($id)
{
  global $conn;
  $sql = "UPDATE ticket SET status = 'Closed' WHERE id = '$id'";
  $query = mysqli_query($conn, $sql);
}
