<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../IRestricao.php' );

class TipoConstraintTO implements IRestricao {
	
	
	public function retorna($valor, $fase) {
		$string = "";
		if (isset ( $valor )) {
			$string = $valor;
		}
		return $string;
	}
}