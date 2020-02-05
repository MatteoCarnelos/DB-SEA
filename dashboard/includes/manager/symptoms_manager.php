<?php

if (isset($_GET['new']) && !empty($_POST)) {
  $name = $_POST['name'];
  $description = $_POST['description'];
  $query = "
    INSERT INTO \"SINTOMO\"
    VALUES('$name', '$description')
  ";
  $result = pg_query($query);
  if ($result) echo $succ_alert;
}
