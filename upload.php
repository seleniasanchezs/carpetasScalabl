<?php
    require_once('funciones.php');
    require_once('../inc/header.php');
    require_once('../inc/footer.php');

    function actualizar_imagen($location, $id){
        require('../inc/configuracion.inc');

        $consulta = "UPDATE usuarios SET imagen = '$location' WHERE id_usuario = '$id'";

        mysqli_query($connection, $consulta) or die(mysqli_error($connection));
    }

    if($_FILES["file"]["name"] != ''){
        $nombre = $_POST["nombre"];
        $id = $_POST["id"];
        $test = explode(".", $_FILES["file"]["name"]);
        $extension = end($test);
        $nombre_normalizado = normaliza($nombre . "-" . $id);
        $name = $nombre_normalizado . '.' . $extension;
        $location = 'img/perfil/'.$name;
        actualizar_imagen($location, $id);
        move_uploaded_file($_FILES["file"]["tmp_name"], $location);
        echo $location;
    }

?>