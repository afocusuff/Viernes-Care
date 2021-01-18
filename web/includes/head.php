<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Viernes Care</title>
    <script src="https://kit.fontawesome.com/dfe4edbd6e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/main.css" />
    <?php
    //Esta parte de codigo solo se aparecera si se ha iniciado session 
        if ($isSignedIn) { ?> 
            <link href="css/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
            <script src="js/jquery/jquery.min.js"></script>
            <script src="js/bootstrap/bootstrap.bundle.min.js"></script>
            <script src="js/datatables/jquery.dataTables.min.js"></script>
            <script src="js/datatables/dataTables.bootstrap4.min.js"></script>
            <script src="js/datatables/datatables.js"></script>
    <?php } ?>

</head>
