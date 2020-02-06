<?php

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
  if ($result) echo file_get_contents('success_alert.html');
}
