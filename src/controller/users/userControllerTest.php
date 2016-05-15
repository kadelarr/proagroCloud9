<?php
require_once ('UserController.php');

class UserControllerTest extends PHPUnit_Framework_TestCase{


	public function buscarUsuarioTest(){

		$user = new UserController();
		var_dump($user -> buscarUser(1));
		
		
	}

 	}


 		$user1 = new UserControllerTest();
 		$user1 -> buscarUsuarioTest();

 	/*public function buscarUser($id){
     $result = $this->db->getData("users","id = " . $id);
     return $result->fetch_assoc();
  }*/

?>
 