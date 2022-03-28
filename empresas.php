<?php
require("funciones.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
} else {
    $usuario = get_perfil($_SESSION["usuario"]);

    if($usuario["tipo"] != 0){
        header("Location: index.php");
    }else {
        $super_admin = true;
    }

    $id = isset($usuario) ? $usuario['id'] : "";
    $imagen = isset($usuario) ? $usuario['imagen'] : "";
    $nombre = isset($usuario) ? $usuario['usuario'] : "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Empresas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="../admin/css/estilos.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>

<body>
    <div class="wrapper">
        <?php headerAlumni($id, $imagen, $nombre, $super_admin); ?>

        <!-- Page Content Holder -->
        <div id="content">
            <div class="container-fluid mb-4">
                <button type="button" id="sidebarCollapse" class="navbar-btn">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <div class="container-fluid">
                <h1 class="mb-4 titulo">Empresas</h1>
                <div class="container-fluid">
                    <form class="my-2 my-md-0 ">
                        <div class="form-group row">
                            <input id="tb_buscar" data-buscar="empresa" class="form-control form-control-sm input-lg barra-buscar inline-block ml-2" type="text" placeholder="Buscar" aria-label="Search">
                            <button class="btn btn-scalabl btn-sm ml-2 inline-block" id="btn_buscar">Buscar</button>
                        </div>
                        <div class="form-group row">
                            <div class="form-check form-check-inline ml-2">
                                <input class="form-check-input" type="radio" name="tipoBuscar" id="ne" value="0" checked>
                                <label class="form-check-label" for="ne">Nombre empresa</label>
                            </div>
                            <div class="form-check form-check-inline ml-2">
                                <input class="form-check-input" type="radio" name="tipoBuscar" id="na" value="1">
                                <label class="form-check-label" for="na">Nombre Alumni</label>
                            </div>
                            <div class="form-check form-check-inline ml-2">
                                <input class="form-check-input" type="radio" name="tipoBuscar" id="ind" value="2">
                                <label class="form-check-label" for="ind">Industria</label>
                            </div>
                            <div class="form-check form-check-inline ml-2">
                                <input class="form-check-input" type="radio" name="tipoBuscar" id="info" value="3">
                                <label class="form-check-label" for="info">Información</label>
                            </div>
                            <!-- <button class="btn btn-white btn-sm ml-2" id="empresas">Empresas</button>
                        <button class="btn btn-white btn-sm ml-2" id="beneficios">Beneficios</button> -->
                        </div>
                    </form>
                </div>
                <?php
                    if($usuario["tipo"] == 0){
                ?>
                    <button class="btn btn-scalabl my-0">DESCARGAR EXCEL</button>
                <?php
                    }
                ?>
                <div class="container-fluid my-5 tabla">
                    <table id="tabla" class="table table-sm table-hover">
                        <colgroup>
                            <col span="1" style="width: 5%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 15%;">
                            <col span="1" style="width: 25%;">
                            <col span="1" style="width: 10%;">
                        </colgroup>
                        <thead class="bg-scalabl text-white">
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Nombre Empresa</th>
                                <th scope="col">Nombre Alumni</th>
                                <th scope="col">Web</th>
                                <th scope="col">Industria</th>
                                <th scope="col">Información</th>
                                <th scope="col">País</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="../admin/js/funciones.js"></script>
    <script src="utils/tablefilter_all_min.js"></script>
</body>

</html>