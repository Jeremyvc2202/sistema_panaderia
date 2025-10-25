<?php
require_once 'models/Usuario.php';
require_once 'includes/functions.php';

class UsuarioController {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = new Usuario();
            $usuario->email = sanitize($_POST['email']);
            $usuario->password = $_POST['password'];
            
            if ($usuario->login()) {
                $_SESSION['usuario_id'] = $usuario->id;
                $_SESSION['usuario_nombre'] = $usuario->nombre;
                $_SESSION['usuario_email'] = $usuario->email;
                
                showMessage("Bienvenido " . $usuario->nombre, "success");
                redirect("index.php?controller=pedido&action=index");
            } else {
                showMessage("Email o contraseña incorrectos", "error");
            }
        }
        require_once 'views/auth/login.php';
    }
    
    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = new Usuario();
            $usuario->nombre = sanitize($_POST['nombre']);
            $usuario->email = sanitize($_POST['email']);
            $usuario->password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            
            if ($usuario->password !== $confirm_password) {
                showMessage("Las contraseñas no coinciden", "error");
            } elseif ($usuario->verificarEmail()) {
                showMessage("Este email ya está registrado", "error");
            } else {
                if ($usuario->registrar()) {
                    showMessage("Registro exitoso. Ahora puedes iniciar sesión", "success");
                    redirect("index.php?controller=usuario&action=login");
                } else {
                    showMessage("Error al registrar usuario", "error");
                }
            }
        }
        require_once 'views/auth/registro.php';
    }
    
    public function recuperar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = new Usuario();
            $usuario->email = sanitize($_POST['email']);
            
            if ($usuario->verificarEmail()) {
                $nueva_password = $_POST['nueva_password'];
                $confirm_password = $_POST['confirm_password'];
                
                if ($nueva_password !== $confirm_password) {
                    showMessage("Las contraseñas no coinciden", "error");
                } else {
                    $usuario->password = $nueva_password;
                    if ($usuario->actualizarPassword()) {
                        showMessage("Contraseña actualizada correctamente", "success");
                        redirect("index.php?controller=usuario&action=login");
                    } else {
                        showMessage("Error al actualizar contraseña", "error");
                    }
                }
            } else {
                showMessage("Email no encontrado", "error");
            }
        }
        require_once 'views/auth/recuperar.php';
    }
    
    public function logout() {
        session_destroy();
        redirect("index.php?controller=usuario&action=login");
    }
}
?>