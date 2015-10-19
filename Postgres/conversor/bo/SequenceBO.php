<?php
include_once __DIR__.'/../dao/daoImpl/SequenceDAOImpl.php';
include_once __DIR__.'/../enum/SchemasCompany.php';
include_once __DIR__.'/../enum/SchemaType.php';
include_once 'BOImpl.php';

class SequenceBO extends BOImpl{
	
protected  $dao;
	
	public function __construct($dbCompany){
		$this->dao = new SequenceDAOImpl($dbCompany);
	}
	
	
	public function dropSequenceHomolog(){
		$array = $this->diff_homolog_devQuery();
		$string = "\n\n------ DROP DE SEQUENCES ------";
		if(isset($array)){
			foreach ($array as $value) {
				$string .= "\nDROP SEQUENCE $value CASCADE;";
			}
		}
		return $string;
	}
	
	
}