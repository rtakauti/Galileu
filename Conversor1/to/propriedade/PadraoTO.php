<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../../bo/sequence/GerenciadorSequence.php' );
include_once realpath ( __DIR__ . '/../IPropriedade.php' );
class PadraoTO extends GerenciadorSequence implements IPropriedade {
	public function __construct($valor = NULL, $fase = NULL, $condicao = NULL, $estrutura = NULL) {
		$this->retorna ( $valor, $fase, $condicao, $estrutura );
	}
	public function retorna($valor, $fase, $condicao, $estrutura) {
		$schema = $estrutura [EstruturaQuery::SCHEMA];
		$tabela = $estrutura [EstruturaQuery::TABELA];
		$coluna = $estrutura [EstruturaQuery::COLUNA];
		$sequences = $estrutura [EstruturaQuery::SEQUENCE];
		GerenciadorSequence::carregaCriados ( $sequences );
		$sequences = GerenciadorSequence::getCriados ();
		
		$string = "";
		if (isset ( $valor )) {
			
			if ((substr ( $valor, 0, strlen ( "nextval('" ) ) == "nextval('") && $fase != FaseQuery::CREATE) {
				$fimSequence = strpos ( $valor, "':" ) - strlen ( "nextval('" );
				$sequence = substr ( $valor, strlen ( "nextval('" ), $fimSequence );
				if ($schema == "public")
					$sequence = "public." . $sequence;
				if(isset($sequences))
				if (! in_array ( $sequence, $sequences ) ) {
					GerenciadorSequence::adicionaCriados ( $sequence );
					$createSequence = "\n\n-------------------- CREATE DA SEQUENCE --------------------";
					$createSequence .= "\nCREATE SEQUENCE $sequence;";
					GerenciadorSequence::adicionaQueryCriado ( $createSequence );
					$setSequence = "\n\n-------------------- SET DA SEQUENCE --------------------";
					$setSequence .= "\nSELECT setval('$sequence', MAX($coluna)) FROM $tabela;";
					GerenciadorSequence::adicionaQuerySetado ( $setSequence );
				} else {
					$setSequence = "\n\n-------------------- SET DA SEQUENCE --------------------";
					$setSequence .= "\nSELECT setval('$sequence', MAX($coluna)) FROM $tabela;";
					GerenciadorSequence::adicionaQuerySetado ( $setSequence );
				}
			}
			
			switch ($fase) {
				case FaseQuery::CREATE :
					$string = " DEFAULT $valor ";
					break;
				case FaseQuery::ADD :
					$string = "\n\tDEFAULT $valor ";
					break;
				case FaseQuery::ALTER :
					$string = "\nALTER TABLE $tabela ALTER COLUMN $coluna DROP DEFAULT;";
					$string .= "\nALTER TABLE $tabela ALTER COLUMN $coluna SET DEFAULT $valor;";
					break;
				
				default :
					break;
			}
			return $string;
		}
	}
}