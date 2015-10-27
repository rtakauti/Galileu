<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../IRestricao.php' );
include_once realpath ( __DIR__ . '/../../bo/estrutura/Estrutura.php' );

class CombinacaoTO extends Estrutura implements IRestricao {
	
	
	public function retorna($valor) {
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