
<div class="content-promedio">
  <nav>
    <a href="<?php echo $routeServer . $urls['routing'] . "?url=zona"; ?>">Volver Zona</a>
  </nav>

  <div class="list-promedio">
    <table>
      <thead>
        <tr>
          <th>Lote</th>
          <th>Fecha de Corte</th>
          
        </tr>
      </thead>
      <tbody>
      <?php
        include_once   $urls['zonaController'];
        $zona = new ZonaController();
        echo $zona->getSiembra();
      ?>
    </tbody>
  </table>
  </div>
  
</div>