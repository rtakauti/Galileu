<?php
include_once 'IRestricao.php';
class GeradorRestricoes{

	public static function gerarRestricao(IRestricao $constraint, $valor){
		return $constraint->retorna($valor);
	}
	
}