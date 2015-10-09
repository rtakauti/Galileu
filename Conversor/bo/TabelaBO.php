<?php
include_once realpath (__DIR__.'/../dao/daoImpl/TabelaDAOImpl.php');
include_once realpath (__DIR__.'/../enum/SchemasCompany.php');
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/FaseQuery.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
include_once 'BOImpl.php';
include_once 'ColunaBO.php';
include_once 'ConstraintBO.php';

class TabelaBO extends BOImpl{
	
	protected  $dao;
	private $estrutura;
	
	public function __construct($dbCompany, $schemaParameter, $sequenceParameter, $estrutura){
		$this->estrutura = $estrutura;
		$this->dao = new TableDAOImpl($dbCompany, $schemaParameter);
		$this->estrutura[EstruturaQuery::SEQUENCE] = $sequenceParameter;
		$this->estrutura[EstruturaQuery::SCHEMA] = $schemaParameter;
		$this->estrutura[EstruturaQuery::COMPANY] = $dbCompany;
	}
	
	
	public function dropTable(){
		$tabelas = $this->diff_homolog_devQuery();
		$string = "";
		if(!empty($tabelas)){
			$string = "\n\n\n-------------------- DROP TABLE --------------------";
			foreach ($tabelas as $tabela) {
				$string .= "\nDROP TABLE $tabela CASCADE;";
			}
		}
		return $string;
	}
	
	public function createTable(){
		$empresa = $this->estrutura[EstruturaQuery::COMPANY];
		$schema= $this->estrutura[EstruturaQuery::SCHEMA];
		$sequence = $this->estrutura[EstruturaQuery::SEQUENCE];
		$user = $this->estrutura[EstruturaQuery::USER];
		$tabelas = $this->diff_dev_homologQuery();
		$fase = FaseQuery::CREATE;
		$colunas = array();
		$stringResult = "\n\n\n-------------------- CREATE TABLE --------------------";
		if(!empty($tabelas)){
			foreach ($tabelas as $tabela) {
				$string = "\n\nCREATE TABLE $tabela";
				$string .="\n(\n";
				$stringColuna = "";
				$stringConstraint = "";
				$colunaBO = new ColunaBO($empresa, $schema , $tabela, $sequence, $fase);
				$string .= $colunaBO->createColumn();
				$constraintBO = new ConstraintBO($empresa, $schema, $tabela, $fase);
				$string .= $constraintBO->createConstraint();
				$string = substr ( $string, 0, - 2 );
				$string .= "\n)";
				$string .= "\nWITH (";
				$string .= "\n\tOIDS=FALSE";
				$string .= "\n);";
				$string .= "\nALTER TABLE $tabela";
				$string .= "\n\tOWNER TO $user;";
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
		$tabelas = $this->intersect_homolog_devQuery();
		$fase = FaseQuery::ALTER;
		$colunas = array();
		$stringResult = "\n\n\n-------------------- ALTER TABLE --------------------";
		$string = "";
		if(!empty($tabelas)){
			foreach ($tabelas as $tabela) {
				$constraintBO = new ConstraintBO($empresa, $schema, $tabela, $fase);
				//$string .= $constraintBO->dr
				$colunaBO = new ColunaBO($empresa, $schema , $tabela, $sequence, $fase);
				$string .= $colunaBO->dropColumn();
				$triggerBO = new TriggerBO($empresa, $schema, $tabela);
				$string .= $triggerBO->dropTrigger();
			}
			return $stringResult.$string;
		}
	}
	
}