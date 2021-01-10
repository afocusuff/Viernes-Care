<?php
    include("./includes/_imports.php");
    require("./includes/config.php");
    include("./includes/functions.php");
    session_start();
    //si el boton submit informado y el campo email no esta vacio
    if(isset($_POST["submit"]) && !empty($_POST["email"]) ){
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        //validamos usuario
        $data = validateUserLoginPDO($conn,$email,$pass);
        
        //Si los datos son correctos. Creamos session
        if($data != null){
            $_SESSION['rol'] = $data->rol;
            $_SESSION['userMail'] = $data->email;
            $_SESSION['name'] = $data->nombre;
            $_SESSION['id_user'] = $data->id;
            //segun el rol dirigimos al usuario a su pagina correspondientes
            GoToPage($data->rol);
        }
        else{
            //Si los datos son Incorrectos lo renviamos a la pagina de inicio y pintamos el error:
            header("Location: ./index.php?error=El email o la contraseña es incorrecto");
            exit();
        }
        $conn = null;
    }
?>