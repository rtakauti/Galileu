<?php

include_once __DIR__ .'/../../enum/FaseQuery.php';
include_once __DIR__.'/../../enum/EstruturaQuery.php';
include_once __DIR__ .'/../../bo/sequence/GerenciadorSequence.php';
include_once __DIR__.'/../IPropriedade.php';
class MaximoCharTO implements IPropriedade{
	
	public function __construct($valor= NULL, $fase = NULL, $condicao=NULL, $estrutura = NULL){
		$this->retorna($valor, $fase, $condicao, $estrutura);
	}
	
	public function retorna($valor, $fase, $condicao, $estrutura) {
		$string = "";
		if (isset ( $valor )) {
			switch ($fase) {
				case FaseQuery::CREATE :
					$string = " ($valor)";
					break;
				case FaseQuery::ADD :
					$string = "($valor) ";
					break;
				
				default :
					break;
			}
			return $string;
		}
	}
}