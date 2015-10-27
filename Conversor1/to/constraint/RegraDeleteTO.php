<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../IRestricao.php' );
include_once realpath ( __DIR__ . '/../../bo/estrutura/Estrutura.php' );

class RegraDeleteTO extends Estrutura implements IRestricao {
	
	
	public function retorna($valor) {
		$string = "";
		if (isset ( $valor )) {
			$string = " ON DELETE $valor ";
		}
		return $string;
	}
}