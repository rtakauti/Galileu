<?php
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');

class FuncaoBO extends AssemblerBO{
	
	
	
	
	public static function dev() {
		$lista = array();
		$schemas = array_keys ( parent::$dev ['schema'] );
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$dev ['schema'] [$schema] ['funcao'] )) {
				$funcoes = array_keys ( parent::$dev ['schema'] [$schema] ['funcao'] );
				foreach ( $funcoes as $funcao ) {
					$lista [] = "$schema.$funcao";
				}
			}
		}
		return $lista;
	}
	
	public static function homolog() {
		$lista = array ();
		$schemas = array_keys ( parent::$homolog ['schema'] );
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$homolog ['schema'] [$schema] ['funcao'] )) {
				$funcoes = array_keys ( parent::$homolog ['schema'] [$schema] ['funcao'] );
				foreach ( $funcoes as $funcao ) {
					$lista [] = "$schema.$funcao";
				}
			}
		}
		return $lista;
	}
	
	public function listarDev() {
		$lista = self::dev();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ DEV FUNCTIONS ------";
			foreach ($lista as $funcao) {
				list($schema, $funcao) = explode(".", $funcao);
				$string .= "\n\t-- $schema.$funcao";
			}
		}
		return $string;
	}
	
	public function listarHomolog() {
		$lista = self::homolog();
		$string = "";
		if (! empty ( $lista )) {
			foreach ($lista as $funcao) {
				list($schema, $funcao) = explode(".", $funcao);
				$string .= "\n\t-- $schema.$funcao";
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
		$funcoes = array_diff ( $homolog, $dev );
		$string = "";
		if (! empty ( $funcoes )) {
			$string = "\n\n\n--------------------  DROP DE FUNCTION, PROCEDURE, TRIGGER -------------------- ";
			$string .= "\n/*";
			foreach ( $funcoes as $funcao ) {
				list($schema, $funcao) = explode(".", $funcao);
				 $string .= "\nDROP FUNCTION IF EXISTS $schema.$funcao CASCADE;";
				 unset ( parent::$result ['schema'] [$schema] ['funcao'] [$funcao] );
			}
			$string .= "\n*/";
		}
		return $string;
	}
	
	public function create() {
		$dev = self::dev();
		$homolog = self::homolog();
		$funcoes = array_diff($dev, $homolog);
		$string = "";
		if (! empty ( $funcoes )) {
			$string .= "\n\n\n--------------------  CREATE DE FUNCTION, PROCEDURE, TRIGGER  -------------------- ";
			foreach ( $funcoes as $funcao ) {
				list($schema, $funcao) = explode(".", $funcao);
				$create = parent::$dev ['schema'] [$schema] ['funcao'][$funcao]['create'];
				$string .= "\n\n$create";
				parent::$result ['schema'] [$schema] ['funcao'] [$funcao] = parent::$dev ['schema'] [$schema] ['funcao'] [$funcao];
			}
		}
		return $string;
	}
	
	
}