<?php
    # NOTE: url => scalabl/books/gracias.php?status=ok&id=1
    require('funciones.php');

    if ( !isset($_GET["id"]) || !isset($_GET["status"]) ) {
        header("Location: index.php");
    } else {
        $libro = getLibroFromId($_GET["id"]);
        if($_GET["status"] == "approved"){

            $cod = substr(md5(uniqid(mt_rand(), true)) , 0, 8);
            registrarCompra($libro["id"], $cod, $_GET["valor"], $libro["titulo"]);
        }
    }
    $mensajeFranBanner = "Quiero conocer a Francisco Santolo y la Academia de Emprendimiento e Innovación de Scalabl";

?>

<!DOCTYPE html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="content-language" content="es-es">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>¡Gracias!</title>
        <meta name="description" content="Colección de libros de emprendimientos e innovación Scalabl. Los libros más importantes del mundo a nivel emprendimiento e innovación traducidos al español y con prólogo de Francisco Santolo.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:image" content="https://www.scalabl.com/resources/og-logo.jpg">
        <meta property="og:description" content="Colección de libros de emprendimientos e innovación Scalabl. Los libros más importantes del mundo a nivel emprendimiento e innovación traducidos al español y con prólogo de Francisco Santolo." />
		<meta property="og:title" content="¡Gracias!" />
		<link rel="icon" type="image/jpg" href="../inc/favicon/logo.jpg">
		<meta name="theme-color" content="#613b5e" />
        <link rel="stylesheet" href="../inc/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/estilos.css">
        <?php pixel(); ?>
    </head>

    <body>
        <?php pixel_body(); ?>
        <!-- <div class="container mt-3 mb-2 mb-md-4">
            <a class="btn-submit btn-whatsapp" href="https://api.whatsapp.com/send?phone=85297124652&text=<? echo $mensajeFranBanner; ?>" target="_blank">
                <img class="img-fluid img-banner-fran" src="../businessreview/img/banner/banner-es.png" />
            </a>
        </div> -->

        <!-- menu navegacion -->
        <header class="container-fluid header-agradecimiento">
            <?php nuevo_header("es", "SBC", null, true); ?>
        </header>
        <!-- fin menu navegacion -->

        <div class="container mt-4 mb-5 mt-md-5 mb-md-5">
            <!-- fila -->
            <div class="row justify-content-center">
                <div class="col-12 col-md-10">
                    <div class="card pagina-libro-card-libro">
                        <div class="row no-gutters justify-content-center">
                            <div class="col-10 col-lg-12 text-center">
                                <img src="<?php echo $libro["imagen"]; ?>" class="pagina-libro-img-libro mx-auto rounded" alt="<?php echo $libro["titulo"]; ?>">
                            </div>
                        </div>
                        <div class="row justify-content-center no-gutters">
                            <div class="col-12 col-md-12">
                                <?php
                                    if($_GET["status"] == "approved"){
                                ?>
                                <div class="card-body text-center mt-2">
                                    <h2 class="texto__gracias mb-lg-4 mb-0">¡Gracias!</h2>
                                    <h5 class="mb-0">Tu compra del libro <b><?php echo $libro["titulo"]; ?></b> se ha realizado con éxito</h5>

                                    <?php 
                                    if (!isset($_GET["gift"])) {
                                        ?>
                                            <h6 class="mt-3 mb-4 text-secondary">Tu código de operación es <b class="text-success"><?php echo $cod; ?></b></h6>
                                        <?php
                                    }
                                    ?>
                                    <div class="col-12 col-lg-7 mx-auto text-left">
                                        <h6 class="mt-3 card-title titulo-envios mb-0"><b>Escríbenos para coordinar el envío o el retiro</b></h6>
                                        <p class="card-title mb-0">- Envío por Rappi o Glovo (a cargo del comprador)</p>
                                        <p class="card-title mb-0">- Retiro por Recoleta o Belgrano</p>
                                    </div>
                                    <a class="btn btn-outline-success mt-3 mt-lg-4" href="https://api.whatsapp.com/send?phone=5491167099456&text=He comprado <?php echo $libro["titulo"]; ?>, mi código es <?php echo $cod; ?> quisiera coordinar envío o retiro. Gracias" target="_blank"><i class="fa fa-whatsapp mr-2"></i>Contactar</a>
                                </div>
                                <?php
                                    } else if($_GET["status"] == "error" || $_GET["status"] == "pending"){
                                ?>
                                <div class="card-body text-center my-0 pt-2">
                                    <h5 class="mb-0 text-danger">Ha ocurrido un error en la compra del libro </h5>
                                    <h5 class="card-title my-0"><b><?php echo $libro["titulo"]; ?></b></h5>
                                    <a class="btn btn-danger mt-3" href="../libros/<?php echo $libro["url_es"]; ?>">Volver</a>
                                </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fin fila -->
        </div>


        <?php getFooter("es", "SBC"); ?>


        <script src="../inc/js/jquery-3.4.1.min.js"></script>
        <script src="../inc/js/popper.min.js"></script>
        <script src="../inc/js/bootstrap.min.js"></script>
        <script src="js/funciones.js"></script>
        <script src="js/header-agradecimiento.js"></script>
    </body>
</html>