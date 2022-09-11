<?php include('functions.php');?>
<?php $db_connection = new General;?>

<?php
    if($_POST['func_name'] == 'create_ticket'){
        $sql = "INSERT INTO `lisorubni_kvytky`(`number`, `sosna`, `sosna_dilova`, `jalyna`, `jalyna_dilova`, `dub`, `dub_dilova`, `bereza`, `bereza_dilova`, `vilha`, `vilha_dilova`, `grab`, `grab_dilova`, `jasen`, `jasen_dilova`, `klen`, `klen_dilova`, `osyka`, `osyka_dilova`, `lypa`, `lypa_dilova`, `inshe`, `inshe_dilova`, `chvorost_1c`, `chvorost_2c`, `chvorost_3c`, `total_chvorost`) VALUES (" . $_POST['ticket_number'] . "," . $_POST['sosna'] . "," . $_POST['sosna_dilova'] . "," . $_POST['jalyna'] . "," . $_POST['jalyna_dilova'] . "," . $_POST['dub'] . "," . $_POST['dub_dilova'] . "," . $_POST['bereza'] . "," . $_POST['bereza_dilova'] . "," . $_POST['vilha'] . "," . $_POST['vilha_dilova'] . "," . $_POST['grab'] . "," . $_POST['grab_dilova'] . "," . $_POST['jasen'] . "," . $_POST['jasen_dilova'] . "," . $_POST['klen'] . "," . $_POST['klen_dilova'] . "," . $_POST['osyka'] . "," . $_POST['osyka_dilova'] . "," . $_POST['lypa'] . "," . $_POST['lypa_dilova'] . "," . $_POST['inshe'] . "," . $_POST['inshe_dilova'] . "," . $_POST['chvorost_1c'] . "," . $_POST['chvorost_2c'] . "," . $_POST['chvorost_3c'] . "," . $_POST['total_chvorost'] . ")";
        $sth = $db_connection->dbs->prepare($sql);
        if($sth->execute()){
            return true;
        }
        return false;
    }
?>