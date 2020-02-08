<?php

function delete_medicine($code)
{
  pg_prepare('', '
    DELETE FROM "FARMACO" WHERE codice = $1
  ');
  return pg_execute('', array($code));
}

if (isset($_GET['remove']) && !empty($_POST)) {
  $code = $_POST['code'];
  $result = delete_medicine($code);
  if ($result) include 'success_alert.html';
}

if (isset($_GET['new']) && !empty($_POST)) {
  $code = $_POST['code'];
  $name = $_POST['name'];
  $form = $_POST['form'];
  $administration = $_POST['administration'];
  $agent = $_POST['agent'];
  $symptoms = $_POST['symptoms'];

  pg_prepare('', '
    INSERT INTO "FARMACO"
    VALUES($1, $2, $3, $4, $5)
  ');
  $result = pg_execute('', array($code, $name, $form, $administration, $agent));
  if ($result) {
    foreach ($symptoms as $symptom) {
      pg_prepare('', '
        INSERT INTO "CAUSA"
        VALUES($1, $2, true)
      ');
      $result = pg_execute('', array($code, $symptom));
      if (!$result) {
        delete_medicine($code);
        break;
      }
    }
    if ($result) include 'success_alert.html';
  }
}
