<?php
$succ_alert = '
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    Medico aggiunto al database!
    <button type="button" class="close" data-dismiss="alert">
      <span>&times;</span>
    </button>
  </div>
';

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
  if ($result) echo $succ_alert;
}
