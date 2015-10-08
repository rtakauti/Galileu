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

ALTER TABLE tabela1 drop COLUMN nr_numero 
--ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE varchar(20) USING nr_numero::varchar
--ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE char USING nr_numero::char
--ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE text USING nr_numero::text
--ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE character varying(200)
-- ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE numeric(10) USING nr_numero::numeric;


/*

ALTER TABLE tabela1 ALTER COLUMN nm_nome TYPE text USING nm_nome::text;
ALTER TABLE tabela1 ALTER COLUMN nm_nome DROP DEFAULT;
ALTER TABLE tabela1 ALTER COLUMN nm_nome SET NOT NULL;
ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE numeric(10,2) USING nr_numero::numeric;
ALTER TABLE tabela1 ALTER COLUMN nr_numero DROP DEFAULT;
ALTER TABLE tabela1 ALTER COLUMN nr_numero SET NOT NULL;
ALTER TABLE tabela1 DROP COLUMN tm;
ALTER TABLE tabela2 ALTER COLUMN nm_nome TYPE text USING nm_nome::text;
ALTER TABLE tabela2 ALTER COLUMN nm_nome DROP DEFAULT;
ALTER TABLE tabela2 ALTER COLUMN nm_nome SET NOT NULL;

*/
ALTER TABLE tabela1 
	 ALTER COLUMN nm_nome DROP DEFAULT, 
	 ALTER COLUMN nm_nome SET DEFAULT ''teste''::character varying, 
	 ALTER COLUMN nm_nome DROP NOT NULL, 
	 ALTER COLUMN nm_nome TYPE character varying USING nm_nome::character varying, 
	 ALTER COLUMN nm_nome TYPE character varying(20);


--ALTER TABLE tabela1 ALTER COLUMN nr_numero SET DEFAULT 'teste'

-- ALTER TABLE tabela1 DROP COLUMN tm;
-- ALTER TABLE mytable ADD COLUMN mycolumn character varying(50) NOT NULL DEFAULT 'foo';

ALTER TABLE tabela1
    
    ALTER COLUMN nr_numero DROP NOT NULL,
    ALTER COLUMN nr_numero SET NOT NULL,
    ALTER COLUMN nr_numero TYPE numeric(9,0) USING nr_numero::numeric;


select distinct * from information_schema.columns where table_schema = 'public' and table_name = 'tabela1' and column_name= 'nr_numero'

insert into tabela1(cd_codigo, nm_nome, ds_descricao, dt_data, nr_numero) values (DEFAULT,'Rubens', 'teste', now(), '30.5');

select SUM(nr_numero) from tabela1

select * from tabela1

SELECT c.relname FROM pg_class c WHERE c.relkind = 'S';
SELECT * FROM pg_class c WHERE c.relkind = 'S';
SELECT DISTINCT relkind  FROM pg_class;
SELECT *  FROM pg_class WHERE relkind = 'v';


/* retorna as procedures */
SELECT  *
FROM    pg_catalog.pg_namespace n
JOIN    pg_catalog.pg_proc p
ON      p.pronamespace = n.oid
WHERE   n.nspname = 'public'

/*
CREATE OR REPLACE FUNCTION increment1(i INT) RETURNS INT AS $$
    BEGIN
      RETURN i + 1;
    END;
    $$ LANGUAGE plpgsql;
*/

/*
CREATE FUNCTION one1() RETURNS integer AS $$
    SELECT 1 AS result;
$$ LANGUAGE SQL;
*/

SELECT * FROM pg_proc WHERE proname = 'one';

SELECT * FROM information_schema.routines WHERE specific_schema LIKE 'public' AND routine_name LIKE 'one';


/* Constraints  */

SELECT *
FROM information_schema.table_constraints
WHERE constraint_schema = 'public';


SELECT *
FROM information_schema.constraint_column_usage

SELECT *
FROM pg_class
WHERE oid IN (
SELECT indexrelid
FROM pg_index, pg_class
WHERE pg_class.relname='tabela1'
AND pg_class.oid=pg_index.indrelid
AND (   indisunique = 't'
OR indisprimary = 't'
)
);



select * from information_schema.key_column_usage
select constraint_name, column_name, ordinal_position  from information_schema.key_column_usage where table_name = 'tabela3'

create table tabela3 
(
	cd_codigo bigserial not null,
	id_identity bigserial not null,
	ds_descricao text,
	constraint pk_tabela3 primary key (cd_codigo, id_identity)

);

ALTER TABLE TABELA3 ADD COLUMN nr_numero BIGINT;

ALTER TABLE TABELA3 ADD CONSTRAINT FK_TABELA2 FOREIGN KEY (CD2_CODIGO) REFERENCES TABELA2(CD_CODIGO)

ALTER TABLE TABELA3 DROP CONSTRAINT PK_TABELA3;

ALTER TABLE TABELA3 ADD CONSTRAINT PK_TABELA3 PRIMARY KEY (CD1_CODIGO, CD2_CODIGO, CD_CODIGO);

alter table TABELA3
drop constraint FK_TABELA1,
add constraint FK_TABELA1
   foreign key (CD1_CODIGO)
   references TABELA1(CD_CODIGO)
   on delete CASCADE
   on UPDATE CASCADE;

SELECT * FROM information_schema.table_constraints   

-- alter table tabela3 add constraint ck_igual check(cd_codigo = id_identity);


SELECT tc.CONSTRAINT_NAME, tc.constraint_type, KCU.COLUMN_NAME, RC.MATCH_OPTION, RC.UPDATE_RULE, RC.DELETE_RULE, KCU.ORDINAL_POSITION, c.consrc
FROM information_schema.table_constraints tc
LEFT JOIN information_schema.key_column_usage kcu
ON tc.constraint_catalog = kcu.constraint_catalog
AND tc.constraint_schema = kcu.constraint_schema
AND tc.constraint_name = kcu.constraint_name
LEFT JOIN information_schema.referential_constraints rc
ON tc.constraint_catalog = rc.constraint_catalog
AND tc.constraint_schema = rc.constraint_schema
AND tc.constraint_name = rc.constraint_name
LEFT JOIN information_schema.constraint_column_usage ccu
ON rc.unique_constraint_catalog = ccu.constraint_catalog
AND rc.unique_constraint_schema = ccu.constraint_schema
AND rc.unique_constraint_name = ccu.constraint_name
left join pg_constraint c
on tc.CONSTRAINT_NAME = c.conname
WHERE tc.table_name = 'tabela3';



alter table tabela1 add column id_identity bigint;

alter table tabela3 add column id1_identity bigint;

alter table tabela3 drop constraint cd1_id1_fk;

alter table tabela3 add constraint cd1_id1_fk foreign key (id1_identity) references tabela1 (cd_codigo) match full;

alter table tabela3 add constraint uq_descricao unique (ds_descricao);

alter table tabela3 add column nm_nome text;

create unique index index_nome on tabela3(nm_nome) ;

DROP INDEX tabela3_nm_nome_idx;

select * from pg_class where relname = 'index_nome';

SELECT  
c.relname AS table,
f.attname AS column,  
pg_catalog.format_type(f.atttypid,f.atttypmod) AS type,
f.attnotnull AS notnull,  
i.relname as index_name,
CASE  
    WHEN i.oid<>0 THEN 't'  
    ELSE 'f'  
END AS is_index,  
CASE  
    WHEN p.contype = 'p' THEN 't'  
    ELSE 'f'  
END AS primarykey,  
CASE  
    WHEN p.contype = 'u' THEN 't' 
    WHEN p.contype = 'p' THEN 't' 
    ELSE 'f'
END AS uniquekey,
CASE
    WHEN f.atthasdef = 't' THEN d.adsrc
END AS default  
FROM pg_attribute f  
JOIN pg_class c ON c.oid = f.attrelid  
JOIN pg_type t ON t.oid = f.atttypid  
LEFT JOIN pg_attrdef d ON d.adrelid = c.oid AND d.adnum = f.attnum  
LEFT JOIN pg_namespace n ON n.oid = c.relnamespace  
LEFT JOIN pg_constraint p ON p.conrelid = c.oid AND f.attnum = ANY (p.conkey)  
LEFT JOIN pg_class AS g ON p.confrelid = g.oid
LEFT JOIN pg_index AS ix ON f.attnum = ANY(ix.indkey) and c.oid = f.attrelid and c.oid = ix.indrelid 
LEFT JOIN pg_class AS i ON ix.indexrelid = i.oid 
WHERE c.relkind = 'r'::char  
AND n.nspname = 'public'  -- Replace with Schema name 
--AND c.relname = 'nodes'  -- Replace with table name, or Comment this for get all tables
AND f.attnum > 0
ORDER BY c.relname,f.attname;


select * 
FROM pg_attribute f  
JOIN pg_class c ON c.oid = f.attrelid 
where c.relname = 'index_nome';


SELECT  p.proname
FROM    pg_catalog.pg_namespace n
JOIN    pg_catalog.pg_proc p
ON      p.pronamespace = n.oid
WHERE   n.nspname = 'public'
------


SELECT
    * 
FROM
    information_schema.routines 
WHERE
    specific_schema LIKE 'public'
    AND routine_name LIKE 'increment';

    ------------------------


   SELECT view_definition FROM information_schema.views WHERE table_schema = ? AND table_name = ?



SELECT tc.CONSTRAINT_NAME, tc.constraint_type, KCU.COLUMN_NAME, RC.MATCH_OPTION, RC.UPDATE_RULE, RC.DELETE_RULE, KCU.ORDINAL_POSITION, c.consrc,  ccu.table_name AS foreign_table_name,  ccu.column_name AS foreign_column_name 
FROM information_schema.table_constraints tc
LEFT JOIN information_schema.key_column_usage kcu
ON tc.constraint_catalog = kcu.constraint_catalog
AND tc.constraint_schema = kcu.constraint_schema
AND tc.constraint_name = kcu.constraint_name
LEFT JOIN information_schema.referential_constraints rc
ON tc.constraint_catalog = rc.constraint_catalog
AND tc.constraint_schema = rc.constraint_schema
AND tc.constraint_name = rc.constraint_name
LEFT JOIN information_schema.constraint_column_usage ccu
ON rc.unique_constraint_catalog = ccu.constraint_catalog
AND rc.unique_constraint_schema = ccu.constraint_schema
AND rc.unique_constraint_name = ccu.constraint_name
left join pg_constraint c
on tc.CONSTRAINT_NAME = c.conname
WHERE tc.table_name = 'tabela3'
and upper(tc.CONSTRAINT_NAME) not like '%NOT_NULL%'
order by 1;


alter table tabela3 alter column cd2_codigo drop not null

select relname  from pg_class  where relkind = 'S'

drop sequence tabela3_cd2_codigo_sq


alter table tabela3 add column mais1 int2;
alter table tabela3 add column mais2 int2;
alter table tabela3 add column mais3 int2;
alter table tabela3 add column mais4 int2;
alter table tabela3 add column mais5 int2;
alter table tabela3 add column mais6 int2;
alter table tabela3 add column mais7 int2;


alter table tabela3 
drop column mais1,
drop column mais2,
drop column mais3,
drop column mais4,
drop column mais5,
drop column mais6,
drop column mais7;


alter table tabela3 add constraint pk_cd_codigo primary key (cd_codigo, cd1_codigo)

create sequence tabela3_teste_seq

alter table tabela3 add constraint uq_mais unique (mais1,mais2, mais3);

alter table tabela3
DROP CONSTRAINT pk_cd_codigo;
alter table tabela3
ADD CONSTRAINT pk_cd_codigo
PRIMARY KEY (cd_codigo, cd1_codigo)
drop sequence tabela3_id2_sq

alter index  pk_cd_codigo rename to pk_tabela3;


alter table tabela3 add constraint fk

alter table tabela3 drop constraint fk_tabela2 cascade

alter table tabela3 add constraint fk_tabela2 foreign key (cd2_codigo)references tabela2(cd_codigo) 

select distinct * from information_schema.columns
 where table_schema not in ('information_schema', 'pg_catalog')
 and table_schema = 'public'
 order by 1




select distinct 
tc.table_name, 
tc.constraint_name,  
tc.constraint_type,  
kcu.column_name,  
rc.match_option,  
rc.update_rule,  
rc.delete_rule,  
c.consrc, 
ccu.table_name as foreign_table_name, 
ccu.column_name as foreign_column_name 
from information_schema.table_constraints tc 
left join information_schema.key_column_usage kcu 
on tc.constraint_catalog = kcu.constraint_catalog 
and tc.constraint_schema = kcu.constraint_schema 
and tc.constraint_name = kcu.constraint_name 
left join information_schema.referential_constraints rc 
on tc.constraint_catalog = rc.constraint_catalog 
and tc.constraint_schema = rc.constraint_schema 
and tc.constraint_name = rc.constraint_name 
left join information_schema.constraint_column_usage ccu 
on rc.unique_constraint_catalog = ccu.constraint_catalog 
and rc.unique_constraint_schema = ccu.constraint_schema 
and rc.unique_constraint_name = ccu.constraint_name 
left join pg_constraint c 
on tc.constraint_name = c.conname 
where upper(tc.constraint_name) not like '%NOT_NULL%'
and tc.table_schema = 'public'
and tc.table_name = 'tabela3'
--and tc.constraint_name = 'pk_tabela3'
order by 2

 

create table teste
(
cd_codigo bigserial
);


SELECT *
FROM pg_class
WHERE relkind = 'S'
AND relnamespace IN (
SELECT oid
FROM pg_namespace
WHERE nspname NOT LIKE 'pg_%'
AND nspname != 'information_schema');


drop table tabela3 cascade
create sequence tabela3_cd2_codigo_sq;
create sequence tabela3_id2_sq;




CREATE TABLE tabela3
(
  cd_codigo bigserial NOT NULL,
  id_identity bigserial NOT NULL,
  ds_descricao text,
  cd2_codigo bigint DEFAULT nextval('tabela3_cd2_codigo_sq'::regclass),
  nr_numero numeric(8,0) NOT NULL DEFAULT nextval('tabela3_id_identity_seq'::regclass),
  nm_nome character varying(100) NOT NULL DEFAULT 'teste'::character varying,
  nm_sobrenome character varying(100) NOT NULL DEFAULT 'teste'::character varying,
  nr_cardinal bigint,
  id2_identity bigint DEFAULT nextval('tabela3_id2_sq'::regclass),
  CONSTRAINT pk_tabela3 PRIMARY KEY (cd_codigo),
  CONSTRAINT fk_tabela2 FOREIGN KEY (cd2_codigo)
      REFERENCES tabela2 (cd_codigo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT ck_igual CHECK (cd_codigo = id_identity)
)

CREATE INDEX tabela3_descricao_IDX ON tabela3(ds_descricao);


SELECT *
FROM pg_proc pr,
pg_type tp
WHERE tp.oid = pr.prorettype
AND pr.proisagg = FALSE
AND tp.typname <> 'trigger'
AND pr.pronamespace IN (
SELECT oid
FROM pg_namespace
where nspname = 'public')

WHERE nspname NOT LIKE 'pg_%'
AND nspname != 'information_schema'
);


SELECT *
FROM information_schema.routines
where specific_schema = 'public'
WHERE specific_schema NOT IN
('pg_catalog', 'information_schema')
AND type_udt_name != 'trigger';

---function

SELECT n.nspname as "Schema",
  p.proname as "Name",
  pg_catalog.pg_get_function_result(p.oid) as "Result data type",
  pg_catalog.pg_get_function_arguments(p.oid) as "Argument data types",
 CASE
  WHEN p.proisagg THEN 'agg'
  WHEN p.proiswindow THEN 'window'
  WHEN p.prorettype = 'pg_catalog.trigger'::pg_catalog.regtype THEN 'trigger'
  ELSE 'normal'
END as "Type"
FROM pg_catalog.pg_proc p
     LEFT JOIN pg_catalog.pg_namespace n ON n.oid = p.pronamespace
 where pg_catalog.pg_function_is_visible(p.oid)    
--WHERE p.proname ~ '^(increment)$'
  AND pg_catalog.pg_function_is_visible(p.oid)
ORDER BY 1, 2, 4;




drop table tabela3 cascade

CREATE TABLE tabela3
(
  cd1_codigo bigint NOT NULL,
  cd2_codigo bigint,
  cd_codigo bigint NOT NULL ,
  cod1_codigo bigint,
  dt_data date,
  nr_numero2 integer,
  CONSTRAINT pk_tabela3 PRIMARY KEY (cd1_codigo, cd_codigo)
)

select pg_catalog.pg_get_constraintdef(oid) as "Argument data types"
from pg_catalog.pg_constraint



select pg_catalog.pg_get_indexdef(oid) as "Argument data types"
from pg_catalog.pg_namespace

CREATE OR REPLACE FUNCTION public.one()
RETURNS integer
LANGUAGE sql
AS $function$
SELECT 1 AS result;
$function$

