<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Matteo Carnelos">
  <title>Pannello di controllo</title>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.it.min.js" integrity="sha256-Q1WYt89PQOqy/rdwt8tZl0oowLiTTRUlAZyqVBDSG2Y=" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="libs/bootstrap-input-spinner.js"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha256-FAOaXTpl90/K8cXmSdsskbQN3nKYulhCpPbcFzGTWKI=" crossorigin="anonymous">
  <link href="includes/css/dashboard.css" rel="stylesheet">
</head>

<body>
  <!-- Navbar -->
  <?php include 'includes/frame/navbar.html' ?>

  <div class="container-fluid">
    <!-- Sidebar -->
    <div class="row">
      <?php
      $active = 1;
      include 'includes/frame/sidebar.php';
      ?>
      <!-- Main area -->
      <main role="main" class="col-10 ml-auto px-4">
        <h2 class="pb-2 pt-3 mb-3 border-bottom">Segnalazioni</h2>

        <?php include 'includes/handler/error_handler.php' ?>
        <?php include 'includes/handler/connection_handler.php' ?>
        <?php include 'includes/manager/reports_manager.php' ?>

        <div class="card">
          <div class="card-header p-0">
            <button class="btn btn-block btn-link text-left d-flex align-items-center text-dark" type="button" data-toggle="collapse" data-target="#newReportCollapse">
              <i class="mr-1" data-feather="plus" style="width: 24px; height: 24px"></i>
              <h5 class="pt-2">Nuova segnalazione</h5>
            </button>
          </div>
          <div id="newReportCollapse" class="collapse <?php if (isset($_GET['show'])) echo 'show' ?>">
            <div class="card-body">
              <form class="needs-validation" method="post" action="reports.php?new" novalidate>

                <div class="form-group row">
                  <label class="col-1 col-form-label" for="dateInput">Data</label>
                  <div class="input-group col-2">
                    <input type="text" class="form-control datepicker" data-date-today-btn="linked" id="dateInput" name="date" value="<?php echo date("d-m-Y") ?>" required>
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary datepicker-toggler" type="button">
                        <i data-feather="calendar"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-1 col-form-label" for="doctorInput">Medico</label>
                  <div class="input-group col-11">
                    <select class="custom-select" id="doctorInput" name="doctor" required>
                      <option selected disabled value="">Seleziona un medico...</option>
                      <?php
                      $query = '
                        SELECT id, nome, cognome
                        FROM "MEDICO"
                      ';
                      $doctors = pg_query($query);
                      while ($doctor = pg_fetch_array($doctors, null, PGSQL_ASSOC))
                        echo "<option value='{$doctor['id']}'>{$doctor['nome']} {$doctor['cognome']}</option>";
                      ?>
                    </select>
                    <div class="input-group-append">
                      <a class="btn btn-outline-success" href="doctors.php?show">
                        <i data-feather="database"></i>
                        Registra nuovo medico
                      </a>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-1 col-form-label" for="notesInput">Note</label>
                  <div class="col-11">
                    <textarea class="form-control" id="notesInput" name="notes" rows="3" placeholder="Eventuali note del medico..."></textarea>
                  </div>
                </div>

                <h5 class="pb-2 border-bottom">Dettagli paziente</h5>

                <div class="mt-3 form-group row">
                  <label class="col-1 col-form-label" for="initialsInput">Iniziali</label>
                  <div class="col-2">
                    <input type="text" class="form-control text-uppercase" id="initialsInput" name="patient[initials]" placeholder="MR" required>
                  </div>
                  <label class="offset-1 col-1 col-form-label" for="cityInput">Città</label>
                  <div class="col-3">
                    <input type="text" class="form-control" id="cityInput" name="patient[city]" placeholder="Padova" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-1 col-form-label" for="ageInput">Età</label>
                  <div class="col-2">
                    <input type="number" value="" max="150" class="form-control" id="ageInput" name="patient[age]" required>
                  </div>
                  <label class="offset-1 col-1 col-form-label" for="genderInput">Sesso</label>
                  <div class="col-3">
                    <select class="custom-select" id="genderInput" name="patient[gender]" required>
                      <option selected disabled value="">Seleziona un sesso...</option>
                      <option value="M">Maschio</option>
                      <option value="F">Femmina</option>
                    </select>
                  </div>
                  <div class="custom-control custom-checkbox my-auto">
                    <input type="checkbox" class="custom-control-input" id="gravidanceCheckbox" name="patient[gravidance]" disabled>
                    <label class="custom-control-label" for="gravidanceCheckbox">Gravidanza</label>
                  </div>
                </div>

                <h5 class="pb-2 border-bottom">Dettagli assunzione</h5>

                <div class="mt-3 form-group row">
                  <label class="col-1 col-form-label" for="medicineInput">Farmaco</label>
                  <div class="input-group col-11">
                    <select class="custom-select" id="medicineInput" name="assumption[medicine]" required>
                      <option selected disabled value="">Seleziona un farmaco...</option>
                      <?php
                      $query = '
                        SELECT codice, nome, forma
                        FROM "FARMACO"
                      ';
                      $medicines = pg_query($query);
                      while ($medicine = pg_fetch_array($medicines, null, PGSQL_ASSOC))
                        echo "<option value='{$medicine['codice']}'>{$medicine['nome']} {$medicine['forma']}</option>";
                      ?>
                    </select>
                    <div class="input-group-append">
                      <a class="btn btn-outline-success" href="medicines.php?show">
                        <i data-feather="database"></i>
                        Registra nuovo farmaco
                      </a>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-1 col-form-label" for="assStartInput">Data inizio</label>
                  <div class="input-group col-2">
                    <input type="text" class="form-control datepicker startpicker" id="assStartInput" name="assumption[start]" value="" required>
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary datepicker-toggler" type="button">
                        <i data-feather="calendar"></i>
                      </button>
                    </div>
                  </div>
                  <label class="col-1 offset-1 col-form-label" for="assEndInput">Data fine</label>
                  <div class="input-group col-2">
                    <input type="text" class="form-control datepicker endpicker" data-date-clear-btn="true" id="assEndInput" name="assumption[end]">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary datepicker-toggler" type="button">
                        <i data-feather="calendar"></i>
                      </button>
                    </div>
                  </div>
                  <small class="text-muted my-auto">Se ancora in corso, lasciare vuoto il campo.</small>
                </div>

                <div class="form-group row">
                  <label class="col-1 col-form-label" for="frequencyInput">Frequenza</label>
                  <div class="col-2">
                    <input type="text" class="form-control" id="frequencyInput" name="assumption[frequency]" placeholder="3/settimana" required>
                  </div>
                  <label class="col-1 offset-1 col-form-label" for="doseInput">Dosaggio</label>
                  <div class="col-2">
                    <input type="text" class="form-control" id="doseInput" name="assumption[dose]" placeholder="1 pastiglia" required>
                  </div>
                </div>

                <div class="d-flex align-items-center border-bottom">
                  <h5 class="mr-auto my-2">Dettagli sintomi</h5>

                  <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" id="removeSymptom" disabled>
                      <i data-feather="minus"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="addSymptom">
                      <i data-feather="plus"></i>
                    </button>
                  </div>
                </div>

                <div class="symptoms-container" id="symptomsContainer">
                  <div class="symptom-group">
                    <div class="mt-3 form-group row">
                      <label class="col-1 col-form-label" for="symptomInput0">Sintomo</label>
                      <div class="input-group col-11">
                        <select class="custom-select symptom-select" id="symptomInput0" name="symptoms[0][name]" required>
                          <option selected disabled value="">Seleziona un sintomo...</option>
                          <?php
                          $query = '
                            SELECT nome
                            FROM "SINTOMO"
                          ';
                          $symptoms = pg_query($query);
                          while ($symptom = pg_fetch_array($symptoms, null, PGSQL_ASSOC))
                            echo "<option value='{$symptom['nome']}'>{$symptom['nome']}</option>";
                          ?>
                        </select>
                        <div class="input-group-append">
                          <a class="btn btn-outline-success" href="symptoms.php?show">
                            <i data-feather="database"></i>
                            Registra nuovo sintomo
                          </a>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-1 col-form-label" for="startSymInput0">Data inizio</label>
                      <div class="input-group col-2">
                        <input type="text" class="form-control datepicker startpicker" id="startSymInput0" name="symptoms[0][start]" value="" required>
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary datepicker-toggler" type="button">
                            <i data-feather="calendar"></i>
                          </button>
                        </div>
                      </div>
                      <label class="col-1 offset-1 col-form-label" for="endSymInput0">Data fine</label>
                      <div class="input-group col-2">
                        <input type="text" class="form-control datepicker endpicker" data-date-clear-btn="true" id="endSymInput0" name="symptoms[0][end]">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary datepicker-toggler" type="button">
                            <i data-feather="calendar"></i>
                          </button>
                        </div>
                      </div>
                      <small class="text-muted my-auto">Se ancora in corso, lasciare vuoto il campo.</small>
                    </div>

                    <div class="form-group row">
                      <label class="col-1 col-form-label" for="statusInput0">Stato</label>
                      <div class="col-3">
                        <select class="custom-select status-select" id="statusInput0" name="symptoms[0][status]" required>
                          <option selected disabled value="">Seleziona uno stato...</option>
                          <?php include 'includes/frame/status_options.php' ?>
                        </select>
                      </div>
                      <label class="col-1 col-form-label" for="severityInput0">Gravità</label>
                      <div class="col-3">
                        <select class="custom-select severity-select" id="severityInput0" name="symptoms[0][severity]" required>
                          <option selected disabled value="">Seleziona una gravità...</option>
                          <?php include 'includes/frame/severity_options.php' ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row justify-content-end border-top pt-3">
                  <div class="col-3">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Invia</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-baseline">
          <h4 class="m-3">Lista segnalazioni registrate</h4>
          <p class="text-dark">Numero tuple: <?php echo pg_fetch_result(pg_query('SELECT COUNT(*) FROM "SEGNALAZIONE"'), 0) ?></p>
        </div>

        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Medico</th>
              <th scope="col">Note</th>
              <th scope="col">Paziente</th>
              <th scope="col">Assunzione</th>
              <th scope="col">Sintomi</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>

            <?php
            $query = '
              SELECT S.numero, S.data, S.note, 
                M.nome, M.cognome, M.telefono, 
                P.iniziali, P.età, P.sesso, P.città, P.gravidanza, P.inizio, P.fine, P.frequenza, P.dosaggio,
                F.nome AS farmaco
              FROM "SEGNALAZIONE" AS S 
                JOIN "MEDICO" AS M ON S.medico = M.id
                JOIN "PAZIENTE" AS P ON S.numero = P.segnalazione
                JOIN "FARMACO" AS F ON P.farmaco = F.codice
              ORDER BY S.numero
            ';
            $reports = pg_query($query);
            pg_prepare('selsyms', '
              SELECT sintomo, insorgenza, fine, stato, gravità
              FROM "RIPORTA"
              WHERE segnalazione = $1
            ');
            $index = 0;
            while ($report = pg_fetch_array($reports, null, PGSQL_ASSOC)) {
              $index++;
            ?>

              <tr>
                <th scope="row">
                  <?php echo $report['numero'] ?> <br>
                  <p class="text-muted font-weight-normal"><?php echo date('d-m-Y', strtotime($report['data'])) ?></p>
                </th>
                <td>
                  <?php echo "{$report['nome']} {$report['cognome']}" ?><br>
                  <p class="text-muted">tel. <?php echo isset($report['telefono']) ? $report['telefono'] : 'non fornito' ?></p>
                </td>
                <td>
                  <button class="btn btn-link text-body pl-0 pt-0" data-toggle="modal" data-target="#notesModal<?php echo $index ?>" type="button">
                    <?php
                    if (empty($report['note'])) echo 'Aggiungi note';
                    else echo 'Visualizza/Modifica note';
                    ?>
                  </button>
                  <div class="modal fade" data-backdrop="static" id="notesModal<?php echo $index ?>">
                    <div class="modal-dialog modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Note segnalazione numero <?php echo $report['numero'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                          </button>
                        </div>
                        <form method="post" action="reports.php?updatenote">
                          <input type="hidden" name="number" value="<?php echo $report['numero'] ?>">
                          <div class="modal-body">
                            <textarea class="form-control" name="notes" rows="7" placeholder="Aggiungi note alla segnalazione..."><?php echo $report['note'] ?></textarea>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                            <button type="submit" class="btn btn-info">Salva modifiche</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  <?php
                  foreach (str_split($report['iniziali']) as $initial)
                    echo "$initial. ";
                  echo '(';
                  echo $report['sesso'] == 'M' ? 'Maschio' : 'Femmina';
                  if ($report['gravidanza'] == 't') echo ', Gravidanza';
                  echo ')<br>';
                  ?>
                  <p class="text-muted"><?php echo "Anni {$report['età']}, {$report['città']}" ?></p>
                </td>
                <td>
                  <?php echo $report['farmaco'] ?>
                  <p class="text-muted">
                    <?php
                    echo date('d-m-Y', strtotime($report['inizio']));
                    echo ' → ';
                    if (!isset($report['fine'])) echo 'in corso';
                    else echo date('d-m-Y', strtotime($report['fine']));
                    echo '<br>';
                    echo "{$report['frequenza']}, {$report['dosaggio']}<br>";
                    ?>
                  </p>
                </td>

                <?php
                $symptoms = pg_execute('selsyms', array($report['numero']));
                $updatable = false;
                if (pg_num_rows($symptoms) == 1) {
                  $symptom = pg_fetch_row($symptoms, 0, PGSQL_ASSOC);
                ?>

                  <td>
                    <?php echo $symptom['sintomo'] ?>
                    <p class="text-muted">
                      <?php
                      echo date('d-m-Y', strtotime($symptom['insorgenza']));
                      echo ' → ';
                      if (!isset($symptom['fine'])) {
                        echo 'in corso';
                        $updatable = true;
                      } else echo date('d-m-Y', strtotime($symptom['fine']));
                      echo '<br>';
                      echo "{$symptom['stato']}, {$symptom['gravità']}<br>";
                      ?>
                    </p>
                  </td>

                <?php } else { ?>

                  <td>
                    <div class="accordion" id="root<?php echo $index ?>">

                      <?php
                      $count = 0;
                      while ($symptom = pg_fetch_array($symptoms, null, PGSQL_ASSOC)) {
                        $count++;
                      ?>

                        <a class="btn-link text-body" href="#collapse<?php echo $index . $count ?>" data-toggle='collapse'>
                          + <?php echo $symptom['sintomo'] ?><br>
                        </a>
                        <div class="collapse text-muted" id="collapse<?php echo $index . $count ?>" data-parent="#root<?php echo $index ?>">
                          <?php
                          echo date('d-m-Y', strtotime($symptom['insorgenza']));
                          echo ' → ';
                          if (!isset($symptom['fine'])) {
                            echo 'in corso';
                            $updatable = true;
                          } else echo date('d-m-Y', strtotime($symptom['fine']));
                          echo '<br>';
                          echo "{$symptom['stato']}, {$symptom['gravità']}<br>";
                          ?>
                        </div>

                      <?php } ?>

                    </div>
                  </td>

                <?php } ?>

                <td class="align-middle">
                  <div class="row justify-content-end mr-1">
                    <button class="btn btn-outline-danger" type="button" data-toggle="modal" data-target="#removeModal<?php echo $index ?>">
                      <i data-feather="trash-2"></i>
                    </button>
                  </div>
                  <?php if ($updatable) { ?>
                    <div class="row justify-content-end mr-1">
                      <button class="mt-2 btn btn-outline-info" type="button" data-toggle="modal" data-target="#updateModal<?php echo $index ?>">
                        <i data-feather="edit"></i>
                      </button>
                    </div>
                  <?php } ?>
                </td>
              </tr>

              <div class="modal fade" id="removeModal<?php echo $index ?>">
                <div class="modal-dialog modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Rimozione segnalazione numero <?php echo $report['numero'] ?></h5>
                      <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                      </button>
                    </div>
                    <form class="needs-validation" method="post" action="reports.php?remove" novalidate>
                      <input type="hidden" name="number" value="<?php echo $report['numero'] ?>">
                      <div class="modal-body">
                        Sei sicuro di voler cancellare la segnalazione?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-danger">Cancella</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <?php if ($updatable) { ?>
                <div class="modal fade" data-backdrop="static" id="updateModal<?php echo $index ?>">
                  <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Aggiornamento sintomi segnalazione <?php echo $report['numero'] ?></h5>
                        <button type="button" class="close" data-dismiss="modal">
                          <span>&times;</span>
                        </button>
                      </div>
                      <form method="post" action="reports.php?update">
                        <input type="hidden" name="number" value="<?php echo $report['numero'] ?>">
                        <div class="modal-body">
                          <div class="symptoms-container">
                            <?php
                            $symptoms = pg_execute('selsyms', array($report['numero']));
                            $count = -1;
                            while ($symptom = pg_fetch_array($symptoms, null, PGSQL_ASSOC)) {
                              if (!isset($symptom['fine'])) {
                                $count++;
                            ?>

                                <h5 class="border-bottom pb-1"><?php echo $symptom['sintomo'] ?></h5>
                                <input type="hidden" name="symptoms[<?php echo $count ?>][name]" value="<?php echo $symptom['sintomo'] ?>">
                                <div class="symptom-group">
                                  <div class="mt-3 form-group row">
                                    <label class="col-3 col-form-label" for="modEndSymInput<?php echo $count ?>">Data fine</label>
                                    <div class="input-group col-7">
                                      <input type="text" class="form-control datepicker endpicker" data-date-clear-btn="true" id="modEndSymInput<?php echo $count ?>" name="symptoms[<?php echo $count ?>][end]" placeholder="In corso" data-date-start-date="<?php echo date('d-m-Y', strtotime($symptom['insorgenza'])) ?>">
                                      <div class="input-group-append">
                                        <button class="btn btn-outline-secondary datepicker-toggler" type="button">
                                          <i data-feather="calendar"></i>
                                        </button>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-3 col-form-label" for="modStatusInput<?php echo $count ?>">Stato</label>
                                    <div class="col-9">
                                      <select class="custom-select status-select" id="modStatusInput<?php echo $count ?>" name="symptoms[<?php echo $count ?>][status]" required>
                                        <option selected disabled value="">Seleziona uno stato...</option>
                                        <?php
                                        $selected = $symptom['stato'];
                                        include 'includes/frame/status_options.php'
                                        ?>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-3 col-form-label" for="modSeverityInput<?php echo $count ?>">Gravità</label>
                                    <div class="col-9">
                                      <select class="custom-select severity-select" id="modSeverityInput<?php echo $count ?>" name="symptoms[<?php echo $count ?>][severity]" required>
                                        <option selected disabled value="">Seleziona una gravità...</option>
                                        <?php
                                        $selected = $symptom['gravità'];
                                        include 'includes/frame/severity_options.php'
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>

                            <?php }
                            } ?>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                          <button type="submit" class="btn btn-info">Salva modifiche</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              <?php } ?>
            <?php } ?>

          </tbody>
        </table>
      </main>
    </div>
  </div>
  <script>
    feather.replace();
    loadDatepickers();
    loadSymChecks();

    $('#dateInput').change(function() {
      var date = $(this).datepicker('getDate');
      $('.startpicker').each(function() {
        $(this).datepicker('setEndDate', date);
        if ($(this).val() != '') {
          var parts = $(this).val().split('-');
          var startDate = new Date(parts[2], parts[1] - 1, parts[0]);
          if (startDate > date) $(this).datepicker('clearDates');
        }
      });
      $('#symptomsContainer').find('.endpicker').each(function() {
        $(this).datepicker('setEndDate', date);
        if ($(this).val() != '') {
          var parts = $(this).val().split('-');
          var endDate = new Date(parts[2], parts[1] - 1, parts[0]);
          if (endDate > date) $(this).datepicker('clearDates');
        }
      });
    });

    function loadDatepickers() {
      $('.datepicker').datepicker({
        language: 'it',
        format: 'dd-mm-yyyy',
        autoclose: 'true'
      });
      $('.datepicker-toggler').click(function() {
        $(this).closest('.input-group').find('input').focus();
      });
      $('.startpicker').change(function() {
        var startDate = new Date($(this).datepicker('getDate'));
        var endPicker = $(this).closest('.form-group').find('.endpicker');
        endPicker.datepicker('setStartDate', startDate);
        var endDate = new Date(endPicker.datepicker('getDate'));
        if (endDate < startDate) endPicker.datepicker('clearDates');
      });
      $('.startpicker').datepicker('setEndDate', $('#dateInput').val());
      $('#symptomsContainer').find('.endpicker').datepicker('setEndDate', $('#dateInput').val());
    }

    function loadSymChecks() {
      $('.symptoms-container').find('.endpicker').change(function() {
        var statusSelect = $(this).closest('.symptom-group').find('.status-select');
        var severitySelect = $(this).closest('.symptom-group').find('.severity-select');
        if ($(this).val() != '') {
          if (statusSelect.val() != 'Decesso' && statusSelect.val() != 'Guarito' && statusSelect.val() != 'Non noto') statusSelect.val('');
          statusSelect.find('option[value="Decesso"]').attr('disabled', false);
          statusSelect.find('option[value="Peggiorato"]').attr('disabled', true);
          statusSelect.find('option[value="Migliorato"]').attr('disabled', true);
          statusSelect.find('option[value="Guarito"]').attr('disabled', false);
        } else {
          statusSelect.find('option').attr('disabled', false);
          statusSelect.find('option[value=""]').attr('disabled', true);
        }
      });
      $('.status-select').change(function() {
        var endPicker = $(this).closest('.symptom-group').find('.endpicker');
        var severitySelect = $(this).closest('.symptom-group').find('.severity-select');
        endPicker.attr('required', ($(this).val() == 'Decesso' || $(this).val() == 'Guarito'));
        if ($(this).val() == 'Decesso') severitySelect.val('Fatale');
        else if (severitySelect.val() == 'Fatale') severitySelect.val('');
      });
      $('.severity-select').change(function() {
        var endPicker = $(this).closest('.symptom-group').find('.endpicker');
        var statusSelect = $(this).closest('.symptom-group').find('.status-select');
        if ($(this).val() == 'Fatale') endPicker.attr('required', true);
        if ($(this).val() == 'Fatale') statusSelect.val('Decesso');
        else if (statusSelect.val() == 'Decesso') statusSelect.val('');
      });
      $('.symptom-select').change(function() {
        var previous = $(this).data('prev');
        var current = $(this).val();
        $(this).closest('.symptoms-container').find('.symptom-select').not(this).each(function() {
          $(this).find('option[value="' + previous + '"]').attr('disabled', false);
          $(this).find('option[value="' + current + '"]').attr('disabled', true);
        });
        $(this).data('prev', current);
      });
    }

    $("input[type='number']").inputSpinner();

    $('#genderInput').change(function() {
      var $gravidanceCheckbox = $('#gravidanceCheckbox');
      if ($(this).children('option:selected').val() == 'M') {
        $gravidanceCheckbox.prop('checked', false);
        $gravidanceCheckbox.prop('disabled', true);
      } else $gravidanceCheckbox.prop('disabled', false);
    });

    var groups = 0;

    function updateAttr(element, attr) {
      element.find('[' + attr + ']').each(function() {
        var forAttr = $(this).attr(attr);
        $(this).attr(attr, forAttr.replace('0', groups));
      });
    }

    function reset(element) {
      element.find('#startSymInput0').val('');
      element.find('#endSymInput0').val('');
      element.find('.status-select').find('option').attr('disabled', false);
      var selected = $('.symptom-group').first().find('option:selected').val();
      element.find('.symptom-select').find('option[value="' + selected + '"]').attr('disabled', true);
    }
    $('#addSymptom').click(function() {
      $('#removeSymptom').attr('disabled', false);
      if (groups == 3) $(this).attr('disabled', true);
      groups++;
      $('#symptomsContainer').append('<hr>');
      var clonedSymptom = $('.symptom-group').first().clone();
      reset(clonedSymptom);
      updateAttr(clonedSymptom, 'for');
      updateAttr(clonedSymptom, 'id');
      updateAttr(clonedSymptom, 'name');
      clonedSymptom.appendTo('#symptomsContainer');
      loadDatepickers();
      loadSymChecks();
    });
    $('#removeSymptom').click(function() {
      $('#addSymptom').attr('disabled', false);
      if (groups == 1) $(this).attr('disabled', true);
      groups--;
      var selected = $('#symptomsContainer').find('.symptom-group').last().find('.symptom-select').find('option:selected').val();
      if (selected != '') $('#symptomsContainer').find('.symptom-group').find('.symptom-select').find('option[value="' + selected + '"]').attr('disabled', false);
      $('#symptomsContainer').children().last().remove();
      $('#symptomsContainer').children().last().remove();
    });

    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>

</html>