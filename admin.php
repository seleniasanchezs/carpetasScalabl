<?php
    require("funciones.php");
    
    #if ( !isset($_SESSION["usuario"]) ) header("Location: login.php?sessionOut");
    #if ( $_SESSION["usuario"]["admin"] != 1 ) header("Location: login.php?sessionOut");

    $resumen = resumen_admin();

    // calcular totales
    $cant = 0;
    $total_importe = 0;
    $total_ganancia = 0;
    foreach ( $resumen as $r ) {
        $cant++;
        $total_importe += $r["importe_neto"];
        $total_ganancia += $r["ganancia"];    
    }
    $total_importe = number_format($total_importe, 2, ",", ".");
    $total_ganancia = number_format($total_ganancia, 2, ",", ".");

    
?>

<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Scalabl | Programa de Alianzas</title>
        <meta name="description" content="Panel">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../inc/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/estilos.css">
    </head>
    <body>


        <div class="container-fluid bg-scalabl">
            <div class="row">
                <div class="col-10 text-white pt-3 pb-2">
                    <h1><b>Scalabl</b> | 
                        <?php echo $_SESSION["usuario"]["admin"] == 1 ? "Programa de Alianzas" : $_SESSION["usuario"]["alianza"]; ?>
                    </h1>
                </div>
                <div class="col-2 text-right"><a class="nav-link text-white" href="funciones.php?destroy">Salir</a></div>
            </div>
        </div>

        <div class="container-fluid mb-5 pb-5">
            <div class="row justify-content-center">
                <div class="col-10">

                    <label class="mt-5 text-info"><b>Resumen</b></label>
                    <p class="mb-0">Cursos vendidos: <?php echo $cant; ?></p>
                    <p class="mb-0">Ganancia: USD <?php echo $total_ganancia; ?></p>                    
                    <p class="mb-0">Cursos históricos: <?php echo $cant; ?></p>
                    <p class="mb-0">Saldo acumulado: USD <?php echo $total_ganancia; ?></p>                    
                    

                    <!-- resumen -->
                    <table class="table table-sm table-hover my-5">
                        <thead class="bg-scalabl text-white">
                            <th>Referencia</th>                            
                            <th class="text-right px-5">Importe Neto</th>
                            <th class="text-center">Participantes</th>
                            <th class="text-center">Ganancia</th>
                            <th class="text-center">Revenue Share</th>
                            <th class="text-center">Descuento</th>        
                            <th class="text-center">Participantes Históricos</th>                    
                            <th class="text-center">Ganancia Histórica</th>                                                
                        </thead>
                        <tbody>
                            <?php
                                foreach ( $resumen as $r ) {
                                    $importe_neto = number_format($r["importe_neto"], 2, ",", ".");                                  
                                    $ganancia = number_format($r["ganancia"], 2, ",", ".");
                                            
                                    echo "<tr>";
                                    echo "<td><a class='text-primary' href='registros.php?ref=" . $r["ref"]  ."'>" . $r["ref"] . "</a></td>";                                    
                                    echo "<td class='text-right px-5'>" . $r["moneda"] . " " . $importe_neto . "</td>";
                                    echo "<td class='text-center'>" . $r["cant_reg"] . "</td>";
                                    echo "<td class='text-center'>" . $r["moneda"] . " " . $ganancia . "</td>";
                                    echo "<td class='text-center'>" . $r["revenue"] . "%</td>";
                                    echo "<td class='text-center'>" . $r["descuento"] . "%</td>";                                                                        
                                    echo "<td class='text-center'>" . $r["cant_reg"] . "</td>";
                                    echo "<td class='text-center'>" . $r["moneda"] . " " . $ganancia . "</td>";
                                    echo "</tr>";
                                }
                                
                                    # totales
                                    echo "<tr>";
                                    echo "<td><b>Totales</b></td>";
                                    echo "<td class='text-right text-info px-5'><b>USD $total_importe</b></td>";
                                    echo "<td class='text-center text-info'><b>$cant</b></td>";
                                    echo "<td class='text-center text-info'><b>USD $total_ganancia</b></td>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td class='text-center text-info'><b>$cant</b></td>";
                                    echo "<td class='text-center text-info'><b>USD $total_ganancia</b></td>";
                                    echo "</tr>";
                                ?>
                        </tbody>
                    </table>

                   
                </div>
            </div>
        </div>
        
        <script src="../inc/js/jquery-3.4.1.min.js"></script>
        <script src="../inc/js/popper.min.js"></script>
        <script src="../inc/js/bootstrap.min.js"></script>        
    </body>
</html>