<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
include_once realpath ( __DIR__ . '/../IDAOImpl.php' );
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/SchemaType.php' );

class TriggerDAOImpl extends DAOImpl implements IDAOImpl {
	
	public function __construct() {
		parent::__construct (  );
		$this->setQuery ();
	}
	
	public function setQuery() {
		// Retorna dados das TRIGGER
		$query = "	select distinct ";
		$query .= " tr.trigger_name ,  ";
		$query .= " tr.action_timing ,  ";
		$query .= " tr.event_manipulation ,  ";
		$query .= " tr.action_orientation as trigger_scope,  ";
		$query .= " tr.action_statement,  ";
		$query .= " tr.event_object_table as table_name,  ";
		$query .= " tr.event_object_schema as schema_name ";
		$query .= " from information_schema.triggers tr, ";
		$query .= " pg_class cl  ";
		$query .= " where tr.event_object_table = cl.relname";
		$query .= " and cl.relkind ='r' ";
		$query .= " and cl.oid not in (select inhrelid from pg_inherits  ) ";
		$this->query = $query;
	}
	
	public function retorna($schemaType) {
		$arrayResult = array ();
		$arrayResult ['triggers'] = array();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult ['triggers'][$array [$i] ['schema_name'].".".$array [$i] ['table_name'].".".$array [$i] ['trigger_name']] = $array [$i] ['schema_name'].".".$array [$i] ['table_name'].".".$array [$i] ['trigger_name'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['trigger'] [$array [$i] ['trigger_name']] ['action_timing'] = $array [$i] ['action_timing'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['trigger'] [$array [$i] ['trigger_name']] ['event_manipulation'] [$array [$i] ['event_manipulation']] = $array [$i] ['event_manipulation'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['trigger'] [$array [$i] ['trigger_name']] ['trigger_scope'] = $array [$i] ['trigger_scope'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['trigger'] [$array [$i] ['trigger_name']] ['action_statement'] = $array [$i] ['action_statement'];
		}
		return $arrayResult;
	}
}
