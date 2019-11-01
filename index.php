<?php 
	/**
	 * 
	 */
	class Loteria 
	{
		private $dezenas;
		private $resultados;
		private $total_jogos;
		private $jogos;

		function __construct($dezenas, $total_jogos)
		{
			if($this->setAtributos('dezenas', $dezenas))
				$this->setAtributos('total_jogos', $total_jogos);
			else
				return 'Valor informado para o total de dezenas é inválido';
		}

		public function getAtributos($atributo){
			switch ($atributo) {
				case 'dezenas':
					return $this->dezenas;
					break;
				case 'resultados':
					return $this->resultados;
					break;
				case 'total_jogos':
					return $this->total_jogos;
					break;
				case 'jogos':
					return $this->jogos;
					break;
				default:
					return 'Atributo não reconhecido';
					break;
			}
		}

		public function setAtributos($atributo, $valor){
			switch ($atributo) {
				case 'dezenas':
					if ($valor < 6 || $valor > 10) {
						return false;
					}
					$this->dezenas = $valor;
					return true;
					break;
				case 'resultados':
					$this->resultados = $valor;
					return true;
					break;
				case 'total_jogos':
					$this->total_jogos = $valor;
					return true;
					break;
				case 'jogos':
					$this->jogos = $valor;
					return true;
					break;
				default:
					return 'Atributo não reconhecido';
					break;
			}
		}

		private function gerarJogo(){
			$numeros_gerados = array();
			$dezenas = $this->getAtributos('dezenas');
			for($i = 0; $i < $dezenas; $i++){
				$numero = rand(1,60);
				if (!in_array($numero, $numeros_gerados)) {
					$numeros_gerados[$i] = $numero;
				}else{
					$i--;
				}
			}
			sort($numeros_gerados);
			return $numeros_gerados;
		}

		public function gerarJogos(){
			$jogos_gerados = array();
			$total_jogos = $this->getAtributos('total_jogos');
			for ($i=0; $i < $total_jogos; $i++) { 
				$jogos_gerados[$i] = $this->gerarJogo();
			}
			$this->setAtributos('jogos',$jogos_gerados);
		}

		public function gerarSorteio(){
			$numeros_gerados = array();
			for($i = 0; $i < 6; $i++){
				$numero = rand(1,60);
				if (!in_array($numero, $numeros_gerados)) {
					$numeros_gerados[$i] = $numero;
				}else{
					$i--;
				}
			}
			sort($numeros_gerados);
			$this->setAtributos('resultados', $numeros_gerados);
		}

		public function confereJogos(){
			$resultado = $this->getAtributos('resultados');
			$jogos = $this->getAtributos('jogos');
			$html = '
					<table style="width: 100%;">
						<thead>
					   		<tr>
					     		<th>Jogo</th>
					    		<th>Número de Acertos</th>
					    	</tr>
					  	</thead>
					  	<tbody>';
			foreach ($jogos as $jogo) {
				/*foreach ($jogo as $numero) {
					$jogo_string
				}*/
				$jogo_string = implode(',',$jogo); 
				$acertos = array_intersect($jogo,$resultado);
				if(empty($acertos)){
					$num_acertos = 0;
				}else{
					$num_acertos = count($acertos);
				}
				
				  	$html.= '
						<tr>
							<td style="text-align: center;">'.$jogo_string.'</td>
							<td style="text-align: center;">'.$num_acertos.'</td>
						</tr>';
					
			}
			$html .= "</tbody></table>";
			return $html;
		}

	}

?>