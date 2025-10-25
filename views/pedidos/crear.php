<?php include 'views/layout/header.php'; ?>

<div class="content-header">
    <h2>Crear Nuevo Pedido</h2>
</div>

<div class="form-container pedido-form">
    <form method="POST" action="" id="formPedido">
        <div class="form-row">
            <div class="form-group">
                <label>Cliente:</label>
                <select name="cliente_id" id="cliente_id" required>
                    <option value="">Seleccionar cliente...</option>
                    <?php foreach($clientes as $cliente): ?>
                        <option value="<?php echo $cliente['id']; ?>">
                            <?php echo $cliente['nombre'] . ' ' . $cliente['apellido']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <h3>Agregar Productos</h3>
        
        <div class="producto-selector">
            <div class="form-row">
                <div class="form-group">
                    <label>Producto:</label>
                    <select id="producto_id">
                        <option value="">Seleccionar producto...</option>
                        <?php foreach($productos as $producto): ?>
                            <option value="<?php echo $producto['id']; ?>" 
                                    data-nombre="<?php echo $producto['nombre']; ?>"
                                    data-precio="<?php echo $producto['precio']; ?>"
                                    data-stock="<?php echo $producto['stock']; ?>">
                                <?php echo $producto['nombre']; ?> - S/. <?php echo $producto['precio']; ?> (Stock: <?php echo $producto['stock']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Cantidad:</label>
                    <input type="number" id="cantidad" min="1" value="1">
                </div>
                
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-success" id="btnAgregar">Agregar</button>
                </div>
            </div>
        </div>

        <h3>Productos en el Pedido</h3>
        
        <div class="table-container">
            <table class="table" id="tablaProductos">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unit.</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="listaProductos">
                    <tr class="empty-message">
                        <td colspan="5" style="text-align: center; color: #999;">
                            No hay productos agregados
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>TOTAL:</strong></td>
                        <td><strong>S/. <span id="totalPedido">0.00</span></strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <input type="hidden" name="detalles" id="detalles">
        <input type="hidden" name="total" id="total">
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary" id="btnGuardar">Guardar Pedido</button>
            <a href="index.php?controller=pedido&action=index" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include 'views/layout/footer.php'; ?>