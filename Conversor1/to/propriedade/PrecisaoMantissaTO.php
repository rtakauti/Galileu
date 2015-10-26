<?php
include_once realpath(__DIR__ .'/../../enum/FaseQuery.php');
include_once realpath(__DIR__.'/../../enum/EstruturaQuery.php');
include_once realpath(__DIR__ .'/../../bo/sequence/GerenciadorSequence.php');
include_once realpath(__DIR__.'/../IPropriedade.php');

class PrecisaoMantissaTO implements IPropriedade{


	public function retorna($valor, $fase, $condicao, $estrutura) {
		$schema = $estrutura [EstruturaQuery::SCHEMA];
		$tabela = $estrutura [EstruturaQuery::TABELA];
		$coluna = $estrutura [EstruturaQuery::COLUNA];
		$string = "";
		if (isset ( $valor ) && $condicao ['udt_name'] == "numeric") {
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
		}
		return $string;
	}
	
	
}