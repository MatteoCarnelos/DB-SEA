<?php

$err_alert = '
  <div class="alert alert-danger" role="alert">
    Errore durante la connessione con il database. <a href="reports.php" class="alert-link">Riprova</a>
  </div>
';

$dbconn = pg_connect("host=dbstud.dei.unipd.it port=5432 dbname=carnelosma user=carnelosma password=Mat.Uni2019")
  or die($err_alert);
