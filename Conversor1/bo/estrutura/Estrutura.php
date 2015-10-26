<?php


abstract class Estrutura {
	
	protected static $estrutura;
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