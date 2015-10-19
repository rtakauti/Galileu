<?php
include_once realpath(__DIR__.'/../DAOImpl.php');
class SequenceDAOImpl extends DAOImpl {
	
	
	
	public function __construct($dbCompany) {
		parent::__construct ( $dbCompany );
		$this->setQuery();
	}
	
	
	/**
	 *
	 * @param string $query
	 *        	- Recebe uma query opcional 
	 *        	
	 */
	public function setQuery($query = null) {
		if (isset ( $query )) {
			$this->query = $query;
		} else {
			// Retorna os nomes das SEQUENCE
			$query = "select ";
			$query .= " relname ";
			$query .= " from pg_class ";
			$query .= " where relkind = 'S' ";
			$query .= " and relnamespace in ( ";
			$query .= "		select  ";
			$query .= " 	oid ";
			$query .= " 	from pg_namespace ";
			$query .= " 	where nspname not like 'pg_%' ";
			$query .= " 	and nspname != 'information_schema') ";
			
			$this->query = $query;
		}
	}
}