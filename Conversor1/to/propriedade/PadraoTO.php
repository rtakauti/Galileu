<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../bo/estrutura/Estrutura.php' );
include_once realpath ( __DIR__ . '/../IPropriedade.php' );

class PadraoTO extends Estrutura implements IPropriedade {

	public function sequence($valor, $sequences, $schema, $tabela, $coluna){
		$valida = "nextval('";
		$string = "";
		if ((substr ( $valor, 0, strlen ( $valida ) ) == $valida) ) {
			$fimSequence = strpos ( $valor, "':" ) - strlen ( $valida );
			$sequence = substr ( $valor, strlen ( $valida ), $fimSequence );
			if ($schema == "public")
				$sequence = "public." . $sequence;
			if(isset($sequences))
				if (! in_array ( $sequence, $sequences ) ) {
					$string .= "\nCREATE SEQUENCE $sequence;";
					$string .= "\nSELECT setval('$sequence', MAX($coluna)) FROM $schema.$tabela;";
				} else {
				//	$string = "\n\n----  SET DA SEQUENCE  ----";  
					$string .= "\nSELECT setval('$sequence', MAX($coluna)) FROM $schema.$tabela;";
				}
		}
		return $string;
	}
	
	public function retorna($valor) {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		$coluna = parent::$coluna;
		$propriedades = parent::$propriedades;
		$sequences = parent::$sequences;
		
		$string = "";
		if ( isset($valor) ){
			
			switch (parent::$fase) {
				case FaseQuery::CREATE :
					$string = " DEFAULT $valor ";
					break;
				case FaseQuery::ADD :
					$string = "\n\tDEFAULT $valor ";
					break;
				case FaseQuery::ALTER :
					$string = "\nALTER TABLE $schema.$tabela ALTER COLUMN $coluna SET DEFAULT $valor;";
					$string .= $this->sequence($valor, $sequences, $schema, $tabela, $coluna);
					break;
				
				default :
					break;
			}
		}else{
			if(parent::$fase == FaseQuery::ALTER)
				$string = "\nALTER TABLE $schema.$tabela ALTER COLUMN $coluna DROP DEFAULT;";
		}
		return $string;
	}
}