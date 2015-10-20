--drop table tabela2;
/*
CREATE TABLE tabela2
(
  cd_codigo bigserial NOT NULL,
  nm_nome character varying(20) DEFAULT 'teste'::character varying,
  ds_descricao text DEFAULT 'teste'::text,
  
  nr_numero numeric(8,1) DEFAULT 30,
  dt_data timestamp with time zone,
  CONSTRAINT tabela1_pkey PRIMARY KEY (cd_codigo)
)
*/

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
/*
ALTER TABLE tabela3 ALTER COLUMN nr_numero  set NOT NULL;
ALTER TABLE tabela3 ALTER COLUMN nr_numero DROP DEFAULT;
ALTER TABLE tabela3 ALTER COLUMN nr_numero SET DEFAULT 30;
ALTER TABLE tabela3 ALTER COLUMN nr_numero TYPE numeric(8) USING nr_numero::numeric;
ALTER TABLE tabela1 ALTER COLUMN nr_numero TYPE decimal(10) USING nr_numero::decimal;
ALTER TABLE tabela3 ALTER COLUMN dt_data DROP NOT NULL;
*/

ALTER TABLE tabela3 ADD COLUMN nm_sobrenome varchar(100) not null default 'teste';

ALTER TABLE tabela3 ADD COLUMN nr_cardinal int8; 

alter table tabela3 drop nr_numero;

ALTER TABLE tabela3 ADD COLUMN nr_numero
numeric(8,2)
DEFAULT 30



-- ALTER TABLE tabela1 ALTER COLUMN dt_data TYPE timestamp with time zone;
-- ALTER TABLE tabela1 ALTER COLUMN dt_data TYPE date;
-- ALTER TABLE tabela1 ALTER COLUMN dt_data TYPE timestamp WITH time zone USING to_timestamp(dt_data::timestamp with time zone);

-- ALTER TABLE tabela1 ADD COLUMN tm timestamp with time zone
-- ALTER TABLE tabela1 DROP COLUMN dt_data ;

--select * from tabela1;
-- truncate table log_transicao
-- drop table log_transicao
select * from log_transicao;
/*
insert into tabela1(dt_data) values (now());

select proargnames[pronargs-pronargdefaults+1:pronargs] optargnames,
       pg_get_expr(proargdefaults, 0) optargdefaults
from   pg_proc


select * from pg_proc
*/

create table tabela3 
(
	cd_codigo bigserial not null,
	id_identity bigserial not null,
	ds_descricao text,
	constraint pk_tabela3 primary key (cd_codigo, id_identity)

);


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


select constraint_name, column_name, ordinal_position  from information_schema.key_column_usage where table_name = 'tabela3'

alter table tabela3 drop constraint pk_tabela3;

select * from tabela3;

insert into tabela3 (ds_descricao) values ('teste');
ALTER TABLE TABELA3 ADD CONSTRAINT PK_TABELA3 PRIMARY KEY(CD_CODIGO);


SELECT KCU.CONSTRAINT_NAME, KCU.COLUMN_NAME, RC.MATCH_OPTION, RC.UPDATE_RULE, RC.DELETE_RULE, KCU.ORDINAL_POSITION
FROM information_schema.key_column_usage kcu
LEFT JOIN information_schema.referential_constraints rc
ON kcu.constraint_catalog = rc.constraint_catalog
AND kcu.constraint_schema = rc.constraint_schema
AND kcu.constraint_name = rc.constraint_name
LEFT JOIN information_schema.constraint_column_usage ccu
ON rc.unique_constraint_catalog = ccu.constraint_catalog
AND rc.unique_constraint_schema = ccu.constraint_schema
AND rc.unique_constraint_name = ccu.constraint_name
WHERE KCU.table_name = 'tabela3'

SELECT * FROM information_schema.table_constraints

SELECT * FROM information_schema.key_column_usage

SELECT * FROM information_schema.referential_constraints

SELECT * FROM information_schema.constraint_column_usage



ALTER TABLE TABELA3 ADD COLUMN CD2_CODIGO BIGINT;

ALTER TABLE TABELA3 ADD CONSTRAINT FK_TABELA2 FOREIGN KEY (CD2_CODIGO) REFERENCES TABELA2(CD_CODIGO)

ALTER TABLE tabela3 drop COLUMN nm_sobrenome

ALTER TABLE tabela3 ADD COLUMN nm_sobrenome
varchar (100)
DEFAULT 'teste'::character varying
NOT NULL

ALTER TABLE tabela3 add COLUMN nr_cardinal 
	 INT8


select * from pg_class c where c.relkind = 'S';

SELECT *
FROM pg_class
WHERE relkind = 'S'
AND relnamespace IN (
SELECT oid
FROM pg_namespace
WHERE nspname NOT LIKE 'pg_%'
AND nspname != 'information_schema');


 nsp.nspname as schema,
 select      nsp.nspname ||'.'|| cls.relname as sequence
from pg_class cls
  join pg_namespace nsp on nsp.oid = cls.relnamespace
where nsp.nspname not in ('information_schema', 'pg_catalog')
  and nsp.nspname not like 'pg_toast%'
  and cls.relkind = 'S'
order by 1;

create sequence public.tabela20_cd_codigo_seq;

alter table tabela3 alter column cd2_codigo set default nextval('tabela3_cd2_codigo_sq')

create sequence tabela3_cd2_codigo_sq


alter table tabela3 add column id2_identity int8
create sequence tabela3_id2_sq
alter table tabela3 alter column id2_identity set default nextval('tabela3_id2_sq')


select relname  from pg_class  where relkind = 'S'



/*

*/

 
select * from information_schema.columns 
where table_schema = 'public'
and table_name = 'newtable'
order by 4

select * from pg_attribute order by 2;


	
drop table sal_emp cascade;
CREATE TABLE sal_emp (
    texto            text,
    integerarray  integer[],
    textarray        text[][],
    bigintarray	    bigint[],
    bits             bit,
    bitarray	    bit[1][2],
    bitarray1	   bit varying[10],
    booleano	   boolean,
    booleanoarray  boolean[],
    box    	   box,
    boxarray	   box[],
    bytea	   bytea,
    byteaarray     bytea[],
    varcahar 	   varchar(100),
    varchararray   varchar[100][50],
    chara	   char(500),
    chararray	   char[10][20],
    cidr	   cidr,
    cidrarray	   cidr[10][5],
    circle	   circle,
    circlearray    circle[2][3],
    dates	   date,
    datearray	   date[2][2],
    floate	   float,
    floate1	   double precision,
    floatarray     float[][],
    smallinte	   smallint,
    smallintarray  smallint[][],
    decimale 	   decimal,
    decimalarray   decimal[][],
    numerico	   numeric,
    numerico1	   numeric(8),
    numerico2	   numeric(5,2),
    numericoarray  numeric[][],
    numericoarray1 numeric(6,3)[][],
    reale	   real,
    realarray	   real[][],
    money	   money,
    moneyarray	   money[][],
    macaddr	   macaddr,
    macaddrarrary  macaddr[][],
    inet	   inet,
    inetarray	   inet[][],
    intervale	   interval(3),
    intervalarray  interval(4)[][],
    len         interval hour to minute,
    line	   line,
    linearray	   line[][],
    lseg	   lseg,
    lsegarray	   lseg[][],
    path	   path,
    patharray	   path[][],
    point	   point,
    pointarray	   point[][],
    polygon	   polygon,
    polygonarray   polygon[][],
    tempo	   time,
    tempo1	   time(3),
    tempozone	   time(2) with time zone,
    temponozone    time(1) without time zone,
    tempo1array	   time(3)[][],
    tempozonearray   time(2) with time zone[][],
    temponozonearray    time(1) without time zone[][],
    stamp	   timestamp,
    stamp1	   timestamp(3),
    stampzone	   timestamp(1) with time zone,
    stampnozone    timestamp(1) without time zone,
    stamp1array	   timestamp(3)[][],
    stampzonearray   timestamp(2) with time zone[][],
    stampnozonearray    timestamp(1) without time zone[][],
    tsquery	   tsquery,
    tsqueryarray   tsquery[][],
    tsvector	   tsvector,
    tsvectorarray  tsvector[][],
    txid_snapshot  txid_snapshot,
    txid_snapshotarray  txid_snapshot[][],
    uuid	   uuid,
    uuidarray	   uuid[][],
    xmle	   xml,
    xmlearray	   xml[][],
    pos_area 	   geometry
);
commit;


drop table sal_emp cascade;

CREATE TABLE sal_emp
(
bigintarray bigint [] ,
bitarray bit (1) [] ,
bitarray1 bit varying [] ,
bits bit (1),
booleano boolean,
booleanoarray boolean [] ,
box box,
boxarray box [] ,
bytea bytea,
byteaarray bytea [] ,
chara character (500),
chararray character (1) [] ,
cidr cidr,
cidrarray cidr [] ,
circle circle,
circlearray circle [] ,
datearray date [] ,
dates date,
decimalarray numeric [] ,
decimale numeric,
floatarray double precision [] ,
floate double precision,
floate1 double precision,
inet inet,
inetarray inet [] ,
integerarray integer [] ,
intervalarray interval [] ,
intervale interval (3) ,
len interval HOUR TO MINUTE ,
line line,
linearray line [] ,
lseg lseg,
lsegarray lseg [] ,
macaddr macaddr,
macaddrarrary macaddr [] ,
money money,
moneyarray money [] ,
numerico numeric,
numerico1 numeric (8,0) ,
numerico2 numeric (5,2) ,
numericoarray numeric [] ,
numericoarray1 numeric [] ,
path path,
patharray path [] ,
point point,
pointarray point [] ,
polygon polygon,
polygonarray polygon [] ,
realarray real [] ,
reale real,
smallintarray smallint [] ,
smallinte smallint,
tempo time (6) without time zone,
tempo1 time (3) without time zone,
tempo1array time without time zone [] ,
temponozone time (1) without time zone,
temponozonearray time without time zone [] ,
tempozone time (2) with time zone,
tempozonearray time with time zone [] ,
textarray text [] ,
texto text,
varcahar character varying (100),
varchararray varchar []
);


insert into sal_emp(pay_by_quarter)values('{20000, 25000, 25000, 25000}');

insert into sal_emp(schedule)values('{{"breakfast", "consulting"}, {"meeting", "lunch"}}');

insert into sal_emp(dates) values (DATE_TRUNC('second', NOW()));

select * from sal_emp;

/*
*/




CREATE TABLE tictactoe (
    squares   integer[3][3]
);

create table tabela11
(
cd_codigo bigserial
);


alter table tabela11 add column nm_nome varchar(50)  not null default 'eu'

alter table tabela10 add column nr_numrero numeric(10,2) 

create table tabela12
(
cd_codigo int8 NOT NULL DEFAULT nextval('tabela10_cd_codigo_seq'::regclass), 
	id_identity int8, 
	nm_nome varchar (50) NOT NULL DEFAULT 'eu'::character varying 
);

drop table tabela11
create sequence tabela11_cd_codigo_seq
CREATE TABLE tabela11 
( 
	cd_codigo int8 NOT NULL DEFAULT nextval('tabela11_cd_codigo_seq'::regclass) , 
	nm_nome varchar (50) NOT NULL DEFAULT 'eu'::character varying 
);


SELECT pg_class.oid, 
pg_class.relname as tablename,
                      case when (select count(*) 
                      from pg_inherits left join pg_class filha 
                      on filha.oid = pg_inherits.inhrelid 
                      where inhparent = (
					select filha.oid 
					from pg_class filha 
					where filha.relname = pg_class.relname
					) 
				) > 0 then true else false end as temfilha
               FROM pg_namespace, pg_class
               WHERE pg_class.relkind ='r'
                  AND pg_namespace.nspname='public'
                  AND pg_class.relnamespace = pg_namespace.oid
                  AND pg_class.oid not in (select inhrelid from pg_inherits  )
               ORDER BY pg_class.relname;




CREATE TABLE cities (
    name            text,
    population      float,
    altitude        int     -- in feet
);

CREATE TABLE capitals (
    state           char(2)
) INHERITS (cities);


SELECT *
FROM pg_namespace, pg_class
WHERE pg_class.relkind ='r'
  AND pg_namespace.nspname='public'
  AND pg_class.relnamespace = pg_namespace.oid
  AND pg_class.oid not in (select inhrelid from pg_inherits  )
ORDER BY pg_class.relname;


drop table tabela3 cascade;


CREATE TABLE tabela3
(
  cd_codigo bigserial NOT NULL,
  id_identity bigserial NOT NULL,
  ds_descricao text,
  cd1_codigo bigint NOT NULL,
  cd2_codigo bigint,
  id1_identity bigint,
  nm_nome text,
  cod1_codigo bigint,
  mais1 smallint,
  mais2 smallint,
  mais3 smallint,
  mais4 smallint,
  mais5 smallint,
  mais6 smallint,
  mais7 smallint,
  CONSTRAINT pk_tabela3 PRIMARY KEY (cd_codigo, cd1_codigo),
  CONSTRAINT cd1_id1_fk FOREIGN KEY (id1_identity)
      REFERENCES tabela1 (cd_codigo) MATCH FULL
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_tabela1 FOREIGN KEY (cd1_codigo)
      REFERENCES tabela1 (cd_codigo) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_tabela2 FOREIGN KEY (cd2_codigo)
      REFERENCES tabela2 (cd_codigo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT uq_descricao UNIQUE (ds_descricao),
  CONSTRAINT uq_mais UNIQUE (mais1, mais2, mais3),
  CONSTRAINT ck_igual CHECK (cd_codigo = id_identity)
)




create sequence tabela3_cd_codigo_seq;
create sequence tabela3_id_identity_seq;

drop table tabela3 cascade;
CREATE TABLE tabela3
(
cd1_codigo bigint NOT NULL,
cd2_codigo bigint,
cd_codigo bigint NOT NULL DEFAULT nextval('tabela3_cd_codigo_seq'::regclass),
cod1_codigo bigint,
ds_descricao text,
id1_identity bigint,
id_identity bigint NOT NULL DEFAULT nextval('tabela3_id_identity_seq'::regclass),
nm_nome text,
CONSTRAINT cd1_id1_fk FOREIGN KEY (id1_identity)
REFERENCES tabela1 (cd_codigo) MATCH FULL
ON UPDATE NO ACTION ON DELETE NO ACTION ,
CONSTRAINT ck_igual CHECK (cd_codigo = id_identity) ,
CONSTRAINT fk_tabela1 FOREIGN KEY (cd1_codigo)
REFERENCES tabela1 (cd_codigo) MATCH SIMPLE
ON UPDATE CASCADE ON DELETE CASCADE ,
CONSTRAINT fk_tabela2 FOREIGN KEY (cd2_codigo)
REFERENCES tabela2 (cd_codigo) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION ,
CONSTRAINT pk_tabela3 PRIMARY KEY (cd1_codigo, cd_codigo) ,
CONSTRAINT uq_descricao UNIQUE (ds_descricao)
);

CREATE INDEX tabela3_descricao_IDX ON tabela3(ds_descricao);

CREATE INDEX tabela3_nome_IDX2 ON tabela3(nm_nome, ds_descricao);

SELECT *
FROM pg_class
WHERE oid IN (
SELECT indexrelid
FROM pg_index, pg_class
WHERE pg_class.relname='tabela3'
AND pg_class.oid=pg_index.indrelid
AND indisunique != 't'
AND indisprimary != 't'
);



SELECT
*
FROM
pg_class AS a
JOIN pg_index AS b ON (a.oid = b.indrelid)
JOIN pg_class AS c ON (c.oid = b.indexrelid)
WHERE
a.relname = 'tabela3';


SELECT n.nspname as "Schema",
  c.relname as "Name",
  CASE c.relkind WHEN 'r' THEN 'table' WHEN 'v' THEN 'view' WHEN 'i' 
THEN 'index' WHEN 'S' THEN 'sequence' WHEN 's' THEN 'special' END as "Type",
  u.usename as "Owner",
 c2.relname as "Table"
 select *
FROM pg_catalog.pg_class c
     JOIN pg_catalog.pg_index i ON i.indexrelid = c.oid
     JOIN pg_catalog.pg_class c2 ON i.indrelid = c2.oid
     LEFT JOIN pg_catalog.pg_user u ON u.usesysid = c.relowner
     LEFT JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace
WHERE c.relkind IN ('i','')
      AND n.nspname NOT IN ('pg_catalog', 'pg_toast')
      AND pg_catalog.pg_table_is_visible(c.oid)
ORDER BY 1,2;



select
    t.relname as table_name,
    i.relname as index_name,
    a.attname as column_name,
    n.nspname as schema_name
--select *
from
    pg_class t,
    pg_class i,
    pg_index ix,
    pg_attribute a,
    pg_namespace n
where
    t.oid = ix.indrelid
    and i.oid = ix.indexrelid
    and a.attrelid = t.oid
    and a.attnum = ANY(ix.indkey)
    and n.oid = t.relnamespace
    and t.relkind = 'r'
    AND indisunique != 't'
AND indisprimary != 't'
    and t.relname = 'tabela3'
    and n.nspname = 'public'
   -- and t.relname like 'tabela3%'
order by
    t.relname,
    i.relname;

CREATE INDEX tabela3_unit_cod  ON tabela3 USING btree (nm_nome, ds_descricao, cd_codigo);

CREATE TABLE vintage_unit
(
  id integer NOT NULL,
  vintage_unit_date date,
  origination_month timestamp with time zone,
  product character varying,
  customer_type character varying,
  balance numeric,
  CONSTRAINT pk_id_loan PRIMARY KEY (id)
);

CREATE INDEX id_vintage_unit_date  ON vintage_unit USING btree (vintage_unit_date);   
CREATE INDEX ind_customer_type ON vintage_unit USING btree (customer_type COLLATE pg_catalog."default");
CREATE INDEX ind_origination_month ON vintage_unit USING btree  (origination_month);    
CREATE INDEX ind_product ON vintage_unit USING btree (product COLLATE pg_catalog."default");

--- function

 
SELECT routine_name
FROM information_schema.routines
WHERE specific_schema NOT IN
('pg_catalog', 'information_schema')
AND type_udt_name != 'trigger';



select distinct 
tc.constraint_name ,  
tc.constraint_type ,  
kcu.column_name ,  
ccu.table_name as foreign_table , 
ccu.column_name as foreign_column , 
rc.match_option ,  
rc.update_rule ,  
rc.delete_rule ,  
c.consrc , 
case when tc.constraint_type = 'PRIMARY KEY' then 1
 when tc.constraint_type = 'FOREIGN KEY' then 2
 when tc.constraint_type = 'CHECK' then 3
 when tc.constraint_type = 'UNIQUE' then 4
end as ordem 
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
order by ordem


alter table cities add column city varchar;
alter table cities add column states varchar;

  CREATE OR REPLACE FUNCTION add_city(city VARCHAR(70), states CHAR(2)) 
    RETURNS void AS $$
    BEGIN
      INSERT INTO cities VALUES (city, states);
    END;
    $$ LANGUAGE plpgsql;


CREATE OR REPLACE FUNCTION increment(i INT) RETURNS INT AS $$
    BEGIN
      RETURN i + 1;
    END;
    $$ LANGUAGE plpgsql;



CREATE FUNCTION one() RETURNS integer AS $$
    SELECT 1 AS result;
$$ LANGUAGE SQL;


------------------------function

SELECT n.nspname as "Schema",
  p.proname as "Name",
  pg_catalog.pg_get_function_result(p.oid) as "Result data type",
  pg_catalog.pg_get_functiondef(p.oid) as "Argument data types",
 CASE
  WHEN p.proisagg THEN 'agg'
  WHEN p.proiswindow THEN 'window'
  WHEN p.prorettype = 'pg_catalog.trigger'::pg_catalog.regtype THEN 'trigger'
  ELSE 'normal'
END as "Type",
	p.prosrc
FROM pg_catalog.pg_proc p
     LEFT JOIN pg_catalog.pg_namespace n ON n.oid = p.pronamespace
 where pg_catalog.pg_function_is_visible(p.oid)    
  AND pg_catalog.pg_function_is_visible(p.oid)
  and n.nspname ='public'
ORDER BY 1, 2, 4;

select * from pg_catalog.pg_index




SELECT distinct n.nspname as schema_name,
p.proname as function_name,
pg_catalog.pg_get_function_result(p.oid) as return,
pg_catalog.pg_get_function_arguments(p.oid) as parameter,
p.prosrc as body
FROM pg_catalog.pg_proc p
LEFT JOIN pg_catalog.pg_namespace n ON n.oid = p.pronamespace
where pg_catalog.pg_function_is_visible(p.oid)    
AND pg_catalog.pg_function_is_visible(p.oid)
and n.nspname ='public'
ORDER BY 1, 2, 4;
------------------------------------

SELECT pr.prosrc
FROM pg_proc pr,
pg_type tp
WHERE tp.oid = pr.prorettype
AND pr.proisagg = FALSE
AND tp.typname <> 'trigger'
AND pr.pronamespace IN (
SELECT oid
FROM pg_namespace
WHERE nspname NOT LIKE 'pg_%'
AND nspname != 'information_schema'
);


SELECT proisagg
FROM pg_proc


---- trigger

CREATE TABLE NEWTABLE (
ID INT DEFAULT 0 NOT NULL,
SOMENAME VARCHAR (12),
SOMEDATE TIMESTAMP NOT NULL
);
ALTER TABLE NEWTABLE ADD CONSTRAINT PKINDEX_IDX PRIMARY KEY (ID);
CREATE SEQUENCE NEWTABLE_SEQ INCREMENT 1 START 1;

CREATE FUNCTION add_stamp() RETURNS OPAQUE AS '
BEGIN
IF (NEW.somedate IS NULL OR NEW.somedate = 0) THEN
NEW.somedate := CURRENT_TIMESTAMP;
RETURN NEW;
END IF;
END;
' LANGUAGE 'plpgsql';
 
CREATE TRIGGER ADDCURRENTDATE
BEFORE INSERT OR UPDATE
ON newtable FOR EACH ROW
EXECUTE PROCEDURE add_stamp();


-----------------------------------------------SELECT trg.tgname AS trigger_name


select *
FROM pg_trigger trg, pg_class tbl, pg_namespace nm, information_schema.triggers itg
WHERE trg.tgrelid = tbl.oid
and tbl.relnamespace = nm.oid
and trg.tgname = itg.trigger_name
AND itg.trigger_schema = 'public'
and itg.event_object_table = 'newtable'

----------------------------------------------------

select * from information_schema.triggers

select * from information_schema.tABLES

select * from information_schema.attributes

select * from information_schema.triggered_update_columns

select * from information_schema.constraint_column_usage

select * from information_schema.sequences

select * from pg_catalog.pg_trigger

select pg_catalog.pg_get_function_identity_arguments(oid) from pg_catalog.pg_proc

DROP FUNCTION add_stamp() cascade;


SET SEARCH_PATH TO teste2;



select distinct 
trigger_name , 
action_timing ,
event_manipulation ,
event_object_table as table_name , 
action_orientation as trigger_scope,
action_statement
from information_schema.triggers
where event_object_schema = 'public'

------------------- tabelas

select distinct
i.table_schema,
cl.relkind,
i.table_name,
i.column_name , 
i.udt_name , 
i.data_type , 
i.numeric_precision , 
i.numeric_scale	, 
i.character_maximum_length , 
i.datetime_precision	, 
i.interval_type	, 
i.is_nullable	, 
i.column_default	 
from
pg_namespace nm ,
pg_class cl ,
information_schema.columns i
where  cl.relkind = 'S'
--and i.table_schema = nm.nspname
--and cl.relname = i.table_name
and cl.relnamespace = nm.oid
and cl.oid not in (select inhrelid from pg_inherits  )
order by 1,2




SELECT routine_name
FROM information_schema.routines
WHERE specific_schema != 'information_schema'
and specific_schema not like 'pg_%'
AND type_udt_name != 'trigger';



SELECT proname
FROM pg_proc pr,
pg_type tp
WHERE tp.oid = pr.prorettype
AND pr.proisagg = FALSE
AND tp.typname <> 'trigger'
AND pr.pronamespace IN (
SELECT oid
FROM pg_namespace
WHERE nspname NOT LIKE 'pg_%'
AND nspname != 'information_schema'
);


 select distinct 
 p.proname as function_name, 
 pg_get_function_result(p.oid) as return, 
 pg_get_function_arguments(p.oid) as parameter, 
 pg_get_functiondef(p.oid) as create, 
 n.nspname as schema_name 
 from pg_proc p 
 left join pg_namespace n 
 on n.oid = p.pronamespace 
 where pg_function_is_visible(p.oid) 
 and pg_function_is_visible(p.oid) 
 and n.nspname NOT LIKE 'pg_%' 
 and n.nspname != 'information_schema' 




select distinct
    pp.proname as function_name,
    pn.nspname as schema_name,
    pg_get_function_result(pp.oid) as return, 
    pg_get_function_arguments(pp.oid) as parameter, 
    pp.prosrc as body,
    pg_get_functiondef(pp.oid) as create
from pg_proc pp
inner join pg_namespace pn on (pp.pronamespace = pn.oid)
inner join pg_language pl on (pp.prolang = pl.oid)
where pl.lanname NOT IN ('c','internal') 
  and pn.nspname NOT LIKE 'pg_%'
  and pn.nspname <> 'information_schema'
  and (pp.proname like 'f_%' or pp.proname like 'tf_%')
order by 2;
  





-- First drop old aggregates
DROP AGGREGATE IF EXISTS memgeomunion(geometry);
DROP AGGREGATE IF EXISTS geomunion(geometry);
DROP AGGREGATE IF EXISTS polygonize(geometry); -- Deprecated in 1.2.3, Dropped in 2.0.0
DROP AGGREGATE IF EXISTS collect(geometry); -- Deprecated in 1.2.3, Dropped in 2.0.0
DROP AGGREGATE IF EXISTS st_geomunion(geometry);
DROP AGGREGATE IF EXISTS accum_old(geometry);
DROP AGGREGATE IF EXISTS st_accum_old(geometry);
DROP AGGREGATE IF EXISTS st_accum(geometry);
DROP AGGREGATE IF EXISTS st_collect(geometry);
DROP AGGREGATE IF EXISTS st_extent(geometry);


-- BEGIN Management functions that now have default param for typmod --
DROP FUNCTION IF EXISTS AddGeometryColumn(varchar,varchar,varchar,varchar,integer,varchar,integer);
DROP FUNCTION IF EXISTS AddGeometryColumn(varchar,varchar,varchar,integer,varchar,integer);
DROP FUNCTION IF EXISTS AddGeometryColumn(varchar,varchar,integer,varchar,integer);
DROP FUNCTION IF EXISTS populate_geometry_columns();
DROP FUNCTION IF EXISTS populate_geometry_columns(oid);

-- END Management functions now have default parameter for typmod --
-- Then drop old functions
DROP FUNCTION IF EXISTS box2d_overleft(box2d, box2d);
DROP FUNCTION IF EXISTS box2d_overright(box2d, box2d);
DROP FUNCTION IF EXISTS box2d_left(box2d, box2d);
DROP FUNCTION IF EXISTS box2d_right(box2d, box2d);
DROP FUNCTION IF EXISTS box2d_contain(box2d, box2d);
DROP FUNCTION IF EXISTS box2d_contained(box2d, box2d);
DROP FUNCTION IF EXISTS box2d_overlap(box2d, box2d);
DROP FUNCTION IF EXISTS box2d_same(box2d, box2d);
DROP FUNCTION IF EXISTS box2d_intersects(box2d, box2d);
DROP FUNCTION IF EXISTS st_area(geography); -- this one changed to use default parameters
DROP FUNCTION IF EXISTS ST_AsGeoJson(geometry); -- this one changed to use default args 
DROP FUNCTION IF EXISTS ST_AsGeoJson(geography); -- this one changed to use default args 
DROP FUNCTION IF EXISTS ST_AsGeoJson(geometry,int4); -- this one changed to use default args 
DROP FUNCTION IF EXISTS ST_AsGeoJson(geography,int4); -- this one changed to use default args 
DROP FUNCTION IF EXISTS ST_AsGeoJson(int4,geometry); -- this one changed to use default args
DROP FUNCTION IF EXISTS ST_AsGeoJson(int4,geography); -- this one changed to use default args
DROP FUNCTION IF EXISTS ST_AsGeoJson(int4,geometry,int4); -- this one changed to use default args
DROP FUNCTION IF EXISTS ST_AsGeoJson(int4,geography,int4); -- this one changed to use default args
DROP FUNCTION IF EXISTS st_asgml(geometry); -- changed to use default args
DROP FUNCTION IF EXISTS st_asgml(geometry, int4);  -- changed to use default args
DROP FUNCTION IF EXISTS st_asgml(int4, geometry);  -- changed to use default args
DROP FUNCTION IF EXISTS st_asgml(int4, geometry, int4);  -- changed to use default args
DROP FUNCTION IF EXISTS st_asgml(int4, geometry, int4,int4);  -- changed to use default args
DROP FUNCTION IF EXISTS st_asgml(geography); -- changed to use default args
DROP FUNCTION IF EXISTS st_asgml(geography, int4);  -- changed to use default args
DROP FUNCTION IF EXISTS st_asgml(int4, geography);  -- changed to use default args
DROP FUNCTION IF EXISTS st_asgml(int4, geography, int4);  -- changed to use default args
DROP FUNCTION IF EXISTS st_asgml(int4, geography, int4,int4);  -- changed to use default args
DROP FUNCTION IF EXISTS ST_AsKML(geometry); -- changed to use default args
DROP FUNCTION IF EXISTS ST_AsKML(geography); -- changed to use default args
DROP FUNCTION IF EXISTS ST_AsKML(int4, geometry, int4); -- changed to use default args
DROP FUNCTION IF EXISTS ST_AsKML(int4, geography, int4); -- changed to use default args
DROP FUNCTION IF EXISTS st_asx3d(geometry); -- this one changed to use default parameters so full function deals with it
DROP FUNCTION IF EXISTS st_asx3d(geometry, int4); -- introduce variant with opts so get rid of other without ops
DROP FUNCTION IF EXISTS st_assvg(geometry); -- changed to use default args
DROP FUNCTION IF EXISTS st_assvg(geometry,int4); -- changed to use default args
DROP FUNCTION IF EXISTS st_assvg(geography); -- changed to use default args
DROP FUNCTION IF EXISTS st_assvg(geography,int4); -- changed to use default args
DROP FUNCTION IF EXISTS st_box2d_overleft(box2d, box2d);
DROP FUNCTION IF EXISTS st_box2d_overright(box2d, box2d);
DROP FUNCTION IF EXISTS st_box2d_left(box2d, box2d);
DROP FUNCTION IF EXISTS st_box2d_right(box2d, box2d);
DROP FUNCTION IF EXISTS st_box2d_contain(box2d, box2d);
DROP FUNCTION IF EXISTS st_box2d_contained(box2d, box2d);
DROP FUNCTION IF EXISTS st_box2d_overlap(box2d, box2d);
DROP FUNCTION IF EXISTS st_box2d_same(box2d, box2d);
DROP FUNCTION IF EXISTS st_box2d_intersects(box2d, box2d);
DROP FUNCTION IF EXISTS st_box2d_in(cstring);
DROP FUNCTION IF EXISTS st_box2d_out(box2d);
DROP FUNCTION IF EXISTS st_box2d(geometry);
DROP FUNCTION IF EXISTS st_box2d(box3d);
DROP FUNCTION IF EXISTS st_box3d(box2d);
DROP FUNCTION IF EXISTS st_box(box3d);
DROP FUNCTION IF EXISTS st_box3d(geometry);
DROP FUNCTION IF EXISTS st_box(geometry);
DROP FUNCTION IF EXISTS ST_ConcaveHull(geometry,float); -- this one changed to use default parameters
DROP FUNCTION IF EXISTS st_text(geometry);
DROP FUNCTION IF EXISTS st_geometry(box2d);
DROP FUNCTION IF EXISTS st_geometry(box3d);
DROP FUNCTION IF EXISTS st_geometry(text);
DROP FUNCTION IF EXISTS st_geometry(bytea);
DROP FUNCTION IF EXISTS st_bytea(geometry);
DROP FUNCTION IF EXISTS st_addbbox(geometry);
DROP FUNCTION IF EXISTS st_dropbbox(geometry); 
DROP FUNCTION IF EXISTS st_hasbbox(geometry); 
DROP FUNCTION IF EXISTS cache_bbox();
DROP FUNCTION IF EXISTS st_cache_bbox();
DROP FUNCTION IF EXISTS ST_GeoHash(geometry); -- changed to use default args
DROP FUNCTION IF EXISTS st_length(geography); -- this one changed to use default parameters
DROP FUNCTION IF EXISTS st_perimeter(geography); -- this one changed to use default parameters
DROP FUNCTION IF EXISTS transform_geometry(geometry,text,text,int);
DROP FUNCTION IF EXISTS collector(geometry, geometry);
DROP FUNCTION IF EXISTS st_collector(geometry, geometry);
DROP FUNCTION IF EXISTS geom_accum (geometry[],geometry);
DROP FUNCTION IF EXISTS st_geom_accum (geometry[],geometry);
DROP FUNCTION IF EXISTS collect_garray (geometry[]);
DROP FUNCTION IF EXISTS st_collect_garray (geometry[]);
DROP FUNCTION IF EXISTS geosnoop(geometry);
DROP FUNCTION IF EXISTS jtsnoop(geometry);
DROP FUNCTION IF EXISTS st_noop(geometry);
DROP FUNCTION IF EXISTS st_max_distance(geometry, geometry);
DROP FUNCTION IF EXISTS  ST_MinimumBoundingCircle(geometry); --changed to use default parameters
-- Drop internals that should never have existed --
DROP FUNCTION IF EXISTS st_geometry_analyze(internal);
DROP FUNCTION IF EXISTS st_geometry_in(cstring);
DROP FUNCTION IF EXISTS st_geometry_out(geometry);
DROP FUNCTION IF EXISTS st_geometry_recv(internal);
DROP FUNCTION IF EXISTS st_geometry_send(geometry);
DROP FUNCTION IF EXISTS st_spheroid_in(cstring);
DROP FUNCTION IF EXISTS st_spheroid_out(spheroid);
DROP FUNCTION IF EXISTS st_geometry_lt(geometry, geometry);
DROP FUNCTION IF EXISTS st_geometry_gt(geometry, geometry);
DROP FUNCTION IF EXISTS st_geometry_ge(geometry, geometry);
DROP FUNCTION IF EXISTS st_geometry_eq(geometry, geometry);
DROP FUNCTION IF EXISTS st_geometry_cmp(geometry, geometry);
DROP FUNCTION IF EXISTS SnapToGrid(geometry, float8, float8);

DROP FUNCTION IF EXISTS geometry_gist_sel_2d (internal, oid, internal, int4);
DROP FUNCTION IF EXISTS geometry_gist_joinsel_2d(internal, oid, internal, smallint);
DROP FUNCTION IF EXISTS geography_gist_selectivity (internal, oid, internal, int4);
DROP FUNCTION IF EXISTS geography_gist_join_selectivity(internal, oid, internal, smallint);

DROP FUNCTION IF EXISTS ST_AsBinary(text); -- deprecated in 2.0
DROP FUNCTION IF EXISTS postgis_uses_stats(); -- deprecated in 2.0


-- Drop all views.
-- Drop all tables.
-- Drop all aggregates.
DROP AGGREGATE IF EXISTS Extent (geometry);
DROP AGGREGATE IF EXISTS makeline (geometry);
DROP AGGREGATE IF EXISTS accum (geometry);
DROP AGGREGATE IF EXISTS Extent3d (geometry);
DROP AGGREGATE IF EXISTS memcollect (geometry);
DROP AGGREGATE IF EXISTS MemGeomUnion (geometry);
DROP AGGREGATE IF EXISTS ST_Extent3D (geometry);
-- Drop all operators classes and families.
-- Drop all operators.
-- Drop all casts.
-- Drop all functions except 0 needed for type definition.
DROP FUNCTION IF EXISTS AsBinary (geometry);
DROP FUNCTION IF EXISTS AsBinary (geometry,text);
DROP FUNCTION IF EXISTS AsText (geometry);
DROP FUNCTION IF EXISTS Estimated_Extent (text,text,text);
DROP FUNCTION IF EXISTS Estimated_Extent (text,text);
DROP FUNCTION IF EXISTS GeomFromText (text, int4);
DROP FUNCTION IF EXISTS GeomFromText (text);
DROP FUNCTION IF EXISTS ndims (geometry);
DROP FUNCTION IF EXISTS SetSRID (geometry,int4);
DROP FUNCTION IF EXISTS SRID (geometry);
DROP FUNCTION IF EXISTS ST_AsBinary (text);
DROP FUNCTION IF EXISTS ST_AsText (bytea);
DROP FUNCTION IF EXISTS addbbox (geometry);
DROP FUNCTION IF EXISTS dropbbox (geometry);
DROP FUNCTION IF EXISTS hasbbox (geometry);
DROP FUNCTION IF EXISTS getsrid (geometry);
DROP FUNCTION IF EXISTS GeometryFromText (text, int4);
DROP FUNCTION IF EXISTS GeometryFromText (text);
DROP FUNCTION IF EXISTS GeomFromWKB (bytea);
DROP FUNCTION IF EXISTS GeomFromWKB (bytea, int);
DROP FUNCTION IF EXISTS noop (geometry);
DROP FUNCTION IF EXISTS SE_EnvelopesIntersect (geometry,geometry);
DROP FUNCTION IF EXISTS SE_Is3D (geometry);
DROP FUNCTION IF EXISTS SE_IsMeasured (geometry);
DROP FUNCTION IF EXISTS SE_Z (geometry);
DROP FUNCTION IF EXISTS SE_M (geometry);
DROP FUNCTION IF EXISTS SE_LocateBetween (geometry, float8, float8);
DROP FUNCTION IF EXISTS SE_LocateAlong (geometry, float8);
DROP FUNCTION IF EXISTS st_box2d (geometry);
DROP FUNCTION IF EXISTS st_box3d (geometry);
DROP FUNCTION IF EXISTS st_box (geometry);
DROP FUNCTION IF EXISTS st_box2d (box3d);
DROP FUNCTION IF EXISTS st_box3d (box2d);
DROP FUNCTION IF EXISTS st_box (box3d);
DROP FUNCTION IF EXISTS st_text (geometry);
DROP FUNCTION IF EXISTS st_geometry (box2d);
DROP FUNCTION IF EXISTS st_geometry (box3d);
DROP FUNCTION IF EXISTS st_geometry (text);
DROP FUNCTION IF EXISTS st_geometry (bytea);
DROP FUNCTION IF EXISTS st_bytea (geometry);
DROP FUNCTION IF EXISTS st_box3d_in (cstring);
DROP FUNCTION IF EXISTS st_box3d_out (box3d);
DROP FUNCTION IF EXISTS rename_geometry_table_constraints ();
DROP FUNCTION IF EXISTS fix_geometry_columns ();
DROP FUNCTION IF EXISTS probe_geometry_columns ();
DROP FUNCTION IF EXISTS st_geometry_lt (geometry, geometry);
DROP FUNCTION IF EXISTS st_geometry_le (geometry, geometry);
DROP FUNCTION IF EXISTS st_geometry_gt (geometry, geometry);
DROP FUNCTION IF EXISTS st_geometry_ge (geometry, geometry);
DROP FUNCTION IF EXISTS st_geometry_eq (geometry, geometry);
DROP FUNCTION IF EXISTS st_geometry_cmp (geometry, geometry);
DROP FUNCTION IF EXISTS Affine (geometry,float8,float8,float8,float8,float8,float8,float8,float8,float8,float8,float8,float8);
DROP FUNCTION IF EXISTS Affine (geometry,float8,float8,float8,float8,float8,float8);
DROP FUNCTION IF EXISTS RotateZ (geometry,float8);
DROP FUNCTION IF EXISTS Rotate (geometry,float8);
DROP FUNCTION IF EXISTS RotateX (geometry,float8);
DROP FUNCTION IF EXISTS RotateY (geometry,float8);
DROP FUNCTION IF EXISTS Scale (geometry,float8,float8,float8);
DROP FUNCTION IF EXISTS Scale (geometry,float8,float8);
DROP FUNCTION IF EXISTS Translate (geometry,float8,float8,float8);
DROP FUNCTION IF EXISTS Translate (geometry,float8,float8);
DROP FUNCTION IF EXISTS TransScale (geometry,float8,float8,float8,float8);
DROP FUNCTION IF EXISTS AddPoint (geometry, geometry);
DROP FUNCTION IF EXISTS AddPoint (geometry, geometry, integer);
DROP FUNCTION IF EXISTS Area (geometry);
DROP FUNCTION IF EXISTS Area2D (geometry);
DROP FUNCTION IF EXISTS AsEWKB (geometry);
DROP FUNCTION IF EXISTS AsEWKB (geometry,text);
DROP FUNCTION IF EXISTS AsEWKT (geometry);
DROP FUNCTION IF EXISTS AsGML (geometry);
DROP FUNCTION IF EXISTS AsGML (geometry, int4);
DROP FUNCTION IF EXISTS AsKML (geometry, int4);
DROP FUNCTION IF EXISTS AsKML (geometry);
DROP FUNCTION IF EXISTS AsKML (int4, geometry, int4);
DROP FUNCTION IF EXISTS AsHEXEWKB (geometry);
DROP FUNCTION IF EXISTS AsHEXEWKB (geometry, text);
DROP FUNCTION IF EXISTS AsSVG (geometry);
DROP FUNCTION IF EXISTS AsSVG (geometry,int4);
DROP FUNCTION IF EXISTS AsSVG (geometry,int4,int4);
DROP FUNCTION IF EXISTS azimuth (geometry,geometry);
DROP FUNCTION IF EXISTS BdPolyFromText (text, integer);
DROP FUNCTION IF EXISTS BdMPolyFromText (text, integer);
DROP FUNCTION IF EXISTS boundary (geometry);
DROP FUNCTION IF EXISTS buffer (geometry,float8,integer);
DROP FUNCTION IF EXISTS buffer (geometry,float8);
DROP FUNCTION IF EXISTS BuildArea (geometry);
DROP FUNCTION IF EXISTS Centroid (geometry);
DROP FUNCTION IF EXISTS Contains (geometry,geometry);
DROP FUNCTION IF EXISTS convexhull (geometry);
DROP FUNCTION IF EXISTS crosses (geometry,geometry);
DROP FUNCTION IF EXISTS distance (geometry,geometry);
DROP FUNCTION IF EXISTS difference (geometry,geometry);
DROP FUNCTION IF EXISTS Dimension (geometry);
DROP FUNCTION IF EXISTS disjoint (geometry,geometry);
DROP FUNCTION IF EXISTS distance_sphere (geometry,geometry);
DROP FUNCTION IF EXISTS distance_spheroid (geometry,geometry,spheroid);
DROP FUNCTION IF EXISTS Dump (geometry);
DROP FUNCTION IF EXISTS DumpRings (geometry);
DROP FUNCTION IF EXISTS Envelope (geometry);
DROP FUNCTION IF EXISTS Expand (box2d,float8);
DROP FUNCTION IF EXISTS Expand (box3d,float8);
DROP FUNCTION IF EXISTS Expand (geometry,float8);
DROP FUNCTION IF EXISTS Find_Extent (text,text);
DROP FUNCTION IF EXISTS Find_Extent (text,text,text);
DROP FUNCTION IF EXISTS EndPoint (geometry);
DROP FUNCTION IF EXISTS ExteriorRing (geometry);
DROP FUNCTION IF EXISTS Force_2d (geometry);
DROP FUNCTION IF EXISTS Force_3d (geometry);
DROP FUNCTION IF EXISTS Force_3dm (geometry);
DROP FUNCTION IF EXISTS Force_3dz (geometry);
DROP FUNCTION IF EXISTS Force_4d (geometry);
DROP FUNCTION IF EXISTS Force_Collection (geometry);
DROP FUNCTION IF EXISTS ForceRHR (geometry);
DROP FUNCTION IF EXISTS GeomCollFromText (text, int4);
DROP FUNCTION IF EXISTS GeomCollFromText (text);
DROP FUNCTION IF EXISTS GeomCollFromWKB (bytea, int);
DROP FUNCTION IF EXISTS GeomCollFromWKB (bytea);
DROP FUNCTION IF EXISTS GeometryN (geometry,integer);
DROP FUNCTION IF EXISTS GeomUnion (geometry,geometry);
DROP FUNCTION IF EXISTS getbbox (geometry);
DROP FUNCTION IF EXISTS intersects (geometry,geometry);
DROP FUNCTION IF EXISTS IsRing (geometry);
DROP FUNCTION IF EXISTS IsSimple (geometry);
DROP FUNCTION IF EXISTS length_spheroid (geometry, spheroid);
DROP FUNCTION IF EXISTS length2d_spheroid (geometry, spheroid);
DROP FUNCTION IF EXISTS length3d_spheroid (geometry, spheroid);
DROP FUNCTION IF EXISTS LineMerge (geometry);
DROP FUNCTION IF EXISTS locate_along_measure (geometry, float8);
DROP FUNCTION IF EXISTS MakeBox2d (geometry, geometry);
DROP FUNCTION IF EXISTS MakePolygon (geometry, geometry[]);
DROP FUNCTION IF EXISTS MakePolygon (geometry);
DROP FUNCTION IF EXISTS MPolyFromWKB (bytea);
DROP FUNCTION IF EXISTS multi (geometry);
DROP FUNCTION IF EXISTS MultiPolyFromWKB (bytea, int);
DROP FUNCTION IF EXISTS MultiPolyFromWKB (bytea);
DROP FUNCTION IF EXISTS InteriorRingN (geometry,integer);
DROP FUNCTION IF EXISTS intersection (geometry,geometry);
DROP FUNCTION IF EXISTS IsClosed (geometry);
DROP FUNCTION IF EXISTS IsEmpty (geometry);
DROP FUNCTION IF EXISTS IsValid (geometry);
DROP FUNCTION IF EXISTS length3d (geometry);
DROP FUNCTION IF EXISTS length2d (geometry);
DROP FUNCTION IF EXISTS length (geometry);
DROP FUNCTION IF EXISTS line_interpolate_point (geometry, float8);
DROP FUNCTION IF EXISTS line_locate_point (geometry, geometry);
DROP FUNCTION IF EXISTS line_substring (geometry, float8, float8);
DROP FUNCTION IF EXISTS LineFromText (text);
DROP FUNCTION IF EXISTS LineFromText (text, int4);
DROP FUNCTION IF EXISTS LineFromMultiPoint (geometry);
DROP FUNCTION IF EXISTS LineFromWKB (bytea, int);
DROP FUNCTION IF EXISTS LineFromWKB (bytea);
DROP FUNCTION IF EXISTS LineStringFromText (text);
DROP FUNCTION IF EXISTS LineStringFromText (text, int4);
DROP FUNCTION IF EXISTS LinestringFromWKB (bytea, int);
DROP FUNCTION IF EXISTS LinestringFromWKB (bytea);
DROP FUNCTION IF EXISTS locate_between_measures (geometry, float8, float8);
DROP FUNCTION IF EXISTS M (geometry);
DROP FUNCTION IF EXISTS MakeBox3d (geometry, geometry);
DROP FUNCTION IF EXISTS makeline_garray  (geometry[]);
DROP FUNCTION IF EXISTS MakeLine (geometry, geometry);
DROP FUNCTION IF EXISTS MakePoint (float8, float8);
DROP FUNCTION IF EXISTS MakePoint (float8, float8, float8);
DROP FUNCTION IF EXISTS MakePoint (float8, float8, float8, float8);
DROP FUNCTION IF EXISTS MakePointM (float8, float8, float8);
DROP FUNCTION IF EXISTS max_distance (geometry,geometry);
DROP FUNCTION IF EXISTS mem_size (geometry);
DROP FUNCTION IF EXISTS MLineFromText (text, int4);
DROP FUNCTION IF EXISTS MLineFromText (text);
DROP FUNCTION IF EXISTS MLineFromWKB (bytea, int);
DROP FUNCTION IF EXISTS MLineFromWKB (bytea);
DROP FUNCTION IF EXISTS MPointFromText (text, int4);
DROP FUNCTION IF EXISTS MPointFromText (text);
DROP FUNCTION IF EXISTS MPointFromWKB (bytea, int);
DROP FUNCTION IF EXISTS MPointFromWKB (bytea);
DROP FUNCTION IF EXISTS MPolyFromText (text, int4);
DROP FUNCTION IF EXISTS MPolyFromText (text);
DROP FUNCTION IF EXISTS MPolyFromWKB (bytea, int);
DROP FUNCTION IF EXISTS MultiLineFromWKB (bytea, int);
DROP FUNCTION IF EXISTS MultiLineFromWKB (bytea, int);
DROP FUNCTION IF EXISTS MultiLineFromWKB (bytea);
DROP FUNCTION IF EXISTS MultiLineStringFromText (text);
DROP FUNCTION IF EXISTS MultiLineStringFromText (text, int4);
DROP FUNCTION IF EXISTS MultiPointFromText (text);
DROP FUNCTION IF EXISTS MultiPointFromText (text);
DROP FUNCTION IF EXISTS MultiPointFromText (text, int4);
DROP FUNCTION IF EXISTS MultiPointFromWKB (bytea, int);
DROP FUNCTION IF EXISTS MultiPointFromWKB (bytea);
DROP FUNCTION IF EXISTS MultiPolygonFromText (text, int4);
DROP FUNCTION IF EXISTS MultiPolygonFromText (text);
DROP FUNCTION IF EXISTS NumInteriorRing (geometry);
DROP FUNCTION IF EXISTS NumInteriorRings (geometry);
DROP FUNCTION IF EXISTS npoints (geometry);
DROP FUNCTION IF EXISTS nrings (geometry);
DROP FUNCTION IF EXISTS NumGeometries (geometry);
DROP FUNCTION IF EXISTS NumPoints (geometry);
DROP FUNCTION IF EXISTS overlaps (geometry,geometry);
DROP FUNCTION IF EXISTS perimeter3d (geometry);
DROP FUNCTION IF EXISTS perimeter2d (geometry);
DROP FUNCTION IF EXISTS point_inside_circle (geometry,float8,float8,float8);
DROP FUNCTION IF EXISTS PointFromText (text);
DROP FUNCTION IF EXISTS PointFromText (text, int4);
DROP FUNCTION IF EXISTS PointFromWKB (bytea);
DROP FUNCTION IF EXISTS PointFromWKB (bytea, int);
DROP FUNCTION IF EXISTS PointN (geometry,integer);
DROP FUNCTION IF EXISTS PointOnSurface (geometry);
DROP FUNCTION IF EXISTS PolyFromText (text);
DROP FUNCTION IF EXISTS PolyFromText (text, int4);
DROP FUNCTION IF EXISTS PolyFromWKB (bytea, int);
DROP FUNCTION IF EXISTS PolyFromWKB (bytea);
DROP FUNCTION IF EXISTS PolygonFromText (text, int4);
DROP FUNCTION IF EXISTS PolygonFromText (text);
DROP FUNCTION IF EXISTS PolygonFromWKB (bytea, int);
DROP FUNCTION IF EXISTS PolygonFromWKB (bytea);
DROP FUNCTION IF EXISTS Polygonize_GArray  (geometry[]);
DROP FUNCTION IF EXISTS relate (geometry,geometry);
DROP FUNCTION IF EXISTS relate (geometry,geometry,text);
DROP FUNCTION IF EXISTS RemovePoint (geometry, integer);
DROP FUNCTION IF EXISTS reverse (geometry);
DROP FUNCTION IF EXISTS Segmentize (geometry, float8);
DROP FUNCTION IF EXISTS SetPoint (geometry, integer, geometry);
DROP FUNCTION IF EXISTS shift_longitude (geometry);
DROP FUNCTION IF EXISTS Simplify (geometry, float8);
DROP FUNCTION IF EXISTS SnapToGrid (geometry, float8, float8, float8, float8);
DROP FUNCTION IF EXISTS SnapToGrid (geometry, float8);
DROP FUNCTION IF EXISTS SnapToGrid (geometry, geometry, float8, float8, float8, float8);
DROP FUNCTION IF EXISTS SnapToGrid (geometry, float8, float8);
DROP FUNCTION IF EXISTS ST_MakeLine_GArray  (geometry[]);
DROP FUNCTION IF EXISTS StartPoint (geometry);
DROP FUNCTION IF EXISTS symdifference (geometry,geometry);
DROP FUNCTION IF EXISTS symmetricdifference (geometry,geometry);
DROP FUNCTION IF EXISTS summary (geometry);
DROP FUNCTION IF EXISTS transform (geometry,integer);
DROP FUNCTION IF EXISTS touches (geometry,geometry);
DROP FUNCTION IF EXISTS within (geometry,geometry);
DROP FUNCTION IF EXISTS X (geometry);
DROP FUNCTION IF EXISTS xmax (box3d);
DROP FUNCTION IF EXISTS xmin (box3d);
DROP FUNCTION IF EXISTS Y (geometry);
DROP FUNCTION IF EXISTS ymax (box3d);
DROP FUNCTION IF EXISTS ymin (box3d);
DROP FUNCTION IF EXISTS Z (geometry);
DROP FUNCTION IF EXISTS zmax (box3d);
DROP FUNCTION IF EXISTS zmin (box3d);
DROP FUNCTION IF EXISTS zmflag (geometry);
DROP FUNCTION IF EXISTS collect (geometry, geometry);
DROP FUNCTION IF EXISTS combine_bbox (box2d,geometry);
DROP FUNCTION IF EXISTS combine_bbox (box3d,geometry);
DROP FUNCTION IF EXISTS ST_Polygonize_GArray  (geometry[]);
DROP FUNCTION IF EXISTS ST_unite_garray  (geometry[]);
DROP FUNCTION IF EXISTS unite_garray  (geometry[]);
DROP FUNCTION IF EXISTS ST_Length3D (geometry);
DROP FUNCTION IF EXISTS ST_Length_spheroid3D (geometry, spheroid);
DROP FUNCTION IF EXISTS ST_Perimeter3D (geometry);
DROP FUNCTION IF EXISTS ST_MakeBox3D (geometry, geometry);
-- Drop all types.
-- Drop all functions needed for types definition.
-- Drop all schemas.