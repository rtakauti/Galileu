<?php

include_once __DIR__ .'/../../enum/FaseQuery.php';
include_once realpath ( __DIR__ . '/../../bo/estrutura/Estrutura.php' );
include_once __DIR__.'/../IPropriedade.php';

class MaximoCharTO extends Estrutura implements IPropriedade{
	
	
	public function retorna($valor) {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		$coluna = parent::$coluna;
		$propriedades = parent::$propriedades;
		$string = "";
		if (isset ( $valor )) {
			switch (parent::$fase) {
				case FaseQuery::CREATE :
					$string = " ($valor)";
					break;
				case FaseQuery::ADD :
					$string = "($valor) ";
					break;
				case FaseQuery::ALTER :
					$string = "\nALTER TABLE $schema.$tabela ALTER COLUMN $coluna TYPE character varying($valor);";
					break;
				default :
					break;
			}
			return $string;
		}
	}
}