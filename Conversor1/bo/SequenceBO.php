<?php

class SequenceBO extends SchemaBO{
	
	public static function dev() {
		$lista = array ();
		$schemas = parent::dev();
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
		$schemas = parent::homolog();
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
		$sequences = self::dev();
		$string = "";
		if (! empty ( $sequences )) {
			$string .= "\n\n\n";
			$string .= str_pad(" DEV SEQUENCES ",50,"-",STR_PAD_BOTH);
			$i=1;
			foreach ($sequences as $sequence) {
				$string .= "\n\t--$i--   $sequence";
				$i++;
			}
		}
		return $string;
	}
	
	public function listarHomolog() {
		$sequences = self::homolog();
		$string = "";
		if (! empty ( $sequences )) {
			$string .= "\n\n\n";
			$string .= str_pad(" HOMOLOG SEQUENCES ",50,"-",STR_PAD_BOTH);
			$i=1;
			foreach ($sequences as $sequence) {
				$string .= "\n\t--$i--   $sequence";
				$i++;
			}
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
			$string .= "\n\n\n";
			$string .= str_pad(" DROP DE SEQUENCES ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ( $sequences as $sequence ) {
				list($schema, $sequence) = explode(".", $sequence);
				$string .= "\nDROP SEQUENCE IF EXISTS $schema.$sequence CASCADE;";
			}
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	
	public function create() {
		$dev = self::dev();
		$homolog = self::homolog();
		$sequences = array_diff($dev, $homolog);
		$string = "";
		if (! empty ( $sequences )) {
			$string .= "\n\n\n";
			$string .= str_pad(" CREATE DE SEQUENCES ",100,"-",STR_PAD_BOTH);
			foreach ( $sequences as $sequenceInput ) {
				list($schema, $sequence) = explode(".", $sequenceInput);
				$string .= "\n\nCREATE SEQUENCE $schema.$sequence ";
				$string .= "\n\tINCREMENT 1";
				$string .= "\n\tMINVALUE 1";
				$string .= "\n\tSTART 1";
				$string .= "\n\tCACHE 1;";
			}
		}
		return $string;
	}
	
	
}
