<?php
include_once __DIR__ . '/../enum/FaseQuery.php';
include_once __DIR__ . '/../enum/EstruturaQuery.php';
include_once '../IRestricao.php';

class RegraUniqueTO implements IRestricao {
	
	public function __construct($valor = NULL, $fase = NULL) {
		$this->retorna ( $valor, $fase);
	}
	
	public function retorna($valor, $fase) {
		$string = "";
		if (isset ( $valor )) {
			switch ($fase) {
				case FaseQuery::CREATE :
					$string = " $valor ";
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