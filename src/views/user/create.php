<?php
if(isset($_POST['user'])) {
  //Se valida que los campos no esten vacios
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
          <input type="text" name="user" value="" required>
        </div>
        <div>
          <label>Nombre: </label>
          <input type="text" name="name" value="" required>
        </div>
        <div>
          <label>Password: </label>
          <input type="password" name="password" value="" required>
        </div>
        <div>
          <label>Rol: </label>
          <select class="" name="rol">
            <option value="1">Admin</option>
            <option value="2">User</option>
          </select>
        </div>
        <div>
          <input type="submit" name="submit" value="Create">
          <a href="<?php echo $routeServer . $urls['routing'] . "?url=users"; ?>">Cancel</a>
        </div>
      </form>
    </div>
  </div>
<?php
}
?>
