<?php
include_once realpath(__DIR__.'/../dao/daoImpl/SchemaDAOImpl.php');
include_once realpath(__DIR__.'/../enum/SchemasCompany.php');
include_once realpath(__DIR__.'/../enum/SchemaType.php');
include_once __DIR__.'/../enum/EstruturaQuery.php';
include_once 'BOImpl.php';
include_once 'TabelaBO.php';

class SchemaBO extends BOImpl{
	
	protected  $dao;
	private $estrutura;
	
	public function __construct($schemaCompany){
		$this->dao = new SchemaDAOImpl($schemaCompany);
		$this->estrutura[EstruturaQuery::COMPANY] = $schemaCompany;
	}
	
	
	public function listarHomolog(){
		$homolog = $this->arrayHomolog();
		if(!empty($homolog)){
		$string = "\n\n------ HOMOLOG SCHEMAS ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $homolog )  ;
		return $string;
		}
	}
	
	public function listarDev(){
		$dev = $this->arrayDev();
		if(!empty($dev)){
		$string = "\n\n------ DEV SCHEMAS ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $dev )  ;
		return $string;
		}
	}
	
	public function setSchema($schemaName){
		$string = "\n\n-------------------- SET SCHEMAS --------------------";
		$string .= "\nSET SEARCH_PATH TO $schemaName;";
		return $string;
	
	}
	
	public function dropSchema() {
		$array = $this->diff_homolog_devQuery ();
		if (!empty ( $array )) {
		$string = "\n\n-------------------- DROP DE SCHEMAS --------------------";
			foreach ( $array as $schema ) {
				$string .= "\nDROP SCHEMA IF EXISTS $schema CASCADE;";
			}
		return $string;
		}
		return ;
	}
	
	public function createSchema() {
		$empresa = $this->estrutura [EstruturaQuery::COMPANY];
		$schemas = $this->diff_dev_homologQuery ();
		$string = "";
		if (! empty ( $schemas ))
			foreach ( $schemas as $schema ) {
				$string .= "\n\n\n\n-------------------- CREATE SCHEMA --------------------";
				$string .= "\nCREATE SCHEMA $schema;";
				$string .= $this->setSchema ( $schema );
				$sequence = new SequenceBO ( $empresa, $schema );
				$string .= $sequence->dropSequence ();
				$sequenceParameter = $sequence->diff_dev_homologQuery();
				$string .= $sequence->createSequence ();
				$tabela = new TabelaBO ( $empresa, $schema,$sequenceParameter );
				$string .= $tabela->createTable ();
			}
		return $string;
	}
	
	public function alterSchema(){
		$empresa = $this->estrutura [EstruturaQuery::COMPANY];
		$schemas = $this->intersect_homolog_devQuery();
		$string = "";
		if (! empty ( $schemas ))
			foreach ( $schemas as $schema ) {
				$string .= "\n\n\n\n-------------------- ALTER SCHEMA --------------------";
				$string .= $this->setSchema ( $schema );
				$sequence = new SequenceBO ( $empresa, $schema );
				$string .= $sequence->dropSequence ();
				$sequenceParameter = $sequence->diff_dev_homologQuery();
				$string .= $sequence->createSequence ();
				$tabela = new TabelaBO ( $empresa, $schema,$sequenceParameter );
				$string .= $tabela->createTable ();
			}
		return $string;
	}
	
	
	/*
	public function createSchemaHomolog(){
		$array = $this->diff_dev_homologQuery();
		if (!empty ( $array )) {
		$string = "\n\n------ CREATE DE SCHEMAS ------";
			foreach ( $array as $schema ) {
				$string .= "\nCREATE SCHEMA $schema;";
			}
		return $string;
		}
		return ;
	}
	*/
	
}