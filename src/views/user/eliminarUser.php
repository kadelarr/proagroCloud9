<?php
include_once   $urls['userController'];
    $users = new UserController();
    $column = $users->eliminarUser($_SESSION['id']);

        header("Location: " . $routeServer . $urls['routing'] . "?url=users");
  
?>
