<div class="p">
<div class="content-promedio">
  <nav>
    <a href="<?php echo $routeServer . $urls['routing'] . "?url=zona"; ?>">Volver Zona</a>
  </nav>
  <div class="list-promedio">
    <table class="tb_promedio">
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

<div class="chart"> <div class=" grafico1 ct-chart ct-perfect-fourth"></div></div>
</div>