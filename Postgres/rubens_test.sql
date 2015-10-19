CREATE TABLE log_transicao
(
  id bigserial,
  tb_origem character varying(200) NOT NULL,
  tb_destino character varying(200) NOT NULL,
  msg text,
  data timestamp without time zone,
  status character varying(20) NOT NULL,
  CONSTRAINT log_pk PRIMARY KEY (id)
);

--ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE varchar(20) USING nr_numero::varchar
--ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE char USING nr_numero::char
--ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE text USING nr_numero::text
--ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE character varying(200)
-- ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE numeric(10) USING nr_numero::numeric;


/*
ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE numeric(8,0) USING nr_numero::numeric;
ALTER TABLE tabela1 ALTER COLUMN nr_numero DROP DEFAULT;
ALTER TABLE tabela1 ALTER COLUMN nr_numero SET NOT NULL;
*/
---------------
--ALTER TABLE tabela1 ALTER COLUMN nr_numero SET DEFAULT 'teste'

select distinct * from information_schema.columns where table_schema = 'public' and table_name = 'tabela1' and column_name= 'nr_numero'

insert into tabela1(cd_codigo, nm_nome, ds_descricao, dt_data, nr_numero) values (DEFAULT,'Rubens', 'teste', now(), '30.5');

select SUM(nr_numero) from tabela1

select * from tabela1

SELECT c.relname FROM pg_class c WHERE c.relkind = 'S';
SELECT * FROM pg_class c WHERE c.relkind = 'S';
SELECT * FROM pg_class;
