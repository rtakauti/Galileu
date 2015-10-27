<?php
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once 'estrutura/Estrutura.php';

class SequenceBO extends Estrutura{
	
	
	
	public static function dev() {
		$lista = array ();
		$schemas = array_keys(parent::$dev['schema']);
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$dev ['schema'] [$schema] ['sequence'] )) {
				$sequences = array_keys ( parent::$dev ['schema'] [$schema] ['sequence'] );
				foreach ( $sequences as $sequence ) {
					$lista [] = "$schema.$sequence";
					parent::$sequences[] = "$schema.$sequence";
				}
			}
		}
		return $lista;
	}
	
	
	public static function homolog() {
		$lista = array ();
		$schemas = array_keys(parent::$homolog['schema']);
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
		$dev = self::dev();
		$string = "";
		if (! empty ( $dev )) {
			$string = "\n\n------ DEV SEQUENCES ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $dev );
		}
		return $string;
	}
	
	public function listarHomolog() {
		$homolog = self::homolog();
		$string = "";
		if (! empty ( $homolog )) {
			$string = "\n\n------ HOMOLOG SEQUENCES ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $homolog );
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
			$string .= "\n\n\n--------------------  DROP DE SEQUENCES -------------------- ";
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
	
	
	public function create() {
		$dev = self::dev();
		$homolog = self::homolog();
		$sequences = array_diff($dev, $homolog);
		$string = "";
		if (! empty ( $sequences )) {
			$string .= "\n\n\n--------------------  CREATE DE SEQUENCES -------------------- ";
			foreach ( $sequences as $sequence ) {
				list($schema, $sequence) = explode(".", $sequence);
				$string .= "\n\nCREATE SEQUENCE $schema.$sequence ";
				$string .= "\n\tINCREMENT 1";
				$string .= "\n\tMINVALUE 1";
				$string .= "\n\tSTART 1";
				$string .= "\n\tCACHE 1;";
				parent::$result ['schema'] [$schema] ['sequence'] [$sequence] = $sequence;
			}
		}
		return $string;
	}
	
	public function resetSeqGerenciamento(){
		GerenciadorSequence::resetCriados();
		GerenciadorSequence::resetQueryCriado();
		GerenciadorSequence::resetQuerySetado();
	}
	
}
