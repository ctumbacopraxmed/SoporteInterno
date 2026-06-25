<?php

class UsersDAO
{
    private $conexion = null;
    private $tabla = "users";
    private $clase = "Users";
    function __construct()
    {
        $this->conexion = Conexion::getConexion();
    }
    public function login($email)
    {
        $sql = "SELECT * FROM $this->tabla WHERE email=? AND status=?";
        $result = $this->conexion->ejecutarConsultaClase($sql, array($email, 1), $this->clase);
        return $result;
    }
    public function consult()
    {
        $array = array();
        $sql = "SELECT * FROM $this->tabla";
        $resulset = $this->conexion->ejecutarConsultaClase($sql, $array, $this->clase);
        return $resulset;
    }
    public function create(Users $data)
    {
        $sql = "INSERT INTO `$this->tabla` (`id`, `name`, `email`, `password`) VALUES (NULL, ?, ?, ?)";
        $array = array(
            $data->getName(),
            $data->getEmail(),
            $data->getPassword()
        );
        $result = $this->conexion->ejecutarActualizacion($sql, $array);
        return $result;
    }
    public function update(Users $data)
    {
        $sql = "UPDATE `$this->tabla` SET `name`=?, `password`=?, `rol`=?, `status`=? WHERE `id`=?";
        $array = array(
            $data->getName(),
            $data->getPassword(),
            $data->getRol(),
            $data->getStatus(),
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
    public function repeated($email)
    {
        $sql = "SELECT * FROM $this->tabla WHERE email=?";
        $result = $this->conexion->ejecutarConsultaClase($sql, array($email), $this->clase);
        if (sizeof($result) > 0) {
            return false;
        } else {
            return true;
        }
    }
}
