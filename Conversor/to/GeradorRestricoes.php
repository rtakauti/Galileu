<?php
include_once 'IRestricao.php';
class GeradorRestricoes{

	public static function gerarRestricao(IRestricao $constraint, $valor, $fase, $condicao){
		return $constraint->retorna($valor, $fase, $condicao);
	}
	
}