<?php
include_once realpath (__DIR__.'/../enum/SchemasCompany.php');
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/FaseQuery.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
//include_once 'BOImpl.php';
include_once 'ColunaBO.php';
include_once 'ConstraintBO.php';

class TabelaBO extends AssemblerBO{
	
	
	public function __construct(){
	}
	
	public static function dev() {
		$schemas = array_keys ( parent::$dev ['schema'] );
		$lista = array ();
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] )) {
				$tabelas = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] );
				foreach ( $tabelas as $tabela ) {
					$lista [] = $tabela;
				}
			}
		}
		return $lista;
	}
	
	
	public static function homolog() {
		$schemas = array_keys ( parent::$homolog ['schema'] );
		$lista = array ();
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] )) {
				$tabelas = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] );
				foreach ( $tabelas as $tabela ) {
					$lista [] = $tabela;
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
				$string .= "\nDROP TABLE IF EXISTS $tabela CASCADE;";
				unset ( parent::$homolog ['schema'] [substr($tabela, 0, strpos($tabela, '.'))] ['tabela'] [$tabela] );
			}
			$string .= "\n*/";
		}
		return $string;
	}
	
	
	
	public function createTable(){
		$empresa = $this->estrutura[EstruturaQuery::COMPANY];
		$schema= $this->estrutura[EstruturaQuery::SCHEMA];
		$sequence = $this->estrutura[EstruturaQuery::SEQUENCE];
		$user = $this->estrutura[EstruturaQuery::USER];
		//$tabelas = $this->diff_dev_homologQuery();
		$dev = $this->dev;
		$homolog = $this->homolog;
		$tabelas = array_diff(array_keys($dev), array_keys($homolog));
		$fase = FaseQuery::CREATE;
		$colunas = array();
		$stringResult = "\n\n\n------------------------------ CREATE TABLE $schema ------------------------------";
		if(!empty($tabelas)){
			foreach ($tabelas as $tabela) {
				$string = "\n\nCREATE TABLE $tabela";
				$string .="\n(\n";
				$stringColuna = "";
				$stringConstraint = "";
				$colunaBO = new ColunaBO($empresa, $schema , $tabela, $sequence, $fase, array(), $dev[$tabela]);
				$string .= $colunaBO->createColumn();
				$constraintBO = new ConstraintBO($empresa, $schema, $tabela, $fase);
				$string .= $constraintBO->createConstraint();
				$string = substr ( $string, 0, - 2 );
				$string .= "\n);";
				$string .= "\nALTER TABLE $tabela OWNER TO $user;";
				$triggerBO = new TriggerBO($empresa, $schema, $tabela);
				$string .= $triggerBO->createTrigger();
				$indiceBO = new IndiceBO($empresa, $schema, $tabela);
				$string .= $indiceBO->createIndex();
				$stringResult .= GerenciadorSequence::getQueryCriado().$string.GerenciadorSequence::getQuerySetado();
				$string = "";
			}
			return $stringResult;
		}
	}
	
	public function alterTable(){
		$empresa = $this->estrutura[EstruturaQuery::COMPANY];
		$schema= $this->estrutura[EstruturaQuery::SCHEMA];
		$sequence = $this->estrutura[EstruturaQuery::SEQUENCE];
		//$user = $this->estrutura[EstruturaQuery::USER];
		$fase = FaseQuery::ALTER;
		//$tabelas = $this->intersect_homolog_devQuery();
		$dev = $this->dev;
		$homolog = $this->homolog;
		$tabelas = array_intersect(array_keys($homolog), array_keys($dev));
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