

------------------ DATABASE: rubens_test ------------------


------ DEV SCHEMAS ------
	-- public

------ HOMOLOG SCHEMAS ------
	-- public
	-- teste

------ DROP DE SCHEMAS ------
DROP SCHEMA IF EXISTS teste CASCADE;

------ CREATE DE SCHEMAS ------

------ DROP DE SEQUENCES ------
DROP SEQUENCE tabela3_teste_seq CASCADE;
DROP SEQUENCE tabela4_id_seq CASCADE;
DROP SEQUENCE tabela5_id_seq CASCADE;

------ SET SCHEMAS ------
SET search_path TO public;

------ DROP DE TABELAS ------
DROP TABLE tabela4 CASCADE;
DROP TABLE tabela5 CASCADE;

------ SET SCHEMAS ------
SET search_path TO teste;

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;

------------------ DATABASE: rubens_test ------------------


------ DEV SCHEMAS ------
	-- public

------ HOMOLOG SCHEMAS ------
	-- public
	-- teste

------ DROP DE SCHEMAS ------
DROP SCHEMA IF EXISTS teste CASCADE;

------ CREATE DE SCHEMAS ------

------ DROP DE SEQUENCES ------
DROP SEQUENCE tabela3_teste_seq CASCADE;
DROP SEQUENCE tabela4_id_seq CASCADE;
DROP SEQUENCE tabela5_id_seq CASCADE;

------ SET SCHEMAS ------
SET search_path TO public;

------ DROP DE TABELAS ------
DROP TABLE tabela4 CASCADE;
DROP TABLE tabela5 CASCADE;------ CREATE DE SEQUENCES ------
CREATE SEQUENCE tabela10_cd_codigo_seq;
CREATE SEQUENCE tabela11_cd_codigo_seq;

------ CREATE DAS TABELAS ------
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

------ SET SCHEMAS ------
SET search_path TO teste;

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;