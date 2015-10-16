<?php
include_once realpath(__DIR__.'/../DAOImpl.php');

class SequenceDAOImpl extends DAOImpl {
	
	public function __construct($dbCompany) {
		parent::__construct ( $dbCompany );
		$this->setQuery();
	}
	
	
	public function setQuery() {
			// Retorna os nomes das SEQUENCE
			$query =  " select distinct ";
			$query .= " nsp.nspname ||'.'|| cls.relname as sequence ";
			$query .= " from pg_class cls ";
			$query .= " join pg_namespace nsp ";
			$query .= " on nsp.oid = cls.relnamespace ";
			$query .= " where nsp.nspname not in ('information_schema', 'pg_catalog') ";
			$query .= "	and nsp.nspname not like 'pg_toast%' ";
			$query .= " and cls.relkind = 'S' ";
			$query .= " order by 1 ";
			
			$this->query = $query;
	}
}