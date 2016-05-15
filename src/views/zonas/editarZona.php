<?php
include_once   $urls['zonaController'];
    $zona = new ZonaController();
    $column= $zona->buscarZona($_SESSION['id']);
if(isset($_POST['initial'])) {
  //Se valida que los campos no esten vacios
  if($_POST['initial'] != '' && $_POST['initial'] != '0000-00-00' && $_POST['id_area'] != '' && $_POST['cut'] != '' ) {
    if(empty($_POST['final'])){
      $_POST['final'] = null;
    }
    if($zona->editarZona($_POST)) {
        header("Location: " . $routeServer . $urls['routing'] . "?url=zona");
    } 
  }
} else {
?>
  <div class="content-users">
    <div class="create-users">
      <form class="" action="<?php echo $routeServer; ?>" method="post">
        <input type="hidden" value="<?php echo $column['id']; ?>" name="id"></input>
        <div>
          <label>Lotes: </label>
          <select class="" name="id_area">
            <?php 
              echo $zona->getZonasDisponibles();
              echo $zona->getCurrentZone($column['id_area']);
             ?>
          </select>
        </div>
        <div>
          <label>Fecha de Siembra: </label>
          <input type="date" name="initial" value="<?php echo $column['initial']; ?>" required>
        </div>

        <div>
          <label>Fecha de Corte: </label>
          <input type="date" name="cut" value="<?php echo $column['cut']; ?>" required>
        </div>

        <div>
          <label>Fecha Fin de Corte: </label>
          <input type="date" name="final" value="<?php echo $column['final']; ?>">
        </div>
       
       <div>
          <label>Cantidad de Corte: </label>
          <input type="number" name="count" value="<?php echo $column['count']; ?>">
        </div>
        
        <div>
          <input type="submit" name="submit" value="Actualizar">
          <a href="<?php echo $routeServer . $urls['routing'] . "?url=zona"; ?>">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
<?php
}
?>