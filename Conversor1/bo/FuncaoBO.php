<?php
class FuncaoBO extends SchemaBO{
	
	
	public static function dev() {
		$lista = array();
		$schemas = parent::dev();
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
		$schemas = parent::homolog();
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
			$string .= "\n\n\n";
			$string .= str_pad(" DEV FUNCTIONS ",50,"-",STR_PAD_BOTH);
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
			$string .= "\n\n\n";
			$string .= str_pad(" HOMOLOG FUNCTIONS ",50,"-",STR_PAD_BOTH);
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
			$string .= "\n\n\n";
			$string .= str_pad(" DROP DE FUNCTION, PROCEDURE, TRIGGER ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ( $funcoes as $funcao ) {
				list($schema, $funcao) = explode(".", $funcao);
				 $string .= "\nDROP FUNCTION IF EXISTS $schema.$funcao CASCADE;";
			}
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	public function create() {
		$dev = self::dev();
		$homolog = self::homolog();
		$funcoes = array_diff($dev, $homolog);
		$string = "";
		if (! empty ( $funcoes )) {
			$string .= "\n\n\n";
			$string .= str_pad(" CREATE DE FUNCTION, PROCEDURE, TRIGGER ",100,"-",STR_PAD_BOTH);
			foreach ( $funcoes as $funcao ) {
				list($schema, $funcao) = explode(".", $funcao);
				$create = parent::$dev ['schema'] [$schema] ['funcao'][$funcao]['create'];
				$string .= "\n\n$create";
			}
		}
		return $string;
	}
	
	public function alter(){
		$dev = self::dev();
		$homolog = self::homolog();
		$funcoes = array_intersect($dev, $homolog);
		$string = "";
		if(!empty($funcoes)){
			$string .= "\n\n\n";
			$string .= str_pad(" ALTER DE FUNCTION, PROCEDURE, TRIGGER ",100,"-",STR_PAD_BOTH);
			foreach ($funcoes as $funcoesInput) {
				list($schema, $funcao) = explode(".", $funcoesInput);
				$devCreate = parent::$dev ['schema'] [$schema] ['funcao'][$funcao]['create'];
				$homologCreate = parent::$homolog ['schema'] [$schema] ['funcao'][$funcao]['create'];
				if($devCreate != $homologCreate){
					$string .= "\n\nDROP FUNCTION IF EXISTS $schema.$funcao CASCADE;";
					
					$string .= "\n\n$devCreate";
				}
			}
		}
		return $string;
	}
	
}







