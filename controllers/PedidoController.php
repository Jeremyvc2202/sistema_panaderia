<?php
require_once 'models/Pedido.php';
require_once 'models/Cliente.php';
require_once 'models/Producto.php';
require_once 'includes/functions.php';

class PedidoController {

    private function isAjax(): bool {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private function respondJson($payload, int $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload);
        exit;
    }

    public function index() {
        requireLogin();

        $pedido = new Pedido();
        $stmt = $pedido->leer();
        $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'views/pedidos/index.php';
        // (no exit aquí porque es render de vista normal)
    }

    public function crear() {
        requireLogin();

        // GET -> mostrar formulario
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $cliente = new Cliente();
            $stmtClientes = $cliente->leer();
            $clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);

            $producto = new Producto();
            $stmtProductos = $producto->leer();
            $productos = $stmtProductos->fetchAll(PDO::FETCH_ASSOC);

            require_once 'views/pedidos/crear.php';
            return;
        }

        // POST -> guardar pedido
        try {
            $cliente_id = (int)($_POST['cliente_id'] ?? 0);
            $detalles   = isset($_POST['detalles']) ? json_decode($_POST['detalles'], true) : null;

            if (!$cliente_id) { 
                if ($this->isAjax()) $this->respondJson(['ok'=>false,'message'=>'Cliente requerido'], 422);
                showMessage('Cliente requerido', 'error');
                redirect('index.php?controller=pedido&action=crear'); // <-- esta función debe hacer exit
            }

            if (!is_array($detalles) || empty($detalles)) {
                if ($this->isAjax()) $this->respondJson(['ok'=>false,'message'=>'Agrega al menos un producto'], 422);
                showMessage('Agrega al menos un producto', 'error');
                redirect('index.php?controller=pedido&action=crear');
            }

            // Crear el pedido
            $pedido = new Pedido();
            $pedido->cliente_id = $cliente_id;
            $pedido->estado     = 'Pendiente';
            // El modelo recalcula total y maneja stock

            $ok = $pedido->crear($detalles);

            if ($this->isAjax()) {
                $this->respondJson(['ok'=>$ok, 'message'=>$ok?'Pedido creado exitosamente':'No se pudo guardar'], $ok?200:500);
            } else {
                if ($ok) {
                    showMessage("Pedido creado exitosamente", "success");
                    redirect("index.php?controller=pedido&action=index"); // <-- redirect debe hacer exit
                } else {
                    showMessage("Error al crear pedido", "error");
                    redirect("index.php?controller=pedido&action=crear");
                }
            }
        } catch (Throwable $e) {
            if ($this->isAjax()) {
                $this->respondJson(['ok'=>false, 'message'=>$e->getMessage()], 500);
            } else {
                showMessage($e->getMessage(), "error");
                redirect("index.php?controller=pedido&action=crear");
            }
        }
    }

    public function detalle() {
        requireLogin();

        $pedido_id = (int)($_GET['id'] ?? 0);
        $pedido = new Pedido();
        $stmt = $pedido->leerDetalle($pedido_id);
        $detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($detalles);
        exit; // 👈 importante
    }

    public function actualizarEstado() {
        requireLogin();

        $pedido = new Pedido();
        $pedido->id = (int)($_POST['id'] ?? 0);
        $pedido->estado = $_POST['estado'] ?? 'Pendiente';

        $ok = $pedido->actualizarEstado();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => $ok]);
        exit; // 👈 importante
    }
}
