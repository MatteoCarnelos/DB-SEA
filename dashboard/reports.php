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

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha256-FAOaXTpl90/K8cXmSdsskbQN3nKYulhCpPbcFzGTWKI=" crossorigin="anonymous">
    <link href="dashboard.css" rel="stylesheet">
  </head>

  <body>
    <!-- Navbar -->
    <?php include '_includes/navbar.html'; ?>
    
    <div class="container-fluid">
      <!-- Sidebar -->
      <div class="row">
        <?php 
          $active = 1;
          include '_includes/sidebar.php';
        ?>
        <!-- Main area -->
        <main role="main" class="col-10 ml-auto px-4">
          <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h2>Segnalazioni</h2>
          </div>
          
          <div class="card">
            <div class="card-header p-0">
              <button class="btn btn-block btn-link text-left d-flex align-items-center text-dark" data-toggle="collapse" data-target="#newReportCollapse">
                <i class="mr-1" data-feather="plus" style="width: 24px; height: 24px"></i>
                <h5 class="pt-2">Nuova segnalazione</h5>
              </button>
            </div>
            <div id="newReportCollapse" class="collapse show"> <!-- TOGLIERE SHOW -->
              <div class="card-body pb-2">
                <form class="need-validation">

                  <h5 class="pb-2 border-bottom">Dettagli segnalazione:</h5>

                  <div class="mt-3 form-group row">
                    <label class="col-1 col-form-label">Data:</label>
                    <div class="input-group col-2">
                      <input type="text" class="form-control datepicker" value="<?php echo date("d-m-Y") ?>" readonly required>
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary datepicker-toggler" type="button">
                          <i data-feather="calendar"></i>
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-1 col-form-label">Medico:</label>
                    <div class="input-group col-11">
                      <select class="custom-select" required>
                        <option selected disabled value="">Seleziona un medico...</option>
                        <?php

                        ?>
                      </select>
                      <div class="input-group-append">
                        <button class="btn btn-outline-success" type="button">
                          <i data-feather="plus"></i>
                          Registra nuovo medico
                        </button>
                      </div>
                    </div>
                  </div>

                  <h5 class="pb-2 border-bottom">Dettagli paziente:</h5>

                  <button type="submit" class="btn btn-primary">Submit</button>

                </form>
              </div>
            </div>
          </div>
          
        </main>
      </div>
    </div>

    <script> 
      feather.replace();
      $('.datepicker').datepicker({
        language: 'it',
        format: 'dd-mm-yyyy',
        autoclose: 'true',
        todayBtn: 'linked'
      });
      $('.datepicker-toggler').click(function () {
        $('.datepicker').focus();
      });
    </script>
  </body>
</html>