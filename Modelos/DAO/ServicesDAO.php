<?php

class ServicesDAO
{
    private $conexion = null;
    private $tabla = "services";
    private $clase = "Services";
    function __construct()
    {
        $this->conexion = Conexion::getConexion();
    }
    public function consult()
    {
        $array = array();
        $sql = "SELECT * FROM $this->tabla";
        $resulset = $this->conexion->ejecutarConsultaClase($sql, $array, $this->clase);
        return $resulset;
    }
    public function create(Services $data)
    {
        $sql = "INSERT INTO `$this->tabla` (`id`, `server_id`, `name`, `description`, `file_log`) VALUES (NULL, ?, ?, ?, ?)";
        $array = array(
            $data->getServer_id(),
            $data->getName(),
            $data->getDescription(),
            $data->getFile_log(),
        );
        $result = $this->conexion->ejecutarActualizacion($sql, $array);
        return $result;
    }
    public function update(Services $data)
    {
        $sql = "UPDATE `$this->tabla` SET `name`=?, `description`=?, `file_log`=? WHERE `id`=?";
        $array = array(
            $data->getName(),
            $data->getDescription(),
            $data->getFile_log(),
            $data->getId()
        );
        $result = $this->conexion->ejecutarActualizacion($sql, $array);
        return $result;
    }
    public function delete($id)
    {
        $num_filas_afectadas = $this->conexion->ejecutarActualizacion("DELETE FROM $this->tabla WHERE id=?", array($id));
        return $num_filas_afectadas;
    }
    public function consultId($id)
    {
        $sql = "SELECT * FROM $this->tabla WHERE id=?";
        $result = $this->conexion->ejecutarConsultaClase($sql, array($id), $this->clase);
        return $result;
    }
    public function repeated($data)
    {
        $sql = "SELECT * FROM $this->tabla WHERE server_id=? AND name=?";
        $result = $this->conexion->ejecutarConsultaClase($sql, $data, $this->clase);
        if (sizeof($result) > 0) {
            return false;
        } else {
            return true;
        }
    }
}
