

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

);

CREATE TABLE tabela2

);

CREATE TABLE tabela3

);

CREATE TABLE tabela4

);

CREATE TABLE tabela5

);

CREATE TABLE teste

);



-------------------- CREATE SCHEMA --------------------
CREATE SCHEMA teste2;

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO teste2;

--------------------  CREATE DE SEQUENCES -------------------- 
CREATE SEQUENCE teste2.tabela1_cd_codigo_seq;

-------------------- CREATE TABLE --------------------

CREATE TABLE tabela1

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

);

CREATE TABLE sal_emp

);

CREATE TABLE tabela10

);

CREATE TABLE tabela11

);

CREATE TABLE tabela12

);

CREATE TABLE tabela3
(
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

);

CREATE TABLE tictactoe

);



-------------------- ALTER SCHEMA --------------------

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO teste;

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;