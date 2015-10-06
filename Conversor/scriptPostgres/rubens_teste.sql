--
-- PostgreSQL database dump
--

-- Dumped from database version 9.2.9
-- Dumped by pg_dump version 9.4.0
-- Started on 2015-09-29 09:34:30

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 172 (class 1259 OID 19188594)
-- Name: tabela1; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tabela1 (
    cd_codigo bigint NOT NULL,
    nm_nome character varying(20) DEFAULT 'teste'::character varying,
    ds_descricao text DEFAULT 'teste'::text,
    nr_numero numeric(8,1) DEFAULT 30,
    dt_data timestamp with time zone,
    tm timestamp with time zone
);


ALTER TABLE tabela1 OWNER TO postgres;

--
-- TOC entry 181 (class 1259 OID 19829550)
-- Name: tabela10; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tabela10 (
    cd_codigo bigint NOT NULL,
    nm_nome character varying(50) DEFAULT 'eu'::character varying NOT NULL,
    id_identity bigint,
    nr_numrero numeric(10,2)
);


ALTER TABLE tabela10 OWNER TO postgres;

--
-- TOC entry 180 (class 1259 OID 19829548)
-- Name: tabela10_cd_codigo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tabela10_cd_codigo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tabela10_cd_codigo_seq OWNER TO postgres;

--
-- TOC entry 2929 (class 0 OID 0)
-- Dependencies: 180
-- Name: tabela10_cd_codigo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tabela10_cd_codigo_seq OWNED BY tabela10.cd_codigo;


--
-- TOC entry 183 (class 1259 OID 19841031)
-- Name: tabela11_cd_codigo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tabela11_cd_codigo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tabela11_cd_codigo_seq OWNER TO postgres;

--
-- TOC entry 184 (class 1259 OID 19841048)
-- Name: tabela11; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tabela11 (
    cd_codigo bigint DEFAULT nextval('tabela11_cd_codigo_seq'::regclass) NOT NULL,
    nm_nome character varying(50) DEFAULT 'eu'::character varying NOT NULL
);


ALTER TABLE tabela11 OWNER TO postgres;

--
-- TOC entry 182 (class 1259 OID 19840407)
-- Name: tabela12; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tabela12 (
    cd_codigo bigint DEFAULT nextval('tabela10_cd_codigo_seq'::regclass) NOT NULL,
    id_identity bigint,
    nm_nome character varying(50) DEFAULT 'eu'::character varying NOT NULL
);


ALTER TABLE tabela12 OWNER TO postgres;

--
-- TOC entry 171 (class 1259 OID 19188592)
-- Name: tabela1_cd_codigo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tabela1_cd_codigo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tabela1_cd_codigo_seq OWNER TO postgres;

--
-- TOC entry 2930 (class 0 OID 0)
-- Dependencies: 171
-- Name: tabela1_cd_codigo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tabela1_cd_codigo_seq OWNED BY tabela1.cd_codigo;


--
-- TOC entry 170 (class 1259 OID 18933256)
-- Name: tabela2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tabela2 (
    cd_codigo bigint NOT NULL,
    nm_nome character varying(200) DEFAULT NULL::character varying,
    desc_descricao text,
    dt_data timestamp without time zone NOT NULL
);


ALTER TABLE tabela2 OWNER TO postgres;

--
-- TOC entry 169 (class 1259 OID 18933254)
-- Name: tabela2_cd_codigo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tabela2_cd_codigo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tabela2_cd_codigo_seq OWNER TO postgres;

--
-- TOC entry 2931 (class 0 OID 0)
-- Dependencies: 169
-- Name: tabela2_cd_codigo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tabela2_cd_codigo_seq OWNED BY tabela2.cd_codigo;


--
-- TOC entry 176 (class 1259 OID 19404712)
-- Name: tabela3_cd2_codigo_sq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tabela3_cd2_codigo_sq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tabela3_cd2_codigo_sq OWNER TO postgres;

--
-- TOC entry 177 (class 1259 OID 19494234)
-- Name: tabela3_id2_sq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tabela3_id2_sq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tabela3_id2_sq OWNER TO postgres;

--
-- TOC entry 175 (class 1259 OID 19243152)
-- Name: tabela3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tabela3 (
    cd_codigo bigint NOT NULL,
    id_identity bigint NOT NULL,
    ds_descricao text,
    cd2_codigo bigint DEFAULT nextval('tabela3_cd2_codigo_sq'::regclass),
    nr_numero numeric(8,0) NOT NULL,
    nm_nome character varying(100) DEFAULT 'teste'::character varying NOT NULL,
    nm_sobrenome character varying(100) DEFAULT 'teste'::character varying NOT NULL,
    nr_cardinal bigint,
    id2_identity bigint DEFAULT nextval('tabela3_id2_sq'::regclass),
    CONSTRAINT ck_igual CHECK ((cd_codigo = id_identity))
);


ALTER TABLE tabela3 OWNER TO postgres;

--
-- TOC entry 173 (class 1259 OID 19243148)
-- Name: tabela3_cd_codigo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tabela3_cd_codigo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tabela3_cd_codigo_seq OWNER TO postgres;

--
-- TOC entry 2932 (class 0 OID 0)
-- Dependencies: 173
-- Name: tabela3_cd_codigo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tabela3_cd_codigo_seq OWNED BY tabela3.cd_codigo;


--
-- TOC entry 174 (class 1259 OID 19243150)
-- Name: tabela3_id_identity_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tabela3_id_identity_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE tabela3_id_identity_seq OWNER TO postgres;

--
-- TOC entry 2933 (class 0 OID 0)
-- Dependencies: 174
-- Name: tabela3_id_identity_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tabela3_id_identity_seq OWNED BY tabela3.id_identity;


--
-- TOC entry 179 (class 1259 OID 19805423)
-- Name: teste; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE teste (
    cd_codigo bigint NOT NULL
);


ALTER TABLE teste OWNER TO postgres;

--
-- TOC entry 178 (class 1259 OID 19805421)
-- Name: teste_cd_codigo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE teste_cd_codigo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE teste_cd_codigo_seq OWNER TO postgres;

--
-- TOC entry 2934 (class 0 OID 0)
-- Dependencies: 178
-- Name: teste_cd_codigo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE teste_cd_codigo_seq OWNED BY teste.cd_codigo;


--
-- TOC entry 2775 (class 2604 OID 19188597)
-- Name: cd_codigo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tabela1 ALTER COLUMN cd_codigo SET DEFAULT nextval('tabela1_cd_codigo_seq'::regclass);


--
-- TOC entry 2788 (class 2604 OID 19829553)
-- Name: cd_codigo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tabela10 ALTER COLUMN cd_codigo SET DEFAULT nextval('tabela10_cd_codigo_seq'::regclass);


--
-- TOC entry 2773 (class 2604 OID 18933259)
-- Name: cd_codigo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tabela2 ALTER COLUMN cd_codigo SET DEFAULT nextval('tabela2_cd_codigo_seq'::regclass);


--
-- TOC entry 2779 (class 2604 OID 19243155)
-- Name: cd_codigo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tabela3 ALTER COLUMN cd_codigo SET DEFAULT nextval('tabela3_cd_codigo_seq'::regclass);


--
-- TOC entry 2780 (class 2604 OID 19243156)
-- Name: id_identity; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tabela3 ALTER COLUMN id_identity SET DEFAULT nextval('tabela3_id_identity_seq'::regclass);


--
-- TOC entry 2783 (class 2604 OID 19396395)
-- Name: nr_numero; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tabela3 ALTER COLUMN nr_numero SET DEFAULT nextval('tabela3_id_identity_seq'::regclass);


--
-- TOC entry 2787 (class 2604 OID 19805426)
-- Name: cd_codigo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY teste ALTER COLUMN cd_codigo SET DEFAULT nextval('teste_cd_codigo_seq'::regclass);


--
-- TOC entry 2910 (class 0 OID 19188594)
-- Dependencies: 172
-- Data for Name: tabela1; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tabela1 (cd_codigo, nm_nome, ds_descricao, nr_numero, dt_data, tm) FROM stdin;
\.


--
-- TOC entry 2919 (class 0 OID 19829550)
-- Dependencies: 181
-- Data for Name: tabela10; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tabela10 (cd_codigo, nm_nome, id_identity, nr_numrero) FROM stdin;
\.


--
-- TOC entry 2935 (class 0 OID 0)
-- Dependencies: 180
-- Name: tabela10_cd_codigo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tabela10_cd_codigo_seq', 1, false);


--
-- TOC entry 2922 (class 0 OID 19841048)
-- Dependencies: 184
-- Data for Name: tabela11; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tabela11 (cd_codigo, nm_nome) FROM stdin;
\.


--
-- TOC entry 2936 (class 0 OID 0)
-- Dependencies: 183
-- Name: tabela11_cd_codigo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tabela11_cd_codigo_seq', 1, false);


--
-- TOC entry 2920 (class 0 OID 19840407)
-- Dependencies: 182
-- Data for Name: tabela12; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tabela12 (cd_codigo, id_identity, nm_nome) FROM stdin;
\.


--
-- TOC entry 2937 (class 0 OID 0)
-- Dependencies: 171
-- Name: tabela1_cd_codigo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tabela1_cd_codigo_seq', 1, false);


--
-- TOC entry 2908 (class 0 OID 18933256)
-- Dependencies: 170
-- Data for Name: tabela2; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tabela2 (cd_codigo, nm_nome, desc_descricao, dt_data) FROM stdin;
\.


--
-- TOC entry 2938 (class 0 OID 0)
-- Dependencies: 169
-- Name: tabela2_cd_codigo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tabela2_cd_codigo_seq', 1, false);


--
-- TOC entry 2913 (class 0 OID 19243152)
-- Dependencies: 175
-- Data for Name: tabela3; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tabela3 (cd_codigo, id_identity, ds_descricao, cd2_codigo, nr_numero, nm_nome, nm_sobrenome, nr_cardinal, id2_identity) FROM stdin;
1	1	teste	\N	30	teste	teste	\N	\N
\.


--
-- TOC entry 2939 (class 0 OID 0)
-- Dependencies: 176
-- Name: tabela3_cd2_codigo_sq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tabela3_cd2_codigo_sq', 1, false);


--
-- TOC entry 2940 (class 0 OID 0)
-- Dependencies: 173
-- Name: tabela3_cd_codigo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tabela3_cd_codigo_seq', 1, true);


--
-- TOC entry 2941 (class 0 OID 0)
-- Dependencies: 177
-- Name: tabela3_id2_sq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tabela3_id2_sq', 1, false);


--
-- TOC entry 2942 (class 0 OID 0)
-- Dependencies: 174
-- Name: tabela3_id_identity_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tabela3_id_identity_seq', 1, true);


--
-- TOC entry 2917 (class 0 OID 19805423)
-- Dependencies: 179
-- Data for Name: teste; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY teste (cd_codigo) FROM stdin;
\.


--
-- TOC entry 2943 (class 0 OID 0)
-- Dependencies: 178
-- Name: teste_cd_codigo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('teste_cd_codigo_seq', 1, false);


--
-- TOC entry 2799 (class 2606 OID 19261047)
-- Name: pk_tabela3; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tabela3
    ADD CONSTRAINT pk_tabela3 PRIMARY KEY (cd_codigo);


--
-- TOC entry 2797 (class 2606 OID 19188605)
-- Name: tabela1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tabela1
    ADD CONSTRAINT tabela1_pkey PRIMARY KEY (cd_codigo);


--
-- TOC entry 2795 (class 2606 OID 18933265)
-- Name: tabela2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tabela2
    ADD CONSTRAINT tabela2_pkey PRIMARY KEY (cd_codigo);


--
-- TOC entry 2800 (class 2606 OID 19265655)
-- Name: fk_tabela2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tabela3
    ADD CONSTRAINT fk_tabela2 FOREIGN KEY (cd2_codigo) REFERENCES tabela2(cd_codigo);


--
-- TOC entry 2928 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2015-09-29 09:34:35

--
-- PostgreSQL database dump complete
--

