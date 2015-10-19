

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