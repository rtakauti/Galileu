

------------------ DATABASE: rubens_test ------------------


------ DEV SCHEMAS ------
	-- public
	-- teste
	-- teste1
	-- teste2

------ HOMOLOG SCHEMAS ------
	-- public
	-- teste



-------------------- CREATE SCHEMA --------------------
CREATE SCHEMA teste1;

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO teste1;

--------------------  CREATE DE SEQUENCES -------------------- 
CREATE SEQUENCE teste1.tabela1_cd_codigo_seq;
CREATE SEQUENCE teste1.tabela2_cd_codigo_seq;
CREATE SEQUENCE teste1.tabela3_cd_codigo_seq;
CREATE SEQUENCE teste1.tabela4_cd_codigo_seq;
CREATE SEQUENCE teste1.tabela5_cd_codigo_seq;
CREATE SEQUENCE teste1.teste_cd_codigo_seq;

-------------------- CREATE TABLE --------------------

CREATE TABLE tabela1
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.tabela1_cd_codigo_seq'::regclass)
);

CREATE TABLE tabela2
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.tabela2_cd_codigo_seq'::regclass)
);

CREATE TABLE tabela3
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.tabela3_cd_codigo_seq'::regclass),
	nm_nome character varying (100) NOT NULL DEFAULT 'teste'::character varying
);

CREATE TABLE tabela4
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.tabela4_cd_codigo_seq'::regclass),
	nm_nome character varying (100) DEFAULT 'eu'::character varying
);

CREATE TABLE tabela5
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.tabela5_cd_codigo_seq'::regclass),
	nm_nome character varying (100) NOT NULL DEFAULT 'eu'::character varying
);

CREATE TABLE teste
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.teste_cd_codigo_seq'::regclass),
	nm_nome character varying (100) NOT NULL DEFAULT 'exemplo'::character varying,
	nr_numero numeric (8,5)  NOT NULL DEFAULT 10.0
);



-------------------- CREATE SCHEMA --------------------
CREATE SCHEMA teste2;

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO teste2;

--------------------  CREATE DE SEQUENCES -------------------- 
CREATE SEQUENCE teste2.tabela1_cd_codigo_seq;

-------------------- CREATE TABLE --------------------

CREATE TABLE tabela1
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste2.tabela1_cd_codigo_seq'::regclass)
);



-------------------- ALTER SCHEMA --------------------

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO public;

--------------------  DROP DE SEQUENCES -------------------- 
DROP SEQUENCE public.tabela3_teste_seq CASCADE;
DROP SEQUENCE public.tabela4_id_seq CASCADE;
DROP SEQUENCE public.tabela5_id_seq CASCADE;
DROP SEQUENCE public.teste_cd_codigo_seq CASCADE;

--------------------  CREATE DE SEQUENCES -------------------- 
CREATE SEQUENCE public.log_alteracoes_codlog_seq;
CREATE SEQUENCE public.tabela10_cd_codigo_seq;
CREATE SEQUENCE public.tabela11_cd_codigo_seq;
CREATE SEQUENCE public.tabela20_cd_codigo_seq;
CREATE SEQUENCE public.tabela3_cd_codigo_seq;
CREATE SEQUENCE public.tabela3_id_identity_seq;

-------------------- CREATE TABLE --------------------

CREATE TABLE cities
(
	altitude integer,
	name text,
	population double precision
);

CREATE TABLE sal_emp
(
	bigintarray  bigint [] ,
	bitarray  bit (1) [] ,
	bitarray1  bit varying [] ,
	bits bit (1),
	booleano boolean,
	booleanoarray  boolean [] ,
	box box,
	boxarray  box [] ,
	bytea bytea,
	byteaarray  bytea [] ,
	chara character (500),
	chararray  character (1) [] ,
	cidr cidr,
	cidrarray  cidr [] ,
	circle circle,
	circlearray  circle [] ,
	datearray  date [] ,
	dates date,
	decimalarray  numeric [] ,
	decimale numeric,
	floatarray  double precision [] ,
	floate double precision,
	floate1 double precision,
	inet inet,
	inetarray  inet [] ,
	integerarray  integer [] ,
	intervalarray  interval [] ,
	intervale interval (3) ,
	len interval HOUR TO MINUTE ,
	line line,
	linearray  line [] ,
	lseg lseg,
	lsegarray  lseg [] ,
	macaddr macaddr,
	macaddrarrary  macaddr [] ,
	money money,
	moneyarray  money [] ,
	numerico numeric,
	numerico1 numeric (8,0) ,
	numerico2 numeric (5,2) ,
	numericoarray  numeric [] ,
	numericoarray1  numeric [] ,
	path path,
	patharray  path [] ,
	point point,
	pointarray  point [] ,
	polygon polygon,
	polygonarray  polygon [] ,
	realarray  real [] ,
	reale real,
	smallintarray  smallint [] ,
	smallinte smallint,
	stamp timestamp (6) without time zone,
	stamp1 timestamp (3) without time zone,
	stamp1array  time without time zone [] ,
	stampnozone timestamp (1) without time zone,
	stampnozonearray  time without time zone [] ,
	stampzone timestamp (1) with time zone,
	stampzonearray  time with time zone [] ,
	tempo time (6) without time zone,
	tempo1 time (3) without time zone,
	tempo1array  time without time zone [] ,
	temponozone time (1) without time zone,
	temponozonearray  time without time zone [] ,
	tempozone time (2) with time zone,
	tempozonearray  time with time zone [] ,
	textarray  text [] ,
	texto text,
	tsquery tsquery,
	tsqueryarray  tsquery [] ,
	tsvector tsvector,
	tsvectorarray  tsvector [] ,
	txid_snapshot txid_snapshot,
	txid_snapshotarray  txid_snapshot [] ,
	uuid uuid,
	uuidarray  uuid [] ,
	varcahar character varying (100),
	varchararray  varchar [] ,
	xmle xml,
	xmlearray  xml [] 
);

CREATE TABLE tabela10
(
	cd_codigo bigint NOT NULL DEFAULT nextval('tabela10_cd_codigo_seq'::regclass),
	id_identity bigint,
	nm_nome character varying (50) NOT NULL DEFAULT 'eu'::character varying,
	nr_numrero numeric (10,2) 
);

CREATE TABLE tabela11
(
	cd_codigo bigint NOT NULL DEFAULT nextval('tabela11_cd_codigo_seq'::regclass),
	nm_nome character varying (50) NOT NULL DEFAULT 'eu'::character varying
);

CREATE TABLE tabela12
(
	cd_codigo bigint NOT NULL DEFAULT nextval('tabela10_cd_codigo_seq'::regclass),
	id_identity bigint,
	nm_nome character varying (50) NOT NULL DEFAULT 'eu'::character varying
);

CREATE TABLE tabela3
(
	cd1_codigo bigint NOT NULL,
	cd2_codigo bigint,
	cd_codigo bigint NOT NULL DEFAULT nextval('tabela3_cd_codigo_seq'::regclass),
	cod1_codigo bigint,
	ds_descricao text,
	id1_identity bigint,
	id_identity bigint NOT NULL DEFAULT nextval('tabela3_id_identity_seq'::regclass),
	nm_nome text,
CONSTRAINT cd1_id1_fk FOREIGN KEY(id1_identity)
	REFERENCES tabela1  (cd_codigo)  MATCH FULL 
	ON UPDATE NO ACTION  ON DELETE NO ACTION ,
CONSTRAINT ck_igual CHECK() (cd_codigo = id_identity) ,
CONSTRAINT fk_tabela1 FOREIGN KEY(cd1_codigo)
	REFERENCES tabela1  (cd_codigo)  MATCH SIMPLE 
	ON UPDATE CASCADE  ON DELETE CASCADE ,
CONSTRAINT fk_tabela2 FOREIGN KEY(cd2_codigo)
	REFERENCES tabela2  (cd_codigo)  MATCH SIMPLE 
	ON UPDATE NO ACTION  ON DELETE NO ACTION ,
CONSTRAINT pk_tabela3 PRIMARY KEY(cd1_codigo, cd_codigo),
CONSTRAINT uq_descricao UNIQUE(ds_descricao)
);

CREATE TABLE teste1
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.teste_cd_codigo_seq'::regclass),
	nm_nome character varying (100) NOT NULL DEFAULT 'exemplo'::character varying,
	nr_numero numeric (8,5)  NOT NULL DEFAULT 10.0
);

CREATE TABLE tictactoe
(
	squares  integer [] 
);



-------------------- ALTER SCHEMA --------------------

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO teste;

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;