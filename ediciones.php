<?php
    require("funciones_ediciones.php");

    $ediciones = get_ediciones();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
        <h3>Ediciones</h3>
        <?php if (isset($_GET["edicion_actualizada"])) echo "<p style='color: green;'>Edición actualizada ok</p>"; ?>
        <?php if (isset($_GET["error"])) echo "<p style='color: red;'>Ha ocurrido un error</p>"; ?>
        <hr />
        <?php
            foreach ( $ediciones as $e ) {
                extract($e);
                ?>
                    <form action="funciones_ediciones.php" method="post">
                        Edición: <?= $detalle; ?>
                        <input type="number" name="numero_edicion" value="<?php echo $numero; ?>" />
                        <input type="hidden" name="id_edicion" value="<?php echo $id ?>" />
                        <input type="submit" name="btn_actualizar" value="Actualizar" />
                    </form>
                    <hr />
                <?php
            }
        ?>

    </body>
</html>