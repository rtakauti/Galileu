<?php

include_once __DIR__ .'/../enum/FaseQuery.php';
include_once __DIR__.'/../enum/EstruturaQuery.php';
include_once __DIR__ .'/../bo/sequence/GerenciadorSequence.php';
include_once 'IPropriedade.php';

class TipoDadoTO implements IPropriedade{

	public function __construct($valor= NULL, $fase = NULL, $condicao=NULL, $coluna = NULL){
		$this->retorna($valor, $fase, $condicao, $coluna);
	}
	


	public function retorna($valor, $fase, $condicao, $estrutura) {
		$string = "";
		if (isset ( $valor )) {
			switch ($fase) {
				case FaseQuery::CREATE :
					
					switch ($valor) {
						case "ARRAY" :
							$string = "[] ";
							break;
						case "time without time zone" :
							$string = "";
							break;	
						case "time with time zone" :
							$string = "";
							break;	
						case "timestamp without time zone" :
							$string = "";
							break;
						case "timestamp with time zone" :
							$string = "";
							break;
						case "USER-DEFINED" :
							$string = "";
							break;	
						default :
							$string = $valor;
							break;
					}
					
					break;
				case FaseQuery::ADD :
					$string = "\n\t$valor ";
					break;
				
				default :
					break;
			}
		}
		return $string;
	}
	
}