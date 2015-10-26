<?php
include_once realpath(__DIR__.'/../DAOImpl.php');
include_once realpath(__DIR__.'/../IDAOImpl.php');
include_once 'SequenceDAOImpl.php';
include_once 'FuncaoDAOImpl.php';
include_once 'IndiceDAOImpl.php';


class SchemaDAOImpl extends DAOImpl implements IDAOImpl{
	
	
	public function __construct() {
		parent::__construct (  );
		$this->setQuery ();
	}
	
	public function setQuery() {
		// Retorna os SCHEMAS do schema selecionado
		$query =  " select distinct ";
		$query .= " i.table_schema 					as schema_name, ";
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
		$query .= " where nm.nspname != 'information_schema' ";
		$query .= " and nm.nspname not like 'pg_%' ";
		$query .= " and cl.relkind ='r' ";
		$query .= " and cl.relname = i.table_name ";
		$query .= " and i.table_schema = nm.nspname ";
		$query .= " and cl.relnamespace = nm.oid ";
		$query .= " and cl.oid not in (select inhrelid from pg_inherits  ) ";
		$query .= " order by 1	 ";
		$this->query = $query;
	}
	

	public function retorna($schemaType) {
		return $this->queryAllAssoc ( $schemaType );
	}
	
}