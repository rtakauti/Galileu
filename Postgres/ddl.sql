-- Table: carga

-- DROP TABLE carga;

CREATE TABLE carga
(
  codcarga bigint NOT NULL DEFAULT nextval('sq_codcarga'::regclass),
  codusrincl integer NOT NULL,
  dtahrincl timestamp with time zone DEFAULT now(),
  codusralter integer,
  dtahralter timestamp with time zone,
  codstatcarga integer NOT NULL DEFAULT 1,
  descrstatcarga character varying(20),
  dtahrstatcarga timestamp with time zone DEFAULT now(),
  codusrstatcarga integer,
  dtahrini timestamp with time zone,
  dtahrfim timestamp with time zone,
  dtahrcancelado timestamp with time zone,
  dtahrsinistrado timestamp with time zone,
  dtahragredespacho timestamp with time zone,
  codsitcarga integer DEFAULT 2,
  descrsitcarga character varying(255),
  dtahrsitcarga timestamp with time zone,
  codusrsitcarga integer,
  codtppriorsitcarga integer,
  dtahratrasado timestamp with time zone,
  dtahrnaoatrasado timestamp with time zone,
  temlembrete boolean NOT NULL DEFAULT false,
  temextrainfo boolean NOT NULL DEFAULT false,
  temocorrencia boolean NOT NULL DEFAULT false,
  codempembar integer,
  empembar_id character varying(30),
  empembar_nome character varying(100),
  codemptra integer,
  emptra_id character varying(30),
  emptra_nome character varying(100),
  codtpoper integer,
  tpoper_descr character varying(20),
  tpoper_redespacho boolean DEFAULT false,
  codtpcarga integer,
  tpcarga_id character varying(30),
  tpcarga_descr character varying(255),
  codemporig integer,
  emporig_id character varying(30),
  emporig_nome character varying(100),
  emporig_logradouro character varying(255),
  emporig_bairro character varying(50),
  emporig_cep character varying(10),
  emporig_codciduf integer,
  emporig_nomeciduf character varying(50),
  emporig_pos_long numeric(15,13),
  emporig_pos_lat numeric(15,13),
  dtahrprevcoleta timestamp with time zone,
  tempoprevcoleta integer NOT NULL DEFAULT 0,
  dtahrinicoleta timestamp with time zone,
  dtahrfimcoleta timestamp with time zone,
  codempdest integer,
  empdest_id character varying(30),
  empdest_nome character varying(100),
  empdest_logradouro character varying(255),
  empdest_bairro character varying(50),
  empdest_cep character varying(10),
  empdest_codciduf integer,
  empdest_nomeciduf character varying(50),
  empdest_pos_long numeric(15,13),
  empdest_pos_lat numeric(15,13),
  dtahrpreventrega timestamp with time zone,
  tempopreventrega integer NOT NULL DEFAULT 0,
  dtahrinientrega timestamp with time zone,
  dtahrfimentrega timestamp with time zone,
  codpriembarque bigint,
  codultembarque bigint,
  id character varying(30),
  numnf character varying(20),
  numdoc character varying(20),
  numped character varying(30),
  numvol integer NOT NULL DEFAULT 1,
  peso numeric(7,2) NOT NULL DEFAULT 0,
  vol numeric(7,2) NOT NULL DEFAULT 0,
  codmoeda integer NOT NULL DEFAULT 1,
  moeda_sigla character varying(10),
  vlr numeric(11,2) NOT NULL DEFAULT 0,
  emporig_pos_area geometry,
  empdest_pos_area geometry,
  isagendamento boolean NOT NULL DEFAULT false,
  dtahrprevfimcoleta timestamp with time zone,
  dtahrprevfimentrega timestamp with time zone,
  codcargafluxo integer,
  codenderecodest integer,
  codtpevento integer,
  tpevento_nome character varying(200),
  tpcarga_tempminima numeric(10,2),
  tpcarga_tempmaxima numeric(10,2),
  prazo integer DEFAULT 0,
  distancia integer DEFAULT 0,
  codemptnf integer,
  emptnf_id character varying(30),
  emptnf_nome character varying(100),
  emptnf_logradouro character varying(255),
  emptnf_bairro character varying(50),
  emptnf_cep character varying(15),
  emptnf_codciduf integer,
  emptnf_nomeciduf character varying(50),
  emptnf_pos_lat numeric(15,13),
  emptnf_pos_long numeric(15,13),
  emptnf_pos_area geometry,
  dtahrprevtnf timestamp with time zone,
  dtahrprevfimtnf timestamp with time zone,
  codcargaorigem integer,
  numpalete integer DEFAULT 0,
  codcargagrupo integer,
  obscarga text,
  obsagendamento text,
  codtppalete integer,
  codenderecoorig integer,
  principal boolean DEFAULT true,
  codempjanela integer,
  codmotivo integer,
  descrmotivo text,
  dtaremessa date,
  pesods numeric(7,2),
  tempendencias boolean DEFAULT false,
  pendencias text[],
  tempendenciasds boolean DEFAULT false,
  codcargafluxoveic integer,
  dtahragendamento timestamp with time zone,
  venda boolean DEFAULT false,
  temdelivery boolean DEFAULT false,
  tnfid character varying(20),
  boxagendamento character varying(20),
  senhaagendamento character varying(30),
  agendamento_realizado integer DEFAULT (-1),
  codigoexternoveic character varying(20),
  CONSTRAINT pk_tblcarga_codcarga PRIMARY KEY (codcarga),
  CONSTRAINT ck_tblcarga_empdest_pos_area CHECK (st_ndims(empdest_pos_area) = 2),
  CONSTRAINT ck_tblcarga_empdest_pos_area2 CHECK (geometrytype(empdest_pos_area) = 'POLYGON'::text OR empdest_pos_area IS NULL),
  CONSTRAINT ck_tblcarga_empdest_pos_area3 CHECK (st_srid(empdest_pos_area) = 29101),
  CONSTRAINT ck_tblcarga_emporig_pos_area CHECK (st_ndims(emporig_pos_area) = 2),
  CONSTRAINT ck_tblcarga_emporig_pos_area2 CHECK (geometrytype(emporig_pos_area) = 'POLYGON'::text OR emporig_pos_area IS NULL),
  CONSTRAINT ck_tblcarga_emporig_pos_area3 CHECK (st_srid(emporig_pos_area) = 29101)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE carga
  OWNER TO postgres;

-- Index: i_carga_empembar_empdest_tpcarga_tpoper

-- DROP INDEX i_carga_empembar_empdest_tpcarga_tpoper;

CREATE INDEX i_carga_empembar_empdest_tpcarga_tpoper
  ON carga
  USING btree
  (codempembar, codempdest, codtpcarga, codtpoper);

-- Index: i_tblcarga_agendamento_realizado

-- DROP INDEX i_tblcarga_agendamento_realizado;

CREATE INDEX i_tblcarga_agendamento_realizado
  ON carga
  USING btree
  (agendamento_realizado);

-- Index: i_tblcarga_codcargafluxo

-- DROP INDEX i_tblcarga_codcargafluxo;

CREATE INDEX i_tblcarga_codcargafluxo
  ON carga
  USING btree
  (codcargafluxo);

-- Index: i_tblcarga_codcargafluxoveic

-- DROP INDEX i_tblcarga_codcargafluxoveic;

CREATE INDEX i_tblcarga_codcargafluxoveic
  ON carga
  USING btree
  (codcargafluxoveic);

-- Index: i_tblcarga_codcargaorigem

-- DROP INDEX i_tblcarga_codcargaorigem;

CREATE INDEX i_tblcarga_codcargaorigem
  ON carga
  USING btree
  (codcargaorigem);

-- Index: i_tblcarga_codempjanela

-- DROP INDEX i_tblcarga_codempjanela;

CREATE INDEX i_tblcarga_codempjanela
  ON carga
  USING btree
  (codempjanela);

-- Index: i_tblcarga_codenderecodest

-- DROP INDEX i_tblcarga_codenderecodest;

CREATE INDEX i_tblcarga_codenderecodest
  ON carga
  USING btree
  (codenderecodest);

-- Index: i_tblcarga_codenderecoorig_codtpoper

-- DROP INDEX i_tblcarga_codenderecoorig_codtpoper;

CREATE INDEX i_tblcarga_codenderecoorig_codtpoper
  ON carga
  USING btree
  (codenderecoorig, codtpoper);

-- Index: i_tblcarga_codpriembarque

-- DROP INDEX i_tblcarga_codpriembarque;

CREATE INDEX i_tblcarga_codpriembarque
  ON carga
  USING btree
  (codpriembarque);

-- Index: i_tblcarga_codstatcarga

-- DROP INDEX i_tblcarga_codstatcarga;

CREATE INDEX i_tblcarga_codstatcarga
  ON carga
  USING btree
  (codstatcarga);

-- Index: i_tblcarga_codultembarque

-- DROP INDEX i_tblcarga_codultembarque;

CREATE INDEX i_tblcarga_codultembarque
  ON carga
  USING btree
  (codultembarque);

-- Index: i_tblcarga_dtahratrasado

-- DROP INDEX i_tblcarga_dtahratrasado;

CREATE INDEX i_tblcarga_dtahratrasado
  ON carga
  USING btree
  (dtahratrasado);

-- Index: i_tblcarga_dtahrcancelado

-- DROP INDEX i_tblcarga_dtahrcancelado;

CREATE INDEX i_tblcarga_dtahrcancelado
  ON carga
  USING btree
  (dtahrcancelado);

-- Index: i_tblcarga_dtahrfim

-- DROP INDEX i_tblcarga_dtahrfim;

CREATE INDEX i_tblcarga_dtahrfim
  ON carga
  USING btree
  (dtahrfim);

-- Index: i_tblcarga_dtahrfimcoleta

-- DROP INDEX i_tblcarga_dtahrfimcoleta;

CREATE INDEX i_tblcarga_dtahrfimcoleta
  ON carga
  USING btree
  (dtahrfimcoleta);

-- Index: i_tblcarga_dtahrfimentrega

-- DROP INDEX i_tblcarga_dtahrfimentrega;

CREATE INDEX i_tblcarga_dtahrfimentrega
  ON carga
  USING btree
  (dtahrfimentrega);

-- Index: i_tblcarga_dtahrini

-- DROP INDEX i_tblcarga_dtahrini;

CREATE INDEX i_tblcarga_dtahrini
  ON carga
  USING btree
  (dtahrini);

-- Index: i_tblcarga_dtahrinicoleta

-- DROP INDEX i_tblcarga_dtahrinicoleta;

CREATE INDEX i_tblcarga_dtahrinicoleta
  ON carga
  USING btree
  (dtahrinicoleta);

-- Index: i_tblcarga_dtahrinientrega

-- DROP INDEX i_tblcarga_dtahrinientrega;

CREATE INDEX i_tblcarga_dtahrinientrega
  ON carga
  USING btree
  (dtahrinientrega);

-- Index: i_tblcarga_dtahrnaoatrasado

-- DROP INDEX i_tblcarga_dtahrnaoatrasado;

CREATE INDEX i_tblcarga_dtahrnaoatrasado
  ON carga
  USING btree
  (dtahrnaoatrasado);

-- Index: i_tblcarga_dtahrprevcoleta

-- DROP INDEX i_tblcarga_dtahrprevcoleta;

CREATE INDEX i_tblcarga_dtahrprevcoleta
  ON carga
  USING btree
  (dtahrprevcoleta);

-- Index: i_tblcarga_dtahrpreventrega

-- DROP INDEX i_tblcarga_dtahrpreventrega;

CREATE INDEX i_tblcarga_dtahrpreventrega
  ON carga
  USING btree
  (dtahrpreventrega);

-- Index: i_tblcarga_dtahrsinistrado

-- DROP INDEX i_tblcarga_dtahrsinistrado;

CREATE INDEX i_tblcarga_dtahrsinistrado
  ON carga
  USING btree
  (dtahrsinistrado);

-- Index: i_tblcarga_dtahrsitcarga

-- DROP INDEX i_tblcarga_dtahrsitcarga;

CREATE INDEX i_tblcarga_dtahrsitcarga
  ON carga
  USING btree
  (dtahrsitcarga);

-- Index: i_tblcarga_dtahrstatcarga

-- DROP INDEX i_tblcarga_dtahrstatcarga;

CREATE INDEX i_tblcarga_dtahrstatcarga
  ON carga
  USING btree
  (dtahrstatcarga);

-- Index: i_tblcarga_empdest_id

-- DROP INDEX i_tblcarga_empdest_id;

CREATE INDEX i_tblcarga_empdest_id
  ON carga
  USING btree
  (empdest_id COLLATE pg_catalog."default");

-- Index: i_tblcarga_empembar_id

-- DROP INDEX i_tblcarga_empembar_id;

CREATE INDEX i_tblcarga_empembar_id
  ON carga
  USING btree
  (empembar_id COLLATE pg_catalog."default");

-- Index: i_tblcarga_emporig_id

-- DROP INDEX i_tblcarga_emporig_id;

CREATE INDEX i_tblcarga_emporig_id
  ON carga
  USING btree
  (emporig_id COLLATE pg_catalog."default");

-- Index: i_tblcarga_emptra_id

-- DROP INDEX i_tblcarga_emptra_id;

CREATE INDEX i_tblcarga_emptra_id
  ON carga
  USING btree
  (emptra_id COLLATE pg_catalog."default");

-- Index: i_tblcarga_id

-- DROP INDEX i_tblcarga_id;

CREATE INDEX i_tblcarga_id
  ON carga
  USING btree
  (id COLLATE pg_catalog."default");

-- Index: i_tblcarga_numdoc

-- DROP INDEX i_tblcarga_numdoc;

CREATE INDEX i_tblcarga_numdoc
  ON carga
  USING btree
  (numdoc COLLATE pg_catalog."default");

-- Index: i_tblcarga_numnf

-- DROP INDEX i_tblcarga_numnf;

CREATE INDEX i_tblcarga_numnf
  ON carga
  USING btree
  (numnf COLLATE pg_catalog."default");

-- Index: i_tblcarga_numped

-- DROP INDEX i_tblcarga_numped;

CREATE INDEX i_tblcarga_numped
  ON carga
  USING btree
  (numped COLLATE pg_catalog."default");

-- Index: i_tblcarga_tpcarga_id

-- DROP INDEX i_tblcarga_tpcarga_id;

CREATE INDEX i_tblcarga_tpcarga_id
  ON carga
  USING btree
  (tpcarga_id COLLATE pg_catalog."default");


-- Trigger: t_after_iud_tblcarga on carga

-- DROP TRIGGER t_after_iud_tblcarga ON carga;

CREATE TRIGGER t_after_iud_tblcarga
  AFTER INSERT OR UPDATE OR DELETE
  ON carga
  FOR EACH ROW
  EXECUTE PROCEDURE dados_carga.tf_after_iud_carga_child();

-- Trigger: t_before_iud_tblcarga on carga

-- DROP TRIGGER t_before_iud_tblcarga ON carga;

CREATE TRIGGER t_before_iud_tblcarga
  BEFORE INSERT OR UPDATE OR DELETE
  ON carga
  FOR EACH ROW
  EXECUTE PROCEDURE dados_carga.tf_before_iud_carga_child();

