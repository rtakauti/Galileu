

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

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;