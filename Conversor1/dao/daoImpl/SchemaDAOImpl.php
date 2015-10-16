<?php
include_once realpath(__DIR__.'/../DAOImpl.php');
include_once 'SequenceDAOImpl.php';
include_once 'FuncaoDAOImpl.php';
include_once 'IndiceDAOImpl.php';


class SchemaDAOImpl extends DAOImpl {
	
	private $dbCompany;
	
	public function __construct($dbCompany) {
		parent::__construct ( $dbCompany );
		$this->setQuery ();
		$this->dbCompany = $dbCompany;
	}
	
	public function setQuery() {
		// Retorna os SCHEMAS do schema selecionado
		$query =  " select distinct ";
		$query .= " i.table_schema 					as schema_name, ";
		$query .= " i.table_name 					as table_name, ";
		$query .= " i.column_name                   as column_name ,  ";
		$query .= " i.udt_name                      as udt_name ,  ";
		$query .= " i.data_type                     as data_type ,  ";
		$query .= " i.numeric_precision	            as numeric_precision ,  ";
		$query .= " i.numeric_scale	                as numeric_scale ,  ";
		$query .= " i.character_maximum_length	    as character_maximum_length	,  ";
		$query .= " i.datetime_precision	        as datetime_precision	,  ";
		$query .= " i.interval_type	                as interval_type	,  ";
		$query .= " i.is_nullable	                as is_nullable	,  ";
		$query .= " i.column_default	            as column_default ";
		$query .= " from ";
		$query .= " pg_namespace nm , ";
		$query .= " pg_class cl , ";
		$query .= " information_schema.columns i ";
		$query .= " where nm.nspname != 'information_schema' ";
		$query .= " and nm.nspname not like 'pg_%' ";
		$query .= " and cl.relkind ='r' ";
		$query .= " and cl.relname = i.table_name ";
		$query .= " and i.table_schema = nm.nspname ";
		$query .= " and cl.relnamespace = nm.oid ";
		$query .= " and cl.oid not in (select inhrelid from pg_inherits  ) ";
		$query .= " order by 1	 ";
		$this->query = $query;
	}
	
	public function schema($schemaType) {
		$dbCompany = $this->dbCompany;
		$arrayResult = array ();
		$array = $this->queryAllAssoc ( $schemaType );
		$sequence = new SequenceDAOImpl ( $dbCompany );
		$arrayResult ['sequences'] = $sequence->query ( $schemaType ) ;
		
		$indice = new IndiceDAOImpl($dbCompany);
		$arrayIndice = $indice->index($schemaType);
		$arrayResult ['indices'] = @$arrayIndice['indices'];
		
		/*
		$funcao = new FuncaoDAOImpl($dbCompany);
		$arrayFuncao = $funcao->funcao($schemaType);
		$arrayResult['funcoes'] = @$arrayFuncao['funcoes'];
		*/
		$trigger = new TriggerDAOImpl($dbCompany);
		$arrayTrigger = $trigger->trigger($schemaType);
		$arrayResult['triggers'] = @$arrayTrigger['triggers'];
		
		$constraint = new ConstraintDAOImpl($dbCompany);
		$arrayConstraint = $constraint->restricao($schemaType);
		$arrayResult['constraints'] = @$arrayConstraint['constraints'];
		for($i = 0; $i < count ( $array ); $i ++) {
			
			$default = $array [$i] ['column_default'];
			$valida = "nextval('";
			if (substr ( $default, 0, strlen ( $valida ) ) == $valida) {
				$fimSequence = strpos ( $default, "':" ) - strlen ( $valida );
				$sequence = substr ( $default, strlen ( $valida ), $fimSequence );
				if (strpos ( $sequence, "." ) == 0)
					$sequence = "public." . $sequence;
				$arrayResult ['sequences'] [] = $sequence;
			}
			
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['udt_name'] = $array [$i] ['udt_name'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['data_type'] = $array [$i] ['data_type'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['numeric_precision'] = $array [$i] ['numeric_precision'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['numeric_scale'] = $array [$i] ['numeric_scale'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['character_maximum_length'] = $array [$i] ['character_maximum_length'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['datetime_precision'] = $array [$i] ['datetime_precision'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['interval_type'] = $array [$i] ['interval_type'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['is_nullable'] = $array [$i] ['is_nullable'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['column_default'] = $array [$i] ['column_default'];
			$arrayResult ['tabelas'] []  = $array [$i] ['schema_name'].".".$array [$i] ['table_name'];
			if(isset($arrayIndice['schema'] [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']]))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['indice'] = $arrayIndice['schema']  [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']] ['indice'] ;
			/*
			if(isset($arrayFuncao['schema'] [$array [$i] ['schema_name']] ['funcao']  ))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['funcao']  = $arrayFuncao['schema']  [$array [$i] ['schema_name']] ['funcao']  ;
			*/
			if(isset($arrayTrigger['schema'] [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']]))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['trigger'] = $arrayTrigger['schema']  [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']] ['trigger'] ;
			if(isset($arrayConstraint['schema'] [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']]))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['constraint'] = $arrayConstraint['schema']  [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']] ['constraint'] ;
		}
		$arrayResult ['tabelas'] = array_unique($arrayResult ['tabelas']);
		sort($arrayResult ['tabelas']);
		
		$arrayResult ['sequences'] = array_unique ( $arrayResult ['sequences'] );
		sort ( $arrayResult ['sequences'] );

		
		return $arrayResult;
	}
}