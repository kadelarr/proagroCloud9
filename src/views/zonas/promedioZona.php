<div class="content-users">
  <nav>
    <a href="<?php echo $routeServer . $urls['routing'] . "?url=zona"; ?>">Volver Zona</a>
  </nav>
  <div class="list-users">
    <table>
      <thead>
        <tr>
          <th>Lote</th>
          <th>Promedio Producción</th>
          
        </tr>
      </thead>
      <tbody>
      <?php
        include_once   $urls['zonaController'];
        $zona = new ZonaController();
        echo $zona->getAvgAreas();
      ?>
    </tbody>
  </table>
  </div>

</div>

<div class="chart"> <div class="ct-chart ct-perfect-fourth"></div></div>