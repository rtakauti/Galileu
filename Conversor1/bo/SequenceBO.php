<?php
include_once 'estrutura/Estrutura.php';
class SequenceBO extends Estrutura{
	
	private static function dev() {
		return parent::$dev['sequences'];
	}
	
	
	private static function homolog() {
		return parent::$homolog['sequences'];
	}
	
	
	private function listarSequence($sequences, $titulo) {
		$string = "";
		if (! empty ( $sequences )) {
			$string .= "\n\n\n";
			$string .= str_pad(" $titulo SEQUENCES ",50,"-",STR_PAD_BOTH);
			foreach ($sequences as $indice => $sequence) $string .= "\n\t--$indice--   $sequence";
		}
		return $string;
	}
	
	
	public function listar(){
		$string = "";
		$string .= $this->listarSequence(self::dev(), "DEV");
		$string .= $this->listarSequence(self::homolog(), "HOMOLOG");
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
				$string .= "\nDROP SEQUENCE IF EXISTS $schema.$sequence;";
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
