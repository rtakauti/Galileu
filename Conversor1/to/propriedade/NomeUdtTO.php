<?php

include_once realpath(__DIR__ .'/../../enum/FaseQuery.php');
include_once realpath(__DIR__.'/../../enum/EstruturaQuery.php');
include_once realpath(__DIR__ .'/../../bo/sequence/GerenciadorSequence.php');
include_once realpath(__DIR__.'/../IPropriedade.php');

class NomeUdtTO implements IPropriedade {
	
	
	public function __construct($valor = NULL, $fase = NULL, $condicao = NULL, $estrutura = NULL) {
		$this->retorna ( $valor, $fase, $condicao, $estrutura );
	}
	
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
					/*
					case "_bool" :
						$string = " boolean ";
						break;
					case "_bytea" :
						$string = " bytea ";
						break;
					case "_numeric" :
						$string = " numeric ";
						break;	
					case "_money" :
						$string = " money ";
						break;
					case "_bpchar" :
						$string = " character (1) ";
						break;
					case "_varchar" :
						$string = " varchar ";
						break;
					case "_text" :
						$string = " text ";
						break;
					case "_date" :
						$string = " date ";
						break;
					case "_interval" :
						$string = " interval ";
						break;
					case "geometry" :
						$string = " geometry ";
						break;	
					case "_point" :
						$string = " point ";
						break;		
					case "_line" :
						$string = " line ";
						break;	
					case "_lseg" :
						$string = " lseg ";
						break;	
					case "_path" :
						$string = " path ";
						break;	
					case "_polygon" :
						$string = " polygon ";
						break;	
					case "_box" :
						$string = " box ";
						break;
					case "_circle" :
						$string = " circle ";
						break;	
					case "_cidr" :
						$string = " cidr ";
						break;	
					case "_inet" :
						$string = " inet ";
						break;		
					case "_macaddr" :
						$string = " macaddr ";
						break;	
					case "_tsquery" :
						$string = " tsquery ";
						break;		
					case "_tsvector" :
						$string = " tsvector ";
						break;	
					case "_txid_snapshot" :
						$string = " txid_snapshot ";
						break;	
					case "_uuid" :
						$string = " uuid ";
						break;	
					case "_xml" :
						$string = " xml ";
						break;	
					*/
					default :
						if($valor[0] == "_"){
							$valor[0] = $valor[strlen($valor)] = " ";
							$string = $valor;
						}
						break;
				}
				
		}
		return $string;
	}
	
	
}