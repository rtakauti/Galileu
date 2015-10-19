<?php
/*
 *
 * Constantes
 *
 *
 */

// Construcao das CONSTRAINT
const CONSTRAINT_NAME = 0;
const CONSTRAINT_TYPE = 1;
const COLUMN_NAME = 2;
const MATCH_OPTION = 3;
const UPDATE_RULE = 4;
const DELETE_RULE = 5;
const ORDINAL_POSITION = 6;
const CONSRC = 7;
const FOREIGN_TABLE_NAME = 8;
const FOREIGN_COLUMN_NAME = 9;

// Construcao das COLUNAS
// const COLUMN_NAME = 0;
const COLUMN_DEFAULT = 1;
const IS_NULLABLE = 2;
const DATA_TYPE = 3;
const CHARACTER_MAXIMUM_LENGTH = 4;
const NUMERIC_PRECISION = 5;
const NUMERIC_SCALE = 6;
const UDT_NAME = 7;

/*
 *
 * Arrays
 *
 */

// Construηγo das CONSTRAINTS
$tableConstraintAttrib = array (
		'constraint_name',
		'constraint_type',
		'column_name',
		'match_option',
		'update_rule',
		'delete_rule',
		'consrc',
		'foreign_table_name',
		'foreign_column_name' 
);

// Construηγo das COLUNAS
$tableColumnAttrib = array (
		'column_name',
		'column_default',
		'is_nullable',
		'data_type',
		'character_maximum_length',
		'numeric_precision',
		'numeric_scale',
		'udt_name',
);

/*
 *
 * Queries
 *
 */

// Retorna as TABELA do schema selecionado
$schemaQuery = "select distinct ";
$schemaQuery .= " table_name ";
$schemaQuery .= " from information_schema.columns ";
$schemaQuery .= " where table_schema = 'public' ";
$schemaQuery .= " and table_name = 'tabela3'";

// Retorna dados das CONSTRAINT
$constraintQuery = "	select ";
$constraintQuery .= " tc.constraint_name,  ";
$constraintQuery .= " tc.constraint_type,  ";
$constraintQuery .= " kcu.column_name,  ";
$constraintQuery .= " rc.match_option,  ";
$constraintQuery .= " rc.update_rule,  ";
$constraintQuery .= " rc.delete_rule,  ";
$constraintQuery .= " c.consrc, ";
$constraintQuery .= " ccu.table_name as foreign_table_name, ";
$constraintQuery .= " ccu.column_name as foreign_column_name ";
$constraintQuery .= " from information_schema.table_constraints tc ";
$constraintQuery .= " left join information_schema.key_column_usage kcu ";
$constraintQuery .= " on tc.constraint_catalog = kcu.constraint_catalog ";
$constraintQuery .= " and tc.constraint_schema = kcu.constraint_schema ";
$constraintQuery .= " and tc.constraint_name = kcu.constraint_name ";
$constraintQuery .= " left join information_schema.referential_constraints rc ";
$constraintQuery .= " on tc.constraint_catalog = rc.constraint_catalog ";
$constraintQuery .= " and tc.constraint_schema = rc.constraint_schema ";
$constraintQuery .= " and tc.constraint_name = rc.constraint_name ";
$constraintQuery .= " left join information_schema.constraint_column_usage ccu ";
$constraintQuery .= " on rc.unique_constraint_catalog = ccu.constraint_catalog ";
$constraintQuery .= " and rc.unique_constraint_schema = ccu.constraint_schema ";
$constraintQuery .= " and rc.unique_constraint_name = ccu.constraint_name ";
$constraintQuery .= " left join pg_constraint c ";
$constraintQuery .= " on tc.constraint_name = c.conname ";
$constraintQuery .= " where upper(tc.constraint_name) not like '%NOT_NULL%'";
$constraintQuery .= " and tc.table_name = ";

// Retorna os nomes das SEQUENCE
$sequenceQuery = "select ";
$sequenceQuery .= " relname ";
$sequenceQuery .= " from pg_class ";
$sequenceQuery .= " where relkind = 'S' ";
$sequenceQuery .= " and relnamespace in (select  ";
$sequenceQuery .= " 					oid ";
$sequenceQuery .= " 					from pg_namespace ";
$sequenceQuery .= " 					where nspname not like 'pg_%' ";
$sequenceQuery .= " 					and nspname != 'information_schema') ";


// Retorna as COLUNAS das tabelas do schema
$colunaQuery = "select ";
$colunaQuery .= " column_name	, ";
$colunaQuery .= " column_default	, ";
$colunaQuery .= " is_nullable	, ";
$colunaQuery .= " data_type	, ";
$colunaQuery .= " character_maximum_length	, ";
$colunaQuery .= " numeric_precision	, ";
$colunaQuery .= " numeric_scale	, ";
$colunaQuery .= " udt_name	 ";
$colunaQuery .= " from information_schema.columns where table_name = ";



