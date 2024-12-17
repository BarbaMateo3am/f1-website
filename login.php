<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = 'usuario';
    $contraseña = 'contraseña';

    $usuario_input = base64_encode($_POST['usuario']);
    $contraseña_input = base64_encode($_POST['contraseña']);

    if ($usuario_input == base64_encode($usuario) && $contraseña_input == base64_encode($contraseña)) {
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
        exit;
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles-login.css"> 
</head>
<body>
    <div class="login-container">
        <div class="login-box">
        <form method="POST" action="login.php">
            <form action="index.php" method="post">
            <input type="text" id="usuario" name="usuario" placeholder="Usuario" required>
                <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña" required>
                <button type="submit">Iniciar Sesión</button>
            </form>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </div>
    </div>
</body>
</html>


