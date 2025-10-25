<?php include 'views/layout/header.php'; ?>

<div class="content-header">
    <h2>Editar Cliente</h2>
</div>

<div class="form-container">
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $cliente->nombre; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Apellido:</label>
                <input type="text" name="apellido" value="<?php echo $cliente->apellido; ?>" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono" value="<?php echo $cliente->telefono; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $cliente->email; ?>" required>
            </div>
        </div>
        
        <div class="form-group">
            <label>Dirección:</label>
            <textarea name="direccion" rows="3" required><?php echo $cliente->direccion; ?></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Cliente</button>
            <a href="index.php?controller=cliente&action=index" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<?php include 'views/layout/footer.php'; ?>