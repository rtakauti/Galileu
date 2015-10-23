<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );
include_once realpath(__DIR__.'/../dao/daoImpl/AssemblerDAOImpl.php');

class AssemblerBO {
	
	private $dao;
	protected  static $estrutura;
	protected  static $dev;
	protected  static $homolog;
	protected  static $result;
	
	public function __construct($dbCompany, $estrutura){
		$this->dao = new AssemblerDAOImpl($dbCompany); 
		self::$estrutura = $estrutura;
		self::$dev = $this->dao->retorna(SchemaType::DEV);
		self::$result = self::$homolog = $this->dao->retorna(SchemaType::HOMOLOG);
		$this->dao = NULL;
	}
	
	public function __destruct(){
		$this->dao = NULL;
	}
	
	public static function dev(){
		return self::$dev;
	}
	
	public static function homolog(){
		return self::$homolog;
	}
	
}