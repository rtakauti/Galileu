<?php
include_once 'estrutura/Estrutura.php';
class SchemaBO extends Estrutura{
	
	
	public function listar(){
		$string = "";
		$string .= parent::lista(parent::$dev['schemas'], "DEV SCHEMA");
		$string .= parent::lista(parent::$homolog['schemas'], "HOMOLOG SCHEMA");
		return $string;
	}
	
	public function drop() {
		$schemas = array_diff ( parent::$homolog['schemas'],  parent::$dev['schemas'] );
		$string = "";
		if (! empty ( $schemas )) {
			$string .= "\n\n\n".str_pad(" DROP DE SCHEMA ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ( $schemas as $schema ) $string .= "\nDROP SCHEMA IF EXISTS $schema;";
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	
	public function create() {
		$schemas = array_diff(parent::$dev['schemas'], parent::$homolog['schemas']);
		$string = "";
		if (! empty ( $schemas ))
			$string .= "\n\n\n".str_pad(" CREATE DE SCHEMA ",100,"-",STR_PAD_BOTH);
			foreach ( $schemas as $schema ) $string .= "\nCREATE SCHEMA $schema;";
		return $string;
	}
	
	
}