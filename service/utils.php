<?php

  //Abrir conexion a la base de datos
  function connect($db)
  {
      try {
          $conn = new PDO("mysql:host={$db['host']};dbname={$db['db']}", $db['username'], $db['password']);

          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          return $conn;
      } catch (PDOException $exception) {
          exit($exception->getMessage());
      }
  }


 //Obtener parametros para updates
 function getParams($input)
 {
    $filterParams = [];
    foreach($input as $param => $value)
    {
            $filterParams[] = "$param=:$param";
    }
    return implode(", ", $filterParams);
	}

  //Asociar todos los parametros a un sql
	function bindAllValues($statement, $params)
  {
		foreach($params as $param => $value)
    {
				$statement->bindValue(':'.$param, $value);
		}
		return $statement;
  }


  //validar los datos del paciente
function  validateUser($context, $dni,$code){
    ////da un error si se cambia el variable resultado a result///
    $statment = $context->prepare("SELECT * FROM paciente WHERE docIdPaciente= :docIdPaciente");
    $statment->bindParam(":docIdPaciente", $dni);
    $statment->execute();
    $count=$statment->rowCount();
    if($count ==1){
        $userData=$statment->fetch(PDO::FETCH_OBJ);
        //$isPassValid = password_verify($code, $userData->pass);
        $isPassValid = $code === $userData->clavePaciente;
        if($isPassValid){
            return $userData; 
        }else{
            return null;
        }
    }
    else{
        return null;
    }
  }
 
 ?>