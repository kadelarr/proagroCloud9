<?php
session_start();

if (isset($_GET['id'])) {
    $_SESSION['id'] = $_GET['id'];
}


//Captura las peticiones de url
if (isset($_GET['url'])) {
    if (isset($_SESSION['url'])) {
        $_SESSION['location'] = $_GET['url'];
        header("Location: " . $_SESSION['url']);
    }
}

//Valida si se requiere de algun servicio y llama a los archivos asociados
if (isset($_GET['get'])) {
    include_once '../services/LocationService.php';
    include_once '../services/PromedioService.php';
}

//Cierra la sesión y redirecciona a la pagina principal
if (isset($_GET['close'])) {
    if (isset($_SESSION['url'])) {
        $routeServer = $_SESSION['url'];
        session_destroy();
        header("Location: " . $routeServer);
    }
}

//Si existe algun error se redirecciona a donde estaba antes de ingresar al error
if (isset($_GET['error'])) {
    if (isset($_SESSION['url'])) {
        unset($_SESSION['location']);
        header("Location: " . $_SESSION['url']);
    }
}
