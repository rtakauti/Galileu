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
		$this->dao = new ColunaDAOImpl($dbCompany, $schemaParameter, $tableParameter, $fase);
		$this->estrutura[EstruturaQuery::SEQUENCE] = $sequenceParameter;
		$this->estrutura[EstruturaQuery::TABELA] = $tableParameter;
		$this->estrutura[EstruturaQuery::SCHEMA] = $schemaParameter;
		$this->estrutura[EstruturaQuery::COMPANY] = $dbCompany;
		$this->fase = $fase;
	}

	public function dropColumn(){
		$tabela = $this->estrutura [EstruturaQuery::TABELA];
		$dev = array_keys($this->dao->propriedade(SchemaType::DEV));
		$homolog = array_keys($this->dao->propriedade(SchemaType::HOMOLOG));
		$colunas = array_diff($homolog, $dev);
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
		//$colunas = $this->diff_dev_homologQuery ();
		$dev = $this->dao->propriedade(SchemaType::DEV);
		$homolog = $this->dao->propriedade(SchemaType::HOMOLOG);
		$colunas = array_diff_assoc($dev, $homolog);
		$string = "";
		if (! empty ( $colunas )) {
			foreach ( $colunas as $nameColuna => $coluna ) {
				$propriedade = new PropriedadeBO ( $empresa, $schema, $tabela, $nameColuna, $sequence, $fase, $coluna );
				$string .= "\t" . $nameColuna . " " . $propriedade->constructProperty () . ",\n";
			}
		}
		return $string;
	}
	
	
}