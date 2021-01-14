<?php
include('includes/session.php');
include('includes/functions.php');
//Si no ha iniciado session y si el rol es admin no enviar a la pagina de inicio de session
if (!$isSignedIn || $isAdmin) {
    header("Location: ./index.php");
    exit();
}
//si se hace clic sobre el boton actualizar
if(isset($_POST["actualizarPaciente"])){
    $data = array(
        'clavePaciente' => $_POST['clavePaciente'],
        'docIdPaciente' => $_POST['docIdPaciente'],
        'emailPaciente' => $_POST['emailPaciente'],
        'telefonoPaciente' => $_POST['telefonoPaciente'],
        'rol' => $_SESSION['rol']
    );
    $query = http_build_query($data);
    $url = 'http://localhost/viernes/ut1893/viernes-care/service/pacientes.php?'.$query;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    $result = curl_exec($ch);
    
    curl_close($ch);
    
}
//buscar el paciente segun el query
if(isset($_GET["doc"]) && !empty($_GET["doc"])){
    $docPaciente = $_GET["doc"];
    $rol = $_SESSION['rol'];
    $url = 'http://localhost/viernes/ut1893/viernes-care/service/pacientes.php?docIdPaciente='.$docPaciente.'&rol='.$rol;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $json_result = json_decode($result);
    curl_close($ch);
}
else{
    header('Location: index.php');
}
include("includes/head.html");
?>
<body>
    <main class="container">
        <?php
        /*Si el rol es Rastreado podra Atualizar el paciente*/
        if ($isRastreador) {
        ?>
        <h2>Datos del paciente</h2>
            <form action="" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="clavePaciente">Clave</label>
                        <input value="<?php  echo $json_result->clavePaciente; ?>" type="text" class="form-control" name="clavePaciente" id="clavePaciente" placeholder="clave del Paciente">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="Email">Email</label>
                        <input value="<?php  echo $json_result->emailPaciente; ?>" type="email" class="form-control" name="emailPaciente" id="Email" placeholder="Email">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="DocPaciente">Documento</label>
                        <input readonly name="docIdPaciente" value="<?php  echo $json_result->docIdPaciente; ?>" type="text" class="form-control" id="DocPaciente" placeholder="Documento del paciente">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="tel">Telefono</label>
                        <input name="telefonoPaciente" value="<?php  echo $json_result->telefonoPaciente; ?>" type="number" class="form-control" id="tel" placeholder="Telefono del paciente">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="EstadoPaciente">Estado</label>
                        <input value="<?php  echo $json_result->estado; ?>" type="text" class="form-control" id="EstadoPaciente" readonly>
                    </div>
                </div>
                <div class="input-group">
                    <a href="rastreador.php" class="btn btn-info mr-2">Volver</a>
                    <input type="submit" name="actualizarPaciente" class="btn btn-success" value="Actualizar">
                </div>
            </form>
        <?php
            }
        if($isMedico){
        ?>
            <!-- era aqui Codigo html-->
        <?php
            }
        ?>
    </main>
</body>