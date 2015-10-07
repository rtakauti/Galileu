<?php

include_once realpath (__DIR__ . '/../enum/SchemasCompany.php');
include_once realpath (__DIR__ . '/../enum/SchemaType.php');
include_once realpath (__DIR__ . '/../enum/FaseQuery.php');
include_once realpath (__DIR__ . '/../enum/EstruturaQuery.php');
include_once realpath (__DIR__ .'/../to/GeradorRestricoes.php');
include_once realpath (__DIR__ .'/../to/constraint/TipoConstraintTO.php');
include_once realpath (__DIR__ .'/../to/constraint/NomeColunaTO.php');
include_once realpath (__DIR__ .'/../to/constraint/TabelaEstrangeiraTO.php');
include_once realpath (__DIR__ .'/../to/constraint/ColunaEstrangeiraTO.php');
include_once realpath (__DIR__ .'/../to/constraint/CombinacaoTO.php');
include_once realpath (__DIR__ .'/../to/constraint/RegraUpdateTO.php');
include_once realpath (__DIR__ .'/../to/constraint/RegraDeleteTO.php');
include_once realpath (__DIR__ .'/../to/constraint/RegraUniqueTO.php');


class RestricaoBO {

	private $arrayConstraint;
	private $objetos;
	protected  $fase;

	public function __construct($arrayConstraint, $fase){
		$this->arrayConstraint = $arrayConstraint;
		$this->fase = $fase;
		
		$this->objetos['constraint_type'] = new TipoConstraintTO();
		$this->objetos['column_name'] = new NomeColunaTO();
		$this->objetos['foreign_table'] = new TabelaEstrangeiraTO();
		$this->objetos['foreign_column'] = new ColunaEstrangeiraTO();
		$this->objetos['match_option'] = new CombinacaoTO();
		$this->objetos['update_rule'] = new RegraUpdateTO();
		$this->objetos['delete_rule'] = new RegraDeleteTO();
		$this->objetos['consrc'] = new RegraUniqueTO();


	}

	public function constructConstraint(){
		$fase = FaseQuery::CREATE;
		$restricoesBO = $this->objetos;
		$constraints = $this->arrayConstraint;
		$stringResult ="";
		foreach ($constraints as $key => $constraint) {
			$string = GeradorRestricoes::gerarRestricao($restricoesBO[$key], $constraint, $fase);
			$stringResult .= $string;
		}
		return $stringResult;

	}
	


}
	
	
