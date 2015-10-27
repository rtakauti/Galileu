<?php
include_once realpath(__DIR__ . '/../../enum/FaseQuery.php');
include_once realpath ( __DIR__ . '/../../bo/estrutura/Estrutura.php' );
include_once realpath(__DIR__.'/../IPropriedade.php');


class NuloTO extends Estrutura implements IPropriedade {

	public function retorna($valor) {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		$coluna = parent::$coluna;
		$propriedades = parent::$propriedades;
		$string = "";
		if (isset ( $valor )) {
			switch (parent::$fase) {
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