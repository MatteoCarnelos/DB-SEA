<?php

if (isset($_GET['new']) && !empty($_POST)) {
  $code = $_POST['code'];
  $name = $_POST['name'];
  $form = $_POST['form'];
  $administration = $_POST['administration'];
  $agent = $_POST['agent'];
  $symptoms = $_POST['symptoms'];

  $query = "
    INSERT INTO \"FARMACO\"
    VALUES($code, '$name', '$form', '$administration', '$agent')
  ";
  $result = pg_query($query);
  if ($result) {
    foreach ($symptoms as $symptom) {
      $query = "
        INSERT INTO \"CAUSA\"
        VALUES($code, '$symptom', true)
      ";
      $result = pg_query($query);
      if (!$result) {
        pg_query("DELETE FROM \"FARMACO\" WHERE codice = $code");
        break;
      }
    }
    if ($result) echo $succ_alert;
  }
}
