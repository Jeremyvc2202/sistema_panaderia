<?php
$message = getMessage();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Panadería</title>
    <link rel="icon" type="image/x-icon" href="assets/imagenes/un-pan.ico">

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php if(isLoggedIn()): ?>
    <nav class="navbar">
        <div class="nav-container">
            <h1>🍞 Panadería</h1>
            <ul class="nav-menu">
                <li><a href="index.php?controller=pedido&action=index">Pedidos</a></li>
                <li><a href="index.php?controller=cliente&action=index">Clientes</a></li>
                <li><a href="index.php?controller=producto&action=index">Productos</a></li>
                <li class="user-menu">
                    <span>👤 <?php echo $_SESSION['usuario_nombre']; ?></span>
                    <a href="index.php?controller=usuario&action=logout" class="btn-logout">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php endif; ?>
    
    <div class="container">
        <?php if($message): ?>
            <div class="alert alert-<?php echo $message['type']; ?>">
                <?php echo $message['message']; ?>
            </div>
        <?php endif; ?>
