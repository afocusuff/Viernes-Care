<?php
include('includes/session.php');
include('includes/functions.php');
//Si no ha iniciado session y si el rol es admin no enviar a la pagina de inicio de session
if (!$isSignedIn && !$isRastreador) {
    header("Location: ./index.php");
    exit();
}
//iniciarlizar error vacio y isFromValid a true
$error = "";
$success="";
$isFormValid = true;

//si se hace clic sobre el boton actualizar
if(isset($_POST["anadirPaciente"])){
    //Verificarmos los campos
    if (empty($_POST['emailPaciente'])) {
        $error .= "El email es obligatorio<br>";
        $isFormValid = false;
    }
    if (empty($_POST['docIdPaciente'])) {
        $error .= "El Documento del paciente es obligatorio<br>";
        $isFormValid = false;
    }
    if (empty($_POST['telefonoPaciente'])) {
        $error .= "El telefono es obligatorio<br>";
        $isFormValid = false;
    }
    if($isFormValid){
        $data = array(
            'docIdPaciente' => $_POST['docIdPaciente'],
            'emailPaciente' => $_POST['emailPaciente'],
            'telefonoPaciente' => $_POST['telefonoPaciente'],
            'rol' => $_SESSION['rol']
        );
        $query = http_build_query($data);
        $url = 'http://localhost/viernes/ut1893/viernes-care/service/pacientes.php';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        $result = curl_exec($ch);
        //verificamos si el servicio devuelve algun texto que contenga error
        if(strpos($result, 'Error') !== false){
            $error = $result;
        }else{
            $success = "El paciente se ha añadido con exito";
        }
        curl_close($ch);
        
    }
    
}
include("includes/head.html");
?>
<body>
    <main class="container">
        <h2>Datos del paciente</h2>
            <?php
                if (!empty($error)) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">
                    <p class='error'>" . $error . "<p>
                    </div>";
                }
                if (!empty($success)) {
                    echo "<div class=\"alert alert-success\" role=\"alert\">
                    <p class='error'>" . $success . "<p>
                    </div>";
                }
            ?>
            <form action="" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" name="emailPaciente" id="Email" placeholder="Email">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="DocPaciente">Documento</label>
                        <input  name="docIdPaciente" type="text" class="form-control" id="DocPaciente" placeholder="Documento del paciente">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="tel">Telefono</label>
                        <input name="telefonoPaciente"  type="number" class="form-control" id="tel" placeholder="Telefono del paciente">
                    </div>
                </div>
                <div class="input-group">
                    <a href="rastreador.php" class="btn btn-info mr-2">Volver</a>
                    <input type="submit" name="anadirPaciente" class="btn btn-success" value="Añadir">
                </div>
            </form>
    </main>
</body>