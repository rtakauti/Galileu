<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
class FuncaoDAOImpl extends DAOImpl  {
	
	
	public function __construct($dbCompany, $schemaParameter ) {
		parent::__construct ( $dbCompany );
		$this->setQuery ($schemaParameter);
	}
	
	public function setQuery($schemaParameter) {
		// Retorna as FUNCOES dos schemas
		$query = "  select distinct ";
		$query .= " p.proname as function_name, ";
		$query .= " pg_catalog.pg_get_function_result(p.oid) as return, ";
		$query .= " pg_catalog.pg_get_function_arguments(p.oid) as parameter, ";
		$query .= " pg_catalog.pg_get_functiondef(p.oid) as create, ";
		$query .= " p.prosrc as body ";
		$query .= " from pg_catalog.pg_proc p ";
		$query .= " left join pg_catalog.pg_namespace n on n.oid = p.pronamespace ";
		$query .= " where pg_catalog.pg_function_is_visible(p.oid) ";
		$query .= " and pg_catalog.pg_function_is_visible(p.oid) ";
		$query .= " and n.nspname = '{$schemaParameter}' ";
		$query .= " order by 2 ";
		$this->query = $query;
		
	}
	
	
	public function funcao($schemaType) {
		$arrayResult = array ();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult [$array [$i] ['function_name']] ['return'] = $array [$i] ['return'];
			$arrayResult [$array [$i] ['function_name']] ['parameter'] = $array [$i] ['parameter'];
			$arrayResult [$array [$i] ['function_name']] ['body'] = $array [$i] ['body'];
			$arrayResult [$array [$i] ['function_name']] ['create'] = $array [$i] ['create'];
		}
		return $arrayResult;
	}
	
}
