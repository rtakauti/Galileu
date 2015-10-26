<?php

include_once __DIR__ .'/../../enum/FaseQuery.php';
include_once __DIR__.'/../../enum/EstruturaQuery.php';
include_once __DIR__ .'/../../bo/sequence/GerenciadorSequence.php';
include_once __DIR__.'/../IPropriedade.php';
class MaximoCharTO implements IPropriedade{
	
	
	public function retorna($valor, $fase, $condicao, $estrutura) {
		$schema = $estrutura [EstruturaQuery::SCHEMA];
		$tabela = $estrutura [EstruturaQuery::TABELA];
		$coluna = $estrutura [EstruturaQuery::COLUNA];
		$string = "";
		if (isset ( $valor )) {
			switch ($fase) {
				case FaseQuery::CREATE :
					$string = " ($valor)";
					break;
				case FaseQuery::ADD :
					$string = "($valor) ";
					break;
				case FaseQuery::ALTER :
					$string = "\nALTER TABLE $tabela ALTER COLUMN $coluna TYPE character varying($valor);";
					break;
				default :
					break;
			}
			return $string;
		}
	}
}