<?php
include "config.php";
include "utils.php";


$dbConn =  connect($db);

/*
  listar todos los posts o solo uno
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
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
  //   $input = $_POST;
  //   $sql = "INSERT INTO country
  //         (Code, Name, Capital, Code2)
  //         VALUES
  //         (:Code, :Name, :Capital, :Code2)";
  //   $statement = $dbConn->prepare($sql);
  //   bindAllValues($statement, $input);
  //   $statement->execute();
  //   $count = $statement->rowCount();
  //   if($count == 1)
  //   {
  //     header("HTTP/1.1 200 OK");
  //     echo json_encode($input);
  //     exit();
	//  }
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
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    // $input = $_GET;
    // $postId = $input['Code'];
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