<?php
//include_once realpath(__DIR__.'/../dao/daoImpl/SchemaDAOImpl.php');
include_once realpath(__DIR__.'/../enum/SchemasCompany.php');
include_once realpath(__DIR__.'/../enum/SchemaType.php');
include_once realpath(__DIR__.'/../enum/EstruturaQuery.php');
//include_once 'BOImpl.php';
//include_once 'TabelaBO.php';

class SchemaBO extends AssemblerBO{
	
	
	public function __construct(){
	}
	
	public static function dev(){
		return array_keys(parent::$dev['schema']);
	}
	
	public static function homolog(){
		return array_keys(parent::$homolog['schema']);
	}
	
	public function listarDev(){
		$dev = self::dev();
		if(!empty($dev)){
			$string = "\n\n------ DEV SCHEMAS ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $dev )  ;
			return $string;
		}
	}
	
	public function listarHomolog(){
		$homolog = self::homolog();
		if(!empty($homolog)){
			$string = "\n\n------ HOMOLOG SCHEMAS ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $homolog )  ;
			return $string;
		}
	}
	
	
	public function listar(){
		$string = "";
		$string .= $this->listarDev();
		$string .= $this->listarHomolog();
		return $string;
	}
	
	public function drop() {
		$dev = self::dev();
		$homolog = self::homolog();
		$schemas = array_diff ( $homolog, $dev );
		$string = "";
		if (! empty ( $schemas )) {
			$string = "\n\n\n\n------------------------------ DROP DE SCHEMAS ------------------------------";
			$string .= "\n/*";
			foreach ( $schemas as $schema ) {
				$string .= "\nDROP SCHEMA IF EXISTS $schema CASCADE;";
				unset ( parent::$homolog ['schema'] [$schema] );
			}
			$string .= "\n*/";
		}
		return $string;
	}
}
	
	
	/*
	
	public function setSchema($schemaName){
		$string = "\n\n-------------------- SET SCHEMA $schemaName --------------------";
		$string .= "\nSET SEARCH_PATH TO $schemaName;";
		return $string;
	
	public function createSchema() {
		$estrutura = $this->estrutura;
		$dbCompany = $estrutura[EstruturaQuery::COMPANY];
		//$schemas = $this->diff_dev_homologQuery ();
		$dev = array_keys($this->devArray['schema']);
		$homolog = array_keys($this->homologArray['schema']);
		$schemas = array_diff($dev, $homolog);
		$string = "";
		if (! empty ( $schemas ))
			foreach ( $schemas as $schema ) {
				$estrutura = $this->estrutura;
				$string .= "\n\n\n\n------------------------------ CREATE SCHEMA ------------------------------";
				$string .= "\nCREATE SCHEMA $schema;";
				$string .= $this->setSchema ( $schema );
				$sequence = new SequenceBO ( $dbCompany, $schema, $this->devArray['sequence'], $this->homologArray['sequence'] );
				$string .= $sequence->dropSequence ();
				$sequenceParameter = $sequence->diff_dev_homologQuery();
				$string .= $sequence->createSequence ();
				$tabela = new TabelaBO ( $dbCompany, $schema,$sequenceParameter, $estrutura );
				$string .= $tabela->createTable ();
				$funcao = new FuncaoBO($dbCompany, $schema);
				$string .= $funcao->createFuncao();
			}
		return $string;
	}
	
	public function alterSchema(){
		$dbCompany = $this->estrutura [EstruturaQuery::COMPANY];
		$schemas = $this->intersect_homolog_devQuery();
		$string = "";
		if (! empty ( $schemas ))
			foreach ( $schemas as $schema ) {
				$string .= "\n\n\n\n------------------------------ ALTER SCHEMA ------------------------------";
				$string .= $this->setSchema ( $schema );
				$sequence = new SequenceBO ( $dbCompany, $schema );
				$string .= $sequence->dropSequence ();
				$sequenceParameter = $sequence->diff_dev_homologQuery();
				$string .= $sequence->createSequence ();
				$tabela = new TabelaBO ( $dbCompany, $schema,$sequenceParameter, $this->estrutura );
				$string .= $tabela->dropTable();
				$string .= $tabela->createTable ();
				$string .= $tabela->alterTable();
				$funcao = new FuncaoBO($dbCompany, $schema);
				$string .= $funcao->dropFuncao();
				$string .= $funcao->createFuncao();
			}
		return $string;
	}
	
	*/
