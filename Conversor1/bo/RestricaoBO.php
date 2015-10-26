<?php
include_once realpath ( __DIR__ . '/../enum/SchemaType.php' );
include_once realpath ( __DIR__ . '/../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../to/GeradorRestricoes.php' );
include_once realpath ( __DIR__ . '/../to/constraint/TipoConstraintTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/NomeColunaTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/TabelaEstrangeiraTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/ColunaEstrangeiraTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/CombinacaoTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/RegraUpdateTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/RegraDeleteTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/RegraUniqueTO.php' );


class RestricaoBO extends AssemblerBO{

	private $restricoes;

	public function __construct(){
		$this->restricoes['constraint_type'] = new TipoConstraintTO();
		$this->restricoes['column_name'] = new NomeColunaTO();
		$this->restricoes['foreign_table'] = new TabelaEstrangeiraTO();
		$this->restricoes['foreign_column'] = new ColunaEstrangeiraTO();
		$this->restricoes['match_option'] = new CombinacaoTO();
		$this->restricoes['update_rule'] = new RegraUpdateTO();
		$this->restricoes['delete_rule'] = new RegraDeleteTO();
		$this->restricoes['consrc'] = new RegraUniqueTO();
	}

	public function construct($constraintInput, $fase){
		list($schema, $tabela, $constraint) = explode(".", $constraintInput);
		$restricoesBO = $this->restricoes;
		$constraints = parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['constraint'][$constraint];
		$stringResult ="";
		foreach ($constraints as $constraint => $valor) {
			$string = GeradorRestricoes::gerarRestricao($restricoesBO[$constraint], $valor, $fase);
			$stringResult .= $string;
		}
		return $stringResult;

	}
	


}
	
	
