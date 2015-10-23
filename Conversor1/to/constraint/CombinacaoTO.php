<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../IRestricao.php' );

class CombinacaoTO implements IRestricao {
	
	public function __construct($valor = NULL, $fase = NULL) {
		$this->retorna ( $valor, $fase);
	}
	
	public function retorna($valor, $fase) {
		$string = "";
		if (isset ( $valor )) {
			if ($valor == "NONE") {
				$string = " MATCH SIMPLE ";
			} elseif ($valor == "FULL") {
				$string = " MATCH FULL ";
			}
		}
		return $string;
	}
}