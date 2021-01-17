<?php
include('includes/session.php');

//Si no hay session se redirege a la pagina de incio session
if (!$isSignedIn) {
    header("Location: ./index.php");
    exit();
}

//Si no es Rastreador si manda una pagina de acceso denegado 403
if (!$isRastreador) {
    header("HTTP/1.1 403 Forbidden");
    exit();
}

//si llega hasta aquí es que hay session y es rastreador.
//Entonces hacemos una llamada al api para traer todos los pacientes
//hacemos uso de function file_get_contents()

//
$url = 'http://localhost/viernes/ut1893/viernes-care/service/pacientes.php?rol=rastreador';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    $result = curl_exec($ch);
    $json_result = json_decode($result);
    curl_close($ch);
//incluyer html head
include("includes/head.php");
?>

<body>
    
    <?php
        //incluyer cabecera
        include("includes/header.php");
    ?>
    <main class="container mt-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center"><h5 class="m-0 font-weight-bold text-primary">Pacientes</h5></div>
                    <div class="col-md-6 text-right"><a class="btn btn-info" href="altaPaciente.php"><i class="fas fa-plus-circle"></i> Alta Nueva</a></div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>
                                    Correo Electronico
                                </th>
                                <th>
                                    Telefono
                                </th>
                                <th>
                                    Documento
                                </th>
                                <th>
                                    Estado
                                </th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tfoot>
                        <tr>
                                <th>
                                    Correo Electronico
                                </th>
                                <th>
                                    Telefono
                                </th>
                                <th>
                                    Documento
                                </th>
                                <th>
                                    Estado
                                </th>
                                <th>Acción</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php 
                                foreach($json_result as $item){
                                    echo "<tr>";
                                    echo "<td>$item->emailPaciente</td>
                                        <td>$item->telefonoPaciente</td>
                                        <td>$item->docIdPaciente</td>
                                        <td>$item->estado</td>";
                                    echo "<td>
                                    <a class='btn btn-warning' href='editarPaciente.php?doc=$item->docIdPaciente'><i class='fas fa-edit'></i> Editar</a> 
                                    
                                    </td>";
                                    echo "</tr>";
                                }
                            ?>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>

</html>