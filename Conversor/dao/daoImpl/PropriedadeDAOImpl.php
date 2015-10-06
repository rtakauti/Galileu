<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );

class PropriedadeDAOImpl extends DAOImpl {
	
	public function __construct($schemaCompany, $schemaParameter, $tableParameter, $columnParameter, $fase) {
		parent::__construct ( $schemaCompany );
		$this->setQuery ( $schemaParameter, $tableParameter, $columnParameter, $fase );
	}
	
	public function setQuery($schemaParameter, $tableParameter, $columnParameter, $fase) {
		switch ($fase) {
			case FaseQuery::CREATE :
				// Retorna CREATE as PROPRIEDADES das Colunas das tabelas do schema
				$query = "select distinct ";
				$query .= " udt_name , ";
				$query .= " data_type , ";
				$query .= " numeric_precision	, ";
				$query .= " numeric_scale	, ";
				$query .= " character_maximum_length	, ";
				$query .= " datetime_precision	, ";
				$query .= " is_nullable	, ";
				$query .= " column_default	, ";
				$query .= " interval_type	 ";
				$query .= " from information_schema.columns ";
				$query .= " where table_schema = '{$schemaParameter}' ";
				$query .= " and table_name = '{$tableParameter}' ";
				$query .= " and column_name = '{$columnParameter}' ";
				$this->query = $query;
				break;
			case FaseQuery::ADD :
				// Retorna CREATE as PROPRIEDADES das Colunas das tabelas do schema
				$query = "select distinct ";
				$query .= " udt_name	, ";
				$query .= " numeric_precision	, ";
				$query .= " numeric_scale	, ";
				$query .= " character_maximum_length	, ";
				$query .= " is_nullable	, ";
				$query .= " data_type	, ";
				$query .= " column_default	 ";
				$query .= " from information_schema.columns ";
				$query .= " where table_schema = '{$schemaParameter}' ";
				$query .= " and table_name = '{$tableParameter}' ";
				$query .= " and column_name = '{$columnParameter}' ";
				$query .= " order by 1,2	 ";
				$this->query = $query;
				break;
			case FaseQuery::ALTER :
				// Retorna CREATE as PROPRIEDADES das Colunas das tabelas do schema
				$query = "select distinct ";
				$query .= " udt_name	, ";
				$query .= " numeric_precision	, ";
				$query .= " numeric_scale	, ";
				$query .= " character_maximum_length	, ";
				$query .= " is_nullable	, ";
				$query .= " data_type	, ";
				$query .= " column_default	 ";
				$query .= " from information_schema.columns ";
				$query .= " where table_schema = '{$schemaParameter}' ";
				$query .= " and table_name = '{$tableParameter}' ";
				$query .= " and column_name = '{$columnParameter}' ";
				$query .= " order by 1,2	 ";
				$this->query = $query;
				break;
			
			default :
				;
				break;
		}
	}
}
