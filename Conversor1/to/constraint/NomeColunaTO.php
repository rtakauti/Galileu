<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../IRestricao.php' );
include_once realpath ( __DIR__ . '/../../bo/estrutura/Estrutura.php' );

class NomeColunaTO extends Estrutura implements IRestricao {
	
	
	
	public function retorna($valor) {
		$string = "";
		if (isset ( $valor )) {
			$colunas = "";
			$colunas = implode ( ", ", $valor );
			if ($colunas != "")
				$string = " ($colunas) ";
		}
		return $string;
	}
}