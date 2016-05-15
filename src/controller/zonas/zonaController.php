<?php
require_once $urls['dataBase'];

class ZonaController{

  private $db;

  public function __construct(){
      $this->db = new DataBase();
  }

  /**
  * Obtiene la lista de todos las zonas registrados para ser visualizados en una tabla
  */
  public function getAll($editar){
      $table = "";
      $result = $this->db->query("select s.*, a.name from areas a inner join sowing s on s.id_area = a.id");
      while ($row = $result->fetch_assoc()){
        $table .= "<tr>"
          ."<td>" . $row['name']
          ."</td>"
          ."<td>" . $row['initial']
          ."</td>"
          ."<td>" . $row['cut']
          ."</td>"
          ."<td>" . $row['final']
          ."</td>"
          ."<td>" . $row['count']
          ."</td>"
          ."<td><a href='" . $editar . "?id=" . $row['id'] . "&url=editarZona'>Editar</a>"
          ."</td>"
          ."</tr>";
      }
      return $table;
  }

  /**
  *
  */
  public function createZona($dataZona){
    $dataInsert = [
        "initial" => [
            "data" => $dataZona["initial"],
            "type" => "text"
        ],
        "id_area" => [
            "data" => $dataZona["id_area"],
            "type" => "int"
        ]
        
    ];
    
    return $this->db->insertData("sowing", $dataInsert);
  }

  public function getZonasDisponibles(){
      $option = "";
      $result = $this->db->getData("areas","status = 0");
      while ($row = $result->fetch_assoc()){
        $option .= ""
          ."<option value='" . $row['id'] . "'>" . $row['name']
          ."</option>";
      }
      return $option;
  }

   public function editarZona($dataZona){
    $dataInsert = [
        "initial" => [
            "data" => $dataZona["initial"],
            "type" => "text"
        ],
        "cut" => [
            "data" => $dataZona["cut"],
            "type" => "text"
        ],
        "final" => [
            "data" => $dataZona["final"],
            "type" => "text"
        ],
        "count" => [
            "data" => $dataZona["count"],
            "type" => "text"
        ],
        "id_area" => [
            "data" => $dataZona["id_area"],
            "type" => "int"
        ]
        
    ];
    return $this->db->updateData("sowing", $dataInsert, "id = " . $dataZona['id']);
  }

 public function buscarZona($id){   
    $result = $this->db->getData("sowing", "id = " . $id);
    return $result->fetch_assoc();
  }

  public function getCurrentZone($id){
 $option = "";
      $result = $this->db->getData("areas","id = " . $id);
      while ($row = $result->fetch_assoc()){
        $option .= ""
          ."<option value='" . $row['id'] . "' selected>" . $row['name']
          ."</option>";
      }
      return $option;
  }

  public function getAvgAreas() {
    $sql = "select avg(s.count) as promedio, a.name as name from sowing s INNER JOIN areas a on a.id = s.id_area GROUP by s.id_area";
    $result = $this->db->query($sql);
     $table = "";
      while ($row = $result->fetch_assoc()){
        $table .= "<tr>"
          ."<td>" . $row['name']
          ."</td>"
          ."<td>" . $row['promedio']
          ."</td>"
          ."</tr>";
      }
      return $table;
  }
}
?>
