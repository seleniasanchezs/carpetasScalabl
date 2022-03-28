<?php
    require "funciones.php";

    $idioma = "en";

    $alianza = false;
    $curso_descuento = true;


    # nombre y número de los cursos actuales
    $ediciones = get_ediciones();
    $edicion_es =  $ediciones[0]["detalle"] . " " . $ediciones[0]["numero"];
    $edicion_en =  $ediciones[1]["detalle"] . " " . $ediciones[1]["numero"];
    $edicion_pt =  $ediciones[2]["detalle"] . " " . $ediciones[2]["numero"];
    $nombre_curso = $idioma == "es" ? $edicion_es : ($idioma == "en" ? $edicion_en : $edicion_pt);

    $pais = get_pais();
    //$pais = "Argentina";
    
    # variables de pais para mostrar los valores
    $is_arg = false;
    $is_mex = false;
    $is_spain = false;
    $is_otro = false;
    $is_colombia = false;
    $is_peru = false;
    $is_chile = false;
    $is_paraguay = false;

    # condicional de país
    if ($pais == "Argentina") {
        $is_arg = true;
    } else if ($pais == "Mexico") {
        $is_mex = true;
    } else  if ($pais == "Spain") {
        $is_spain = true;
    } else if ($pais == "Colombia") {
        $is_colombia = true;
    } else if ($pais == "Peru") {
        $is_peru = true;
    } else if ($pais == "Chile") {
        $is_chile = true;
    } else if ($pais == "Paraguay") {
        $is_paraguay = true;
    } else {
        $is_otro = true;
    }

    # valores del curso 100%
    $valor_arg = 42500;
    $valor_euro = 300;
    $valor_dolar = 350;
    $valor_libras = 220;
    $valor_mex = 6950;
    $valor_colombia = 1350000;
    $valor_peru = 1400;
    $valor_chile = 270000;
    $valor_paraguay = 2400000;
    # valores curso descuento 20%
    $valor_arg_descuento = $curso_descuento ? 34000 : 42500;
    $valor_euro_descuento = $curso_descuento ? 240 : 300;
    $valor_dolar_descuento = $curso_descuento ? 280 : 350;
    $valor_mex_descuento = $curso_descuento ? 5560 : 6950;
    $valor_colombia_descuento = 1080000;
    $valor_peru_descuento = 1120;
    $valor_chile_descuento = 216000;
    $valor_paraguay_descuento = 1920000;
    $plataforma = "";
    $currency = "";

    # poner el valor con la moneda: ARS 27.500 | US$ 250 | EUR 200
    # según geo
    $link_mp = "";
    $id_stripe = "";
    $preference_id = "";
    $valor_curso_full = 0;
    $valor_curso = 0;
    if ($is_arg) {
        $valor_curso_full = $valor_arg;
        $valor_curso = $curso_descuento ? $valor_arg_descuento : $valor_arg;
        $string_valor = "ARS " . number_format($valor_arg, 0, "", ".");
        $string_valor_descuento = "ARS " . number_format($valor_arg_descuento, 0, "", ".");
        # plataforma
        $plataforma = "Podrás acceder hasta 6 cuotas sin interés.";
        $valor_cuota_sin_interes = "Pay in 3 <b>interest-free</b> installments,<br> or up to 12 monthly payments";
        $currency = "ars";
        // $preference_id = crear_preference_id_mp($valor_curso, $nombre_curso, "sin alianza");
        #$link_mp = crear_link_mp($valor_curso, $nombre_curso);

        # valores para link encriptados
        $valor_curso_full_enc = urlencode(base64_encode($valor_curso_full));
        $valor_curso_enc = urlencode(base64_encode($valor_curso));
        $alianza_enc = $alianza ? urlencode(base64_encode($alianza["alianza"])) : urlencode(base64_encode("no"));
        $time_enc = urlencode(base64_encode(time() + 60 * 60));
        $url_enc = urlencode(base64_encode($_SERVER['REQUEST_URI']));
        $link_mp = "/inc/pagos/index.php?valor_curso_full=$valor_curso_full_enc&valor_curso=$valor_curso_enc&alianza=$alianza_enc&pagogc=$time_enc&url=$url_enc";
        $img_medio_pago = "/entrenamientos/emprendimientos-e-innovacion/img/pagos/Tarjetas-2.png";
        $clase_tamanio_img_pago = "tamanio-tarjetas";
        $clase_correr_logo_mp = "contenedor-pagos-oferta-arg";
        $clase_margen_logo_mp_oferta = "contenedor-pagos-oferta-arg-margen";
    } else if ($is_mex) {
        $valor_curso = $curso_descuento ? $valor_mex_descuento : $valor_mex;
        $string_valor = "MXN " . number_format($valor_mex, 0, "", ",");
        $string_valor_descuento = "MXN " . number_format($valor_mex_descuento, 0, "", ",");
        $plataforma = "Stripe.";
        $currency = "mxn";
        $valor_cuota_sin_interes = "";
        $id_stripe = "btn_modal_stripe";
        $img_medio_pago = "/entrenamientos/emprendimientos-e-innovacion/img/pagos/stripe-3.png";
        $clase_tamanio_img_pago = "tamanio-stripe";
        $clase_correr_logo_mp = "";
        $clase_margen_logo_mp_oferta = "";
    } else if ($is_spain) {
        $valor_curso = $curso_descuento ? $valor_euro_descuento : $valor_euro;
        $string_valor = "EUR " . number_format($valor_euro, 0, "", ".");
        $string_valor_descuento = "EUR " . number_format($valor_euro_descuento, 0, "", ".");
        $plataforma = "Stripe.";
        $currency = "eur";
        $valor_cuota_sin_interes = "";
        $id_stripe = "btn_modal_stripe";
        $img_medio_pago = "/entrenamientos/emprendimientos-e-innovacion/img/pagos/stripe-3.png";
        $clase_tamanio_img_pago = "tamanio-stripe";
        $clase_correr_logo_mp = "";
        $clase_margen_logo_mp_oferta = "";
    } else if ($is_otro) {
        $valor_curso = $curso_descuento ? $valor_dolar_descuento : $valor_dolar;
        $string_valor = "USD " . number_format($valor_dolar, 0, "", ".");
        $string_valor_descuento = "USD " . number_format($valor_dolar_descuento, 0, "", ".");
        $plataforma = "Stripe.";
        $currency = "usd";
        $valor_cuota_sin_interes = "";
        $id_stripe = "btn_modal_stripe";
        $img_medio_pago = "/entrenamientos/emprendimientos-e-innovacion/img/pagos/stripe-3.png";
        $clase_tamanio_img_pago = "tamanio-stripe";
        $clase_correr_logo_mp = "";
        $clase_margen_logo_mp_oferta = "";
    } else if ($is_colombia) {
        $valor_curso = $curso_descuento ? $valor_colombia_descuento : $valor_colombia;
        $string_valor = "COP $ " . number_format($valor_colombia, 0, "", ".");
        $string_valor_descuento = "COP $ " . number_format($valor_colombia_descuento, 0, "", ".");
        $plataforma = "Stripe.";
        $currency = "cop";
        $valor_cuota_sin_interes = "";
        $id_stripe = "btn_modal_stripe";
        $img_medio_pago = "/entrenamientos/emprendimientos-e-innovacion/img/pagos/stripe-3.png";
        $clase_tamanio_img_pago = "tamanio-stripe";
        $clase_correr_logo_mp = "";
        $clase_margen_logo_mp_oferta = "";
    } else if ($is_peru) {
        $valor_curso = $curso_descuento ? $valor_peru_descuento : $valor_peru;
        $string_valor = "S/ " . number_format($valor_peru, 0, "", ".");
        $string_valor_descuento = "S/ " . number_format($valor_peru_descuento, 0, "", ".");
        $plataforma = "Stripe.";
        $currency = "pen";
        $valor_cuota_sin_interes = "";
        $id_stripe = "btn_modal_stripe";
        $img_medio_pago = "/entrenamientos/emprendimientos-e-innovacion/img/pagos/stripe-3.png";
        $clase_tamanio_img_pago = "tamanio-stripe";
        $clase_correr_logo_mp = "";
        $clase_margen_logo_mp_oferta = "";
    } else if ($is_chile) {
        $valor_curso = $curso_descuento ? $valor_chile_descuento : $valor_chile;
        $string_valor = "CLP " . number_format($valor_chile, 0, "", ".");
        $string_valor_descuento = "CLP " . number_format($valor_chile_descuento, 0, "", ".");
        $plataforma = "Stripe.";
        $currency = "chl";
        $valor_cuota_sin_interes = "";
        $link_mp = "https://mpago.li/1hqnfAa";
        $img_medio_pago = "/entrenamientos/emprendimientos-e-innovacion/img/pagos/mercadopago.png";
        $clase_tamanio_img_pago = "tamanio-mp";
        $clase_correr_logo_mp = "";
        $clase_margen_logo_mp_oferta = "";
    } else if ($is_paraguay) {
        $valor_curso = $curso_descuento ? $valor_paraguay_descuento : $valor_paraguay;
        $string_valor = "Gs. " . number_format($valor_paraguay, 0, "", ".");
        $string_valor_descuento = "Gs. " . number_format($valor_paraguay_descuento, 0, "", ".");
        $plataforma = "Stripe.";
        $currency = "pyg";
        $valor_cuota_sin_interes = "";
        $id_stripe = "btn_modal_stripe";
        $img_medio_pago = "/entrenamientos/emprendimientos-e-innovacion/img/pagos/stripe-3.png";
        $clase_tamanio_img_pago = "tamanio-stripe";
        $clase_correr_logo_mp = "";
        $clase_margen_logo_mp_oferta = "";
    }

    $string_descuento = $curso_descuento ? " 20% dto." : "";

    # stripe
    # valor stripe
    $valor_curso_stripe = $valor_curso * 100;

    #ocultar seccion columna 2
    $ocultar = false;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/inc/bootstrap-5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    <link rel="stylesheet" href="/freetrial/css/estilos.css?version=<?php echo time(); ?>">
    <link rel="icon" type="image/jpg" href="/inc/favicon/logo.jpg">
    <meta property="og:title" content="Business Models" />
    <meta property="og:description" content="The business model describes what value we deliver to the customers and stakeholders, how we extract part of that value and how we make it all possible. Additionally, it outlines the main economic, financial and risk indicators. Our methodology provides answers to the questions of how to design and implement sustainable, scalable and repeatable business models that avoid the common pitfalls of unnecessary financial and economic risks." />
    <meta property="og:url" content="https://scalabl.com/freetrial.php">
    <meta property="og:image" content="https://www.scalabl.com/freetrial/img/og/logo-redes.jpg">
    <meta name="description" content="The business model describes what value we deliver to the customers and stakeholders, how we extract part of that value and how we make it all possible. Additionally, it outlines the main economic, financial and risk indicators. Our methodology provides answers to the questions of how to design and implement sustainable, scalable and repeatable business models that avoid the common pitfalls of unnecessary financial and economic risks." />
    <meta name="theme-color" content="#613b5e" />
    <title>Business Models</title>
    <script src="https://js.stripe.com/v3/"></script>
    <?php pixel(); ?>
</head>

<body>
    <?php pixel_body(); ?>
    <!-- Header -->
    <header class="container-fluid p-0">
        <!-- Nav - Logo Curso Online -->
        <nav class="navbar nav-border navbar-expand-lg">
            <div class="container d-lg-flex px-4 px-lg-0">
                <div class="navbar-brand navbar-brand-responsive">
                    <a href="https://scalabl.com/course/" target="_blank">
                        <img class="ps-lg-5" src="/inc/img/logo-SCO-blanco-en.png" alt="Logo Curso Scalabl">
                    </a>
                </div>
            </div>
        </nav>
        <!-- / Nav - Logo Curso Online -->
    </header>
    <!-- / Header -->

    <!-- contenedor entero -->
    <section class="container container-estrecho">
        <div>
            <!-- Fila -->
            <div class="row">
                <!-- Columna #1 desktop - tablet - mobile -->
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 columna-1 mt-3 px-4 px-lg-0 col-1-mobile">
                    <div>
                        <h1>
                            <b>Business models, in depth</b>
                        </h1>

                    </div>

                    <!-- Contenedor -> contenido prueba gratis -->
                    <div class="py-3 px-0 contenedor_texto">
                        <p>When thinking about starting a business, entrepreneurs are typically faced with the imperative of <b>a groundbreaking idea</b> 💥💡. Then comes the hype about the imagined product or service and only after that does the customer come into the picture, often in an abstract, narrow consideration focused on their purchasing power.</p>
                        <p>The more experienced entrepreneurs, as well as leading authors in the field, focus instead on <b>the product-customer fit</b>. This is an undoubtedly necessary but not sufficient consideration.</p>
                        <div class="contenedor_conBorde  my-3  ps-2 ms-lg-3">
                            <p class="my-3">You could have the best product-market fit and yet set out on a project which has no chance to succeed because you failed in selecting the right channels, client relationships, revenue model, cost structure, resource allocation, or because you incurred unnecessary risks.</p>
                        </div>

                        <!-- Contenedor video -->
                        <div class="contenedor_video">
                            <!-- Contenedor Iframe -->
                            <div class="contendor_iframe d-flex align-items-center">
                                <iframe title="vimeo-player" src="https://player.vimeo.com/video/618008719?h=0cb7f86d08" frameborder="0" allowfullscreen></iframe>
                            </div>
                            <!-- / Contenedor Iframe -->
                        </div>
                        <!-- /Contenedor video -->

                       <!-- Contenedor banner desktop -->
                       <div class="contenedor_banner d-none d-lg-block my-4">
                            <a href="https://scalabl.com/course/?utm_source=freetrial&utm_medium=banners" target="_blank"> 
                                <img src="/freetrial/img/banners/banner-enroll-descuento-rosa.gif" alt="Banner enroll now, get a 20% discount">
                            </a>
                        </div>
                        <!-- Contenedor banner desktop-->

                        <!-- Contenedor banner mobile -->
                        <div class="contenedor_banner d-block d-lg-none my-2">
                            <a href="https://scalabl.com/course/?utm_source=freetrial&utm_medium=banners" target="_blank">
                                <img src="/freetrial/img/banners/banner-enroll-descuento-rosa-mobile.jpg" alt="Banner enroll now, get a 20% discount">
                            </a>
                        </div>
                        <!-- Contenedor banner mobile-->

                        <!-- Contenedor texto -->
                        <div class="mt-4 contenedor_texto">
                            <p>The business model is more important than the idea or the product/service – even though the entrepreneur usually falls in love with the latter 🤷. </p>
                            <div class="contenedor_conBorde  my-3  ps-2 ms-lg-3">
                                <p class="my-3">The focus should be put on <b>satisfying a need at lower cost or with improved performance to beat existing market alternatives</b> – or both, as is the case of the “blue ocean” strategy. </p>
                            </div>
                            <p>Let's take a look at Netflix and Blockbuster, two clarifying examples of disruption achieved by implementing changes in the business model or rolling out a new one.</p>
                        </div>

                        <!--/ Contenedor texto -->

                        <!-- Contenedor video -->
                        <div class="contenedor_video">
                            <div class="contendor_iframe d-flex align-items-center">
                                <iframe title="vimeo-player" src="https://player.vimeo.com/video/617138802?h=7500cdf4c0" frameborder="0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <!-- / Contenedor video -->

                        <!-- Compartir solo mobile  -->
                        <div class="columna-2-mobile position-relative d-xl-none d-lg-none d-md-none d-block mt-2">
                            <div class="contenedor_compartir d-flex  align-items-center mt-4">
                                <button type="button" class="btn_compartir d-flex justify-content-center align-items-center py-2"  data-bs-toggle="modal" data-bs-target="#popUpCompartir">
                                   <span class="me-3">We’re all about knowledge sharing. Give your friends a <span class="color-lima">free 7-day trial</span> </span><img class="me-3" src="/freetrial/img/iconos/compartir.png" alt="Icono compartir">
                                </button>
                            </div>
                        </div>
                        <!-- Compartir solo mobile  -->

                        <!-- Contenedor texto -->
                        <div class="mt-4 contenedor_texto">
                            <div class="contenedor_conBorde  my-3  ps-2 ms-lg-3">
                                <p class="my-3">In the future, companies will only thrive if they are focused on <b>a dynamic business model</b>, unconstrained by the limits of a certain industry, product or service. </p>
                            </div>
                            <p> Hit the “Next Unit” button below to move forward to the next step of our methodology, where we get down to <b>the nitty-gritty of model testing and validation</b>.</p>
                        </div>
                        <!--/ Contenedor texto -->

                        <!-- Contenedor consultas / siguiente unidad / barra unidades -->
                        <div class="contenedor_consultas-unidades-barra  px-0 px-lg-4" id="contenedor_consultas-altura">
                            <!-- Contenedor barra unidades -->
                            <div class="d-flex align-items-center mt-5">
                                <a href="https://scalabl.com/freetrial/purposeandstrategy">
                                    <img src="/freetrial/img/iconos/prev.png" alt="Ir a la anterior unidad">
                                </a>
                                <!-- Unidades desktop -->
                                <div class="barra_unidades position-relative d-none d-lg-block d-xl-block">
                                    <!-- barra -->
                                    <div class="item_unidad_1 item_unidades position-absolute d-flex flex-column justify-content-center align-items-center">
                                        <img src="/freetrial/img/iconos/icono-desbloqueado.png" alt="Unidad realizada">
                                        <h2 class="mt-3 text-center">Unit 3</h2>
                                        <p class="text-center">Purpose and strategy</p>
                                    </div>
                                    <div class="item_unidad_2 item_unidades position-absolute d-flex flex-column justify-content-center align-items-center">
                                        <img src="/freetrial/img/iconos/icono-en-curso.png" alt="Unidad realizada">
                                        <h2 class="mt-3 text-center">Unit 4</h2>
                                        <p class="text-center">Business models</p>
                                    </div>
                                    <div class="item_unidad_3 item_unidades position-absolute d-flex flex-column justify-content-center align-items-center">
                                        <img src="/freetrial/img/iconos/icono-bloqueado.png" alt="Unidad desbloqueada">
                                        <h2 class="mt-3 text-center">Unit 5</h2>
                                        <p class="text-center">Find your customers</p>
                                    </div>
                                    <div class="item_unidad_4 item_unidades position-absolute d-flex flex-column justify-content-center align-items-center">
                                        <img src="/freetrial/img/iconos/icono-bloqueado.png" alt="Unidad bloqueada">
                                        <h2 class="mt-3 text-center">Unit 6</h2>
                                        <p class="text-center">Your customer as co-creator</p>
                                    </div>
                                </div>
                                <!--/ Unidades desktop -->

                                <!-- Unidades mobile -->
                                <div class="barra_unidades barra_unidadesMobile position-relative d-block d-lg-none d-xl-none">
                                    <!-- barra -->
                                    <div class="item_unidad_1 item_unidades position-absolute d-flex flex-column justify-content-center align-items-center">
                                        <img src="/freetrial/img/iconos/icono-desbloqueado.png" alt="Unidad realizada">
                                        <h2 class="mt-3 mb-1 text-center">Unit 3</h2>
                                        <p class="text-center">Purpose and strategy</p>
                                    </div>
                                    <div class="item_unidad_2 item_unidades position-absolute d-flex flex-column justify-content-center align-items-center">
                                        <img src="/freetrial/img/iconos/icono-bloqueado.png" alt="Unidad bloqueada">
                                        <h2 class="mt-3 mb-1 text-center">Unit 5</h2>
                                        <p class="text-center">Find your customers</p>
                                    </div>
                                </div>
                                <!-- Unidades mobile -->
                                <a href="https://scalabl.com/freetrial/probleminterview">
                                    <img src="/freetrial/img/iconos/next-2.png" alt="Ir a la siguiente unidad">
                                </a>
                            </div>
                            <!--/ Contenedor barra unidades -->
                            <!-- Contenedor siguiente unidad -->
                            <div class="contendor_unidades d-flex justify-content-between align-items-center">
                                <!-- Desktop -->
                                <div class="dropdown d-none d-lg-block d-md-block d-xl-block">
                                    <button type="button" class="btn_anteriorUnidad btn_unidad dropdown-toggle py-2 px-2 px-lg-3" id="dropdownUnidadPrevia" data-bs-toggle="dropdown" aria-expanded="false"> Previous Unit </button>
                                    <ul class="dropdown-menu text-center p-0" aria-labelledby="dropdownUnidadPrevia">
                                        <li><a class="dropdown-item item-curso borde-item" href="https://scalabl.com/course/" target="_blank">+info about the course</a></li>
                                        <li><a class="dropdown-item py-2" href="https://scalabl.com/freetrial/purposeandstrategy">Previous</a></li>
                                    </ul>
                                </div>

                                <div class="dropdown d-none d-lg-block d-md-block d-xl-block">
                                    <button type="button" class="btn_siguienteUnidad btn_unidad dropdown-toggle py-2 px-2 px-lg-3" id="dropdownSiguienteUnidad" data-bs-toggle="dropdown" aria-expanded="false">Next Unit </button>
                                    <ul class="dropdown-menu text-center p-0" aria-labelledby="dropdownSiguienteUnidad">
                                        <li><a class="dropdown-item item-curso borde-item" href="https://scalabl.com/course/" target="_blank">Ready to enroll?</a></li>
                                        <li><a class="dropdown-item py-2" href="https://scalabl.com/freetrial/probleminterview">Next</a></li>
                                    </ul>
                                </div>
                                <!--/ Desktop -->
                                <!-- Mobile -->
                                <div class="contendor_unidades d-flex justify-content-between align-items-center d-block d-lg-none d-md-none d-xl-none">
                                    <a href="https://scalabl.com/freetrial/purposeandstrategy">
                                        <button class="btn_anteriorUnidad btn_unidad py-2 px-2 px-lg-3 me-2"> <b> Previous</b></button>
                                    </a>
                                    <a href="https://scalabl.com/freetrial/probleminterview">
                                        <button class="btn_siguienteUnidad btn_unidad py-2 px-2 px-lg-3"><b>Next </b> </button>
                                    </a>
                                </div>
                                <!-- / Mobile -->
                            </div>
                            <!--/ Contenedor siguiente unidad -->
                        </div>
                        <!--/ Contenedor consultas / siguiente unidad / barra unidades -->
                        <!-- Contenedor banner dto + inscribite-->

                        <!-- Contenedor banner desktop -->
                        <div class="contenedor_banner d-none d-lg-block my-4">
                            <a href="https://scalabl.com/course/?utm_source=freetrial&utm_medium=banners" target="_blank"> 
                                <img src="/freetrial/img/banners/banner-looking-future.gif" alt="Banner enroll now, get a 20% discount">
                            </a>
                        </div>
                        <!-- Contenedor banner desktop-->

                        <!-- Contenedor banner mobile -->
                        <div class="contenedor_banner d-block d-lg-none my-2">
                            <a href="https://scalabl.com/course/?utm_source=freetrial&utm_medium=banners" target="_blank">
                                <img src="/freetrial/img/banners/banner-looking-future-mobile.jpg" alt="Banner enroll now, get a 20% discount">
                            </a>
                        </div>
                        <!-- Contenedor banner mobile-->
                        
                        <div class="mt-4 contenedor-inscribite px-3">
                            <p class="mb-1 pt-2"><b>When you enroll in the full course you’ll get access to</b></p>
                            <ul class="pe-1 list-unstyled">
                                <li class="mb-1"><i class="fas fa-arrow-right me-2"></i> The <b>verified track</b> featuring <b>120+ videos, exercises and reading materials</b></li>
                                <li class="mb-1"><i class="fas fa-arrow-right me-2"></i> Scheduled <b>Zoom meet-ups</b> with your classmates, your instructor Francisco and members of the Scalabl team</li>
                                <li class="mb-1"><i class="fas fa-arrow-right me-2"></i> Your cohort’s communication channels on popular messaging and social media platforms – <b>intensive networking practice</b> and opportunities for collaboration from day one through the end of the course and beyond!</li>
                                <li class="mb-1"><i class="fas fa-arrow-right me-2"></i> <b>Lifetime membership to the Scalabl Global Community</b>, a horizontal network of 1500+ graduates from 50+ countries – founders, owners and talented business professionals in almost every industry. Curious? Discover more about them here.</li>
                            </ul>
                            <!-- Get it touch -->
                            <div class="contenedor_texto">
                                <p class="mb-1"><b>— Anything we can help you with? 🤙 Get in touch with our team —</b></p>
                                <p><a href="mailto:info@scalabl.com" target="_blank">📧 Email</a> / <a href="https://api.whatsapp.com/send?phone=5491169315560&text=Hi,%20I%20signed%20up%20for%20the%20free%20trial%20of%20Scalabl%E2%80%99s%20Online%20Course%20in%20Entrepreneurship%20and%20Innovation%20and%20would%20like%20to%20know%20more%20about%20the%20full%20course." target="_blank">📲 Whatsapp</a> <span class="d-block pt-2"><em>We normally respond in a few hours</em></span></p>
                            </div>
                            <!--/ Get it touch -->
                        </div>
                        <!-- /Contenedor banner dto + Inscribirte -->
                    </div>
                    <!-- Contenedor contenido prueba gratis-->
                </div>
                <!-- / Columna #1 desktop - tablet - mobile -->


            <!-- Columna #2 solo desktop -->
            <?#php get_col_2_desktop($curso_descuento, $string_valor, $string_descuento, $is_arg, $is_chile, $id_stripe, $link_mp, $clase_tamanio_img_pago, $valor_cuota_sin_interes, $img_medio_pago, $string_valor_descuento, $ocultar, $gif); ?>
            <!-- / Columna #2 solo desktop -->

            <!-- / Columna #2 mobile -->
            <div class="columna-2-mobile columna-pop-up d-xl-none d-lg-none d-md-none d-block p-0" id="columna_2_mobile">
                <!-- Contenedor accede al curso -->
                <div class="d-flex justify-content-center align-items-center contendor_titulo-popUp mb-0" data-bs-toggle="modal" data-bs-target="#popUpMasInfo">
                    <h2 class="text-center my-4 me-3">Read more about <span class="d-block"><b> the full course</b></span></h2>
                    <i class="fas fa-angle-double-up icono-popup" id="icono_popUp"></i>
                </div>
                <!--/ Contenedor accede al curso -->
            </div>
            <!-- / Columna #2 mobile -->
            </div>
        </div>
        <!-- / Fila -->
    </section>
    <!--/ contenedor entero -->

    <!-- Footer -->
    <footer>
        <!-- <ul>
            <li><a href="https://www.instagram.com/scalabl/" target="_blank"><i class="fab fa-instagram"></i></a></li>
            <li class="ms-2"><a href="https://www.linkedin.com/company/scalabl/mycompany/" target="_blank"><i class="fab fa-linkedin"></i></a></li>
        </ul> -->
        <div class="d-flex flex-column pb-2">
            <p class="mt-2 mb-1">© 2021 Scalabl All rights reserved</p>
            <a class="footer-en__termycond" data-bs-toggle="modal" data-bs-target="#modalTerminosCondiciones">Terms & Conditions</a>
            <a class="footer-en__termycond" data-bs-toggle="modal" data-bs-target="#modalTerminosCondiciones">Privacy Policy</a>
        </div>
    </footer>
    <!--/ Footer -->

    <!-- Modal mas info -->
    <div class="modal fade" id="popUpMasInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-body text-center p-0 d-flex flex-column position-relative">
                    <button type="button" class="close position-absolute" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <a href="https://scalabl.com/course/" target="_blank">
                        <div class="contendedor_accederCurso py-3 contendedor_accederCursoMobile d-flex flex-column justify-content-center align-items-center p-2 mt-0">
                            <img class="img-diploma" src="/freetrial/img/diplomas/diploma.png" alt="Diploma Curso Scalabl">
                            <ul class="p-0 mt-4 text-start">
                                <li class="mb-2 ps-1 d-flex"><img class="img_iconList pe-3" src="/freetrial/img/iconos/play-videos.png" alt="Icono video"> 120 dynamic video-lessons</li>
                                <li class="mb-2 ps-1 d-flex"><img class="img_iconList pe-3" src="/freetrial/img/iconos/computer.png" alt="Icono computadora"> 2 live classes with your instructor Francisco</li>
                                <li class="mb-2 ps-1 d-flex"><img class="img_iconList pe-3" src="/freetrial/img/iconos/check.png" alt="Icono check">Downloadable guides and editable templates</li>
                                <li class="mb-2 ps-1 d-flex"><img class="img_iconList pe-3" src="/freetrial/img/iconos/chat.png" alt="Icono chat">Networking practice with other participants</li>
                                <li class="mb-2 ps-1 d-flex"><img class="img_iconList pe-3" src="/freetrial/img/iconos/comunidad.png" alt="Icono comunidad">Access to the Scalabl Global Community</li>
                                <li class="ps-1 d-flex"><img class="img_iconList pe-3" src="/freetrial/img/iconos/certificacion.png" alt="Icono certificacion">Certificate of completion</li>
                            </ul>
                        </div>
                    </a>
                    <!--/ Contenedor accede al curso -->

                    <!-- Contenedor comprar curso -->
                    <div class="contendor_comprarCurso">
                        <h2 class="text-center pt-3 px-4 px-lg-0 px-md-0"> Starts <?php fechas_num(1, 0, 2); ?></h2>
                        <?php
                        if ($curso_descuento) {
                            # si existe el descuento mostrar el contador y los valores con descuento
                        ?>
                            <!-- <h2 class="text-center px-4 px-lg-0 px-md-0">¡La oferta termina en <span class="timer_contador"></span>!</h2> -->
                            <!-- Precio oferta -->
                            <div class="box-precio-oferta my-3 px-4 px-lg-0 px-md-0">
                                <p class="text-center"> <span class="precio-original"><?= $string_valor; ?></p>
                            </div>
                            <!-- Precio oferta -->
                        <?php
                        }
                        ?>
                        <!-- Contenedor boton comprar + img medio de pago y cuotas segun corresponda -->
                        <div class="d-flex flex-column mt-3 justify-content-center align-items-center">
                            <a class="btn btn_comprar d-block py-2  <?= !$is_arg &&  !$is_chile ? $id_stripe : ''; ?> btn_comprarcurso" <?= $is_arg || $is_chile ? "href='$link_mp'" : ""; ?>>Enroll <?= $string_valor_descuento; ?></a>

                            <div class="d-flex justify-content-center contenedor-pagos-oferta align-items-center <?= $clase_correr_logo_mp; ?>">
                                <div class="contendor-img-medios-de-pago">
                                    <a <?= $is_arg || $is_chile ? "href='$link_mp'" : ""; ?>>
                                        <img class="medio-de-pago mt-1 <?= $clase_tamanio_img_pago; ?> <?= (!$is_arg) ? 'mt-3 mb-3 mb-lg-0' : ''; ?> <?= !$is_arg &&  !$is_chile ? $id_stripe : ''; ?>" src="<?= $img_medio_pago; ?>" alt="Medio de pago">
                                    </a>
                                </div>
                                <?php if ($is_arg) { ?>
                                    <span class="mx-2 d-block barra-pagos-oferta">
                                        <!-- barra -->
                                    </span>
                                    <div>
                                        <p class="cuotas-arg text-start"><?= $valor_cuota_sin_interes ?></p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <!--/ Contenedor boton comprar + img medio de pago y cuotas segun corresponda -->
                    </div>
                    <!--/ Contenedor comprar curso -->
                </div>
            </div>
        </div>
    </div>
    <!-- Modal mas info -->

    <!-- Modal terminos y condiciones -->
    <div class="modal fade" id="modalTerminosCondiciones" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel1" aria-hidden="true">
        <!-- Modal dialog -->
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <!-- Modal content -->
            <div class="modal-content">
                <!-- Modal header - titulo -->
                <div class="modal-header position-relative">
                    <h2 class="modal-title me-3 me-lg-0 me-md-0" id="staticBackdropLabel1">General Terms and Conditions</h2>
                    <button type="button" class="btn-modalPopUpVIoleta position-absolute py-2 me-3" data-bs-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Modal header - titulo -->
                <!-- Modal body -->
                <div class="modal-body">
                    <!-- Seccion #Identifying Data -->
                    <section>
                        <!-- Lista ordenada A -->
                        <ol type="A">
                            <li>
                                <h2 class="text-start">Identifying Data</h2>
                                <p><span class="bolder">Scalabl Global Limited</span>(hereinafter, “Scalabl”), headquartered at Innovation Centre, Gallows Hill, Warwick, CV34 6UW, United Kingdom, is a global consulting and training company, specializing in business, entrepreneurship, and innovation.</p>
                                <p>Scalabl offers third parties the so-called “Course in Entrepreneurship and Innovation” (hereinafter, the “Course”), which is currently delivered online (hereinafter, “Online Course in Entrepreneurship and Innovation” or “Online Course”) in Spanish, English, or Portuguese, through the website www.scalabl.com (hereinafter, the “Website”).</p>
                                <p>The Course, both in its currently imparted online modality and its face-to-face modalities, which have been previously offered or may be delivered in the future, is addressed to entrepreneurs, businesspeople, and professionals, and is based on a robust methodology for the development of highly profitable and scalable business models, which can be applied to the design of a new company or business unit, or to the restructuring of an existing company.</p>
                                <p>Scalabl's Global Community of Graduates (hereinafter, “Scalabl's Global Community”, “Community” or “Network”) is formed by all the people who, having graduated from the Course, regardless of what institution has marketed it, and having been admitted by Scalabl Global Limited, acquire the status of “Member” or the status of “Alumni” and, voluntarily, decide to accept and to belong to the Network. </p>
                                <p>All graduates of the face-to-face editions of the Course are referred to as “Alumni” (hereinafter, individually and collectively referred to as “Alumni”), and any person who has successfully completed the Online Course is referred to as “Member” (hereinafter, collectively referred to as “Members”, and together with the Alumni, as the “Community Members”).</p>
                                <p>By registering for the Course, you are entrusting us with information and accepting the practices outlined below. Hereinafter, you will be referred to as the “User”, or jointly as the “Users” of the Course.</p>
                                <p>Scalabl's identifying information is as follows:</p>
                                <ul class="list-circle">
                                    <li><span>Scalabl Global Limited</span></li>
                                    <li><span>Address: </span> Innovation Centre, Gallows Hill, Warwick, CV34 6UW, United Kingdom</li>
                                    <li><span>Contact email: </span> info@scalabl.com</li>
                                    <li><span>Contact phone number:</span> +372 58 35 83 47</li>
                                </ul>
                                <p>In carrying out such commitment, Scalabl has implemented this privacy policy (hereinafter, the "Privacy Policy") which complies with the European Regulation No. 679/2016, of April 27, 2016, on the Protection of Personal Data and with the Argentine law No. 25,326 on the Protection of Personal Data.</p>
                                <p>This Privacy Policy describes Scalabl's policies and practices regarding the collection, use, and disclosure of personal information collected. As such, this Privacy Policy is intended to help you understand what data we collect, why we collect it, and what we do with it.</p>
                                <p>Please note that Scalabl reserves the right to modify this Privacy Policy for a variety of reasons, such as the use of new information processing technologies or changes to the Website, or changes in applicable law. In the event that such a modification affects you concerning the treatment of your data in the Privacy Policy, you will be duly informed and, if you do not agree with such changes, you will have to unsubscribe from the Course.</p>
                                <p>If you do not agree with the Privacy Policy, you can always unsubscribe from the Course.</p>

                                <p>The following information will help you understand our Privacy Policy.</p>
                                <!-- indice -->
                                <ol type="1">
                                    <li><b> What information do we collect?</b></li>
                                    <li><b>What do we use the information we collect for?</b></li>
                                    <li><b>Why do we need express consent?</b></li>
                                    <li><b>To whom do we share the information we collect?</b></li>
                                    <li><b>Where do we store and how do we protect the information we collect?</b></li>
                                    <li><b>How can you access, delete and/or update the information we collect?</b></li>
                                    <li><b>What are your rights when you provide us with your information?</b></li>
                                    <li><b>Age of majority</b></li>
                                    <li><b>Social Media Policy</b></li>
                                    <li><b>Integration with the rest of the legal texts</b></li>
                                </ol>
                                <!--/ indice -->
                            </li>
                            <!-- desgloce del indice -->
                            <ol class="p-0">
                                <li class="my-5">
                                    <h2 class="text-start">What information do we collect?</h2>
                                    <p>Scalabl receives and stores (a) information that you provide to us, (b) information obtained from third parties, and (c) information collected by our systems, as described below:</p>
                                    <ol type="a">
                                        <li>
                                            <h3><b>Information provided to us by the User</b></h3>
                                            <p>By entering the Course, you agree to provide Scalabl with personal information regarding your identity, including but not limited to your first and last name, address, telephone number, e-mail address, date of birth, and nationality ("Personal Information").</p>
                                            <p>Additionally, during the Course, you may provide us with opinions and comments (hereinafter, the "Opinions"). In this case, you accept and agree that all Feedback you submit to us will be published on the Website or on other websites and/or applications with whom Scalabl has contractual relationships. In such a case, we inform you that, eventually, you may be identified with your full name, photo, professional profile, comment, and nationality. By giving us your opinion or uploading real photos through the Course and/or the Website, you are assigning to Scalabl all property rights on such photos and Opinions. We remind you that you may delete your feedback by following the procedure detailed below in point <b>6. How can I access, delete and/or update the Collected Information?</b></p>
                                        </li>
                                        <li>
                                            <h3><b>Information provided by third parties</b></h3>
                                            <p>To the extent permitted by applicable law, Scalabl may also obtain Personal Information from you and aggregate it with Personal Information provided to us by third parties, whether group companies, business partners, and/or other independent third-party sources, such as public databases, information collected during a telephone conversation and/or through interactive applications. You should note that all information we collect about each User may only be used for the purposes set out in point 2. Any Personal Information obtained by Scalabl by the means described herein will be treated under the provisions of this Privacy Policy.</p>
                                            <p>As already established in the previous points, Scalabl will not provide Users' data to third parties. Should it wish to do so, you will be informed in advance and your consent will be requested.</p>
                                        </li>
                                        <li>
                                            <h3><b>Information collected by our systems. Cookies Policy. Links to other sites. Geolocation Services</b></h3>
                                            <p>Scalabl may collect and process information about your visits to our Web Site. This information may be used to improve the content of the Website and/or the Course. For these purposes, we may set "cookies," which are small pieces of text that are used to retain information in web browsers and are stored on the hard drive of your device. These cookies may be used by Scalabl or by third parties.</p>
                                            <p>In addition, through cookies or a geolocation service based on the IP of your connection or GPS, Scalabl will be able to access your location information to provide you with a better service from the Website.</p>
                                            <p>We have content on the Website that links to third-party sites or services. When a third-party service is enabled, you authorize us to connect and access other information that is available under our agreement with the service provider. However, Scalabl does not receive or store passwords from any of these third-party services.</p>
                                            <p>In this regard, as data processors, we have contracted with the following service providers, who have committed to comply with the applicable data protection regulations at the time of contracting:</p>
                                            <ul class="list-circle">
                                                <li>
                                                    <h3 class="text-start d-inline bold"><b>Teachable Inc</b></h3>
                                                    <p class="d-inline">, 16 W. 22nd Street, 6th Floor, New York, New York 10010, which provides web course creation services. The privacy policy and other legal aspects of the company can be consulted at the following link: <a href="https://teachable.com/privacy-policy">https://teachable.com/privacy-policy</a> </p></li>
                                                <li>
                                                    <h3 class="text-start d-inline bold"><b>Facebook Ireland Limited</b></h3>
                                                    <p class="d-inline">(identified by the trademarks Facebook, Messenger, Instagram, and/or WhatsApp), VAT registered number IE9692928F and domiciled at 4 Grand Canal Square, Grand Canal Harbour, Dublin 2, Ireland. The privacy policy and other legal aspects of said company can be consulted at the following link: <a href="https://www.facebook.com/about/privacy/update">https://www.facebook.com/about/privacy/update</a> </p></li>
                                                <li>
                                                    <h3 class="text-start d-inline bold"><b>LinkedIn Ireland Unlimited Company</b></h3>
                                                    <p class="d-inline">, Wilton Place, Dublin 2, Ireland. The privacy policy and other legal aspects of this company can be viewed at the following link: <a href="https://www.linkedin.com/legal/privacy-policy">https://www.linkedin.com/legal/privacy-policy</a> </p></li>
                                            </ul>
                                        </li>
                                    </ol>
                                </li>
                                <li class="my-5">
                                    <h2 class="text-start">What do we use the information we collect for?</h2>
                                    <p>Scalabl uses your Personal Information for the following purposes:</p>
                                    <ol type="A">
                                        <li>To provide the Course and its related services.</li>
                                        <li>To prevent or address any errors, technical or security problems, or fraud on the Website.</li>
                                        <li>To analyze and monitor usage, trends, and other activities of Users.</li>
                                        <li>To comply with the requirements of applicable laws, regulations, and legal procedures.</li>
                                        <li>To communicate with the User in response to User requests, comments, and questions.</li>
                                        <li>To develop and provide search, training, and productivity tools and additional features.</li>
                                        <li>To send emails and other communications regarding new Courses and/or Website features, as well as promotional communications or other news about Scalabl.</li>
                                        <li>For billing, account management, and other administrative purposes. Please be advised that Scalabl may need to contact you for billing, account management, and other similar reasons.</li>
                                    </ol>
                                </li>
                                <li class="my-5">
                                    <h2 class="text-start">Why do we need express consent?</h2>
                                    <p>In compliance with the requirements of the European Regulation 679/2016, of April 27, on Personal Data Protection, by the Organic Law 3/2018 on Personal Data Protection and guarantee of digital rights, and by the Argentine law 25.326, on Personal Data Protection, and following the provisions of our internal policies, we need your personal data in order to identify you and provide you with the Course.</p>
                                    <p>With such action(s), you are freely and unequivocally declaring that you agree that Scalabl treats your data according to the purposes mentioned in the previous sections.</p>
                                    <p>The User guarantees that the personal data provided to Scalabl are truthful and is responsible for communicating to Scalabl any modification thereof.</p>
                                    <p>The User's acceptance that his/her data will be processed for the purposes referred to in this Privacy Policy is always revocable, without retroactive effects, under the provisions of current legislation.</p>
                                </li>
                                <li class="my-5">
                                    <h2 class="text-start">With whom is the Personal Information collected shared?</h2>
                                    <p>This section describes with whom Scalabl may share and disclose Information:</p>
                                    <ol type="A">
                                        <li>Group companies: Scalabl may share information with any of its controlled, controlling, and related companies.</li>
                                        <li>Corporate reorganization: If from time to time, Scalabl is involved in a merger, acquisition, bankruptcy, dissolution, reorganization, sale of some or all of our corporate assets or interests, financing, public offering, acquisition of all or part of our business, or similar transaction or proceeding, some or all of the Personal Information may be shared or transferred, subject to standard confidentiality agreements.</li>
                                        <li>With competition authorities: only in case of receiving requests of a judicial nature in accordance with the requirements of applicable laws, regulations and legal procedures.</li>
                                        <li>Between Users: the Course and/or the Web Site allows collaborative work between Users, allowing each one to eventually issue Opinions during the Course.</li>
                                    </ol>
                                </li>
                                <li class="my-5">
                                    <h2 class="text-start">Where do we store and how do we protect the information we collect?</h2>
                                    <p>All Personal Information is collected and stored on servers physically located in the United States, European Community, and/or Argentina. By accepting the Privacy Policy, you agree that Scalabl may transfer your Personal Information to any country in the world. In any case, Scalabl is committed to guaranteeing that the legally required standards for the protection and safeguarding of your Personal Information are met, through the signing of agreements or conventions whose purpose is the privacy of your Personal Information.</p>
                                    <p>In order to guarantee the security of our Website, we have integrated a security system that allows us to maintain the confidentiality and integrity of the data of our Users that have been sent or collected through the means mentioned in the first point.</p>
                                    <p>Thus, Scalabl maintains the security levels of data protection required by the new legislation and regulations referred to throughout the text and has provided on the Website all the technical means at its disposal to prevent the loss, misuse, alteration, unauthorized access, and theft of the data provided by the User through the Website.</p>
                                    <p>Also, as a User of our Website and/or the Course you understand, accept, and understand that security measures on the Internet are not impregnable and that, therefore, you are obliged to adopt the necessary security measures that allow you to trust the veracity of the Website in which you are entering your data. We will also do our best to ensure the privacy and security of your identification data at all times, always using the utmost diligence and implementing the necessary measures.</p>
                                    <p>Thus, we inform you that you will be solely responsible for the security measures that you implement concerning the protection of your data, with which, Scalabl is not responsible for situations where the User has not implemented the corresponding security measures, nor for their consequences, as well as for causes or damages caused by third parties outside Scalabl, including fortuitous cases and/or force majeure.</p>
                                    <p>In accordance with the aforementioned, Scalabl cannot guarantee that unauthorized third parties may have knowledge of the type, conditions, characteristics, and circumstances of the use that the Users make of the Course.</p>
                                </li>
                                <li class="my-5">
                                    <h2 class="text-start">What data do we retain after your User account is deactivated?</h2>
                                    <p>If you cease to be a User, we inform you that Scalabl will only retain your Personal Information for the period necessary to comply with the requirements of applicable law.</p>
                                </li>
                                <li class="my-5">
                                    <h2 class="text-start">What are your rights when you provide us with your data?</h2>
                                    <p>The applicable legislation and regulations have implemented a series of legal guarantees that allow the User to exercise rights and actions related to the processing of his or her data.</p>
                                    <p>Scalabl offers you this legal guarantee, with which, at any time and/or when you consider it convenient, you can make use of your rights of access, rectification, suppression, opposition, portability, and oblivion by writing to the contact email that we have enabled for this purpose: info@scalabl.com, attaching a copy of your passport or your ID card (holder of the data) and indicating in the subject expressly the request you wish to make: access, rectification, suppression, opposition, portability, oblivion and limitation of processing.</p>
                                    <p>Notwithstanding the above, it is important that as a User you keep in mind that the information you have shared, by any means, may continue to be visible and that Scalabl is exonerated from any responsibility in relation to the elimination of this information.</p>
                                    <p>Likewise, Scalabl does not control the renewal system of third party search mechanisms, which may contain certain public profile information that has already been deleted by Scalabl but that is still visible on the Internet due to the rebroadcast of the same, in which case, we recommend that you contact those responsible for those platforms and/or websites to request its deletion or the exercise of the right to oblivion.</p>
                                    <p>We explain briefly what each of the rights you can exercise consists of:</p>
                                    <ul class="list-unstyle">
                                        <li>
                                            <h3 class="text-start">&#10003  Right of access: </h3>
                                            <p>by exercising this right, you will be able to know what processing is carried out on your personal data by Scalabl: its purpose, origin, or possible transfer to third parties.</p>
                                        </li>
                                        <li>
                                            <h3 class="text-start">&#10003 Right to erasure (or right to be forgotten): </h3>
                                            <p>you may request the deletion of your personal data, without undue delay, when any of the cases contemplated occur. For example, unlawful data processing, or when the purpose for which the data was processed or collected has disappeared. However, there are several exceptions in which this right does not apply. For example, when the right to freedom of expression and information must prevail.</p>
                                        </li>
                                        <li>
                                            <h3 class="text-start">&#10003  Right of opposition: </h3>
                                            <p>through this right you may oppose the processing of your personal data: (i) when, for reasons related to your personal situation, the processing of your data must cease unless a legitimate interest is proven, i.e. necessary for the exercise or defense of claims, or, (ii) when the processing is for the purpose of direct marketing.</p>
                                        </li>
                                        <li>
                                            <h3 class="text-start">&#10003  Right to limit processing: </h3>
                                            <p>you may ask us to restrict the processing of your data (i) when the accuracy of the data is contested, while we verify such contestation, (ii) when the processing is unlawful, but you object to the deletion of your data and request the restriction of the processing instead, (iii) when you are the one who needs them in case of a claim (iv) and even when you have objected to the processing of your data for the performance of a mission in the public interest or for the satisfaction of a legitimate interest, which must be verified. In these cases, we will only keep them for the exercise or defense of claims.</p>
                                        </li>
                                        <li>
                                            <h3 class="text-start">&#10003  Right of portability: </h3>
                                            <p>you may request the portability of your data in a structured, commonly used and machine-readable format, so that it can be transmitted to another entity, provided that this is technically possible.</p>
                                        </li>
                                    </ul>
                                    <p>To exercise any of these rights, you must send an email to the mailbox info@scalabl.com, after which we will contact you to validate your identity and resolve your request.</p>
                                    <p>Also, at any time, you may withdraw your consent without affecting the lawfulness of the processing already carried out, by sending your request to the same address indicated in the previous paragraph. In this case, it is also necessary to attach a copy of your National Identity Card or an equivalent document proving your identity to your request.</p>
                                </li>
                                <li class="my-5">
                                    <h2 class="text-start">Social Media Policy</h2>
                                    <p>Scalabl has corporate profiles and/or private groups in the social networks Facebook, Instagram, LinkedIn, Twitter, YouTube, WhatsApp, Telegram, Pinterest, TikTok, and Clubhouse (hereinafter, the "Social Networks"). Thus, according to the provisions of the European Data Protection Regulation 679/2016 of April 27, 2016, and the Argentine Personal Data Protection Law, Law No. 25,326, Scalabl is "Responsible for the processing of your data" on the grounds of the existence of such profiles on these social networks and the fact that you follow us and we can follow you.</p>
                                    <p>On the other hand, we inform you that we will use social networks as a channel of interaction between Users and Scalabl.</p>
                                    <p>However, we also let you know that there is no link between Scalabl and such social networks, so you will accept their policy of use and conditions once you access them and/or accept their notices and/or terms and conditions in the registration procedure, and Scalabl will not be responsible for the use or treatment of your data that is made outside the strict relationship and provision of services indicated in this Privacy Policy.</p>
                                </li>
                                <li class="my-5">
                                    <h2 class="text-start">Integration with the rest of the legal texts</h2>
                                    <p>This Privacy Policy is supplemented by the Terms and Conditions of Use and the Cookie Policy associated with this Web Site.</p>
                                </li>
                            </ol>
                            <!-- desgloce del indice -->
                        </ol>
                        <!-- / Lista ordenada  -->
                    </section>
                </div>
                <!-- / Modal body -->
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-modal py-2 me-2" data-bs-dismiss="modal">Close</button>
                </div>
                <!-- / Modal footer -->
            </div>
            <!-- / Modal content -->
        </div>
        <!-- / Modal dialog -->
    </div>
    <!-- / Modal terminos y condiciones -->


    <!-- modal stripe -->
    <div class="modal fade" id="modal_stripe" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="stripeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="globalContent modal-content">
                <main>
                    <section class="container-lg">
                        <div class="cell stripe stripe1" id="stripe-1">
                            <a type="button" class="close" id="btn_close_stripe">
                                <span aria-hidden="true">&times;</span>
                            </a>
                            <img width="150px" src="/inc/img/<?php echo $idioma == "es" || $idioma == "por" ? "logo-SCO.png" : "logo-SCO-en.png"; ?>">
                            <h1 class="titulo-modal"><?php echo $idioma == "es" ? "Comprar Curso Online" : ($idioma == "en" ? "Buy Online Course" : "Comprar Curso Online"); ?></h1>
                            <form action="/inc/tests/stripe/stripe.php" method="POST" id="payment-form">
                                <fieldset>
                                    <div class="row">
                                        <label for="stripe1-name"><?php echo $idioma == "es" ? "Nombre" : ($idioma == "en" ? "Name" : "Nome"); ?></label>
                                        <input id="stripe1-name" type="text" placeholder="<?php echo $idioma == "es" ? "Juan Rodriguez" : ($idioma == "en" ? "Jane Doe" : "João Silva"); ?>" required="" name="nombre" autocomplete="nombre">
                                    </div>
                                    <div class="row row-line">
                                        <label for="stripe1-email">Email</label>
                                        <input id="stripe1-email" type="email" placeholder="<?php echo $idioma == "es" ? "juanrodriguez@gmail.com" : ($idioma == "en" ? "janedoe@gmail.com" : "joaosilva@gmail.com"); ?>" required="" name="email" autocomplete="email">
                                    </div>
                                    <div class="row row-line">
                                        <label for="stripe1-phone"><?php echo $idioma == "es" ? "Teléfono" : ($idioma == "en" ? "Phone" : "Telefone"); ?></label>
                                        <input id="stripe1-phone" type="tel" placeholder="<?php echo $idioma == "es" ? "+54 (11) 2555-0123" : ($idioma == "en" ? "+1 (941) 555-0123" : "+55 (11) 2555-0123"); ?>" required="" name="tel" autocomplete="tel">
                                    </div>
                                    <div class="row">
                                        <input type="hidden" value="SP" name="plataforma">
                                        <input type="hidden" value="<?php echo isset($_GET["ref"]) ? $_GET["ref"] : ""; ?>" name="ref">
                                        <input type="hidden" value="<?php echo strtoupper($currency); ?>" name="currency">
                                        <input type="hidden" value="<?php echo $valor_curso_stripe; ?>" name="valor">
                                        <input type="hidden" value="<?php echo $idioma; ?>" name="idioma">
                                        <input type="hidden" value="<?php echo $nombre_curso; ?>" name="nombre_curso">
                                        <input type="hidden" value="1" name="curso_nuevo">
                                        <input type="hidden" value="1" name="intento_pago_stripe">
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="row">
                                        <div id="card-element">
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <button class="submit" type="submit" id="btn_compra_stripe" name="btn_pagar_stripe"><?php echo $idioma == "es" ? "Pagar" : ($idioma == "en" ? "Pay" : "Pagamento"); ?> <?= $string_valor_descuento; ?></button>
                                </fieldset>
                            </form>
                            <?php echo tarjetas_stripe(); ?>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>
    <!-- /modal stripe -->

    <!-- modal intermedio stripe -->
    <div class="modal fade" id="modal_stripe_intermedio" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="stripeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="globalContent modal-content">
                <main>
                    <section class="container-lg">
                        <div class="modal-stripe stripe stripe1 cell">
                            <div class="m-auto text-center">
                                <h2>Just a moment!</h2>
                                <p class="mt-1">Don't you wish to make the payment?</p>

                                <div class="m-auto d-flex flex-column mt-5">
                                    <button class="btn-modal-stripe btn-stripe-pago p-2" type="button" id="btn_seguir_stripe">Continue payment</button>
                                    <button class="btn-modal-stripe btn-stripe-cerrar p-2 mt-2" type="button" data-bs-dismiss="modal" aria-label="Close">Close and cancel payment</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>
    <!-- /modal intermedio stripe -->

    <!-- Modal compartir -->
    <div class="modal fade" id="popUpCompartir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header py-3">
                    <h2 class="modal-title py-0" id="modalShareTitulo">Share this invite link:</h2>
                    <button type="button" class="close position-relative" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center py-0 my-4 d-flex" id="modalShareContenido">
                    <form action="#" class="d-flex mb-0  mr-0 mr-lg-3 ">
                        <input class="input-text form-control py-1 px-1 pl-1 text-center text-lg-start" type="text" id="tb_url" value="https://scalabl.com/startup" readonly>
                        <input class="input-submit text-center p-1" id="btn_copy_link" type="button" value="Copy">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal compartir -->


    <!-- Estilos para tamaño de video vimio -->
    <style type="text/css">
        .player,
        .player *,
        #player,
        .player-0ee1845b-b274-4d9f-9841-8c184d2cf3d1,
        .js-player-fullscreen,
        .with-fullscreen,
        .with-sticky-custom-logo,
        .player-normal,
        .player-cardsCorner {
            max-width: 100% !important;
        }
    </style>
    <!--/ Estilos para tamaño de video vimio -->

    <!-- CDN Bootstrap -->
    <script src="/inc/bootstrap-5/js/bootstrap.bundle.js"></script>
    <!-- / CDN Bootstrap -->
    <script src="/inc/js/jquery-3.4.1.min.js"></script>
    <script src="/freetrial/js/funciones.js"></script>

    <script>
        let stripe_valor = <?= $valor_curso_stripe; ?>;
        let stripe_currency = '<?= $currency; ?>';
    </script>
    <script src="/inc/tests/stripe/js/stripe.js?version=<?php echo time(); ?>"></script>

</body>

</html>