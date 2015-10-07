<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
class ColunaDAOImpl extends DAOImpl  {
	
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter) {
		parent::__construct ( $dbCompany );
		$this->setQuery ($schemaParameter, $tableParameter);
	}
	
	public function setQuery($schemaParameter, $tableParameter) {
		// Retorna as COLUNAS das tabelas do schema
		$query = "  select distinct ";
		$query .= " column_name	 ";
		$query .= " from information_schema.columns ";
		$query .= " where table_schema = '{$schemaParameter}' ";
		$query .= " and table_name = '{$tableParameter}' ";
		$query .= " order by 1	";
		$this->query = $query;
	}
	
	
}
