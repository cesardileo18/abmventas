<?php

class Provincia{
    private $idprovincia;
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
        $sql = "INSERT INTO provincias (
                    nombre
                ) VALUES (
                    '" . $this->nombre ."'
                );";
        //Ejecuta la query
        if (!$mysqli->query($sql)) {
            printf("Error en query: %s\n", $mysqli->error . " " . $sql);
        }
        //Obtiene el id generado por la inserción
        $this->idprovincia = $mysqli->insert_id;
        //Cierra la conexión
        $mysqli->close();
    }

    public function obtenerTodos(){
        $aProvincias = null;
        $mysqli = new mysqli(Config::BBDD_HOST, Config::BBDD_USUARIO, Config::BBDD_CLAVE, Config::BBDD_NOMBRE);
        $resultado = $mysqli->query("SELECT 
            idprovincia,
            nombre
            FROM provincias ORDER BY nombre ASC");

        while ($fila = $resultado->fetch_assoc()) {
            $entidad = new Provincia();
            $entidad->idprovincia = $fila["idprovincia"];
            $entidad->nombre = $fila["nombre"];
            $aProvincias[] = $entidad;
        }
        return $aProvincias;
    }

}


?>