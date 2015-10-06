<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
class TableDAOImpl extends DAOImpl  {
	
	
	public function __construct($schemaCompany, $schemaParameter) {
		parent::__construct ( $schemaCompany );
		$this->setQuery ( $schemaParameter);
	}
	public function setQuery($schemaParameter) {
		// Retorna as TABELAS das tabelas do schema
			$query = "select distinct ";
			$query .= " cl.relname as table_name ";
			$query .= " from pg_namespace nm, pg_class cl ";
			$query .= " where nm.nspname = '{$schemaParameter}' ";
			$query .= " and cl.relkind ='r' ";
			$query .= " and cl.relnamespace = nm.oid ";
			$query .= " and cl.oid not in (select inhrelid from pg_inherits  ) ";
			$query .= " order by 1	 ";
			$this->query = $query;
	}
	
}