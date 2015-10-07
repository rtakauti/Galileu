<?php
include_once 'IRestricao.php';
class GeradorRestricoes{

	public static function gerarRestricao(IRestricao $constraint, $valor, $fase){
		return $constraint->retorna($valor, $fase);
	}
	
}