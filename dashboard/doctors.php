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
    <link href="includes/dashboard.css" rel="stylesheet">
    
  </head>
  <body>
    <!-- Navbar -->
    <?php include 'includes/navbar.html' ?>
    
    <div class="container-fluid">
      <!-- Sidebar -->
      <div class="row">
        <?php 
          $active = 2;
          include 'includes/sidebar.php';
        ?>

        <!-- Main area -->
        <main role="main" class="col-10 ml-auto px-4">
            <h2 class="pb-2 pt-3 mb-3 border-bottom">Medici</h2>

            <?php include 'includes/error_handler.php' ?>
            <?php include 'includes/connect.php' ?>
            <?php include 'includes/new_doctor.php' ?>
          
            <div class="card">
              <div class="card-header p-0">
                <button class="btn btn-block btn-link text-left d-flex align-items-center text-dark" type="button" data-toggle="collapse" data-target="#newDoctorCollapse">
                  <i class="mr-1" data-feather="plus" style="width: 24px; height: 24px"></i>
                  <h5 class="pt-2">Registra medico</h5>
                </button>
              </div>
              <div id="newDoctorCollapse" class="collapse <?php if(isset($_GET['new'])) echo 'show' ?>">
                <div class="card-body">
                  <form class="needs-validation" method="post" action="doctors.php" novalidate>

                    <div class="form-group row">
                      <label class="col-1 col-form-label" for="idInput">ID</label>
                      <div class="col-2">
                        <input type="text" class="form-control text-uppercase" id="idInput" name="id" placeholder="1234567890" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-1 col-form-label" for="nameInput">Nome</label>
                      <div class="col-4">
                        <input type="text" class="form-control" id="nameInput" name="name" placeholder="Mario" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-1 col-form-label" for="surnameInput">Cognome</label>
                      <div class="col-4">
                        <input type="text" class="form-control" id="surnameInput" name="surname" placeholder="Rossi" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-1 col-form-label" for="phoneInput">Telefono</label>
                      <div class="col-3">
                        <input type="text" class="form-control text-uppercase" id="phoneInput" name="phone" placeholder="+393401234567">
                      </div>
                      <small class="text-muted my-auto">Se non comunicato, lasciare vuoto il campo.</small>
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
              <h4 class="m-3">Lista medici registrati</h4>
              <p class="text-dark">Numero tuple: <?php echo pg_fetch_result(pg_query('SELECT COUNT(*) FROM "MEDICO"'), 0) ?></p>
            </div>

            <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                <th scope="col">Cognome</th>
                <th scope="col">Telefono</th>
                <th scope="col">Azioni</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $query = '
                  SELECT *
                  FROM "MEDICO"
                ';
                $result = pg_query($query);
                while($doctor = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                  if(!isset($doctor['telefono'])) $doctor['telefono'] = 'Non rilasciato';
                  echo "
                    <tr>
                      <th scope='row'>
                        {$doctor['id']}
                      </th>
                      <td>
                        {$doctor['nome']}
                      </td>
                      <td>
                        {$doctor['cognome']}
                      </td>
                      <td>
                        {$doctor['telefono']}
                      </td>
                      <td class='align-middle'>
                        <button class='mr-1 btn btn-outline-danger' type='button'>
                          <i data-feather='trash-2'></i>
                        </button>
                        <button class='ml-1 btn btn-outline-info' type='button'>
                          <i data-feather='edit'></i>
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