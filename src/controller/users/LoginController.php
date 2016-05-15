<?php
session_start();
require_once '../../database/DataBase.php';

if (isset($_POST)) {
    $dataBase = new DataBase();
    $user = $dataBase->validate($_POST['user']);
    $password = $dataBase->validate($_POST['password']);
    $result = $dataBase->getData("users", "user = '" . $user . "' AND password = '" . $password . "'");
    $user = $result->fetch_assoc();
    if ($result->num_rows > 0) {
        $_SESSION['user'] = $user['user'];
        $_SESSION['type'] = $user['rol'] == 1 ? 'admin' : 'user';
        $_SESSION['id'] = $user['id'];
        $_SESSION['location'] = "map";
        if ($user['rol'] == "admin") {
            $_SESSION['location'] = "map";
        }
    } else {
        $_SESSION['message'] = "Los datos ingresados no son correctos";
    }
    header("Location: " . $_SESSION['url']);
}
