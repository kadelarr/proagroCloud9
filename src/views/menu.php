<!-- Menu -->
<div class="menu">
  <div class="title">
    Proagro
  </div>
  <div class="content-menu">
      <?php
      //Se realiza una validación para no mostrar los menus si la url no existe
      if(isset($_SESSION['error'])){
        unset($_SESSION['error']);
      } else {
        if(!isset($typeUser) || $typeUser == "") {
          //Carga el menu para pagina web
          include_once $urls['menuWeb'];
        } else {
          if ($typeUser == "admin") {
              //el menu de la cuenta de administrador
              include_once $urls['menuAdmin'];
          } else {
              //el menu del usuario normal
              include_once $urls['menuUser'];
          }
        }
      }
      ?>
  </div>
</div>
