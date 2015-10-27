<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../bo/estrutura/Estrutura.php' );
include_once realpath ( __DIR__ . '/../IPropriedade.php' );

class PrecisaoDataTO extends Estrutura implements IPropriedade {
	
	
	public function retorna($valor) {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		$coluna = parent::$coluna;
		$propriedades = parent::$propriedades;
		$string = "";
		if (isset ( $valor ) && ! isset ( $propriedades ['interval_type'] )) {
			switch (parent::$fase) {
				case FaseQuery::CREATE :
					if ($valor != 0)
						$string = " ($valor) ";
					switch ($propriedades ['data_type']) {
						case "time without time zone" :
							$string = "time ($valor) without time zone";
							break;
						case "time with time zone" :
							$string = "time ($valor) with time zone";
							break;
						case "timestamp without time zone" :
							$string = "timestamp ($valor) without time zone";
							break;
						case "timestamp with time zone" :
							$string = "timestamp ($valor) with time zone";
							break;
						default :
							break;
					}
					break;
				case FaseQuery::ADD :
					if ($valor != 0)
						$string = " ($valor) ";
					switch ($propriedades ['data_type']) {
						case "time without time zone" :
							$string = "\n\ttime($valor) without time zone";
							break;
						case "time with time zone" :
							$string = "\n\ttime($valor) with time zone";
							break;
						case "timestamp without time zone" :
							$string = "\n\ttimestamp($valor) without time zone";
							break;
						case "timestamp with time zone" :
							$string = "\n\ttimestamp($valor) with time zone";
							break;
						default :
							break;
					}
					break;
				
				default :
					break;
			}
		}
		return $string;
	}
}