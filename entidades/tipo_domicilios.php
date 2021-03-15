<?php

class tipoDomicilio{
    private $idtipo;
    private $nombre;

    public function __get($atributo) {
        return $this->$atributo;
    }

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;
        return $this;
    }
    public function insertar(){
        //Instancia la clase mysqli con el constructor parametrizado
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        //Arma la query
        $sql = "INSERT INTO tipo_domicilios ( 
                    tipo,
                    nombre
                ) VALUES (
                    '" . $this->tipo ."', 
                    '" . $this->nombre ."'
                );";
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        //Obtiene el id generado por la inserción
        $this->idtipo = $mysqli->insert_id;
        //Cierra la conexión
        $mysqli->close();
    } 

    public function actualizar(){

        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE tipo_domicilios  SET
                tipo = '".$this->tipo."',
                nombre =  '".$this->nombre."'
                WHERE idtipo = " . $this->idtipo;
          
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

}


?>