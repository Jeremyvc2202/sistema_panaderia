<?php
require_once 'includes/functions.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'usuario';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = 'controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerObj = new $controllerName();
    
    if (method_exists($controllerObj, $action)) {
        $controllerObj->$action();
    } else {
        die("La acción no existe");
    }
} else {
    die("El controlador no existe");
}
?>