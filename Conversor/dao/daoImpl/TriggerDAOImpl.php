<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/SchemaType.php' );

class TriggerDAOImpl extends DAOImpl {
	
	
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter) {
		parent::__construct ( $dbCompany );
		$this->setQuery ( $schemaParameter, $tableParameter );
		
	}
	
	public function setQuery($schemaParameter, $tableParameter) {
		// Retorna dados das TRIGGER
		$query = "	select distinct ";
		$query .= " trigger_name ,  ";
		$query .= " action_timing ,  ";
		$query .= " event_manipulation ,  ";
		$query .= " action_orientation as trigger_scope,  ";
		$query .= " action_statement  ";
		$query .= " from information_schema.triggers  ";
		$query .= " where event_object_schema = '{$schemaParameter}'  ";
		$query .= " and event_object_table = '{$tableParameter}'  ";
		
		$this->query = $query;
	}
	public function trigger($schemaType) {
		$arrayResult = array ();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult [$array [$i] ['trigger_name']] ['action_timing'] = $array [$i] ['action_timing'];
			$arrayResult [$array [$i] ['trigger_name']] ['event_manipulation'] [] = $array [$i] ['event_manipulation'];
			$arrayResult [$array [$i] ['trigger_name']] ['trigger_scope'] = $array [$i] ['trigger_scope'];
			$arrayResult [$array [$i] ['trigger_name']] ['action_statement'] = $array [$i] ['action_statement'];
		}
		return $arrayResult;
	}
}
