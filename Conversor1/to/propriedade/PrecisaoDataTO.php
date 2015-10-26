<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../../bo/sequence/GerenciadorSequence.php' );
include_once realpath ( __DIR__ . '/../IPropriedade.php' );

class PrecisaoDataTO implements IPropriedade {

	public function retorna($valor, $fase, $condicao, $estrutura) {
		$string = "";
		if (isset ( $valor ) && ! isset ( $condicao ['interval_type'] )) {
			switch ($fase) {
				case FaseQuery::CREATE :
					if ($valor != 0)
						$string = " ($valor) ";
					switch ($condicao ['data_type']) {
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
							;
							break;
					}
					break;
				case FaseQuery::ADD :
					$string = "($valor) ";
					break;
				
				default :
					break;
			}
		}
		return $string;
	}
}