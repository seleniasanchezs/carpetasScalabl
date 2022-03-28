<?php
require("funciones.php");

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
} else {
    $usuario = get_perfil($_SESSION["usuario"]);

    $id = isset($usuario) ? $usuario['id'] : "";
    $imagen = isset($usuario) ? $usuario['imagen'] : "";
    $nombre = isset($usuario) ? $usuario['usuario'] : "";

    $super_admin = $usuario["tipo"] == 0 ? true : false;
}

$no_leidos = get_no_leidos($nombre);

$chats = mostrarChats($nombre);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin/css/estilos.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    if ($no_leidos > 0) {
    ?>
        <div class="w-100 d-flex flex-column p-4" style="position: absolute; top: 25px; right: 0; z-index: 999">
            <div class="toast mt-auto ml-auto" role="alert" data-delay="3000" data-autohide="false" data-animation="true">
                <div class="toast-header">
                    <img src="../inc/img/logo-landing-blanco.png" width="60px" class="rounded mr-2" alt="...">
                    <strong class="mr-auto text-primary"></strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="toast-body bg-danger">¡Tienes <?php echo $no_leidos > 1 ? $no_leidos . " mensajes" : $no_leidos . " mensaje"; ?> sin leer!</div>
            </div>
        </div>
    <?php
    }
    ?>
    <!-- <div class="notificaciones">
        <i class="fa fa-bell fa-lg" aria-hidden="true"></i>
        <?php
        //if ($no_leidos > 0) {
        ?>
            <div class="contador">
                <p><?php// echo $no_leidos; ?></p>
            </div>
        <?php
        //}
        ?>
    </div> -->
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
            <!-- Button trigger modal -->

            <div class="container-fluid">
                <h1 class="mb-4 titulo">Mensajes</h1>
                <div class="nuevo-mensaje">
                    <button type="button" class="btn btn-scalabl ml-2 mb-4" data-toggle="modal" data-target="#exampleModalCenter">
                        Nuevo mensaje
                    </button>
                </div>
                <div class="row msj-container">
                    <div class="col-4 chats pb-4">
                        <h5 class="my-4">Conversaciones</h5>
                        <div class="conv">
                            <?php
                            foreach ($chats as $chat) {
                                $rem = explode(",", $chat["remitente"]);
                                $des = explode(",", $chat["destinatario"]);
                            ?>
                                <?php
                                if (array_search($nombre, $des) !== false) {
                                ?>
                                    <div class="chat" data-user="<?php echo $nombre; ?>" data-nombre="" data-id="<?php echo $chat["id_chat"]; ?>">
                                        <div class="imagen-container">
                                            <img width="60px" height="60px" src="<?php echo count($rem) > 1 ? "../inc/img/logo-conv-grupal.jpg" : "../comunidad/" . get_imagen_perfil($rem[0]); ?>" alt="">
                                            <?php
                                            $num_no_leidos = get_no_leidos($nombre, $chat["id_chat"]);
                                            if ($num_no_leidos != 0) {
                                            ?>
                                                <div class="contador-chat">
                                                    <p><?php echo $num_no_leidos; ?></p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if (count($rem) > 1) {
                                        ?>
                                            <p><?php echo implode(", ", $rem); ?></p>
                                        <?php
                                        } else {
                                        ?>
                                            <p><?php echo $rem[0]; ?></p>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                <?php
                                }
                                if (array_search($nombre, $rem) !== false) {
                                ?>
                                    <div class="chat" data-user="<?php echo $nombre; ?>" data-nombre="<?php //echo $d; 
                                                                                                        ?>" data-id="<?php echo $chat["id_chat"]; ?>">
                                        <div class="imagen-container">
                                            <img width="60px" height="60px" src="<?php echo count($des) > 1 ? "../inc/img/logo-conv-grupal.jpg" : "../comunidad/" . get_imagen_perfil($des[0]); ?>" alt="">
                                            <?php
                                            $num_no_leidos = get_no_leidos($nombre, $chat["id_chat"]);
                                            if ($num_no_leidos != 0) {
                                            ?>
                                                <div class="contador-chat">
                                                    <p><?php echo $num_no_leidos; ?></p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        if (count($des) > 1) {
                                        ?>
                                            <p><?php echo implode(", ", $des); ?></p>
                                        <?php
                                        } else {
                                        ?>
                                            <p><?php echo $des[0]; ?></p>
                                        <?php
                                        }
                                        ?>
                                    </div>
                            <?php

                                }
                            }
                            ?>
                            <?php
                            ?>
                        </div>
                    </div>
                    <div class="col-8 mensajes">
                        <div class="cover">
                            <i class="fa fa-comments fa-5x mb-3" aria-hidden="true"></i>
                            <h3 class="mb-3">Tus mensajes</h3>
                            <p>Envía mensajes privados a un integrante del equipo.</p>
                            <button type="button" class="btn btn-scalabl ml-2 mb-4" data-toggle="modal" data-target="#exampleModalCenter">
                                Nuevo mensaje
                            </button>
                        </div>
                        <div class="historia-mensajes py-4">
                            <!-- <?php //$conversacion = get_conversacion("54a6sd84asd8");
                                    //foreach ($conversacion as $c) {
                                    ?>
                                <?php
                                //if ($c["remitente"] != $nombre) {
                                ?>
                                    <div class="linea-texto">
                                        <img width="30px" height="30px" src="<?php// echo "../comunidad/" . get_imagen_perfil($c["remitente"]); ?>" alt="">
                                        <p><?php// echo $c["mensaje"]; ?></p>
                                    </div>
                                <?php
                                //} else {
                                ?>
                                    <div class="linea-texto right">
                                        <p><?php// echo $c["mensaje"]; ?></p>
                                        <img width="30px" height="30px" src="<?php //echo "../comunidad/" . get_imagen_perfil($c["remitente"]);
                                                                                ?>" alt="">
                                    </div>
                                <?php
                                //}
                                ?>
                            <?php
                            //}
                            ?> -->
                        </div>
                        <form class="form-inline" id="enviar-mensaje" action="">
                            <div class="form-group form-group-lg container-enviar">
                                <input type="text" class="form-control input-lg" name="mensaje" id="msj">
                                <input type="hidden" name="destinatario" id="destinatario" value="">
                                <input type="hidden" name="remitente" id="remitente" value="<?php echo $nombre; ?>">
                                <input type="hidden" name="id_chat" id="id_chat" value="">
                                <button class="btn btn-scalabl" type="submit" id="enviar" data-nombre="<?php echo $nombre; ?>">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Seleccionar destinatarios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="nuevo-msj" action="">
                    <div class="modal-body">
                        <div class="destinatarios">
                            <?php
                            $usuarios = get_destinatarios();
                            $index = 0;
                            foreach ($usuarios as $u) {
                                if ($u["usuario"] != $nombre && $u["usuario"] != "team") {
                            ?>
                                    <div class="form-check contactos">
                                        <div class="contactos-nombre">
                                            <img width="30px" height="30px" src="../comunidad/<?php echo $u["imagen"]; ?>" alt="">
                                            <label class="form-check-label" for="nuevo-msj">
                                                <?php echo $u["usuario"]; ?>
                                            </label>
                                        </div>
                                        <div class="contactos-input">
                                            <input class="form-check-input" type="checkbox" name="destinatario_nuevo[]" value="<?php echo $u["usuario"]; ?>" id="nuevo-msj<?php echo $index; ?>" required>
                                        </div>
                                    </div>
                            <?php
                                    $index++;
                                }
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="mensaje-nuevo">Mensaje</label>
                            <textarea class="form-control" id="mensaje-nuevo" name="mensaje_nuevo" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="remitente_nuevo" value="<?php echo $nombre; ?>">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="nuevo-enviar" class="btn btn-scalabl">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="../admin/js/funciones.js"></script>
</body>

</html>