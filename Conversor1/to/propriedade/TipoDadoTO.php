<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../bo/estrutura/Estrutura.php' );
include_once realpath ( __DIR__ . '/../IPropriedade.php' );

class TipoDadoTO extends Estrutura implements IPropriedade {
	
	public function retorna($valor) {
		$schema = parent::$schema;
		$tabela = parent::$tabela;
		$coluna = parent::$coluna;
		$propriedades = parent::$propriedades;
		$string = "";
		if (isset ( $valor )) {
			switch (parent::$fase) {
				case FaseQuery::CREATE :
					
					switch ($valor) {
						case "ARRAY" :
							$string = "[] ";
							break;
						case "time without time zone" :
							$string = "";
							break;
						case "time with time zone" :
							$string = "";
							break;
						case "timestamp without time zone" :
							$string = "";
							break;
						case "timestamp with time zone" :
							$string = "";
							break;
						case "USER-DEFINED" :
							$string = "";
							break;
						default :
							$string = $valor;
							break;
					}
					
					break;
				case FaseQuery::ADD :
					switch ($valor) {
						case "ARRAY" :
							$string = "[]";
							break;
						case "time without time zone" :
							$string = "";
							break;
						case "time with time zone" :
							$string = "";
							break;
						case "timestamp without time zone" :
							$string = "";
							break;
						case "timestamp with time zone" :
							$string = "";
							break;
						case "USER-DEFINED" :
							$string = "";
							break;
						default :
							$string = "\n\t$valor";
							break;
					}
					break;
				
				case FaseQuery::ALTER :
					$string = "\nALTER TABLE $schema.$tabela ALTER COLUMN $coluna TYPE $valor USING $coluna::$valor;";
					break;
				
				default :
					break;
			}
		}
		return $string;
	}
}