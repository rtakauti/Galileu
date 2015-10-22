<?php
include_once realpath(__DIR__.'/../DAOImpl.php');
include_once realpath(__DIR__.'/../IIndiceDAO.php');


class IndiceDAOImpl extends DAOImpl implements IIndiceDAO{
	
	
	public function __construct($dbCompany) {
		parent::__construct ( $dbCompany );
		$this->setQuery();
	}
	
	
	public function setQuery() {
			// Retorna os nomes dos INDICES

			$query = "  select distinct ";
			$query .= " i.relname as index_name, ";
			$query .= " a.attname as column_name, ";
			$query .= " t.relname as table_name, ";
			$query .= " n.nspname as schema_name ";
			$query .= " from ";
			$query .= " pg_class t, ";
			$query .= " pg_class i, ";
			$query .= " pg_index ix, ";
			$query .= " pg_attribute a, ";
			$query .= " pg_namespace n ";
			$query .= " where n.nspname not in ('pg_catalog') ";
			$query .= " and t.oid = ix.indrelid ";
			$query .= " and i.oid = ix.indexrelid ";
			$query .= " and a.attrelid = t.oid ";
			$query .= " and a.attnum = ANY(ix.indkey) ";
			$query .= " and n.oid = t.relnamespace ";
			$query .= " and t.relkind = 'r' ";
			$query .= " and indisunique != 't' ";
			$query .= " and indisprimary != 't' ";
			$this->query = $query;
	}
	
	
	public function retorna($schemaType) {
		$arrayResult = array ();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult ['schema'][$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']]['indice'] [$array [$i] ['index_name']] [] = $array [$i] ['column_name'];
			//$arrayResult['indices'][] = $array [$i] ['schema_name'].".".$array [$i] ['index_name'];
		}
		return $arrayResult;
	}
	
	
}