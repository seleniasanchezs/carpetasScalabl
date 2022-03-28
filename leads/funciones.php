<?php

    require_once($_SERVER["DOCUMENT_ROOT"] . "/inc/funciones_inc.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/inc/geoip_funciones.php");

	if ( isset($_POST["btn_filtrar"]) ) filtrar_por_fecha($_POST);

    // #filtrar por fecha
    // function filtrar_por_fecha($post) {
    //     extract($post);
    //     require($_SERVER["DOCUMENT_ROOT"] . "/inc/configuracion.inc");
    //     $fecha_hasta = "2022-31-12 23:59:00";
    //     $sql = "UPDATE marketing_digital_fechas_filtrar SET fecha_desde = '$fecha_desde' WHERE id = 1";
    //     if ( mysqli_query($connection, $sql) ) {
    //         return header("Location: leads.php");
    //     }
    // }

    // function get_fechas_filtrar() {
    //     require($_SERVER["DOCUMENT_ROOT"] . "/inc/configuracion.inc");
    //     $sql = "SELECT * FROM marketing_digital_fechas_filtrar WHERE id = 1";
    //     $res = mysqli_query($connection, $sql);

    //     $f = array();
    //     $reg = mysqli_fetch_array($res);
    //     extract($reg);
    //     $f = array(
    //         "fecha_desde"   => $fecha_desde,
    //         "fecha_hasta"   => $fecha_hasta 
    //     );
    //     return $f;
    // }


    #mini leads
    function get_testing_acciones(){
        require($_SERVER["DOCUMENT_ROOT"] . "/inc/configuracion.inc");
        $sql = "SELECT  *  FROM marketing_digital_curso 
                ORDER BY fecha_registro DESC";
                    
        $res = mysqli_query($connection, $sql);
        $registro = array();
        
        while ( $f = mysqli_fetch_array($res) ) {
            extract($f);
            
            $registro[] = array(
                "id"                => $id,
                "desde_donde"       => utf8_encode($desde_donde),
                "version_web"       => utf8_encode($version_web),
                "pais"              => utf8_encode($pais),
                "ip"                => utf8_encode($ip),
                "fecha_registro"    => date_format(new DateTime($fecha_registro), "d/m/Y H:i:s"),
            );
        }
        return $registro;
    }

  

    # guarda visita a la página indicando cual titulo/subtitulo se mostró, si tiene o no seccion_profesor
    function guardar_visita($vw, $dd) {
        require($_SERVER["DOCUMENT_ROOT"] . '/inc/configuracion.inc');
        $fecha = date("Y-m-d H:i:s");
        $ip = get_client_ip();
        $pais = get_pais();
        // $ip = 0;
        // $pais = 0;

        $sql = "INSERT INTO marketing_digital_curso_visitas VALUES (null, '$dd', $vw, '$ip', '$pais', '$fecha')";
        mysqli_query($connection, $sql) or die(mysqli_error($connection));
    }

    # traer la cantidad de visitas al sitio
    function get_visitas($fd, $fh, $no_group = false) {
        require($_SERVER["DOCUMENT_ROOT"] . '/inc/configuracion.inc');
        $sql = "SELECT * FROM marketing_digital_curso_visitas WHERE fecha_registro >= '$fd' and fecha_registro <= '$fh'";
        if ( !$no_group ) $sql .= " GROUP BY ip";
        $resultado = mysqli_query($connection, $sql) or die(mysqli_error($connection));

        $visitas = array();

        while ($fila = mysqli_fetch_array($resultado)) {
            extract($fila);

            $visitas[] = array(
                'id'                        => $id,
                'desde_donde'               => utf8_encode($desde_donde),
                'version_web'               => utf8_encode($version_web),
                'pais'                      => utf8_encode($pais),
                'ip'                        => utf8_encode($ip),
                'fecha_registro'            => date_format(new DateTime($fecha_registro), "d/m/Y H:i:s")
            );
        }
        return $visitas;
    }

        # traer la cantidad de visitas al sitio
        function get_acciones_segun_variantes($fd, $fh, $no_group = false) {
            require($_SERVER["DOCUMENT_ROOT"] . '/inc/configuracion.inc');
            $sql = "SELECT * FROM marketing_digital_curso WHERE fecha_registro >= '$fd' and fecha_registro <= '$fh'";
            if ( !$no_group ) $sql .= " GROUP BY ip";
            $resultado = mysqli_query($connection, $sql) or die(mysqli_error($connection));
    
            $visitas = array();
    
            while ($fila = mysqli_fetch_array($resultado)) {
                extract($fila);
    
                $visitas[] = array(
                    'id'                        => $id,
                    'desde_donde'               => utf8_encode($desde_donde),
                    'version_web'               => utf8_encode($version_web),
                    'pais'                      => utf8_encode($pais),
                    'ip'                        => utf8_encode($ip),
                    'fecha_registro'            => date_format(new DateTime($fecha_registro), "d/m/Y H:i:s")
                );
            }
            return $visitas;
        }
    

    # procesa la info de los arrays para calcular cuántas conversiones en función de las visitas
    function procesar_info($visitas, $acciones) {
        $visitas = procesar_visitas($visitas);
        $conversiones = procesar_conversiones($acciones);
        mostrar($visitas, $conversiones);
    }
    
    # procecesar conversiones 
    function procesar_conversiones($acciones){
        $conversiones_curso_00 = 0;
        $conversiones_curso_01 = 0;
        $conversiones_curso__fem_00 = 0;
        $conversiones_curso__fem_01 = 0;
        
   
        foreach ( $acciones as $a ) {
            extract($a);
        
            if ( $desde_donde == "curso" && $version_web == 0) $conversiones_curso_00++;
            if ( $desde_donde == "curso" && $version_web == 1) $conversiones_curso_01++;

            if ( $desde_donde == "curso_fem-es"  && $version_web == 0) $conversiones_curso__fem_00++;
            if ( $desde_donde == "curso_fem-es"  && $version_web == 1) $conversiones_curso__fem_01++;
        }
        return array($conversiones_curso_00, $conversiones_curso_01,
        $conversiones_curso__fem_00, $conversiones_curso__fem_01);
    }

    # procecesar visitas 
    function procesar_visitas($visitas) {
   
        $visitas_curso_00 = 0;
        $visitas_curso_01 = 0;
        $visitas_curso_fem_00 = 0;
        $visitas_curso_fem_01 = 0;


        foreach ( $visitas as $v ) {
            extract($v);
            if ( $desde_donde == "curso" && $version_web == 0 ) $visitas_curso_00++;
            if ( $desde_donde == "curso" && $version_web == 1 ) $visitas_curso_01++;

            if ( $desde_donde == "curso_fem-es" && $version_web == 0 ) $visitas_curso_fem_00++;
            if ( $desde_donde == "curso_fem-es" && $version_web == 1 ) $visitas_curso_fem_01++;
        }
        return array($visitas_curso_00, $visitas_curso_01,
        $visitas_curso_fem_00, $visitas_curso_fem_01);
    }



    function mostrar($v, $c) {



        
        $porcentaje_curso_00 = $v[0] != 0 ? number_format((($c[0] / $v[0]) * 100), 2, ",", ".") . "%" : "0%";
        $porcentaje_curso_01 = $v[1] != 0 ? number_format((($c[1] / $v[1]) * 100), 2, ",", ".") . "%" : "0%";
        $porcentaje_curso_fem_00 = $v[2] != 0 ? number_format((($c[2] / $v[2]) * 100), 2, ",", ".") . "%" : "0%";
        $porcentaje_curso_fem_01 = $v[3] != 0 ? number_format((($c[3] / $v[3]) * 100), 2, ",", ".") . "%" : "0%";
       
        echo "<table class='table table-hover bg-light'>";
        echo "<tr class='bg-dark text-light'><th>Desde donde</th><th>Versión Web</th><th class='text-center'>Visitas</th><th class='text-center'>Conversiones</th><th class='text-center'>Porcentaje</th></tr>";
        # index

        
        # curso_02
        echo "<tr>";
        echo "<td>curso</td>";
        echo "<td>Sin temario ni preguntas frecuentes</td>";
        echo "<td class='text-center'>$v[0]</td>";
        echo "<td class='text-center'>$c[0]</td>";
        echo "<td class='text-center'>$porcentaje_curso_00</td>";
        echo "</tr>";
        
        # curso_03
        echo "<tr>";
        echo "<td>curso</td>";
        echo "<td>Sin temario ni preguntas frecuentes</td>";
        echo "<td class='text-center'>$v[1]</td>";
        echo "<td class='text-center'>$c[1]</td>";
        echo "<td class='text-center'>$porcentaje_curso_01</td>";
        echo "</tr>";

        # curso_fem_00
        echo "<tr>";
        echo "<td>curso_fem-es</td>";
        echo "<td>¿Quieres hacer crecer tu negocio? ¿Aprender a resolver problemas, organizarte e innovar? | Tenemos un Curso y una Comunidad para ti.</td>";
        echo "<td class='text-center'>$v[2]</td>";
        echo "<td class='text-center'>$c[2]</td>";
        echo "<td class='text-center'>$porcentaje_curso_fem_00</td>";
        echo "</tr>";

        # curso_fem_01
        echo "<tr>";
        echo "<td>curso_fem-es</td>";
        echo "<td>¿Eres emprendedora  y quieres crecer? ¿Sueñas con vivir de lo que te gusta?  | Tenemos un Curso y una Comunidad para ti.</td>";
        echo "<td class='text-center'>$v[3]</td>";
        echo "<td class='text-center'>$c[3]</td>";
        echo "<td class='text-center'>$porcentaje_curso_fem_01</td>";
        echo "</tr>";
        
        
       

        echo "</table>";
    }

?>