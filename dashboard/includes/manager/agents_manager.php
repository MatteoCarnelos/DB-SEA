<?php

if (isset($_GET['newagent']) && !empty($_POST)) {
  $name = $_POST['name'];
  $query = "
    INSERT INTO \"PRINCIPIO_ATTIVO\"
    VALUES('$name')
  ";
  $result = pg_query($query);
  if ($result) echo $succ_alert;
}

if (isset($_GET['removeagent']) && !empty($_POST)) {
  $name = $_POST['name'];
  $query = "
    DELETE FROM \"PRINCIPIO_ATTIVO\" WHERE nome = '$name'
  ";
  $result = pg_query($query);
  if ($result) echo $succ_alert;
}
