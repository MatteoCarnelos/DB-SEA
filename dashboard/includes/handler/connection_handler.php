<?php

date_default_timezone_set('Europe/Rome');

$err_alert = '
  <div class="alert alert-danger" role="alert">
    Errore durante la connessione con il database. <a href="reports.php" class="alert-link">Riprova</a>
  </div>
';

$dbconn = pg_connect("dbname=carnelosma user=webdb password=webdb")
  or die($err_alert);
