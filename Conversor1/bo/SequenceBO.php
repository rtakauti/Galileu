<?php
//include_once realpath (__DIR__.'/../dao/daoImpl/SequenceDAOImpl.php');
include_once realpath (__DIR__.'/../enum/SchemasCompany.php');
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
include_once 'sequence/GerenciadorSequence.php';
//include_once 'BOImpl.php';

class SequenceBO extends AssemblerBO{
	
	
	public function __construct(){
	}
	
	public static function dev() {
		$lista = array ();
		$schemas = array_keys ( parent::$dev ['schema'] );
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$dev ['schema'] [$schema] ['sequence'] )) {
				$sequences = array_keys ( parent::$dev ['schema'] [$schema] ['sequence'] );
				foreach ( $sequences as $sequence ) {
					$lista [] = "$schema.$sequence";
				}
			}
		}
		return $lista;
	}
	
	
	public static function homolog() {
		$lista = array ();
		$schemas = array_keys ( parent::$homolog ['schema'] );
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$homolog ['schema'] [$schema] ['sequence'] )) {
				$sequences = array_keys ( parent::$homolog ['schema'] [$schema] ['sequence'] );
				foreach ( $sequences as $sequence ) {
					$lista [] = "$schema.$sequence";
				}
			}
		}
		return $lista;
	}
	
	public function listarDev() {
		$lista = self::dev();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ DEV SEQUENCES ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $lista );
		}
		return $string;
	}
	
	public function listarHomolog() {
		$lista = self::homolog();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ HOMOLOG SEQUENCES ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $lista );
		}
		return $string;
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
		$sequences = array_diff ( $homolog, $dev );
		$string = "";
		if (! empty ( $sequences )) {
			$string = "\n\n\n--------------------  DROP DE SEQUENCES -------------------- ";
			$string .= "\n/*";
			foreach ( $sequences as $sequence ) {
				list($schema, $sequence) = explode(".", $sequence);
				$string .= "\nDROP SEQUENCE IF EXISTS $schema.$sequence CASCADE;";
				unset ( parent::$result ['schema'] [$schema] ['sequence'] [$sequence] );
			}
			$string .= "\n*/";
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
