<?php
require_once 'models/Cliente.php';
require_once 'includes/functions.php';

class ClienteController {
    
    public function index() {
        requireLogin();
        
        $cliente = new Cliente();
        $stmt = $cliente->leer();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'views/clientes/index.php';
    }
    
    public function crear() {
        requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cliente = new Cliente();
            $cliente->nombre = sanitize($_POST['nombre']);
            $cliente->apellido = sanitize($_POST['apellido']);
            $cliente->telefono = sanitize($_POST['telefono']);
            $cliente->direccion = sanitize($_POST['direccion']);
            $cliente->email = sanitize($_POST['email']);
            
            if ($cliente->crear()) {
                showMessage("Cliente creado exitosamente", "success");
                redirect("index.php?controller=cliente&action=index");
            } else {
                showMessage("Error al crear cliente", "error");
            }
        }
        
        require_once 'views/clientes/crear.php';
    }
    
    public function editar() {
        requireLogin();
        
        $cliente = new Cliente();
        $cliente->id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cliente->nombre = sanitize($_POST['nombre']);
            $cliente->apellido = sanitize($_POST['apellido']);
            $cliente->telefono = sanitize($_POST['telefono']);
            $cliente->direccion = sanitize($_POST['direccion']);
            $cliente->email = sanitize($_POST['email']);
            
            if ($cliente->actualizar()) {
                showMessage("Cliente actualizado exitosamente", "success");
                redirect("index.php?controller=cliente&action=index");
            } else {
                showMessage("Error al actualizar cliente", "error");
            }
        }
        
        $cliente->leerUno();
        require_once 'views/clientes/editar.php';
    }
    
    public function eliminar() {
        requireLogin();
        
        $cliente = new Cliente();
        $cliente->id = $_GET['id'];
        
        if ($cliente->eliminar()) {
            showMessage("Cliente eliminado exitosamente", "success");
        } else {
            showMessage("Error al eliminar cliente", "error");
        }
        
        redirect("index.php?controller=cliente&action=index");
    }
}
?>