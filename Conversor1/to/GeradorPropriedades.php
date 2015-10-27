<?php
include_once 'IPropriedade.php';
class GeradorPropriedades{

	public static function gerarPropriedade(IPropriedade $propriedade, $valor){
		return $propriedade->retorna($valor);
	}
	
}