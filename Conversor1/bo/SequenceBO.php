<?php
include_once 'estrutura/Estrutura.php';
class SequenceBO extends Estrutura{
	
	
	
public function listar(){
		$string = "";
		$string .= parent::lista(parent::$dev['sequences'], "DEV SEQUENCE");
		$string .= parent::lista(parent::$homolog['sequences'], "HOMOLOG SEQUENCE");
		return $string;
	}
	
	public function drop() {
		$sequences = array_diff ( parent::$homolog['sequences'], parent::$dev['sequences'] );
		$string = "";
		if (! empty ( $sequences )) {
			$string .= "\n\n\n".str_pad(" DROP DE SEQUENCES ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ( $sequences as $sequence ) $string .= "\nDROP SEQUENCE IF EXISTS $sequence;";
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	
	public function create() {
		$sequences = array_diff(parent::$dev['sequences'] , parent::$homolog['sequences']);
		$string = "";
		if (! empty ( $sequences )) {
			$string .= "\n\n\n".str_pad(" CREATE DE SEQUENCES ",100,"-",STR_PAD_BOTH);
			foreach ( $sequences as $sequence) {
				$string .= "\n\nCREATE SEQUENCE $sequence;";
				//$string .= "\n\tINCREMENT 1";
				//$string .= "\n\tMINVALUE 1";
				//$string .= "\n\tSTART 1";
				//$string .= "\n\tCACHE 1;";
			}
		}
		return $string;
	}
	
	
}
