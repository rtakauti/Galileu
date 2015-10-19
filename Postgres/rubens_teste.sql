
/*
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
*/

-- ALTER TABLE tabela1 ALTER COLUMN nr_numero DROP DEFAULT
-- ALTER TABLE tabela1 ALTER COLUMN nr_numero SET DEFAULT 30
-- ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE numeric(10,2) USING nr_numero::numeric;
-- ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE numeric(10) USING nr_numero::numeric;



-- truncate table log_transicao
-- drop table log_transicao
select * from log_transicao
