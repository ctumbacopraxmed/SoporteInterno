<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once RUTA . '/Modelos/Conexion.php';
require_once RUTA . '/Modelos/DTO/Services.php';
require_once RUTA . '/Modelos/DAO/ServicesDAO.php';
require_once RUTA . '/Modelos/DTO/CommandsServices.php';
require_once RUTA . '/Modelos/DAO/CommandsServicesDAO.php';
require_once RUTA . '/Controlador/RedirController.php';
require_once RUTA . '/Controlador/RuteoController.php';

class ServiciosController
{
    private $servicesDAO = null;
    private $commandsServicesDAO = null;
    private $clase = null;
    private $description = null;

    public function __construct()
    {
        $this->servicesDAO = new ServicesDAO();
        $this->commandsServicesDAO = new CommandsServicesDAO();
        $this->clase = 'Servicios';
    }
    public function create()
    {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);
            if (!empty($data)) {
                if ($this->servicesDAO->repeated(array($data['serverId'], trim($data['name'])))) {
                    $service = new Services();
                    $service->setServer_id($data['serverId']);
                    $service->setName(trim($data['name']));
                    $service->setDescription(trim($data['description']) ?? null);
                    $service->setFile_log($data['file_log']);
                    $response = $this->servicesDAO->create($service);
                    if ($response > 0) {
                        echo json_encode(['success' => true, 'message' => 'Servicio registrado.']);
                        return;
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Ocurrio un error inesperado.']);
                        return;
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'La servicio ya existe.']);
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
    public function createcommands()
    {
        header('Content-Type: application/json; charset=utf-8');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);
            if (!empty($data)) {
                if ($this->commandsServicesDAO->repeated(array($data['serverId'], trim($data['serviceId']), trim($data['name'])))) {
                    $command = new CommandsServices();
                    $command->setServer_id($data['serverId']);
                    $command->setService_id($data['serviceId']);
                    $command->setName(trim($data['name']));
                    $command->setCommand(trim($data['command']));
                    $response = $this->commandsServicesDAO->create($command);
                    if ($response > 0) {
                        echo json_encode(['success' => true, 'message' => 'Comando registrado.']);
                        return;
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Ocurrio un error inesperado.']);
                        return;
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'La Comando ya existe.']);
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
}



$controller = new ServiciosController();
$accion = $_GET['a'] ?? null;
$id = $_GET['id'] ?? null;
if ($accion != null) {
    controladorrutas($controller, $accion, [$id]);
}
