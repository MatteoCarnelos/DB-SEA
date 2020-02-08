<?php

function delete_report($number)
{
  pg_prepare('', '
    DELETE FROM "SEGNALAZIONE" WHERE numero = $1
  ');
  return pg_execute('', array($number));
}

if (isset($_GET['updatenote']) && !empty($_POST)) {
  $number = $_POST['number'];
  $notes = $_POST['notes'];
  pg_prepare('', '
    UPDATE "SEGNALAZIONE"
    SET note = $1
    WHERE numero = $2
  ');
  $result = pg_execute('', array($notes, $number));
  if ($result) include 'success_alert.html';
}

if (isset($_GET['remove']) && !empty($_POST)) {
  $number = $_POST['number'];
  $result = delete_report($number);
  if ($result) include 'success_alert.html';
}

if (isset($_GET['new']) && !empty($_POST)) {
  $date = date('m-d-Y', strtotime($_POST['date']));
  $doctor = $_POST['doctor'];
  $notes = $_POST['notes'];
  pg_prepare('', '
    INSERT INTO "SEGNALAZIONE"(data, note, medico)
    VALUES($1, $2, $3)
    RETURNING numero
  ');
  $result = pg_execute('', array($date, $notes, $doctor));
  if ($result) {
    $number = pg_fetch_result($result, 0, 0);
    $patient = $_POST['patient'];
    $assumption = $_POST['assumption'];
    pg_prepare('', '
      INSERT INTO "PAZIENTE"
      VALUES($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)
    ');
    $result = pg_execute('', array(
      $number,
      strtoupper($patient['initials']),
      $patient['age'],
      $patient['gender'],
      $patient['city'],
      $patient['gender'] == 'M' ? null : (isset($patient['gravidance']) ? 'true' : 'false'),
      $assumption['medicine'],
      date('Y-m-d', strtotime($assumption['start'])),
      empty($assumption['end']) ? null : date('Y-m-d', strtotime($assumption['end'])),
      $assumption['frequency'],
      $assumption['dose']
    ));
    if (!$result) delete_report($number);
    else {
      $symptoms = $_POST['symptoms'];
      pg_prepare('inssym1', '
        INSERT INTO "RIPORTA"
        VALUES($1, $2, $3, $4, $5, $6)
      ');
      pg_prepare('inssym2', '
        INSERT INTO "CAUSA"
        VALUES($1, $2, false)
        ON CONFLICT DO NOTHING
      ');
      foreach ($symptoms as $symptom) {
        $result = pg_execute('inssym1', array(
          $number,
          $symptom['name'],
          date('Y-m-d', strtotime($symptom['start'])),
          empty($symptom['end']) ? null : date('Y-m-d', strtotime($symptom['end'])),
          $symptom['status'],
          $symptom['severity']
        ));
        if (!$result) {
          delete_report($number);
          break;
        }
        $result = pg_execute('inssym2', array(
          $assumption['medicine'],
          $symptom['name']
        ));
        if (!$result) {
          delete_report($number);
          break;
        }
      }
      if ($result) include 'success_alert.html';
    }
  }
}
