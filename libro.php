<?php

    require('funciones.php');

    if ( !isset($_GET["id"]) ) { header("Location: index.php"); }

    $idioma = "es";
    $libro = getLibroFromUrl($_GET["id"]);

    $precio = number_format($libro["valor"], 0, ",", ".");
    $precioAlumni = $libro["valor"] - (20 * $libro["valor"]) / 100;
    $precioAlumni = number_format($precioAlumni, 0, ",", ".");
    $fechaPublicacion = date_format(new DateTime($libro["fecha"]), 'M d, Y');
    // $titulo =  $libro["titulo"];

    // $preference_id = crear_preference_id_mp($titulo, $libro["valor"], $libro["id"]);

    // string que pone el o los autores si hay más de 1 autor
    $elautor = "El autor";
    if ( strpos($libro["autor"], ",") || strpos($libro["autor"], " y ") ) {
        $elautor = "Los autores";
    }

    $banners = getBanners(0, 1, 3);

    $mensajeFranBanner = "Quiero conocer a Francisco Santolo y la Academia de Emprendimiento e Innovación de Scalabl";

    # contenido random
    $contenido_random = get_contenido_random($idioma, "books_libros", 1);

    # formulario newsletter
    $form_news = formulario_newsletter($idioma);

?>

<!DOCTYPE html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="content-language" content="es-es">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Scalabl | Colección de Libros</title>
        <meta name="description" content="<?echo substr(strip_tags($libro["sinopsis"]), 0, 100) . "..."; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="og:image" content="<?php echo "https://www.scalabl.com/books/" . $libro["imagen"]; ?>">
		<meta property="og:title" content="<?php echo $libro["titulo"]; ?>" />
        <meta property="og:description" content="<?php echo substr(strip_tags($libro["sinopsis"]), 0, 100) . "..."; ?>" />
		<link rel="icon" type="image/jpg" href="../inc/favicon/logo.jpg">
		<meta name="theme-color" content="#613b5e" />
        <link rel="stylesheet" href="../inc/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"/>
        <link rel="stylesheet" href="../books/css/estilos.css?version=<?php echo time(); ?>">
        <!-- <link rel="stylesheet" href="/books/css/estilos-mp.css?version=<?php echo time(); ?>">
        <script src="https://sdk.mercadopago.com/js/v2"></script> -->

        <?php pixel(); ?>


    </head>

    <body>

        <?php pixel_body(); ?>

        <!-- menu navegacion -->
        <div class="container-fluid">
            <?php nuevo_header("es", "SBC", null, true, null, "libros"); ?>
        </div>
        <!-- fin menu navegacion -->
        
        <?php #barra_flotante_buscando_un_cambio_form(false, false, "libros-libro");?>

        <div class="container mt-4 mb-3 mt-md-5 mb-md-5">
            <!-- fila -->
            <div class="row justify-content-center">

                <div class="col-10 col-md-8">
                    <div class="card pagina-libro-card-libro">
                        <div class="row justify-content-center no-gutters">
                            <div class="col-11 col-md-4 text-center">
                                <img data-src="../books/<?php echo $libro["imagen"]; ?>" class="pagina-libro-img-libro rounded lazyload" loading="lazy" alt="<?php echo $libro["titulo"]; ?>">
                            </div>
                            <div class="col-11 col-md-8">
                                <div class="card-body">
                                    <h1 class="card-title my-0 titulo-libro" style="line-height: 16px;"><b><?php echo $libro["titulo"]; ?></b></h1>
                                    <p class="card-text mt-2 lh-low text-muted">de <?php echo $libro["autor"]; ?></p>

                                    <?php if ( $libro["bajada"] != "" ) {
                                        ?>
                                            <p class="card-text mt-2 lh-low"><i><? echo $libro["bajada"]; ?></i></p>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- botones comprar / reservar para mobile -->
                    <div class="col-12 d-block d-md-none">
                    <?php
                        if ( $libro["stock"] > 0 ) {
                            ?>
                                <button class="btn btn-outline-success btn-sm mt-2 btn-block mx-auto" id="btnGoToComprar">COMPRAR</button>
                            <?php
                        } else {
                            ?>
                                <button class="btn btn-outline-success btn-sm btn-reservar btn-block" data-titulo="<?php echo $libro["titulo"]; ?>">RESERVAR</button>
                            <?php
                        }
                    ?>
                    </div>
                    <!-- fin botones comprar / reservar para mobile -->

                    <div class="card pagina-libro-card-descripcion">
                        <div class="card-body">
                            <p class="card-title"><h4><b>Sinopsis</b></h4></p>
                            <p class="card-text div-sinopsis mt-3 mb-0">
                                <?php echo $libro["sinopsis"]; ?>
                            </p>
                            <div id="btn-ver-mas-sinopsis" class="btn-ver-mas mt-2">Ver más</div>

                            <?php if ( $libro["opiniones"] != "" ) {
                                ?>
                                <p class="card-title mt-5"><h4><b>Opiniones</b></h4></p>
                                <p class="card-title text-secondary mt-3">
                                    <i><?php echo $libro["opiniones"]; ?></i>
                                </p>
                                <?php
                            }
                            ?>

                            <?php
                                if ( $libro["sobreautor"] != "" ) {
                                    ?>
                                        <p class="card-title mt-5"><h4><b><?php echo $elautor; ?></b></h4></p>
                                        <p class="card-text mt-3">
                                            <?php echo $libro["sobreautor"]; ?>
                                        </p>
                                    <?php
                                }
                            ?>


                            <?php if ( $libro["destacados"] != "" ) {
                                ?>
                                <p class="card-title mt-5"><h4><b>Destacados</b></h4></p>
                                <p class="card-title text-secondary mt-3">
                                    <i><?php echo $libro["destacados"]; ?></i>
                                </p>
                                <?php
                            }
                            ?>

                        </div>
                    </div>

                </div>

                <div class="col-9 col-md-4 px-3 px-md-4 pt-md-3 mb-5 mb-md-0">
                    <?php
                        if ( $libro["stock"] > 0 ) {
                            ?>
                                <h5 class="text-scalabl" id="precio" style="font-size: 20px; font-weight: bold;">ARS <?php echo $precio; ?></h5>
                                <!--<h5 class="text-scalabl">ARS<?php //echo $precioAlumni; ?> para graduados de Scalabl</h5>-->

                                <!-- código de descuento -->
                                <div class="row justify-content-center">

                                    <!-- input / botón descuento  -->
                                    <div class="col-12 col-lg-8 div-descuento mt-2 mt-lg-1">
                                        <input class="form-control form-control-sm" type="text" name="tbCodigoDescuento" id="tbCodigoDescuento" placeholder="Código de descuento" />
                                        <!-- <a href="#" class="link-generar-codigo text-muted" target="_blank"><small><u>Genera tu código de descuento</u></small></a> -->
                                        <div class="spinner-border spinner-descuento text-scalabl" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4 mt-2 mt-lg-1 div-boton-descuento">
                                        <button class="btn btn-outline-scalabl btn-sm" id="cmdValidarDescuento" data-titulo="<?php echo $libro["titulo"]; ?>" data-valor="<?php echo $libro["valor"]; ?>" data-id_libro="<?php echo $libro["id"]; ?>" type="button">Validar</button>
                                    </div>
                                    <!-- fin input / botón descuento -->

                                    <!-- mensaje descuento aplicado / no aplicado -->
                                    <div class="col-12 mt-1">
                                        <a id="descuento-ok" class="alert alert-success alert-descuento py-1">
                                            <small class="text-success">
                                                El descuento ha sido aplicado
                                            </small>
                                        </a>
                                        <a id="descuento-error" class="alert alert-danger alert-sm alert-descuento py-1"><small class="text-danger">Código de descuento inválido</small></a>
                                    </div>

                                    <!-- fin mensaje descuento aplicado / no aplicado -->

                                </div>
                                <!-- fin código de descuento -->
                                
                                <!-- btn mercado pago -->
                                <!-- <div class="in-boton-mp btn btn-outline-success btn-sm p-0 mt-1" id="cmdComprarLibro">
            
                                </div> -->
                                <a href="<?php echo $libro["link_pago"]; ?>" class="btn btn-outline-success btn-sm mt-2" id="cmdComprarLibro">COMPRAR</a>
                                <!--/ btn mercado pago -->
                            <?php
                        } else {
                            ?>
                                <button class="btn btn-outline-success btn-sm btn-reservar" data-titulo="<?php echo $libro["titulo"]; ?>">RESERVAR</button>
                            <?php
                        }
                    ?>

                        <h5 class="card-title mt-4 mb-0">Formas de envío y entrega</h5>
                        <h6 class="card-title text-muted mb-0"><small>- Envío a todo el país (a cargo del comprador)</small></h6>
                        <h6 class="card-title text-muted mb-0"><small>- Envío por Rappi o Glovo (a cargo del comprador)</small></h6>
                        <h6 class="card-title text-muted mb-0"><small>- Retiro por Recoleta o Belgrano</small></h6>


                        <h5 class="card-title mt-4 mb-0">Información bibliográfica</h5>
                        <h6 class="card-title text-muted my-0 mt-1 mb-5"><small><?php echo $libro["infobiblio"]; ?></small></h6>

                        <!-- contenido random -->
                        <?php 
                            # variable para ir contando las vueltas para mostrar los títulos
                            $seccion_random = 1;
                            foreach ( $contenido_random as $cr ) {
                                ?>
                                <div class="mt-3 contRandom__tituloSeccion d-none d-lg-block">
                                    <?php 
                                        if ( $seccion_random == 1 ) {
                                            if ( $idioma == "es" ) echo "Videos";
                                            if ( $idioma == "en" ) echo "Videos";
                                            if ( $idioma == "por" ) echo "Vídeos";
                                        }
                                        if ( $seccion_random == 2 ) {
                                            if ( $idioma == "es" ) echo "Podcasts";
                                            if ( $idioma == "en" ) echo "Podcasts";
                                            if ( $idioma == "por" ) echo "Podcasts";
                                        }
                                        if ( $seccion_random == 3 ) {
                                            if ( $idioma == "es" ) echo "Artículos";
                                            if ( $idioma == "en" ) echo "Articles";
                                            if ( $idioma == "por" ) echo "Artigos";
                                        }
                                        if ( $seccion_random == 4 ) {
                                            if ( $idioma == "es" ) echo "Prensa";
                                            if ( $idioma == "en" ) echo "Press";
                                            if ( $idioma == "por" ) echo "Imprensa";
                                        }
                                    ?>
                                </div>
                                <?php
                                foreach ( $cr as $c ) {
                                    extract($c);
                                    # si es video setear la imagen y la url de forma distinta
                                    # la url la toma del link
                                    # en los demás casos, la url es la url
                                    $url_link = $url;
                                    if ( $es_video ) {
                                        $imagen = "https://img.youtube.com/vi/" . substr($link, 32, 11) . "/mqdefault.jpg";
                                        $url_link = $url;
                                    }
                                    ?>
                                    <a href="<?= $url_link; ?>" class="link__cardContenidoRandom"> 
                                    <div class="cardContRandom">
                                        <img src="<?= $imagen; ?>" class="card-img-top" alt="<?= $titulo; ?>">
                                        <div class="card-body">
                                            <h5 class="card-title cardContRandom__titulo"><?= $titulo; ?></h5>
                                        </div>
                                    </div>
                                    </a>
                                    <?php
                                }
                                $seccion_random++;
                            }
                        ?>
                        <!-- /contenido random -->
                </div>

            </div>
            <!-- fin fila -->
        </div>

        <!-- form prueba gratuita  -->
        <!-- <?#= form_prueba_gratuita($idioma, "SBR-nota"); ?> -->
        <?#php btn_quiero_prueba_gratuita("libros-libro-bottom"); ?>
        <!-- /form prueba gratuita  -->


        <?php getFooter("es", "SBC"); ?>


        <!-- modal reservar libro -->
        <div class="modal fade" id="modalReservarLibro" tabindex="-1" role="dialog" aria-labelledby="modalReservarLibro" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header pb-2">
                        <h5 class="modal-title modalReservarLibroTitulo text-scalabl"><b>Colección de Libros de Scalabl</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <div class="modal-body modalReservarLibroBody text-center">
                    <div class="row justify-content-center">
                        <div class="col-11 resevarLibro-body-mensaje">
                            <!-- mensaje js -->
                        </div>
                    </div>
                    <div class="row justify-content-center mt-3">
                        <div class="col-5">
                            <div class="form-group mb-0 p-0">
                                <input type="text" class="form-control form-control-sm" name="tbNombre" id="tbNombre" placeholder="Nombre" />
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group mb-0 p-0">
                                <input type="email" class="form-control form-control-sm" name="tbEmail" id="tbEmail" placeholder="Email" />
                            </div>
                        </div>
                    </div>
                    <!-- mensaje validación -->
                    <div class="row justify-content-center mt-2">
                        <div class="col-8 text-center">
                            <span class="text-danger span-validar-reserva">Complete todos los campos</span>
                        </div>
                    </div>
                    <!-- fin mensaje validación -->
                </div>
                    <div class="modal-footer modalReservarLibroBotonera">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-sm btn-success btnEnviarReserva">Reservar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal reservar libro -->


        <script src="../inc/js/jquery-3.4.1.min.js"></script>
        <script src="../inc/js/popper.min.js"></script>
        <script src="../inc/js/bootstrap.min.js"></script>
        <script src="../books/js/funciones.js?version=<?php echo time(); ?>"></script>
        <script src="/inc/js/funciones.js?version=<?php echo time(); ?>"></script>

        <!-- <script>
                    //Agrega credenciales de SDK
                    const mp = new MercadoPago('APP_USR-b132ec39-473e-4d29-a900-ecfb28173756', {
                            locale: 'es-AR'
                    });

                    //Inicializa el checkout
                    mp.checkout({
                        preference: {
                            id: '<?#= $preference_id; ?>'
                        },
                        render: {
                                container: '.in-boton-mp', // Indica dónde se mostrará el botón de pago
                                label: 'COMPRAR', // Cambia el texto del botón de pago (opcional)
                        },
                        theme: {
                            elementsColor: '#5b455b'
                        }

                    });
    </script> -->

    </body>
</html>