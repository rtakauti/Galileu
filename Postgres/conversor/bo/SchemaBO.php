<?php
include_once realpath(__DIR__.'/../dao/daoImpl/SchemaDAOImpl.php');
include_once realpath(__DIR__.'/../enum/SchemasCompany.php');
include_once realpath(__DIR__.'/../enum/SchemaType.php');
include_once 'BOImpl.php';

class SchemaBO extends BOImpl{
	
	protected  $dao;
	private $homolog;
	private $dev;
	
	public function __construct($dbCompany){
		$this->dao = new SchemaDAOImpl($dbCompany);
		$this->homolog = $this->arrayHomolog();
		$this->dev = $this->arrayDev();
	}
	
	
	public function listarHomolog(){
		$string = "\n\n------ HOMOLOG SCHEMAS ------";
		if(isset($this->homolog))
			$string .= "\n\t-- " . implode ( "\n\t-- ", $this->homolog )  ;
		return $string;
	}
	
	public function listarDev(){
		$string = "\n\n------ DEV SCHEMAS ------";
		if(isset($this->dev))
			$string .= "\n\t-- " . implode ( "\n\t-- ", $this->dev )  ;
		return $string;
	}
	
	public function setSchema($schemaName){
		$string = "\n\n------ SET SCHEMAS ------";
		$string .= "\nSET search_path TO $schemaName;";
		return $string;
	
	}
	
	public function dropSchemaHomolog() {
		$array = $this->diff_homolog_devQuery ();
		$string = "\n\n------ DROP DE SCHEMAS ------";
		if (isset ( $array )) {
			foreach ( $array as $schema ) {
				$string .= "\nDROP SCHEMA IF EXISTS $schema CASCADE;";
			}
		}
		return $string;
	}
	
	public function createSchemaHomolog(){
		$array = $this->diff_dev_homologQuery();
		$string = "\n\n------ CREATE DE SCHEMAS ------";
		if (isset ( $array )) {
			foreach ( $array as $schema ) {
				$string .= "\nCREATE SCHEMA $schema;";
			}
		}
		return $string;
		
	}
	
}