<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
include_once realpath ( __DIR__ . '/../ITriggerDAO.php' );
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/SchemaType.php' );

class TriggerDAOImpl extends DAOImpl implements ITriggerDAO {
	
	
	
	public function __construct($dbCompany) {
		parent::__construct ( $dbCompany );
		$this->setQuery ();
		
	}
	
	public function setQuery() {
		// Retorna dados das TRIGGER
		$query = "	select distinct ";
		$query .= " trigger_name ,  ";
		$query .= " action_timing ,  ";
		$query .= " event_manipulation ,  ";
		$query .= " action_orientation as trigger_scope,  ";
		$query .= " action_statement,  ";
		$query .= " event_object_table as table_name,  ";
		$query .= " event_object_schema as schema_name ";
		$query .= " from information_schema.triggers  ";
		//$query .= " where event_object_schema = '{$schemaParameter}'  ";
		//$query .= " and event_object_table = '{$tableParameter}'  ";
		
		$this->query = $query;
	}
	public function retorna($schemaType) {
		$arrayResult = array ();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['schema_name'].".".$array [$i] ['table_name']]['trigger'][$array [$i] ['trigger_name']] ['action_timing'] = $array [$i] ['action_timing'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['schema_name'].".".$array [$i] ['table_name']]['trigger'][$array [$i] ['trigger_name']] ['event_manipulation'] [] = $array [$i] ['event_manipulation'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['schema_name'].".".$array [$i] ['table_name']]['trigger'][$array [$i] ['trigger_name']] ['trigger_scope'] = $array [$i] ['trigger_scope'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['tabela'][$array [$i] ['schema_name'].".".$array [$i] ['table_name']]['trigger'][$array [$i] ['trigger_name']] ['action_statement'] = $array [$i] ['action_statement'];
		}
		return $arrayResult;
	}
}
