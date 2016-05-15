<?php
include_once   $urls['zonaController'];
    $zona = new ZonaController();
if(isset($_POST['initial'])) {
  //Se valida que los campos no esten vacios
  if($_POST['initial'] != '' && $_POST['id_area'] != '' ) {
    
    if($zona->createZona($_POST)) {
        header("Location: " . $routeServer . $urls['routing'] . "?url=zona");
    } 
  }
} else {
?>
  <div class="content-users">
    <div class="create-users">
      <form class="" action="<?php echo $routeServer; ?>" method="post">
        
        <div>
          <label>Lotes: </label>
          <select class="" name="id_area">
            <?php 
              echo $zona->getZonasDisponibles();
             ?>
          </select>
        </div>
        <div>
          <label>Fecha de Siembra: </label>
          <input type="date" name="initial" value="" required>
        </div>
       
        
        <div>
          <input type="submit" name="submit" value="Crear">
          <a href="<?php echo $routeServer . $urls['routing'] . "?url=zona"; ?>">Cancel</a>
        </div>
      </form>
    </div>
  </div>
<?php
}
?>