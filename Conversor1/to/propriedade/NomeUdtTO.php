<?php

include_once realpath(__DIR__ .'/../../enum/FaseQuery.php');
include_once realpath(__DIR__.'/../../enum/EstruturaQuery.php');
include_once realpath(__DIR__ .'/../../bo/sequence/GerenciadorSequence.php');
include_once realpath(__DIR__.'/../IPropriedade.php');

class NomeUdtTO implements IPropriedade {

	public function retorna($valor, $fase, $condicao, $estrutura) {
		$string = "";
		if (isset ( $valor )) {
					switch ($valor) {
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
						case "_bpchar" :
							$string = " character (1) ";
							break;	
						case "_time" :
							if(isset($condicao['datetime_precision'])) $string = " time({$condicao['datetime_precision']}) without time zone ";
							else $string = " time without time zone ";
							break;	
						case "_timetz" :
							if(isset($condicao['datetime_precision'])) $string = " time({$condicao['datetime_precision']}) with time zone ";
							else $string = " time with time zone ";
							break;	
						case "_timestamp" :
							if(isset($condicao['datetime_precision'])) $string = " timestamp({$condicao['datetime_precision']}) without time zone ";
							else $string = " time without time zone ";
							break;	
						case "_timestamptz" :
							if(isset($condicao['datetime_precision'])) $string = " timestamp({$condicao['datetime_precision']}) with time zone ";
							else $string = " time with time zone ";
							break;	
						default :
							if($valor[0] == "_"){
								$valor[0] = $valor[strlen($valor)] = " ";
								$string = $valor;
							}else{
								$string = $valor;
							}
							break;
					}
		return $string;
		}
	}
	
	
}