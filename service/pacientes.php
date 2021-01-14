<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

/*
  buscar pacientes
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
  //El rastreador y el médico podrán buscar un paciente
  if(isset($_GET['docIdPaciente']) && (isset($_GET['rol']) && ($_GET['rol'] == 'rastreador' || $_GET['rol'] == 'medico' ))){
      $statment = $dbConn->prepare("SELECT * FROM paciente WHERE docIdPaciente= :docIdPaciente");
      $statment->bindParam(":docIdPaciente", $_GET['docIdPaciente']);
      $statment->execute();
      $count=$statment->rowCount();
      if($count ==1){
        header("HTTP/1.1 200 OK");
        echo json_encode($statment->fetch(PDO::FETCH_OBJ));
      }
    }
  //Devolver los datos al paciente
  //Si el DNI y EL CODE estan Informados accedemos a verificar el paciente
  if(isset($_GET['docIdPaciente']) && isset($_GET['code'])){
    //Verificamos si el paciente existe, si existe devuelve los datos de paciente
    //si no existe devolverá null
    $dataUser = validateUser($dbConn,$_GET['docIdPaciente'],$_GET['code']);

    //si el paciente existe se le mandará el cliente lo datos corespondientes
    if($dataUser != null){
      header("HTTP/1.1 200 OK");
      echo json_encode($dataUser);
      exit();
    }
    else{
      // si el paciente no existe de enviar un cabecera de 404 recorso no encontrado. 
      header("HTTP/1.1 404 NOT FOUND");
      exit();
    }
  }
}

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  //Verificamos el rol de usuario, si es rastreador
    if(isset($_POST['rol']) && $_POST['rol'] == "rastreador"){
            $input = $_POST;
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-!@#¡.?¡¿';
            $key = substr(str_shuffle($permitted_chars), 0, 8);

            //Antes de insertar datos debemos verificar que no exista un paciente
            //con el mismo documente
            $stmtCheck = $dbConn->prepare("SELECT docIdPaciente FROM paciente WHERE docIdPaciente= :docIdPaciente");
            $stmtCheck->bindParam(':docIdPaciente', $_POST['docIdPaciente']);
            $stmtCheck->execute();
            $Mycount=$stmtCheck->rowCount();
            if($Mycount == 1){
              header("HTTP/1.1 400 Bad Request");
              //devolvemos un mesaje de error:
              echo json_encode("Error: El Documento del paciente ya ha sido registrado");
              exit();
            }

            //Verficar el email para que no se insertan usuario con el mismo email
            $emailCheck = $dbConn->prepare("SELECT emailPaciente FROM paciente WHERE emailPaciente= :emailPaciente");
            $emailCheck->bindParam(':emailPaciente', $_POST['emailPaciente']);
            $emailCheck->execute();
            $emailCount=$emailCheck->rowCount();
            if($emailCount == 1){
              header("HTTP/1.1 400 Bad Request");
              //devolvemos un mesaje de error:
              echo json_encode("Error: Ya hay un paciente con este email");
              exit();
            }

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
    }
    if(isset($_POST['rol']) && $_POST['rol'] == "medico" && isset($_POST["idPaciente"]) && isset($_POST["estado"]) && isset($_POST["seguimiento"])){
          // $input = $_POST;
          $estado = $_POST["estado"];
          $fecha = date('y-m-d H:m:s');
          $sqlNota = "INSERT INTO nota (fecha_hora,seguimiento,idPaciente) VALUES (:fecha_hora,:seguimiento,:idPaciente)";
          $statement = $dbConn->prepare($sqlNota);
          $statement->bindParam(":fecha_hora", $fecha);
          $statement->bindParam(":seguimiento", $_POST["seguimiento"]);
          $statement->bindParam(":idPaciente", $_POST["idPaciente"]);
          $statement->execute();
          
          header("HTTP/1.1 200 OK");
          exit();
    }
    else{
        header("HTTP/1.1 404 NOT FOUND");
    }
    exit();
}
//Actualizar
//Para poder actualizar el paciente hay dos caso
/*
1-Actualizar el perfil: El encargado es el admin.
2-acualizar el estado: el encargado es el doctor/a.
*/

/*este metodo recibirá un rol para poder acceder a una funcion o otra.
y EL DNI/NIE del paciente
*/
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
  //si el dni y el rol estan infromados
  //si estan informados verificado el tipo de rol
  if(isset($_GET['docIdPaciente']) && isset($_GET['rol'])){
    if($_GET['rol'] == 'rastreador'){
      unset($_GET['rol']);
      $input = $_GET;
      $dni = $input['docIdPaciente'];
      $fields = getParams($input);
      $sql = "UPDATE paciente SET $fields WHERE docIdPaciente='$dni'";
      $statement = $dbConn->prepare($sql);
      bindAllValues($statement, $input);
      $statement->execute();
      header("HTTP/1.1 200 OK");
      exit();
    }

    // si es medico solo actualizar estado
    if($_GET['rol'] == 'medico' && isset($_GET['estado'])){
      $estado = $_GET['estado'];
      $sql = "UPDATE paciente SET estado WHERE docIdPaciente='$dni'";
      $statement = $dbConn->prepare($sql);
      bindAllValues($statement, $estado);
      $statement->execute();
      header("HTTP/1.1 200 OK");
      exit();
    }
  }
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");