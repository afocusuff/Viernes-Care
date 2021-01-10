<?php 
//si la sesion esta iniciada se dirigira  a la pagina correspondiente
include('includes/session.php');
include('includes/functions.php');
if($isSignedIn){
    GoToPage($_SESSION['rol']);
}
include("includes/head.html");
?>

<body>
    <main class="container">
        <!-- formulario de registro-->
        
        <section>
            <form class="form-signin" action="validarUsuario.php" method="post">
                <div class="form-label-group">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Dirección electrónico" required autofocus="">
                    <label for="email">Email</label>
                </div>

                <div class="form-label-group">
                    <input type="password" id="password" name="pass" class="form-control" placeholder="Contraseña" required="">
                    <label for="password">Contraseña</label>
                </div>

                <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Acceder</button>
                <p class="mt-5 mb-3 text-muted text-center">© <?php echo date('y'); ?></p>
            </form>
        </section>
    </main>
</body>

</html>