<?php
include_once __DIR__.'/../dao/daoImpl/SequenceDAOImpl.php';
include_once __DIR__.'/../enum/SchemasCompany.php';
include_once __DIR__.'/../enum/SchemaType.php';
include_once '/sequence/GerenciadorSequence.php';
include_once 'BOImpl.php';

class SequenceBO extends BOImpl{
	
protected  $dao;
	
	public function __construct($schemaCompany, $schemaParameter){
		$this->dao = new SequenceDAOImpl($schemaCompany, $schemaParameter);
		$this->resetSeqGerenciamento();
		$this->cargaSeqGerenciamento();
	}
	
	
	public function dropSequence() {
		$sequences = $this->diff_homolog_devQuery ();
		if (!empty ( $sequences )) {
			$string = "\n\n--------------------  DROP DE SEQUENCES -------------------- ";
			foreach ( $sequences as $sequence ) {
				$string .= "\nDROP SEQUENCE $sequence CASCADE;";
			}
			return $string;
		}
		return;
	}
	
	public function createSequence() {
		$sequences = $this->diff_dev_homologQuery ();
		if (!empty ( $sequences )) {
			$string = "\n\n--------------------  CREATE DE SEQUENCES -------------------- ";
			foreach ( $sequences as $sequence ) {
				$string .= "\nCREATE SEQUENCE $sequence;";
			}
			return $string;
		}
		return;
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