<?php
//activamos la memoria para evitar que nos pida la contraseña cada vez que recarguemos la página
session_start();

//si pulsan el enlace de cerrar sesión
if (isset($_GET['logout'])) {
    session_destroy();            // Borra la memoria de la sesión
    header('Location: admin.php'); // Redirige al inicio de sesión limpio (formulario de contraseña)
    exit;                         // Detiene la ejecución del script
}

//definimos la contraseña del admin
define('ADMIN_PASSWORD', 'admin123');

$mensaje_error = '';

//comprobamos si el formulario se envió por POST y si se ha enviado el campo password 
//detecta también si alguien ha pulsado enviar o simplemente acaba de cargar la página 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === ADMIN_PASSWORD) {
        // Guardamos en la sesión que ya está autenticado
        $_SESSION['es_admin'] = true;
    } else {
        $mensaje_error = "Contraseña incorrecta. Inténtalo de nuevo.";
    }
}

//si la contraseña es correcta, guardamos la sesión del admin
$esta_autenticado = isset($_SESSION['es_admin']) && $_SESSION['es_admin'] === true;


//cargar el panel de admin
require_once 'PAGES/vista_admin.php';
?>