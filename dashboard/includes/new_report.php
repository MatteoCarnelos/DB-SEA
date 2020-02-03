<?php
    $succ_alert = '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Segnalazione aggiunta al database!
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    ';
    
    if(!empty($_POST)) {
        $date = $_POST['date'];
        $date = date('m-d-Y', strtotime($date));
        $doctor = $_POST['doctor'];
        $notes = $_POST['notes'];
        $query = "
            INSERT INTO \"SEGNALAZIONE\"(data, note, medico)
            VALUES('$date', '$notes', $doctor)
            RETURNING numero
        ";
        $result = pg_query($query);
        if($result) {
            $number = pg_fetch_result($result, 0, 0);
            $patient = $_POST['patient'];
            if($patient['gender'] == 'M') $patient['gravidance'] = 'null';
            else $patient['gravidance'] = isset($patient['gravidance']) ? 'true' : 'false';
            $patient['initials'] = strtoupper($patient['initials']);
            $assumption = $_POST['assumption'];
            $assumption['start'] = date('Y-m-d', strtotime($assumption['start']));
            if(empty($assumption['end'])) $assumption['end'] = 'null';
            else {
                $assumption['end'] = date('Y-m-d', strtotime($assumption['end']));
                $assumption['end'] = "'{$assumption['end']}'";
            }
            $query = "
                INSERT INTO \"PAZIENTE\"
                VALUES($number, '{$patient['initials']}', {$patient['age']}, '{$patient['gender']}', '{$patient['city']}', {$patient['gravidance']},
                        {$assumption['medicine']}, '{$assumption['start']}', {$assumption['end']}, '{$assumption['frequency']}', '{$assumption['dose']}')
            ";
            $result = pg_query($query);
            if(!$result) pg_query("DELETE FROM \"SEGNALAZIONE\" WHERE numero = $number");
            else {
                $symptoms = $_POST['symptoms'];
                foreach($symptoms as $symptom) {
                    $symptom['start'] = date('Y-m-d', strtotime($symptom['start']));
                    if(empty($symptom['end'])) $symptom['end'] = 'null';
                    else {
                        $symptom['end'] = date('Y-m-d', strtotime($symptom['end']));
                        $symptom['end'] = "'{$symptom['end']}'";
                    }
                    $query = "
                        INSERT INTO \"RIPORTA\"
                        VALUES($number, '{$symptom['name']}', '{$symptom['start']}', {$symptom['end']}, '{$symptom['status']}', '{$symptom['severity']}')
                    ";
                    $result = pg_query($query);
                    if(!$result) {
                        pg_query("DELETE FROM \"SEGNALAZIONE\" WHERE numero = $number");
                        break;
                    }
                }
                if($result) echo $succ_alert;
            }
        }
    }
?>