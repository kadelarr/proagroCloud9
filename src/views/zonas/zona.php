 <div class="rendi"> 
      <label>Cantidad de Toneladas de Caña</label>
      <input type="number" id="cana"> </input>
      <label>Cantidad de Bolsas de Panela</label>
      <input type="number" id="panela"> </input>
      <button onclick="calcularPanela()"> Calcular</button>
      
      <div id="alert">
      <input disabled="" type="number" id="result"></input>
    <div id="correcto"></div>
    <div id="error"></div>
    
  </div>
  </div>
  
<div class="content-users">
  <nav>
    <a href="<?php echo $routeServer . $urls['routing'] . "?url=createZona"; ?>">Crear Zona</a>
    <a href="<?php echo $routeServer . $urls['routing'] . "?url=promedioZona"; ?>">Promedio Zona</a>
  </nav>

  <div class="list-users">
    <table>
      <thead>
        <tr>
          <th>Lote</th>
          <th>Fecha de Siembra</th>
          <th>Fecha de Corte</th>
          <th>Fecha Final</th>
          <th>Cantidad de Corte</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
      <?php
        include_once   $urls['zonaController'];
        $zona = new ZonaController();
        echo $zona->getAll($routeServer . $urls['routing']);
      ?>
    </tbody>
  </table>
  </div>
</div>