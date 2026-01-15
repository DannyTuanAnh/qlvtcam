--
-- PostgreSQL database dump
--

\restrict Xw7sFAhTbPOeJY5xvXttpbMT263YCJqYOqzbh9at5dXmz0fc2RfSX73JFXQNYPc

-- Dumped from database version 16.11
-- Dumped by pg_dump version 16.11

-- Started on 2026-01-16 00:22:45

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 218 (class 1259 OID 16760)
-- Name: canbo_kt; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.canbo_kt (
    macanbo integer NOT NULL,
    hoten character varying(100) NOT NULL,
    gioitinh character varying(5) NOT NULL,
    ngaysinh timestamp without time zone NOT NULL,
    sodienthoai character varying(15) NOT NULL,
    email character varying(50),
    donvicongtac integer NOT NULL,
    trangthai smallint DEFAULT 1 NOT NULL,
    manguoidung integer NOT NULL,
    avatar character varying(255),
    CONSTRAINT canbo_kt_gioitinh_check CHECK (((gioitinh)::text = ANY ((ARRAY['Nam'::character varying, 'Nữ'::character varying])::text[])))
);


ALTER TABLE public.canbo_kt OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 16759)
-- Name: canbo_kt_macanbo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.canbo_kt_macanbo_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.canbo_kt_macanbo_seq OWNER TO postgres;

--
-- TOC entry 5061 (class 0 OID 0)
-- Dependencies: 217
-- Name: canbo_kt_macanbo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.canbo_kt_macanbo_seq OWNED BY public.canbo_kt.macanbo;


--
-- TOC entry 228 (class 1259 OID 16822)
-- Name: giong_cam; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.giong_cam (
    magiong integer NOT NULL,
    tengiong character varying(100) NOT NULL,
    dactinh text,
    nguongoc character varying(100)
);


ALTER TABLE public.giong_cam OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 16821)
-- Name: giong_cam_magiong_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.giong_cam_magiong_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.giong_cam_magiong_seq OWNER TO postgres;

--
-- TOC entry 5062 (class 0 OID 0)
-- Dependencies: 227
-- Name: giong_cam_magiong_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.giong_cam_magiong_seq OWNED BY public.giong_cam.magiong;


--
-- TOC entry 230 (class 1259 OID 16831)
-- Name: giong_trong; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.giong_trong (
    matrong integer NOT NULL,
    magiong integer NOT NULL,
    mavu integer NOT NULL,
    mathua integer NOT NULL,
    ngaytrong timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    soluongcay integer
);


ALTER TABLE public.giong_trong OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 16830)
-- Name: giong_trong_matrong_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.giong_trong_matrong_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.giong_trong_matrong_seq OWNER TO postgres;

--
-- TOC entry 5063 (class 0 OID 0)
-- Dependencies: 229
-- Name: giong_trong_matrong_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.giong_trong_matrong_seq OWNED BY public.giong_trong.matrong;


--
-- TOC entry 242 (class 1259 OID 16952)
-- Name: ho_tro_ky_thuat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ho_tro_ky_thuat (
    mahotro integer NOT NULL,
    ngayhotro timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    noidung text NOT NULL,
    macanbo integer NOT NULL,
    maho integer NOT NULL,
    mavung integer NOT NULL
);


ALTER TABLE public.ho_tro_ky_thuat OWNER TO postgres;

--
-- TOC entry 241 (class 1259 OID 16951)
-- Name: ho_tro_ky_thuat_mahotro_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.ho_tro_ky_thuat_mahotro_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.ho_tro_ky_thuat_mahotro_seq OWNER TO postgres;

--
-- TOC entry 5064 (class 0 OID 0)
-- Dependencies: 241
-- Name: ho_tro_ky_thuat_mahotro_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.ho_tro_ky_thuat_mahotro_seq OWNED BY public.ho_tro_ky_thuat.mahotro;


--
-- TOC entry 236 (class 1259 OID 16892)
-- Name: nhat_ky_canh_tac; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.nhat_ky_canh_tac (
    manhatky integer NOT NULL,
    thoigian timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    loaihoatdong character varying(100),
    noidung text,
    mathua integer NOT NULL,
    mavu integer NOT NULL,
    manguoinhap integer NOT NULL
);


ALTER TABLE public.nhat_ky_canh_tac OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 16891)
-- Name: nhat_ky_canh_tac_manhatky_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.nhat_ky_canh_tac_manhatky_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.nhat_ky_canh_tac_manhatky_seq OWNER TO postgres;

--
-- TOC entry 5065 (class 0 OID 0)
-- Dependencies: 235
-- Name: nhat_ky_canh_tac_manhatky_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.nhat_ky_canh_tac_manhatky_seq OWNED BY public.nhat_ky_canh_tac.manhatky;


--
-- TOC entry 220 (class 1259 OID 16776)
-- Name: nong_ho; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.nong_ho (
    maho integer NOT NULL,
    hoten character varying(100) NOT NULL,
    gioitinh character varying(5) NOT NULL,
    ngaysinh timestamp without time zone,
    diachi character varying(255),
    sodienthoai character varying(20),
    email character varying(100),
    mavung integer,
    manguoidung integer NOT NULL,
    avatar character varying(255),
    CONSTRAINT nong_ho_gioitinh_check CHECK (((gioitinh)::text = ANY ((ARRAY['Nam'::character varying, 'Nữ'::character varying])::text[])))
);


ALTER TABLE public.nong_ho OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16775)
-- Name: nong_ho_maho_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.nong_ho_maho_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.nong_ho_maho_seq OWNER TO postgres;

--
-- TOC entry 5066 (class 0 OID 0)
-- Dependencies: 219
-- Name: nong_ho_maho_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.nong_ho_maho_seq OWNED BY public.nong_ho.maho;


--
-- TOC entry 234 (class 1259 OID 16865)
-- Name: phat_hien_sau; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.phat_hien_sau (
    mabaocao integer NOT NULL,
    ngayphathien timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    mucdo character varying(50),
    masau integer NOT NULL,
    mathua integer NOT NULL,
    mavu integer NOT NULL,
    ghichu text
);


ALTER TABLE public.phat_hien_sau OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 16864)
-- Name: phat_hien_sau_mabaocao_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.phat_hien_sau_mabaocao_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.phat_hien_sau_mabaocao_seq OWNER TO postgres;

--
-- TOC entry 5067 (class 0 OID 0)
-- Dependencies: 233
-- Name: phat_hien_sau_mabaocao_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.phat_hien_sau_mabaocao_seq OWNED BY public.phat_hien_sau.mabaocao;


--
-- TOC entry 216 (class 1259 OID 16748)
-- Name: quan_ly_nguoi_dung; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.quan_ly_nguoi_dung (
    manguoidung integer NOT NULL,
    matkhau character varying(255) NOT NULL,
    hoten character varying(100),
    email character varying(100),
    sodienthoai character varying(20),
    vaitro character varying(10) DEFAULT 'nongho'::character varying NOT NULL,
    ngaytao timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT quan_ly_nguoi_dung_vaitro_check CHECK (((vaitro)::text = ANY ((ARRAY['nongho'::character varying, 'canbo'::character varying])::text[])))
);


ALTER TABLE public.quan_ly_nguoi_dung OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 16747)
-- Name: quan_ly_nguoi_dung_manguoidung_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.quan_ly_nguoi_dung_manguoidung_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.quan_ly_nguoi_dung_manguoidung_seq OWNER TO postgres;

--
-- TOC entry 5068 (class 0 OID 0)
-- Dependencies: 215
-- Name: quan_ly_nguoi_dung_manguoidung_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.quan_ly_nguoi_dung_manguoidung_seq OWNED BY public.quan_ly_nguoi_dung.manguoidung;


--
-- TOC entry 232 (class 1259 OID 16856)
-- Name: sau_benh; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sau_benh (
    masau integer NOT NULL,
    tensaubenh character varying(100) NOT NULL,
    trieuchung text,
    bienphapxuly text
);


ALTER TABLE public.sau_benh OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 16855)
-- Name: sau_benh_masau_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sau_benh_masau_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sau_benh_masau_seq OWNER TO postgres;

--
-- TOC entry 5069 (class 0 OID 0)
-- Dependencies: 231
-- Name: sau_benh_masau_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sau_benh_masau_seq OWNED BY public.sau_benh.masau;


--
-- TOC entry 240 (class 1259 OID 16939)
-- Name: thoi_tiet; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.thoi_tiet (
    mathoitiet integer NOT NULL,
    ngaydo timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    mavung integer NOT NULL,
    nhietdo real NOT NULL,
    doam real NOT NULL,
    luongmua real,
    thoitiet character varying(100) NOT NULL,
    ghichu character varying(100)
);


ALTER TABLE public.thoi_tiet OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 16938)
-- Name: thoi_tiet_mathoitiet_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.thoi_tiet_mathoitiet_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.thoi_tiet_mathoitiet_seq OWNER TO postgres;

--
-- TOC entry 5070 (class 0 OID 0)
-- Dependencies: 239
-- Name: thoi_tiet_mathoitiet_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.thoi_tiet_mathoitiet_seq OWNED BY public.thoi_tiet.mathoitiet;


--
-- TOC entry 238 (class 1259 OID 16919)
-- Name: thu_hoach; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.thu_hoach (
    mathuhoach integer NOT NULL,
    ngaythuhoach timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    sanluong numeric(10,2),
    chatluong character varying(20),
    ghichu text,
    mathua integer NOT NULL,
    mavu integer NOT NULL
);


ALTER TABLE public.thu_hoach OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 16918)
-- Name: thu_hoach_mathuhoach_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.thu_hoach_mathuhoach_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.thu_hoach_mathuhoach_seq OWNER TO postgres;

--
-- TOC entry 5071 (class 0 OID 0)
-- Dependencies: 237
-- Name: thu_hoach_mathuhoach_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.thu_hoach_mathuhoach_seq OWNED BY public.thu_hoach.mathuhoach;


--
-- TOC entry 224 (class 1259 OID 16803)
-- Name: thua_dat; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.thua_dat (
    mathua integer NOT NULL,
    dientich real NOT NULL,
    loaidat character varying(100) NOT NULL,
    vitri character varying(255),
    maho integer NOT NULL
);


ALTER TABLE public.thua_dat OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 16802)
-- Name: thua_dat_mathua_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.thua_dat_mathua_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.thua_dat_mathua_seq OWNER TO postgres;

--
-- TOC entry 5072 (class 0 OID 0)
-- Dependencies: 223
-- Name: thua_dat_mathua_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.thua_dat_mathua_seq OWNED BY public.thua_dat.mathua;


--
-- TOC entry 226 (class 1259 OID 16815)
-- Name: vu_mua; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vu_mua (
    mavu integer NOT NULL,
    tenvu character varying(100) NOT NULL,
    thoigianbatdau timestamp without time zone NOT NULL,
    thoigianthuhoach timestamp without time zone,
    motavu character varying(255)
);


ALTER TABLE public.vu_mua OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 16814)
-- Name: vu_mua_mavu_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.vu_mua_mavu_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vu_mua_mavu_seq OWNER TO postgres;

--
-- TOC entry 5073 (class 0 OID 0)
-- Dependencies: 225
-- Name: vu_mua_mavu_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.vu_mua_mavu_seq OWNED BY public.vu_mua.mavu;


--
-- TOC entry 222 (class 1259 OID 16793)
-- Name: vung_trong; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.vung_trong (
    mavung integer NOT NULL,
    tenvung character varying(100) NOT NULL,
    diachi character varying(255),
    tinh character varying(50) NOT NULL,
    huyen character varying(50),
    xa character varying(50),
    dientich real,
    mota text,
    trangthai smallint DEFAULT 1,
    sohodan integer
);


ALTER TABLE public.vung_trong OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16792)
-- Name: vung_trong_mavung_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.vung_trong_mavung_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vung_trong_mavung_seq OWNER TO postgres;

--
-- TOC entry 5074 (class 0 OID 0)
-- Dependencies: 221
-- Name: vung_trong_mavung_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.vung_trong_mavung_seq OWNED BY public.vung_trong.mavung;


--
-- TOC entry 4803 (class 2604 OID 16763)
-- Name: canbo_kt macanbo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.canbo_kt ALTER COLUMN macanbo SET DEFAULT nextval('public.canbo_kt_macanbo_seq'::regclass);


--
-- TOC entry 4810 (class 2604 OID 16825)
-- Name: giong_cam magiong; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.giong_cam ALTER COLUMN magiong SET DEFAULT nextval('public.giong_cam_magiong_seq'::regclass);


--
-- TOC entry 4811 (class 2604 OID 16834)
-- Name: giong_trong matrong; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.giong_trong ALTER COLUMN matrong SET DEFAULT nextval('public.giong_trong_matrong_seq'::regclass);


--
-- TOC entry 4822 (class 2604 OID 16955)
-- Name: ho_tro_ky_thuat mahotro; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ho_tro_ky_thuat ALTER COLUMN mahotro SET DEFAULT nextval('public.ho_tro_ky_thuat_mahotro_seq'::regclass);


--
-- TOC entry 4816 (class 2604 OID 16895)
-- Name: nhat_ky_canh_tac manhatky; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhat_ky_canh_tac ALTER COLUMN manhatky SET DEFAULT nextval('public.nhat_ky_canh_tac_manhatky_seq'::regclass);


--
-- TOC entry 4805 (class 2604 OID 16779)
-- Name: nong_ho maho; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nong_ho ALTER COLUMN maho SET DEFAULT nextval('public.nong_ho_maho_seq'::regclass);


--
-- TOC entry 4814 (class 2604 OID 16868)
-- Name: phat_hien_sau mabaocao; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phat_hien_sau ALTER COLUMN mabaocao SET DEFAULT nextval('public.phat_hien_sau_mabaocao_seq'::regclass);


--
-- TOC entry 4800 (class 2604 OID 16751)
-- Name: quan_ly_nguoi_dung manguoidung; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.quan_ly_nguoi_dung ALTER COLUMN manguoidung SET DEFAULT nextval('public.quan_ly_nguoi_dung_manguoidung_seq'::regclass);


--
-- TOC entry 4813 (class 2604 OID 16859)
-- Name: sau_benh masau; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sau_benh ALTER COLUMN masau SET DEFAULT nextval('public.sau_benh_masau_seq'::regclass);


--
-- TOC entry 4820 (class 2604 OID 16942)
-- Name: thoi_tiet mathoitiet; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.thoi_tiet ALTER COLUMN mathoitiet SET DEFAULT nextval('public.thoi_tiet_mathoitiet_seq'::regclass);


--
-- TOC entry 4818 (class 2604 OID 16922)
-- Name: thu_hoach mathuhoach; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.thu_hoach ALTER COLUMN mathuhoach SET DEFAULT nextval('public.thu_hoach_mathuhoach_seq'::regclass);


--
-- TOC entry 4808 (class 2604 OID 16806)
-- Name: thua_dat mathua; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.thua_dat ALTER COLUMN mathua SET DEFAULT nextval('public.thua_dat_mathua_seq'::regclass);


--
-- TOC entry 4809 (class 2604 OID 16818)
-- Name: vu_mua mavu; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vu_mua ALTER COLUMN mavu SET DEFAULT nextval('public.vu_mua_mavu_seq'::regclass);


--
-- TOC entry 4806 (class 2604 OID 16796)
-- Name: vung_trong mavung; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vung_trong ALTER COLUMN mavung SET DEFAULT nextval('public.vung_trong_mavung_seq'::regclass);


--
-- TOC entry 5031 (class 0 OID 16760)
-- Dependencies: 218
-- Data for Name: canbo_kt; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.canbo_kt (macanbo, hoten, gioitinh, ngaysinh, sodienthoai, email, donvicongtac, trangthai, manguoidung, avatar) FROM stdin;
1	Trần Hải Đăng	Nam	1985-06-12 00:00:00	0911000005	dang@gmail.com	1	1	5	\N
2	Hồ Tấn Đạt	Nam	1988-01-12 00:00:00	0911000086	dat@gmail.com	1	1	6	\N
3	Phương Thị Tuyết Nhung	Nữ	1985-06-12 00:00:00	0911000007	nhung@gmail.com	1	1	7	\N
4	Nguyễn Ngọc Duệ	Nữ	1985-06-12 00:00:00	0911000010	due@gmail.com	1	1	10	\N
5	Trần Văn Cán 	Nam	2005-08-17 20:04:15	0987654321	canbo1@gmail.com	1	1	13	\N
\.


--
-- TOC entry 5041 (class 0 OID 16822)
-- Dependencies: 228
-- Data for Name: giong_cam; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.giong_cam (magiong, tengiong, dactinh, nguongoc) FROM stdin;
1	Cam sành Hà Giang	Vỏ dày, vị ngọt thanh, thích hợp khí hậu vùng núi	Hà Giang
2	Cam sành Hậu Giang	Trái lớn, vỏ mỏng, ngọt đậm, năng suất cao	Hậu Giang
3	Cam sành Vĩnh Long	Thích hợp vùng ĐBSCL, trái trung bình, thơm, dễ tiêu thụ	Vĩnh Long
4	Cam sành Tân Phú	Sinh trưởng tốt, chống chịu sâu bệnh khá	Đồng Nai
5	Cam sành Cao Phong	Vỏ xanh, mọng nước, ngọt dịu, thịt cam màu vàng cam	Hòa Bình
6	Cam sành Lục Ngạn	Năng suất trung bình, có thể trồng xen canh	Bắc Giang
7	Cam sành lai Xoàn	Giống mới, vỏ mỏng, ít hạt, ngọt đậm	Lai tạo địa phương
8	Cam sành không hạt	Thuận tiện tiêu dùng, chất lượng ổn định	Viện Nghiên cứu
\.


--
-- TOC entry 5043 (class 0 OID 16831)
-- Dependencies: 230
-- Data for Name: giong_trong; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.giong_trong (matrong, magiong, mavu, mathua, ngaytrong, soluongcay) FROM stdin;
2	7	1	2	2024-01-10 00:00:00	28
3	2	1	3	2024-01-10 00:00:00	31
4	4	1	1	2024-01-12 00:00:00	32
5	3	1	5	2024-01-12 00:00:00	32
6	1	1	6	2024-01-10 00:00:00	34
7	5	1	7	2024-01-10 00:00:00	35
8	2	1	8	2024-01-11 00:00:00	26
9	2	1	9	2024-01-10 00:00:00	33
10	5	1	10	2024-01-10 00:00:00	40
11	7	1	11	2024-01-11 00:00:00	36
12	2	1	12	2024-01-11 00:00:00	38
13	6	2	1	2024-05-15 00:00:00	40
14	4	2	2	2024-05-16 00:00:00	26
15	6	2	3	2024-05-15 00:00:00	25
16	7	2	4	2024-05-16 00:00:00	40
17	4	2	5	2024-05-16 00:00:00	30
18	8	2	6	2024-05-16 00:00:00	31
19	5	2	7	2024-05-18 00:00:00	40
20	7	2	8	2024-05-18 00:00:00	26
21	8	2	9	2024-05-18 00:00:00	36
22	1	2	10	2024-05-15 00:00:00	30
23	7	2	11	2024-05-15 00:00:00	32
24	4	2	12	2024-05-17 00:00:00	36
25	8	3	1	2024-09-13 00:00:00	31
26	4	3	2	2024-09-13 00:00:00	27
27	4	3	3	2024-09-12 00:00:00	33
29	6	3	5	2024-09-11 00:00:00	29
30	7	3	6	2024-09-10 00:00:00	25
31	8	3	7	2024-09-12 00:00:00	34
32	8	3	8	2024-09-13 00:00:00	26
33	1	3	9	2024-09-12 00:00:00	38
34	2	3	10	2024-09-10 00:00:00	26
35	7	3	11	2024-09-10 00:00:00	40
36	3	3	12	2024-09-10 00:00:00	26
37	8	4	1	2025-01-05 00:00:00	38
38	1	4	2	2025-01-06 00:00:00	27
40	3	4	4	2025-01-06 00:00:00	36
41	7	4	5	2025-01-08 00:00:00	33
42	6	4	6	2025-01-05 00:00:00	40
43	8	4	7	2025-01-06 00:00:00	37
44	6	4	8	2025-01-05 00:00:00	37
45	4	4	9	2025-01-07 00:00:00	30
46	6	4	10	2025-01-08 00:00:00	32
47	4	4	11	2025-01-07 00:00:00	32
48	5	4	12	2025-01-06 00:00:00	31
49	7	5	1	2025-06-03 00:00:00	32
50	8	5	2	2025-06-02 00:00:00	26
51	2	5	3	2025-06-04 00:00:00	40
53	2	5	5	2025-06-02 00:00:00	28
54	8	5	6	2025-06-01 00:00:00	37
55	2	5	7	2025-06-02 00:00:00	37
56	3	5	8	2025-06-04 00:00:00	29
57	8	5	9	2025-06-04 00:00:00	38
58	7	5	10	2025-06-04 00:00:00	32
59	7	5	11	2025-06-02 00:00:00	26
60	3	5	12	2025-06-03 00:00:00	31
61	5	7	3	2025-07-14 08:12:00	35
62	4	7	3	2025-08-14 18:13:00	45
\.


--
-- TOC entry 5055 (class 0 OID 16952)
-- Dependencies: 242
-- Data for Name: ho_tro_ky_thuat; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ho_tro_ky_thuat (mahotro, ngayhotro, noidung, macanbo, maho, mavung) FROM stdin;
1	2025-07-25 00:00:00	Hỗ trợ phòng trừ sâu bệnh trên cam sành	1	1	1
2	2025-07-26 00:00:00	Tư vấn kỹ thuật bón phân cho cam sành giai đoạn phát triển trái	2	3	1
3	2025-07-27 00:00:00	Hướng dẫn tỉa cành, tạo tán cho cam sành	3	6	1
7	2025-08-21 18:49:00	Tư vấn bón phân theo loại sâu bệnh	5	2	2
\.


--
-- TOC entry 5049 (class 0 OID 16892)
-- Dependencies: 236
-- Data for Name: nhat_ky_canh_tac; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.nhat_ky_canh_tac (manhatky, thoigian, loaihoatdong, noidung, mathua, mavu, manguoinhap) FROM stdin;
1	2024-01-12 00:30:00	Gieo giống	Gieo hom cam sành giống sạch bệnh trên luống đất tơi xốp.	1	1	1
2	2025-08-07 17:38:53	Tưới nước	Tưới nước lần đầu sau gieo giống bằng hệ thống nhỏ giọt.	1	1	1
3	2024-02-19 23:45:00	Bón phân	Bón phân NPK 16-16-8 giai đoạn cây con.	2	1	2
5	2024-04-15 00:00:00	Tưới nước	Tưới nước tăng cường do thời tiết nắng hạn.	5	1	2
6	2024-05-10 02:30:00	Bón phân	Bón phân hữu cơ vi sinh thúc ra đọt non.	5	1	2
7	2024-06-19 23:30:00	Diệt sâu bệnh	Phun thuốc sinh học phòng nhện đỏ gây hại lá.	5	2	1
9	2024-09-15 00:30:00	Bón phân	Bón phân kali hỗ trợ quá trình tạo quả.	9	3	4
10	2024-10-20 01:15:00	Tưới nước	Tưới ẩm giữ trái giai đoạn chín.	9	3	4
11	2025-01-08 02:45:00	Gieo giống	Chuẩn bị đất và trồng cây mới cho vụ Xuân 2025.	10	4	8
12	2025-02-18 01:00:00	Bón phân	Bón phân lót bằng phân chuồng hoai mục.	10	4	8
13	2025-03-03 00:20:00	Diệt sâu bệnh	Phun thuốc sau khi phát hiện vàng lá greening.	12	4	9
14	2025-06-09 23:50:00	Tưới nước	Tưới nước định kỳ 3 ngày/lần mùa hè.	11	5	9
15	2025-07-05 00:30:00	Bón phân	Bón phân hữu cơ tăng sức đề kháng mùa mưa.	12	5	9
16	2025-07-24 02:00:00	Diệt sâu bệnh	Phun Trichoderma xử lý bệnh thối rễ.	2	5	2
17	2025-08-06 05:00:00	Diệt sâu bệnh	Phun dầu khoáng diệt rầy mềm và phun thuốc sinh học phòng nhện đỏ gây hại lá.	1	5	1
18	2025-08-09 05:56:00	Diệt sâu bệnh	Diệt sâu ăn lá, gây mất mùa	5	5	2
19	2025-08-19 07:41:00	Phun thuốc	phun	5	7	2
\.


--
-- TOC entry 5033 (class 0 OID 16776)
-- Dependencies: 220
-- Data for Name: nong_ho; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.nong_ho (maho, hoten, gioitinh, ngaysinh, diachi, sodienthoai, email, mavung, manguoidung, avatar) FROM stdin;
1	Nguyễn Văn Tới	Nam	1982-03-15 00:00:00	Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long	0911009876	toi@gmail.com	1	1	\N
2	Nguyễn Bích Tuyền	Nữ	1982-03-15 00:00:00	Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long	0911000002	tuyen@gmail.com	2	2	uploads/avatars/avatar_2_1755853405.ico
3	Dương Nhật Thanh	Nam	1982-03-15 00:00:00	Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long	0911000017	thanh@gmail.com	1	3	\N
4	Mai Thanh Truyền	Nam	1982-03-15 00:00:00	Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long	0911000004	truyen@gmail.com	2	4	\N
5	Trần Bảo Phúc	Nam	1982-03-15 00:00:00	Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long	0911000008	phuc@gmail.com	3	8	\N
6	Phan Minh Khoa	Nam	1979-07-20 00:00:00	Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long	0911000009	khoa@gmail.com	3	9	\N
7	Nguyễn Văn Phương	Nam	2005-08-17 18:58:37	Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long	0123456789	vanphuong@gmail.com	2	11	\N
8	Nguyễn Thị Thử	Nữ	2005-09-17 20:03:20	Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long	0912345678	thithu@gmail.com	1	12	\N
25	Trần Tuấn Anh	Nam	2005-04-07 12:45:20	Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long	0911989999	anh@gmail.com	3	22	\N
26	Trần Hoàng Phương	Nam	2005-08-11 21:46:29	Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long	0911009899	phuong@gmail.com	3	23	\N
\.


--
-- TOC entry 5047 (class 0 OID 16865)
-- Dependencies: 234
-- Data for Name: phat_hien_sau; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.phat_hien_sau (mabaocao, ngayphathien, mucdo, masau, mathua, mavu, ghichu) FROM stdin;
1	2024-02-16 00:00:00	Nhẹ	1	1	1	Sâu vẽ bùa xuất hiện ở lá non, đã xử lý bằng thuốc sinh học.
2	2024-08-25 00:00:00	Nhẹ	1	7	2	Sâu vẽ bùa vừa xuất hiện, can thiệp kịp thời.
3	2025-06-22 00:00:00	Nhẹ	1	11	5	Sâu vẽ bùa vừa chớm phát, đã xử lý.
4	2024-03-05 00:00:00	Trung bình	2	3	1	Rầy mềm gây chảy nhựa, xử lý bằng dầu khoáng.
5	2024-11-05 00:00:00	Nhẹ	2	8	3	Rầy mềm gây hại nhẹ ở tán lá non.
6	2025-07-10 00:00:00	Trung bình	2	10	5	Rầy mềm nhiều do mưa liên tục, đã phun thuốc.
7	2024-06-20 00:00:00	Nặng	3	5	2	Nhện đỏ xuất hiện nhiều ở mặt dưới lá, làm lá úa.
8	2025-01-18 00:00:00	Trung bình	3	10	4	Nhện đỏ xuất hiện sau mùa khô, gây ảnh hưởng nhẹ.
10	2025-03-03 00:00:00	Nặng	4	12	4	Cam sành vàng lá toàn bộ cây, cần tiêu hủy cây nhiễm.
11	2025-07-24 00:00:00	Trung bình	5	2	5	Vùng rễ có mùi hôi, rễ đen, xử lý bằng Trichoderma.
12	2024-09-12 00:00:00	Nặng	5	9	3	Thối rễ làm cây héo, phải xử lý nấm đất.
\.


--
-- TOC entry 5029 (class 0 OID 16748)
-- Dependencies: 216
-- Data for Name: quan_ly_nguoi_dung; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.quan_ly_nguoi_dung (manguoidung, matkhau, hoten, email, sodienthoai, vaitro, ngaytao) FROM stdin;
1	123456	Nguyễn Văn Tới	toi@gmail.com	0911000001	nongho	2025-07-27 09:45:55
2	123456	Nguyễn Bích Tuyền	tuyen@gmail.com	0911000002	nongho	2025-07-27 09:45:55
3	123456	Dương Nhật Thanh	thanh@gmail.com	0911000003	nongho	2025-07-27 09:45:55
4	123456	Mai Thanh Truyền	truyen@gmail.com	0911000004	nongho	2025-07-27 09:45:55
5	123456	Trần Hải Đăng	dang@gmail.com	0911000005	canbo	2025-07-27 09:45:55
6	123456	Hồ Tấn Đạt	dat@gmail.com	0911000086	canbo	2025-07-27 09:45:55
7	123456	Phương Thị Tuyết Nhung	nhung@gmail.com	0911000007	canbo	2025-07-27 09:45:55
8	123456	Trần Bảo Phúc	phuc@gmail.com	0911000008	nongho	2025-07-27 09:45:55
9	123456	Phan Minh Khoa	khoa@gmail.com	0911000009	nongho	2025-07-27 09:45:55
10	123456	Nguyễn Ngọc Duệ	due@gmail.com	0911000010	canbo	2025-07-27 09:47:55
11	123456	Nguyễn Văn Phương	vanphuong@gmail.com	0123456789	nongho	2025-08-17 11:58:37
12	123456	Nguyễn Thị Thử	thithu@gmail.com	0912345678	nongho	2025-08-17 13:03:20
13	123456	Trần Văn Cán 	canbo1@gmail.com	0987654321	canbo	2025-08-17 13:04:15
22	123456	Trần Tuấn Anh	anh@gmail.com	0911989999	nongho	2025-08-22 13:13:00
23	123456	Trần Hoàng Phương	phuong@gmail.com	0911009899	nongho	2025-08-23 14:46:59
\.


--
-- TOC entry 5045 (class 0 OID 16856)
-- Dependencies: 232
-- Data for Name: sau_benh; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sau_benh (masau, tensaubenh, trieuchung, bienphapxuly) FROM stdin;
1	Rầy mềm	Chích hút nhựa cây non, làm lá xoăn và còi cọc	Phun thuốc bảo vệ thực vật như Confidor hoặc dùng dầu khoáng
2	Sâu vẽ bùa	Tạo đường hầm trên lá, làm lá xoăn và giảm quang hợp	Phun thuốc trừ sâu như Abamectin hoặc dùng biện pháp sinh học
3	Bệnh vàng lá Greening	Lá vàng, rụng quả non, cây sinh trưởng kém	Tiêu hủy cây bệnh, sử dụng cây giống sạch bệnh, quản lý rầy chổng cánh
4	Bệnh loét vi khuẩn	Xuất hiện đốm nâu có viền vàng trên lá và quả	Cắt bỏ cành bệnh, phun thuốc gốc đồng như Copper Hydroxide
5	Bệnh thán thư	Làm khô cành, quả bị thối nhũn và rụng	Cắt tỉa cây thông thoáng, phun thuốc như Mancozeb
\.


--
-- TOC entry 5053 (class 0 OID 16939)
-- Dependencies: 240
-- Data for Name: thoi_tiet; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.thoi_tiet (mathoitiet, ngaydo, mavung, nhietdo, doam, luongmua, thoitiet, ghichu) FROM stdin;
1	2025-07-27 00:00:00	1	35	70	9	Nắng	Tưới nhiều nước
2	2025-07-27 00:00:00	2	32	75	12	Nắng	Mưa nhiều
4	2025-08-09 12:20:00	3	31	58	20	Mưa vừa	Mưa âm u
\.


--
-- TOC entry 5051 (class 0 OID 16919)
-- Dependencies: 238
-- Data for Name: thu_hoach; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.thu_hoach (mathuhoach, ngaythuhoach, sanluong, chatluong, ghichu, mathua, mavu) FROM stdin;
1	2024-07-20 00:00:00	1680.00	Tốt	Đất kém màu, bù phân hữu cơ	1	1
2	2024-07-20 00:00:00	1582.26	Khá	Năng suất cao, trái đều	2	1
3	2024-07-20 00:00:00	1597.19	Khá	Có sâu vẽ bùa nhưng xử lý tốt	3	1
4	2024-07-20 00:00:00	1660.14	Tốt	Chăm sóc chuẩn, trái ngọt	4	1
5	2024-07-20 00:00:00	1474.91	Khá	Mẫu mã đẹp, đạt tiêu chuẩn	5	1
6	2024-07-20 00:00:00	1438.37	Tốt	Thiếu nước đầu vụ	6	1
7	2024-07-20 00:00:00	1658.05	Tốt	Thiếu nước đầu vụ	7	1
8	2024-07-20 00:00:00	1605.89	Tốt	Ảnh hưởng mưa cuối vụ	8	1
9	2024-07-20 00:00:00	1515.90	Trung bình	Vườn bị ngập nhẹ	9	1
10	2024-07-20 00:00:00	1666.89	Trung bình	Có sâu vẽ bùa nhưng xử lý tốt	10	1
11	2024-07-20 00:00:00	1631.71	Khá	Chăm sóc chuẩn, trái ngọt	11	1
12	2024-07-20 00:00:00	1593.78	Khá	Chăm sóc chuẩn, trái ngọt	12	1
13	2024-11-25 00:00:00	1653.56	Tốt	Trái nhỏ hơn trung bình	1	2
14	2024-11-25 00:00:00	1368.10	Trung bình	Đất kém màu, bù phân hữu cơ	2	2
15	2024-11-25 00:00:00	1674.02	Tốt	Chăm sóc chuẩn, trái ngọt	3	2
16	2024-11-25 00:00:00	1595.93	Trung bình	Chăm sóc chuẩn, trái ngọt	4	2
17	2024-11-25 00:00:00	1491.14	Khá	Vườn bị ngập nhẹ	5	2
18	2024-11-25 00:00:00	1697.68	Trung bình	Trái nhỏ hơn trung bình	6	2
19	2024-11-25 00:00:00	1565.45	Khá	Ảnh hưởng mưa cuối vụ	7	2
20	2024-11-25 00:00:00	1459.68	Khá	Phân bố quả chưa đều	8	2
21	2024-11-25 00:00:00	1645.32	Tốt	Đất kém màu, bù phân hữu cơ	9	2
22	2024-11-25 00:00:00	1521.74	Khá	Ảnh hưởng mưa cuối vụ	10	2
23	2024-11-25 00:00:00	1568.16	Khá	Có sâu vẽ bùa nhưng xử lý tốt	11	2
24	2024-11-25 00:00:00	1512.82	Khá	Mẫu mã đẹp, đạt tiêu chuẩn	12	2
25	2025-03-15 00:00:00	1602.00	Tốt	Thiếu nước đầu vụ	1	3
26	2025-03-15 00:00:00	1380.02	Tốt	Chăm sóc chuẩn, trái ngọt	2	3
27	2025-03-15 00:00:00	1598.30	Tốt	Ảnh hưởng mưa cuối vụ	3	3
28	2025-03-15 00:00:00	1636.91	Tốt	Đất kém màu, bù phân hữu cơ	4	3
29	2025-03-15 00:00:00	1455.32	Khá	Trái to, ít sâu bệnh	5	3
30	2025-03-15 00:00:00	1552.73	Trung bình	Chăm sóc chuẩn, trái ngọt	6	3
31	2025-03-15 00:00:00	1427.20	Trung bình	Phân bố quả chưa đều	7	3
32	2025-03-15 00:00:00	1358.99	Khá	Mẫu mã đẹp, đạt tiêu chuẩn	8	3
33	2025-03-15 00:00:00	1561.13	Khá	Chăm sóc chuẩn, trái ngọt	9	3
34	2025-03-15 00:00:00	1647.41	Tốt	Có sâu vẽ bùa nhưng xử lý tốt	10	3
35	2025-03-15 00:00:00	1469.64	Khá	Vườn bị ngập nhẹ	11	3
36	2025-03-15 00:00:00	1657.91	Trung bình	Trái nhỏ hơn trung bình	12	3
38	2025-07-10 00:00:00	1519.35	Khá	Sâu đục trái thấp	2	4
39	2025-07-10 00:00:00	1531.64	Khá	Đất kém màu, bù phân hữu cơ	3	4
40	2025-07-10 00:00:00	1619.66	Trung bình	Ảnh hưởng mưa cuối vụ	4	4
41	2025-07-10 00:00:00	1607.39	Trung bình	Đất kém màu, bù phân hữu cơ	5	4
42	2025-07-10 00:00:00	1521.75	Tốt	Mẫu mã đẹp, đạt tiêu chuẩn	6	4
43	2025-07-10 00:00:00	1510.15	Khá	Chăm sóc chuẩn, trái ngọt	7	4
44	2025-07-10 00:00:00	1424.33	Tốt	Trái nhỏ hơn trung bình	8	4
45	2025-07-10 00:00:00	1620.10	Trung bình	Sâu đục trái thấp	9	4
46	2025-07-10 00:00:00	1492.86	Trung bình	Có sâu vẽ bùa nhưng xử lý tốt	10	4
47	2025-07-10 00:00:00	1467.14	Tốt	Phân bố quả chưa đều	11	4
48	2025-07-10 00:00:00	1668.21	Tốt	Ảnh hưởng mưa cuối vụ	12	4
51	2025-08-08 22:45:22	1645.20	Tốt	Năng suất cao, trái đều	1	5
\.


--
-- TOC entry 5037 (class 0 OID 16803)
-- Dependencies: 224
-- Data for Name: thua_dat; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.thua_dat (mathua, dientich, loaidat, vitri, maho) FROM stdin;
1	1500	Đất cát	Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long	1
2	1600.5	Đất trồng cam sành	Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long	2
3	1450	Đất trồng cam sành	Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long	1
4	1700.25	Đất trồng cam sành	Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long	1
5	1550.75	Đất trồng cam sành	Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long	2
6	1625.5	Đất trồng cam sành	Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long	3
7	1420	Đất trồng cam sành	Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long	4
8	1580.5	Đất trồng cam sành	Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long	4
9	1650.25	Đất trồng cam sành	Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long	4
10	1510.75	Đất trồng cam sành	Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long	5
11	1490	Đất trồng cam sành	Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long	6
12	1725	Đất trồng cam sành	Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long	6
\.


--
-- TOC entry 5039 (class 0 OID 16815)
-- Dependencies: 226
-- Data for Name: vu_mua; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.vu_mua (mavu, tenvu, thoigianbatdau, thoigianthuhoach, motavu) FROM stdin;
1	Vụ Xuân 2024	2024-01-10 00:00:00	2024-04-07 00:00:00	Vụ xuân năm 2024, trồng cam sành vào đầu mùa nắng
2	Vụ Hạ 2024	2024-03-30 00:00:00	2024-06-25 00:00:00	Vụ hè mưa nhiều, thích hợp cho cam sành ra hoa và phát triển tốt
3	Vụ Thu 2024	2024-07-10 00:00:00	2024-11-28 00:00:00	Vụ cam thu, thời gian chăm sóc dài hơn, thu hoạch vào đầu gần cuối năm
4	Vụ Đông 2024	2024-11-11 00:00:00	2025-01-16 00:00:00	Đây là thời điểm lý tưởng để cây cam phát triển bộ rễ, hấp thụ dinh dưỡng và chuẩn bị cho giai đoạn ra hoa, đậu trái vào mùa xuân
5	Vụ Xuân 2025	2025-01-28 00:00:00	2025-04-15 21:49:21	Thời tiết ấm áp và độ ẩm cao trong giai đoạn này giúp cây cam dễ dàng bén rễ và phát triển tốt, giảm thiểu nguy cơ chết cây 
6	Vụ Hạ 2025	2025-04-29 21:51:50	2025-07-23 21:51:50	Việc trồng cam vào mùa mưa giúp cây có đủ độ ẩm, giảm công tưới, nhưng cần chú ý phòng trừ sâu bệnh
7	Vụ Thu 2025	2025-08-01 00:00:00	2025-10-24 00:00:00	Vụ thu 2025 đang canh tác, dự kiến thu hoạch cuối năm.
\.


--
-- TOC entry 5035 (class 0 OID 16793)
-- Dependencies: 222
-- Data for Name: vung_trong; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.vung_trong (mavung, tenvung, diachi, tinh, huyen, xa, dientich, mota, trangthai, sohodan) FROM stdin;
1	Vùng trồng cam sành	Ấp Mỹ Hưng	Vĩnh Long	Trà Ôn	Trà Côn	20	Vùng chuyên trồng cam sành chất lượng cao	1	3
2	Vùng trồng cam sành	Ấp An Hòa B	Vĩnh Long	Tam Bình	Bình Ninh	40	Vùng chuyên trồng cam sành chất lượng cao	1	3
3	Vùng trồng cam sành	Ấp Hiếu Ngãi	Vĩnh Long	Vũng Liêm	Hiếu Thành	37	Vùng chuyên trồng cam sành chất lượng cao	1	4
\.


--
-- TOC entry 5075 (class 0 OID 0)
-- Dependencies: 217
-- Name: canbo_kt_macanbo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.canbo_kt_macanbo_seq', 1, false);


--
-- TOC entry 5076 (class 0 OID 0)
-- Dependencies: 227
-- Name: giong_cam_magiong_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.giong_cam_magiong_seq', 1, false);


--
-- TOC entry 5077 (class 0 OID 0)
-- Dependencies: 229
-- Name: giong_trong_matrong_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.giong_trong_matrong_seq', 1, false);


--
-- TOC entry 5078 (class 0 OID 0)
-- Dependencies: 241
-- Name: ho_tro_ky_thuat_mahotro_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ho_tro_ky_thuat_mahotro_seq', 1, false);


--
-- TOC entry 5079 (class 0 OID 0)
-- Dependencies: 235
-- Name: nhat_ky_canh_tac_manhatky_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.nhat_ky_canh_tac_manhatky_seq', 1, false);


--
-- TOC entry 5080 (class 0 OID 0)
-- Dependencies: 219
-- Name: nong_ho_maho_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.nong_ho_maho_seq', 1, false);


--
-- TOC entry 5081 (class 0 OID 0)
-- Dependencies: 233
-- Name: phat_hien_sau_mabaocao_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.phat_hien_sau_mabaocao_seq', 1, false);


--
-- TOC entry 5082 (class 0 OID 0)
-- Dependencies: 215
-- Name: quan_ly_nguoi_dung_manguoidung_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.quan_ly_nguoi_dung_manguoidung_seq', 1, false);


--
-- TOC entry 5083 (class 0 OID 0)
-- Dependencies: 231
-- Name: sau_benh_masau_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sau_benh_masau_seq', 1, false);


--
-- TOC entry 5084 (class 0 OID 0)
-- Dependencies: 239
-- Name: thoi_tiet_mathoitiet_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.thoi_tiet_mathoitiet_seq', 1, false);


--
-- TOC entry 5085 (class 0 OID 0)
-- Dependencies: 237
-- Name: thu_hoach_mathuhoach_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.thu_hoach_mathuhoach_seq', 1, false);


--
-- TOC entry 5086 (class 0 OID 0)
-- Dependencies: 223
-- Name: thua_dat_mathua_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.thua_dat_mathua_seq', 1, false);


--
-- TOC entry 5087 (class 0 OID 0)
-- Dependencies: 225
-- Name: vu_mua_mavu_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.vu_mua_mavu_seq', 1, false);


--
-- TOC entry 5088 (class 0 OID 0)
-- Dependencies: 221
-- Name: vung_trong_mavung_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.vung_trong_mavung_seq', 1, false);


--
-- TOC entry 4832 (class 2606 OID 16769)
-- Name: canbo_kt canbo_kt_manguoidung_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.canbo_kt
    ADD CONSTRAINT canbo_kt_manguoidung_key UNIQUE (manguoidung);


--
-- TOC entry 4834 (class 2606 OID 16767)
-- Name: canbo_kt canbo_kt_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.canbo_kt
    ADD CONSTRAINT canbo_kt_pkey PRIMARY KEY (macanbo);


--
-- TOC entry 4846 (class 2606 OID 16829)
-- Name: giong_cam giong_cam_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.giong_cam
    ADD CONSTRAINT giong_cam_pkey PRIMARY KEY (magiong);


--
-- TOC entry 4848 (class 2606 OID 16837)
-- Name: giong_trong giong_trong_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.giong_trong
    ADD CONSTRAINT giong_trong_pkey PRIMARY KEY (matrong);


--
-- TOC entry 4866 (class 2606 OID 16960)
-- Name: ho_tro_ky_thuat ho_tro_ky_thuat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ho_tro_ky_thuat
    ADD CONSTRAINT ho_tro_ky_thuat_pkey PRIMARY KEY (mahotro);


--
-- TOC entry 4858 (class 2606 OID 16900)
-- Name: nhat_ky_canh_tac nhat_ky_canh_tac_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhat_ky_canh_tac
    ADD CONSTRAINT nhat_ky_canh_tac_pkey PRIMARY KEY (manhatky);


--
-- TOC entry 4836 (class 2606 OID 16786)
-- Name: nong_ho nong_ho_manguoidung_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nong_ho
    ADD CONSTRAINT nong_ho_manguoidung_key UNIQUE (manguoidung);


--
-- TOC entry 4838 (class 2606 OID 16784)
-- Name: nong_ho nong_ho_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nong_ho
    ADD CONSTRAINT nong_ho_pkey PRIMARY KEY (maho);


--
-- TOC entry 4854 (class 2606 OID 16873)
-- Name: phat_hien_sau phat_hien_sau_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phat_hien_sau
    ADD CONSTRAINT phat_hien_sau_pkey PRIMARY KEY (mabaocao);


--
-- TOC entry 4828 (class 2606 OID 16758)
-- Name: quan_ly_nguoi_dung quan_ly_nguoi_dung_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.quan_ly_nguoi_dung
    ADD CONSTRAINT quan_ly_nguoi_dung_email_key UNIQUE (email);


--
-- TOC entry 4830 (class 2606 OID 16756)
-- Name: quan_ly_nguoi_dung quan_ly_nguoi_dung_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.quan_ly_nguoi_dung
    ADD CONSTRAINT quan_ly_nguoi_dung_pkey PRIMARY KEY (manguoidung);


--
-- TOC entry 4852 (class 2606 OID 16863)
-- Name: sau_benh sau_benh_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sau_benh
    ADD CONSTRAINT sau_benh_pkey PRIMARY KEY (masau);


--
-- TOC entry 4864 (class 2606 OID 16945)
-- Name: thoi_tiet thoi_tiet_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.thoi_tiet
    ADD CONSTRAINT thoi_tiet_pkey PRIMARY KEY (mathoitiet);


--
-- TOC entry 4862 (class 2606 OID 16927)
-- Name: thu_hoach thu_hoach_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.thu_hoach
    ADD CONSTRAINT thu_hoach_pkey PRIMARY KEY (mathuhoach);


--
-- TOC entry 4842 (class 2606 OID 16808)
-- Name: thua_dat thua_dat_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.thua_dat
    ADD CONSTRAINT thua_dat_pkey PRIMARY KEY (mathua);


--
-- TOC entry 4856 (class 2606 OID 16875)
-- Name: phat_hien_sau unq_phat_hien_sau; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phat_hien_sau
    ADD CONSTRAINT unq_phat_hien_sau UNIQUE (masau, mathua, mavu);


--
-- TOC entry 4850 (class 2606 OID 16839)
-- Name: giong_trong uq_giong_trong; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.giong_trong
    ADD CONSTRAINT uq_giong_trong UNIQUE (mavu, mathua, magiong);


--
-- TOC entry 4860 (class 2606 OID 16902)
-- Name: nhat_ky_canh_tac uq_nkct; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhat_ky_canh_tac
    ADD CONSTRAINT uq_nkct UNIQUE (thoigian, mathua, mavu);


--
-- TOC entry 4844 (class 2606 OID 16820)
-- Name: vu_mua vu_mua_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vu_mua
    ADD CONSTRAINT vu_mua_pkey PRIMARY KEY (mavu);


--
-- TOC entry 4840 (class 2606 OID 16801)
-- Name: vung_trong vung_trong_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.vung_trong
    ADD CONSTRAINT vung_trong_pkey PRIMARY KEY (mavung);


--
-- TOC entry 4867 (class 2606 OID 16770)
-- Name: canbo_kt fk_canbo_kt_manguoidung; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.canbo_kt
    ADD CONSTRAINT fk_canbo_kt_manguoidung FOREIGN KEY (manguoidung) REFERENCES public.quan_ly_nguoi_dung(manguoidung) ON DELETE CASCADE;


--
-- TOC entry 4868 (class 2606 OID 16787)
-- Name: nong_ho fk_nongho_manguoidung; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nong_ho
    ADD CONSTRAINT fk_nongho_manguoidung FOREIGN KEY (manguoidung) REFERENCES public.quan_ly_nguoi_dung(manguoidung) ON DELETE CASCADE;


--
-- TOC entry 4870 (class 2606 OID 16840)
-- Name: giong_trong giong_trong_magiong_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.giong_trong
    ADD CONSTRAINT giong_trong_magiong_fkey FOREIGN KEY (magiong) REFERENCES public.giong_cam(magiong) ON DELETE CASCADE;


--
-- TOC entry 4871 (class 2606 OID 16850)
-- Name: giong_trong giong_trong_mathua_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.giong_trong
    ADD CONSTRAINT giong_trong_mathua_fkey FOREIGN KEY (mathua) REFERENCES public.thua_dat(mathua) ON DELETE CASCADE;


--
-- TOC entry 4872 (class 2606 OID 16845)
-- Name: giong_trong giong_trong_mavu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.giong_trong
    ADD CONSTRAINT giong_trong_mavu_fkey FOREIGN KEY (mavu) REFERENCES public.vu_mua(mavu) ON DELETE CASCADE;


--
-- TOC entry 4882 (class 2606 OID 16961)
-- Name: ho_tro_ky_thuat ho_tro_ky_thuat_macanbo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ho_tro_ky_thuat
    ADD CONSTRAINT ho_tro_ky_thuat_macanbo_fkey FOREIGN KEY (macanbo) REFERENCES public.canbo_kt(macanbo) ON DELETE CASCADE;


--
-- TOC entry 4883 (class 2606 OID 16966)
-- Name: ho_tro_ky_thuat ho_tro_ky_thuat_maho_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ho_tro_ky_thuat
    ADD CONSTRAINT ho_tro_ky_thuat_maho_fkey FOREIGN KEY (maho) REFERENCES public.nong_ho(maho) ON DELETE CASCADE;


--
-- TOC entry 4884 (class 2606 OID 16971)
-- Name: ho_tro_ky_thuat ho_tro_ky_thuat_mavung_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ho_tro_ky_thuat
    ADD CONSTRAINT ho_tro_ky_thuat_mavung_fkey FOREIGN KEY (mavung) REFERENCES public.vung_trong(mavung) ON DELETE CASCADE;


--
-- TOC entry 4876 (class 2606 OID 16913)
-- Name: nhat_ky_canh_tac nhat_ky_canh_tac_manguoinhap_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhat_ky_canh_tac
    ADD CONSTRAINT nhat_ky_canh_tac_manguoinhap_fkey FOREIGN KEY (manguoinhap) REFERENCES public.quan_ly_nguoi_dung(manguoidung) ON DELETE CASCADE;


--
-- TOC entry 4877 (class 2606 OID 16903)
-- Name: nhat_ky_canh_tac nhat_ky_canh_tac_mathua_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhat_ky_canh_tac
    ADD CONSTRAINT nhat_ky_canh_tac_mathua_fkey FOREIGN KEY (mathua) REFERENCES public.thua_dat(mathua) ON DELETE CASCADE;


--
-- TOC entry 4878 (class 2606 OID 16908)
-- Name: nhat_ky_canh_tac nhat_ky_canh_tac_mavu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nhat_ky_canh_tac
    ADD CONSTRAINT nhat_ky_canh_tac_mavu_fkey FOREIGN KEY (mavu) REFERENCES public.vu_mua(mavu) ON DELETE CASCADE;


--
-- TOC entry 4873 (class 2606 OID 16876)
-- Name: phat_hien_sau phat_hien_sau_masau_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phat_hien_sau
    ADD CONSTRAINT phat_hien_sau_masau_fkey FOREIGN KEY (masau) REFERENCES public.sau_benh(masau) ON DELETE CASCADE;


--
-- TOC entry 4874 (class 2606 OID 16881)
-- Name: phat_hien_sau phat_hien_sau_mathua_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phat_hien_sau
    ADD CONSTRAINT phat_hien_sau_mathua_fkey FOREIGN KEY (mathua) REFERENCES public.thua_dat(mathua) ON DELETE CASCADE;


--
-- TOC entry 4875 (class 2606 OID 16886)
-- Name: phat_hien_sau phat_hien_sau_mavu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.phat_hien_sau
    ADD CONSTRAINT phat_hien_sau_mavu_fkey FOREIGN KEY (mavu) REFERENCES public.vu_mua(mavu) ON DELETE CASCADE;


--
-- TOC entry 4881 (class 2606 OID 16946)
-- Name: thoi_tiet thoi_tiet_mavung_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.thoi_tiet
    ADD CONSTRAINT thoi_tiet_mavung_fkey FOREIGN KEY (mavung) REFERENCES public.vung_trong(mavung) ON DELETE CASCADE;


--
-- TOC entry 4879 (class 2606 OID 16928)
-- Name: thu_hoach thu_hoach_mathua_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.thu_hoach
    ADD CONSTRAINT thu_hoach_mathua_fkey FOREIGN KEY (mathua) REFERENCES public.thua_dat(mathua) ON DELETE CASCADE;


--
-- TOC entry 4880 (class 2606 OID 16933)
-- Name: thu_hoach thu_hoach_mavu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.thu_hoach
    ADD CONSTRAINT thu_hoach_mavu_fkey FOREIGN KEY (mavu) REFERENCES public.vu_mua(mavu) ON DELETE CASCADE;


--
-- TOC entry 4869 (class 2606 OID 16809)
-- Name: thua_dat thua_dat_ibfk_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.thua_dat
    ADD CONSTRAINT thua_dat_ibfk_1 FOREIGN KEY (maho) REFERENCES public.nong_ho(maho) ON DELETE CASCADE;


-- Completed on 2026-01-16 00:22:45

--
-- PostgreSQL database dump complete
--

\unrestrict Xw7sFAhTbPOeJY5xvXttpbMT263YCJqYOqzbh9at5dXmz0fc2RfSX73JFXQNYPc

