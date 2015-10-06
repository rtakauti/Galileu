<?php
include_once __DIR__.'/../dao/daoImpl/ConstraintDAOImpl.php';
include_once __DIR__.'/../enum/SchemasCompany.php';
include_once __DIR__.'/../enum/SchemaType.php';
include_once 'BOImpl.php';

class ConstraintBO extends BOImpl{
	
	protected $dao;
	private $table;
	
	
	public function __construct($schemaCompany, $queryParameter){
		$this->dao = new ConstraintDAOImpl($schemaCompany, $queryParameter);
		$this->table = $queryParameter;
	}
	
	public function dropConstraintHomolog(){ 
		if (isset ( $this->dao->arrayHomolog ) && isset ( $this->dao->arrayDev )) {
			$array = array_diff_assoc ( $this->dao->arrayHomolog, $this->dao->arrayDev );
			ksort ( $array );
			$array = array_keys ( $array );
			$string = "\n\n------ DROP DE CONSTRAINTS ------";
			foreach ( $array as  $value ) {
				$string .= "\nALTER TABLE {$this->table} DROP CONSTRAINT $value;";
			}
			return $string;
		}
	}
	
	public function addConstraintHomolog(){
		if (isset ( $this->dao->arrayHomolog ) && isset ( $this->dao->arrayDev )) {
			$array = array_diff_assoc ( $this->dao->arrayDev, $this->dao->arrayHomolog );
			ksort ( $array );
			$array = array_keys ( $array );
			$string = "\n\n------ ADD DE CONSTRAINTS ------";
			foreach ( $array as  $value ) {
				$string .= "\nALTER TABLE {$this->table} ADD CONSTRAINT $value;";
			}
			return $string;
		}
	}
	
	public function arrayHomolog(){
		return $this->dao->arrayHomolog;
	}
	
	public function arrayDev(){
		return $this->dao->arrayDev;
	}
}