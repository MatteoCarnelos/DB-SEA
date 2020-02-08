<?php

if (isset($_GET['newagent']) && !empty($_POST)) {
  $name = $_POST['name'];
  pg_prepare('', '
    INSERT INTO "PRINCIPIO_ATTIVO"
    VALUES($1)
  ');
  $result = pg_execute('', array($name));
  if ($result) include 'success_alert.html';
}

if (isset($_GET['removeagent']) && !empty($_POST)) {
  $name = $_POST['name'];
  pg_prepare('', '
    DELETE FROM "PRINCIPIO_ATTIVO" WHERE nome = $1
  ');
  $result = pg_execute('', array($name));
  if ($result) include 'success_alert.html';
}
