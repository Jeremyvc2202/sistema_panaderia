<?php include 'views/layout/header.php'; ?>

<div class="content-header">
    <h2>Gestión de Pedidos</h2>
    <a href="index.php?controller=pedido&action=crear" class="btn btn-primary">+ Nuevo Pedido</a>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($pedidos as $pedido): ?>
            <tr>
                <td><?php echo $pedido['id']; ?></td>
                <td><?php echo $pedido['cliente_nombre'] . ' ' . $pedido['cliente_apellido']; ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($pedido['fecha_pedido'])); ?></td>
                <td>S/. <?php echo number_format($pedido['total'], 2); ?></td>
                <td>
                    <select class="estado-select" data-id="<?php echo $pedido['id']; ?>" 
                            style="padding: 5px; border-radius: 5px; border: 1px solid #ddd;">
                        <option value="Pendiente" <?php echo $pedido['estado'] == 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="En Proceso" <?php echo $pedido['estado'] == 'En Proceso' ? 'selected' : ''; ?>>En Proceso</option>
                        <option value="Completado" <?php echo $pedido['estado'] == 'Completado' ? 'selected' : ''; ?>>Completado</option>
                        <option value="Cancelado" <?php echo $pedido['estado'] == 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                    </select>
                </td>
                <td>
                    <button class="btn btn-small btn-info ver-detalle" data-id="<?php echo $pedido['id']; ?>">Ver Detalle</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para ver detalle -->
<div id="modalDetalle" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Detalle del Pedido</h3>
        <div id="detalleContent"></div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>