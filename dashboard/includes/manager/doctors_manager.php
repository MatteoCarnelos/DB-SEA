<?php

if (isset($_GET['update']) && !empty($_POST)) {
  $id = $_POST['id'];
  $phone = $_POST['phone'];
  $query = "
    UPDATE \"MEDICO\"
    SET telefono = '$phone'
    WHERE id = $id
  ";
  $result = pg_query($query);
  if ($result) include 'success_alert.html';
}

if (isset($_GET['remove']) && !empty($_POST)) {
  $id = $_POST['id'];
  $query = "
    DELETE FROM \"MEDICO\" WHERE id = $id
  ";
  $result = pg_query($query);
  if ($result) include 'success_alert.html';
}

if (isset($_GET['new']) && !empty($_POST)) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $phone = $_POST['phone'];
  if (empty($phone)) $phone = 'null';
  else $phone = "'$phone'";
  $query = "
    INSERT INTO \"MEDICO\"
    VALUES($id, '$name', '$surname', $phone)
  ";
  $result = pg_query($query);
  if ($result) include 'success_alert.html';
}
