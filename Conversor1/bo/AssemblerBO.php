<?php
error_reporting ( E_ALL );
ini_set ( "display_errors", 1 );

include_once realpath(__DIR__.'/../dao/daoImpl/AssemblerDAOImpl.php');
include_once 'estrutura/Estrutura.php';

class AssemblerBO extends Estrutura{
	
	private $dao;
	
	public function __construct(){
		$this->dao = new AssemblerDAOImpl(); 
		parent::$dev = $this->dao->retorna(SchemaType::DEV);
		parent::$result = parent::$homolog = $this->dao->retorna(SchemaType::HOMOLOG);
		$this->dao = NULL;
	}
	
	
	public static function dev(){
		return self::$dev;
	}
	
	public static function homolog(){
		return self::$homolog;
	}
	
}