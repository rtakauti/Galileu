<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../IRestricao.php' );

class RegraUniqueTO implements IRestricao {
	
	public function __construct($valor = NULL, $fase = NULL, $condicao = NULL) {
		$this->retorna ( $valor, $fase, $condicao );
	}
	
	public function retorna($valor, $fase, $condicao) {
		$string = "";
		if (isset ( $valor )) {
			$string = " $valor ";
		}
		return $string;
	}
}