<?php
include_once realpath(__DIR__.'/../dao/daoImpl/IndiceDAOImpl.php');
include_once realpath(__DIR__.'/../enum/SchemasCompany.php');
include_once realpath(__DIR__.'/../enum/SchemaType.php');
include_once realpath (__DIR__.'/../enum/EstruturaQuery.php');
include_once 'BOImpl.php';

class IndiceBO extends BOImpl{
	
protected  $dao;
private $estrutura;
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter){
		$this->dao = new IndiceDAOImpl($dbCompany, $schemaParameter, $tableParameter);
		
		$this->estrutura[EstruturaQuery::COMPANY] = $dbCompany;
		$this->estrutura[EstruturaQuery::SCHEMA] = $schemaParameter;
		$this->estrutura[EstruturaQuery::TABELA] = $tableParameter;
	}
	public function dropIndice() {
		$tabela = $this->estrutura[EstruturaQuery::TABELA];
		$homolog = array_keys($this->dao->index(SchemaType::HOMOLOG));
		$dev = array_keys($this->dao->index(SchemaType::DEV));
		$indices = array_diff($homolog, $dev);
		$string = "";
		if (! empty ( $indices )) {
			$string = "\n\n--------------------  DROP DE INDICES $tabela -------------------- ";
			foreach ( $indices as $indice ) {
				$string .= "\nDROP INDEX $indice;";
			}
		}
		return $string;
	}
	
	public function createIndex() {
		$indices = $this->dao->index(SchemaType::DEV);
		$tabela = $this->estrutura[EstruturaQuery::TABELA];
		$string = "";
		if (! empty ( $indices )) {
			$string = "\n\n\n--------------------  CREATE DE INDICES $tabela -------------------- ";
			foreach ( $indices as $key => $indice ) {
				$string .= "\n\nCREATE INDEX $key";
				$string .= "\n\tON $tabela";
				$string .= "\n\tUSING btree";
				$string .= "\n\t(".implode(", ", $indice).");";
			}
		}
		return $string;
	}
	
	public function retornahomolog(){
		return $this->dao->index(SchemaType::DEV);
		return array_diff( $this->arrayHomolog(),$this->arrayDev());
	}
	
}