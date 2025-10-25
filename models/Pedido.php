<?php
require_once 'config/database.php';
require_once 'models/Producto.php'; // 👈 NECESARIO

class Pedido {
    private $conn;
    private $table = "pedidos";
    private $detalleTable = "detalle_pedidos";

    public $id;
    public $cliente_id;
    public $fecha_pedido;
    public $total;
    public $estado;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function crear($detalles) {
        try {
            $this->conn->beginTransaction();

            // Inserta encabezado (total 0 provisional si prefieres recalcular)
            $qEnc = "INSERT INTO {$this->table} (cliente_id, total, estado) VALUES (?, ?, ?)";
            $stmEnc = $this->conn->prepare($qEnc);
            $stmEnc->execute([$this->cliente_id, $this->total, $this->estado]);

            $pedido_id = (int)$this->conn->lastInsertId();

            // Prepared del detalle
            $qDet = "INSERT INTO {$this->detalleTable}
                    (pedido_id, producto_id, cantidad, precio_unitario, subtotal)
                    VALUES (?, ?, ?, ?, ?)";
            $stmDet = $this->conn->prepare($qDet);

            $totalCalculado = 0.0;

            foreach ($detalles as $detalle) {
                // OPCIONAL (recomendado): obtener precio real desde BD en vez de confiar en $_POST
                // $prodRow = $this->conn->prepare("SELECT precio, stock FROM productos WHERE id=?");
                // $prodRow->execute([$detalle['producto_id']]);
                // $prod = $prodRow->fetch();
                // if (!$prod) throw new Exception('Producto no encontrado');
                // if ((int)$prod['stock'] < (int)$detalle['cantidad']) throw new Exception('Stock insuficiente');
                // $precio = (float)$prod['precio'];
                // $subtotal = $precio * (int)$detalle['cantidad'];

                // Si confías en lo que viene del front (no recomendado), usa lo del payload:
                $precio   = (float)$detalle['precio'];
                $subtotal = (float)$detalle['subtotal'];

                // Inserta detalle (usa execute con arreglo, no bindParam con índices)
                $stmDet->execute([
                    $pedido_id,
                    (int)$detalle['producto_id'],
                    (int)$detalle['cantidad'],
                    $precio,
                    $subtotal
                ]);

                // Actualiza stock
                $producto = new Producto();
                $producto->id = (int)$detalle['producto_id'];
                $producto->actualizarStock((int)$detalle['cantidad']);

                $totalCalculado += $subtotal;
            }

            // OPCIONAL: sobreescribe el total del encabezado con el recalculado del servidor
            $qUpd = "UPDATE {$this->table} SET total=? WHERE id=?";
            $stmUpd = $this->conn->prepare($qUpd);
            $stmUpd->execute([$totalCalculado, $pedido_id]);

            $this->conn->commit();
            return true;

        } catch (Throwable $e) { // atrapa también TypeError/Errores modernos
            if ($this->conn->inTransaction()) $this->conn->rollBack();
            // Puedes loguear $e->getMessage() para depurar
            return false;
        }
    }

    public function leer() {
        $query = "SELECT p.*, c.nombre as cliente_nombre, c.apellido as cliente_apellido 
                  FROM {$this->table} p
                  INNER JOIN clientes c ON p.cliente_id = c.id
                  ORDER BY p.fecha_pedido DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function leerDetalle($pedido_id) {
        $query = "SELECT dp.*, pr.nombre as producto_nombre 
                  FROM {$this->detalleTable} dp
                  INNER JOIN productos pr ON dp.producto_id = pr.id
                  WHERE dp.pedido_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([(int)$pedido_id]);
        return $stmt;
    }

    public function actualizarEstado() {
        $query = "UPDATE {$this->table} SET estado = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->estado, (int)$this->id]);
    }
}
