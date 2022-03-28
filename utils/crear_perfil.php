<?php

// crearUsuarios();

function crearUsuarios()
{
    require('../../inc/configuracion.inc');

    $usuarios = array("mechi", "caro", "sofi", "majo", "nico", "fran", "pau", "it");

    for ($i = 0; $i < count($usuarios); $i++) {

        $user = $usuarios[$i];
        $pass = uniqid(rand(10, 100));
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

        echo $user . " => ";

        echo $pass . "</br>";

        sleep(0.1);

        $crear = "INSERT INTO usuarios (usuario, password, tipo) VALUES ('$user', '$pass_hash', 0)";

        if (mysqli_query($connection, $crear) or die(mysqli_error($connection))) {
        } else {
            echo "ERROR </br>";
        }
    }
}

?>