<?php
  include_once '../database/database.php';

  /**
  * Se encarga de administras los WebServices para la gestion de los mapas, consultar información
  * y actualizar estados de las zonas
  * @author Carlos Arley
  */
  class PromedioService{
    private $db;
    private $areas;
    private $dataByAreas = [];

    /**
    * Se establece la conexión con la base de datos
    */
    public function __construct()
    {
      $this->db = new DataBase();
    }

    /**
    * Ajusta las zonas con los datos de latitud asociados y la información de la zona,
    * el json generado se edita para evitar que quede con signos extras como el \ que
    * genera error en la lectura del js
    */
    public function getAreas()
    {
          $data = [];
          $data['labels'] = [];
          $data['series'] = [];
          $sql = "select a.name as name from sowing s INNER JOIN areas a on a.id = s.id_area GROUP by s.id_area";
          $result = [];
          $resultName = $this->db->query($sql);
          while ($row = $resultName->fetch_assoc()) {
              array_push($result, $row['name']);
          }
          $data['labels'] = json_encode($result, JSON_NUMERIC_CHECK);
          $sql = "select avg(s.count) as promedio from sowing s INNER JOIN areas a on a.id = s.id_area GROUP by s.id_area";
          $resultPromedio = $this->db->query($sql);
          $result = [];
          $resultName = $this->db->query($sql);
          while ($row = $resultPromedio->fetch_assoc()) {
              array_push($result, $row['promedio']);
          }
          $data['series'] = "[".json_encode($result, JSON_NUMERIC_CHECK) ."]";
          
      $data = str_replace("\\", "", json_encode($data, JSON_NUMERIC_CHECK));
      $data = str_replace("\"[", "[", $data);
      $data = str_replace("]\"", "]", $data);
      //Se imprime la respuesta para el consumo del WebServices
      return $data;
  }
}

  //Se instancia la clase para ser ejecutada
  $promedio = new PromedioService();

  //Se realiza una validación del servicio que se trata de obtener
  if(isset($_GET['get'])) {
     if($_GET['get'] == 'promedio') {
      echo "callback(".$promedio->getAreas().")";
      
    }
  }

  ?>
