


------------- DATABASE: rubens_test   TABELA: tabela3 -------------


------ DROP DE COLUNAS ------
ALTER TABLE tabela3 DROP COLUMN cd1_codigo;
ALTER TABLE tabela3 DROP COLUMN id1_identity;
ALTER TABLE tabela3 DROP COLUMN cod1_codigo;
ALTER TABLE tabela3 DROP COLUMN mais1;
ALTER TABLE tabela3 DROP COLUMN mais2;
ALTER TABLE tabela3 DROP COLUMN mais3;
ALTER TABLE tabela3 DROP COLUMN mais4;
ALTER TABLE tabela3 DROP COLUMN mais5;
ALTER TABLE tabela3 DROP COLUMN mais6;
ALTER TABLE tabela3 DROP COLUMN mais7;

------ DROP DE SEQUENCES ------
DROP SEQUENCE tabela3_teste_seq;
DROP SEQUENCE tabela4_id_seq;
DROP SEQUENCE tabela5_id_seq;

-- SET DE SEQUENCE: cd2_codigo --
CREATE SEQUENCE tabela3_cd2_codigo_sq;
SELECT setval('tabela3_cd2_codigo_sq', max(cd2_codigo)) FROM tabela3;

-- CAMPO: cd2_codigo --
-- ESTADO ANTERIOR: column_default = null  -------
ALTER TABLE tabela3 
	 ALTER COLUMN cd2_codigo DROP DEFAULT, 
	 ALTER COLUMN cd2_codigo SET DEFAULT nextval('tabela3_cd2_codigo_sq');

-- SET DE SEQUENCE: nr_numero -- 
SELECT setval('tabela3_id_identity_seq', max(nr_numero)) FROM tabela3;

-- CAMPO: nr_numero --
ALTER TABLE tabela3 ADD COLUMN nr_numero 
	 NUMERIC(8,0)
	 DEFAULT existe nextval('tabela3_id_identity_seq')
	 NOT NULL;

-- CAMPO: nm_nome --
-- ESTADO ANTERIOR: column_default = null, is_nullable = YES, udt_name = text  -------
ALTER TABLE tabela3 
	 ALTER COLUMN nm_nome DROP DEFAULT, 
	 ALTER COLUMN nm_nome SET DEFAULT 'teste'::character varying, 
	 ALTER COLUMN nm_nome SET NOT NULL, 
	 ALTER COLUMN nm_nome TYPE character varying USING nm_nome::character varying, 
	 ALTER COLUMN nm_nome TYPE character varying(100);

-- CAMPO: nm_sobrenome --
ALTER TABLE tabela3 ADD COLUMN nm_sobrenome 
	 VARCHAR(100)
	 DEFAULT 'teste'::character varying
	 NOT NULL;

-- CAMPO: nr_cardinal --
ALTER TABLE tabela3 ADD COLUMN nr_cardinal 
	 INT8;

-- SET DE SEQUENCE: id2_identity --
CREATE SEQUENCE tabela3_id2_sq;
SELECT setval('tabela3_id2_sq', max(id2_identity)) FROM tabela3;

-- CAMPO: id2_identity --
ALTER TABLE tabela3 ADD COLUMN id2_identity 
	 INT8
	 DEFAULT nao nextval('tabela3_id2_sq');




------------- DATABASE: rubens_test   TABELA: tabela3 -------------


------ DROP DE COLUNAS ------
ALTER TABLE tabela3 DROP COLUMN cd1_codigo;
ALTER TABLE tabela3 DROP COLUMN id1_identity;
ALTER TABLE tabela3 DROP COLUMN cod1_codigo;
ALTER TABLE tabela3 DROP COLUMN mais1;
ALTER TABLE tabela3 DROP COLUMN mais2;
ALTER TABLE tabela3 DROP COLUMN mais3;
ALTER TABLE tabela3 DROP COLUMN mais4;
ALTER TABLE tabela3 DROP COLUMN mais5;
ALTER TABLE tabela3 DROP COLUMN mais6;
ALTER TABLE tabela3 DROP COLUMN mais7;

------ DROP DE SEQUENCES ------
DROP SEQUENCE tabela3_teste_seq;
DROP SEQUENCE tabela4_id_seq;
DROP SEQUENCE tabela5_id_seq;

-- SET DE SEQUENCE: cd2_codigo --
CREATE SEQUENCE tabela3_cd2_codigo_sq;
SELECT setval('tabela3_cd2_codigo_sq', max(cd2_codigo)) FROM tabela3;

-- CAMPO: cd2_codigo --
-- ESTADO ANTERIOR: column_default = null  -------
ALTER TABLE tabela3 
	 ALTER COLUMN cd2_codigo DROP DEFAULT, 
	 ALTER COLUMN cd2_codigo SET DEFAULT nextval('tabela3_cd2_codigo_sq');

-- SET DE SEQUENCE: nr_numero -- 
SELECT setval('tabela3_id_identity_seq', max(nr_numero)) FROM tabela3;

-- CAMPO: nr_numero --
ALTER TABLE tabela3 ADD COLUMN nr_numero 
	 NUMERIC(8,0)
	 DEFAULT existe nextval('tabela3_id_identity_seq')
	 NOT NULL;

-- CAMPO: nm_nome --
-- ESTADO ANTERIOR: column_default = null, is_nullable = YES, udt_name = text  -------
ALTER TABLE tabela3 
	 ALTER COLUMN nm_nome DROP DEFAULT, 
	 ALTER COLUMN nm_nome SET DEFAULT 'teste'::character varying, 
	 ALTER COLUMN nm_nome SET NOT NULL, 
	 ALTER COLUMN nm_nome TYPE character varying USING nm_nome::character varying, 
	 ALTER COLUMN nm_nome TYPE character varying(100);

-- CAMPO: nm_sobrenome --
ALTER TABLE tabela3 ADD COLUMN nm_sobrenome 
	 VARCHAR(100)
	 DEFAULT 'teste'::character varying
	 NOT NULL;

-- CAMPO: nr_cardinal --
ALTER TABLE tabela3 ADD COLUMN nr_cardinal 
	 INT8;

-- SET DE SEQUENCE: id2_identity --
CREATE SEQUENCE tabela3_id2_sq;
SELECT setval('tabela3_id2_sq', max(id2_identity)) FROM tabela3;

-- CAMPO: id2_identity --
ALTER TABLE tabela3 ADD COLUMN id2_identity 
	 INT8
	 DEFAULT nao nextval('tabela3_id2_sq');

