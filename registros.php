<?php

    require("funciones.php");

    if (!isset($_SESSION["scalabl_admin_root_user"])) {
        session_destroy();
        header("Location: login.php?noSession");
    }

    $info = get_registros();
    // echo "<pre>";
    // print_r($info);
    // echo "</pre>";
    // return;

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="content-language" content="es">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Scalabl | MBA UCEMA registros</title>
    <meta name="description" content="mbaucema">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#613b5e" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
        <style>
            .tabla-leads{
                border-collapse: collapse;
            }
            .tabla-leads th{
                border-bottom: 1px solid gray;
                background-color: lightgrey;
            }
            .tabla-leads th, .tabla-leads td{
                padding: 5px 20px;
            }
            .c-centro{text-align: center;}
            .b-bottom{border-bottom: 1px solid #f2f2f2;}
            .fa-check:hover, .fa-times:hover,.fa-trash:hover{transform: scale(1.2); cursor: pointer;}
            .leads-contactar{text-decoration: none; color: darkblue;}
            .leads-contactar:hover{text-decoration: underline;}
        </style>
        <?php
        echo "<table class='tabla-leads'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Nombre</th>";
        echo "<th>Email</th>";
        echo "<th>Curso</th>";
        echo "<th>Fecha</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($info as $i) {
            extract($i);

            echo "<tr class='b-bottom'>";
            echo "<td>$nombre $apellido</td>";
            echo "<td>$email</td>";
            echo "<td>$fecha_curso</td>";
            echo "<td>$fecha_registro</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    ?>

</body>
</html>