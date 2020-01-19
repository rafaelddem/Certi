<?php
	include_once 'model\bo\BO_Certi.php';

	class Contr_encontraRetorno {
		
		function getJson() {
			
			$certi = new BO_Certi();
			echo $certi -> getJson($_SERVER['REQUEST_URI']);
			
		}
		
	}
	
?>