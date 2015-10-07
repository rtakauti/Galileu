<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../IRestricao.php' );
class NomeColunaTO implements IRestricao {
	public function __construct($valor = NULL, $fase = NULL) {
		$this->retorna ( $valor, $fase );
	}
	public function retorna($colunas, $fase) {
		$string = "";
		if (! empty ( $colunas )) {
			switch ($fase) {
				case FaseQuery::CREATE :
					$string = "(" . implode ( ", ", $colunas ) . ")";
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