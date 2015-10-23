<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../IRestricao.php' );

class ColunaEstrangeiraTO implements IRestricao {
	
	public function __construct($valor = NULL, $fase = NULL) {
		$this->retorna ( $valor, $fase );
	}
	
	public function retorna($valor, $fase) {
		$string = "";
		if (isset ( $valor )) {
			$string = " ($valor) ";
		}
		return $string;
	}
}