<?php

include_once realpath(__DIR__.'/../dao/daoImpl/AssemblerDAOImpl.php');

class AssemblerBO {
	
	private $dao;
	private $dev;
	private $homolog;
	
	public function __construct($dbCompany){
		$this->dao = new AssemblerDAOImpl($dbCompany); 
		$this->dev = $this->dao->retorna(SchemaType::DEV);
		$this->homolog = $this->dao->retorna(SchemaType::HOMOLOG);
	}
	
	
	
	public function dev(){
		return $this->dev;
		
	}
	
}