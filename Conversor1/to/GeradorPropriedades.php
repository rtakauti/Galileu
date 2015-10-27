<?php
include_once 'IPropriedade.php';
class GeradorPropriedades{

	public static function gerarPropriedade($propriedade, $valor){
		return $propriedade->retorna($valor);
	}
	
}