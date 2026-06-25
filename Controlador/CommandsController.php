<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once RUTA . '/Modelos/Conexion.php';
require_once RUTA . '/Modelos/DTO/Servers.php';
require_once RUTA . '/Modelos/DAO/ServersDAO.php';
require_once RUTA . '/Controlador/RedirController.php';
require_once RUTA . '/Controlador/RuteoController.php';
require_once RUTA . '/Controlador/KeysController.php';
require_once RUTA . '/Controlador/SSHController.php';

class CommandsController
{
    private $serversDAO = null;
    private $keysController = null;
    private $sshController = null;

    public function __construct()
    {
        $this->serversDAO = new ServersDAO();
        $this->keysController = new KeysController();
        $this->sshController = new SSHController();
    }
    public function execute()
    {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);
            if (!empty($data)) {
                $serverId = $data['serverId'];
                $serviceId = $data['serviceId'];
                $commandId = $data['commandId'];
                $service = $this->serversDAO->execute(array($serverId, $serviceId, $commandId));
                if (!empty($service) && is_array($service)) {
                    $service = $service[0];
                    $password = $this->keysController->decrypt($service['password_encrypted']);
                    $execute = $this->sshController->execute(
                        $service['ip_address'],
                        $service['user'],
                        $service['port'],
                        $password,
                        $service['command']
                    );
                    if ($execute['success']) {
                        echo json_encode([
                            'success' => true,
                            'message' => 'Comando ejectuado exitosamente.',
                            'command' => $service['command'],
                            'output' => $execute['output']
                        ]);
                    } else {
                        echo json_encode([
                            'success' => false,
                            'message' => 'Error inesperado',
                            'command' => $service['command'],
                            'output' => $execute['message']
                        ]);
                        return;
                    }
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Ocurrio un error inesperado.']);
                return;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
    }
    public function execute_logs()
    {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);
            if (!empty($data)) {
                $serverId = $data['serverId'];
                $serviceId = $data['serviceId'];
                $service = $this->serversDAO->executelogs(array($serverId, $serviceId));
                if (!empty($service) && is_array($service)) {
                    $service = $service[0];
                    $password = $this->keysController->decrypt($service['password_encrypted']);
                    $execute = $this->sshController->execute(
                        $service['ip_address'],
                        $service['user'],
                        $service['port'],
                        $password,
                        $service['file_log']
                    );
                    if ($execute['success']) {
                        echo json_encode([
                            'success' => true,
                            'message' => 'Comando ejectuado exitosamente.',
                            'command' => $service['file_log'],
                            'output' => $execute['output']
                        ]);
                    } else {
                        echo json_encode([
                            'success' => false,
                            'message' => 'Error inesperado',
                            'command' => $service['file_log'],
                            'output' => $execute['message']
                        ]);
                        return;
                    }
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Ocurrio un error inesperado.']);
                return;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }
    }
}



$controller = new CommandsController();
$accion = $_GET['a'] ?? null;
$id = $_GET['id'] ?? null;
if ($accion != null) {
    controladorrutas($controller, $accion, [$id]);
}
