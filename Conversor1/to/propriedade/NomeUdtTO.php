<?php
include_once realpath ( __DIR__ . '/../../enum/FaseQuery.php' );
include_once realpath ( __DIR__ . '/../../bo/estrutura/Estrutura.php' );
include_once realpath ( __DIR__ . '/../IPropriedade.php' );

class NomeUdtTO extends Estrutura implements IPropriedade {
	
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
						case "_bool" :
							$string = " boolean ";
							break;
						case "_bit" :
							$string = " bit (1) ";
							break;
						case "_varbit" :
							$string = " bit varying ";
							break;
						case "_int2" :
							$string = " smallint ";
							break;
						case "_int4" :
							$string = " integer ";
							break;
						case "_int8" :
							$string = " bigint ";
							break;
						case "_float4" :
							$string = " real ";
							break;
						case "_float8" :
							$string = " double precision ";
							break;
						case "_varchar" :
							$string = " character varying ";
							break;
						case "_bpchar" :
							$string = " character (1) ";
							break;
						case "_time" :
							if (isset ( $condicao ['datetime_precision'] ))
								$string = " time({$condicao['datetime_precision']}) without time zone ";
							else
								$string = " time without time zone ";
							break;
						case "_timetz" :
							if (isset ( $condicao ['datetime_precision'] ))
								$string = " time({$condicao['datetime_precision']}) with time zone ";
							else
								$string = " time with time zone ";
							break;
						case "_timestamp" :
							if (isset ( $condicao ['datetime_precision'] ))
								$string = " timestamp({$condicao['datetime_precision']}) without time zone ";
							else
								$string = " time without time zone ";
							break;
						case "_timestamptz" :
							if (isset ( $condicao ['datetime_precision'] ))
								$string = " timestamp({$condicao['datetime_precision']}) with time zone ";
							else
								$string = " time with time zone ";
							break;
						
						default :
							if ($valor [0] == "_") {
								$valor [0] = " ";
								$string = $valor;
							}
							break;
					}
					
					break;
				case FaseQuery::ADD :
					
					switch ($valor) {
						case "_bool" :
							$string = "\n\tboolean";
							break;
						case "_bit" :
							$string = "\n\tbit (1)";
							break;
						case "_varbit" :
							$string = "\n\tbit varying";
							break;
						case "_int2" :
							$string = "\n\tsmallint";
							break;
						case "_int4" :
							$string = "\n\tinteger";
							break;
						case "_int8" :
							$string = "\n\tbigint";
							break;
						case "_float4" :
							$string = "\n\treal";
							break;
						case "_float8" :
							$string = "\n\tdouble precision";
							break;
						case "_bpchar" :
							$string = "\n\tcharacter (1)";
							break;
						case "_varchar" :
							$string = "\n\tcharacter varying";
							break;
						case "_time" :
							if (isset ( $condicao ['datetime_precision'] ))
								$string = " time({$condicao['datetime_precision']}) without time zone ";
							else
								$string = "\n\ttime without time zone";
							break;
						case "_timetz" :
							if (isset ( $condicao ['datetime_precision'] ))
								$string = " time({$condicao['datetime_precision']}) with time zone ";
							else
								$string = "\n\ttime with time zone";
							break;
						case "_timestamp" :
							if (isset ( $condicao ['datetime_precision'] ))
								$string = " timestamp({$condicao['datetime_precision']}) without time zone ";
							else
								$string = "\n\ttime without time zone";
							break;
						case "_timestamptz" :
							if (isset ( $condicao ['datetime_precision'] ))
								$string = " timestamp({$condicao['datetime_precision']}) with time zone ";
							else
								$string = "\n\ttime with time zone";
							break;
						
						default :
							if ($valor [0] == "_") {
								$valor [0] = "";
								$string = "\n\t" . $valor;
							}
							break;
					}
					
					break;
				default :
					break;
			}
		}
		return $string;
	}
}