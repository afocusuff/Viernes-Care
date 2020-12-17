<?php
include "config.php";
include "utils.php";

$dbConn =  connect($db);

/*
  buscar pacientes
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
  //El rastreador podra buscar un paciente
if(isset($_GET['DNI']) && (isset($_GET['roll']) && ($_GET['roll'] == 'rastreador' || $_GET['roll'] == 'medico' ))){
  $statment = $dbConn->prepare("SELECT * FROM paciente WHERE docIdPaciente= :docIdPaciente");
    $statment->bindParam(":docIdPaciente", $_GET['DNI']);
    $statment->execute();
    $count=$statment->rowCount();
    if($count ==1){
      header("HTTP/1.1 200 OK");
      echo json_encode($statment->fetch(PDO::FETCH_OBJ));
    }
  }
  //Devolver los datos al paciente
  //Si el DNI y EL CODE estan Informados accedemos a verificar el paciente
  if(isset($_GET['DNI']) && isset($_GET['CODE'])){

    //Verificamos si el paciente existe, si existe devuelve los datos de paciente
    //si no existe devolverá null
    $dataUser = validateUser($conn,$_GET['DNI'],$_GET['CODE']);

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

  //   if (isset($_GET['Code']))
  //   {
  //     //Mostrar un post
  //     $sql = $dbConn->prepare("SELECT * FROM country where Code=:Code");
  //     $sql->bindValue(':Code', $_GET['Code']);
  //     $sql->execute();
  //     header("HTTP/1.1 200 OK");
  //     echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
  //     exit();
	//   }
  //   else {
  //     //Mostrar lista de post
  //     $sql = $dbConn->prepare("SELECT * FROM country");
  //     $sql->execute();
  //     $sql->setFetchMode(PDO::FETCH_ASSOC);
  //     header("HTTP/1.1 200 OK");
  //     echo json_encode( $sql->fetchAll()  );
  //     exit();
	// }
}

// Crear un nuevo post
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

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
	// $id = $_GET['Code'];
  // $statement = $dbConn->prepare("DELETE FROM country where Code=:id");
  // $statement->bindValue(':id', $id);
  // $statement->execute();
	// header("HTTP/1.1 200 OK");
	// exit();
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
  if(isset($_GET['DNI']) && isset($_GET['rol'])){
    if($_GET['rol'] == 'rastreador'){
      $input = $_GET;
      $dni = $input['DNI'];
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
  //$input = $_GET;
  //$postId = $input['Code'];
  // $fields = getParams($input);

    // $sql = "
    //       UPDATE country
    //       SET $fields
    //       WHERE Code='$postId'
    //        ";

    // $statement = $dbConn->prepare($sql);
    // bindAllValues($statement, $input);

    // $statement->execute();
    // header("HTTP/1.1 200 OK");
    // exit();
}

//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>