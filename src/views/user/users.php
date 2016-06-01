<div class="content-users">
  <nav>
    <a href="<?php echo $routeServer . $urls['routing'] . "?url=createUser"; ?>">Crear Usuario</a>
  </nav>
  <div class="list-users">
    <table>
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Nombre</th>
          <th>Tipo</th>
          <th>Acción</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
      <?php
        include_once   $urls['userController'];
        $users = new UserController();
        echo $users->getAllUser($routeServer . $urls['routing']);
      ?>
    </tbody>
  </table>
  </div>
</div>
