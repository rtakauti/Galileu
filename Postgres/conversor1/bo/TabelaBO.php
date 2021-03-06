<?php
include_once realpath (__DIR__.'/../dao/daoImpl/TabelaDAOImpl.php');
include_once realpath (__DIR__.'/../enum/SchemasCompany.php');
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
include_once 'BOImpl.php';
include_once 'ColunaBO.php';

class TabelaBO extends BOImpl{
	
	protected  $dao;
	private $estrutura;
	
	public function __construct($dbCompany, $schemaParameter, $sequenceParameter){
		$this->dao = new TableDAOImpl($dbCompany, $schemaParameter);
		$this->estrutura[EstruturaQuery::SEQUENCE] = $sequenceParameter;
		$this->estrutura[EstruturaQuery::SCHEMA] = $schemaParameter;
		$this->estrutura[EstruturaQuery::COMPANY] = $dbCompany;
	}
	
	public function createTableDev(){
		return $this->arrayDev();
	}
	
	public function createTable(){
		$empresa = $this->estrutura[EstruturaQuery::COMPANY];
		$schema= $this->estrutura[EstruturaQuery::SCHEMA];
		$sequence = $this->estrutura[EstruturaQuery::SEQUENCE];
		$tabelas = $this->diff_dev_homologQuery();
		$colunas = array();
		$stringResult = "\n\n-------------------- CREATE TABLE --------------------";
		if(!empty($tabelas)){
			foreach ($tabelas as $tabela) {
				$string = "\n\nCREATE TABLE $tabela";
				$string .="\n(\n";
				$colunaBO = new ColunaBO($empresa, $schema , $tabela, $sequence);
				$string .= $colunaBO->createColumn();
				$string .= "\n);";
				$stringResult .= GerenciadorSequence::getQueryCriado().$string.GerenciadorSequence::getQuerySetado();
				$string = "";
			}
			return $stringResult;
		}
	}
	
	
	
}