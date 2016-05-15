<?php
  include_once '../database/database.php';

  /**
  * Se encarga de administras los WebServices para la gestion de los mapas, consultar información
  * y actualizar estados de las zonas
  * @author Carlos Arley
  */
  class LocationService{
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
      $this->getNameAreas();
      while($rows = $this->areas->fetch_assoc()) {
          $data = [];
          $data['message'] = [];
          $data['nextCut'] = [];
          $data['locations'] = $this->db->getJson("locations", "id_area = " . $rows['id']);
          $data['sowing'] = $this->db->getJson("sowing", "id_area = " . $rows['id'] . " AND final IS NULL");
          $data['status'] = "sowing";
          $resultNextCut = $this->db->getData("sowing", "id_area = " . $rows['id'] . " AND cut BETWEEN NOW() AND DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 8 DAY),'%Y-%m-%d')");
          $resultStatus = $this->db->getData("sowing", "id_area = " . $rows['id'] . " AND cut <= now() AND final IS NULL");
          if($resultStatus->num_rows > 0) {
            $data['status'] = "cut";
            array_push($data['message'], "El lote " . $rows['name'] . " Esta en proceso de corte, se identifica por el color rojo");
          }
          if($resultNextCut->num_rows > 0) {
            $data['status'] = "next";
            array_push($data['message'], "El lote " . $rows['name'] . " Esta a punto de terminar el tiempo para iniciar el corte");
          }
          $this->dataByAreas[$rows['name']] = $data;
      }
      $this->dataByAreas = str_replace("\\", "", json_encode($this->dataByAreas, JSON_NUMERIC_CHECK));
      $this->dataByAreas = str_replace("\"[", "[", $this->dataByAreas);
      $this->dataByAreas = str_replace("]\"", "]", $this->dataByAreas);
      //Se imprime la respuesta para el consumo del WebServices
      return $this->dataByAreas;
    }

    public function getSowing(){
      $this->getNameAreas();
      $sql = "select * from locations INNER join sowing on sowing.id_location = locations.id where sowing.final is null";
      $result = $this->db->query($sql);
      while($rows = $result->fetch_assoc()) {
          $this->dataByAreas[$rows['name']] = $this->db->getJson("locations", "id_area = " . $rows['id']);
      }
      $this->dataByAreas = str_replace("\\", "", json_encode($this->dataByAreas, JSON_NUMERIC_CHECK));
      $this->dataByAreas = str_replace("\"[", "[", $this->dataByAreas);
      $this->dataByAreas = str_replace("]\"", "]", $this->dataByAreas);
      //Se imprime la respuesta para el consumo del WebServices
      return $this->dataByAreas;
    }

    /**
    * Consulta todos los registros de las zonas, trae los datos como nombre y color
    */
    private function getNameAreas()
    {
      $this->areas = $this->db->getData("areas",null);
    }
  }

  //Se instancia la clase para ser ejecutada
  $locations = new LocationService();

  //Se realiza una validación del servicio que se trata de obtener
  if(isset($_GET['get'])) {
    if($_GET['get'] == 'areas') {
      echo "callback(".$locations->getAreas().")";
      
    }
    if($_GET['get'] == 'sowing') {
      echo "callback(".$locations->getSowing().")";
      
    }
  }

  ?>
