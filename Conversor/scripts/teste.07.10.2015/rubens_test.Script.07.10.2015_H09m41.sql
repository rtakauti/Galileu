

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



-------------------- CREATE SCHEMA --------------------
CREATE SCHEMA teste2;

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO teste2;

--------------------  CREATE DE SEQUENCES -------------------- 
CREATE SEQUENCE teste2.tabela1_cd_codigo_seq;



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



-------------------- ALTER SCHEMA --------------------

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO teste;

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;

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



-------------------- CREATE SCHEMA --------------------
CREATE SCHEMA teste2;

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO teste2;

--------------------  CREATE DE SEQUENCES -------------------- 
CREATE SEQUENCE teste2.tabela1_cd_codigo_seq;



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



-------------------- ALTER SCHEMA --------------------

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO teste;

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;