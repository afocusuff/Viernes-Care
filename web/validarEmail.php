<?php
    session_start();
    include("./includes/_imports.php");
    require("./includes/config.php");
    include("./includes/functions.php");
    
    //si el boton submit informado y el campo email no esta vacio
    if(isset($_POST["submit"]) && !empty($_POST["email"]) ){
        $email = $_POST['email'];

        //validamos usuario
        $isEmailValid = validateEmail($conn,$email);
        if($isEmailValid){
            header("Location: ./olvide_contrasena.php?success=Se ha enviadoun email a su correo");
            exit();
        }
        else{
            //Si los datos son Incorrectos lo renviamos a la pagina de inicio y pintamos el error:
            header("Location: ./olvide_contrasena.php?error=El email no existe");
            exit();
        }
        $conn = null;
    }
?>