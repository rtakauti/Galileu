<?php
include_once __DIR__ .'/../enum/FaseQuery.php';
include_once __DIR__.'/../enum/EstruturaQuery.php';
include_once __DIR__ .'/../bo/sequence/GerenciadorSequence.php';
include_once 'IPropriedade.php';

class PrecisaoMantissaTO implements IPropriedade{

public function __construct($valor= NULL, $fase = NULL, $condicao=NULL, $estrutura = NULL){
		$this->retorna($valor, $fase, $condicao, $estrutura);
	}

	public function retorna($valor, $fase, $condicao, $estrutura) {
		if (isset ( $valor ) && $condicao['udt_name'] == "numeric") {
			switch ($fase) {
				case FaseQuery::CREATE :
					$string = "$valor) ";
					break;
				case FaseQuery::ADD :
					$string = "$valor) ";
					break;
				
				default :
					break;
			}
			return $string;
		}
		return "";
	}
	
	
}