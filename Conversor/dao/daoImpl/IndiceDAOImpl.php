<?php
include_once realpath(__DIR__.'/../DAOImpl.php');

class IndiceDAOImpl extends DAOImpl {
	
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter) {
		parent::__construct ( $dbCompany );
		$this->setQuery($schemaParameter, $tableParameter);
	}
	
	
	public function setQuery($schemaParameter, $tableParameter) {
			// Retorna os nomes dos INDICES

			$query = "  select distinct ";
			$query .= " i.relname as index_name, ";
			$query .= " a.attname as column_name ";
			$query .= " from ";
			$query .= " pg_class t, ";
			$query .= " pg_class i, ";
			$query .= " pg_index ix, ";
			$query .= " pg_attribute a, ";
			$query .= " pg_namespace n ";
			$query .= " where t.oid = ix.indrelid ";
			$query .= " and i.oid = ix.indexrelid ";
			$query .= " and a.attrelid = t.oid ";
			$query .= " and a.attnum = ANY(ix.indkey) ";
			$query .= " and n.oid = t.relnamespace ";
			$query .= " and t.relkind = 'r' ";
			$query .= " and indisunique != 't' ";
			$query .= " and indisprimary != 't' ";
			$query .= " and n.nspname = '{$schemaParameter}' ";
			$query .= " and t.relname = '{$tableParameter}' ";
			$query .= " order by 1,2 ";
			
			$this->query = $query;
	}
	
	
	public function index($schemaType) {
		$arrayResult = array ();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult [$array [$i] ['index_name']] [] = $array [$i] ['column_name'];
		}
		return $arrayResult;
	}
	
	
}