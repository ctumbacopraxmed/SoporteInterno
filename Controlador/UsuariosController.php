<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once RUTA . '/Modelos/Conexion.php';
require_once RUTA . '/Modelos/DTO/Users.php';
require_once RUTA . '/Modelos/DAO/UsersDAO.php';
require_once RUTA . '/Controlador/RedirController.php';
require_once RUTA . '/Controlador/RuteoController.php';

class UsuariosController
{
    private $usersDAO = null;
    private $clase = null;

    public function __construct()
    {
        $this->usersDAO = new UsersDAO();
        $this->clase = 'Usuarios';
    }
    public function consultar()
    {
        $scripts = [
            'usuarios.js',
            'funciones.min.js',
            'tabla.js'
        ];
        $users = $this->usersDAO->consult();
        require HEADER;
        require_once RUTA . '/Vistas/' . $this->clase . '/' . $this->clase . '.php';
        require FOOTER;
    }
    public function create()
    {
        if (
            isset(
                $_POST['name'],
                $_POST['user'],
                $_POST['password']
            ) && $_POST['name'] != null
            && $_POST['user'] != null
            && $_POST['password'] != null
        ) {
            if ($this->usersDAO->repeated(trim($_POST['user']))) {
                $user = new Users();
                $user->setName(trim($_POST['name']));
                $user->setEmail(trim($_POST['user']));
                $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
                $response = $this->usersDAO->create($user);
                if ($response > 0) {
                    $_SESSION['ok'] = "Usuario creado correctamente";
                } else {
                    $_SESSION['error'] = "Ocurrio un error al guardar";
                }
            }
        }
        redirect($this->clase);
    }
    public function manage()
    {
        if (isset($_GET['id']) && $_GET['id'] != null) {
            $scripts = [
                'usuarios.js',
                'funciones.min.js'
            ];
            $id = $_GET['id'];
            $user = $this->usersDAO->consultId($id);
            if ($user != null) {
                require HEADER;
                require_once RUTA . '/Vistas/' . $this->clase . '/Manage.php';
                require FOOTER;
            }
        } else {
            redirect($this->clase);
        }
    }
}
$controller = new UsuariosController();
$accion = $_GET['a'] ?? null;
$id = $_GET['id'] ?? null;
if ($accion != null) {
    controladorrutas($controller, $accion, [$id]);
}
