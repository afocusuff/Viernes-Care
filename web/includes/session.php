<?php
    session_start();
    $isSignedIn = true;
    $isAdmin = false;
    $isMedico = false;
    $isRastreador = false;
    
    //Si la sesion email no esta informado.
    if(!isset($_SESSION['userMail'])){
        $isSignedIn = false;
    }else{
        $isAdmin = strtolower($_SESSION['rol']) == "admin" ? true : false;
        $isMedico = strtolower($_SESSION['rol']) == "medico" ? true : false;
        $isRastreador = strtolower($_SESSION['rol']) == "rastreador" ? true : false;
    }
    
?>