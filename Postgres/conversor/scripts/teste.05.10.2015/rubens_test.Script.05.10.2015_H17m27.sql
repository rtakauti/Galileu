

------------------ DATABASE: rubens_test ------------------


------ DEV SCHEMAS ------
	-- public
	-- teste
	-- teste1
	-- teste2

------ HOMOLOG SCHEMAS ------
	-- public
	-- teste

------ DROP DE SCHEMAS ------

------ CREATE DE SCHEMAS ------
CREATE SCHEMA teste1;
CREATE SCHEMA teste2;

------ DROP DE SEQUENCES ------
DROP SEQUENCE tabela3_teste_seq CASCADE;
DROP SEQUENCE tabela4_id_seq CASCADE;
DROP SEQUENCE tabela5_id_seq CASCADE;

------ SET SCHEMAS ------
SET search_path TO public;

------ DROP DE TABELAS ------
DROP TABLE tabela4 CASCADE;
DROP TABLE tabela5 CASCADE;
DROP TABLE teste CASCADE;------ CREATE DE SEQUENCES ------
CREATE SEQUENCE log_alteracoes_codlog_seq;
CREATE SEQUENCE tabela10_cd_codigo_seq;
CREATE SEQUENCE tabela11_cd_codigo_seq;
CREATE SEQUENCE teste1.teste_cd_codigo_seq;

------ CREATE DAS TABELAS ------
CREATE TABLE bid_hist 
( 
	codbid int4 NOT NULL , 
	codbidtransp int4 NOT NULL , 
	dta date NOT NULL , 
	dtavigencia date NOT NULL , 
	embarques _int4 DEFAULT '{}'::integer[] , 
	ofertas _int4 DEFAULT '{}'::integer[] , 
	qtdofertado numeric NOT NULL DEFAULT 0 , 
	qtdrealizado numeric NOT NULL DEFAULT 0 , 
	qtdrecusado numeric NOT NULL DEFAULT 0 
);
CREATE TABLE bid_hist_20150 
( 
	codbid int4 NOT NULL , 
	codbidtransp int4 NOT NULL , 
	dta date NOT NULL , 
	dtavigencia date NOT NULL , 
	embarques _int4 DEFAULT '{}'::integer[] , 
	ofertas _int4 DEFAULT '{}'::integer[] , 
	qtdofertado numeric NOT NULL DEFAULT 0 , 
	qtdrealizado numeric NOT NULL DEFAULT 0 , 
	qtdrecusado numeric NOT NULL DEFAULT 0 
);
CREATE TABLE bid_hist_201509 
( 
	codbid int4 NOT NULL , 
	codbidtransp int4 NOT NULL , 
	dta date NOT NULL , 
	dtavigencia date NOT NULL , 
	embarques _int4 DEFAULT '{}'::integer[] , 
	qtdofertado numeric NOT NULL DEFAULT 0 , 
	qtdrealizado numeric NOT NULL DEFAULT 0 , 
	qtdrecusado numeric NOT NULL DEFAULT 0 
);
CREATE TABLE capitals 
( 
	altitude int4 , 
	name text , 
	population float8 , 
	state bpchar 
);
CREATE TABLE cities 
( 
	altitude int4 , 
	name text , 
	population float8 
);
CREATE TABLE log_alteracoes_20150803_0809_w32 
( 
	codlog int4 NOT NULL DEFAULT nextval('log_alteracoes_codlog_seq'::regclass) , 
	codusr int4 , 
	data_alteracao timestamptz , 
	nome_chave varchar (255) NOT NULL , 
	tabela varchar (100) NOT NULL , 
	tipo int4 , 
	valor_chave varchar (255) NOT NULL 
);
CREATE TABLE sal_emp 
( 
	bigintarray _int8 , 
	bitarray _bit , 
	bitarray1 _varbit , 
	bits bit , 
	booleano bool , 
	booleanoarray _bool , 
	box box , 
	boxarray _box , 
	bytea bytea , 
	byteaarray _bytea , 
	chara bpchar , 
	chararray _bpchar , 
	cidr cidr , 
	cidrarray _cidr , 
	circle circle , 
	circlearray _circle , 
	datearray _date , 
	dates date , 
	decimalarray _numeric , 
	decimale numeric , 
	floatarray _float8 , 
	floate float8 , 
	floate1 float8 , 
	inet inet , 
	inetarray _inet , 
	integerarray _int4 , 
	intervalarray _interval , 
	intervale interval , 
	len interval , 
	line line , 
	linearray _line , 
	lseg lseg , 
	lsegarray _lseg , 
	macaddr macaddr , 
	macaddrarrary _macaddr , 
	money money , 
	moneyarray _money , 
	numerico numeric , 
	numerico1 numeric (8,0) , 
	numerico2 numeric (5,2) , 
	numericoarray _numeric , 
	numericoarray1 _numeric , 
	path path , 
	patharray _path , 
	point point , 
	pointarray _point , 
	polygon polygon , 
	polygonarray _polygon , 
	realarray _float4 , 
	reale float4 , 
	smallintarray _int2 , 
	smallinte int2 , 
	stamp timestamp , 
	stamp1 timestamp , 
	stamp1array _timestamp , 
	stampnozone timestamp , 
	stampnozonearray _timestamp , 
	stampzone timestamptz , 
	stampzonearray _timestamptz , 
	tempo time , 
	tempo1 time , 
	tempo1array _time , 
	temponozone time , 
	temponozonearray _time , 
	tempozone timetz , 
	tempozonearray _timetz , 
	textarray _text , 
	texto text , 
	tsquery tsquery , 
	tsqueryarray _tsquery , 
	tsvector tsvector , 
	tsvectorarray _tsvector , 
	txid_snapshot txid_snapshot , 
	txid_snapshotarray _txid_snapshot , 
	uuid uuid , 
	uuidarray _uuid , 
	varcahar varchar (100) , 
	varchararray _varchar , 
	xmle xml , 
	xmlearray _xml 
);
CREATE TABLE tabela10 
( 
	cd_codigo int8 NOT NULL DEFAULT nextval('tabela10_cd_codigo_seq'::regclass) , 
	id_identity int8 , 
	nm_nome varchar (50) NOT NULL DEFAULT 'eu'::character varying , 
	nr_numrero numeric (10,2) 
);
CREATE TABLE tabela11 
( 
	cd_codigo int8 NOT NULL DEFAULT nextval('tabela11_cd_codigo_seq'::regclass) , 
	nm_nome varchar (50) NOT NULL DEFAULT 'eu'::character varying 
);
CREATE TABLE tabela12 
( 
	cd_codigo int8 NOT NULL DEFAULT nextval('tabela10_cd_codigo_seq'::regclass) , 
	id_identity int8 , 
	nm_nome varchar (50) NOT NULL DEFAULT 'eu'::character varying 
);
CREATE TABLE teste1 
( 
	cd_codigo int8 NOT NULL DEFAULT nextval('teste1.teste_cd_codigo_seq'::regclass) , 
	nm_nome varchar (100) NOT NULL DEFAULT 'exemplo'::character varying , 
	nr_numero numeric (8,5) NOT NULL DEFAULT 10.0 
);
CREATE TABLE tictactoe 
( 
	squares _int4 
);

------ DROP DAS COLUNAS ------
ALTER TABLE tabela3 DROP COLUMN cd1_codigo CASCADE;
ALTER TABLE tabela3 DROP COLUMN cod1_codigo CASCADE;
ALTER TABLE tabela3 DROP COLUMN id1_identity CASCADE;
ALTER TABLE tabela3 DROP COLUMN mais1 CASCADE;
ALTER TABLE tabela3 DROP COLUMN mais2 CASCADE;
ALTER TABLE tabela3 DROP COLUMN mais3 CASCADE;
ALTER TABLE tabela3 DROP COLUMN mais4 CASCADE;
ALTER TABLE tabela3 DROP COLUMN mais5 CASCADE;
ALTER TABLE tabela3 DROP COLUMN mais6 CASCADE;
ALTER TABLE tabela3 DROP COLUMN mais7 CASCADE;

------ CREATE DE SEQUENCES ------
CREATE SEQUENCE tabela3_id2_sq;

------ ADD DAS COLUNAS ------
ALTER TABLE tabela1 ADD COLUMN nr_numero
	numeric (8,1) 
	DEFAULT 30 ;

ALTER TABLE tabela1 ADD COLUMN tm
	timestamptz ;

ALTER TABLE tabela3 ADD COLUMN id2_identity
	int8 
	DEFAULT nextval('tabela3_id2_sq'::regclass) ;

ALTER TABLE tabela3 ADD COLUMN nm_sobrenome
	varchar (100) 
	NOT NULL 
	DEFAULT 'teste'::character varying ;

ALTER TABLE tabela3 ADD COLUMN nr_cardinal
	int8 ;

ALTER TABLE tabela3 ADD COLUMN nr_numero
	numeric (8,0) 
	NOT NULL 
	DEFAULT nextval('tabela3_id_identity_seq'::regclass) ;


------ SET DE SEQUENCES ------
SELECT setval('tabela3_id2_sq', MAX(id2_identity)) FROM tabela3;
SELECT setval('tabela3_id_identity_seq', MAX(nr_numero)) FROM tabela3;

------ CREATE DE SEQUENCES ------
CREATE SEQUENCE tabela3_cd2_codigo_sq;

------ ALTER DAS COLUNAS ------

ALTER TABLE tabela1
	ALTER COLUMN nm_nome DROP DEFAULT, 
	ALTER COLUMN nm_nome SET DEFAULT 'teste'::character varying, 
	ALTER COLUMN nm_nome DROP NOT NULL, 
	ALTER COLUMN nm_nome TYPE character varying USING nm_nome::character varying, 
	ALTER COLUMN nm_nome TYPE character varying(20); 

ALTER TABLE tabela2
	ALTER COLUMN nm_nome DROP DEFAULT, 
	ALTER COLUMN nm_nome SET DEFAULT NULL::character varying, 
	ALTER COLUMN nm_nome DROP NOT NULL, 
	ALTER COLUMN nm_nome TYPE character varying USING nm_nome::character varying, 
	ALTER COLUMN nm_nome TYPE character varying(200); 

ALTER TABLE tabela3
	ALTER COLUMN cd2_codigo DROP DEFAULT, 
	ALTER COLUMN cd2_codigo SET DEFAULT nextval('tabela3_cd2_codigo_sq'::regclass); 

ALTER TABLE tabela3
	ALTER COLUMN nm_nome DROP DEFAULT, 
	ALTER COLUMN nm_nome SET DEFAULT 'teste'::character varying, 
	ALTER COLUMN nm_nome SET NOT NULL, 
	ALTER COLUMN nm_nome TYPE character varying USING nm_nome::character varying, 
	ALTER COLUMN nm_nome TYPE character varying(100);

------ SET DE SEQUENCES ------
SELECT setval('tabela3_cd2_codigo_sq', MAX(cd2_codigo)) FROM tabela3;

------ SET SCHEMAS ------
SET search_path TO teste;

------ DROP DE TABELAS ------------ CREATE DE SEQUENCES ------

------ CREATE DAS TABELAS ------

------ DROP DAS COLUNAS ------

------ CREATE DE SEQUENCES ------

------ ADD DAS COLUNAS ------

------ CREATE DE SEQUENCES ------

------ ALTER DAS COLUNAS ----;

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;