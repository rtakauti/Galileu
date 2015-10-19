

------------------ DATABASE: rubens_test ------------------


------ DROP DE SEQUENCES ------
DROP SEQUENCE tabela3_teste_seq CASCADE;
DROP SEQUENCE tabela4_id_seq CASCADE;
DROP SEQUENCE tabela5_id_seq CASCADE;

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

------ SET SCHEMAS ------
SET search_path TO teste1;

---- CREATE DE TABELAS ----

------------------ DATABASE: rubens_test ------------------


------ DROP DE SEQUENCES ------
DROP SEQUENCE tabela3_teste_seq CASCADE;
DROP SEQUENCE tabela4_id_seq CASCADE;
DROP SEQUENCE tabela5_id_seq CASCADE;

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

------ SET SCHEMAS ------
SET search_path TO teste1;

---- CREATE DE TABELAS ----

------ SET SCHEMAS ------
SET search_path TO teste2;

---- CREATE DE TABELAS ----

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;