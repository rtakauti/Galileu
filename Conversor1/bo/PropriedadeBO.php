<?php
include_once realpath (__DIR__ . '/../enum/SchemaType.php');
include_once realpath (__DIR__ . '/../enum/FaseQuery.php');
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
include_once 'estrutura/Estrutura.php';

class PropriedadeBO extends Estrutura{

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
	
	public function construct() {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		$coluna = parent::$coluna;
		$propriedadesBO = $this->properties;
		parent::$propriedades = parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['coluna'][$coluna];
		$string = "";
		foreach ( parent::$propriedades as $propriedade => $valor ) 
			$string .= GeradorPropriedades::gerarPropriedade ( $propriedadesBO [$propriedade], $valor);
		return $string;
	}
	
	
	public function alter() {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		$coluna = parent::$coluna;
		parent::$fase = FaseQuery::ALTER;
		$propriedadesBO = $this->properties;
		$dev = parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] [$coluna];
		$homolog = parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] [$coluna];
		parent::$propriedades = array_diff_assoc ( $dev, $homolog );
		$string = $anteriorColuna = $anterior = "";
		foreach ( parent::$propriedades as $propriedade => $valor ) {
			$anteriorColuna = "\n\n-- ESTADO ANTERIOR: $coluna -- ";
			$homologValor = parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['coluna'] [$coluna] [$propriedade];
			if (! isset ( $homologValor ))	$homologValor = "NULO";
			$anterior .= " $propriedade => $homologValor, ";
			$string .= GeradorPropriedades::gerarPropriedade ( $propriedadesBO [$propriedade], $valor );
		}
		$anterior = substr ( $anterior, 0, - 2 );
		return $anteriorColuna . $anterior . $string;
	}


}