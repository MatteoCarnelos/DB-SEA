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
  <script src="https://unpkg.com/feather-icons"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="includes/css/dashboard.css" rel="stylesheet">
</head>

<body>
  <!-- Navbar -->
  <?php include 'includes/frame/navbar.html' ?>

  <div class="container-fluid">
    <!-- Sidebar -->
    <div class="row">
      <?php
      $active = 0;
      include 'includes/frame/sidebar.php';
      ?>

      <!-- Main area -->
      <main role="main" class="col-10 ml-auto px-4">
        <h2 class="pb-2 pt-3 mb-3 border-bottom">Dashboard</h2>

        <?php include 'includes/handler/error_handler.php' ?>
        <?php include 'includes/handler/connection_handler.php' ?>
        <?php include 'includes/manager/index_manager.php' ?>

        <div class="row">
          <div class="col-4 pr-0">
            <div class="card text-dark bg-warning mb-3">
              <h5 class="card-header">Farmaco più segnalato</h5>
              <div class="card-body">
                <h4 class="card-title">
                  <?php
                  if (!isset($medicine1)) echo 'Query non eseguita';
                  else if (empty($medicine1)) echo 'Nessun farmaco segnalato';
                  else echo "{$medicine1['nome']} {$medicine1['forma']}";
                  ?>
                </h4>
                <p class="card-text">
                  Numero segnalazioni: <b>
                    <?php
                    if (!isset($medicine1) || empty($medicine1)) echo '...';
                    else echo $medicine1['segnalazioni'];
                    ?>
                  </b><br>
                  Codice farmaco: <b>
                    <?php
                    if (!isset($medicine1) || empty($medicine1)) echo '...';
                    else echo $medicine1['farmaco'];
                    ?>
                  </b><br>
                  Via di somministrazione: <b>
                    <?php
                    if (!isset($medicine1) || empty($medicine1)) echo '...';
                    else echo $medicine1['somministrazione'];
                    ?>
                  </b><br>
                  Principio attivo: <b>
                    <?php
                    if (!isset($medicine1) || empty($medicine1)) echo '...';
                    else echo $medicine1['principio_attivo'];
                    ?>
                  </b><br>
                </p>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-outline-dark text-hover-warning" type="button" onClick="window.location.reload();">
                  <i data-feather="play"></i>
                  Esegui query
                </button>
              </div>
            </div>
            <div class="card text-white bg-info">
              <h5 class="card-header">Farmaco più problematico per la gravidanza</h5>
              <div class="card-body">
                <h4 class="card-title">
                  <?php
                  if (!isset($medicine4)) echo 'Query non eseguita';
                  else if (empty($medicine4)) echo 'Nessun sintomo grave segnalato in gravidanza';
                  else echo "{$medicine4['nome']} {$medicine4['forma']}";
                  ?>
                </h4>
                <p class="card-text">
                  Totale sintomi gravi segnalati: <b>
                    <?php
                    if (!isset($medicine4) || empty($medicine4)) echo '...';
                    else echo $medicine4['sintomi'];
                    ?>
                  </b><br>
                  Codice farmaco: <b>
                    <?php
                    if (!isset($medicine4) || empty($medicine4)) echo '...';
                    else echo $medicine4['farmaco'];
                    ?>
                  </b><br>
                  Via di somministrazione: <b>
                    <?php
                    if (!isset($medicine4) || empty($medicine4)) echo '...';
                    else echo $medicine4['somministrazione'];
                    ?>
                  </b><br>
                  Principio attivo: <b>
                    <?php
                    if (!isset($medicine4) || empty($medicine4)) echo '...';
                    else echo $medicine4['principio_attivo'];
                    ?>
                  </b><br>
                </p>
                <p class="card-text text-white-50">
                  Con "sintomo grave" si intende un sintomo con gravità che non sia "Non definita" o "Non grave".
                </p>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-outline-light text-hover-info" onClick="window.location.reload();" type="button">
                  <i data-feather="play"></i>
                  Esegui query
                </button>
              </div>
            </div>
          </div>
          <div class="col-8">
            <div class="card text-white bg-dark mb-3">
              <h5 class="card-header">Casi di decesso per sintomi non noti</h5>
              <div class="card-body">
                <table class="table table-dark mb-0">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Medico</th>
                      <th scope="col">Paziente</th>
                      <th scope="col">Farmaco</th>
                      <th scope="col">Sintomi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!isset($reports2)) { ?>
                      <td colspan="5" class="text-center text-white-50 h5">Query non eseguita</td>
                    <?php } else if (empty($reports2)) { ?>
                      <td colspan="5" class="text-center text-white-50 h5">Nessun caso segnalato</td>
                    <?php } else foreach ($reports2 as $report) { ?>
                      <tr>
                        <th scope="row"><?php echo $report['numero'] ?></th>
                        <td>
                          <?php echo "{$report['nome_medico']} {$report['cognome']}" ?>
                        </td>
                        <td>
                          <?php
                          foreach (str_split($report['iniziali']) as $initial)
                            echo "$initial. ";
                          ?>
                          <br>
                          <span class="text-white-50">Anni <?php echo $report['età'] ?></span>
                        </td>
                        <td>
                          <?php echo "{$report['nome_farmaco']} {$report['forma']}" ?> <br>
                          <span class="text-white-50"><?php echo $report['principio_attivo'] ?></span>
                        </td>
                        <td>
                          <?php
                          foreach ($report['sintomi'] as $symptom)
                            echo "$symptom<br>";
                          ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="card-footer d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0">Totale casi: <?php echo isset($reports2) ? count($reports2) : '...' ?></h5>
                <button class="btn btn-outline-light" onClick="window.location.reload();" type="button">
                  <i data-feather="play"></i>
                  Esegui query
                </button>
              </div>
            </div>
            <div class="card bg-light border-dark">
              <h5 class="card-header">Ricerca sintomi segnalati per farmaco</h5>
              <div class="card-body">
                <form class="needs-validation" method="post" action="index.php?search" novalidate>
                  <div class="form-group row">
                    <label class="col-2 col-form-label" for="medicineInput">Farmaco</label>
                    <div class="col-7">
                      <select class="custom-select" id="medicineInput" name="medicine" required>
                        <option selected disabled value="">Seleziona un farmaco...</option>
                        <?php
                        $query = '
                        SELECT codice, nome, forma
                        FROM "FARMACO"
                      ';
                        $medicines = pg_query($query);
                        while ($medicine = pg_fetch_array($medicines, null, PGSQL_ASSOC)) {
                          if (isset($_POST['medicine']) && $_POST['medicine'] == $medicine['codice']) $selected = 'selected';
                          else $selected = '';
                          echo "<option value='{$medicine['codice']}' $selected>{$medicine['nome']} {$medicine['forma']}</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-3">
                      <button class="btn btn-outline-dark btn-block" type="submit">
                        <i data-feather="search"></i>
                        Cerca
                      </button>
                    </div>
                  </div>
                </form>
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th scope="col">Sintomo</th>
                      <th scope="col">
                        Numero segnalazioni
                        <i data-feather="arrow-up" class="ml-1"></i>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!isset($symptoms3)) { ?>
                      <td colspan="5" class="text-center text-muted h5">Query non ancora eseguita</td>
                    <?php } else if (empty($symptoms3)) { ?>
                      <td colspan="5" class="text-center text-muted h5">Nessun sintomo segnalato</td>
                    <?php } else foreach ($symptoms3 as $symptom) { ?>
                      <tr>
                        <th scope="row">
                          <?php echo $symptom['sintomo'] ?>
                        </th>
                        <td>
                          <?php echo $symptom['segnalazioni'] ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script>
    feather.replace();

    $('.text-hover-warning').hover(function() {
      $(this).removeClass('text-dark');
      $(this).addClass('text-warning');
    }, function() {
      $(this).removeClass('text-warning');
      $(this).addClass('text-dark');
    });

    $('.text-hover-info').hover(function() {
      $(this).removeClass('text-light');
      $(this).addClass('text-info');
    }, function() {
      $(this).removeClass('text-info');
      $(this).addClass('text-light');
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