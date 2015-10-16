<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
class ColunaDAOImpl extends DAOImpl  {
	
	private $fase;
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter, $fase) {
		parent::__construct ( $dbCompany );
		$this->setQuery ($schemaParameter, $tableParameter);
		$this->fase = $fase;
	}
	
	public function setQuery($schemaParameter, $tableParameter) {
		// Retorna as COLUNAS das tabelas do schema
		$query = "  select distinct ";
		$query .= " column_name , ";
		$query .= " udt_name , ";
		$query .= " data_type , ";
		$query .= " numeric_precision	, ";
		$query .= " numeric_scale	, ";
		$query .= " character_maximum_length	, ";
		$query .= " datetime_precision	, ";
		$query .= " interval_type	, ";
		$query .= " is_nullable	, ";
		$query .= " column_default	 ";
		$query .= " from information_schema.columns ";
		$query .= " where table_schema = '{$schemaParameter}' ";
		$query .= " and table_name = '{$tableParameter}' ";
		$this->query = $query;
	}
	
	
	public function propriedade($schemaType) {
		$arrayResult = array ();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult [$array [$i] ['column_name']] ['udt_name'] = $array [$i] ['udt_name'];
			$arrayResult [$array [$i] ['column_name']] ['data_type'] = $array [$i] ['data_type'];
			$arrayResult [$array [$i] ['column_name']] ['numeric_precision'] = $array [$i] ['numeric_precision'];
			$arrayResult [$array [$i] ['column_name']] ['numeric_scale'] = $array [$i] ['numeric_scale'];
			$arrayResult [$array [$i] ['column_name']] ['character_maximum_length'] = $array [$i] ['character_maximum_length'];
			$arrayResult [$array [$i] ['column_name']] ['datetime_precision'] = $array [$i] ['datetime_precision'];
			$arrayResult [$array [$i] ['column_name']] ['interval_type'] = $array [$i] ['interval_type'];
			$arrayResult [$array [$i] ['column_name']] ['is_nullable'] = $array [$i] ['is_nullable'];
			$arrayResult [$array [$i] ['column_name']] ['column_default'] = $array [$i] ['column_default'];
		}
		return $arrayResult;
	}
	
}
