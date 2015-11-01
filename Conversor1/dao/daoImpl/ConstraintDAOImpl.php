<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
include_once realpath ( __DIR__ . '/../IDAOImpl.php' );
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/SchemaType.php' );


class ConstraintDAOImpl extends DAOImpl implements IDAOImpl{
	
	
	public function __construct() {
		parent::__construct (  );
		$this->setQuery ( );
	}
	
	public function setQuery() {
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
		$query .= " tc.table_name as table_name , ";
		$query .= " tc.table_schema as schema_name , ";
		$query .= " case "; 
		$query .= "  when tc.constraint_type = 'PRIMARY KEY' then 1";
		$query .= "  when tc.constraint_type = 'UNIQUE' then 2";
		$query .= "  when tc.constraint_type = 'FOREIGN KEY' then 3";
		$query .= "  when tc.constraint_type = 'CHECK' then 4";
		$query .= " end as ordem ";
		$query .= " from information_schema.table_constraints tc ";
		$query .= " inner join pg_class cl ";
		$query .= " on tc.table_name = cl.relname ";
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
		$query .= " and cl.oid not in (select inhrelid from pg_inherits  ) ";
		$query .= " and cl.relkind ='r' ";
		$query .= " order by ordem";
		$this->query = $query;
	}
	
	
	public function retorna($schemaType) {
		$arrayResult = array ();
		$arrayResult ['constraints'] = array();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult ['constraints'][$array [$i] ['schema_name'].".".$array [$i] ['table_name'].".".$array [$i] ['constraint_name']] = $array [$i] ['schema_name'].".".$array [$i] ['table_name'].".".$array [$i] ['constraint_name'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['table_name']] ['constraint'][$array [$i] ['constraint_name']] ['constraint_type'] = $array [$i] ['constraint_type'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['table_name']] ['constraint'][$array [$i] ['constraint_name']] ['column_name'] [] = $array [$i] ['column_name'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['table_name']] ['constraint'][$array [$i] ['constraint_name']] ['foreign_table'] = $array [$i] ['foreign_table'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['table_name']] ['constraint'][$array [$i] ['constraint_name']] ['foreign_column'] = $array [$i] ['foreign_column'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['table_name']] ['constraint'][$array [$i] ['constraint_name']] ['match_option'] = $array [$i] ['match_option'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['table_name']] ['constraint'][$array [$i] ['constraint_name']] ['update_rule'] = $array [$i] ['update_rule'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['table_name']] ['constraint'][$array [$i] ['constraint_name']] ['delete_rule'] = $array [$i] ['delete_rule'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['table_name']] ['constraint'][$array [$i] ['constraint_name']] ['consrc'] = $array [$i] ['consrc'];
		}
		return $arrayResult;
	}
}
