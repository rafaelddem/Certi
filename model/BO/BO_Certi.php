<?php
	include_once 'model\Entity\Certi.php';
	
	class BO_Certi {
		
		private $certi = "";
		
		public function getJson($uri){
			try {
				$parametro = $this -> verificaInconsistencias($uri);
				$certi = new Certi($parametro);
				$extenso = $certi -> identificaNomeNumero($certi -> getParametro());
				
				$data = array('extenso' => $extenso);
				header('Content-Type: application/json');
				echo json_encode($data);
			} catch (Exception $e) {
				return $e -> getMessage();
			}
		}
		
		public function verificaInconsistencias($uri) {
		//	throw new Exception("Forçando erro genérico");
			
			$uri = explode('/', $uri);
			if (count($uri) != 2) throw new Exception("O formato da URL informada deve ser \"http://localhost:3000/XXX\", onde \"XXX\" DEVE ser substituido pelo parâmetro desejado<br>(Opcional informar \"http://\" no início)", 1);
			
			return $uri[1];
		}
		
	}
	
?>