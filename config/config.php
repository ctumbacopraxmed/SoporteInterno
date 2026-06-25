<?php
ini_set('session.gc_maxlifetime', 7200);
if (!isset($_SESSION)) {
    session_name("inventario");
    session_start();
}
date_default_timezone_set('America/Guayaquil');
define('DBUSER', 'praxmed');
define('DBPWD', 'praxmed');
define('DBHOST', '127.0.0.1');
define('DBNAME', 'appecua');
define('NOMBRE', 'Soporte');
define('RUTA', dirname(__DIR__));
define('RUTA_WEB', '/appecua');
define('APP_ENCRYPTION_KEY', 'f3c51176c4443cab04ddd7cc9621308067086b7c2f84b97f237463b9280e7293');
define('HEADER', RUTA . '/Vistas/Plantillas/Header.php');
define('FOOTER', RUTA . '/Vistas/Plantillas/Footer.php');
define('SINACCESO', RUTA . '/Vistas/Plantillas/Nopermitido.php');
define('ACTIVE', 'nav-item flex items-center space-x-3 px-4 py-3 rounded-xl bg-gradient-to-r from-indigo-50 to-purple-50 text-purple-700 font-medium shadow-sm transition-all');
define('INACTIVE', 'nav-item flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium transition-all duration-200');
