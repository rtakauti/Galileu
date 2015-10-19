

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

-------------------- SET DA SEQUENCE --------------------
SELECT setval('teste1.tabela1_cd_codigo_seq', MAX(cd_codigo)) FROM tabela1;

CREATE TABLE tabela2
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.tabela2_cd_codigo_seq'::regclass)
);

-------------------- SET DA SEQUENCE --------------------
SELECT setval('teste1.tabela2_cd_codigo_seq', MAX(cd_codigo)) FROM tabela2;

CREATE TABLE tabela3
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.tabela3_cd_codigo_seq'::regclass),
	nm_nome character varying (100) NOT NULL DEFAULT 'teste'::character varying
);

-------------------- SET DA SEQUENCE --------------------
SELECT setval('teste1.tabela3_cd_codigo_seq', MAX(cd_codigo)) FROM tabela3;

CREATE TABLE tabela4
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.tabela4_cd_codigo_seq'::regclass),
	nm_nome character varying (100) DEFAULT 'eu'::character varying
);

-------------------- SET DA SEQUENCE --------------------
SELECT setval('teste1.tabela4_cd_codigo_seq', MAX(cd_codigo)) FROM tabela4;

CREATE TABLE tabela5
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.tabela5_cd_codigo_seq'::regclass),
	nm_nome character varying (100) NOT NULL DEFAULT 'eu'::character varying
);

-------------------- SET DA SEQUENCE --------------------
SELECT setval('teste1.tabela5_cd_codigo_seq', MAX(cd_codigo)) FROM tabela5;

CREATE TABLE teste
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.teste_cd_codigo_seq'::regclass),
	nm_nome character varying (100) NOT NULL DEFAULT 'exemplo'::character varying,
	nr_numero numeric(8,5) NOT NULL DEFAULT 10.0
);

-------------------- SET DA SEQUENCE --------------------
SELECT setval('teste1.teste_cd_codigo_seq', MAX(cd_codigo)) FROM teste;



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

-------------------- SET DA SEQUENCE --------------------
SELECT setval('teste2.tabela1_cd_codigo_seq', MAX(cd_codigo)) FROM tabela1;



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
CREATE SEQUENCE public.tabela3_cd2_codigo_sq;
CREATE SEQUENCE public.tabela3_id2_sq;

-------------------- CREATE TABLE --------------------

CREATE TABLE capitals
(
	altitude integer,
	name text,
	population double precision,
	state character (2)
);

CREATE TABLE cities
(
	altitude integer,
	name text,
	population double precision
);

CREATE TABLE log_alteracoes_20150803_0809_w32
(
	codlog integer NOT NULL DEFAULT nextval('log_alteracoes_codlog_seq'::regclass),
	codusr integer,
	data_alteracao timestamp with time zone,
	nome_chave character varying (255) NOT NULL,
	tabela character varying (100) NOT NULL,
	tipo integer,
	valor_chave character varying (255) NOT NULL
);

-------------------- SET DA SEQUENCE --------------------
SELECT setval('public.log_alteracoes_codlog_seq', MAX(codlog)) FROM log_alteracoes_20150803_0809_w32;

CREATE TABLE sal_emp
(
	name text,
	pay_by_quarter ARRAY,
	schedule ARRAY
);

-------------------- SET DA SEQUENCE --------------------
SELECT setval('public.log_alteracoes_codlog_seq', MAX(codlog)) FROM log_alteracoes_20150803_0809_w32;

CREATE TABLE tabela10
(
	cd_codigo bigint NOT NULL DEFAULT nextval('tabela10_cd_codigo_seq'::regclass),
	id_identity bigint,
	nm_nome character varying (50) NOT NULL DEFAULT 'eu'::character varying,
	nr_numrero numeric(10,2)
);

-------------------- SET DA SEQUENCE --------------------
SELECT setval('public.tabela10_cd_codigo_seq', MAX(cd_codigo)) FROM tabela10;

CREATE TABLE tabela11
(
	cd_codigo bigint NOT NULL DEFAULT nextval('tabela11_cd_codigo_seq'::regclass),
	nm_nome character varying (50) NOT NULL DEFAULT 'eu'::character varying
);

-------------------- SET DA SEQUENCE --------------------
SELECT setval('public.tabela11_cd_codigo_seq', MAX(cd_codigo)) FROM tabela11;

CREATE TABLE tabela12
(
	cd_codigo bigint NOT NULL DEFAULT nextval('tabela10_cd_codigo_seq'::regclass),
	id_identity bigint,
	nm_nome character varying (50) NOT NULL DEFAULT 'eu'::character varying
);

-------------------- SET DA SEQUENCE --------------------
SELECT setval('public.tabela10_cd_codigo_seq', MAX(cd_codigo)) FROM tabela12;

-------------------- CREATE DA SEQUENCE --------------------
CREATE SEQUENCE public.teste1.teste_cd_codigo_seq;

CREATE TABLE teste1
(
	cd_codigo bigint NOT NULL DEFAULT nextval('teste1.teste_cd_codigo_seq'::regclass),
	nm_nome character varying (100) NOT NULL DEFAULT 'exemplo'::character varying,
	nr_numero numeric(8,5) NOT NULL DEFAULT 10.0
);

-------------------- SET DA SEQUENCE --------------------
SELECT setval('public.teste1.teste_cd_codigo_seq', MAX(cd_codigo)) FROM teste1;



-------------------- ALTER SCHEMA --------------------

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO teste;

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;