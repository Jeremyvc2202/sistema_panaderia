<?php include 'views/layout/header.php'; ?>

<div class="content-header">
    <h2>Crear Nuevo Producto</h2>
</div>

<div class="form-container">
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
                <label>Nombre del Pan:</label>
                <input type="text" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label>Categoría:</label>
                <select name="categoria" required>
                    <option value="">Seleccionar...</option>
                    <option value="Pan Dulce">Pan Dulce</option>
                    <option value="Pan Salado">Pan Salado</option>
                    <option value="Pan Integral">Pan Integral</option>
                    <option value="Pan Especial">Pan Especial</option>
                    <option value="Bollería">Bollería</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" rows="3" required></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Precio (S/.):</label>
                <input type="number" step="0.01" name="precio" required>
            </div>
            
            <div class="form-group">
                <label>Stock:</label>
                <input type="number" name="stock" required>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar Producto</button>
            <a href="index.php?controller=producto&action=index" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include 'views/layout/footer.php'; ?>