<?php


abstract class Estrutura {
	
	protected static $sequences;
	protected static $schema;
	protected static $tabela;
	protected static $coluna;
	protected static $constraint;
	protected static $fase;
	protected static $propriedades;
	
	protected static $host;
	protected static $user;
	protected static $dbHomolog;
	protected static $dbDev;
	protected static $dev;
	protected static $homolog;
	protected static $result;
	private static $pass;

	protected  static function getPass(){
		return self::$pass;
	}
	
	protected  static function setPass($senha){
		self::$pass = $senha;
	}
	
	protected static function lista($objetos, $titulo){
		$string = "";
		if(!empty($objetos)){
			$string .= "\n\n\n".str_pad("  $titulo  ",50,"-",STR_PAD_BOTH);
			for ($indice = 0; $indice < count($objetos); $indice++) $string .= "\n\t-- $indice    $objetos[$indice] ";
		}
		return $string;
	}
	
}