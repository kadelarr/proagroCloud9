<?php
if(isset($_POST['user'])) {
  /**
  * Se valida que los campos no esten vacios
  */
  if($_POST['user'] != '' && $_POST['password'] != '' && $_POST['name'] != '') {
    include_once   $urls['userController'];
    $users = new UserController();
    if($users->createUser($_POST)) {
        header("Location: " . $routeServer . $urls['routing'] . "?url=users");
    } else {
        header("Location: " . $routeServer . $urls['routing'] . "?url=createUser");
    }
  }
} else {

     
?>
  <div class="content-users">
    <div class="create-users">
      <form class="" action="<?php echo $routeServer; ?>" method="post">
        <div>
          <label>Usuario: </label>
          <input type="text" name="user"  value="" required>
        </div>
        <div>
          <label>Nombre: </label>
          <input title="!!SOLO SE PERMITEN LETRAS" type="text" name="name" id="name" value="" 
          required pattern="([a-z A-Z ]{4, 20})" maxlength="20">
        </div>
        <div>
          <label>Password: </label>
          <input type="password" name="password" value="" required>
        </div>
        <div>
          <label>Rol: </label>
          <select class="" name="rol">
            <option value="1">Administrador</option>
            <option value="2">Usuario</option>
          </select>
        </div>
        <div >
          <input type="submit" name="submit" value="Crear">
          <a href="<?php echo $routeServer . $urls['routing'] . "?url=users"; ?>">Cancelar</a><br>
         
          
        </div>
      </form>

    </div>
  </div>
<?php
}
?>
