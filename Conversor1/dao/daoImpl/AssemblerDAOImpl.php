<?php
include_once realpath ( __DIR__ . '/../IDAOImpl.php' );
include_once 'ConstraintDAOImpl.php';
include_once 'FuncaoDAOImpl.php';
include_once 'IndiceDAOImpl.php';
include_once 'SchemaDAOImpl.php';
include_once 'SequenceDAOImpl.php';
include_once 'TriggerDAOImpl.php';

class AssemblerDAOImpl implements IDAOImpl{
	
	private $funcao;
	private $schema;
	private $sequence;
	private $trigger;
	private $constraint;
	private $indice;

	public function __construct(){
		$this->funcao = new FuncaoDAOImpl();
		$this->schema = new SchemaDAOImpl();
		$this->sequence = new SequenceDAOImpl();
		$this->trigger = new TriggerDAOImpl();
		$this->constraint = new ConstraintDAOImpl();
		$this->indice = new IndiceDAOImpl();
	}
	
	
	public function  retorna($schemaType){
		$funcao = $this->funcao->retorna($schemaType);
		$sequence = $this->sequence->retorna($schemaType);
		$indice = $this->indice->retorna($schemaType);
		$trigger = $this->trigger->retorna($schemaType);
		$constraint = $this->constraint->retorna($schemaType);
		$schema = $this->schema->retorna($schemaType);
		
		return array_merge_recursive($schema, $sequence, $funcao, $trigger, $indice, $constraint );
	}
	
}



