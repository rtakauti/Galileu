<?php
include_once realpath(__DIR__ .'/../../enum/FaseQuery.php');
include_once realpath(__DIR__.'/../../enum/EstruturaQuery.php');
include_once realpath(__DIR__ .'/../../bo/sequence/GerenciadorSequence.php');
include_once realpath(__DIR__.'/../IPropriedade.php');

class PrecisaoNumericaTO implements IPropriedade{

	public function __construct($valor= NULL, $fase = NULL, $condicao=NULL, $estrutura = NULL){
		$this->retorna($valor, $fase, $condicao, $estrutura);
	}

	public function retorna($valor, $fase, $condicao, $estrutura) {
		$schema = $estrutura [EstruturaQuery::SCHEMA];
		$tabela = $estrutura [EstruturaQuery::TABELA];
		$coluna = $estrutura [EstruturaQuery::COLUNA];
		$string = "";
		if (isset ( $valor ) && $condicao ['udt_name'] == "numeric") {
			switch ($fase) {
				case FaseQuery::CREATE :
					$string = "($valor,";
					break;
				case FaseQuery::ADD :
					$string = "($valor,";
					break;
				case FaseQuery::ALTER :
					$string = "\nALTER TABLE $tabela ALTER COLUMN $coluna TYPE NUMERIC($valor,{$condicao['numeric_scale']});";
					break;
				default :
					break;
			}
		}
		return $string;
	}
	
	
}