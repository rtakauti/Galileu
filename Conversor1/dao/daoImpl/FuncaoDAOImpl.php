<?php
include_once realpath ( __DIR__ . '/../DAOImpl.php' );
include_once realpath ( __DIR__ . '/../IDAOImpl.php' );


class FuncaoDAOImpl extends DAOImpl implements IDAOImpl {
	
	
	public function __construct( ) {
		parent::__construct (  );
		$this->setQuery ();
	}
	
	public function setQuery() {
		// Retorna as FUNCOES dos schemas
		$query = "  select distinct ";
		$query .= " pp.proname as function_name, ";
		$query .= " pn.nspname as schema_name, ";
		$query .= " pg_get_function_result(pp.oid) as return, ";
		$query .= " pg_get_function_arguments(pp.oid) as parameter, ";
		//$query .= " pp.prosrc as body, ";
		$query .= " pg_get_functiondef(pp.oid) as create ";
		$query .= " from pg_proc pp ";
		$query .= " inner join pg_namespace pn on (pp.pronamespace = pn.oid) ";
		$query .= " inner join pg_language pl on (pp.prolang = pl.oid) ";
		$query .= " where pl.lanname NOT IN ('c','internal') ";
		$query .= " and pn.nspname NOT LIKE 'pg_%' ";
		$query .= " and pn.nspname <> 'information_schema' ";
		$query .= " and (pp.proname like 'f_%' or pp.proname like 'tf_%') ";
		$query .= " order by 2 ";
		$this->query = $query;
	}
	
	
	public function retorna($schemaType) {
		$arrayResult = array ();
		$arrayResult ['funcoes'] = array();
		$array = $this->queryAllAssoc ( $schemaType );
		for($i = 0; $i < count ( $array ); $i ++) {
			$arrayResult ['funcoes'][$array [$i] ['schema_name'].".".$array [$i] ['function_name']."(".$array [$i] ['parameter'].")"] = $array [$i] ['schema_name'].".".$array [$i] ['function_name']."(".$array [$i] ['parameter'].")";
			$arrayResult ['schema'][$array [$i] ['schema_name']]['funcao'][$array [$i] ['function_name']."(".$array [$i] ['parameter'].")"] ['create'] = utf8_decode($array [$i] ['create']);
			$arrayResult ['schema'][$array [$i] ['schema_name']]['funcao'][$array [$i] ['function_name']."(".$array [$i] ['parameter'].")"] ['return'] = $array [$i] ['return'];
			$arrayResult ['schema'][$array [$i] ['schema_name']]['funcao'][$array [$i] ['function_name']."(".$array [$i] ['parameter'].")"] ['parameter'] = $array [$i] ['parameter'];
		}
		sort($arrayResult ['funcoes']);
		return $arrayResult;
	}
	
}
