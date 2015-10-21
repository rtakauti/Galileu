<?php

include_once realpath(__DIR__.'/../dao/daoImpl/AssemblerDAOImpl.php');

class AssemblerBO {
	
	private $dao;
	protected  $dev;
	protected  $homolog;
	
	public function __construct($dbCompany){
		$this->dao = new AssemblerDAOImpl($dbCompany); 
		$this->dev = $this->dao->retorna(SchemaType::DEV);
		$this->homolog = $this->dao->retorna(SchemaType::HOMOLOG);
	}
	
	public function schemaDrop(){
		$dev = $this->dev;
		$homolog = $this->homolog;
		return $dev['schemas'];
		return $schema = array_diff($dev['schemas'], $homolog['schemas']);
		
		
	}
	
	public function dev(){
		return $this->dev;
		
	}
	
}