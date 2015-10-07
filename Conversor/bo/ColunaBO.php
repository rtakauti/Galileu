<?php
include_once realpath (__DIR__.'/../dao/daoImpl/ColunaDAOImpl.php');
include_once realpath (__DIR__.'/../enum/SchemasCompany.php');
include_once realpath (__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
include_once realpath (__DIR__.'/../enum/FaseQuery.php');
include_once 'BOImpl.php';
include_once 'PropriedadeBO.php';

class ColunaBO extends BOImpl{
	
	protected  $dao;
	private $estrutura;
	private $fase;
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter, $sequenceParameter, $fase) {
		$this->dao = new ColunaDAOImpl($dbCompany, $schemaParameter, $tableParameter);
		$this->estrutura[EstruturaQuery::SEQUENCE] = $sequenceParameter;
		$this->estrutura[EstruturaQuery::TABELA] = $tableParameter;
		$this->estrutura[EstruturaQuery::SCHEMA] = $schemaParameter;
		$this->estrutura[EstruturaQuery::COMPANY] = $dbCompany;
		$this->fase = $fase;
	}

	public function dropColumn(){
		$tabela = $this->estrutura [EstruturaQuery::TABELA];
		$colunas = $this->diff_homolog_devQuery();
		$string = "";
		if (! empty ( $colunas )) {
			foreach ( $colunas as $coluna ) {
				$string .= "ALTER TABLE $tabela DROP COLUMN $coluna;\n";
			}
		}
		return $string;
	}
	
	public function createColumn() {
		$sequence = $this->estrutura [EstruturaQuery::SEQUENCE];
		$tabela = $this->estrutura [EstruturaQuery::TABELA];
		$schema = $this->estrutura [EstruturaQuery::SCHEMA];
		$empresa = $this->estrutura [EstruturaQuery::COMPANY];
		$fase = $this->fase;
		$colunas = $this->diff_dev_homologQuery ();
		$string = "";
		if (! empty ( $colunas )) {
			foreach ( $colunas as $coluna ) {
				$propriedade = new PropriedadeBO ( $empresa, $schema, $tabela, $coluna, $sequence, $fase );
				$string .= "\t" . $coluna . " " . $propriedade->constructProperty () . ",\n";
			}
		}
		return $string;
	}
	
	
}