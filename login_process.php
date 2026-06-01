<?php
// Aseguramos que la sesión inicie correctamente
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Capturar datos eliminando espacios vacíos accidentales al inicio o final
$usuario_ingresado = isset($_POST['username']) ? trim($_POST['username']) : '';
$password_ingresado = isset($_POST['password']) ? trim($_POST['password']) : '';

// Arreglo asociativo con las credenciales exactas
$usuarios_validos = [
    'dev_user'   => 'TruperDev2026!',
    'audit_user' => 'TruperAudit2026!'
];

// Verificación limpia e inequívoca
if (array_key_exists($usuario_ingresado, $usuarios_validos) && $password_ingresado === $usuarios_validos[$usuario_ingresado]) {
    
    // Guardamos el usuario validado en la sesión para el panel
    $_SESSION['db_user'] = $usuario_ingresado;
    
    // Redirección inmediata
    header("Location: panel.php");
    exit();
} else {
    // Si falla, mandamos el error de regreso al login
    header("Location: login.php?error=1");
    exit();
}
?>
