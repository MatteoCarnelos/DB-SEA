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
        <?php include 'includes/frame/alerts.php' ?>
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
                      $result = pg_query($query);
                      while ($doctor = pg_fetch_array($result, null, PGSQL_ASSOC))
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
                    <input type="number" value="" max="150" class="form-control" id="ageInput" name="patient[age]" placeholder="50" required>
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
                      $result = pg_query($query);
                      while ($medicine = pg_fetch_array($result, null, PGSQL_ASSOC))
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

                <div id="symptomsGroup">
                  <div id="symptom">
                    <div class="mt-3 form-group row">
                      <label class="col-1 col-form-label" for="symptomInput0">Sintomo</label>
                      <div class="input-group col-11">
                        <select class="custom-select" id="symptomInput0" name="symptoms[0][name]" required>
                          <option selected disabled value="">Seleziona un sintomo...</option>
                          <?php
                          $query = '
                            SELECT nome
                            FROM "SINTOMO"
                          ';
                          $result = pg_query($query);
                          while ($symptom = pg_fetch_array($result, null, PGSQL_ASSOC))
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
                        <select class="custom-select" id="statusInput0" name="symptoms[0][status]" required>
                          <option selected disabled value="">Seleziona uno stato...</option>
                          <option value="Decesso">Decesso</option>
                          <option value="Peggiorato">Peggiorato</option>
                          <option value="Migliorato">Migliorato</option>
                          <option value="Guarito">Guarito</option>
                          <option value="Non noto">Non noto</option>
                        </select>
                      </div>
                      <label class="col-1 col-form-label" for="severityInput0">Gravità</label>
                      <div class="col-3">
                        <select class="custom-select" id="severityInput0" name="symptoms[0][severity]" required>
                          <option selected disabled value="">Seleziona una gravità...</option>
                          <option value="Fatale">Fatale</option>
                          <option value="Pericolo di vita">Pericolo di vita</option>
                          <option value="Anomalie congenite">Anomalie congenite</option>
                          <option value="Disabilità">Disabilità</option>
                          <option value="Ospedalizzazione">Ospedalizzazione</option>
                          <option value="Clinicamente grave">Clinicamente grave</option>
                          <option value="Non grave">Non grave</option>
                          <option value="Non definita">Non definita</option>
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
            ';
            $result1 = pg_query($query);
            while ($report = pg_fetch_array($result1, null, PGSQL_ASSOC)) {
              $report['data'] = date('d-m-Y', strtotime($report['data']));
              if (!isset($report['telefono'])) $report['telefono'] = 'non fornito';
              if (empty($report['note'])) $report['note'] = '-';
              else $report['note'] = "
                <button class='btn btn-link text-body pl-0' data-toggle='modal' data-target='#notesModal{$report['numero']}' type='button'>Visualizza note</button>
                <div class='modal fade' id='notesModal{$report['numero']}'>
                  <div class='modal-dialog modal-dialog-scrollable'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title'>Note segnalazione numero {$report['numero']}</h5>
                        <button type='button' class='close' data-dismiss='modal'>
                          <span>&times;</span>
                        </button>
                      </div>
                      <div class='modal-body'>
                        {$report['note']}
                      </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Chiudi</button>
                      </div>
                    </div>
                  </div>
                </div>
              ";
              $temp = "";
              foreach (str_split($report['iniziali']) as $initial)
                $temp .= "$initial. ";
              $report['iniziali'] = $temp;
              $report['sesso'] = $report['sesso'] == 'M' ? 'Maschio' : 'Femmina';
              if ($report['gravidanza'] == 't') $report['gravidanza'] = ', Gravidanza';
              else $report['gravidanza'] = '';
              $report['inizio'] = date('d-m-Y', strtotime($report['inizio']));
              if (!isset($report['fine'])) $report['fine'] = 'in corso';
              else $report['fine'] = date('d-m-Y', strtotime($report['fine']));
              echo "
                <tr>
                  <th scope='row'>
                    {$report['numero']}<br>
                    <p class='text-muted font-weight-normal'>{$report['data']}</p>
                  </th>
                  <td>
                    {$report['nome']} {$report['cognome']}<br>
                    <p class='text-muted'>tel. {$report['telefono']}</p>
                  </td>
                  <td>
                    {$report['note']}
                  </td>
                  <td>
                    {$report['iniziali']}({$report['sesso']}{$report['gravidanza']})
                    <p class='text-muted'>Anni {$report['età']}, {$report['città']}</p>
                  </td>
                  <td>
                    {$report['farmaco']}
                    <p class='text-muted'>
                      {$report['inizio']} → {$report['fine']}<br>
                      {$report['frequenza']}, {$report['dosaggio']}<br>
                    </p>
                  </td>
              ";

              $query = "
                SELECT sintomo, insorgenza, fine, stato, gravità
                FROM \"RIPORTA\"
                WHERE segnalazione = {$report['numero']}
              ";
              $result = pg_query($query);
              if (pg_num_rows($result) == 1) {
                $symptom = pg_fetch_row($result, 0, PGSQL_ASSOC);
                $symptom['insorgenza'] = date('d-m-Y', strtotime($symptom['insorgenza']));
                if (!isset($symptom['fine'])) $symptom['fine'] = 'in corso';
                else $symptom['fine'] = date('d-m-Y', strtotime($symptom['fine']));
                echo "
                  <td>
                    {$symptom['sintomo']}
                    <p class='text-muted'>
                      {$symptom['insorgenza']} → {$symptom['fine']}<br>
                      {$symptom['stato']}, {$symptom['gravità']}<br>
                    </p>
                  </td>
                ";
              } else {
                echo "
                  <td>
                    <div class='accordion' id='root{$report['numero']}'>
                ";
                $count = 0;
                while ($symptom = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                  $symptom['insorgenza'] = date('d-m-Y', strtotime($symptom['insorgenza']));
                  if (!isset($symptom['fine'])) $symptom['fine'] = 'in corso';
                  else $symptom['fine'] = date('d-m-Y', strtotime($symptom['fine']));
                  $count++;
                  echo "
                    <a class='btn-link text-body' href='#collapse{$report['numero']}$count' data-toggle='collapse'>
                      + {$symptom['sintomo']}<br>
                    </a>
                    <div class='collapse text-muted' id='collapse{$report['numero']}$count' data-parent='#root{$report['numero']}'>
                      {$symptom['insorgenza']} → {$symptom['fine']}<br>
                      {$symptom['stato']}, {$symptom['gravità']}
                    </div>
                  ";
                }
                echo "
                    </div>
                  </td>
                ";
              }
              echo "
                  <td class='align-middle'>
                    <div class='row justify-content-end mr-1'>
                      <button class='mb-2 btn btn-outline-danger' type='button' data-toggle='modal' data-target='#removeModal{$report['numero']}'>
                        <i data-feather='trash-2'></i>
                      </button>
                    </div>
                    <div class='row justify-content-end mr-1'>
                      <button class='btn btn-outline-info' type='button' data-toggle='modal' data-target='#updateModal{$report['numero']}'>
                        <i data-feather='edit'></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <div class='modal fade' id='removeModal{$report['numero']}'>
                  <div class='modal-dialog modal-dialog-scrollable'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title'>Rimozione segnalazione numero {$report['numero']}</h5>
                        <button type='button' class='close' data-dismiss='modal'>
                          <span>&times;</span>
                        </button>
                      </div>
                      <form class='needs-validation' method='post' action='reports.php?remove' novalidate>
                        <input type='hidden' name='number' value='{$report['numero']}'>
                        <div class='modal-body'>
                          Sei sicuro di voler cancellare la segnalazione?
                        </div>
                        <div class='modal-footer'>
                          <button type='button' class='btn btn-secondary' data-dismiss='modal'>Annulla</button>
                          <button type='submit' class='btn btn-danger'>Cancella</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <div class='modal fade' data-backdrop='static' id='updateModal{$report['numero']}'>
                  <div class='modal-dialog modal-dialog-scrollable'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title'>Aggiornamento segnalazione numero {$report['numero']}</h5>
                        <button type='button' class='close' data-dismiss='modal'>
                          <span>&times;</span>
                        </button>
                      </div>
                      <form class='needs-validation' method='post' action='reports.php?update' novalidate>
                        <div class='modal-body'>
                          Coming soon...
                        </div>
                        <div class='modal-footer'>
                          <button type='button' class='btn btn-secondary' data-dismiss='modal'>Annulla</button>
                          <button type='submit' class='btn btn-info'>Salva modifiche</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              ";
            }
            ?>
          </tbody>
        </table>
      </main>
    </div>
  </div>
  <script>
    feather.replace();
    loadDatepickers();

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
    $('#addSymptom').click(function() {
      $('#removeSymptom').attr('disabled', false);
      if (groups == 3) $(this).attr('disabled', true);
      groups++;
      $('#symptomsGroup').append('<hr>');
      var clonedSymptom = $('#symptom').first().clone();
      clonedSymptom.find('#startSymInput0').val('');
      clonedSymptom.find('#endSymInput0').val('');
      updateAttr(clonedSymptom, 'for');
      updateAttr(clonedSymptom, 'id');
      updateAttr(clonedSymptom, 'name');
      clonedSymptom.appendTo('#symptomsGroup');
      loadDatepickers();
    });
    $('#removeSymptom').click(function() {
      $('#addSymptom').attr('disabled', false);
      if (groups == 1) $(this).attr('disabled', true);
      groups--;
      $('#symptomsGroup').children().last().remove();
      $('#symptomsGroup').children().last().remove();
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