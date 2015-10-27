<?php
include_once realpath(__DIR__ .'/../../enum/FaseQuery.php');
include_once realpath ( __DIR__ . '/../../bo/estrutura/Estrutura.php' );
include_once realpath(__DIR__.'/../IPropriedade.php');

class PrecisaoMantissaTO extends Estrutura implements IPropriedade{


	public function retorna($valor) {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		$coluna = parent::$coluna;
		$propriedades = parent::$propriedades;
		$string = "";
		if (isset ( $valor ) && $propriedades ['udt_name'] == "numeric") {
			switch (parent::$fase) {
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