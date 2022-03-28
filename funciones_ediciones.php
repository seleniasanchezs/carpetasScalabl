<?php

    if ( isset($_POST["btn_actualizar"]) ) actualizar_edicion($_POST);

    function actualizar_edicion($post) {
        extract($post);
        require($_SERVER["DOCUMENT_ROOT"] . "/inc/configuracion.inc");
        $sql = "UPDATE curso_ediciones SET numero = $numero_edicion WHERE id = $id_edicion";
        
        if (mysqli_query($connection, $sql) or die(mysqli_error($connection))) {
            header("Location: ediciones.php?edicion_actualizada");
        } else {
            header("Location: ediciones.php?error");
        }
    }

    function get_ediciones() {
        require($_SERVER["DOCUMENT_ROOT"] . "/inc/configuracion.inc");
        $sql = "SELECT * FROM curso_ediciones";
        $res = mysqli_query($connection, $sql);

		$ediciones = array();
		while ( $fila = mysqli_fetch_array($res) ) {
			extract($fila);
			$ediciones[] = array(
				"id"			=> $id,
                "detalle"       => $detalle,
                "numero"        => trim($numero)
			);
		}
		return $ediciones;
    }
?>