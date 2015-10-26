<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../IRestricao.php' );

class TabelaEstrangeiraTO implements IRestricao {
	
	
	public function retorna($valor, $fase) {
		$string = "";
		if (isset ( $valor )) {
			$string = "\n\tREFERENCES $valor ";
		}
		return $string;
	}
}