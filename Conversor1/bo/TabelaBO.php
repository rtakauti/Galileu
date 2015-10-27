<?php
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/FaseQuery.php');
include_once 'ColunaBO.php';
include_once 'ConstraintBO.php';
include_once 'estrutura/Estrutura.php';

class TabelaBO extends Estrutura{
	
	
	
	public static function dev() {
		$lista = array ();
		$schemas = array_keys ( parent::$dev ['schema'] );
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
		$schemas = array_keys ( parent::$homolog ['schema'] );
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
			$string = "\n\n\n------------------------------ DROP TABLE ------------------------------";
			$string .= "\n/*";
			foreach ($tabelas as $tabela) {
				list($schema, $tabela) = explode(".", $tabela);
				$string .= "\nDROP TABLE IF EXISTS $schema.$tabela CASCADE;";
				unset ( parent::$result ['schema'] [$schema] ['tabela'] [$tabela] );
			}
			$string .= "\n*/";
		}
		return $string;
	}
	
	
	
	public function create(){
		$dev = self::dev();
		$homolog = self::homolog();
		$tabelas = array_diff($dev, $homolog);
		$stringResult = "";
		$user = parent::$user;
		if(!empty($tabelas)){
			$coluna = new ColunaBO();
			$constraint = new ConstraintBO();
			$stringResult .= "\n\n\n------------------------------ CREATE TABLE ------------------------------";
			foreach ($tabelas as $tabelaInput) {
				list($schema, $tabela) = explode(".", $tabelaInput);
				parent::$schema = $schema;
				parent::$tabela = $tabela;
				$string = "\n\n\nCREATE TABLE $schema.$tabela";
				$string .="\n(\n";
				$string .= $coluna->create();
				$string .= $constraint->create($tabelaInput);
				$string = substr($string, 0, -2);
				$string .= "\n)";
				$string .= "\nWITH (\n\tOIDS=FALSE\n);";
				$string .= "\nALTER TABLE $tabela \n\tOWNER TO $user;";
				$stringResult .= $string;
			}
			return $stringResult;
		}
	}
	
	
	public function add() {
		$dev = self::dev ();
		$homolog = self::homolog ();
		$tabelas = array_intersect ( $homolog, $dev );
		$stringResult = "";
		if (! empty ( $tabelas )) {
			$stringResult = "\n\n\n------------------------------ ALTER TABLE ------------------------------";
			$coluna = new ColunaBO ();
			foreach ( $tabelas as $tabelaInput ) {
				list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
				parent::$schema = $schema;
				parent::$tabela = $tabela;
				$string = $coluna->add ( );
				$stringResult .= $string;
				$string = "";
			}
			return $stringResult . $string;
		}
	}
	
	
	public function alter(){
		$dev = self::dev();
		$homolog = self::homolog();
		$tabelas = array_intersect($homolog, $dev);
		$stringResult = "";
		if(!empty($tabelas)){
			$string = "\n\n\n------------------------------ ALTER TABLE ------------------------------";
			$coluna = new ColunaBO();
			foreach ($tabelas as $tabelaInput) {
				list($schema, $tabela) = explode(".", $tabelaInput);
				parent::$schema = $schema;
				parent::$tabela = $tabela;
				$colunas = $coluna->alter();
				if($colunas != "") $string .= "\n".$colunas;
				$stringResult .= $string;
				$string = "";
			}
			return $stringResult.$string;
		}
	}
	
}