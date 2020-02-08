<?php

if (isset($_GET['update']) && !empty($_POST)) {
  $id = $_POST['id'];
  $phone = $_POST['phone'];
  pg_prepare('', '
    UPDATE "MEDICO"
    SET telefono = $1
    WHERE id = $2
  ');
  $result = pg_execute('', array($phone, $id));
  if ($result) include 'success_alert.html';
}

if (isset($_GET['remove']) && !empty($_POST)) {
  $id = $_POST['id'];
  pg_prepare('', '
    DELETE FROM "MEDICO" WHERE id = $1
  ');
  $result = pg_execute('', array($id));
  if ($result) include 'success_alert.html';
}

if (isset($_GET['new']) && !empty($_POST)) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $phone = $_POST['phone'];
  pg_prepare('', '
    INSERT INTO "MEDICO"
    VALUES($1, $2, $3, $4)
  ');
  $result = pg_execute('', array(
    $id,
    $name,
    $surname,
    empty($phone) ? null : $phone
  ));
  if ($result) include 'success_alert.html';
}
