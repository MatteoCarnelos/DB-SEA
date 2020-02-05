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
      $active = 4;
      include 'includes/frame/sidebar.php';
      ?>

      <!-- Main area -->
      <main role="main" class="col-10 ml-auto px-4">
        <h2 class="pb-2 pt-3 mb-3 border-bottom">Sintomi</h2>

        <?php include 'includes/handler/error_handler.php' ?>
        <?php include 'includes/frame/alerts.php' ?>
        <?php include 'includes/handler/connection_handler.php' ?>
        <?php include 'includes/manager/symptoms_manager.php' ?>

        <div class="card">
          <div class="card-header p-0">
            <button class="btn btn-block btn-link text-left d-flex align-items-center text-dark" type="button" data-toggle="collapse" data-target="#newSymptomCollapse">
              <i class="mr-1" data-feather="plus" style="width: 24px; height: 24px"></i>
              <h5 class="pt-2">Registra sintomo</h5>
            </button>
          </div>
          <div id="newSymptomCollapse" class="collapse <?php if (isset($_GET['show'])) echo 'show' ?>">
            <div class="card-body">
              <form class="needs-validation" method="post" action="symptoms.php?new" novalidate>

                <div class="form-group row">
                  <label class="col-1 col-form-label" for="nameInput">Nome</label>
                  <div class="col-4">
                    <input type="text" class="form-control" id="nameInput" name="name" placeholder="Nome del sintomo..." required>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-1 col-form-label" for="descriptionInput">Descrizione</label>
                  <div class="col-11">
                    <textarea class="form-control" id="descriptionInput" name="description" rows="3" placeholder="Descrizione del sintomo..."></textarea>
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
          <h4 class="m-3">Lista sintomi registrati</h4>
          <p class="text-dark">Numero tuple: <?php echo pg_fetch_result(pg_query('SELECT COUNT(*) FROM "SINTOMO"'), 0) ?></p>
        </div>

        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Nome</th>
              <th scope="col">Descrizione</th>
              <th scope="col">Causato da</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $query = '
              SELECT *
              FROM "SINTOMO"
            ';
            $result = pg_query($query);
            while ($symptom = pg_fetch_array($result, null, PGSQL_ASSOC)) {
              if (empty($symptom['descrizione'])) $symptom['descrizione'] = '-';
              $aio_name = str_replace(' ', '_', $symptom['nome']);
              echo "
                <tr>
                  <th scope='row'>
                    {$symptom['nome']}
                  </th>
                  <td>
                    {$symptom['descrizione']}
                  </td>
                  <td>
              ";
              $query = "
                SELECT F.nome, F.forma
                FROM \"FARMACO\" AS F JOIN \"CAUSA\" AS C ON F.codice = C.farmaco
                WHERE sintomo = '{$symptom['nome']}'
              ";
              $medicines = pg_query($query);
              if (pg_num_rows($medicines) == 0) echo "<p class='text-muted'>[Nessun farmaco]</p></td>";
              else {
                echo "
                  <button class='btn btn-link text-body pl-0' data-toggle='modal' data-target='#medicinesModal$aio_name' type='button'>Visualizza farmaci</button>
                  <div class='modal fade' id='medicinesModal{$aio_name}'>
                    <div class='modal-dialog modal-dialog-scrollable'>
                      <div class='modal-content'>
                        <div class='modal-header'>
                          <h5 class='modal-title'>Farmaci che causano '{$symptom['nome']}'</h5>
                          <button type='button' class='close' data-dismiss='modal'>
                            <span>&times;</span>
                          </button>
                        </div>
                        <div class='modal-body'>
                          <table class='table table-sm table-borderless table-hover'>
                            <thead class='thead-light'>
                              <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Farmaco</th>
                              </tr>
                            </thead>
                            <tbody>";
                $count = 0;
                while ($medicine = pg_fetch_array($medicines, null, PGSQL_ASSOC)) {
                  $count++;
                  echo "
                    <tr>
                      <th scope='row'>
                        $count
                      </th>
                      <td>
                        {$medicine['nome']} {$medicine['forma']}
                      </td>
                    </tr>
                  ";
                }
                echo "
                              </tbody>
                            </table>
                          </div>
                          <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Chiudi</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                ";
              }
              echo "
                  <td class='align-middle text-right'>
                    <button class='mr-2 btn btn-outline-danger' type='button'>
                      <i data-feather='trash-2'></i>
                    </button>
                  </td>
                </tr>
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