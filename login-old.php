<?php

    require("funciones.php");

    if (isset($_SESSION["usuario"]) ) {
        header("Location: index.php");
    }

?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="content-language" content="es-es">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Scalabl | Login</title>
    <meta name="description" content="Login">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#5b455b" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../admin/css/estilos.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

</head>

<body>

    <nav class="navbar bg-scalabl">
        <a class="navbar-brand text-white">
            <b>Scalabl</b> | Admin
        </a>
    </nav>
    <div class="container-custom d-flex flex-column py-5 bg-white">
        <img src="img/logo/logo.png" width="180px" alt="">
        <form action="funciones.php" method="post">
            <div class="row d-flex flex-column align-self-center align-items-center justify-content-center">
                <div class="col-10 col-lg-5 my-2">
                    <label for="usuario">Usuario</label>
                    <input id="usuario" type="text" name="tbUsuario" class="form-control form-control-sm" placeholder="Nombre de usuario" />
                </div>
                <div class="col-10 col-lg-5 my-2">
                    <label for="pass">Contraseña</label>
                    <input id="pass" type="password" name="tbPassword" class="form-control form-control-sm" placeholder="Password" autocomplete="on"/>
                </div>
                <div class="col-10 col-lg-5 text-center mt-4">
                    <input type="submit" name="cmdLogin" class="btn btn-sm btn-scalabl py-2 px-4" value="Ingresar" />
                </div>
                <?php if (isset($_GET["userError"])) {
                ?>
                    <div class="col-10 mt-2 text-center mb-0">
                        <p class="text-center text-danger mb-0">Los datos ingresados son incorrectos</p>
                    </div>
                <?php
                }
                ?>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>