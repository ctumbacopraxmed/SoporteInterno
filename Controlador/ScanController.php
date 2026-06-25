<?php
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
        foreach ($servers as $server) {
            if ($server->getStatus() == 1) {
                echo "Revisión: ".$server->getIp_address()."\n";
                $id = $server->getId();
                $analyts = $this->analyts($server->getIp_address());
                print_r($analyts);
                if (!empty($analyts) && is_array($analyts)) {
                    $latency = new Servers();
                    $latency->setId($id);
                    $latency->setOnline($analyts['online']);
                    $latency->setLatency_ms($analyts['ms']);
                    $this->serversDAO->updateRevition($latency);
                }
            }
        }
    }
    public function analyts($host)
    {
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $cmd = $isWindows
            ? "ping -n 1 $host"
            : "ping -c 1 $host";

        $output = shell_exec($cmd);
        if (preg_match('/tiempo[=<]\s*([0-9]+)/i', $output, $m)) {
            return [
                'online' => 1,
                'ms' => (int)$m[1]
            ];
        }
        // Caso especial: tiempo<1ms
        if (stripos($output, 'tiempo<1') !== false) {
            return [
                'online' => 1,
                'ms' => 1
            ];
        }
        return [
            'online' => 0,
            'ms' => null
        ];
    }
}

$controller = new ScanController();
while (true) {
    $controller->validatedTimeServer();
    sleep(60);
}
