<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
class ConstraintDAOImpl extends DAOImpl  {
	
	public $arrayHomolog;
	public $arrayDev;
	
	public function __construct($dbCompany, $queryParameter) {
		parent::__construct ( $dbCompany );
		$this->setQuery ( $queryParameter );
		$this->init();
	}
	
	public function setQuery($queryParameter) {
		// Retorna dados das CONSTRAINT
		$query = "	select distinct ";
		$query .= " tc.table_name, ";
		$query .= " tc.constraint_name,  ";
		$query .= " tc.constraint_type,  ";
		$query .= " kcu.column_name,  ";
		$query .= " rc.match_option,  ";
		$query .= " rc.update_rule,  ";
		$query .= " rc.delete_rule,  ";
		$query .= " c.consrc, ";
		$query .= " ccu.table_name as foreign_table_name, ";
		$query .= " ccu.column_name as foreign_column_name ";
		$query .= " from information_schema.table_constraints tc ";
		$query .= " left join information_schema.key_column_usage kcu ";
		$query .= " on tc.constraint_catalog = kcu.constraint_catalog ";
		$query .= " and tc.constraint_schema = kcu.constraint_schema ";
		$query .= " and tc.constraint_name = kcu.constraint_name ";
		$query .= " left join information_schema.referential_constraints rc ";
		$query .= " on tc.constraint_catalog = rc.constraint_catalog ";
		$query .= " and tc.constraint_schema = rc.constraint_schema ";
		$query .= " and tc.constraint_name = rc.constraint_name ";
		$query .= " left join information_schema.constraint_column_usage ccu ";
		$query .= " on rc.unique_constraint_catalog = ccu.constraint_catalog ";
		$query .= " and rc.unique_constraint_schema = ccu.constraint_schema ";
		$query .= " and rc.unique_constraint_name = ccu.constraint_name ";
		$query .= " left join pg_constraint c ";
		$query .= " on tc.constraint_name = c.conname ";
		$query .= " where upper(tc.constraint_name) not like '%NOT_NULL%'";
		$query .= " and tc.table_name = '{$queryParameter}'";
		$this->query = $query;
	}
	
	
	public function init() {
		$homolog = $this->queryAllAssoc ( SchemaType::HOMOLOG );
		$dev = $this->queryAllAssoc ( SchemaType::DEV );
	
		for($i = 0; $i < count ( $dev ); $i ++) {
			if (isset ( $dev [$i] ['constraint_name'] ))
				$devResult [$dev [$i] ['constraint_name']] ['constraint_name'] = $dev [$i] ['constraint_name'];
			
			if (isset ( $dev [$i] ['table_name'] ))
				$devResult [$dev [$i] ['constraint_name']] ['table_name'] = $dev [$i] ['table_name'];
			
			if (isset ( $dev [$i] ['constraint_type'] ))
				$devResult [$dev [$i] ['constraint_name']] ['constraint_type'] = $dev [$i] ['constraint_type'];
			if (isset ( $dev [$i] ['column_name'] ))
				$devResult [$dev [$i] ['constraint_name']] ['column_name'] [] = $dev [$i] ['column_name'];
			if (isset ( $dev [$i] ['match_option'] ))
				$devResult [$dev [$i] ['constraint_name']] ['match_option'] = $dev [$i] ['match_option'];
			if (isset ( $dev [$i] ['update_rule'] ))
				$devResult [$dev [$i] ['constraint_name']] ['update_rule'] = $dev [$i] ['update_rule'];
			if (isset ( $dev [$i] ['delete_rule'] ))
				$devResult [$dev [$i] ['constraint_name']] ['delete_rule'] = $dev [$i] ['delete_rule'];
			if (isset ( $dev [$i] ['consrc'] ))
				$devResult [$dev [$i] ['constraint_name']] ['consrc'] = $dev [$i] ['consrc'];
			if (isset ( $dev [$i] ['foreign_table_name'] ))
				$devResult [$dev [$i] ['constraint_name']] ['foreign_table_name'] = $dev [$i] ['foreign_table_name'];
			if (isset ( $dev [$i] ['foreign_column_name'] ))
				$devResult [$dev [$i] ['constraint_name']] ['foreign_column_name'] = $dev [$i] ['foreign_column_name'];
		}
	
		for($i = 0; $i < count ( $homolog ); $i ++) {
			if (isset ( $homolog [$i] ['constraint_name'] ))
				$homologResult [$homolog [$i] ['constraint_name']] ['constraint_name'] = $homolog [$i] ['constraint_name'];
			
			if (isset ( $homolog [$i] ['table_name'] ))
				$homologResult [$homolog [$i] ['constraint_name']] ['table_name'] = $homolog [$i] ['table_name'];
			
			if (isset ( $homolog [$i] ['constraint_name'] ))
				$homologResult [$homolog [$i] ['constraint_name']] ['constraint_name'] = $homolog [$i] ['constraint_name'];
			if (isset ( $homolog [$i] ['constraint_type'] ))
				$homologResult [$homolog [$i] ['constraint_name']] ['constraint_type'] = $homolog [$i] ['constraint_type'];
			if (isset ( $homolog [$i] ['column_name'] ))
				$homologResult [$homolog [$i] ['constraint_name']] ['column_name'] [] = $homolog [$i] ['column_name'];
			if (isset ( $homolog [$i] ['match_option'] ))
				$homologResult [$homolog [$i] ['constraint_name']] ['match_option'] = $homolog [$i] ['match_option'];
			if (isset ( $homolog [$i] ['update_rule'] ))
				$homologResult [$homolog [$i] ['constraint_name']] ['update_rule'] = $homolog [$i] ['update_rule'];
			if (isset ( $homolog [$i] ['delete_rule'] ))
				$homologResult [$homolog [$i] ['constraint_name']] ['delete_rule'] = $homolog [$i] ['delete_rule'];
			if (isset ( $homolog [$i] ['consrc'] ))
				$homologResult [$homolog [$i] ['constraint_name']] ['consrc'] = $homolog [$i] ['consrc'];
			if (isset ( $homolog [$i] ['foreign_table_name'] ))
				$homologResult [$homolog [$i] ['constraint_name']] ['foreign_table_name'] = $homolog [$i] ['foreign_table_name'];
			if (isset ( $homolog [$i] ['foreign_column_name'] ))
				$homologResult [$homolog [$i] ['constraint_name']] ['foreign_column_name'] = $homolog [$i] ['foreign_column_name'];
		}
	
		unset ( $dev );
		unset ( $homolog );
		if (isset ( $homologResult ))
			$this->arrayHomolog = $homologResult;
		if (isset ( $devResult ))
			$this->arrayDev = $devResult;
	}
	
}