<?php


    fillUrls();

    function fillUrls() {
        require("../inc/configuracion.inc");

        $sql = "SELECT * FROM libros";
        $resultado = mysqli_query($connection, $sql);

        while ( $fila = mysqli_fetch_array($resultado) ) {
            extract($fila);

            $titulo = utf8_encode($titulo);

            $url = normaliza($titulo);
            echo "Título: $titulo | url: $url<br />";
            $insert = "UPDATE libros SET url_es = '$url' WHERE id = $id";
            mysqli_query($connection, $insert) or die(mysqli_error($connection));
        }
    }

    function normaliza ($cadena){
        
        $originales 	= "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕñ";
        $modificadas 	= "aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRrn";
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = utf8_encode($cadena);        
        $cadena = preg_replace('/[^a-z0-9-]+/', '-', strtolower($cadena));
        
        // eliminar los guiones del principio y del final
        $cadena = substr($cadena, 0, 1) == "-" ? substr($cadena, 1) : $cadena;
        $cadena = substr($cadena, -1) == "-" ? substr($cadena, 0, -1) : $cadena;
		return $cadena;
	}

?>