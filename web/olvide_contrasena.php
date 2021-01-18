<?php
include('includes/session.php');
include("./includes/_imports.php");
include('includes/functions.php');
include("includes/head.php");
?>

<body class="text-center align-items-center justify-content-center" style="background-image:url('img/bg-care.jpg'); padding-top: 40px;">
    <main class="container">
        <!-- formulario de registro-->
        <form class="form-signin" action="validarEmail.php" method="post">
            <?php if(!empty($_GET['error'])){
                    echo "<div class='alert alert-danger' role='alert'>
                        $_GET[error]
                    </div>";
                }
                if(!empty($_GET['success'])){
                    echo "<div class='alert alert-success' role='alert'>
                        $_GET[success]
                    </div>";
                }
            ?>
            <img class="mb-4" src="img/logo.png" alt="" width="80" height="80">
            <h1 class="h3 mb-3 font-weight-bold text-primary">VIERNES-CARE</h1>
            <label for="email" class="sr-only">Email address</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                </div>
                <input type="email" id="email" name="email" class="form-control mb-0" placeholder="Dirección electrónico" required autofocus="">
            </div>
            <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Restablecer Contraseña</button>
            <p class="mt-5 mb-3 text-muted text-center">© <?php echo date('Y'); ?></p>
        </form>
    </main>
</body>

</html>