<?php include 'views/layout/header.php'; ?>

<div class="content-header">
    <h2>Crear Nuevo Cliente</h2>
</div>

<div class="form-container">
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            
            <div class="form-group">
                <label>Apellido:</label>
                <input type="text" name="apellido" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
        </div>
        
        <div class="form-group">
            <label>Dirección:</label>
            <textarea name="direccion" rows="3" required></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar Cliente</button>
            <a href="index.php?controller=cliente&action=index" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include 'views/layout/footer.php'; ?>