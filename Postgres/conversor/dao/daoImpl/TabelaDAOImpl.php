<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
class TableDAOImpl extends DAOImpl  {
	
	
	public function __construct($dbCompany, $queryParameter) {
		parent::__construct ( $dbCompany );
		$this->setQuery ( $queryParameter);
	}
	public function setQuery($queryParameter) {
		// Retorna as TABELAS das tabelas do schema
			$query = "select ";
			$query .= " table_name	, ";
			$query .= " column_name	, ";
			$query .= " column_default	, ";
			$query .= " is_nullable	, ";
			$query .= " data_type	, ";
			$query .= " character_maximum_length	, ";
			$query .= " numeric_precision	, ";
			$query .= " numeric_scale	, ";
			$query .= " udt_name	 ";
			$query .= " from information_schema.columns where table_schema = '{$queryParameter}' ";
			$query .= " order by 1,2	 ";
			$this->query = $query;
	}
	
	public function arrayHomolog(){
		return $this->estruturarArray(SchemaType::HOMOLOG);
	}
	
	public function arrayDev(){
		return $this->estruturarArray(SchemaType::DEV);
	}
	
	public  function estruturarArray($schemaType){
		$array = $this->queryAllAssoc($schemaType);
		for($i = 0; $i < count ( $array ); $i ++) {
			if (isset ( $array [$i] ['table_name'] ))
				$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['table_name'] = $array [$i] ['table_name'];
			if (isset ( $array [$i] ['column_name'] ))
				$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['column_name'] = $array [$i] ['column_name'];
			if (isset ( $array [$i] ['column_default'] ))
				$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['column_default'] = $array [$i] ['column_default'];
			if (isset ( $array [$i] ['is_nullable'] ))
				$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['is_nullable'] = $array [$i] ['is_nullable'];
			if (isset ( $array [$i] ['data_type'] ))
				$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['data_type'] = $array [$i] ['data_type'];
			if (isset ( $array [$i] ['character_maximum_length'] ))
				$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['character_maximum_length'] = $array [$i] ['character_maximum_length'];
			if (isset ( $array [$i] ['numeric_precision'] ))
				$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['numeric_precision'] = $array [$i] ['numeric_precision'];
			if (isset ( $array [$i] ['numeric_scale'] ))
				$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['numeric_scale'] = $array [$i] ['numeric_scale'];
			if (isset ( $array [$i] ['udt_name'] ))
				$arrayResult [$array [$i] ['table_name']] [$array [$i] ['column_name']] ['udt_name'] = $array [$i] ['udt_name'];
		}
		if(!empty($arrayResult)) return $arrayResult;
	}
	
	
	
	
}