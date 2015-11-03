<?php
include_once 'estrutura/Estrutura.php';
class ConstraintBO extends Estrutura{
	
	public function listar(){
		$string = "";
		$string .= parent::lista(parent::$dev['constraints'], "DEV CONSTRAINT");
		$string .= parent::lista(parent::$homolog['constraints'], "HOMOLOG CONSTRAINT");
		return $string;
	}
	
	public function drop() {
		$constraints = array_diff ( parent::$homolog['constraints'], parent::$dev['constraints'] );
		$string = "";
		if (! empty ( $constraints )) {
			$string .= "\n\n\n".str_pad(" DROP DE CONSTRAINT ",100,"-",STR_PAD_BOTH);
			$string .= "\n/*\n";
			foreach ( $constraints as $constraintInput ) {
				list ( $schema, $tabela, $constraint ) = explode ( ".", $constraintInput );
				$string .= "\n\nALTER TABLE IF EXISTS $schema.$tabela";
				$string .= "\n\tDROP CONSTRAINT IF EXISTS $constraint;";
			}
			$string .= "\n\n\n*/";
		}
		return $string;
	}
	
	
	public function add() {
		$string = $stringResult = "";
		$constraints = array_diff ( parent::$dev ['constraints'], parent::$homolog ['constraints'] );
		if (! empty ( $constraints )) {
			$restricao = new RestricaoBO ();
			foreach ( $constraints as $constraintInput ) {
				list ( parent::$schema, parent::$tabela, parent::$constraint ) = explode ( ".", $constraintInput );
				$schema = parent::$schema;
				$tabela = parent::$tabela;
				$constraint = parent::$constraint;
				$restricoes = $restricao->construct ();
				if ($restricoes != "") {
					$stringResult = "\n\n\n" . str_pad ( " ADD DE CONSTRAINT ", 100, "-", STR_PAD_BOTH );
					$string .= "\n\nALTER TABLE $schema.$tabela";
					$string .= "\n\tADD CONSTRAINT $constraint $restricoes;";
				}
			}
		}
		return $stringResult . $string;
	}
	
	
	public function alter() {
		$constraints = array_intersect ( parent::$dev['constraints'], parent::$homolog['constraints'] );
		$string = $stringResult = "";
		if (! empty ( $constraints )) {
			$restricao = new RestricaoBO ( );
			foreach ( $constraints as $constraintInput ) {
				list ( parent::$schema, parent::$tabela, $constraint ) = explode ( ".", $constraintInput );
				$schema = parent::$schema;
				$tabela = parent::$tabela;
				$dev = parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] [$constraint];
				$homolog = parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] [$constraint];
				if ($dev != $homolog) {
					parent::$constraint = $constraint;
					$restricoes = $restricao->construct ();
					if ($restricoes != "") {
						$stringResult = "\n\n\n".str_pad(" ALTER DE CONSTRAINT ",100,"-",STR_PAD_BOTH);
						
						$string .= "\n\nALTER TABLE IF EXISTS $schema.$tabela";
						$string .= "\n\tDROP CONSTRAINT IF EXISTS $constraint;";
						
						$string .= "\n\nALTER TABLE $schema.$tabela";
						$string .= "\n\tADD CONSTRAINT $constraint $restricoes;";
					}
				}
			}
		}
		return $stringResult.$string;
	}
	
}

