<?php

$query = '
  CREATE OR REPLACE VIEW "NUMSEGNALAZIONI" AS (
    SELECT farmaco, COUNT(*) AS segnalazioni
    FROM "PAZIENTE"
    GROUP BY farmaco
  )
';
$result = pg_query($query);
if ($result) {
  $query = '
    SELECT *
    FROM "NUMSEGNALAZIONI" AS N JOIN "FARMACO" AS F ON N.farmaco = F.codice
    WHERE N.segnalazioni = ( SELECT MAX(segnalazioni) FROM "NUMSEGNALAZIONI" )
  ';
  $result = pg_query($query);
  if ($result) {
    if (pg_num_rows($result) == 0) $medicine1 = array();
    else $medicine1 = pg_fetch_array($result, 0, PGSQL_ASSOC);
  }
}

$query = '
  SELECT DISTINCT
    S.numero,
    M.nome AS nome_medico, M.cognome,
    P.iniziali, P.età,
    F.nome AS nome_farmaco, F.forma, F.principio_attivo
  FROM "SEGNALAZIONE" AS S 
    JOIN "MEDICO" AS M ON S.medico = M.id
    JOIN "PAZIENTE" AS P ON S.numero = P.segnalazione
    JOIN "FARMACO" AS F ON P.farmaco = F.codice
    JOIN "RIPORTA" AS R ON S.numero = R.segnalazione
    JOIN "CAUSA" AS C ON F.codice = C.farmaco AND R.sintomo = C.sintomo
  WHERE C.conosciuto = false AND R.stato = \'Decesso\'
';
pg_prepare('selsyms', '
  SELECT R.sintomo
  FROM "RIPORTA" AS R 
    JOIN "PAZIENTE" AS P ON R.segnalazione = P.segnalazione
    JOIN "CAUSA" AS C ON P.farmaco = C.farmaco AND R.sintomo = C.sintomo
  WHERE R.segnalazione = $1 AND C.conosciuto = false AND R.stato = \'Decesso\'
');
$result = pg_query($query);
if ($result) {
  if (pg_num_rows($result) == 0) $reports2 = array();
  else {
    $index = 0;
    while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
      $reports2[$index] = $row;
      $symptoms = pg_execute('selsyms', array($row['numero']));
      if ($symptoms) {
        while ($symptom = pg_fetch_array($symptoms, null, PGSQL_ASSOC))
          $reports2[$index]['sintomi'][] = $symptom['sintomo'];
      }
      $index++;
    }
  }
}

if (isset($_GET['search']) && !empty($_POST)) {
  $medicine = $_POST['medicine'];
  pg_prepare('', '
    SELECT R.sintomo, COUNT(*) AS segnalazioni
    FROM "RIPORTA" AS R JOIN "PAZIENTE" AS P ON R.segnalazione = P.segnalazione
    WHERE P.farmaco = $1
    GROUP BY R.sintomo
    ORDER BY segnalazioni DESC
  ');
  $result = pg_execute('', array($medicine));
  if ($result) {
    if (pg_num_rows($result) == 0) $symptoms3 = array();
    else while ($symptom = pg_fetch_array($result, null, PGSQL_ASSOC))
      $symptoms3[] = $symptom;
  }
}

$query = '
  CREATE OR REPLACE VIEW "NUMGRAVIDANZA" AS (
    SELECT farmaco, COUNT(*) AS sintomi
    FROM "PAZIENTE" AS P JOIN "RIPORTA" AS R ON P.segnalazione = R.segnalazione
    WHERE P.gravidanza = true AND R.gravità NOT IN (\'Non definita\', \'Non grave\')
    GROUP BY farmaco
  )
';
$result = pg_query($query);
if ($result) {
  $query = '
    SELECT *
    FROM "NUMGRAVIDANZA" AS N JOIN "FARMACO" AS F ON N.farmaco = F.codice
    WHERE N.sintomi = ( SELECT MAX(sintomi) FROM "NUMGRAVIDANZA" )
  ';
  $result = pg_query($query);
  if ($result) {
    if (pg_num_rows($result) == 0) $medicine4 = array();
    else $medicine4 = pg_fetch_array($result, 0, PGSQL_ASSOC);
  }
}
