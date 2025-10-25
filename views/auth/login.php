<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Panadería</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h1>🍞 Panadería</h1>
            <h2>Iniciar Sesión</h2>
            
            <?php 
            $message = getMessage();
            if($message): 
            ?>
                <div class="alert alert-<?php echo $message['type']; ?>">
                    <?php echo $message['message']; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Contraseña:</label>
                    <input type="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>
            
            <div class="auth-links">
                <a href="index.php?controller=usuario&action=recuperar">¿Olvidaste tu contraseña?</a>
                <a href="index.php?controller=usuario&action=registro">Crear una cuenta</a>
            </div>
        </div>
    </div>
</body>
</html>