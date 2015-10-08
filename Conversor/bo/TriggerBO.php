<?php
include_once realpath (__DIR__ . '/../dao/daoImpl/TriggerDAOImpl.php');
include_once realpath ( __DIR__ . '/../enum/SchemasCompany.php' );
include_once realpath ( __DIR__ . '/../enum/SchemaType.php' );
include_once realpath ( __DIR__ . '/../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../enum/FaseQuery.php' );
include_once 'BOImpl.php';

class TriggerBO extends BOImpl {
	
	protected $dao;
	private $fase;
	private $estrutura;
	
	public function __construct($dbCompany, $schemaParameter, $tableParameter, $fase) {
		$this->dao = new TriggerDAOImpl ( $dbCompany, $schemaParameter, $tableParameter, $fase );
		$this->estrutura[EstruturaQuery::COMPANY] = $dbCompany; 
		$this->estrutura[EstruturaQuery::SCHEMA] = $schemaParameter;
		$this->estrutura[EstruturaQuery::TABELA] = $tableParameter;
		$this->fase = $fase;
	}
	public function createTrigger() {
		$fase = $this->fase;
		$tabela = $this->estrutura[EstruturaQuery::TABELA];
		$dev = $this->dao->trigger( SchemaType::DEV );
		$homolog = $this->dao->trigger( SchemaType::HOMOLOG );
		$triggers = array_diff_assoc($dev, $homolog);
		$string = "";
		if (!empty ( $triggers )) {
			$string .= "\n\n-------------------- CREATE TRIGGER --------------------";
			foreach ( $triggers as $nameTrigger => $trigger ) {
				$string .= "\nCREATE TRIGGER $nameTrigger ";
				$eventos = implode ( " OR ", $trigger ['event_manipulation'] );
				$string .= "\n\t{$trigger['action_timing']} $eventos";
				$string .= "\n\tON $tabela";
				$string .= "\n\tFOR EACH {$trigger['trigger_scope']}";
				$string .= "\n\t{$trigger['action_statement']};";
			}
		}
		return $string;
	}
}


