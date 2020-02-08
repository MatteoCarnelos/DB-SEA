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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/js/bootstrap-select.min.js" integrity="sha256-+o/X+QCcfTkES5MroTdNL5zrLNGb3i4dYdWPWuq6whY=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.12/css/bootstrap-select.min.css" integrity="sha256-l3FykDBm9+58ZcJJtzcFvWjBZNJO40HmvebhpHXEhC0=" crossorigin="anonymous">
  <link href="includes/css/dashboard.css" rel="stylesheet">
</head>

<body>
  <!-- Navbar -->
  <?php include 'includes/frame/navbar.html' ?>

  <div class="container-fluid">
    <!-- Sidebar -->
    <div class="row">
      <?php
      $active = 3;
      include 'includes/frame/sidebar.php';
      ?>

      <!-- Main area -->
      <main role="main" class="col-10 ml-auto px-4">
        <div class="d-flex justify-content-between align-items-center pt-3 mb-3 border-bottom">
          <h2>Farmaci</h2>
          <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#agentsModal">
            <i data-feather="settings"></i>
            Gestisci principi attivi
          </button>
        </div>

        <?php include 'includes/handler/error_handler.php' ?>
        <?php include 'includes/handler/connection_handler.php' ?>
        <?php include 'includes/manager/medicines_manager.php' ?>
        <?php include 'includes/manager/agents_manager.php' ?>

        <div class="modal fade" data-backdrop="static" id="agentsModal">
          <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Principi attivi</h5>
                <button type="button" class="close" data-dismiss="modal">
                  <span>&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-sm table-borderless table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nome</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php
                    $query = '
                      SELECT *
                      FROM "PRINCIPIO_ATTIVO"
                      ORDER BY nome
                    ';
                    $agents = pg_query($query);
                    $count = 0;
                    while ($agent = pg_fetch_array($agents, null, PGSQL_ASSOC)) {
                      $count++;
                    ?>

                      <tr>
                        <form method="post" action="medicines.php?removeagent">
                          <input type="hidden" name="name" value="<?php echo $agent['nome'] ?>">
                          <th class="align-middle" scope="row">
                            <?php echo $count ?>
                          </th>
                          <td class="align-middle cell-name">
                            <?php echo $agent['nome'] ?>
                          </td>
                          <td class="align-middle text-right">
                            <button class="btn btn-outline-danger" type="submit">
                              <i data-feather="trash-2"></i>
                            </button>
                          </td>
                        </form>
                      </tr>

                    <?php } ?>

                    <tr>
                      <form method="post" action="medicines.php?newagent">
                        <th class="align-middle" scope="row">
                          <?php echo $count + 1 ?>
                        </th>
                        <td>
                          <input class="form-control align-middle" type="text" name="name" required>
                        </td>
                        <td class="align-middle text-right">
                          <button class="btn btn-outline-success" type="sumbit">
                            <i data-feather="plus"></i>
                          </button>
                        </td>
                      </form>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
              </div>
              </form>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-header p-0">
            <button class="btn btn-block btn-link text-left d-flex align-items-center text-dark" type="button" data-toggle="collapse" data-target="#newDoctorCollapse">
              <i class="mr-1" data-feather="plus" style="width: 24px; height: 24px"></i>
              <h5 class="pt-2">Registra farmaco</h5>
            </button>
          </div>
          <div id="newDoctorCollapse" class="collapse <?php if (isset($_GET['show'])) echo 'show' ?>">
            <div class="card-body">
              <form class="needs-validation" method="post" action="medicines.php?new" novalidate>

                <div class="form-group row">
                  <label class="col-2 col-form-label" for="codeInput">Codice</label>
                  <div class="col-3">
                    <input type="text" class="form-control text-uppercase" id="codeInput" name="code" placeholder="0123456789" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-2 col-form-label" for="nameInput">Nome</label>
                  <div class="col-4">
                    <input type="text" class="form-control" id="nameInput" name="name" placeholder="Nome del farmaco..." required>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-2 col-form-label" for="formInput">Forma</label>
                  <div class="col-6">
                    <select class="custom-select" id="formInput" name="form" required>
                      <option selected disabled value="">Seleziona una forma farmaceutica...</option>
                      <option disabled value="">Solide:</option>
                      <option value="Compresse">Compresse</option>
                      <option value="Pillole">Pillole</option>
                      <option value="Capsule">Capsule</option>
                      <option value="Polvere">Polvere</option>
                      <option value="Granulato">Granulato</option>
                      <option disabled value="">Semisolide:</option>
                      <option value="Gel">Gel</option>
                      <option value="Unguente">Unguente</option>
                      <option value="Lubrificante">Lubrificante</option>
                      <option value="Pasta">Pasta</option>
                      <option disabled value="">Liquide:</option>
                      <option value="Sciroppo">Sciroppo</option>
                      <option value="Fiale">Fiale</option>
                      <option value="Gocce">Gocce</option>
                      <option value="Collirio">Collirio</option>
                      <option disabled value="">Gassose:</option>
                      <option value="Areosol">Areosol</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-2 col-form-label" for="administrationInput">Somministrazione</label>
                  <div class="col-6">
                    <select class="custom-select" id="administrationInput" name="administration" required>
                      <option selected disabled value="">Seleziona una via di somministrazione...</option>
                      <option value="Orale">Orale</option>
                      <option value="Topica">Topica</option>
                      <option value="Parenterale">Parenterale</option>
                      <option value="Rettale">Rettale</option>
                      <option value="Oftalmica">Oftalmica</option>
                      <option value="Inalatoria">Inalatoria</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-2 col-form-label" for="agentInput">Principio attivo</label>
                  <div class="input-group col-10">
                    <select class="custom-select" id="agentInput" name="agent" required>
                      <option selected disabled value="">Seleziona un principio attivo...</option>
                      <?php
                      $query = '
                        SELECT *
                        FROM "PRINCIPIO_ATTIVO"
                        ORDER BY nome
                      ';
                      $agents = pg_query($query);
                      while ($agent = pg_fetch_array($agents, null, PGSQL_ASSOC))
                        echo "<option value='{$agent['nome']}'>{$agent['nome']}</option>";
                      ?>
                    </select>
                    <div class="input-group-append">
                      <button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#agentsModal">
                        <i data-feather="settings"></i>
                        Gestisci principi attivi
                      </button>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-2 col-form-label" for="symptomsInput">Sintomi conosciuti</label>
                  <div class="input-group col-10">
                    <select class="selectpicker form-control" id="symptomsInput" title="Seleziona uno o più sintomi..." name="symptoms[]" multiple required>
                      <?php
                      $query = '
                        SELECT nome
                        FROM "SINTOMO"
                        ORDER BY nome
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

                <div class="row justify-content-end border-top pt-3">
                  <div class="col-3">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Registra</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-baseline">
          <h4 class="m-3">Lista farmaci registrati</h4>
          <p class="text-dark">Numero tuple: <?php echo pg_fetch_result(pg_query('SELECT COUNT(*) FROM "FARMACO"'), 0) ?></p>
        </div>

        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Codice</th>
              <th scope="col">Nome</th>
              <th scope="col">Forma</th>
              <th scope="col">Somministrazione</th>
              <th scope="col">Principio attivo</th>
              <th scope="col">Sintomi</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>

            <?php
            $query = '
              SELECT *
              FROM "FARMACO"
              ORDER BY nome, forma
            ';
            $medicines = pg_query($query);
            pg_prepare('selsym', '
              SELECT sintomo
              FROM "CAUSA"
              WHERE farmaco = $1 AND conosciuto = $2
              ORDER BY sintomo
            ');
            $index = 0;
            while ($medicine = pg_fetch_array($medicines, null, PGSQL_ASSOC)) {
              $index++;
            ?>

              <tr>
                <th scope='row'>
                  <?php echo $medicine['codice'] ?>
                </th>
                <td>
                  <?php echo $medicine['nome'] ?>
                </td>
                <td>
                  <?php echo $medicine['forma'] ?>
                </td>
                <td>
                  <?php echo $medicine['somministrazione'] ?>
                </td>
                <td>
                  <?php echo $medicine['principio_attivo'] ?>
                </td>
                <td>
                  <button class="btn btn-link text-body pl-0 pt-0" data-toggle="modal" data-target="#symptomsModal<?php echo $index ?>" type="button">Visualizza sintomi</button>
                  <div class="modal fade" id="symptomsModal<?php echo $index ?>">
                    <div class="modal-dialog modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Sintomi "<?php echo "{$medicine['nome']} {$medicine['forma']}" ?>"</h5>
                          <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <table class="table table-sm table-borderless table-hover">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Sintomi conosciuti</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php
                              $known_sympts = pg_execute('selsym', array($medicine['codice'], 'true'));
                              $count = 0;
                              while ($known_sympt = pg_fetch_array($known_sympts, null, PGSQL_ASSOC)) {
                                $count++;
                              ?>

                                <tr>
                                  <th scope="row">
                                    <?php echo $count ?>
                                  </th>
                                  <td>
                                    <?php echo $known_sympt['sintomo'] ?>
                                  </td>
                                </tr>

                              <?php } ?>

                            </tbody>
                          </table>
                          <table class="table table-sm table-borderless table-hover">
                            <thead class="thead-light">
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Sintomi sconosciuti</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php
                              $unknown_sympts = pg_execute('selsym', array($medicine['codice'], 'false'));
                              $count = 0;
                              while ($unknown_sympt = pg_fetch_array($unknown_sympts, null, PGSQL_ASSOC)) {
                                $count++;
                              ?>

                                <tr>
                                  <th scope="row">
                                    <?php echo $count ?>
                                  </th>
                                  <td>
                                    <?php echo $unknown_sympt['sintomo'] ?>
                                  </td>
                                </tr>

                              <?php }
                              if ($count == 0) { ?>

                                <tr>
                                  <th scope="row">
                                    <p class="text-muted mb-0">-</p>
                                  </th>
                                  <td>
                                    <p class="font-italic text-muted mb-0">Nessun sintomo sconosciuto segnalato</p>
                                  </td>
                                </tr>

                              <?php } ?>

                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="align-middle text-right">
                  <button class="mr-2 btn btn-outline-danger" type="button" data-toggle="modal" data-target="#removeModal<?php echo $index ?>">
                    <i data-feather="trash-2"></i>
                  </button>
                </td>
              </tr>

              <div class="modal fade" id="removeModal<?php echo $index ?>">
                <div class="modal-dialog modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Rimozione farmaco "<?php echo "{$medicine['nome']} {$medicine['forma']}" ?>"</h5>
                      <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                      </button>
                    </div>
                    <form class="needs-validation" method="post" action="medicines.php?remove" novalidate>
                      <input type="hidden" name="code" value="<?php echo $medicine['codice'] ?>">
                      <div class="modal-body">
                        Sei sicuro di voler cancellare il farmaco?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                        <button type="submit" class="btn btn-danger">Cancella</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

            <?php } ?>

          </tbody>
        </table>
      </main>
    </div>
  </div>

  <script>
    feather.replace();

    $('#agentsModal').on('shown.bs.modal', function(e) {
      if ($('#newDoctorCollapse').hasClass('show')) {
        $(this).find('form').attr('action', function(index, attr) {
          return attr + "&show";
        });
      }
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