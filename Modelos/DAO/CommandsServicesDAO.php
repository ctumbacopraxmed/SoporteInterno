<?php

class CommandsServicesDAO
{
    private $conexion = null;
    private $tabla = "commands_services";
    private $clase = "CommandsServices";
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
    public function create(CommandsServices $data)
    {
        $sql = "INSERT INTO `$this->tabla` (`id`, `server_id`, `service_id`, `name`, `command`) VALUES (NULL, ?, ?, ?, ?)";
        $array = array(
            $data->getServer_id(),
            $data->getService_id(),
            $data->getName(),
            $data->getCommand(),
        );
        $result = $this->conexion->ejecutarActualizacion($sql, $array);
        return $result;
    }
    public function update(CommandsServices $data)
    {
        $sql = "UPDATE `$this->tabla` SET `name`=?, `command`=? WHERE `id`=?";
        $array = array(
            $data->getName(),
            $data->getCommand(),
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
        $sql = "SELECT * FROM $this->tabla WHERE server_id=? AND service_id=? AND name=?";
        $result = $this->conexion->ejecutarConsultaClase($sql, $data, $this->clase);
        if (sizeof($result) > 0) {
            return false;
        } else {
            return true;
        }
    }
}
