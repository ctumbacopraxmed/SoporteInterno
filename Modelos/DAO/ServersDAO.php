<?php

class ServersDAO
{
    private $conexion = null;
    private $tabla = "servers";
    private $clase = "Servers";
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
    public function create(Servers $data)
    {
        $sql = "INSERT INTO `$this->tabla` (`id`, `name`, `ip_address`, `port`, `user`, `password_encrypted`, `operating_system`,`environment`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
        $array = array(
            $data->getName(),
            $data->getIp_address(),
            $data->getPort(),
            $data->getUser(),
            $data->getPassword_encrypted(),
            $data->getOperating_system(),
            $data->getEnvironment(),
        );
        $result = $this->conexion->ejecutarActualizacion($sql, $array);
        return $result;
    }
    public function update(Servers $data)
    {
        $sql = "UPDATE `$this->tabla` SET `name`=?, `ip_address`=?, `port`=?, `user`=?, `password_encrypted`=?, `operating_system`=? WHERE `id`=?";
        $array = array(
            $data->getName(),
            $data->getIp_address(),
            $data->getPort(),
            $data->getUser(),
            $data->getPassword_encrypted(),
            $data->getOperating_system(),
            $data->getId()
        );
        $result = $this->conexion->ejecutarActualizacion($sql, $array);
        return $result;
    }
    public function updateRevition(Servers $data)
    {
        $sql = "UPDATE `$this->tabla` SET `online`=?, `latency_ms`=?, `last_revision`=current_timestamp() WHERE `id`=?";
        $array = array(
            $data->getOnline(),
            $data->getLatency_ms(),
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
        $sql = "SELECT * FROM $this->tabla WHERE ip_address=?";
        $result = $this->conexion->ejecutarConsultaClase($sql, array($data), $this->clase);
        if (sizeof($result) > 0) {
            return false;
        } else {
            return true;
        }
    }
    public function stats()
    {
        $sql = "SELECT
        COUNT(*) AS servers_quantity,
        SUM(online = 1) AS server_online,
        SUM(online = 0) AS server_offline,
        SUM(
        online = 1 AND latency_ms >= (
        SELECT CAST(config_value AS UNSIGNED)
        FROM config
        WHERE config_key = 'latency_warning'
        )
        ) AS server_latency
        FROM servers
        WHERE status = 1";
        $result = $this->conexion->ejecutarConsultaAssoc($sql, array());
        return $result;
    }
    public function list()
    {
        $sql = "SELECT
        s.id,
        s.name,
        s.ip_address,
        s.operating_system,
        s.environment,
        CASE
        WHEN s.online = 0 THEN 'offline'
        WHEN s.latency_ms > cfg.latency_warning THEN 'warning'
        ELSE 'online'
        END AS `status`,
        s.latency_ms,
        s.last_revision,
        CASE
        WHEN TIMESTAMPDIFF(MINUTE, s.last_revision, NOW()) < 60
        THEN CONCAT(TIMESTAMPDIFF(MINUTE, s.last_revision, NOW()), ' min')
        WHEN TIMESTAMPDIFF(HOUR, s.last_revision, NOW()) < 24
        THEN CONCAT(TIMESTAMPDIFF(HOUR, s.last_revision, NOW()), ' h')
        ELSE CONCAT(TIMESTAMPDIFF(DAY, s.last_revision, NOW()), ' días')
        END AS time_revition
        FROM servers s
        CROSS JOIN (
        SELECT CAST(config_value AS UNSIGNED) AS latency_warning
        FROM config
        WHERE config_key = 'latency_warning'
        ) cfg
        WHERE s.`status` = 1";
        $result = $this->conexion->ejecutarConsultaAssoc($sql, array());
        return $result;
    }
    public function status()
    {
        $sql = "SELECT
        s.id,
        CASE
        WHEN s.online = 0 THEN 'offline'
        WHEN s.latency_ms > cfg.latency_warning THEN 'warning'
        ELSE 'online'
        END AS `status`,
        s.latency_ms,
        s.last_revision,
        CASE
        WHEN TIMESTAMPDIFF(MINUTE, s.last_revision, NOW()) < 60
        THEN CONCAT(TIMESTAMPDIFF(MINUTE, s.last_revision, NOW()), ' min')
        WHEN TIMESTAMPDIFF(HOUR, s.last_revision, NOW()) < 24
        THEN CONCAT(TIMESTAMPDIFF(HOUR, s.last_revision, NOW()), ' h')
        ELSE CONCAT(TIMESTAMPDIFF(DAY, s.last_revision, NOW()), ' días')
        END AS time_revition
        FROM servers s
        CROSS JOIN (
        SELECT CAST(config_value AS UNSIGNED) AS latency_warning
        FROM config
        WHERE config_key = 'latency_warning'
        ) cfg
        WHERE s.`status` = 1";
        $result = $this->conexion->ejecutarConsultaAssoc($sql, array());
        return $result;
    }
    public function manage($id)
    {
        $sql = "SELECT a.id id,
        a.name serverName,
        a.ip_address ip_address,
        a.`user` user,
        a.operating_system,
        a.environment,
        a.online,
        b.id serviceId,
        b.`name` serviceName,
        b.description,
        b.file_log serviceLog,
        c.id commandId,
        c.`name` commandName,
        c.command
        FROM servers a
        LEFT JOIN services b ON a.id=b.server_id AND b.`status`=1
        LEFT JOIN commands_services c ON b.id=c.service_id AND a.id=c.server_id AND c.`status`=1
        WHERE a.id=?";
        $result = $this->conexion->ejecutarConsultaAssoc($sql, array($id));
        return $result;
    }
    public function execute($data)
    {
        $sql = "SELECT a.`user`,
        a.ip_address, 
        a.`port`, 
        a.password_encrypted,
        c.command
        FROM servers a
        INNER JOIN services b ON a.id=b.server_id
        INNER JOIN commands_services c ON a.id=c.server_id AND b.id=c.service_id
        WHERE a.id=?
        AND b.id=?
        AND c.id=?";
        $result = $this->conexion->ejecutarConsultaAssoc($sql, $data);
        return $result;
    }
    public function executelogs($data)
    {
        $sql = "SELECT a.`user`,
        a.ip_address, 
        a.`port`, 
        a.password_encrypted,
        b.file_log
        FROM servers a
        INNER JOIN services b ON a.id=b.server_id
        WHERE a.id=?
        AND b.id=?";
        $result = $this->conexion->ejecutarConsultaAssoc($sql, $data);
        return $result;
    }
}
