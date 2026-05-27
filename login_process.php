<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Credenciales válidas para el entorno del equipo de desarrollo
    if ($username === 'dev_user' && $password === 'TruperDev2026!') {
        $_SESSION['usuario'] = $username;
        header("Location: panel.php");
        exit();
    } else {
        // Si fallan, lo regresamos con un flag de error
        header("Location: index.php?error=1");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
