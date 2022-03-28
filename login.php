<?php
    require("funciones.php");
    
?>

<!doctype html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Scalabl | GRADUADOS MBA UCEMA</title>
    <meta name="description" content="panel">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/inc/css/bootstrap.min.css">
</head>

<body>


    <div class="container-fluid bg-scalabl">
        <div class="row">
            <div class="col-12 text-white pt-3 pb-2">
                <h1><b>Scalabl</b> | GRADUADOS MBA UCEMA</h1>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <form action="funciones.php" method="post">
            <div class="row justify-content-center">
                <div class="col-10 col-lg-5">
                    <input type="text" name="tbUsuario" class="form-control form-control-sm"
                        placeholder="nombre de usuario" />
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-10 col-lg-5 mt-2 mt-lg-2">
                    <input type="password" name="tbPassword" class="form-control form-control-sm"
                        placeholder="password" />
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-10 col-lg-5 text-center mt-2">
                    <input type="submit" name="cmdLogin" class="btn btn-sm btn-primary" value="login" />
                </div>
                <?php if ( isset($_get["usererror"]) ) {
                    ?>
                <div class="col-10 mt-2 text-center mb-0">
                    <p class="text-center text-danger mb-0">los datos ingresados son incorrectos</p>
                </div>
                <?php
                    }
                ?>
            </div>
        </form>
    </div>

    <script src="/inc/js/jquery-3.4.1.min.js"></script>
    <script src="/inc/js/popper.min.js"></script>
    <script src="/inc/js/bootstrap.min.js"></script>    
</body>

</html>