<?php include("includes/head.html");?>

<body>
    <main>
        <section>
            <a href="altaPaciente.php" class="btn btn-primary">Dar de Alta a Paciente</a>
            <h2>Buscar Paciente</h2>
                <form class="form-inline my-lg-0 w-100" action="editarPaciente.php" method="get">
                    <div class="form-group">
                        <div class="col-11 pr-2">
                            <input name="doc" id="search" class="form-control w-100" type="search" autocomplete="off" placeholder="EL documento del paciente" aria-label="Search">
                        </div>
                        <div class="col-1 pl-0">
                            <button class="btn btn-outline-success my-sm-0" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
        </section>
    </main>
</body>
</html>