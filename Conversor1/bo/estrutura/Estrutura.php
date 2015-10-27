<?php


abstract class Estrutura {
	
	protected static $sequences;
	protected static $querySet;
	protected static $schema;
	protected static $tabela;
	protected static $coluna;
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

	public static function getPass(){
		return self::$pass;
	}
	
	public static function setPass($senha){
		self::$pass = $senha;
	}
	
}