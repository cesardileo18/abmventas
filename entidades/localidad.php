<?php

class Localidad{
    private $idlocalidad;
    private $nombre;
    private $fk_idprovincia;
    private $cod_postal;

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
        $sql = "INSERT INTO localidades (
                    nombre, 
                    fk_idprovincia, 
                    cod_postal
                ) VALUES (
                    '" . $this->nombre ."', 
                    '" . $this->fk_idprovincia ."', 
                    '" . $this->cod_postal ."'
                );";
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        //Obtiene el id generado por la inserción
        $this->idlocalidad = $mysqli->insert_id;
        //Cierra la conexión
        $mysqli->close();
    }
    public function actualizar(){

        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "UPDATE localidades SET
                nombre = '".$this->nombre."',
                fk_idprovincia = '".$this->fk_idprovincia."',
                cod_postal =  '".$this->cod_postal."'
                WHERE idlocalidad = " . $this->idlocalidad;
          
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        $mysqli->close();
    }

    public function obtenerPorProvincia($idProvincia){
        $aLocalidades = null;
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $sql = "SELECT 
            idlocalidad,
            nombre, 
            cod_postal
            FROM localidades 
            WHERE fk_idprovincia = $idProvincia
            ORDER BY idlocalidad DESC";
        $resultado = $mysqli->query($sql);

        while ($fila = $resultado->fetch_assoc()) {
            $aLocalidades[] = array(
                "idlocalidad" => $fila["idlocalidad"],
                "nombre" => $fila["nombre"],
                "cod_postal" => $fila["cod_postal"]);
       
        }
        return $aLocalidades;
    }

}


?>