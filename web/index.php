<?php
//si la sesion esta iniciada se dirigira  a la pagina correspondiente
include('includes/session.php');
include('includes/functions.php');
if ($isSignedIn) {
    GoToPage($_SESSION['rol']);
}
include("includes/head.php");
?>

<body class="text-center align-items-center justify-content-center" style="background-image:url('img/bg-care.jpg'); padding-top: 40px;">
    <main class="container">
        <!-- formulario de registro-->
        <form class="form-signin" action="validarUsuario.php" method="post">
            <img class="mb-4" src="img/logo.png" alt="" width="80" height="80">
            <h1 class="h3 mb-3 font-weight-bold text-primary">VIERNES-CARE</h1>
            <label for="email" class="sr-only">Email address</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                </div>
                <input type="email" id="email" name="email" class="form-control mb-0" placeholder="Dirección electrónico" required autofocus="">
            </div>

            <label for="password" class="sr-only">Contraseña</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                </div>
                <input type="password" id="password" name="pass" class="form-control mb-0" placeholder="Contraseña" required="">
            </div>
            
            <div class="checkbox mb-3 text-left text-white">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Acceder</button>
            <p class="mt-5 mb-3 text-muted text-center">© <?php echo date('Y'); ?></p>
        </form>
    </main>
</body>

</html>