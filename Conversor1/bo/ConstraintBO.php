<?php
include_once realpath ( __DIR__ . '/../enum/SchemaType.php' );
include_once realpath ( __DIR__ . '/../enum/EstruturaQuery.php' );
include_once realpath ( __DIR__ . '/../enum/FaseQuery.php' );
include_once 'RestricaoBO.php';

class ConstraintBO extends AssemblerBO{
	
	
	
	
	public static function dev() {
		$lista = array ();
		$schemas = array_keys ( parent::$dev ['schema'] );
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] )) {
				$tabelas = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] );
				foreach ( $tabelas as $tabela ) {
					if (isset ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela]['constraint'] )) {
						$constraints = array_keys ( parent::$dev ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] );
						foreach ( $constraints as $constraint ) {
							$lista [] = "$schema.$tabela.$constraint";
						}
					}
				}
			}
		}
		return $lista;
	}
	
	public static function homolog() {
		$lista = array ();
		$schemas = array_keys ( parent::$homolog ['schema'] );
		foreach ( $schemas as $schema ) {
			if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] )) {
				$tabelas = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] );
				foreach ( $tabelas as $tabela ) {
					if (isset ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela]['constraint'] )) {
						$constraints = array_keys ( parent::$homolog ['schema'] [$schema] ['tabela'] [$tabela] ['constraint'] );
						foreach ( $constraints as $constraint ) {
							$lista [] = "$schema.$tabela.$constraint";
						}
					}
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
	
	
	
	public function create($tabelaInput) {
		list($schema, $tabela) = explode(".", $tabelaInput);
		if(isset(parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['constraint']))
			$constraints = array_keys(parent::$dev ['schema'] [$schema] ['tabela'][$tabela]['constraint']);
		$fase = FaseQuery::CREATE;
		$string = "";
		if (! empty ( $constraints )) {
			foreach ( $constraints as $constraint ) {
				$constraintInput = "$schema.$tabela.$constraint";
				$restricao = new RestricaoBO ();
				$restricoes = $restricao->construct($constraintInput, $fase);
				$string .= "\tCONSTRAINT $nameConstraint $restricoes,\n";
			}
		}
		return $string;
	}
	
	
	public function addConstraint() {
		$fase = FaseQuery::ADD;
		$tabela = $this->estrutura [EstruturaQuery::TABELA];
		$homolog = $this->dao->restricao ( SchemaType::HOMOLOG );
		$dev = $this->dao->restricao ( SchemaType::DEV );
		$constraints = array_diff_assoc ( $dev, $homolog );
		$constraintsIntersect = array_intersect(array_keys($homolog), array_keys($dev));
		$string = "";
		if (!empty($constraints )) {
			$string = "\n\n\n-------------------- ADD CONSTRAINT --------------------";
			foreach ( $constraints as $nameConstraint => $constraint ) {
				$restricao = new RestricaoBO ( $constraint, $fase );
				$string .= "\nALTER TABLE $tabela\n\tADD CONSTRAINT $nameConstraint " . $restricao->constructConstraint () . ";\n";
			}
			foreach ($constraintsIntersect as $nameConstraint) {
				if($homolog[$nameConstraint] != $dev[$nameConstraint]){
					$string .= "\nALTER TABLE $tabela\n\tADD CONSTRAINT $nameConstraint " . $restricao->constructConstraint () . ";\n";
				}
			}
		}
		return $string;
	}
}


