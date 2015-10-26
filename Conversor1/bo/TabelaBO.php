<?php
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/FaseQuery.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
include_once 'ColunaBO.php';
include_once 'ConstraintBO.php';

class TabelaBO extends AssemblerBO{
	
	
	
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
		$user = parent::$estrutura[EstruturaQuery::USER];
		if(!empty($tabelas)){
			$stringResult .= "\n\n\n-------------------- CREATE TABLE --------------------";
			foreach ($tabelas as $tabelaInput) {
				list($schema, $tabela) = explode(".", $tabelaInput);
				$coluna = new ColunaBO();
				$constraint = new ConstraintBO();
				$string = "\n\n\nCREATE TABLE $schema.$tabela";
				$string .="\n(\n";
				$string .= $coluna->create($tabelaInput);
				$string .= $constraint->create($tabelaInput);
				$string = substr($string, 0, -2);
				$string .= "\n)";
				$string .= "\nWITH (\n\tOIDS=FALSE\n);";
				$string .= "\nALTER TABLE $tabela \n\tOWNER TO $user;";
				/*
				$triggerBO = new TriggerBO($empresa, $schema, $tabela);
				$string .= $triggerBO->createTrigger();
				$indiceBO = new IndiceBO($empresa, $schema, $tabela);
				$string .= $indiceBO->createIndex();
				$stringResult .= GerenciadorSequence::getQueryCriado().$string.GerenciadorSequence::getQuerySetado();
				*/
				$stringResult .= $string;
				//$string = "";
			}
			return $stringResult;
		}
	}
	
	public function alter(){
		$dev = self::dev();
		$homolog = self::homolog();
		$tabelas = array_intersect($homolog, $dev);
		$fase = FaseQuery::ALTER;
		$colunas = array();
		$stringResult = "\n\n\n------------------------------ ALTER TABLE ------------------------------";
		$string = "";
		if(!empty($tabelas)){
			foreach ($tabelas as $tabela) {
				$colunaBO = new ColunaBO($empresa, $schema , $tabela, $sequence, $fase, $homolog[$tabela], $dev[$tabela]);
				$string .= $colunaBO->dropColumn();
				$string .= $colunaBO->addColumn();
				$string .= $colunaBO->alterColumn();
				$indiceBO = new IndiceBO($empresa, $schema, $tabela);
				$string .= $indiceBO->dropIndice();
				$string .= $indiceBO->createIndex();
				$constraintBO = new ConstraintBO($empresa, $schema, $tabela, $fase);
				$string .= $constraintBO->dropConstraint();
				$string .= $constraintBO->addConstraint();
				$triggerBO = new TriggerBO($empresa, $schema, $tabela);
				$string .= $triggerBO->dropTrigger();
				$string .= $triggerBO->createTrigger();
				$stringResult .= GerenciadorSequence::getQueryCriado().$string.GerenciadorSequence::getQuerySetado();
				$string = "";
			}
			return $stringResult.$string;
		}
	}
	
}