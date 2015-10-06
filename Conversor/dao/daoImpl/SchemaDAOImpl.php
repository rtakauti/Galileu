<?php
include_once realpath(__DIR__.'/../DAOImpl.php');
class SchemaDAOImpl extends DAOImpl {
	public function __construct($schemaCompany) {
		parent::__construct ( $schemaCompany );
		$this->setQuery ();
	}
	
	public function setQuery() {
		// Retorna as TABELA do schema selecionado
		$query = "select distinct ";
		$query .= " table_schema ";
		$query .= " from information_schema.columns ";
		$query .= " where table_schema not in ('information_schema', 'pg_catalog') ";
		$query .= " order by 1 ";
		
		$this->query = $query;
	}
}