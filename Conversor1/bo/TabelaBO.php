<?php
class TabelaBO extends SchemaBO{
	
	public static function dev() {
		$lista = array ();
		$schemas = parent::dev();
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] )) {
				$tabelas = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] );
				foreach ( $tabelas as $tabela ) {
					$lista [] = "$schema.$tabela";
				}
			}
		}
		return $lista;
	}
	
	
	public static function homolog() {
		$lista = array ();
		$schemas = parent::homolog();
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] )) {
				$tabelas = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] );
				foreach ( $tabelas as $tabela ) {
					$lista [] = "$schema.$tabela";
				}
			}
		}
		return $lista;
	}
	
	
	public function listarDev() {
		$lista = self::dev();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ DEV TABELAS ------";
			$string .= "\n\t-- " . implode ( "\n\t-- ", $lista );
		}
		return $string;
	}
	
	public function listarHomolog() {
		$lista = self::homolog();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ HOMOLOG TABELAS ------";
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
	
	
	public function drop(){
		$dev = self::dev();
		$homolog = self::homolog();
		$tabelas = array_diff ( $homolog, $dev );
		$string = "";
		if(!empty($tabelas)){
			$string .= "\n\n\n------------------------------ DROP TABLE ------------------------------";
			$string .= "\n/*\n";
			foreach ($tabelas as $tabela) {
				list($schema, $tabela) = explode(".", $tabela);
				$string .= "\nDROP TABLE IF EXISTS $schema.$tabela CASCADE;";
			}
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	
	
	public function create(){
		$dev = self::dev();
		$homolog = self::homolog();
		$tabelas = array_diff($dev, $homolog);
		$string = "";
		$user = parent::$user;
		if(!empty($tabelas)){
			$coluna = new ColunaBO();
			$constraint = new ConstraintBO();
			$string .= "\n\n\n------------------------------ CREATE TABLE ------------------------------";
			foreach ($tabelas as $tabelaInput) {
				list($schema, $tabela) = explode(".", $tabelaInput);
				parent::$schema = $schema;
				parent::$tabela = $tabela;
				$string .= "\n\n\nCREATE TABLE $schema.$tabela";
				$string .="\n(\n";
				$string .= $coluna->create();
				$string .= $constraint->create();
				$string = substr($string, 0, -2);
				$string .= "\n)";
				$string .= "\nWITH (\n\tOIDS=FALSE\n);";
				$string .= "\nALTER TABLE $tabela \n\tOWNER TO $user;";
			}
			return $string;
		}
	}
	
	
}