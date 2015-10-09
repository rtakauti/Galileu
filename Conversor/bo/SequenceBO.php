<?php
include_once realpath (__DIR__.'/../dao/daoImpl/SequenceDAOImpl.php');
include_once realpath (__DIR__.'/../enum/SchemasCompany.php');
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
include_once 'sequence/GerenciadorSequence.php';
include_once 'BOImpl.php';

class SequenceBO extends BOImpl{
	
protected  $dao;
private $estrutura;
	
	public function __construct($dbCompany, $schemaParameter){
		$this->dao = new SequenceDAOImpl($dbCompany, $schemaParameter);
		$this->estrutura[EstruturaQuery::COMPANY] = $dbCompany;
		$this->estrutura[EstruturaQuery::SCHEMA] = $schemaParameter;
		$this->resetSeqGerenciamento();
		$this->cargaSeqGerenciamento();
	}
	
	
	public function dropSequence() {
		$schema = $this->estrutura[EstruturaQuery::SCHEMA];
		$sequences = $this->diff_homolog_devQuery ();
		$string = "";
		if (! empty ( $sequences )) {
			$string = "\n\n\n--------------------  DROP DE SEQUENCES $schema -------------------- ";
			foreach ( $sequences as $sequence ) {
				$string .= "\nDROP SEQUENCE $sequence ;";
			}
		}
		return $string;
	}
	
	public function createSequence() {
		$schema = $this->estrutura[EstruturaQuery::SCHEMA];
		$sequences = $this->diff_dev_homologQuery ();
		$string = "";
		if (! empty ( $sequences )) {
			$string = "\n\n\n--------------------  CREATE DE SEQUENCES $schema -------------------- ";
			foreach ( $sequences as $sequence ) {
				$string .= "\nCREATE SEQUENCE $sequence;";
			}
		}
		return $string;
	}
	
	public function cargaSeqGerenciamento() {
		$sequences = $this->intersect_homolog_devQuery ();
		if (isset ( $sequences )){
			foreach ( $sequences as $sequence ) {
				GerenciadorSequence::adicionaCriados ( $sequence );
			}
		}
	}
	
	public function resetSeqGerenciamento(){
		GerenciadorSequence::resetCriados();
		GerenciadorSequence::resetQueryCriado();
		GerenciadorSequence::resetQuerySetado();
	}
	
}