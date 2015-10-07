<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../IRestricao.php' );
class NomeColunaTO implements IRestricao {
	public function __construct($valor = NULL, $fase = NULL, $condicao = NULL) {
		$this->retorna ( $valor, $fase, $condicao );
	}
	public function retorna($valor, $fase, $condicao) {
		$string = "";
		if (isset ( $valor )) {
			switch ($fase) {
				case FaseQuery::CREATE :
					$colunas = "";
					$colunas = implode ( ", ", $valor );
					if ($colunas != "")	$string = " ($colunas) ";
					break;
				case FaseQuery::ADD :
					if ($valor == "NO") {
						$string = "\n\tNOT NULL ";
					}
					break;
				case FaseQuery::ALTER :
					if ($valor == "NO") {
						$string = "\n\tALTER COLUMN $coluna SET NOT NULL";
					} else {
						$string = "\n\tALTER COLUMN $coluna DROP NOT NULL";
					}
					
					break;
				
				default :
					break;
			}
		}
		return $string;
	}
}