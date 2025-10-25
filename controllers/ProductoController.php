<?php
require_once 'models/Producto.php';
require_once 'includes/functions.php';

class ProductoController {
    
    public function index() {
        requireLogin();
        
        $producto = new Producto();
        $stmt = $producto->leer();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once 'views/productos/index.php';
    }
    
    public function crear() {
        requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $producto = new Producto();
            $producto->nombre = sanitize($_POST['nombre']);
            $producto->descripcion = sanitize($_POST['descripcion']);
            $producto->precio = sanitize($_POST['precio']);
            $producto->stock = sanitize($_POST['stock']);
            $producto->categoria = sanitize($_POST['categoria']);
            
            if ($producto->crear()) {
                showMessage("Producto creado exitosamente", "success");
                redirect("index.php?controller=producto&action=index");
            } else {
                showMessage("Error al crear producto", "error");
            }
        }
        
        require_once 'views/productos/crear.php';
    }
    
    public function editar() {
        requireLogin();
        
        $producto = new Producto();
        $producto->id = $_GET['id'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $producto->nombre = sanitize($_POST['nombre']);
            $producto->descripcion = sanitize($_POST['descripcion']);
            $producto->precio = sanitize($_POST['precio']);
            $producto->stock = sanitize($_POST['stock']);
            $producto->categoria = sanitize($_POST['categoria']);
            
            if ($producto->actualizar()) {
                showMessage("Producto actualizado exitosamente", "success");
                redirect("index.php?controller=producto&action=index");
            } else {
                showMessage("Error al actualizar producto", "error");
            }
        }
        
        $producto->leerUno();
        require_once 'views/productos/editar.php';
    }
    
    public function eliminar() {
        requireLogin();
        
        $producto = new Producto();
        $producto->id = $_GET['id'];
        
        if ($producto->eliminar()) {
            showMessage("Producto eliminado exitosamente", "success");
        } else {
            showMessage("Error al eliminar producto", "error");
        }
        
        redirect("index.php?controller=producto&action=index");
    }
}
?>