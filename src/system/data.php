<?php
$urls = array(
    'home' => 'src/views/web/home.php',
    'login' => 'src/views/web/login.php',
    'map' => 'src/views/maps/maps.php',
    'users' => 'src/views/user/users.php',
    'createUser' => 'src/views/user/create.php',
    'createZona' => 'src/views/zonas/createZona.php',
    'zona' => 'src/views/zonas/zona.php',
    'promedioZona' => 'src/views/zonas/promedioZona.php',
    'editarUser' => 'src/views/user/editarUser.php',
    'editarZona' => 'src/views/zonas/editarZona.php',
    'about' => 'src/views/web/about.php',
    'contacto' => 'src/views/web/contacto.php',


    //sistema
    'message' => 'src/views/messages.php',
    'error' => 'src/views/system/error.php',
    'routing' => 'src/system/routing.php',
    'dataBase' => 'src/database/DataBase.php',

    //Menus
    'menu' => 'src/views/menu.php',
    'menuAdmin' => 'src/views/menus/menuAdmin.php',
    'menuWeb' => 'src/views/menus/menuWeb.php',
    'menuUser' => 'src/views/menus/menuUser.php',

    //Controladores
    'loginController' => 'src/controller/users/LoginController.php',
    'userController' => 'src/controller/users/UserController.php',
    'zonaController' => 'src/controller/zonas/zonaController.php',

);


//Se cargan las vistas que se solicitan por desde los controlladores
$view = "home";
if (isset($_SESSION['location'])) {
    if (isset($urls[$_SESSION['location']])) {
        $view = $_SESSION['location'];
    } else {
        $_SESSION['error'] = "error";
        $view = "error";
    }
}

//Carga la variable que indica que tipo de usuario es, tambien ajusta la pagina por defecto
$typeUser = null;
if (isset($_SESSION['type'])) {
    $typeUser = $_SESSION['type'];
    if($typeUser != "" && $view == "home"){
      $view = "map";
    }
}
