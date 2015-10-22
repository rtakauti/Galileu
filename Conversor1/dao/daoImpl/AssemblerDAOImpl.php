<?php
include_once realpath ( __DIR__ . '/../IAssemblerDAO.php' );
include_once 'ConstraintDAOImpl.php';
include_once 'FuncaoDAOImpl.php';
include_once 'IndiceDAOImpl.php';
include_once 'SchemaDAOImpl.php';
include_once 'SequenceDAOImpl.php';
include_once 'TriggerDAOImpl.php';

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
		$arraySequence = $this->sequence->retorna($schemaType);
		$arrayIndice = $this->indice->retorna($schemaType);
		$arrayTrigger = $this->trigger->retorna($schemaType);
		$arrayConstraint = $this->constraint->retorna($schemaType);
		
		
		$array = $this->schema->retorna($schemaType);
		for($i = 0; $i < count ( $array ); $i ++) {
				
			if(isset($arrayIndice['schema'] [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['schema_name'].".".$array [$i] ['table_name']]))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['indice'] = $arrayIndice['schema']  [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['indice'] ;
			if(isset($arrayTrigger['schema'] [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['schema_name'].".".$array [$i] ['table_name']]))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['trigger'] = $arrayTrigger['schema']  [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['trigger'] ;
			if(isset($arraySequence['schema'] [$array [$i] ['schema_name']] ['sequence']  ))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['sequence']  = $arraySequence['schema']  [$array [$i] ['schema_name']] ['sequence']  ;
			if(isset($arrayFuncao['schema'] [$array [$i] ['schema_name']] ['funcao']  ))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['funcao']  = $arrayFuncao['schema']  [$array [$i] ['schema_name']] ['funcao']  ;
			if(isset($arrayConstraint['schema'] [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ))$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']]  ['constraint'] = $arrayConstraint['schema']  [$array [$i] ['schema_name']] ['tabela']  [$array [$i] ['schema_name'].".".$array [$i] ['table_name']]  ['constraint'] ;
			
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['udt_name'] = $array [$i] ['udt_name'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['data_type'] = $array [$i] ['data_type'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['numeric_precision'] = $array [$i] ['numeric_precision'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['numeric_scale'] = $array [$i] ['numeric_scale'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['character_maximum_length'] = $array [$i] ['character_maximum_length'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['datetime_precision'] = $array [$i] ['datetime_precision'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['interval_type'] = $array [$i] ['interval_type'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['is_nullable'] = $array [$i] ['is_nullable'];
			$arrayResult ['schema'] [$array [$i] ['schema_name']] ['tabela'] [$array [$i] ['schema_name'].".".$array [$i] ['table_name']] ['coluna'] [$array [$i] ['column_name']] ['column_default'] = $array [$i] ['column_default'];
		}
		
		return $arrayResult;
	}
	
	
}