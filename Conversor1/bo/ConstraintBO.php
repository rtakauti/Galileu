<?php
include_once realpath ( __DIR__ . '/../enum/SchemaType.php' );
include_once realpath ( __DIR__ . '/../enum/FaseQuery.php' );
include_once 'RestricaoBO.php';
include_once 'estrutura/Estrutura.php';

class ConstraintBO extends TabelaBO{
	
	
	public static function dev() {
		$lista = array ();
		$tabelas = parent::dev ();
		foreach ( $tabelas as $tabelaInput ) {
			list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
			if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] )) {
				$constraints = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] );
				foreach ( $constraints as $constraint ) {
					$lista [] = "$schema.$tabela.$constraint";
				}
			}
		}
		return $lista;
	}
	
	public static function homolog() {
		$lista = array ();
		$tabelas = parent::homolog ();
		foreach ( $tabelas as $tabelaInput ) {
			list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
			if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] )) {
				$constraints = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] );
				foreach ( $constraints as $constraint ) {
					$lista [] = "$schema.$tabela.$constraint";
				}
			}
		}
		return $lista;
	}
	
	
	public function listarDev() {
		$lista = self::dev();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ DEV CONSTRAINTS ------";
			foreach ($lista as $constraint) {
				list($schema, $tabela, $constraint) = explode(".", $constraint);
				$string .= "\n\t-- $schema.$tabela.$constraint" ;
			}
		}
		return $string;
	}
	
	public function listarHomolog() {
		$lista = self::homolog();
		$string = "";
		if (! empty ( $lista )) {
			$string = "\n\n------ HOMOLOG CONSTRAINTS ------";
			$i = 0;
			foreach ($lista as $constraint) {
				list($schema, $tabela, $constraint) = explode(".", $constraint);
				$string .= "\n\t-- $schema.$tabela.$constraint" ;
			}
		}
		return $string;
	}
	
	
	public function listar(){
		$string = "";
		$string .= $this->listarDev();
		$string .= $this->listarHomolog();
		return $string;
	}
	
	
	public function drop() {
		$dev = self::dev ();
		$homolog = self::homolog ();
		$constraints = array_diff ( $homolog, $dev );
		$string = "";
		if (! empty ( $constraints )) {
			$string = "\n\n\n-------------------- DROP CONSTRAINT --------------------";
			$string .= "\n/*";
			foreach ( $constraints as $constraint ) {
				list ( $schema, $tabela, $constraint ) = explode ( ".", $constraint );
				$string .= "\n\nALTER TABLE IF EXISTS $schema.$tabela \n\tDROP CONSTRAINT IF EXISTS $constraint CASCADE;";
				unset ( parent::$result ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] [$constraint] );
			}
			$string .= "\n*/";
		}
		return $string;
	}
	
	
	public function create() {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] ))
			$constraints = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] );
		$string = "";
		if (! empty ( $constraints )) {
			$restricao = new RestricaoBO ();
			foreach ( $constraints as $constraint ) {
				parent::$constraint = $constraint;
				$restricoes = $restricao->construct ( );
				$string .= "\tCONSTRAINT $constraint $restricoes,\n";
				parent::$result['schema'] [$schema] ['tabela'][$tabela]['constraint'][$constraint] = parent::$dev['schema'] [$schema] ['tabela'][$tabela]['constraint'][$constraint];
			}
		}
		return $string;
	}
	
	
	public function add() {
		$dev = parent::dev ();
		$homolog = parent::homolog ();
		$tabelas = array_intersect ( $dev, $homolog );
		$string = "";
		$restricao = new RestricaoBO ( );
		if (! empty ( $tabelas )) {
			$string = "\n\n\n-------------------- ALTER TABLE ADD CONSTRAINT --------------------";
			$propriedade = new PropriedadeBO ();
			foreach ( $tabelas as $tabelaInput ) {
				list ( $schema, $tabela ) = explode ( ".", $tabelaInput );
				parent::$schema = $schema;
				parent::$tabela = $tabela;
				if ((isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] )))
					$dev =  array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint']) ;
				if ((isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] )))
					$homolog = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['constraint']);
				$constraints = array_diff ( $dev, $homolog );
				$constraintsIntersect = array_intersect ( $homolog ,  $dev );
				if (! empty ( $constraints )) {
					foreach ( $constraints as $constraint) {
						parent::$constraint = $constraint;
						$restricoes = $restricao->construct ( );
						if($restricoes != ""){
							$string .= "\nALTER TABLE $schema.$tabela";
							$string .= "\n\tADD CONSTRAINT $constraint " .$restricoes . ";\n";
						}
					}
				}
					/*
					foreach ( $constraintsIntersect as $constraint ) {
						parent::$constraint = $constraint;
						if ($homolog [$constraint] != $dev [$constraint]) {
							$string .= "\nALTER TABLE $schema.$tabela\n\tADD CONSTRAINT $constraint " . $restricao->construct () . ";\n";
						}
					}
					*/
			}
		}
		return $string;
	}
	
	
	
	
}

