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
      $active = 3;
      include 'includes/frame/sidebar.php';
      ?>

      <!-- Main area -->
      <main role="main" class="col-10 ml-auto px-4">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h2>Farmaci</h2>
          <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#agentsModal">
            <i class="mr-1" data-feather="settings"></i>
            Gestisci principi attivi
          </button>
        </div>

        <?php include 'includes/handler/error_handler.php' ?>
        <?php include 'includes/handler/connection_handler.php' ?>
        <?php include 'includes/manager/medicines_manager.php' ?>

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
                    ';
                    $result = pg_query($query);
                    $count = 0;
                    while ($agent = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                      $count++;
                      echo "
                        <tr>
                          <th class='align-middle' scope='row'>
                            $count
                          </th>
                          <td class='align-middle'>
                            {$agent['nome']}
                          </td>
                          <td class='align-middle text-right'>
                            <button class='btn btn-outline-danger' type='button'>
                              <i data-feather='trash-2'></i>
                            </button>
                          </td>
                        </tr>
                      ";
                    }
                    ?>
                    <tr>
                      <th class="align-middle" scope="row">
                        <?php echo $count + 1 ?>
                      </th>
                      <td>
                        <input class="align-middle form-control" type="text">
                      </td>
                      <td class="align-middle text-right">
                        <button class="btn btn-outline-success" type="button">
                          <i data-feather="plus"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-primary">Salva modifiche</button>
              </div>
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
                  <div class="col-4">
                    <select class="custom-select" id="formInput" name="form" required>
                      <option selected disabled value="">Seleziona una forma farmaceutica...</option>
                      <option value="Compresse">Compresse</option>
                      <option value="Pillole">Pillole</option>
                      <option value="Capsule">Capsule</option>
                      <option value="Polvere">Polvere</option>
                      <option value="Granulato">Granulato</option>
                      <option value="Gel">Gel</option>
                      <option value="Ungente">Ungente</option>
                      <option value="Lubrificante">Lubrificante</option>
                      <option value="Pasta">Pasta</option>
                      <option value="Sciroppo">Sciroppo</option>
                      <option value="Fiale">Fiale</option>
                      <option value="Gocce">Gocce</option>
                      <option value="Collirio">Collirio</option>
                      <option value="Areosol">Areosol</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-2 col-form-label" for="administrationInput">Somministrazione</label>
                  <div class="col-4">
                    <select class="custom-select" id="administrationInput" name="administration" required>
                      <option selected disabled value="">Seleziona una via di somministrazione...</option>
                      <option value="Orale">Orale</option>
                      <option value="Topica">Topica</option>
                      <option value="Parentale">Parentale</option>
                      <option value="Rettale">Rettale</option>
                      <option value="Oftalmica">Oftalmica</option>
                      <option value="Inalatoria">Inalatoria</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-2 col-form-label" for="agentInput">Principio attivo</label>
                  <div class="col-4">
                    <select class="custom-select" id="agentInput" name="agent" required>
                      <option selected disabled value="">Seleziona un principio attivo...</option>
                      <?php
                      $query = '
                        SELECT *
                        FROM "PRINCIPIO_ATTIVO"
                      ';
                      $result = pg_query($query);
                      while ($agent = pg_fetch_array($result, null, PGSQL_ASSOC))
                        echo "<option value='{$agent['nome']}'>{$agent['nome']}</option>";
                      ?>
                    </select>
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