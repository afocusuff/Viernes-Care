<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  //Verificamos el rol de usuario, si es rastreador
    if(isset($_POST['rol']) && $_POST['rol'] == "rastreador"){
            $input = $_POST;
            $key = random_int(1000000, 99999999);
            $sql = "INSERT INTO paciente
            (docIdPaciente, clavePaciente, emailPaciente, telefonoPaciente)
            VALUES
             (:docIdPaciente, :clavePaciente, :emailPaciente, :telefonoPaciente)";
            $statement = $dbConn->prepare($sql);
           //bindAllValues($statement, $input);
            $statement->bindParam(':docIdPaciente', $_POST['docIdPaciente']);
            $statement->bindParam(':clavePaciente', $key);
            $statement->bindParam(':emailPaciente', $_POST['emailPaciente']);
            $statement->bindParam(':telefonoPaciente', $_POST['telefonoPaciente']);
            $statement->execute();
            $count = $statement->rowCount();
            if($count == 1)
             {
               header("HTTP/1.1 200 OK");
               echo json_encode($input);
              exit();
            }
    }else{
        header("HTTP/1.1 404 NOT FOUND");
    }
    
    exit();
  }