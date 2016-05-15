<?php
include_once   $urls['userController'];
    $users = new UserController();
    $column = $users->buscarUser($_SESSION['id']);
if(isset($_POST['user'])) {
  //Se valida que los campos no esten vacios
  if($_POST['user'] != '' && $_POST['password'] != '' && $_POST['name'] != '') {
    
    if($users->editarUser($_POST)) {
        header("Location: " . $routeServer . $urls['routing'] . "?url=users");
    }
  }
} else {
?>
  <div class="content-users">
    <div class="create-users">
      <form class="" action="<?php echo $routeServer; ?>" method="post">
      <input type="hidden" name="userOld" value="<?php echo $column['user'];?>">
      <input type="hidden" name="id" value="<?php echo $column['id'];?>">
        <div>
          <label>Usuario: </label>
          <input type="text" name="user" value="<?php echo $column['user'];?>" required>
        </div>
        <div>
          <label>Nombre: </label>
          <input type="text" name="name" value="<?php echo $column['name'];?>" required>
        </div>
        <div>
          <label>Password: </label>
          <input type="password" name="password" value="<?php echo $column['password'];?>" required>
        </div>
        <div>
          <label>Rol: </label>
          <select class="" name="rol">
            <option value="1" <?php echo $column['rol'] == 1 ? 'selected' : ''; ?>>Admin</option>
            <option value="2" <?php echo $column['rol'] == 2 ? 'selected' : ''; ?>>User</option>
          </select>
        </div>
        <div>
          <input type="submit" name="submit" value="Update">
          <a href="<?php echo $routeServer . $urls['routing'] . "?url=users"; ?>">Cancel</a>
        </div>
      </form>
    </div>
  </div>
<?php
}
?>
