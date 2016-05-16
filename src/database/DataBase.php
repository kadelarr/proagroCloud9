<?php
/**
* Controla la comunicación con el sistema de base de datos de mysql, tambien
* brinda la posibilidad de generar consultas rapidas a la base de datos
* @author Carlos Arley
*/
class DataBase
{
    private $host = "localhost";
    private $username = "kadelarr7";
    private $password = "";
    private $dataBase = "proagro";
    public $db;

    /**
    * Realiza una validación para evitar ataque de inyeción sql en inputs
    * @param $content {String} Valor a validar
    */
    public function validate($content){
      $this->connectDataBase();
      $content = $this->db->real_escape_string($content);
      $this->closeConnection();
      return $content;
    }

    /**
    * Ejecuta un query directamente en la base de datos y retorna su resultado
    * sin ningun tipo de procesamiento
    * @param $sql {String} Query a ejecutar
    */
    public function query($sql)
    {
        $this->connectDataBase();
        $result = $this->db->query($sql);
        $this->closeConnection();
        return $result;
    }


    /**
    * Obtiene todos los datos de una tabla siempre que se cumpla la condición where
    * si no se pasa esta condición se traen todos los datos
    * @param $table {String} Nombre de la tabla a consultar
    * @param $where {String} Cadena con la condición where
    */
    public function getData($table, $where)
    {
        $sql = "SELECT * FROM " . $table;
        if ($where != null) {
            $sql .= " WHERE " . $where;
        }
        $this->connectDataBase();
        $result = $this->db->query($sql);
        $this->closeConnection();
        return $result;
    }

    /**
    * Realiza el mismo procedimiento de la funcion getData pero retorna el resultado
    * como un json para ser procesado por JavaScript o Ajax
    */
    public function getJson($table, $where){
      $result = [];
      $data = $this->getData($table, $where);
      while ($row = $data->fetch_assoc()) {
          array_push($result, $row);
      }
      return json_encode($result, JSON_NUMERIC_CHECK);
    }

    /**
    *
    */
    public function updateData($table, $dataUpdate, $where)
    {
        $sql = "UPDATE " . $table;
        $fields = "";
        foreach ($dataUpdate as $currentField => $currentValue) {
            if (!empty($this->validate($currentValue["data"]))) { 
                $fields .= $currentField . " = ";
                if ($currentValue["type"] == "text") {
                    $fields .= "'" . $this->validate($currentValue["data"]) . "',";
                } else {
                    $fields .= $this->validate($currentValue["data"]) . ",";
                }
            }
        }
        $fields = substr($fields, 0, -1);
        $sql .= " SET " . $fields;
        if ($where != null) {
            $sql .= " WHERE " . $where;
        }
        $this->connectDataBase();
        $this->db->query($sql);
        $this->closeConnection();
        return true;
    }

    /**
    *
    */
    public function removeData($table, $where)
    {
        $sql = "DELETE FROM " . $table;
        if ($where != null) {
            $sql .= " WHERE " . $where;
        }
        $this->connectDataBase();
        $this->db->query($sql);
        $this->closeConnection();
    }

    /**
    *
    */
    public function insertData($table, $dataInsert)
    {
        $sql = "INSERT INTO " . $table;
        $values = "";
        $fields = "";
        foreach ($dataInsert as $currentField => $currentValue) {
            $fields .= $currentField . ",";
            if ($currentValue["type"] == "text") {
                $values .= "'" . $this->validate($currentValue["data"]) . "',";
            } else {
                $values .= $this->validate($currentValue["data"]) . ",";
            }
        }
        $fields = "(" . substr($fields, 0, -1) . ")";
        $values = "(" . substr($values, 0, -1) . ")";
        $sql .= " " . $fields . " VALUES " . $values;
        $this->connectDataBase();
        $result = $this->db->query($sql);
        $this->closeConnection();
        return $result;
    }

    /**
    * Establece la conexión con la base de datos, de generar un error lo informa y detiene los proceso
    */
    private function connectDataBase()
    {
        $this->db = new mysqli($this->host, $this->username, $this->password, $this->dataBase);
        if ($this->db->connect_errno) {
            die("DataBase connect error " . $this->db->connect_errno);
        }
    }

    /**
    * Finaliza la comunicación con la base de datos para evitar errores por escases de recursos
    * o infiltraciones de seguridad
    */
    private function closeConnection()
    {
        $this->db->close();
    }

}
?>
