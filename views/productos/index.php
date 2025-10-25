<?php include 'views/layout/header.php'; ?>

<div class="content-header">
    <h2>Gestión de Productos (Panes)</h2>
    <a href="index.php?controller=producto&action=crear" class="btn btn-primary">+ Nuevo Producto</a>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Fecha Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($productos as $producto): ?>
            <tr>
                <td><?php echo $producto['id']; ?></td>
                <td><?php echo $producto['nombre']; ?></td>
                <td><?php echo $producto['descripcion']; ?></td>
                <td><?php echo $producto['categoria']; ?></td>
                <td>S/. <?php echo number_format($producto['precio'], 2); ?></td>
                <td><?php echo $producto['stock']; ?></td>
                <td><?php echo date('d/m/Y', strtotime($producto['fecha_registro'])); ?></td>
                <td>
                    <a href="index.php?controller=producto&action=editar&id=<?php echo $producto['id']; ?>" class="btn btn-small btn-warning">Editar</a>
                    <a href="index.php?controller=producto&action=eliminar&id=<?php echo $producto['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'views/layout/footer.php'; ?>