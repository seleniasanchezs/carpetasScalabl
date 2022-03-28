<?php
    require('funciones.php');

    // if (!isset($_SESSION["scalabl_root_user"])) header("Location: login.php?noSession");


    // $fechas_filtrar = get_fechas_filtrar();

    $registros_testing = get_testing_acciones();
    $fecha_desde = "2022-03-11 19:22:00";
    $fecha_hasta = "2022-12-31 12:00:00";
    $visitas = get_visitas($fecha_desde, $fecha_hasta, true);
    $visitas_info = procesar_visitas($visitas);
    $acciones = get_acciones_segun_variantes($fecha_desde, $fecha_hasta, true);

    // echo "<pre>";
    // print_r($conversiones);
    // echo "</pre>";
    
    // echo "<pre>";
    // print_r($conversiones);
    // echo "</pre>";
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/0aa6304a5a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/inc/bootstrap-5/css/bootstrap.min.css">
    <link rel="stylesheet" href="/admin/leads/css/estilos.css?version=<?php echo time(); ?>">
    <link rel="icon" href="img/scalabl-icon.ico">
    <title>SCALABL</title>
</head>
<!-- card columns -->

<body>
    <h1 class="container text-center">A/B testing</h1>

    <!-- Filtrar fecha -->
    <!-- <div class="container my-3">
		<div class="row mt-5">
			<div class="col-6 text-start">
				<form action="funciones.php" method="post">
					<p>Para filtrar</p>
					<label>Fecha desde: (fecha seteada es:<?#= $fecha_desde; ?>)</label>
					<input class="form-control form-control-sm" type="datetime-local" name="fecha_desde" value="<?#= $fecha_desde; ?>" />
					<label>Fecha hasta:</label>
					<input class="form-control form-control-sm" type="datetime-local" name="fecha_hasta" value="<?#= "2022-12-31 23:59:00"; ?>" />
					<input type="submit" class="btn mt-2" name="btn_filtrar" value="Filtrar" />
				</form>
			</div>
		</div>
	</div> -->
    <!--/ Filtrar fecha -->


    <!-- resumen -->
    <div class="row justify-content-center">
        <div class="col-10 my-5">
          <b>Resumen</b><br />
          <?php procesar_info($visitas, $acciones); ?>
        </div>
    </div>
    <!--/ resumen -->
 
   <!-- <table class="table">
        <thead>
            <tr>
                <th scope="col" class="text-center">Desde dónde</th>
                <th scope="col" class="text-center">Título</th>
                <th scope="col" class="text-center">Subtítulo</th>
                <th scope="col" class="text-center">Sección Profesor</th>
                <th scope="col" class="text-center">Acción</th>
                <th scope="col" class="text-center">País</th>
                <th scope="col" class="text-center">Ip</th>
                <th scope="col" class="text-center">Fecha de registro</th>
            </tr>
        </thead>
        <tbody>
            <?#php foreach ($registros_testing as $registro) {
            ?>
                <tr class="color-fila">
                    <td class="text-center"><?#= $registro["desde_donde"]; ?></td>
                    <td class="text-center"><?#= $registro["titulo"]; ?></td>
                    <td class="text-center"><?#= $registro["subtitulo"]; ?></td>
                    <td class="text-center"><?#= $registro["seccion_profesor"]; ?></td>
                    <td class="text-center"><?#= $registro["accion"]; ?></td>
                    <td class="text-center"><?#= $registro["pais"]; ?></td>
                    <td class="text-center"><?#= $registro["ip"]; ?></td>
                    <td class="text-center"><?#php echo $registro["fecha_registro"]; ?></td>
                </tr>


            <?#php
            #}
            ?>
        </tbody> -->
    </table>


    <script src="/inc/bootstrap-5/js/bootstrap.bundle.js"></script>
    <script src="/inc/js/jquery-3.4.1.min.js"></script>
    <script src="js/leads.js"></script>
    <script src="js/mini-leads.js?version=<?= time(); ?>"></script>
</body>

</html>