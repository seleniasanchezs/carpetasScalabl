<?php

class ActualizarRegistro
{
    private $id;
    private $registro;
    private $columna;

    #### SETs ####
    public function set_id($n)
    {
        $this->id = $n;
    }

    public function set_registro($s)
    {
        $this->registro = $s;
    }

    public function set_columna($n)
    {
        $this->columna = $n;
    }

    #### GETs ####
    public function get_id()
    {
        return $this->id;
    }

    public function get_registro()
    {
        return $this->registro;
    }

    public function get_columna()
    {
        return $this->columna;
    }

    #### FUNCIONES ####
    public function get_info()
    {
        echo "id: " . $this->id . " | registro: " . $this->registro . " | columna: " . $this->columna;
    }

    public function actualizar()
    {
        require("../../inc/configuracion.inc");
        $sql = "UPDATE home SET $this->columna = '$this->registro' WHERE id = $this->id";

        if (mysqli_query($connection, $sql) or die(mysqli_error($connection))) {
            echo "OK";
        } else {
            echo "ERROR";
        }
    }
}


class GetContenido {
    
}







?>