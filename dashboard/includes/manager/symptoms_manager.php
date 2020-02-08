<?php

if (isset($_GET['remove']) && !empty($_POST)) {
  $name = $_POST['name'];
  pg_prepare('', '
    DELETE FROM "SINTOMO" WHERE nome = $1
  ');
  $result = pg_execute('', array($name));
  if ($result) include 'success_alert.html';
}

if (isset($_GET['new']) && !empty($_POST)) {
  $name = $_POST['name'];
  $description = $_POST['description'];
  pg_prepare('', '
    INSERT INTO "SINTOMO"
    VALUES($1, $2)
  ');
  $result = pg_execute('', array($name, $description));
  if ($result) include 'success_alert.html';
}
