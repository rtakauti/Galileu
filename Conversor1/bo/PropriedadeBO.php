<?php
include_once realpath (__DIR__ . '/../enum/SchemaType.php');
include_once realpath (__DIR__ . '/../enum/FaseQuery.php');
include_once realpath (__DIR__ . '/../enum/EstruturaQuery.php');
include_once realpath (__DIR__ .'/../to/GeradorPropriedades.php');
include_once realpath (__DIR__ .'/../to/propriedade/MaximoCharTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/NomeUdtTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/NuloTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/PadraoTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/PrecisaoMantissaTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/PrecisaoNumericaTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/PrecisaoDataTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/TipoDadoTO.php');
include_once realpath (__DIR__ .'/../to/propriedade/TipoIntervaloTO.php');
include_once 'sequence/GerenciadorSequence.php';

class PropriedadeBO extends AssemblerBO{

	private $properties;
	
	public function __construct(){
		$this->properties['column_default'] = new PadraoTO();
		$this->properties['is_nullable'] = new NuloTO();
		$this->properties['data_type'] = new TipoDadoTO();
		$this->properties['character_maximum_length'] = new MaximoCharTO();
		$this->properties['numeric_precision'] = new PrecisaoNumericaTO();
		$this->properties['numeric_scale'] = new PrecisaoMantissaTO();
		$this->properties['datetime_precision'] = new PrecisaoDataTO();
		$this->properties['udt_name'] = new NomeUdtTO();
		$this->properties['interval_type'] = new TipoIntervaloTO();
	}
	
	public function construct($colunaInput, $fase) {
		list($schema, $tabela, $coluna) = explode(".", $colunaInput);
		$estrutura = parent::$estrutura;
		$estrutura[EstruturaQuery::SCHEMA] = $schema;
		$estrutura[EstruturaQuery::TABELA] = $tabela;
		$estrutura[EstruturaQuery::COLUNA] = $coluna;
	
		$propriedadesBO = $this->properties;
		$propriedades = parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['coluna'][$coluna];
		$stringResult = "";
		foreach ( $propriedades as $propriedade => $valor ) {
			$string = GeradorPropriedades::gerarPropriedade ( $propriedadesBO [$propriedade], $valor, $fase, $propriedades, $estrutura );
			$stringResult .= $string;
		}
		return $stringResult;
	}
	
	public function compare($colunaInput){
		list($schema, $tabela, $coluna) = explode(".", $colunaInput);
		$estrutura = parent::$estrutura;
		$estrutura[EstruturaQuery::SCHEMA] = $schema;
		$estrutura[EstruturaQuery::TABELA] = $tabela;
		$estrutura[EstruturaQuery::COLUNA] = $coluna;
		$fase = FaseQuery::ALTER;
		$propriedadesBO = $this->properties;
		$dev = parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['coluna'][$coluna];
		$homolog = parent::$homolog ['schema'] [$schema] ['tabela'][$tabela]['coluna'][$coluna];
		$propriedades = array_diff($dev, $homolog);
		$stringResult = "";
		foreach ( $propriedades as $propriedade => $valor ) {
			$string = GeradorPropriedades::gerarPropriedade ( $propriedadesBO [$propriedade], $valor, $fase, $propriedades, $estrutura );
			$stringResult .= $string;
		}
		return $stringResult;
	}


}