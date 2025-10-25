<?php include 'views/layout/header.php'; ?>

<div class="content-header">
    <h2>Gestión de Clientes</h2>
    <a href="index.php?controller=cliente&action=crear" class="btn btn-primary">+ Nuevo Cliente</a>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clientes as $cliente): ?>
            <tr>
                <td><?php echo $cliente['id']; ?></td>
                <td><?php echo $cliente['nombre']; ?></td>
                <td><?php echo $cliente['apellido']; ?></td>
                <td><?php echo $cliente['telefono']; ?></td>
                <td><?php echo $cliente['email']; ?></td>
                <td><?php echo $cliente['direccion']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($cliente['fecha_registro'])); ?></td>
                <td>
                    <a href="index.php?controller=cliente&action=editar&id=<?php echo $cliente['id']; ?>" class="btn btn-small btn-warning">Editar</a>
                    <a href="index.php?controller=cliente&action=eliminar&id=<?php echo $cliente['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'views/layout/footer.php'; ?>