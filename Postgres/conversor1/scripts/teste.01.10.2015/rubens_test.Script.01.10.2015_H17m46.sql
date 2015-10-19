

------------------ DATABASE: rubens_test ------------------


------ DEV SCHEMAS ------
	-- public
	-- teste
	-- teste1
	-- teste2

------ HOMOLOG SCHEMAS ------
	-- public
	-- teste

------ CREATE DE SCHEMAS ------
CREATE SCHEMA teste1;
CREATE SCHEMA teste2;

------ CREATE DE SEQUENCES ------
CREATE SEQUENCE teste1.tabela1_cd_codigo_seq;
CREATE SEQUENCE teste1.tabela2_cd_codigo_seq;
CREATE SEQUENCE teste1.tabela3_cd_codigo_seq;
CREATE SEQUENCE teste1.tabela4_cd_codigo_seq;
CREATE SEQUENCE teste1.tabela5_cd_codigo_seq;
CREATE SEQUENCE teste1.teste_cd_codigo_seq;

------ SET SCHEMAS ------
SET search_path TO teste1;

---------- CREATE TABLE ----------CREATE TABLE tabela1
 int8 NOT NULL bigint DEFAULT nextval('teste1.tabela1_cd_codigo_seq'::regclass)
CREATE TABLE tabela2
 int8 NOT NULL bigint DEFAULT nextval('teste1.tabela2_cd_codigo_seq'::regclass)
CREATE TABLE tabela3
 int8 NOT NULL bigint DEFAULT nextval('teste1.tabela3_cd_codigo_seq'::regclass)
 varchar (100) NOT NULL character varying DEFAULT 'teste'::character varying
CREATE TABLE tabela4
 int8 NOT NULL bigint DEFAULT nextval('teste1.tabela4_cd_codigo_seq'::regclass)
 varchar (100) character varying DEFAULT 'eu'::character varying
CREATE TABLE tabela5
 int8 NOT NULL bigint DEFAULT nextval('teste1.tabela5_cd_codigo_seq'::regclass)
 varchar (100) NOT NULL character varying DEFAULT 'eu'::character varying
CREATE TABLE teste
 int8 NOT NULL bigint DEFAULT nextval('teste1.teste_cd_codigo_seq'::regclass)
 varchar (100) NOT NULL character varying DEFAULT 'exemplo'::character varying
 numeric (8,5) NOT NULL numeric DEFAULT 10.0


------ CREATE DE SEQUENCES ------
CREATE SEQUENCE teste2.tabela1_cd_codigo_seq;

------ SET SCHEMAS ------
SET search_path TO teste2;

---------- CREATE TABLE ----------CREATE TABLE tabela1
 int8 NOT NULL bigint DEFAULT nextval('teste2.tabela1_cd_codigo_seq'::regclass)


---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;