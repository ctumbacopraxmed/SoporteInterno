#!/usr/bin/php
<?php

declare(ticks=1);
require_once dirname(__DIR__) . '/config/config.php';
require_once RUTA . '/Modelos/Conexion.php';
require_once RUTA . '/Modelos/DTO/Servers.php';
require_once RUTA . '/Modelos/DAO/ServersDAO.php';

class ScanController
{
    private $serversDAO = null;

    public function __construct()
    {
        $this->serversDAO = new ServersDAO();
    }
    public function validatedTimeServer()
    {
        $servers = $this->serversDAO->consult();
        if (!empty($servers) && is_array($servers)) {
            foreach ($servers as $server) {
                if ($server->getStatus() == 1) {
                    $this->log($server->getIp_address());
                    $id = $server->getId();
                    $analyts = $this->analyts($server->getIp_address());
                    $this->log(json_encode($analyts));
                    if (!empty($analyts) && is_array($analyts)) {
                        $latency = new Servers();
                        $latency->setId($id);
                        $latency->setOnline($analyts['online']);
                        $latency->setLatency_ms($analyts['ms']);
                        $this->serversDAO->updateRevition($latency);
                    } else {
                        $this->log("ERROR AL MONITOREAR", "ERROR");
                    }
                }
            }
        } else {
            $this->log("NO HAY SERVIDORES REGISTRADOS", "ERROR");
        }
    }
    public function analyts($host)
    {
        $cmd = "ping -c 1 -W 1 -n " . escapeshellarg($host);
        $output = shell_exec($cmd);

        if (preg_match('/time=([\d\.]+)/', $output, $m)) {
            return [
                'online' => 1,
                'ms' => (float)$m[1]
            ];
        }

        return [
            'online' => 0,
            'ms' => null
        ];
    }
    public function log($msg, $level = "INFO")
    {
        $fecha = date("Y-m-d H:i:s");
        error_log("[$fecha] [$level] $msg\n", 3, "php://stderr");
    }
}
pcntl_signal(SIGTERM, function () {
    echo "TODO BIEN";
    exit;
});
$controller = new ScanController();
while (true) {
    $controller->validatedTimeServer();
    sleep(120);
}
