<?php include 'views/layout/header.php'; ?>

<div class="content-header">
    <h2>Editar Producto</h2>
</div>

<div class="form-container">
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
                <label>Nombre del Pan:</label>
                <input type="text" name="nombre" value="<?php echo $producto->nombre; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Categoría:</label>
                <select name="categoria" required>
                    <option value="">Seleccionar...</option>
                    <option value="Pan Dulce" <?php echo $producto->categoria == 'Pan Dulce' ? 'selected' : ''; ?>>Pan Dulce</option>
                    <option value="Pan Salado" <?php echo $producto->categoria == 'Pan Salado' ? 'selected' : ''; ?>>Pan Salado</option>
                    <option value="Pan Integral" <?php echo $producto->categoria == 'Pan Integral' ? 'selected' : ''; ?>>Pan Integral</option>
                    <option value="Pan Especial" <?php echo $producto->categoria == 'Pan Especial' ? 'selected' : ''; ?>>Pan Especial</option>
                    <option value="Bollería" <?php echo $producto->categoria == 'Bollería' ? 'selected' : ''; ?>>Bollería</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" rows="3" required><?php echo $producto->descripcion; ?></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Precio (S/.):</label>
                <input type="number" step="0.01" name="precio" value="<?php echo $producto->precio; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Stock:</label>
                <input type="number" name="stock" value="<?php echo $producto->stock; ?>" required>
            </div>
        </div>
            <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            <a href="index.php?controller=producto&action=index" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include 'views/layout/footer.php'; ?>