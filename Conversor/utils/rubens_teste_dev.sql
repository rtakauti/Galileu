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
and table_name = 'sal_emp'
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

SELECT *
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

 
SELECT routine_name
FROM information_schema.routines
WHERE specific_schema NOT IN
('pg_catalog', 'information_schema')
AND type_udt_name != 'trigger';
