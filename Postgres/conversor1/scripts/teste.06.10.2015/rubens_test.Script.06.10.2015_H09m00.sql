

------------------ DATABASE: rubens_test ------------------


------ DEV SCHEMAS ------
	-- alteracoes
	-- dashboard
	-- integracao
	-- public

------ HOMOLOG SCHEMAS ------
	-- public
	-- teste

-------------------- DROP DE SCHEMAS --------------------
DROP SCHEMA IF EXISTS teste CASCADE;



-------------------- CREATE SCHEMA --------------------
CREATE SCHEMA alteracoes;

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO alteracoes;



-------------------- CREATE SCHEMA --------------------
CREATE SCHEMA dashboard;

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO dashboard;

--------------------  CREATE DE SEQUENCES -------------------- 
CREATE SEQUENCE dashboard.agendadashboard_codagendadashboard_seq;
CREATE SEQUENCE dashboard.agendalayout_codagendalayout_seq;
CREATE SEQUENCE dashboard.fontedados_codfontedados_seq;
CREATE SEQUENCE dashboard.fontedadosparam_codfontedadosparam_seq;
CREATE SEQUENCE dashboard.layoutdashboard_codlayoutdashboard_seq;

-------------------- CREATE TABLE --------------------

CREATE TABLE agendadashboard
(
	codagendadashboard integer NOT NULL DEFAULT nextval('dashboard.agendadashboard_codagendadashboard_seq'::regclass),
	codgrp integer,
	descricao character varying (200),
	fim date NOT NULL,
	inicio date NOT NULL,
	intervalo integer
);

CREATE TABLE agendalayout
(
	codagendadashboard integer NOT NULL,
	codagendalayout integer NOT NULL DEFAULT nextval('dashboard.agendalayout_codagendalayout_seq'::regclass),
	codlayoutdashboard integer NOT NULL,
	domingo boolean,
	hrfim time (6) without time zone NOT NULL,
	hrini time (6) without time zone NOT NULL,
	ordem integer,
	quarta boolean,
	quinta boolean,
	sabado boolean,
	segunda boolean,
	sexta boolean,
	terca boolean
);

CREATE TABLE fontedados
(
	codfontedados integer NOT NULL DEFAULT nextval('dashboard.fontedados_codfontedados_seq'::regclass),
	colunas text,
	comando text,
	descricao text,
	nome character varying (200) NOT NULL
);

CREATE TABLE fontedadosaux
(
	dtahrultupd timestamp (6) with time zone,
	intervalo integer,
	nome character varying (20),
	sql text
);

CREATE TABLE fontedadosparam
(
	chave character varying (100) NOT NULL,
	codfontedados integer NOT NULL,
	codfontedadosparam integer NOT NULL DEFAULT nextval('dashboard.fontedadosparam_codfontedadosparam_seq'::regclass),
	define_view boolean DEFAULT false,
	ordem integer NOT NULL,
	rotulo character varying (100) NOT NULL,
	tipo character varying (20) NOT NULL,
	valor character varying (100)
);

CREATE TABLE layoutdashboard
(
	altura integer NOT NULL,
	codlayoutdashboard integer NOT NULL DEFAULT nextval('dashboard.layoutdashboard_codlayoutdashboard_seq'::regclass),
	dashboard text NOT NULL,
	descricao character varying (200),
	largura integer NOT NULL,
	nome character varying (150) NOT NULL
);



-------------------- CREATE SCHEMA --------------------
CREATE SCHEMA integracao;

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO integracao;



-------------------- ALTER SCHEMA --------------------

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO public;

--------------------  DROP DE SEQUENCES -------------------- 
DROP SEQUENCE public.tabela1_cd_codigo_seq CASCADE;
DROP SEQUENCE public.tabela2_cd_codigo_seq CASCADE;
DROP SEQUENCE public.tabela3_cd_codigo_seq CASCADE;
DROP SEQUENCE public.tabela3_id_identity_seq CASCADE;
DROP SEQUENCE public.tabela3_teste_seq CASCADE;
DROP SEQUENCE public.tabela4_id_seq CASCADE;
DROP SEQUENCE public.tabela5_id_seq CASCADE;
DROP SEQUENCE public.teste_cd_codigo_seq CASCADE;

--------------------  CREATE DE SEQUENCES -------------------- 
CREATE SEQUENCE public.acao_codacao_seq;
CREATE SEQUENCE public.agenda_codagenda_seq;
CREATE SEQUENCE public.agendadescarga_codagendadescarga_seq;
CREATE SEQUENCE public.agendahr_codagendahr_seq;
CREATE SEQUENCE public.agendamento_codagendamento_seq;
CREATE SEQUENCE public.ajuda_codajuda_seq;
CREATE SEQUENCE public.bid_codbid_seq;
CREATE SEQUENCE public.bid_regiao_codbidregiao_seq;
CREATE SEQUENCE public.bid_spot_codbidspot_seq;
CREATE SEQUENCE public.bid_transp_codbidtransp_seq;
CREATE SEQUENCE public.cargafluxo_codcargafluxo_seq;
CREATE SEQUENCE public.cargafluxoemp_codcargafluxoemp_seq;
CREATE SEQUENCE public.cargafluxoveic_codcargafluxoveic_seq;
CREATE SEQUENCE public.cargagrupo_codcargagrupo_seq;
CREATE SEQUENCE public.conta_codconta_seq;
CREATE SEQUENCE public.contato_codcontato_seq;
CREATE SEQUENCE public.dados_integracao_codregistro_seq;
CREATE SEQUENCE public.emailregra_codemailregra_seq;
CREATE SEQUENCE public.empcfgjanela_codempcfgjanela_seq;
CREATE SEQUENCE public.empcfgturno_codempcfgturno_seq;
CREATE SEQUENCE public.empendereco_codempendereco_seq;
CREATE SEQUENCE public.empjanela_codempjanela_seq;
CREATE SEQUENCE public.empjanelahist_codempjanelahist_seq;
CREATE SEQUENCE public.expediente_codexpediente_seq;
CREATE SEQUENCE public.expedientehorario_codexpedientehorario_seq;
CREATE SEQUENCE public.faq_codfaq_seq;
CREATE SEQUENCE public.feriado_codferiado_seq;
CREATE SEQUENCE public.grpemp_codgrpemp_seq;
CREATE SEQUENCE public.histcompl_codhistcompl_seq;
CREATE SEQUENCE public.histemppos_codhistemppos_seq;
CREATE SEQUENCE public.histmotivoembcarga_codhistmotivoembcarga_seq;
CREATE SEQUENCE public.histstatagendadescarga_codagendadescarga_seq;
CREATE SEQUENCE public.histstatagendadescarga_codhiststatagendadescarga_seq;
CREATE SEQUENCE public.histstatagendadescarga_codstatagendadescarga_seq;
CREATE SEQUENCE public.histstatpedido_codhiststatpedido_seq;
CREATE SEQUENCE public.idioma_codidioma_seq;
CREATE SEQUENCE public.kpiciclocircuito_codciclo_seq;
CREATE SEQUENCE public.leilaoaprovacao_codleilaoaprovacao_seq;
CREATE SEQUENCE public.leilao_codleilao_seq;
CREATE SEQUENCE public.leilaofrete_codleilaofrete_seq;
CREATE SEQUENCE public.leilaolance_codleilaolance_seq;
CREATE SEQUENCE public.leilaotpfrete_codleilaotpfrete_seq;
CREATE SEQUENCE public.leilaotransp_codleilaotransp_seq;
CREATE SEQUENCE public.log_alteracoes_codlog_seq;
CREATE SEQUENCE public.modulo_codmodulo_seq;
CREATE SEQUENCE public.palavra_codpalavra_seq;
CREATE SEQUENCE public.pedido_codpedido_seq;
CREATE SEQUENCE public.produto_codproduto_seq;
CREATE SEQUENCE public.relatorio_codrelatorio_seq;
CREATE SEQUENCE public.sq_ciduf_codciduf;
CREATE SEQUENCE public.sq_codagendadescarga;
CREATE SEQUENCE public.sq_codcarga;
CREATE SEQUENCE public.sq_codcarreta;
CREATE SEQUENCE public.sq_codemailtosend;
CREATE SEQUENCE public.sq_codembarque;
CREATE SEQUENCE public.sq_codembarquecarga;
CREATE SEQUENCE public.sq_codembarquecarreta;
CREATE SEQUENCE public.sq_codembartransp;
CREATE SEQUENCE public.sq_codemp;
CREATE SEQUENCE public.sq_codequiprastr;
CREATE SEQUENCE public.sq_codevento;
CREATE SEQUENCE public.sq_codextrainfo;
CREATE SEQUENCE public.sq_codgrp;
CREATE SEQUENCE public.sq_codgrpusr;
CREATE SEQUENCE public.sq_codhistanotocor;
CREATE SEQUENCE public.sq_codhistpreventrega;
CREATE SEQUENCE public.sq_codhistsitcarga;
CREATE SEQUENCE public.sq_codhistsitembarque;
CREATE SEQUENCE public.sq_codhiststatcarga;
CREATE SEQUENCE public.sq_codhiststatembarque;
CREATE SEQUENCE public.sq_codhiststatocor;
CREATE SEQUENCE public.sq_codlembrete;
CREATE SEQUENCE public.sq_codlocexped;
CREATE SEQUENCE public.sq_codmot;
CREATE SEQUENCE public.sq_codocor;
CREATE SEQUENCE public.sq_codpos;
CREATE SEQUENCE public.sq_codprazotransito;
CREATE SEQUENCE public.sq_codprogcoleta;
CREATE SEQUENCE public.sq_codprogcoletacarga;
CREATE SEQUENCE public.sq_codrastrmovel;
CREATE SEQUENCE public.sq_codrota;
CREATE SEQUENCE public.sq_codtemp;
CREATE SEQUENCE public.sq_codtemplateemail;
CREATE SEQUENCE public.sq_codtpcarga;
CREATE SEQUENCE public.sq_codtpevento;
CREATE SEQUENCE public.sq_codtpveic;
CREATE SEQUENCE public.sq_codusr;
CREATE SEQUENCE public.sq_codveic;
CREATE SEQUENCE public.sq_nf;
CREATE SEQUENCE public.sq_tpcodevento;
CREATE SEQUENCE public.statagendadescarga_codstatagendadescarga_seq;
CREATE SEQUENCE public.statleilao_codstatleilao_seq;
CREATE SEQUENCE public.statpedido_codstatpedido_seq;
CREATE SEQUENCE public.tpeventocjto_codtpeventocjto_seq;
CREATE SEQUENCE public.tpevento_codtpevento_seq;
CREATE SEQUENCE public.tpeventoembarque_codtpeventoembarque_seq;
CREATE SEQUENCE public.tpeventoemp_codtpeventoemp_seq;
CREATE SEQUENCE public.tpferiado_codtpferiado_seq;
CREATE SEQUENCE public.tppalete_codtppalete_seq;
CREATE SEQUENCE public.tpveicoper_codtpveicoper_seq;
CREATE SEQUENCE public.usrhistsenha_codusrhistsenha_seq;

-------------------- CREATE TABLE --------------------

CREATE TABLE acao
(
	chave character varying (200) NOT NULL,
	codacao integer NOT NULL DEFAULT nextval('acao_codacao_seq'::regclass),
	icone character varying (200),
	menu boolean DEFAULT true,
	nome character varying (200) NOT NULL,
	ordem integer DEFAULT 0
);

CREATE TABLE agenda
(
	codagenda integer NOT NULL DEFAULT nextval('agenda_codagenda_seq'::regclass),
	codemp integer NOT NULL,
	dtavigencia date NOT NULL,
	id character varying (200) NOT NULL,
	intervalo integer NOT NULL DEFAULT 30
);

CREATE TABLE agendadescarga
(
	codagendadescarga integer NOT NULL DEFAULT nextval('agendadescarga_codagendadescarga_seq'::regclass),
	codembarque integer,
	codempcfgjanela integer,
	codempcfgturno integer,
	codempdest integer,
	codemporig integer,
	codemptra integer,
	codmot integer,
	codstatagendadescarga integer,
	codusrstatagendadescarga integer,
	codveic integer,
	descrstatagendadescarga character varying (50),
	dia_semana integer,
	dtahragendamento timestamp (6) with time zone,
	dtahrstatagendadescarga timestamp (6) with time zone DEFAULT now(),
	numnf character varying (20),
	placacarreta1 character varying (10),
	placacarreta2 character varying (10),
	produto_descr character varying (255),
	produto_peso numeric (7,2)  DEFAULT 0,
	produto_sapid character varying (50)
);

CREATE TABLE agendahr
(
	codagenda integer NOT NULL,
	codagendahr integer NOT NULL DEFAULT nextval('agendahr_codagendahr_seq'::regclass),
	codemp integer,
	hrfim time (6) without time zone NOT NULL,
	hrini time (6) without time zone NOT NULL,
	qtd integer NOT NULL
);

CREATE TABLE agendamento
(
	codagenda integer NOT NULL,
	codagendahr integer NOT NULL,
	codagendamento integer NOT NULL DEFAULT nextval('agendamento_codagendamento_seq'::regclass),
	codembarque integer NOT NULL,
	codmotivocancelado integer,
	codusrcancelado integer,
	dta date NOT NULL,
	dtahrcancelado timestamp (6) with time zone,
	extra boolean DEFAULT false,
	hrfim time (6) without time zone NOT NULL,
	hrini time (6) without time zone NOT NULL,
	obs text
);

CREATE TABLE ajuda
(
	codajuda integer NOT NULL DEFAULT nextval('ajuda_codajuda_seq'::regclass),
	codmodulo integer,
	codpai integer,
	dtahrcadastro timestamp (6) with time zone,
	ordem integer DEFAULT 0,
	titulo character varying (255)
);

CREATE TABLE bid
(
	ativo boolean DEFAULT false,
	codbid integer NOT NULL DEFAULT nextval('bid_codbid_seq'::regclass),
	codbidregiao integer NOT NULL,
	codcidufdestino integer NOT NULL,
	codciduforigem integer NOT NULL,
	codtpcarga integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL,
	dtavigencia date NOT NULL,
	inativomanual boolean DEFAULT false,
	prox_transp integer
);

CREATE TABLE bid_hist
(
	codbid integer NOT NULL,
	codbidtransp integer NOT NULL,
	dta date NOT NULL,
	dtavigencia date NOT NULL,
	embarques  integer []  DEFAULT '{}'::integer[],
	ofertas  integer []  DEFAULT '{}'::integer[],
	qtdofertado numeric NOT NULL DEFAULT 0,
	qtdrealizado numeric NOT NULL DEFAULT 0,
	qtdrecusado numeric NOT NULL DEFAULT 0
);

CREATE TABLE bid_regiao
(
	ativo boolean DEFAULT true,
	cidades  integer [] ,
	codbidregiao integer NOT NULL DEFAULT nextval('bid_regiao_codbidregiao_seq'::regclass),
	codemporig integer,
	codusralter integer,
	codusrincl integer,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone,
	nome character varying (120)
);

CREATE TABLE bid_spot
(
	codbidspot integer NOT NULL DEFAULT nextval('bid_spot_codbidspot_seq'::regclass),
	codcidufdestino integer NOT NULL,
	codciduforigem integer NOT NULL,
	codembarque integer,
	codemptra integer NOT NULL,
	codprogcoleta integer,
	codtpcarga integer NOT NULL,
	dtaoferta date NOT NULL,
	recusado boolean DEFAULT false
);

CREATE TABLE bid_transp
(
	codbid integer NOT NULL,
	codbidtransp integer NOT NULL DEFAULT nextval('bid_transp_codbidtransp_seq'::regclass),
	codemptra integer NOT NULL,
	embarques  integer []  DEFAULT '{}'::integer[],
	nivelpart double precision NOT NULL DEFAULT 0,
	nivelperform double precision NOT NULL DEFAULT 0,
	ofertas  integer []  DEFAULT '{}'::integer[],
	ordem integer NOT NULL DEFAULT 1,
	pctprev double precision NOT NULL DEFAULT 0,
	pctreal double precision NOT NULL DEFAULT 0,
	qtdofertado numeric NOT NULL DEFAULT 0,
	qtdrealizado numeric NOT NULL DEFAULT 0,
	qtdrecusado numeric NOT NULL DEFAULT 0,
	spots  integer []  DEFAULT '{}'::integer[]
);

CREATE TABLE carga
(
	agendamento_realizado integer DEFAULT (-1),
	boxagendamento character varying (20),
	codcarga bigint NOT NULL DEFAULT nextval('sq_codcarga'::regclass),
	codcargafluxo integer,
	codcargafluxoveic integer,
	codcargagrupo integer,
	codcargaorigem integer,
	codempdest integer,
	codempembar integer,
	codempjanela integer,
	codemporig integer,
	codemptnf integer,
	codemptra integer,
	codenderecodest integer,
	codenderecoorig integer,
	codigoexternoveic character varying (20),
	codmoeda integer NOT NULL DEFAULT 1,
	codmotivo integer,
	codpriembarque bigint,
	codproduto integer,
	codsitcarga integer DEFAULT 2,
	codstatcarga integer NOT NULL DEFAULT 1,
	codtpcarga integer,
	codtpevento integer,
	codtpoper integer,
	codtppalete integer,
	codtppriorsitcarga integer,
	codultembarque bigint,
	codusralter integer,
	codusrincl integer NOT NULL,
	codusrsitcarga integer,
	codusrstatcarga integer,
	descrmotivo text,
	descrsitcarga character varying (255),
	descrstatcarga character varying (20),
	distancia integer DEFAULT 0,
	dtahragendamento timestamp (6) with time zone,
	dtahragredespacho timestamp (6) with time zone,
	dtahralter timestamp (6) with time zone,
	dtahratrasado timestamp (6) with time zone,
	dtahrcancelado timestamp (6) with time zone,
	dtahrfim timestamp (6) with time zone,
	dtahrfimcoleta timestamp (6) with time zone,
	dtahrfimentrega timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	dtahrini timestamp (6) with time zone,
	dtahrinicoleta timestamp (6) with time zone,
	dtahrinientrega timestamp (6) with time zone,
	dtahrnaoatrasado timestamp (6) with time zone,
	dtahrprevcoleta timestamp (6) with time zone,
	dtahrpreventrega timestamp (6) with time zone,
	dtahrprevfimcoleta timestamp (6) with time zone,
	dtahrprevfimentrega timestamp (6) with time zone,
	dtahrprevfimtnf timestamp (6) with time zone,
	dtahrprevtnf timestamp (6) with time zone,
	dtahrsinistrado timestamp (6) with time zone,
	dtahrsitcarga timestamp (6) with time zone,
	dtahrstatcarga timestamp (6) with time zone DEFAULT now(),
	dtaremessa date,
	empdest_bairro character varying (50),
	empdest_cep character varying (10),
	empdest_codciduf integer,
	empdest_id character varying (30),
	empdest_logradouro character varying (255),
	empdest_nome character varying (100),
	empdest_nomeciduf character varying (50),
	empdest_pos_area  geometry ,
	empdest_pos_lat numeric (15,13) ,
	empdest_pos_long numeric (15,13) ,
	empembar_id character varying (30),
	empembar_nome character varying (100),
	emporig_bairro character varying (50),
	emporig_cep character varying (10),
	emporig_codciduf integer,
	emporig_id character varying (30),
	emporig_logradouro character varying (255),
	emporig_nome character varying (100),
	emporig_nomeciduf character varying (50),
	emporig_pos_area  geometry ,
	emporig_pos_lat numeric (15,13) ,
	emporig_pos_long numeric (15,13) ,
	emptnf_bairro character varying (50),
	emptnf_cep character varying (15),
	emptnf_codciduf integer,
	emptnf_id character varying (30),
	emptnf_logradouro character varying (255),
	emptnf_nome character varying (100),
	emptnf_nomeciduf character varying (50),
	emptnf_pos_area  geometry ,
	emptnf_pos_lat numeric (15,13) ,
	emptnf_pos_long numeric (15,13) ,
	emptra_id character varying (30),
	emptra_nome character varying (100),
	id character varying (30),
	isagendamento boolean NOT NULL DEFAULT false,
	moeda_sigla character varying (10),
	numdoc character varying (20),
	numnf character varying (20),
	numpalete integer DEFAULT 0,
	numped character varying (30),
	numvol integer NOT NULL DEFAULT 1,
	obsagendamento text,
	obscarga text,
	pendencias  text [] ,
	peso numeric (7,2)  NOT NULL DEFAULT 0,
	pesods numeric (7,2) ,
	prazo integer DEFAULT 0,
	principal boolean DEFAULT true,
	senhaagendamento character varying (30),
	temdelivery boolean DEFAULT false,
	temextrainfo boolean NOT NULL DEFAULT false,
	temlembrete boolean NOT NULL DEFAULT false,
	temocorrencia boolean NOT NULL DEFAULT false,
	tempendencias boolean DEFAULT false,
	tempendenciasds boolean DEFAULT false,
	tempoprevcoleta integer NOT NULL DEFAULT 0,
	tempopreventrega integer NOT NULL DEFAULT 0,
	tnfid character varying (20),
	tpcarga_descr character varying (255),
	tpcarga_id character varying (30),
	tpcarga_tempmaxima numeric (10,2) ,
	tpcarga_tempminima numeric (10,2) ,
	tpevento_nome character varying (200),
	tpoper_descr character varying (20),
	tpoper_redespacho boolean DEFAULT false,
	venda boolean DEFAULT false,
	vlr numeric (11,2)  NOT NULL DEFAULT 0,
	vol numeric (7,2)  NOT NULL DEFAULT 0
);

CREATE TABLE carga_antiga
(
	agendamento_realizado integer DEFAULT (-1),
	boxagendamento character varying (20),
	codcarga bigint NOT NULL DEFAULT nextval('sq_codcarga'::regclass),
	codcargafluxo integer,
	codcargafluxoveic integer,
	codcargagrupo integer,
	codcargaorigem integer,
	codempdest integer,
	codempembar integer,
	codempjanela integer,
	codemporig integer,
	codemptnf integer,
	codemptra integer,
	codenderecodest integer,
	codenderecoorig integer,
	codmoeda integer NOT NULL DEFAULT 1,
	codmotivo integer,
	codpriembarque bigint,
	codsitcarga integer DEFAULT 2,
	codstatcarga integer NOT NULL DEFAULT 1,
	codtpcarga integer,
	codtpevento integer,
	codtpoper integer,
	codtppalete integer,
	codtppriorsitcarga integer,
	codultembarque bigint,
	codusralter integer,
	codusrincl integer NOT NULL,
	codusrsitcarga integer,
	codusrstatcarga integer,
	descrmotivo text,
	descrsitcarga character varying (255),
	descrstatcarga character varying (20),
	distancia integer DEFAULT 0,
	dtahragendamento timestamp (6) with time zone,
	dtahragredespacho timestamp (6) with time zone,
	dtahralter timestamp (6) with time zone,
	dtahratrasado timestamp (6) with time zone,
	dtahrcancelado timestamp (6) with time zone,
	dtahrfim timestamp (6) with time zone,
	dtahrfimcoleta timestamp (6) with time zone,
	dtahrfimentrega timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	dtahrini timestamp (6) with time zone,
	dtahrinicoleta timestamp (6) with time zone,
	dtahrinientrega timestamp (6) with time zone,
	dtahrnaoatrasado timestamp (6) with time zone,
	dtahrprevcoleta timestamp (6) with time zone,
	dtahrpreventrega timestamp (6) with time zone,
	dtahrprevfimcoleta timestamp (6) with time zone,
	dtahrprevfimentrega timestamp (6) with time zone,
	dtahrprevfimtnf timestamp (6) with time zone,
	dtahrprevtnf timestamp (6) with time zone,
	dtahrsinistrado timestamp (6) with time zone,
	dtahrsitcarga timestamp (6) with time zone,
	dtahrstatcarga timestamp (6) with time zone DEFAULT now(),
	dtaremessa date,
	empdest_bairro character varying (50),
	empdest_cep character varying (10),
	empdest_codciduf integer,
	empdest_id character varying (30),
	empdest_logradouro character varying (255),
	empdest_nome character varying (100),
	empdest_nomeciduf character varying (50),
	empdest_pos_area  geometry ,
	empdest_pos_lat numeric (15,13) ,
	empdest_pos_long numeric (15,13) ,
	empembar_id character varying (30),
	empembar_nome character varying (100),
	emporig_bairro character varying (50),
	emporig_cep character varying (10),
	emporig_codciduf integer,
	emporig_id character varying (30),
	emporig_logradouro character varying (255),
	emporig_nome character varying (100),
	emporig_nomeciduf character varying (50),
	emporig_pos_area  geometry ,
	emporig_pos_lat numeric (15,13) ,
	emporig_pos_long numeric (15,13) ,
	emptnf_bairro character varying (50),
	emptnf_cep character varying (15),
	emptnf_codciduf integer,
	emptnf_id character varying (30),
	emptnf_logradouro character varying (255),
	emptnf_nome character varying (100),
	emptnf_nomeciduf character varying (50),
	emptnf_pos_area  geometry ,
	emptnf_pos_lat numeric (15,13) ,
	emptnf_pos_long numeric (15,13) ,
	emptra_id character varying (30),
	emptra_nome character varying (100),
	id character varying (30),
	isagendamento boolean NOT NULL DEFAULT false,
	moeda_sigla character varying (10),
	numdoc character varying (20),
	numnf character varying (20),
	numpalete integer DEFAULT 0,
	numped character varying (30),
	numvol integer NOT NULL DEFAULT 1,
	obsagendamento text,
	obscarga text,
	pendencias  text [] ,
	peso numeric (7,2)  NOT NULL DEFAULT 0,
	pesods numeric (7,2) ,
	prazo integer DEFAULT 0,
	principal boolean DEFAULT true,
	senhaagendamento character varying (30),
	temdelivery boolean DEFAULT false,
	temextrainfo boolean NOT NULL DEFAULT false,
	temlembrete boolean NOT NULL DEFAULT false,
	temocorrencia boolean NOT NULL DEFAULT false,
	tempendencias boolean DEFAULT false,
	tempendenciasds boolean DEFAULT false,
	tempoprevcoleta integer NOT NULL DEFAULT 0,
	tempopreventrega integer NOT NULL DEFAULT 0,
	tnfid character varying (20),
	tpcarga_descr character varying (255),
	tpcarga_id character varying (30),
	tpcarga_tempmaxima numeric (10,2) ,
	tpcarga_tempminima numeric (10,2) ,
	tpevento_nome character varying (200),
	tpoper_descr character varying (20),
	tpoper_redespacho boolean DEFAULT false,
	venda boolean DEFAULT false,
	vlr numeric (11,2)  NOT NULL DEFAULT 0,
	vol numeric (7,2)  NOT NULL DEFAULT 0
);

CREATE TABLE cargaautooferta
(
	cargas  bigint []  DEFAULT '{}'::bigint[],
	codbid integer,
	codcarga bigint NOT NULL,
	codcargagrupo integer,
	codemptra  bigint []  DEFAULT '{}'::bigint[],
	motivos  varchar []  DEFAULT '{}'::character varying[]
);

CREATE TABLE cargafluxo
(
	ativo boolean DEFAULT true,
	automatico boolean DEFAULT false,
	circuito boolean DEFAULT false,
	codcargafluxo integer NOT NULL DEFAULT nextval('cargafluxo_codcargafluxo_seq'::regclass),
	codemporig integer,
	codultemp integer,
	descr character varying (200) NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL,
	embarques  integer []  DEFAULT '{}'::integer[],
	id character varying (100) NOT NULL,
	transportadoras  integer []  DEFAULT '{}'::integer[],
	veiculos  integer []  DEFAULT '{}'::integer[]
);

CREATE TABLE cargafluxoemp
(
	codcargafluxo integer NOT NULL,
	codcargafluxoemp integer NOT NULL DEFAULT nextval('cargafluxoemp_codcargafluxoemp_seq'::regclass),
	codempdest integer,
	codemporig integer
);

CREATE TABLE cargafluxoveic
(
	ativo boolean DEFAULT true,
	codcargafluxo integer NOT NULL,
	codcargafluxoveic integer NOT NULL DEFAULT nextval('cargafluxoveic_codcargafluxoveic_seq'::regclass),
	codembarque integer,
	codemptra integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	codveic integer,
	dtahralter timestamp (6) with time zone,
	dtahrinativo timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL,
	embarques  integer []  DEFAULT '{}'::integer[],
	id character varying (40) NOT NULL
);

CREATE TABLE cargagrupo
(
	agendamento_realizado integer DEFAULT (-1),
	ativo boolean DEFAULT true,
	cargas  integer []  DEFAULT '{}'::integer[],
	codcargagrupo integer NOT NULL DEFAULT nextval('cargagrupo_codcargagrupo_seq'::regclass),
	codempjanela integer,
	codtpcarga integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	cor character varying (10),
	dtahralter timestamp (6) with time zone,
	dtahrcoleta timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL DEFAULT now(),
	dtaremessa date,
	editavel boolean DEFAULT true,
	id character varying (60) NOT NULL,
	observacoes character varying (255),
	pendencias  text [] ,
	prioridade integer NOT NULL,
	tempendencias boolean DEFAULT false,
	tempendenciasds boolean DEFAULT false,
	totnumvol integer,
	totpalete integer,
	totpeso double precision,
	totpesods double precision,
	totvol double precision,
	tpcarga_descr character varying (100)
);

CREATE TABLE carreta
(
	ativo boolean NOT NULL DEFAULT true,
	codcarreta integer NOT NULL DEFAULT nextval('sq_codcarreta'::regclass),
	codtecrastr integer,
	codtpcarreta integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	id character varying (30) NOT NULL,
	idequiprastr character varying (25),
	modelo character varying (20),
	ultpos_descr character varying (255),
	ultpos_dtahr timestamp (6) with time zone,
	ultpos_lat numeric (15,13) ,
	ultpos_long numeric (15,13) 
);

CREATE TABLE cfgdash
(
	ativo boolean DEFAULT true,
	codcfgdash smallint NOT NULL,
	codusralter smallint,
	codusrincl smallint NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	newxml xml,
	nome character varying (50) NOT NULL,
	xml text
);

CREATE TABLE ciduf
(
	capital boolean NOT NULL,
	codciduf integer NOT NULL DEFAULT nextval('sq_ciduf_codciduf'::regclass),
	codpais integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	ddd integer,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	fusohr integer NOT NULL,
	hrverao boolean NOT NULL,
	nome character varying (50) NOT NULL,
	pos_lat numeric (15,13) ,
	pos_long numeric (15,13) ,
	siglaregiao character (2),
	siglauf character (4)
);

CREATE TABLE config
(
	ativo boolean NOT NULL DEFAULT true,
	codtpconfig integer NOT NULL,
	codusralter integer,
	codusrincl integer,
	descr character varying (255) NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone,
	editavel boolean NOT NULL DEFAULT false,
	nome character varying (50) NOT NULL,
	porusuario boolean NOT NULL DEFAULT false,
	vlratual text NOT NULL,
	vlrpadrao text NOT NULL
);

CREATE TABLE conta
(
	ativo boolean DEFAULT true,
	codconta integer NOT NULL DEFAULT nextval('conta_codconta_seq'::regclass),
	grpembarcador boolean NOT NULL DEFAULT false,
	nome character varying (100) NOT NULL
);

CREATE TABLE contato
(
	area character varying (30),
	ativo boolean NOT NULL DEFAULT true,
	codcontato integer NOT NULL DEFAULT nextval('contato_codcontato_seq'::regclass),
	codemp integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	email character varying (255),
	funcao character varying (30),
	nome character varying (100) NOT NULL,
	recebealerta boolean NOT NULL DEFAULT false,
	telefone character varying (100)
);

CREATE TABLE dados_integracao
(
	codregistro bigint NOT NULL DEFAULT nextval('dados_integracao_codregistro_seq'::regclass),
	dtahrenviado timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	dtahrtentativa timestamp (6) with time zone,
	mensagem text DEFAULT '{}'::text,
	status_retorno boolean DEFAULT false,
	tentativas integer DEFAULT 0,
	texto_retorno text DEFAULT ''::text,
	tipo character varying (20) NOT NULL
);

CREATE TABLE emailregra
(
	chave character varying (50) NOT NULL,
	codemailregra integer NOT NULL DEFAULT nextval('emailregra_codemailregra_seq'::regclass),
	descr character varying (50) NOT NULL,
	recebeemaillogado boolean DEFAULT false
);

CREATE TABLE emailregrausr
(
	codemailregra integer,
	codusr integer
);

CREATE TABLE emailtosend
(
	anexos text,
	codcarga bigint,
	codemailtosend bigint NOT NULL DEFAULT nextval('sq_codemailtosend'::regclass),
	codembarque bigint,
	codemp integer,
	codtemplateemail character varying (250) NOT NULL,
	codusrincl integer NOT NULL,
	destinatarioemail character varying (250) NOT NULL,
	destinatarionome character varying (250) NOT NULL,
	dtahrenvio timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	msg text,
	ocultar_listagem boolean DEFAULT false,
	remetenteemail character varying (250) NOT NULL,
	remetentenome character varying (250) NOT NULL,
	statusenvio boolean DEFAULT false,
	subject character varying (250) NOT NULL
);

CREATE TABLE embarque
(
	agendamento_notificado boolean DEFAULT false,
	agendamento_realizado integer DEFAULT 0,
	alertatemperatura boolean DEFAULT false,
	anteriores  integer []  DEFAULT '{}'::integer[],
	cargaagendada boolean DEFAULT false,
	cargasid text DEFAULT '{}'::text,
	circuitoid character varying (60),
	climatizada boolean DEFAULT false,
	codagendadescarga integer,
	codbidtransp integer,
	codcargafluxo integer,
	codembarque bigint NOT NULL DEFAULT nextval('sq_codembarque'::regclass),
	codempdest integer,
	codempembar integer,
	codemporig integer,
	codemptnf integer,
	codemptra integer,
	codigogr character varying (30) DEFAULT ''::character varying,
	codmoeda integer,
	codmot1 integer,
	codmot2 integer,
	codprogcoleta integer,
	codrastrmovel integer,
	codrota integer,
	codsitembarque integer DEFAULT 2,
	codstatagendadescarga integer,
	codstatembarque integer NOT NULL DEFAULT 1,
	codtpcarga  integer [] ,
	codtpevento integer,
	codtpoper integer,
	codtppriorsitembarque integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	codusrsitembarque integer,
	codusrstatagendadescarga integer,
	codusrstatembarque integer NOT NULL,
	codveic integer,
	considerarbid boolean DEFAULT true,
	ctrlcarregamento boolean DEFAULT false,
	ctrldescarregamento boolean DEFAULT false,
	descrsitembarque character varying (255),
	descrstatagendadescarga character varying (50),
	descrstatembarque character varying (20) NOT NULL,
	distanciapercorrida double precision DEFAULT 0,
	distanciatotal double precision,
	docacoleta character varying (50),
	docaentrega character varying (50),
	dtahragendadescarga timestamp (6) with time zone,
	dtahralter timestamp (6) with time zone,
	dtahratrasado timestamp (6) with time zone,
	dtahrcancelado timestamp (6) with time zone,
	dtahrfim timestamp (6) with time zone,
	dtahrfimcalculada timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	dtahrini timestamp (6) with time zone,
	dtahrinicalculada timestamp (6) with time zone,
	dtahrinidestino timestamp (6) with time zone,
	dtahriniplanta timestamp (6) with time zone,
	dtahrnaoatrasado timestamp (6) with time zone,
	dtahrprevfim timestamp (6) with time zone,
	dtahrprevfimtnf timestamp (6) with time zone,
	dtahrprevini timestamp (6) with time zone,
	dtahrprevinicoleta timestamp (6) with time zone,
	dtahrprevtnf timestamp (6) with time zone,
	dtahrrecalculo timestamp (6) with time zone,
	dtahrretorno timestamp (6) with time zone,
	dtahrsinistrado timestamp (6) with time zone,
	dtahrsitembarque timestamp (6) with time zone,
	dtahrstatagendadescarga timestamp (6) with time zone DEFAULT now(),
	dtahrstatembarque timestamp (6) with time zone DEFAULT now(),
	dtaremessa date,
	empdest_codciduf integer,
	empdest_id character varying (30),
	empdest_nome character varying (100),
	empdest_nomeciduf character varying (50),
	empdest_pos_area  geometry ,
	empdest_pos_lat numeric (15,13) ,
	empdest_pos_long numeric (15,13) ,
	empembar_codciduf integer,
	empembar_id character varying (30),
	empembar_nome character varying (100),
	empembar_nomeciduf character varying (50),
	empembar_pos_area  geometry ,
	empembar_pos_lat numeric (15,13) ,
	empembar_pos_long numeric (15,13) ,
	emporig_codciduf integer,
	emporig_id character varying (30),
	emporig_nome character varying (100),
	emporig_nomeciduf character varying (50),
	emporig_pos_area  geometry ,
	emporig_pos_lat numeric (15,13) ,
	emporig_pos_long numeric (15,13) ,
	emptnf_bairro character varying (50),
	emptnf_cep character varying (15),
	emptnf_codciduf integer,
	emptnf_id character varying (30),
	emptnf_logradouro character varying (255),
	emptnf_nome character varying (100),
	emptnf_nomeciduf character varying (50),
	emptnf_pos_area  geometry ,
	emptnf_pos_lat numeric (15,13) ,
	emptnf_pos_long numeric (15,13) ,
	emptra_codciduf integer,
	emptra_id character varying (30),
	emptra_nome character varying (100),
	emptra_nomeciduf character varying (50),
	emptra_pos_area  geometry ,
	emptra_pos_lat numeric (15,13) ,
	emptra_pos_long numeric (15,13) ,
	entregaparcial boolean DEFAULT false,
	etapascircuito  integer []  DEFAULT '{}'::integer[],
	id character varying (30),
	incotermid integer NOT NULL DEFAULT 0,
	incotermnome character varying (50),
	moeda_sigla character varying (10),
	mot1_id character varying (30),
	mot1_nome character varying (50),
	mot2_id character varying (30),
	mot2_nome character varying (50),
	notificado boolean NOT NULL DEFAULT false,
	placacarreta character varying (10),
	placacarreta2 character varying (10),
	rastrmovel_codtecrastr integer,
	rastrmovel_idequiprastr character varying (25),
	rastrmovel_modelo character varying (20),
	rastrmovel_nometecrastr character varying (50),
	rastrmovel_ultpos_descr character varying (255),
	rastrmovel_ultpos_dtahr timestamp (6) with time zone,
	rastrmovel_ultpos_lat numeric (15,13) ,
	rastrmovel_ultpos_long numeric (15,13) ,
	rota_descr character varying (255),
	rota_id character varying (30),
	rota_progpos  geometry ,
	semagendamento boolean,
	temextrainfo boolean NOT NULL DEFAULT false,
	temlembrete boolean NOT NULL DEFAULT false,
	temocorrencia boolean NOT NULL DEFAULT false,
	temregtemp boolean DEFAULT false,
	temretorno boolean NOT NULL DEFAULT false,
	totnumpalete integer NOT NULL DEFAULT 0,
	totnumvol integer NOT NULL DEFAULT 1,
	totpeso numeric (7,2)  NOT NULL DEFAULT 0,
	totprevcoleta integer NOT NULL DEFAULT 0,
	totpreventrega integer NOT NULL DEFAULT 0,
	totrealcoleta integer NOT NULL DEFAULT 0,
	totrealentrega integer NOT NULL DEFAULT 0,
	totvlr numeric (11,2)  NOT NULL DEFAULT 0,
	totvol numeric (7,2)  NOT NULL DEFAULT 0,
	tpcarga_templimitemaximo numeric (7,2)  DEFAULT 0,
	tpcarga_templimiteminimo numeric (7,2)  DEFAULT 0,
	tpcarga_tempnormalmaximo numeric (7,2)  DEFAULT 0,
	tpcarga_tempnormalminimo numeric (7,2)  DEFAULT 0,
	tpevento_nome character varying (200),
	ufcarreta character (2),
	veic_codtecrastr integer,
	veic_cor character varying (20),
	veic_id character varying (30),
	veic_idequiprastr character varying (25),
	veic_modelo character varying (30),
	veic_nometecrastr character varying (50),
	veic_ultpos_descr character varying (255),
	veic_ultpos_dtahr timestamp (6) with time zone,
	veic_ultpos_lat numeric (15,13) ,
	veic_ultpos_long numeric (15,13) ,
	warningtemperatura boolean DEFAULT false
);

CREATE TABLE embarquealertatemp
(
	codembarque integer NOT NULL,
	codempembar integer NOT NULL,
	codemptra integer NOT NULL,
	dtahr timestamp (6) with time zone,
	pos_lat numeric (15,13) ,
	pos_long numeric (15,13) ,
	tempinformada numeric (10,2) ,
	tempmaxima numeric (10,2) ,
	tempminima numeric (10,2) 
);

CREATE TABLE embarquecarga
(
	codcarga bigint NOT NULL,
	codembarque bigint NOT NULL,
	codembarquecarga bigint NOT NULL DEFAULT nextval('sq_codembarquecarga'::regclass),
	codempdest integer,
	codemporig integer,
	codemptnf integer,
	codemptra integer,
	codenderecodest integer,
	codmotivo integer,
	codrastrmovel integer,
	codtpevento integer,
	codtpoper integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	distancia integer DEFAULT 0,
	distanciapercorrida double precision,
	dtahralter timestamp (6) with time zone,
	dtahrcancelado timestamp (6) with time zone,
	dtahrfimcalculada timestamp (6) with time zone,
	dtahrfimcoleta timestamp (6) with time zone,
	dtahrfimentrega timestamp (6) with time zone,
	dtahrfimtnf timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	dtahrinicoleta timestamp (6) with time zone,
	dtahrinientrega timestamp (6) with time zone,
	dtahrinitnf timestamp (6) with time zone,
	dtahrprevcoleta timestamp (6) with time zone,
	dtahrpreventrega timestamp (6) with time zone,
	dtahrprevfimcoleta timestamp (6) with time zone,
	dtahrprevfimentrega timestamp (6) with time zone,
	dtahrprevfimtnf timestamp (6) with time zone,
	dtahrprevtnf timestamp (6) with time zone,
	empdest_bairro character varying (50),
	empdest_cep character varying (10),
	empdest_codciduf integer,
	empdest_id character varying (30),
	empdest_logradouro character varying (255),
	empdest_nome character varying (100),
	empdest_nomeciduf character varying (50),
	empdest_pos_area  geometry ,
	empdest_pos_lat numeric (15,13) ,
	empdest_pos_long numeric (15,13) ,
	emporig_bairro character varying (50),
	emporig_cep character varying (10),
	emporig_codciduf integer,
	emporig_id character varying (30),
	emporig_logradouro character varying (255),
	emporig_nome character varying (100),
	emporig_nomeciduf character varying (50),
	emporig_pos_area  geometry ,
	emporig_pos_lat numeric (15,13) ,
	emporig_pos_long numeric (15,13) ,
	emptnf_bairro character varying (50),
	emptnf_cep character varying (15),
	emptnf_codciduf integer,
	emptnf_id character varying (30),
	emptnf_logradouro character varying (255),
	emptnf_nome character varying (100),
	emptnf_nomeciduf character varying (50),
	emptnf_pos_area  geometry ,
	emptnf_pos_lat numeric (15,13) ,
	emptnf_pos_long numeric (15,13) ,
	emptra_codciduf integer,
	emptra_id character varying (30),
	emptra_nome character varying (100),
	emptra_nomeciduf character varying (50),
	emptra_pos_area  geometry ,
	emptra_pos_lat numeric (15,13) ,
	emptra_pos_long numeric (15,13) ,
	prazo integer DEFAULT 0,
	rastrmovel_codtecrastr integer,
	rastrmovel_idequiprastr character varying (25),
	rastrmovel_modelo character varying (20),
	rastrmovel_nometecrastr character varying (50),
	rastrmovel_ultpos_descr character varying (255),
	rastrmovel_ultpos_dtahr timestamp (6) with time zone,
	rastrmovel_ultpos_lat numeric (15,13) ,
	rastrmovel_ultpos_long numeric (15,13) ,
	tempoprevcoleta integer NOT NULL DEFAULT 0,
	tempopreventrega integer NOT NULL DEFAULT 0,
	tpcarga_tempmaxima numeric (10,2) ,
	tpcarga_tempminima numeric (10,2) ,
	tpevento_nome character varying (200)
);

CREATE TABLE embarquecarreta
(
	carreta_codtecrastr integer,
	carreta_id character varying (30) NOT NULL,
	carreta_idequiprastr character varying (25),
	carreta_modelo character varying (20),
	carreta_nometecrastr character varying (50),
	carreta_ultpos_descr character varying (255),
	carreta_ultpos_dtahr timestamp (6) with time zone,
	carreta_ultpos_lat numeric (15,13) ,
	carreta_ultpos_long numeric (15,13) ,
	codcarreta integer,
	codembarque bigint NOT NULL,
	codembarquecarreta bigint NOT NULL DEFAULT nextval('sq_codembarquecarreta'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now()
);

CREATE TABLE embartransp
(
	codembartransp integer NOT NULL DEFAULT nextval('sq_codembartransp'::regclass),
	codempembar integer,
	codemptra integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	perccontrato numeric (7,2)  NOT NULL DEFAULT 0
);

CREATE TABLE emp
(
	agendamento boolean DEFAULT false,
	apelido character varying (100),
	ativo boolean NOT NULL DEFAULT true,
	bairro character varying (50),
	broker boolean DEFAULT false,
	cargacompartilhada boolean DEFAULT false,
	cep character varying (10),
	cli boolean NOT NULL DEFAULT false,
	codciduf integer,
	codconta integer,
	codemp integer NOT NULL DEFAULT nextval('sq_codemp'::regclass),
	codempembar integer,
	codexpediente integer,
	codtpeventocjtocoleta integer,
	codtpeventocjtoentrega integer,
	codtpoper integer,
	codtppalete integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	cpfcnpj character varying (14),
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	email character varying (255),
	embar boolean NOT NULL DEFAULT false,
	embarqueautomatico boolean DEFAULT false,
	embar_tempopermanencia integer DEFAULT 180,
	forn boolean NOT NULL DEFAULT false,
	id character varying (30),
	id2 character varying (30),
	logo bytea,
	logradouro character varying (255),
	maxnumvol integer,
	maxpaletes integer,
	maxpeso integer,
	maxvol integer,
	nome character varying (100) NOT NULL,
	obs text,
	obscargas text,
	pos_area  geometry ,
	pos_lat numeric (15,13) ,
	pos_long numeric (15,13) ,
	pos_manual boolean NOT NULL DEFAULT false,
	pos_raio integer NOT NULL DEFAULT 200,
	tempocoletacircuito integer DEFAULT 90,
	tempoentregacircuito integer DEFAULT 45,
	tpveic  integer []  DEFAULT '{}'::integer[],
	transp boolean NOT NULL DEFAULT false,
	unid boolean DEFAULT false,
	usaragendadescarga boolean DEFAULT false,
	usardockscheduling boolean DEFAULT false
);

CREATE TABLE empcfgjanela
(
	ativo boolean NOT NULL DEFAULT true,
	codconta integer NOT NULL,
	codempcfgjanela integer NOT NULL DEFAULT nextval('empcfgjanela_codempcfgjanela_seq'::regclass),
	codempdest integer NOT NULL,
	codemporigem integer,
	codtpcarga integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	dia_semana integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL DEFAULT now(),
	vagasturno text NOT NULL
);

CREATE TABLE empcfgturno
(
	ativo boolean NOT NULL DEFAULT true,
	codempcfgturno integer NOT NULL DEFAULT nextval('empcfgturno_codempcfgturno_seq'::regclass),
	hrfim time (6) without time zone NOT NULL,
	hrini time (6) without time zone NOT NULL,
	idintegracao integer NOT NULL
);

CREATE TABLE empendereco
(
	ativo boolean DEFAULT true,
	bairro character varying (50),
	cep character varying (10),
	codciduf integer,
	codemp integer NOT NULL,
	codempendereco integer NOT NULL DEFAULT nextval('empendereco_codempendereco_seq'::regclass),
	intervalojanelas integer DEFAULT 120,
	logradouro character varying (255),
	padrao boolean DEFAULT false,
	pos_area  geometry ,
	pos_lat numeric (15,13) ,
	pos_long numeric (15,13) ,
	pos_raio integer NOT NULL DEFAULT 200
);

CREATE TABLE empjanela
(
	ano integer,
	cargas  bigint []  DEFAULT '{}'::bigint[],
	codemp integer NOT NULL,
	codempendereco integer NOT NULL,
	codempjanela integer NOT NULL DEFAULT nextval('empjanela_codempjanela_seq'::regclass),
	codempjanelahist integer,
	codjanelaoriginal integer,
	dia integer,
	dia_semana integer,
	dtahrfim timestamp (6) with time zone,
	dtahrini timestamp (6) with time zone,
	fim time (6) without time zone,
	inicio time (6) without time zone,
	limite integer,
	limitegrupos integer DEFAULT 0,
	mes integer,
	target integer,
	totgrupos integer DEFAULT 0,
	totpesocalc double precision DEFAULT 0,
	totpesoreal double precision DEFAULT 0
);

CREATE TABLE empjanelahist
(
	ativo boolean DEFAULT true,
	codemp integer NOT NULL,
	codempendereco integer NOT NULL,
	codempjanelahist integer NOT NULL DEFAULT nextval('empjanelahist_codempjanelahist_seq'::regclass),
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone,
	fatores text,
	janelas text
);

CREATE TABLE empjanelapeso
(
	codempendereco integer NOT NULL,
	codtpoper integer NOT NULL,
	peso numeric (5,2) 
);

CREATE TABLE equiprastr
(
	codentidade integer NOT NULL,
	codequiprastr bigint NOT NULL DEFAULT nextval('sq_codequiprastr'::regclass),
	codtecrastr integer NOT NULL,
	codtpentidade integer NOT NULL,
	dtahrstatus timestamp (6) with time zone NOT NULL DEFAULT now(),
	idequiprastr character varying (25) NOT NULL,
	status character (1) NOT NULL DEFAULT 'I'::bpchar
);

CREATE TABLE evento
(
	codembarque integer,
	codembarquecarga bigint,
	codevento bigint NOT NULL DEFAULT nextval('sq_codevento'::regclass),
	codtpevento integer NOT NULL,
	codusralter integer,
	codusrincl bigint NOT NULL,
	dtahralter timestamp (6) with time zone DEFAULT now(),
	dtahrevento timestamp (6) with time zone DEFAULT now(),
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	veic_id character varying (255)
);

CREATE TABLE expediente
(
	ativo boolean DEFAULT true,
	codexpediente integer NOT NULL DEFAULT nextval('expediente_codexpediente_seq'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL,
	nome character varying (100) NOT NULL,
	padrao boolean DEFAULT false
);

CREATE TABLE expedientehorario
(
	codexpediente integer NOT NULL,
	codexpedientehorario integer NOT NULL DEFAULT nextval('expedientehorario_codexpedientehorario_seq'::regclass),
	dia_inteiro boolean,
	dia_semana integer NOT NULL,
	fim time (6) without time zone,
	inicio time (6) without time zone,
	sem_expediente boolean
);

CREATE TABLE extrainfo
(
	codcarga bigint,
	codembarque bigint,
	codextrainfo bigint NOT NULL DEFAULT nextval('sq_codextrainfo'::regclass),
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	editavel boolean NOT NULL DEFAULT true,
	nome character varying (50) NOT NULL,
	valor text
);

CREATE TABLE faq
(
	cliques integer DEFAULT 0,
	codfaq integer NOT NULL DEFAULT nextval('faq_codfaq_seq'::regclass),
	dtahrcadastro timestamp (6) with time zone,
	ordem integer,
	titulo character varying (255)
);

CREATE TABLE feriado
(
	ano integer,
	codciduf integer,
	codferiado integer NOT NULL DEFAULT nextval('feriado_codferiado_seq'::regclass),
	codtpferiado integer NOT NULL,
	descricao text,
	dia integer,
	excecoes  integer []  DEFAULT '{}'::integer[],
	expediente boolean DEFAULT false,
	facultativo boolean DEFAULT false,
	mes integer,
	nome character varying (200),
	repete_ano integer,
	repete_dia_semana integer,
	repete_semana_mes integer,
	uf character varying (3)
);

CREATE TABLE filapos
(
	angulo numeric (4,1) ,
	codpos bigint NOT NULL,
	codptoref integer,
	codtecrastr integer NOT NULL,
	dist numeric (8,2) ,
	dtahr timestamp (6) with time zone NOT NULL,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	dtahrtecrastr timestamp (6) with time zone NOT NULL,
	idequiprastr character varying (25) NOT NULL,
	ignicao integer,
	lat numeric (15,13)  NOT NULL,
	long numeric (15,13)  NOT NULL,
	nomeptoref character varying (255),
	tpptoref integer,
	veloc integer
);

CREATE TABLE filatemp
(
	codtecrastr integer NOT NULL,
	codtemp bigint NOT NULL,
	dtahr timestamp (6) with time zone NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL DEFAULT now(),
	dtahrtecrastr timestamp (6) with time zone NOT NULL,
	idequiprastr character varying (25) NOT NULL,
	lat numeric (15,13)  NOT NULL,
	long numeric (15,13)  NOT NULL,
	sensor integer NOT NULL DEFAULT 1,
	temperatura numeric (10,2)  NOT NULL
);

CREATE TABLE geometry_columns
(
	coord_dimension integer NOT NULL,
	f_geometry_column character varying (256) NOT NULL,
	f_table_catalog character varying (256) NOT NULL,
	f_table_name character varying (256) NOT NULL,
	f_table_schema character varying (256) NOT NULL,
	srid integer NOT NULL,
	type character varying (30) NOT NULL
);

CREATE TABLE grp
(
	ativo boolean NOT NULL DEFAULT true,
	codgrp integer NOT NULL DEFAULT nextval('sq_codgrp'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	descr text,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	editavel boolean NOT NULL DEFAULT true,
	interno boolean NOT NULL DEFAULT false,
	ips text DEFAULT ''::text,
	isadm boolean DEFAULT false,
	nome character varying (50) NOT NULL
);

CREATE TABLE grpemp
(
	codemp integer NOT NULL,
	codgrp integer NOT NULL,
	codgrpemp integer NOT NULL DEFAULT nextval('grpemp_codgrpemp_seq'::regclass),
	tipoemp character varying (20)
);

CREATE TABLE grpusr
(
	ativo boolean NOT NULL DEFAULT true,
	codgrp integer NOT NULL,
	codgrpusr integer NOT NULL DEFAULT nextval('sq_codgrpusr'::regclass),
	codusr integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now()
);

CREATE TABLE histanotocor
(
	anot text NOT NULL,
	codhistanotocor bigint NOT NULL DEFAULT nextval('sq_codhistanotocor'::regclass),
	codocor bigint NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone DEFAULT now()
);

CREATE TABLE histcompl
(
	codcarga bigint NOT NULL,
	codentidade integer NOT NULL,
	codhistcompl integer NOT NULL DEFAULT nextval('histcompl_codhistcompl_seq'::regclass),
	codtpentidade integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL,
	nomeresp character varying (100),
	tpoper integer NOT NULL
);

CREATE TABLE histempjanelapeso
(
	codempendereco integer NOT NULL,
	codempjanelahist integer NOT NULL,
	codtpoper integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	peso numeric (5,2)  NOT NULL
);

CREATE TABLE histemppos
(
	codemp integer NOT NULL,
	codhistemppos integer NOT NULL DEFAULT nextval('histemppos_codhistemppos_seq'::regclass),
	codusrincl integer NOT NULL,
	dtahr timestamp (6) with time zone,
	pos_area  geometry ,
	pos_lat numeric (15,13) ,
	pos_long numeric (15,13) ,
	pos_manual boolean NOT NULL DEFAULT false,
	pos_raio integer NOT NULL DEFAULT 200
);

CREATE TABLE histmotivoembcarga
(
	codembarquecarga integer NOT NULL,
	codhistmotivoembcarga integer NOT NULL DEFAULT nextval('histmotivoembcarga_codhistmotivoembcarga_seq'::regclass),
	codmotivo integer NOT NULL,
	dtahrmotivo timestamp (6) with time zone
);

CREATE TABLE histpreventrega
(
	codcarga bigint NOT NULL,
	codhistpreventrega integer NOT NULL DEFAULT nextval('sq_codhistpreventrega'::regclass),
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL DEFAULT now(),
	dtahrpreventrega timestamp (6) with time zone,
	isagendamento boolean NOT NULL DEFAULT false,
	motivo character varying (255) NOT NULL
);

CREATE TABLE histsitcarga
(
	codcarga bigint NOT NULL,
	codhistsitcarga bigint NOT NULL DEFAULT nextval('sq_codhistsitcarga'::regclass),
	codsitcarga integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	sitcarga_defineatraso boolean NOT NULL,
	sitcarga_descr character varying (255) NOT NULL,
	sitcarga_tiraatraso boolean NOT NULL
);

CREATE TABLE histsitembarque
(
	codembarque bigint NOT NULL,
	codhistsitembarque bigint NOT NULL DEFAULT nextval('sq_codhistsitembarque'::regclass),
	codsitembarque integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	sitembarque_defineatraso boolean NOT NULL,
	sitembarque_defineretorno boolean NOT NULL,
	sitembarque_descr character varying (255) NOT NULL,
	sitembarque_tiraatraso boolean NOT NULL
);

CREATE TABLE histstatagendadescarga
(
	codagendadescarga integer NOT NULL,
	codembarque integer NOT NULL,
	codhiststatagendadescarga integer NOT NULL DEFAULT nextval('histstatagendadescarga_codhiststatagendadescarga_seq'::regclass),
	codstatagendadescarga integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	numnf character varying (20),
	statagendadescarga_descr character varying (255) NOT NULL
);

CREATE TABLE histstatcarga
(
	codcarga bigint NOT NULL,
	codhiststatcarga bigint NOT NULL DEFAULT nextval('sq_codhiststatcarga'::regclass),
	codstatcarga integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	statcarga_definecancelado boolean NOT NULL,
	statcarga_definefim boolean NOT NULL,
	statcarga_defineinicio boolean NOT NULL,
	statcarga_defineredespacho boolean NOT NULL,
	statcarga_definesinistro boolean NOT NULL,
	statcarga_descr character varying (20) NOT NULL
);

CREATE TABLE histstatembarque
(
	codembarque bigint NOT NULL,
	codhiststatembarque bigint NOT NULL DEFAULT nextval('sq_codhiststatembarque'::regclass),
	codstatembarque integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	statembarque_definecancelado boolean NOT NULL,
	statembarque_definefim boolean NOT NULL,
	statembarque_defineinicio boolean NOT NULL,
	statembarque_definesinistro boolean NOT NULL,
	statembarque_descr character varying (20) NOT NULL
);

CREATE TABLE histstatocor
(
	codhiststatocor bigint NOT NULL DEFAULT nextval('sq_codhiststatocor'::regclass),
	codocor bigint NOT NULL,
	codstatocor integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	statocor_defineencerrado boolean NOT NULL DEFAULT false,
	statocor_definereaberto boolean NOT NULL DEFAULT false,
	statocor_descr character varying (20) NOT NULL,
	statocor_exigeanotacao boolean NOT NULL DEFAULT false
);

CREATE TABLE histstatpedido
(
	codhiststatpedido bigint NOT NULL DEFAULT nextval('histstatpedido_codhiststatpedido_seq'::regclass),
	codpedido bigint NOT NULL,
	codstatpedido integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL
);

CREATE TABLE histvincequiprastr
(
	codentidade integer NOT NULL,
	codtecrastr integer NOT NULL,
	codtpentidade integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL DEFAULT now(),
	eh_rastrmovel boolean NOT NULL DEFAULT false,
	idequiprastr character varying (25) NOT NULL,
	status character (1) NOT NULL DEFAULT 'I'::bpchar
);

CREATE TABLE idioma
(
	abreviacao character varying (3),
	ativo boolean DEFAULT true,
	codidioma integer NOT NULL DEFAULT nextval('idioma_codidioma_seq'::regclass),
	icone character varying (200),
	nome character varying (100),
	ordem integer DEFAULT 0,
	padrao boolean DEFAULT false,
	siglamaps character varying (6)
);

CREATE TABLE kpiciclocircuito
(
	codciclo integer NOT NULL DEFAULT nextval('kpiciclocircuito_codciclo_seq'::regclass),
	codcircuito integer,
	codembarqueatual bigint,
	codpriembarque bigint,
	diferenca integer,
	dtahrfim timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone,
	dtahrini timestamp (6) with time zone,
	dtahrprevfim timestamp (6) with time zone,
	dtahrprevini timestamp (6) with time zone,
	embarcadores  bigint []  DEFAULT '{}'::bigint[],
	embarques  bigint []  DEFAULT '{}'::bigint[],
	noprazo boolean,
	transportadoras  bigint []  DEFAULT '{}'::bigint[]
);

CREATE TABLE leilao
(
	codbid integer NOT NULL,
	codcidufdestino integer NOT NULL,
	codciduforigem integer NOT NULL,
	codleilao integer NOT NULL DEFAULT nextval('leilao_codleilao_seq'::regclass),
	codpedido bigint NOT NULL,
	codstatleilao integer NOT NULL,
	codtpcarga integer NOT NULL,
	codtranspultlance integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahrabertura timestamp (6) with time zone NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrencerramento timestamp (6) with time zone NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL,
	dtahrstatus timestamp (6) with time zone NOT NULL,
	dtahrultlance timestamp (6) with time zone,
	qtdelotes integer NOT NULL DEFAULT 0,
	tamanholote integer NOT NULL DEFAULT 0,
	totvol numeric NOT NULL,
	vlrultlance numeric (10,2)  DEFAULT 0
);

CREATE TABLE leilaoaprovacao
(
	aprovado boolean NOT NULL,
	codleilao integer NOT NULL,
	codleilaoaprovacao integer NOT NULL DEFAULT nextval('leilaoaprovacao_codleilaoaprovacao_seq'::regclass),
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL
);

CREATE TABLE leilaofrete
(
	ativo boolean,
	codcidufdestino integer NOT NULL,
	codciduforigem integer NOT NULL,
	codleilaofrete bigint NOT NULL DEFAULT nextval('leilaofrete_codleilaofrete_seq'::regclass),
	codleilaotpfrete integer NOT NULL,
	codtpcarga integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL,
	dtavigencia date NOT NULL,
	vlr numeric (10,2)  NOT NULL DEFAULT 0
);

CREATE TABLE leilaolance
(
	codemptra integer NOT NULL,
	codleilao integer NOT NULL,
	codleilaolance bigint NOT NULL DEFAULT nextval('leilaolance_codleilaolance_seq'::regclass),
	codleilaotransp integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL DEFAULT now(),
	maxlotes integer NOT NULL DEFAULT 0,
	minlotes integer NOT NULL DEFAULT 0,
	vlrlance numeric (10,2)  NOT NULL DEFAULT 0
);

CREATE TABLE leilaotpfrete
(
	ativo boolean DEFAULT true,
	codleilaotpfrete integer NOT NULL DEFAULT nextval('leilaotpfrete_codleilaotpfrete_seq'::regclass),
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL,
	id character varying (10) NOT NULL,
	nome character varying (200) NOT NULL
);

CREATE TABLE leilaotransp
(
	aprovado boolean DEFAULT false,
	ativo boolean DEFAULT true,
	codemptra integer NOT NULL,
	codleilao integer NOT NULL,
	codleilaotransp integer NOT NULL DEFAULT nextval('leilaotransp_codleilaotransp_seq'::regclass),
	codusrincl integer NOT NULL,
	dtahrinativo timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL,
	maxlotes integer NOT NULL DEFAULT 0,
	minlotes integer NOT NULL DEFAULT 0,
	qtdeaprovado integer NOT NULL DEFAULT 0,
	vlrlance numeric (10,2)  NOT NULL DEFAULT 0
);

CREATE TABLE lembrete
(
	codcarga bigint,
	codembarque bigint,
	codlembrete bigint NOT NULL DEFAULT nextval('sq_codlembrete'::regclass),
	codusrbaixa integer,
	codusrincl integer NOT NULL,
	dtahralarme timestamp (6) with time zone,
	dtahrbaixa timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	texto text
);

CREATE TABLE locexped
(
	codempembar integer,
	codigoexterno character varying (20) NOT NULL,
	codlocexped integer NOT NULL DEFAULT nextval('sq_codlocexped'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	empembar_id character varying (30),
	empembar_nome character varying (100)
);

CREATE TABLE log_alteracoes
(
	codlog integer NOT NULL DEFAULT nextval('log_alteracoes_codlog_seq'::regclass),
	codusr integer,
	data_alteracao timestamp (6) with time zone,
	nome_chave character varying (255) NOT NULL,
	tabela character varying (100) NOT NULL,
	tipo integer,
	valor_chave character varying (255) NOT NULL,
	valores_antigos ,
	valores_novos 
);

CREATE TABLE modulo
(
	alias character varying (100),
	altura integer DEFAULT 300,
	atualizavel boolean DEFAULT false,
	classname character varying (230) NOT NULL,
	codmodulo integer NOT NULL DEFAULT nextval('modulo_codmodulo_seq'::regclass),
	codpai integer,
	fechar_esc boolean DEFAULT false,
	fechavel boolean DEFAULT true,
	icone character varying (200),
	largura integer DEFAULT 500,
	maximizado boolean DEFAULT false,
	maximizavel boolean DEFAULT true,
	menu boolean DEFAULT true,
	minimizavel boolean DEFAULT true,
	modal boolean DEFAULT false,
	multiplainstancia boolean DEFAULT false,
	nome character varying (200) NOT NULL,
	ordem integer DEFAULT 0,
	redimensionavel boolean DEFAULT true
);

CREATE TABLE moduloacao
(
	codacao integer NOT NULL,
	codmodulo integer NOT NULL
);

CREATE TABLE moeda
(
	codmoeda integer NOT NULL,
	descr character varying (20) NOT NULL,
	sigla character varying (10)
);

CREATE TABLE mot
(
	ativo boolean NOT NULL DEFAULT true,
	bairro character varying (50),
	cep character varying (15),
	cnh character varying (20),
	codciduf integer,
	codcidufnat integer,
	codmot integer NOT NULL DEFAULT nextval('sq_codmot'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	dtanasc date,
	foto bytea,
	genero character (1),
	id character varying (30) NOT NULL,
	logradouro character varying (255),
	nome character varying (50) NOT NULL,
	obs text,
	pos_lat numeric (15,13) ,
	pos_long numeric (15,13) ,
	pos_manual boolean NOT NULL DEFAULT false,
	rg character varying (20),
	telefone character varying (100)
);

CREATE TABLE motemp
(
	codemp integer NOT NULL,
	codmot integer NOT NULL
);

CREATE TABLE motivo
(
	ativo boolean NOT NULL DEFAULT true,
	codmotivo integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	descr character varying (255) NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	template_email character varying (100),
	tipos  integer []  DEFAULT '{}'::integer[]
);

CREATE TABLE motivotpentidade
(
	ativo boolean NOT NULL DEFAULT true,
	codmotivo integer NOT NULL,
	codmotivotpentidade integer NOT NULL,
	codtpentidade integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now()
);

CREATE TABLE nf
(
	codcarga integer NOT NULL,
	codmoeda integer NOT NULL DEFAULT 1,
	codmotivo integer,
	codnf integer NOT NULL DEFAULT nextval('sq_nf'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	delivery boolean DEFAULT true,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL,
	entregue boolean,
	id character varying (200),
	moeda_sigla character varying (10),
	numdoc character varying (20),
	numnf character varying (20),
	numped character varying (30),
	numvol integer NOT NULL DEFAULT 1,
	peso numeric (7,2)  NOT NULL DEFAULT 0,
	vlr numeric (11,2)  NOT NULL DEFAULT 0,
	vol numeric (7,2)  NOT NULL DEFAULT 0
);

CREATE TABLE ocor
(
	codempresp integer,
	codentidade integer NOT NULL,
	codmotivo integer,
	codocor bigint NOT NULL DEFAULT nextval('sq_codocor'::regclass),
	codstatocor integer NOT NULL DEFAULT 1,
	codtpentidade integer NOT NULL,
	codtpprior integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	codusrresp integer,
	descr text NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrempresp timestamp (6) with time zone,
	dtahrencerrado timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	dtahrreaberto timestamp (6) with time zone,
	dtahrusrresp timestamp (6) with time zone
);

CREATE TABLE painelcontrole
(
	cargas  integer [] ,
	codempembar integer NOT NULL,
	codemptra integer NOT NULL,
	codsitcarga integer NOT NULL,
	codstatcarga integer NOT NULL,
	numpalete bigint DEFAULT 0,
	pesobruto double precision DEFAULT 0,
	qtde integer DEFAULT 0,
	viagens  integer [] ,
	volume double precision DEFAULT 0
);

CREATE TABLE pais
(
	codpais integer NOT NULL,
	mascara_cep character varying (20) NOT NULL,
	mascara_siglauf character varying (20) NOT NULL,
	nome character varying (50) NOT NULL,
	sigla character (3)
);

CREATE TABLE palavra
(
	chave character varying (200),
	codentidade integer DEFAULT 0,
	codpalavra integer NOT NULL DEFAULT nextval('palavra_codpalavra_seq'::regclass),
	codtpentidade integer,
	nome_interno character varying (150)
);

CREATE TABLE pedido
(
	bids  bigint []  NOT NULL DEFAULT '{}'::bigint[],
	cargas  bigint []  NOT NULL DEFAULT '{}'::bigint[],
	codempdest integer NOT NULL,
	codempembar integer NOT NULL,
	codpedido bigint NOT NULL DEFAULT nextval('pedido_codpedido_seq'::regclass),
	codpedidooriginal bigint,
	codstatpedido integer NOT NULL,
	codtpcarga integer NOT NULL,
	codtpoper integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	descr character varying (200) DEFAULT ''::character varying,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL,
	dtahrprevcoleta timestamp (6) with time zone,
	dtahrpreventrega timestamp (6) with time zone,
	embarques  bigint []  NOT NULL DEFAULT '{}'::bigint[],
	id character varying (200) NOT NULL,
	leiloado  bigint []  NOT NULL DEFAULT '{}'::bigint[],
	obs text DEFAULT ''::text,
	ofertas  integer []  NOT NULL DEFAULT '{}'::integer[],
	qtde numeric (13,4)  NOT NULL DEFAULT 0,
	qtdeconsumida numeric (13,4)  NOT NULL DEFAULT 0,
	unid character varying (10) NOT NULL
);

CREATE TABLE permissao
(
	codacao integer,
	codgrp integer,
	codmodulo integer
);

CREATE TABLE pos
(
	angulo numeric (4,1) ,
	codpos bigint NOT NULL DEFAULT nextval('sq_codpos'::regclass),
	codptoref integer,
	codtecrastr integer NOT NULL,
	dist numeric (8,2) ,
	dtahr timestamp (6) with time zone NOT NULL,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	dtahrtecrastr timestamp (6) with time zone NOT NULL,
	idequiprastr character varying (25) NOT NULL,
	ignicao integer,
	lat numeric (15,13)  NOT NULL,
	long numeric (15,13)  NOT NULL,
	nomeptoref character varying (255),
	tpptoref integer,
	veloc integer
);

CREATE TABLE prazotransito
(
	ativo boolean DEFAULT true,
	codcidufdest integer NOT NULL,
	codciduforig integer NOT NULL,
	codemptra integer,
	codprazotransito bigint NOT NULL DEFAULT nextval('sq_codprazotransito'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	distancia integer,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	dtavigencia date,
	prazo integer,
	tipo integer DEFAULT 1
);

CREATE TABLE produto
(
	ativo boolean NOT NULL DEFAULT true,
	codproduto integer NOT NULL DEFAULT nextval('produto_codproduto_seq'::regclass),
	codtpcarga integer NOT NULL,
	descr character varying (100) NOT NULL,
	sapid integer NOT NULL
);

CREATE TABLE progcoleta
(
	agendamento_realizado integer DEFAULT 0,
	cargaagendada boolean DEFAULT false,
	cargasid text DEFAULT '{}'::text,
	codbidtransp integer,
	codembarque bigint,
	codempdest integer,
	codempembar bigint,
	codemptra integer,
	codpedido bigint,
	codprogcoleta bigint NOT NULL DEFAULT nextval('sq_codprogcoleta'::regclass),
	codprogcoletaoriginal integer,
	codstatprogcoleta integer,
	codtpcarga  integer [] ,
	codtpoper integer,
	codtpveic integer,
	codusraceite integer,
	codusralter integer,
	codusrcancelado integer,
	codusrincl integer NOT NULL,
	codusrrecusa integer,
	considerarbid boolean DEFAULT true,
	descrstatprogcoleta character varying (50),
	dtahraceite timestamp (6) with time zone,
	dtahralter timestamp (6) with time zone,
	dtahrcancelado timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL DEFAULT now(),
	dtahrlimiteaceite timestamp (6) with time zone,
	dtahrprevatual timestamp (6) with time zone,
	dtahrpreventrega timestamp (6) with time zone,
	dtahrprevini timestamp (6) with time zone,
	dtahrrecusa timestamp (6) with time zone,
	dtaremessa date,
	embarques  bigint []  NOT NULL DEFAULT '{}'::bigint[],
	foraprazocontratual boolean DEFAULT false,
	notificado boolean NOT NULL DEFAULT false,
	notificadoembarque boolean DEFAULT false,
	obs text,
	prazocontratual integer DEFAULT 24,
	progoriginal text,
	qtde numeric NOT NULL DEFAULT 0,
	qtdeconsumida numeric NOT NULL DEFAULT 0,
	simultanea boolean DEFAULT false,
	temdelivery boolean DEFAULT false,
	totalcarga integer NOT NULL DEFAULT 0,
	totalnumpalete integer NOT NULL DEFAULT 0,
	totalnumvol integer NOT NULL DEFAULT 0,
	totalpeso numeric (12,2)  NOT NULL DEFAULT 0,
	totalvol numeric (12,2)  NOT NULL DEFAULT 0,
	unid character varying (10) NOT NULL DEFAULT ''::character varying,
	venda boolean DEFAULT false
);

CREATE TABLE progcoletacarga
(
	codcarga bigint NOT NULL,
	codprogcoleta bigint NOT NULL,
	codprogcoletacarga bigint NOT NULL DEFAULT nextval('sq_codprogcoletacarga'::regclass),
	codusrincl integer NOT NULL,
	dtahrincl timestamp (6) with time zone NOT NULL DEFAULT now()
);

CREATE TABLE ptoref
(
	cod integer NOT NULL,
	coord  geometry ,
	nome character varying (255) NOT NULL,
	tp integer NOT NULL
);

CREATE TABLE rastrmovel
(
	ativo boolean NOT NULL DEFAULT true,
	codrastrmovel integer NOT NULL DEFAULT nextval('sq_codrastrmovel'::regclass),
	codtecrastr integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	idequiprastr character varying (25),
	modelo character varying (20),
	ultpos_descr character varying (255),
	ultpos_dtahr timestamp (6) with time zone,
	ultpos_lat numeric (15,13) ,
	ultpos_long numeric (15,13) 
);

CREATE TABLE relatorio
(
	arquivo character varying (200),
	codcategoria integer,
	codrelatorio integer NOT NULL DEFAULT nextval('relatorio_codrelatorio_seq'::regclass),
	nome character varying (200),
	ordem integer,
	padrao boolean,
	parametros text,
	tipo integer NOT NULL,
	titulo character varying (200),
	versao numeric (5,2)  NOT NULL DEFAULT 1,
	visivel boolean DEFAULT true
);

CREATE TABLE rota
(
	ativo boolean NOT NULL DEFAULT true,
	codrota integer NOT NULL DEFAULT nextval('sq_codrota'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	descr character varying (255) NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	id character varying (30),
	progpos  geometry 
);

CREATE TABLE sitcarga
(
	ativo boolean NOT NULL DEFAULT true,
	codsitcarga integer NOT NULL,
	codtpprior integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	defineatraso boolean NOT NULL DEFAULT false,
	descr character varying (255) NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	editavel boolean NOT NULL DEFAULT true,
	geraocor boolean NOT NULL DEFAULT false,
	manual boolean NOT NULL DEFAULT true,
	tiraatraso boolean NOT NULL DEFAULT false
);

CREATE TABLE sitembarque
(
	ativo boolean NOT NULL DEFAULT true,
	codsitembarque integer NOT NULL,
	codtpprior integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	defineatraso boolean NOT NULL DEFAULT false,
	defineretorno boolean NOT NULL DEFAULT false,
	descr character varying (255) NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	editavel boolean NOT NULL DEFAULT true,
	geraocor boolean NOT NULL DEFAULT false,
	manual boolean NOT NULL DEFAULT true,
	tiraatraso boolean NOT NULL DEFAULT false
);

CREATE TABLE spatial_ref_sys
(
	auth_name character varying (256),
	auth_srid integer,
	proj4text character varying (2048),
	srid integer NOT NULL,
	srtext character varying (2048)
);

CREATE TABLE statagendadescarga
(
	ativo boolean NOT NULL DEFAULT true,
	codstatagendadescarga integer NOT NULL DEFAULT nextval('statagendadescarga_codstatagendadescarga_seq'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	cor character (6),
	corsecundaria character (6),
	definecancelado boolean NOT NULL DEFAULT false,
	definefim boolean NOT NULL DEFAULT false,
	defineinicio boolean NOT NULL DEFAULT false,
	descr character varying (50) NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	editavel boolean NOT NULL DEFAULT true,
	idintegracao integer
);

CREATE TABLE statcarga
(
	ativo boolean NOT NULL DEFAULT true,
	codstatcarga integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	cor character (6),
	corsecundaria character (6),
	definecancelado boolean NOT NULL DEFAULT false,
	definefim boolean NOT NULL DEFAULT false,
	defineinicio boolean NOT NULL DEFAULT false,
	defineredespacho boolean NOT NULL DEFAULT false,
	definesinistro boolean NOT NULL DEFAULT false,
	descr character varying (20) NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	editavel boolean NOT NULL DEFAULT false,
	icone character varying (100) DEFAULT 'imagens/icones/lock.png'::character varying,
	ordem_painel integer DEFAULT 0
);

CREATE TABLE statembarque
(
	ativo boolean NOT NULL DEFAULT true,
	codstatembarque integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	cor character (6),
	corsecundaria character (6),
	definecancelado boolean NOT NULL DEFAULT false,
	definefim boolean NOT NULL DEFAULT false,
	defineinicio boolean NOT NULL DEFAULT false,
	defineprogramado boolean NOT NULL DEFAULT false,
	definesinistro boolean NOT NULL DEFAULT false,
	descr character varying (20) NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	editavel boolean NOT NULL DEFAULT true
);

CREATE TABLE statleilao
(
	codstatleilao integer NOT NULL DEFAULT nextval('statleilao_codstatleilao_seq'::regclass),
	codusrincl integer NOT NULL,
	defineaberto boolean DEFAULT false,
	defineagaprovacao boolean DEFAULT false,
	defineaprovado boolean DEFAULT false,
	definecancelado boolean DEFAULT false,
	defineencerrado boolean DEFAULT false,
	definereprovado boolean DEFAULT false,
	dtahrincl timestamp (6) with time zone NOT NULL,
	id character varying (100) NOT NULL,
	nome character varying (100) NOT NULL
);

CREATE TABLE statocor
(
	ativo boolean NOT NULL DEFAULT true,
	codstatocor integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	defineencerrado boolean NOT NULL DEFAULT false,
	definereaberto boolean NOT NULL DEFAULT false,
	descr character varying (20) NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	editavel boolean NOT NULL DEFAULT false,
	exigeanotacao boolean NOT NULL DEFAULT true
);

CREATE TABLE statpedido
(
	ativo boolean DEFAULT true,
	codstatpedido integer NOT NULL DEFAULT nextval('statpedido_codstatpedido_seq'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	cor character varying (15) NOT NULL DEFAULT '#FFFFFF'::character varying,
	defineagleilao boolean DEFAULT false,
	defineagliberacao boolean DEFAULT false,
	defineagofertainicial boolean DEFAULT false,
	definecancelado boolean DEFAULT false,
	defineleiloado boolean DEFAULT false,
	defineofertado boolean DEFAULT false,
	definepodecancelar boolean DEFAULT false,
	definepodeeditar boolean DEFAULT false,
	definepodeleiloar boolean DEFAULT false,
	definepodeofertar boolean DEFAULT false,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL,
	id character varying (100) NOT NULL,
	nome character varying (200) NOT NULL,
	ordem integer NOT NULL DEFAULT 0
);

CREATE TABLE statprogcoleta
(
	ativo boolean DEFAULT true,
	codstatprogcoleta integer NOT NULL,
	cor character varying (10),
	defineaceito boolean DEFAULT false,
	definecancelado boolean DEFAULT false,
	definerecusado boolean DEFAULT false,
	descr character varying (50)
);

CREATE TABLE tecrastr
(
	codtecrastr integer NOT NULL,
	nome character varying (50) NOT NULL,
	toleranciasinal integer DEFAULT 30
);

CREATE TABLE temp
(
	codtecrastr integer NOT NULL,
	codtemp bigint NOT NULL DEFAULT nextval('sq_codtemp'::regclass),
	dtahr timestamp (6) with time zone NOT NULL,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	dtahrtecrastr timestamp (6) with time zone NOT NULL,
	idequiprastr character varying (25) NOT NULL,
	lat numeric (15,13)  NOT NULL,
	long numeric (15,13)  NOT NULL,
	sensor integer DEFAULT 1,
	temperatura numeric (10,2)  NOT NULL
);

CREATE TABLE templateemail
(
	ativo boolean DEFAULT true,
	codtemplateemail integer NOT NULL DEFAULT nextval('sq_codtemplateemail'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	descricao character varying (50) NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	modelo text,
	subject character varying (250) NOT NULL
);

CREATE TABLE token
(
	codusrincl integer NOT NULL,
	dtahrexpir timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone,
	dtahruso timestamp (6) with time zone,
	statususo boolean DEFAULT false,
	token character varying (20) NOT NULL
);

CREATE TABLE tpcarga
(
	ativo boolean NOT NULL DEFAULT true,
	climatizada boolean DEFAULT false,
	codtpcarga integer NOT NULL DEFAULT nextval('sq_codtpcarga'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	descr character varying (255) NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	id character varying (30),
	prioridade integer DEFAULT 0,
	templimitemaximo numeric (7,2)  DEFAULT 0,
	templimiteminimo numeric (7,2)  DEFAULT 0,
	tempnormalmaximo numeric (7,2)  DEFAULT 0,
	tempnormalminimo numeric (7,2)  DEFAULT 0,
	usaragendadescarga boolean NOT NULL DEFAULT false
);

CREATE TABLE tpcarreta
(
	ativo boolean NOT NULL DEFAULT true,
	codtpcarreta integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	nome character varying (50) NOT NULL,
	peso numeric (7,2)  DEFAULT 0,
	vol numeric (7,2)  DEFAULT 0
);

CREATE TABLE tpconfig
(
	codtpconfig integer NOT NULL,
	descr character varying (255) NOT NULL
);

CREATE TABLE tpentidade
(
	codtpentidade integer NOT NULL,
	descr character varying (50) NOT NULL
);

CREATE TABLE tpevento
(
	ativo boolean DEFAULT true,
	codmodulo integer,
	codtpevento integer NOT NULL DEFAULT nextval('tpevento_codtpevento_seq'::regclass),
	codtpeventocjto integer NOT NULL,
	cor character varying (20) DEFAULT 'FFCC00'::character varying,
	execservantes boolean DEFAULT true,
	exibirpainel boolean DEFAULT true,
	finalizaretapa boolean DEFAULT false,
	multiplaescolha boolean DEFAULT false,
	nome character varying (200) NOT NULL,
	ordemexec integer NOT NULL DEFAULT 0,
	proxcodstatcarga integer,
	proxcodstatembarque integer,
	sapid character varying (10),
	servico character varying (255),
	tempomedio integer NOT NULL,
	tempomediomax integer DEFAULT 0,
	tempomediomin integer DEFAULT 0
);

CREATE TABLE tpeventocjto
(
	ativo boolean NOT NULL DEFAULT true,
	codtpeventocjto integer NOT NULL DEFAULT nextval('tpeventocjto_codtpeventocjto_seq'::regclass),
	nome character varying (200) NOT NULL
);

CREATE TABLE tpeventoembarque
(
	alertaenviado boolean DEFAULT false,
	codembarque integer NOT NULL,
	codemp integer NOT NULL,
	codtpevento integer NOT NULL,
	codtpeventocjto integer NOT NULL,
	codtpeventoembarque integer NOT NULL DEFAULT nextval('tpeventoembarque_codtpeventoembarque_seq'::regclass),
	codusr integer,
	dtahrfim timestamp (6) with time zone,
	dtahrini timestamp (6) with time zone,
	dtahrprevfim timestamp (6) with time zone NOT NULL,
	dtahrprevfimmaior timestamp (6) with time zone,
	dtahrprevfimmenor timestamp (6) with time zone,
	dtahrprevini timestamp (6) with time zone NOT NULL,
	iniciadoposalvo boolean DEFAULT false,
	nometpevento character varying (200) NOT NULL,
	ordemexec integer NOT NULL,
	pos_lat double precision,
	pos_long double precision
);

CREATE TABLE tpeventoemp
(
	ativo boolean DEFAULT true,
	codemp integer,
	codtpevento integer,
	codtpeventoemp integer NOT NULL DEFAULT nextval('tpeventoemp_codtpeventoemp_seq'::regclass),
	codusralter integer,
	codusrincl integer,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone,
	ordem integer,
	pos_area  geometry ,
	pos_lat numeric,
	pos_long numeric
);

CREATE TABLE tpeventousr
(
	codemp integer NOT NULL,
	codtpevento integer NOT NULL,
	codusr integer NOT NULL
);

CREATE TABLE tpferiado
(
	codtpferiado integer NOT NULL DEFAULT nextval('tpferiado_codtpferiado_seq'::regclass),
	cor character varying (10),
	estadual boolean,
	federal boolean,
	municipal boolean,
	nome character varying (100)
);

CREATE TABLE tpmotivo
(
	chave character varying (50),
	codtpmotivo integer NOT NULL,
	descr character varying (50) NOT NULL
);

CREATE TABLE tpoper
(
	ativo boolean NOT NULL DEFAULT true,
	codtpoper integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	considerarfds boolean DEFAULT false,
	cor character varying (10) DEFAULT 'ffffff'::character varying,
	ctrlcarregamento boolean DEFAULT false,
	ctrldescarregamento boolean DEFAULT false,
	defineautooferta boolean DEFAULT false,
	definetnf boolean DEFAULT false,
	descr character varying (20) NOT NULL,
	distribuicao boolean DEFAULT false,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	editavel boolean NOT NULL DEFAULT false,
	exibirroteiro boolean DEFAULT false,
	hrinicio time (6) without time zone DEFAULT '07:00:00'::time without time zone,
	hrlimite time (6) without time zone DEFAULT '17:00:00'::time without time zone,
	id character varying (20) NOT NULL DEFAULT ''::character varying,
	importarnotas boolean DEFAULT true,
	prazoaceite integer DEFAULT 1440,
	prioridadeds integer DEFAULT (-1),
	temredespacho boolean NOT NULL DEFAULT false,
	tipoprazotransito integer DEFAULT 1,
	usarrastreamento boolean DEFAULT true
);

CREATE TABLE tppalete
(
	altura double precision,
	ativo boolean,
	codtppalete integer NOT NULL DEFAULT nextval('tppalete_codtppalete_seq'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	comprimento double precision,
	cor character varying (10),
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL,
	largura double precision,
	nome character varying (100) NOT NULL,
	peso double precision,
	volume double precision
);

CREATE TABLE tpprior
(
	ativo boolean NOT NULL DEFAULT true,
	codtpprior integer NOT NULL,
	codusralter integer,
	codusrincl integer NOT NULL,
	corfonte character (6) NOT NULL,
	corfundo character (6) NOT NULL,
	corsemaforo character (6) NOT NULL,
	descr character varying (255),
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	nome character varying (50) NOT NULL,
	prioridade integer NOT NULL DEFAULT 0
);

CREATE TABLE tpveic
(
	altura numeric (10,2)  DEFAULT 0,
	ativo boolean NOT NULL DEFAULT true,
	codtpveic integer NOT NULL DEFAULT nextval('sq_codtpveic'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	comprimento numeric (10,2)  DEFAULT 0,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	eixos integer DEFAULT 0,
	largura numeric (10,2)  DEFAULT 0,
	nome character varying (50) NOT NULL,
	peso numeric (7,2)  DEFAULT 0,
	vol numeric (7,2)  DEFAULT 0
);

CREATE TABLE tpveicoper
(
	codigoexterno character varying (20) NOT NULL,
	codtpcarga integer,
	codtpoper integer NOT NULL,
	codtpveic integer,
	codtpveicoper integer NOT NULL DEFAULT nextval('tpveicoper_codtpveicoper_seq'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL
);

CREATE TABLE traducao
(
	codidioma integer NOT NULL,
	codpalavra integer NOT NULL,
	valor text
);

CREATE TABLE usr
(
	alterar_senha boolean DEFAULT true,
	ativo boolean NOT NULL DEFAULT true,
	avatar bytea,
	bloqueado boolean DEFAULT false,
	codemp integer,
	codusr integer NOT NULL DEFAULT nextval('sq_codusr'::regclass),
	codusralter integer,
	codusrincl integer NOT NULL,
	dtahralter timestamp (6) with time zone,
	dtahrbloqueiasenha timestamp (6) with time zone,
	dtahrexpirasenha timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	editavel boolean NOT NULL DEFAULT true,
	email character varying (255),
	integrador boolean NOT NULL DEFAULT false,
	nome character varying (50) NOT NULL,
	nomeacesso character varying (20),
	qtdetentativas integer DEFAULT 0,
	senhaacesso character varying (32) NOT NULL,
	senhaacessoant character varying (20)
);

CREATE TABLE usrhistsenha
(
	codusr integer NOT NULL,
	codusrhistsenha integer NOT NULL DEFAULT nextval('usrhistsenha_codusrhistsenha_seq'::regclass),
	dtahrincl timestamp (6) with time zone,
	senha character varying (32)
);

CREATE TABLE usrperfil
(
	atalhos text,
	codidioma integer,
	codusr integer NOT NULL,
	colunas text,
	config text DEFAULT '{"auto_hide_menu":false}'::text,
	foto character varying (200),
	janelas text,
	wallpaper character varying (200)
);

CREATE TABLE veic
(
	ativo boolean NOT NULL DEFAULT true,
	codcargafluxo integer,
	codtecrastr integer,
	codtpveic integer,
	codusralter integer,
	codusrincl integer NOT NULL,
	codveic integer NOT NULL DEFAULT nextval('sq_codveic'::regclass),
	cor character varying (20),
	dtahralter timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone DEFAULT now(),
	id character varying (30) NOT NULL,
	idequiprastr character varying (25),
	modelo character varying (20),
	uf character (2),
	ultpos_descr character varying (255),
	ultpos_dtahr timestamp (6) with time zone,
	ultpos_lat numeric (15,13) ,
	ultpos_long numeric (15,13) 
);

CREATE TABLE veicemp
(
	codemp integer NOT NULL,
	codveic integer NOT NULL
);

CREATE TABLE vevento
(
	codemp integer,
	codtpevento integer,
	codtpeventoembarque integer,
	nome character varying (200),
	ordem integer,
	proxcodstatcarga integer,
	proxcodstatembarque integer
);

CREATE TABLE vincequiprastr
(
	codentidade integer NOT NULL,
	codtecrastr integer NOT NULL,
	codtpentidade integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrdesat timestamp (6) with time zone,
	dtahrincl timestamp (6) with time zone NOT NULL DEFAULT now(),
	dtahrstatus timestamp (6) with time zone NOT NULL DEFAULT now(),
	eh_rastrmovel boolean NOT NULL DEFAULT false,
	idequiprastr character varying (25) NOT NULL,
	status character (1) NOT NULL DEFAULT 'I'::bpchar
);

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;