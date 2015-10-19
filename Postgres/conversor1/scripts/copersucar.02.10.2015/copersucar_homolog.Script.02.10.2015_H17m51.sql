

------------------ DATABASE: copersucar_homolog ------------------


------ DEV SCHEMAS ------
	-- alteracoes
	-- dashboard
	-- integracao
	-- public

------ HOMOLOG SCHEMAS ------
	-- alteracoes
	-- dashboard
	-- integracao
	-- public



-------------------- ALTER SCHEMA --------------------

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO alteracoes;



-------------------- ALTER SCHEMA --------------------

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO dashboard;



-------------------- ALTER SCHEMA --------------------

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO integracao;



-------------------- ALTER SCHEMA --------------------

-------------------- SET SCHEMAS --------------------
SET SEARCH_PATH TO public;

--------------------  CREATE DE SEQUENCES -------------------- 
CREATE SEQUENCE public.bid_regiao_codbidregiao_seq;
CREATE SEQUENCE public.histstatagendadescarga_codagendadescarga_seq;
CREATE SEQUENCE public.histstatagendadescarga_codstatagendadescarga_seq;
CREATE SEQUENCE public.histstatpedido_codhiststatpedido_seq;
CREATE SEQUENCE public.leilaoaprovacao_codleilaoaprovacao_seq;
CREATE SEQUENCE public.leilao_codleilao_seq;
CREATE SEQUENCE public.leilaofrete_codleilaofrete_seq;
CREATE SEQUENCE public.leilaolance_codleilaolance_seq;
CREATE SEQUENCE public.leilaotpfrete_codleilaotpfrete_seq;
CREATE SEQUENCE public.leilaotransp_codleilaotransp_seq;
CREATE SEQUENCE public.pedido_codpedido_seq;
CREATE SEQUENCE public.sq_codagendadescarga;
CREATE SEQUENCE public.statleilao_codstatleilao_seq;
CREATE SEQUENCE public.statpedido_codstatpedido_seq;

-------------------- CREATE TABLE --------------------

CREATE TABLE bid_regiao
(
	ativo boolean DEFAULT true,
	cidades  integer ARRAY,
	codbidregiao integer NOT NULL DEFAULT nextval('bid_regiao_codbidregiao_seq'::regclass),
	codemporig integer,
	codusralter integer,
	codusrincl integer,
	dtahralter timestamp with time zone,
	dtahrincl timestamp with time zone,
	nome character varying (120)
);

CREATE TABLE histstatpedido
(
	codhiststatpedido bigint NOT NULL DEFAULT nextval('histstatpedido_codhiststatpedido_seq'::regclass),
	codpedido bigint NOT NULL,
	codstatpedido integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp with time zone NOT NULL
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
	dtahrabertura timestamp with time zone NOT NULL,
	dtahralter timestamp with time zone,
	dtahrencerramento timestamp with time zone NOT NULL,
	dtahrincl timestamp with time zone NOT NULL,
	dtahrstatus timestamp with time zone NOT NULL,
	dtahrultlance timestamp with time zone,
	qtdelotes integer NOT NULL DEFAULT 0,
	tamanholote integer NOT NULL DEFAULT 0,
	totvol numeric NOT NULL,
	vlrultlance numeric(10,2) DEFAULT 0
);

CREATE TABLE leilaoaprovacao
(
	aprovado boolean NOT NULL,
	codleilao integer NOT NULL,
	codleilaoaprovacao integer NOT NULL DEFAULT nextval('leilaoaprovacao_codleilaoaprovacao_seq'::regclass),
	codusrincl integer NOT NULL,
	dtahrincl timestamp with time zone NOT NULL
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
	dtahrincl timestamp with time zone NOT NULL,
	dtavigencia date NOT NULL,
	vlr numeric(10,2) NOT NULL DEFAULT 0
);

CREATE TABLE leilaolance
(
	codemptra integer NOT NULL,
	codleilao integer NOT NULL,
	codleilaolance bigint NOT NULL DEFAULT nextval('leilaolance_codleilaolance_seq'::regclass),
	codleilaotransp integer NOT NULL,
	codusrincl integer NOT NULL,
	dtahrincl timestamp with time zone NOT NULL DEFAULT now(),
	maxlotes integer NOT NULL DEFAULT 0,
	minlotes integer NOT NULL DEFAULT 0,
	vlrlance numeric(10,2) NOT NULL DEFAULT 0
);

CREATE TABLE leilaotpfrete
(
	ativo boolean DEFAULT true,
	codleilaotpfrete integer NOT NULL DEFAULT nextval('leilaotpfrete_codleilaotpfrete_seq'::regclass),
	codusrincl integer NOT NULL,
	dtahrincl timestamp with time zone NOT NULL,
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
	dtahrinativo timestamp with time zone,
	dtahrincl timestamp with time zone NOT NULL,
	maxlotes integer NOT NULL DEFAULT 0,
	minlotes integer NOT NULL DEFAULT 0,
	vlrlance numeric(10,2) NOT NULL DEFAULT 0
);

CREATE TABLE pedido
(
	bids ARRAY NOT NULL DEFAULT '{}'::bigint[],
	cargas ARRAY NOT NULL DEFAULT '{}'::bigint[],
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
	dtahralter timestamp with time zone,
	dtahrincl timestamp with time zone NOT NULL,
	dtahrprevcoleta timestamp with time zone,
	dtahrpreventrega timestamp with time zone,
	embarques ARRAY NOT NULL DEFAULT '{}'::bigint[],
	id character varying (200) NOT NULL,
	leiloado ARRAY NOT NULL DEFAULT '{}'::bigint[],
	obs text DEFAULT ''::text,
	ofertas  integer ARRAY NOT NULL DEFAULT '{}'::integer[],
	qtde numeric(13,4) NOT NULL DEFAULT 0,
	qtdeconsumida numeric(13,4) NOT NULL DEFAULT 0,
	unid character varying (10) NOT NULL
);

CREATE TABLE statleilao
(
	codstatleilao integer NOT NULL DEFAULT nextval('statleilao_codstatleilao_seq'::regclass),
	codusrincl integer NOT NULL,
	defineaberto boolean DEFAULT false,
	defineaprovado boolean DEFAULT false,
	definecancelado boolean DEFAULT false,
	defineencerrado boolean DEFAULT false,
	definereprovado boolean DEFAULT false,
	dtahrincl timestamp with time zone NOT NULL,
	id character varying (100) NOT NULL,
	nome character varying (100) NOT NULL
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
	dtahralter timestamp with time zone,
	dtahrincl timestamp with time zone NOT NULL,
	id character varying (100) NOT NULL,
	nome character varying (200) NOT NULL,
	ordem integer NOT NULL DEFAULT 0
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

---------- COMMIT ----------
--COMMIT;

---------- ROLLBACK ----------
--ROLLBACK;