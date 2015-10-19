<?php

include_once 'Connection.php';
include_once '../enum/SchemasCompany.php';
$dir = "app.ado";
$items = glob($dir );
$schemaQuery = "select distinct ";
$schemaQuery .= " table_name ";
$schemaQuery .= " from information_schema.columns ";
$schemaQuery .= " where table_schema = 'public' ";
//$schemaQuery .= " and table_name = 'tabela3'";
//print_r($items);

//echo SchemasCompany::teste;
//exit();
 
$item = parse_ini_file($dir . '/config.ini');
 //echo $item['connection']['pass'];
//print_r($item);

$conns = Connection::getInstances(SchemasCompany::TESTE);
//$conn['dev']->prepare
$find = $conns['homolog']->prepare ( $schemaQuery );
$find->execute ();
$resultado = $find->fetchAll ( PDO::FETCH_NUM );

print_r($resultado);

//print_r($conn['homolog']);

//$teste = parse_ini_file($filename)