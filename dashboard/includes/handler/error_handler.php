<?php

function error_handler($errno, $errstr, $errfile, $errline)
{
  echo "
    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <h4 class='alert-heading'>Ops...</h4>
        Qualcosa è andato storto durante l'esecuzione delle operazioni sul database, di seguito è riportato il messaggio di errore:<br>
        <strong>$errstr</strong><br>
        Controllare i dati e riprovare.
        <hr>
        Errore nel file '$errfile' alla linea $errline.
        <button type='button' class='close' data-dismiss='alert'>
          <span>&times;</span>
        </button>
    </div>
  ";
}

set_error_handler('error_handler');
