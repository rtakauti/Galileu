<?php
include_once 'IPropriedade.php';
class GeradorPropriedades{

	public static function gerarPropriedade($propriedade, $valor, $fase=NULL, $condicao=NULL, $estrutura =NULL){
		return $propriedade->retorna($valor, $fase, $condicao, $estrutura);
	}
	
}