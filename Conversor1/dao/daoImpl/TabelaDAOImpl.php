<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
class TableDAOImpl extends DAOImpl  {
	
	
	public function __construct($dbCompany, $schemaParameter) {
		parent::__construct ( $dbCompany );
		$this->setQuery ( $schemaParameter);
	}
	public function setQuery($schemaParameter) {
		// Retorna as TABELAS das tabelas do schema
			$query =  " select distinct ";
			$query .= " i.table_name 					as table_name, ";
			$query .= " i.column_name                   as column_name ,  ";
			$query .= " i.udt_name                      as udt_name ,  ";
			$query .= " i.data_type                     as data_type ,  ";
			$query .= " i.numeric_precision	            as numeric_precision ,  ";
			$query .= " i.numeric_scale	                as numeric_scale ,  ";
			$query .= " i.character_maximum_length	    as character_maximum_length	,  ";
			$query .= " i.datetime_precision	        as datetime_precision	,  ";
			$query .= " i.interval_type	                as interval_type	,  ";
			$query .= " i.is_nullable	                as is_nullable	,  ";
			$query .= " i.column_default	            as column_default ";
			$query .= " from ";
			$query .= " pg_namespace nm , ";
			$query .= " pg_class cl , ";
			$query .= " information_schema.columns i ";
			$query .= " where nm.nspname = '{$schemaParameter}' ";
			$query .= " and cl.relkind ='r' ";
			$query .= " and cl.relname = i.table_name ";
			$query .= " and i.table_schema = nm.nspname ";
			$query .= " and cl.relnamespace = nm.oid ";
			$query .= " and cl.oid not in (select inhrelid from pg_inherits  ) ";
			$query .= " order by 1	 ";
			$this->query = $query;
	}
	
	public function tabela($schemaType) {
		$arrayResult = array ();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['udt_name'] = $array [$i] ['udt_name'];
			$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['data_type'] = $array [$i] ['data_type'];
			$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['numeric_precision'] = $array [$i] ['numeric_precision'];
			$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['numeric_scale'] = $array [$i] ['numeric_scale'];
			$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['character_maximum_length'] = $array [$i] ['character_maximum_length'];
			$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['datetime_precision'] = $array [$i] ['datetime_precision'];
			$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['interval_type'] = $array [$i] ['interval_type'];
			$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['is_nullable'] = $array [$i] ['is_nullable'];
			$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['column_default'] = $array [$i] ['column_default'];
			
		}
		return $arrayResult;
	}
	
}