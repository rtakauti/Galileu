<?php
include_once 'estrutura/Estrutura.php';

class SchemaBO extends Estrutura{
	
	
	public static function dev(){
		return array_keys(parent::$dev['schema']);
	}
	
	public static function homolog(){
		return array_keys(parent::$homolog['schema']);
	}
	
	
	public function listarDev(){
		$schemas = self::dev();
		$string = "";
		if(!empty($schemas)){
			$string .= "\n\n\n";
			$string .= str_pad(" DEV SCHEMA ",50,"-",STR_PAD_BOTH);
			$i=1;
			foreach ($schemas as $schema) {
				$string .= "\n\t--$i--  $schema";
				$i++;
			}
		}
		return $string;
	}
	
	public function listarHomolog(){
		$schemas = self::homolog();
		$string = "";
		if(!empty($schemas)){
			$string .= "\n\n\n";
			$string .= str_pad(" HOMOLOG SCHEMA ",50,"-",STR_PAD_BOTH);
			$i=1;
			foreach ($schemas as $schema) {
				$string .= "\n\t--$i--  $schema";
				$i++;
			}
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
			$string .= "\n\n\n";
			$string .= str_pad(" DROP DE SCHEMA ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ( $schemas as $schema ) {
				$string .= "\nDROP SCHEMA IF EXISTS $schema CASCADE;";
			}
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	
	public function create() {
		$dev = self::dev();
		$homolog = self::homolog();
		$schemas = array_diff($dev, $homolog);
		$string = "";
		if (! empty ( $schemas ))
			$string .= "\n\n\n";
			$string .= str_pad(" CREATE DE SCHEMA ",100,"-",STR_PAD_BOTH);
			foreach ( $schemas as $schema ) {
				$string .= "\nCREATE SCHEMA $schema;";
			}
		return $string;
	}
	
	
}