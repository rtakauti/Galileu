<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
class FuncaoDAOImpl extends DAOImpl  {
	
	
	public function __construct($dbCompany ) {
		parent::__construct ( $dbCompany );
		$this->setQuery ();
	}
	
	public function setQuery() {
		// Retorna as FUNCOES dos schemas
		$query = "  select distinct ";
		$query .= " p.proname as function_name, ";
		$query .= " pg_get_function_result(p.oid) as return, ";
		$query .= " pg_get_function_arguments(p.oid) as parameter, ";
		$query .= " pg_get_functiondef(p.oid) as create, ";
		$query .= " n.nspname as schema_name ";
		//$query .= " p.prosrc as body ";
		$query .= " from pg_proc p ";
		$query .= " left join pg_namespace n on n.oid = p.pronamespace ";
		$query .= " where pg_function_is_visible(p.oid) ";
		$query .= " and pg_function_is_visible(p.oid) ";
		$query .= " and n.nspname NOT LIKE 'pg_%' ";
		$query .= " and n.nspname != 'information_schema' ";
		//$query .= " and n.nspname = '{$schemaParameter}' ";
		//$query .= " order by 2 ";
		$this->query = $query;
		
	}
	
	
	public function funcao($schemaType) {
		$arrayResult = array ();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult ['funcoes'][] = $array [$i] ['schema_name'].".".$array [$i] ['function_name']."(".$array [$i] ['parameter'].")";
			$arrayResult ['schema'][$array [$i] ['schema_name']]['funcao'][$array [$i] ['function_name']] ['create'] = $array [$i] ['create'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['funcao'][$array [$i] ['function_name']] ['return'] = $array [$i] ['return'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['funcao'][$array [$i] ['function_name']] ['parameter'] = $array [$i] ['parameter'];
			//$arrayResult [$array [$i] ['function_name']] ['body'] = $array [$i] ['body'];
			
			
			
		}
		return $arrayResult;
	}
	
}
