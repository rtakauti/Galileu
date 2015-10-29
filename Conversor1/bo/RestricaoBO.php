<?php
include_once realpath ( __DIR__ . '/../enum/SchemaType.php' );
include_once realpath ( __DIR__ . '/../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../to/GeradorRestricoes.php' );
include_once realpath ( __DIR__ . '/../to/constraint/TipoConstraintTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/NomeColunaTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/TabelaEstrangeiraTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/ColunaEstrangeiraTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/CombinacaoTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/RegraUpdateTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/RegraDeleteTO.php' );
include_once realpath ( __DIR__ . '/../to/constraint/RegraUniqueTO.php' );
include_once 'estrutura/Estrutura.php';

class RestricaoBO extends Estrutura{

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

	public function construct(){
		$restricoesBO = $this->restricoes;
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		$constraint = parent::$constraint;
		$string ="";
		if(isset(parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['constraint'][$constraint]))
			$restricoes = parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['constraint'][$constraint];
		if(!empty($restricoes))
			foreach ($restricoes as $restricao => $valor) 
				$string .= GeradorRestricoes::gerarRestricao($restricoesBO[$restricao], $valor);
		return $string;

	}
	


}
	
	
