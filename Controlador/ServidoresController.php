<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once RUTA . '/Modelos/Conexion.php';
require_once RUTA . '/Modelos/DTO/Servers.php';
require_once RUTA . '/Modelos/DAO/ServersDAO.php';
require_once RUTA . '/Controlador/RedirController.php';
require_once RUTA . '/Controlador/RuteoController.php';
require_once RUTA . '/Controlador/KeysController.php';
require_once RUTA . '/Controlador/SSHController.php';

class ServidoresController
{
    private $serversDAO = null;
    private $keysController = null;
    private $sshController = null;
    private $clase = null;
    private $description = null;

    public function __construct()
    {
        $this->serversDAO = new ServersDAO();
        $this->keysController = new KeysController();
        $this->sshController = new SSHController();
        $this->clase = 'Servidores';
        $this->description = 'Administración y supervisión de servicios';
    }
    public function consultar()
    {
        $scripts = [
            'servers.js',
            'funciones.min.js',
            'tabla.js'
        ];
        require HEADER;
        require_once RUTA . '/Vistas/' . $this->clase . '/' . $this->clase . '.php';
        require FOOTER;
    }
    public function stats()
    {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $stats = $this->serversDAO->stats();
            echo json_encode(['success' => true, 'data' => $stats[0]]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        }
    }
    public function list()
    {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $list = $this->serversDAO->list();
            echo json_encode(['success' => true, 'data' => $list]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        }
    }
    public function status()
    {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $status = $this->serversDAO->status();
            $stats = $this->serversDAO->stats();
            echo json_encode(['success' => true, 'data' => array("status" => $status, "stats" => $stats[0])]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        }
    }
    public function create()
    {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);
            if (!empty($data)) {
                if ($this->serversDAO->repeated(trim($data['ip_address']))) {
                    $keys = $this->keysController->encrypt(trim($data['password']));
                    $server = new Servers();
                    $server->setName(trim($data['name']));
                    $server->setIp_address(trim($data['ip_address']));
                    $server->setUser(trim($data['user']));
                    $server->setPassword_encrypted($keys);
                    $server->setOperating_system(trim($data['operating_system']));
                    $server->setEnvironment(trim($data['environment']));
                    $response = $this->serversDAO->create($server);
                    if ($response > 0) {
                        echo json_encode(['success' => true, 'message' => 'Servidor registrado.']);
                        return;
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Ocurrio un error inesperado.']);
                        return;
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'La servidor ya existe.']);
                    return;
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
    public function manage()
    {
        if (isset($_GET['id']) && $_GET['id'] != null) {
            $scripts = [
                'serversAction.js',
                'funciones.min.js'
            ];
            $id = $_GET['id'];
            $server = $this->manageDataServer($id);
            if ($server != null) {
                $server = $server[0];
                require HEADER;
                require_once RUTA . '/Vistas/' . $this->clase . '/Manage.php';
                require FOOTER;
            }
        } else {
            redirect($this->clase);
        }
    }
    private function manageDataServer($id)
    {
        $response = null;
        $data = $this->serversDAO->manage($id);
        if (is_array($data) && !empty($data)) {
            $resultado = [];
            foreach ($data as $item) {
                $key = $item['id'];
                if (!isset($resultado[$key])) {
                    $resultado[$key] = [
                        'id' => $item['id'],
                        'serverName' => $item['serverName'],
                        'ip_address' => $item['ip_address'],
                        'user' => $item['user'],
                        'operating_system' => $item['operating_system'],
                        'environment' => $item['environment'],
                        'online' => $item['online'],
                        'services' => []
                    ];
                }
                if ($item['serviceId'] != null) {
                    if (!isset($resultado[$key]['services'][$item['serviceId']])) {
                        $resultado[$key]['services'][$item['serviceId']] = [
                            'serviceId' => $item['serviceId'],
                            'serviceName' => $item['serviceName'],
                            'description' => $item['description'],
                            'serviceLog' => $item['serviceLog'],
                            'commands' => []
                        ];
                    }
                    if ($item['commandId'] != null) {
                        $resultado[$key]['services'][$item['serviceId']]['commands'][] = [
                            'commandId' => $item['commandId'],
                            'commandName' => $item['commandName'],
                            'command' => $item['command']
                        ];
                    }
                }
            }
            foreach ($resultado as &$server) {
                $server['services'] = array_values($server['services']);
            }
            unset($server);
            $response = array_values($resultado);
        }
        return $response;
    }
}



$controller = new ServidoresController();
$accion = $_GET['a'] ?? null;
$id = $_GET['id'] ?? null;
if ($accion != null) {
    controladorrutas($controller, $accion, [$id]);
}
