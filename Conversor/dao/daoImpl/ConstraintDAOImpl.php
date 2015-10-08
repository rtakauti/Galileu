<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/SchemaType.php' );
class ConstraintDAOImpl extends DAOImpl {
	
	private $fase;
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter, $fase) {
		parent::__construct ( $dbCompany );
		$this->setQuery ( $schemaParameter, $tableParameter );
		$this->fase = $fase;
	}
	
	public function setQuery($schemaParameter, $tableParameter) {
		// Retorna dados das CONSTRAINT
		$query = "	select distinct ";
		$query .= " tc.constraint_name ,  ";
		$query .= " tc.constraint_type ,  ";
		$query .= " kcu.column_name ,  ";
		$query .= " ccu.table_name as foreign_table , ";
		$query .= " ccu.column_name as foreign_column , ";
		$query .= " rc.match_option ,  ";
		$query .= " rc.update_rule ,  ";
		$query .= " rc.delete_rule ,  ";
		$query .= " c.consrc , ";
		$query .= " case "; 
		$query .= "  when tc.constraint_type = 'PRIMARY KEY' then 1";
		$query .= "  when tc.constraint_type = 'UNIQUE' then 2";
		$query .= "  when tc.constraint_type = 'FOREIGN KEY' then 3";
		$query .= "  when tc.constraint_type = 'CHECK' then 4";
		$query .= " end as ordem ";
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
		$query .= " and tc.table_schema = '{$schemaParameter}'";
		$query .= " and tc.table_name = '{$tableParameter}'";
		$query .= " order by ordem";
		$this->query = $query;
	}
	public function restricao($schemaType) {
		$fase = $this->fase;
		$arrayResult = array ();
		$array = $this->queryAllAssoc ( $schemaType );
		switch ($fase) {
			case FaseQuery::CREATE :
				for($i = 0; $i < count ( $array ); $i ++) {
					$arrayResult [$array [$i] ['constraint_name']] ['constraint_type'] = $array [$i] ['constraint_type'];
					$arrayResult [$array [$i] ['constraint_name']] ['column_name'] [] = $array [$i] ['column_name'];
					$arrayResult [$array [$i] ['constraint_name']] ['foreign_table'] = $array [$i] ['foreign_table'];
					$arrayResult [$array [$i] ['constraint_name']] ['foreign_column'] = $array [$i] ['foreign_column'];
					$arrayResult [$array [$i] ['constraint_name']] ['match_option'] = $array [$i] ['match_option'];
					$arrayResult [$array [$i] ['constraint_name']] ['update_rule'] = $array [$i] ['update_rule'];
					$arrayResult [$array [$i] ['constraint_name']] ['delete_rule'] = $array [$i] ['delete_rule'];
					$arrayResult [$array [$i] ['constraint_name']] ['consrc'] = $array [$i] ['consrc'];
				}
				break;
			case FaseQuery::ADD :
				for($i = 0; $i < count ( $array ); $i ++) {
					$arrayResult [$array [$i] ['constraint_name']] ['constraint_type'] = $array [$i] ['constraint_type'];
					$arrayResult [$array [$i] ['constraint_name']] ['column_name'] [] = $array [$i] ['column_name'];
					$arrayResult [$array [$i] ['constraint_name']] ['foreign_table'] = $array [$i] ['foreign_table'];
					$arrayResult [$array [$i] ['constraint_name']] ['foreign_column'] = $array [$i] ['foreign_column'];
					$arrayResult [$array [$i] ['constraint_name']] ['match_option'] = $array [$i] ['match_option'];
					$arrayResult [$array [$i] ['constraint_name']] ['update_rule'] = $array [$i] ['update_rule'];
					$arrayResult [$array [$i] ['constraint_name']] ['delete_rule'] = $array [$i] ['delete_rule'];
					$arrayResult [$array [$i] ['constraint_name']] ['consrc'] = $array [$i] ['consrc'];
				}
				break;
			case FaseQuery::ALTER :
				for($i = 0; $i < count ( $array ); $i ++) {
					$arrayResult [$array [$i] ['constraint_name']] ['constraint_type'] = $array [$i] ['constraint_type'];
					$arrayResult [$array [$i] ['constraint_name']] ['column_name'] [] = $array [$i] ['column_name'];
					$arrayResult [$array [$i] ['constraint_name']] ['foreign_table'] = $array [$i] ['foreign_table'];
					$arrayResult [$array [$i] ['constraint_name']] ['foreign_column'] = $array [$i] ['foreign_column'];
					$arrayResult [$array [$i] ['constraint_name']] ['match_option'] = $array [$i] ['match_option'];
					$arrayResult [$array [$i] ['constraint_name']] ['update_rule'] = $array [$i] ['update_rule'];
					$arrayResult [$array [$i] ['constraint_name']] ['delete_rule'] = $array [$i] ['delete_rule'];
					$arrayResult [$array [$i] ['constraint_name']] ['consrc'] = $array [$i] ['consrc'];
				}
				break;
			default :
				;
				break;
		}
		return $arrayResult;
	}
}
