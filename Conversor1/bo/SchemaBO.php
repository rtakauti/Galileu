<?php
include_once 'estrutura/Estrutura.php';
class SchemaBO extends Estrutura{
	
	private static function dev(){
		return parent::$dev['schemas'];
	}
	
	private static function homolog(){
		return parent::$homolog['schemas'];
	}
	
	
	private function listarSchema($schemas, $titulo){
		$string = "";
		if(!empty($schemas)){
			$string .= "\n\n\n";
			$string .= str_pad(" $titulo SCHEMA ",50,"-",STR_PAD_BOTH);
			foreach ($schemas as $indice => $schema) $string .= "\n\t--$indice--  $schema";
		}
		return $string;
	}
	
	
	
	public function listar(){
		$string = "";
		$string .= $this->listarSchema(self::dev(), "DEV");
		$string .= $this->listarSchema(self::homolog(), "HOMOLOG");
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
				$string .= "\nDROP SCHEMA IF EXISTS $schema;";
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