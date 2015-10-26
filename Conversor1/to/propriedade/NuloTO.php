<?php
include_once realpath(__DIR__ . '/../../enum/FaseQuery.php');
include_once realpath(__DIR__ . '/../../enum/EstruturaQuery.php');
include_once realpath(__DIR__ . '/../../bo/sequence/GerenciadorSequence.php');
include_once realpath(__DIR__.'/../IPropriedade.php');


class NuloTO implements IPropriedade {

	public function retorna($valor, $fase, $condicao, $estrutura) {
		$schema = $estrutura [EstruturaQuery::SCHEMA];
		$tabela = $estrutura [EstruturaQuery::TABELA];
		$coluna = $estrutura [EstruturaQuery::COLUNA];
		$string = "";
		if (isset ( $valor )) {
			switch ($fase) {
				case FaseQuery::CREATE :
					if ($valor == "NO") {
						$string = " NOT NULL";
					}
					break;
				case FaseQuery::ADD :
					if ($valor == "NO") {
						$string = "\n\tNOT NULL ";
					}
					break;
				case FaseQuery::ALTER :
					if ($valor == "NO") {
						$string = "\nALTER TABLE $schema.$tabela ALTER COLUMN $coluna SET NOT NULL;";
					} else{
						$string = "\nALTER TABLE $schema.$tabela ALTER COLUMN $coluna DROP NOT NULL;";
					}
					
					break;
				
				default :
					break;
			}
		}
		return $string;
	}
}