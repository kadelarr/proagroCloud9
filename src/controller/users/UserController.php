<?php
require_once $urls['dataBase'];

class UserController{

  private $db;

  public function __construct(){
      $this->db = new DataBase();
  }

  /**
  * Obtiene la lista de todos los usaurios registrados para ser visualizados en una tabla
  */
  public function getAllUser($editar){
      $table = "";
      $result = $this->db->getData("users",null);
      while ($row = $result->fetch_assoc()){
        $table .= "<tr>"
          ."<td>" . $row['user']
          ."</td>"
          ."<td>" . $row['name']
          ."</td>"
          ."<td>" . ($row['rol'] == 1 ? 'Admin' : 'User')
          ."</td>"
          ."<td><a href='" . $editar .  "?id=" . $row['id'] . "&url=editarUser'>Editar</a>"
          ."</td>"
          ."<td><a href='" . $editar .  "?id=" . $row['id'] . "&url=eliminarUser'>Eliminar</a>"
          ."</td>"
          ."</tr>";
      }
      return $table;
  }

  /**
  *
  */
  public function createUser($dataUser){
    $dataInsert = [
        "user" => [
            "data" => $dataUser["user"],
            "type" => "text"
        ],
        "name" => [
            "data" => $dataUser["name"],
            "type" => "text"
        ],
        "password" => [
            "data" => $dataUser["password"],
            "type" => "text"
        ],
        "rol" => [
            "data" => $dataUser["rol"],
            "type" => "int"
        ]
    ];
    //Se valida si el usuario no existe
    if($result = $this->db->getData("users","user = " . $dataUser["user"])) {
      if($result->num_rows > 0) {
        return false;
      }
    }
    return $this->db->insertData("users", $dataInsert);
  }

  public function buscarUser($id){
     $result = $this->db->getData("users","id = " . $id);
     return $result->fetch_assoc();
  }

  public function editarUser($dataUser){
    $dataInsert = [
        "user" => [
            "data" => $dataUser["user"],
            "type" => "text"
        ],
        "name" => [
            "data" => $dataUser["name"],
            "type" => "text"
        ],
        "password" => [
            "data" => $dataUser["password"],
            "type" => "text"
        ],
        "rol" => [
            "data" => $dataUser["rol"],
            "type" => "int"
        ]
    ];
    if($dataUser["user"] != $dataUser["userOld"]){
      //Se valida si el usuario no existe
      if($result = $this->db->getData("users","user = " . $dataUser["user"])) {
        if($result->num_rows > 0) {
          return false;
        }
      }
    }
    return $this->db->updateData("users", $dataInsert, "id = " . $dataUser['id']);
  }

  

  public function eliminarUser($id){
     
       $this->db->removeData("users","id = " . $id);
  }
  

}
?>
