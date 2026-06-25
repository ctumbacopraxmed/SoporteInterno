<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once RUTA . '/Modelos/Conexion.php';
require_once RUTA . '/Controlador/RedirController.php';
require_once RUTA . '/Controlador/RuteoController.php';

class DashboardController
{
    private $clase = null;

    public function __construct()
    {
        $this->clase = 'Dashboard';
    }
    public function consultar()
    {
        $scripts = [];
        require HEADER;
        require_once RUTA . '/Vistas/' . $this->clase . '/' . $this->clase . '.php';
        require FOOTER;
    }
}
$controller = new DashboardController();
$accion = $_GET['a'] ?? null;
$id = $_GET['id'] ?? null;
if ($accion != null) {
    controladorrutas($controller, $accion, [$id]);
}
