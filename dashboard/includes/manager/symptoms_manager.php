<?php

if (isset($_GET['remove']) && !empty($_POST)) {
  $name = $_POST['name'];
  $query = "
    DELETE FROM \"SINTOMO\" WHERE nome = '$name'
  ";
  $result = pg_query($query);
  if ($result) include 'success_alert.html';
}

if (isset($_GET['new']) && !empty($_POST)) {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $query = "
    INSERT INTO \"SINTOMO\"
    VALUES('$name', '$description')
  ";
  $result = pg_query($query);
  if ($result) include 'success_alert.html';
}
