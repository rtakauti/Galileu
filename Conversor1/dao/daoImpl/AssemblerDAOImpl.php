<?php
include_once realpath ( __DIR__ . '/../IAssemblerDAO.php' );


class AssemblerDAOImpl implements IAssemblerDAO{
	
	private $funcao;
	private $schema;
	private $sequence;
	private $trigger;
	private $constraint;
	private $indice;

	public function __construct($dbCompany){
		$this->funcao = new FuncaoDAOImpl($dbCompany);
		$this->schema = new SchemaDAOImpl($dbCompany);
		$this->sequence = new SequenceDAOImpl($dbCompany);
		$this->trigger = new TriggerDAOImpl($dbCompany);
		$this->constraint = new ConstraintDAOImpl($dbCompany);
		$this->indice = new IndiceDAOImpl($dbCompany);
	}
	
	public function retorna($schemaType){
		$arraResult = array();
		
		$arrayFuncao = $this->funcao->retorna($schemaType);
		$arrayResult['funcoes'] = @$arrayFuncao['funcoes'];
		
		$arraResult['sequences'] = $this->sequence->retorna($schemaType);
		
		$arrayIndice = $this->indice->retorna($schemaType);
		$arraResult['indices'] = @$arrayIndice['indices'];
		
		$arrayTrigger = $this->trigger->retorna($schemaType);
		$arrayResult['triggers'] = @$arrayTrigger['triggers'];
		
		$arrayConstraint = $this->constraint->retorna($schemaType);
		$arrayResult['constraints'] = @$arrayConstraint['constraints'];
		
		$array = $this->schema->retorna($schemaType);
		
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
			$arrayResult ['schemas'][$array [$i] ['schema_name']] = $array [$i] ['schema_name'];
			$arrayResult ['tabelas'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']]  = $array [$i] ['schema_name'].".".$array [$i] ['table_name'];
			if(isset($arrayIndice['schema'] [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']]))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['indice'] = $arrayIndice['schema']  [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']] ['indice'] ;
			if(isset($arrayFuncao['schema'] [$array [$i] ['schema_name']] ['funcao']  ))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['funcao']  = $arrayFuncao['schema']  [$array [$i] ['schema_name']] ['funcao']  ;
			if(isset($arrayTrigger['schema'] [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']]))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['trigger'] = $arrayTrigger['schema']  [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']] ['trigger'] ;
			if(isset($arrayConstraint['schema'] [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']]))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['table_name']] ['constraint'] = $arrayConstraint['schema']  [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['table_name']] ['constraint'] ;
		}
		$arrayResult ['schemas'] = array_unique($arrayResult ['schemas']);
		sort($arrayResult ['schemas']);
		
		$arrayResult ['tabelas'] = array_unique($arrayResult ['tabelas']);
		sort($arrayResult ['tabelas']);
		
		$arrayResult ['sequences'] = array_unique ( $arrayResult ['sequences'] );
		sort ( $arrayResult ['sequences'] );
		
		return $arrayResult;
	}
	
	
}