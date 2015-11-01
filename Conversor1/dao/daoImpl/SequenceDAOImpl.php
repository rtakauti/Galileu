<?php
include_once realpath(__DIR__.'/../DAOImpl.php');
include_once realpath(__DIR__.'/../IDAOImpl.php');


class SequenceDAOImpl extends DAOImpl implements IDAOImpl{
	
	public function __construct() {
		parent::__construct (  );
		$this->setQuery();
	}
	
	
	public function setQuery() {
			// Retorna os nomes das SEQUENCE
			$query =  " select distinct ";
			$query .= " nsp.nspname as schema_name, ";
			$query .= " cls.relname as sequence_name ";
			$query .= " from pg_class cls ";
			$query .= " join pg_namespace nsp ";
			$query .= " on nsp.oid = cls.relnamespace ";
			$query .= " where nsp.nspname not in ('information_schema', 'pg_catalog') ";
			$query .= "	and nsp.nspname not like 'pg_toast%' ";
			$query .= " and cls.relkind = 'S' ";
			$query .= " order by 1 ";
			$this->query = $query;
	}

	public function retorna($schemaType){
		$arrayResult = array ();
		$arrayResult ['sequences'] = array();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult ['sequences'][$array [$i] ['schema_name'].".".$array [$i] ['sequence_name']] = $array [$i] ['schema_name'].".".$array [$i] ['sequence_name'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['sequence'][$array [$i] ['sequence_name']] = $array [$i] ['sequence_name'];
		}
		return $arrayResult;
		
	}
	
}