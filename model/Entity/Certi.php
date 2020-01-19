<?php
	
	class Certi {
		
		private $parametro;
		private $unidadePorExtenso = array(1 => 'um', 2 => 'dois', 3 => 'três', 4 => 'quatro', 5 => 'cinco', 6 => 'seis', 7 => 'sete', 8 => 'oito', 9 => 'nove');
		private $dezenaPorExtenso1 = array(0 => 'dez', 1 => 'onze', 2 => 'doze', 3 => 'treze', 4 => 'quatorze', 5 => 'quinze', 6 => 'dezesseis', 7 => 'dezessete', 8 => 'dezoito', 9 => 'dezenove');
		private $dezenaPorExtenso2 = array(2 => 'vinte', 3 => 'trinta', 4 => 'quarenta', 5 => 'cinquenta', 6 => 'sessenta', 7 => 'setenta', 8 => 'oitenta', 9 => 'noventa');
		private $centenaPorExtenso1 = "cem";
		private $centenaPorExtenso2 = array(1 => 'cento', 2 => 'duzentos', 3 => 'trezentos', 4 => 'quatrocentos', 5 => 'quinhentos', 6 => 'seiscentos', 7 => 'setecentos', 8 => 'oitocentos', 9 => 'novecentos');
		
		public function __construct($parametro) {
			$this -> setParametro($parametro);
		}
		
		public function setParametro($parametro) {
			if (!isset($parametro)) throw new Exception("Não foi informado nenhum valor", 1);
			
			if (!is_numeric($parametro)) throw new Exception("O valor passado, deve ser numérico", 2);
			
			if ($parametro < -99999 or $parametro > 99999) throw new Exception("Valor fora dos limites, ele deve estar entre -99999 e 99999", 3);
			
			$this -> parametro = $parametro ;
		}
		
		public function getParametro() {
			return $this -> parametro;
		}
		
		public function identificaNomeNumero($valor) {
			$retorno = "";
			$negativo = (substr($valor, 0, 1) == '-') ? true : false;
			
			$valor = ($negativo) ? abs($valor) : $valor;
			$valores = array_reverse(str_split($valor));
			
			$dezenaDeMilhar = (count($valores) == 5) ? $valores[4] : 0;
			$unidadeDeMilhar = (count($valores) >= 4) ? $valores[3] : 0;
			$centena = (count($valores) >= 3) ? $valores[2] : 0;
			$dezena = (count($valores) >= 2) ? $valores[1] : 0;
			$unidade = (count($valores) >= 1) ? $valores[0] : 0;
			
			$retorno = $this -> buscaNomeDezenaUnidade($unidade, $dezena);
			$retorno = $this -> buscaNomeCentena($retorno, $centena);
			$retorno = $this -> buscaNomeMilhar($retorno, $unidadeDeMilhar, $dezenaDeMilhar);
			
			$retorno = ($negativo) ? "menos ".$retorno : $retorno;
			return $retorno;
		}
		
		public function buscaNomeDezenaUnidade($unidade, $dezena) {
			$retorno = "";
			//unidade
			if ($unidade > 0) {
				$retorno = $this -> unidadePorExtenso[$unidade];
			}
			//dezena
			if ($dezena == 1) {
				$retorno = $this -> dezenaPorExtenso1[$unidade];
			}
			if ($dezena > 1) {
				if (empty($retorno)) {
					$retorno = $this -> dezenaPorExtenso2[$dezena];
				} else {
					$retorno = $this -> dezenaPorExtenso2[$dezena]." e ".$retorno;
				}
			}
			return $retorno;
		}
		
		public function buscaNomeCentena($dezena, $centena) {
			$retorno = "";
			if ($centena > 0) {
				if (!empty($dezena)) {
					$retorno = $this -> centenaPorExtenso2[$centena]." e ".$dezena;
				} else {
					if ($centena > 1) {
						$retorno = $this -> centenaPorExtenso2[$centena];
					}
					if ($centena == 1) {
						$retorno = $this -> centenaPorExtenso1;
					}
				}
				return $retorno;
			} else {
				return $dezena;
			}
		}
		
		public function buscaNomeMilhar($centena, $unidadeDeMilhar, $dezenaDeMilhar) {
			$milhar = $this -> buscaNomeDezenaUnidade($unidadeDeMilhar, $dezenaDeMilhar);
			if (empty($milhar)) return $centena;
			
			if (empty($centena)) return $milhar." mil";
			
			return $milhar." mil e ".$centena;
		}
		
	}
	
?>