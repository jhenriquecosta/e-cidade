------------------------------------------
----------- INICIO TIME FOLHA ------------
------------------------------------------
--Alterando tabela rhpreponto para poder relacionar, criando campo, sequencia e chave prim?ria

--Sequencia para a tabela rhpreponto
create sequence rhpreponto_rh149_sequencial_seq
increment 1
minvalue 1
maxvalue 9223372036854775807
start 1
cache 1;

--Criando tabela tempor?ria para armazenar os dados de rhpreponto
create temp table w_rhpreponto AS
  select * from rhpreponto;

--Excluindo tabela rhpreponto para recri?-la
drop table rhpreponto;

--Recriando tabela preponto com sequencial
CREATE TABLE rhpreponto(
    rh149_sequencial    int4 NOT NULL default nextval('rhpreponto_rh149_sequencial_seq'),
    rh149_instit        int4 NOT NULL default 0,
    rh149_regist        int4 NOT NULL default 0,
    rh149_rubric        varchar(20) NOT NULL ,
    rh149_valor         float8 NOT NULL default 0,
    rh149_quantidade    int4 NOT NULL default 0,
    rh149_tipofolha     int4 NOT NULL default 0,
    rh149_competencia   varchar(7)
);

--Adicionada chave prim?ria ? tabela
ALTER TABLE rhpreponto
  ADD CONSTRAINT rh149_sequencial_pk PRIMARY KEY (rh149_sequencial);

--Adicionando chaves estrangeiras ? tabela
ALTER TABLE rhpreponto
  ADD CONSTRAINT rhpreponto_instit_fk FOREIGN KEY (rh149_instit)
  REFERENCES db_config;
ALTER TABLE rhpreponto
  ADD CONSTRAINT rhpreponto_tipofolha_fk FOREIGN KEY (rh149_tipofolha)
  REFERENCES rhtipofolha;
ALTER TABLE rhpreponto
  ADD CONSTRAINT rhpreponto_regist_fk FOREIGN KEY (rh149_regist)
  REFERENCES rhpessoal;

--Recolocando dados da tabela tempor?ria para a tabela rhpreponto
INSERT INTO rhpreponto
     SELECT (nextval('rhpreponto_rh149_sequencial_seq')),
             rh149_instit,
             rh149_regist,
             rh149_rubric,
             rh149_valor,
             rh149_quantidade,
             rh149_tipofolha,
             null
       FROM w_rhpreponto;

--Excluindo tabela tempor?ria que armazenou dados de rhpreponto
DROP TABLE IF EXISTS w_rhpreponto;

--Sequencia para tabela de lotes de registros do ponto
create sequence loteregistroponto_rh155_sequencial_seq
increment 1
minvalue 1
maxvalue 9223372036854775807
start 1
cache 1;
--Sequencia para tabela relacional entre rhpreponto e loteregistroponto
create sequence rhprepontoloteregistroponto_rh156_sequencial_seq
increment 1
minvalue 1
maxvalue 9223372036854775807
start 1
cache 1;

--Tabela de lotes de registro do ponto
create table loteregistroponto(
    rh155_sequencial    int4 not null default nextval('loteregistroponto_rh155_sequencial_seq'),
    rh155_descricao     varchar(255) not null,
    rh155_ano           int4 not null,
    rh155_mes           int4 not null,
    rh155_situacao      char(1) default 'A',
    rh155_instit        int4 default 0,
    rh155_usuario       int4 not null,
  constraint loteregistroponto_pk primary key (rh155_sequencial)
);
--Tabela relacional entre rhpreponto e loteregistroponto
create table rhprepontoloteregistroponto(
    rh156_sequencial           int4 not null default nextval('rhprepontoloteregistroponto_rh156_sequencial_seq'),
    rh156_rhpreponto           int4 not null,
    rh156_loteregistroponto    int4 not null,
  constraint rhprepontoloteregistroponto_pk primary key (rh156_sequencial)
);

--Chaves estrangeiras da tabela relacional entre rhpreponto e loteregistroponto
alter table rhprepontoloteregistroponto
  add constraint rh156_rhpreponto_fk foreign key (rh156_rhpreponto) references rhpreponto;
alter table rhprepontoloteregistroponto
  add constraint rh156_loteregistroponto_fk foreign key (rh156_loteregistroponto) references loteregistroponto;
alter table loteregistroponto
  ADD CONSTRAINT loteregistroponto_instituicao_fk FOREIGN KEY (rh155_instit) references db_config;
alter table loteregistroponto
  ADD CONSTRAINT loteregistroponto_usuario_fk FOREIGN KEY (rh155_usuario) references db_usuarios;

--Indice para tabela de lotes de registro do ponto
create index loteregistroponto_sequencial_in on loteregistroponto(rh155_sequencial);
--Indice para tabela relacional entre rhpreponto e loteregistroponto
create index rhprepontoloteregistroponto_sequencial_in on rhprepontoloteregistroponto(rh156_sequencial);

--Sequencial a ser utilizado no campo chave da tabela relacional que vincula um usu?rio a uma ou mais lota??es e vice-versa
create sequence db_usuariosrhlota_rh157_sequencial_seq
increment 1
minvalue 1
maxvalue 9223372036854775807
start 1
cache 1;

--Tabela relacional para vincular um usu?rio a uma ou mais lota??es e vice-versa
create table db_usuariosrhlota(
    rh157_sequencial        int4 not null default nextval('db_usuariosrhlota_rh157_sequencial_seq'),
    rh157_usuario           int4 not null,
    rh157_lotacao           int4 not null,
  constraint db_usuariosrhlota_pk primary key (rh157_sequencial)
);

--Cria indice ?nico para os campos de usu?rio e lota??o na tabela relacional que vincula um usu?rio a uma ou mais lota??es e vice-versa
create unique index db_usuariosrhlota_usuario_lotacao_in on db_usuariosrhlota(rh157_usuario, rh157_lotacao);

--Chaves estrangeiras da tabela relacional entre db_usuarios e rhlota
alter table db_usuariosrhlota
  add constraint rh157_usuario_fk foreign key (rh157_usuario) references configuracoes.db_usuarios;
alter table db_usuariosrhlota
  add constraint rh157_lotacao_fk foreign key (rh157_lotacao) references pessoal.rhlota;

------------------------------------------
------------- FIM TIME FOLHA -------------
------------------------------------------


------------------------------------------------------------------------------------
------------------------------ FIM TIME C ------------------------------------------
------------------------------------------------------------------------------------

CREATE SEQUENCE censoetapamediacaodidaticopedagogica_ed131_codigo_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE censoetapaturmacenso_ed134_codigo_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE mediacaodidaticopedagogica_ed130_codigo_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE seriecensoetapa_ed133_codigo_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE turmacensoetapa_ed132_codigo_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE censoetapamediacaodidaticopedagogica(
ed131_codigo  int4 NOT NULL  default nextval('censoetapamediacaodidaticopedagogica_ed131_codigo_seq'),
ed131_mediacaodidaticopedagogica  int4 NOT NULL ,
ed131_censoetapa  int4 NOT NULL ,
ed131_ano  int4 ,
ed131_regular      char(1) NOT NULL default 'N',
ed131_especial     char(1) NOT NULL default 'N',
ed131_eja          char(1) NOT NULL default 'N',
ed131_profissional char(1) NOT NULL default 'N',
CONSTRAINT censoetapamediacaodidaticopedagogica_codi_pk PRIMARY KEY (ed131_codigo));

CREATE TABLE censoetapaturmacenso(
ed134_codigo  int4 NOT NULL  default nextval('censoetapaturmacenso_ed134_codigo_seq'),
ed134_turmacenso  int4 NOT NULL ,
ed134_censoetapa  int4 NOT NULL ,
ed134_ano  int4 ,
CONSTRAINT censoetapaturmacenso_codi_pk PRIMARY KEY (ed134_codigo));

CREATE TABLE mediacaodidaticopedagogica(
ed130_codigo  int4 NOT NULL  default nextval('mediacaodidaticopedagogica_ed130_codigo_seq'),
ed130_descricao  varchar(25) ,
CONSTRAINT mediacaodidaticopedagogica_codi_pk PRIMARY KEY (ed130_codigo));

CREATE TABLE seriecensoetapa(
ed133_codigo  int4 NOT NULL  default nextval('seriecensoetapa_ed133_codigo_seq'),
ed133_serie  int4 NOT NULL ,
ed133_censoetapa  int4 NOT NULL ,
ed133_ano  int4 ,
CONSTRAINT seriecensoetapa_codi_pk PRIMARY KEY (ed133_codigo));

CREATE TABLE turmacensoetapa(
ed132_codigo  int4 NOT NULL  default nextval('turmacensoetapa_ed132_codigo_seq'),
ed132_turma  int4 NOT NULL ,
ed132_censoetapa  int4 NOT NULL ,
ed132_ano  int4 ,
CONSTRAINT turmacensoetapa_codi_pk PRIMARY KEY (ed132_codigo));


CREATE INDEX censoetapamediacaodidaticopedagogica_censoetapa_in ON censoetapamediacaodidaticopedagogica(ed131_censoetapa);
CREATE INDEX censoetapamediacaodidaticopedagogica_mediacaodidaticopedagogica_in ON censoetapamediacaodidaticopedagogica(ed131_mediacaodidaticopedagogica);
CREATE INDEX censoetapaturmacenso_censoetapa_in ON censoetapaturmacenso(ed134_censoetapa);
CREATE INDEX censoetapaturmacenso_turmacenso_in ON censoetapaturmacenso(ed134_turmacenso);
CREATE INDEX seriecensoetapa_censoetapa_in ON seriecensoetapa(ed133_censoetapa);
CREATE INDEX seriecensoetapa_serie_in ON seriecensoetapa(ed133_serie);
CREATE INDEX turmacensoetapa_censoetapa_in ON turmacensoetapa(ed132_censoetapa);
CREATE INDEX turmacensoetapa_turma_in ON turmacensoetapa(ed132_turma);



update tipoensino
   set ed36_c_descr = 'EDUCA??O PROFISSIONAL',
       ed36_c_abrev = 'EP'
 where ed36_i_codigo = 4
   and exists (select 1 from tipoensino where ed36_i_codigo = 4);

insert into tipoensino (ed36_i_codigo, ed36_c_descr, ed36_c_abrev)
     select 4, 'EDUCA??O PROFISSIONAL', 'EP'
      where not exists (select 1 from tipoensino where ed36_i_codigo = 4);


insert into mediacaodidaticopedagogica
     values (1, 'Presencial'),
            (2, 'Semipresencial'),
            (3, 'Educa??o a Dist?ncia');

select setval('censoetapamediacaodidaticopedagogica_ed131_codigo_seq', 3);

-- remove todas constraint de censoetapa
alter table censoregradisc drop constraint if exists censoregradisc_censoetapa_fk;
alter table serie          drop constraint if exists serie_censoetapa_fk;
alter table turma          drop constraint if exists turma_censoetapa_fk;
alter table turmacenso     drop constraint if exists turmacenso_censoetapa_fk;
alter table censoetapa     drop constraint if exists censoetapa_pkey;

alter table censoetapa add column ed266_ano int4 default 0;
alter table censoetapa alter column ed266_c_descr type varchar(200);

alter table censoregradisc add column ed272_ano int4 default 0;
update censoregradisc set ed272_ano = 2014;
update censoetapa set ed266_ano = 2014;

alter table ensino add column ed10_mediacaodidaticopedagogica int4 not null default 1;
alter table ensino add constraint ensino_mediacaodidaticopedagogica_fk foreign key (ed10_mediacaodidaticopedagogica) references mediacaodidaticopedagogica;

alter table serie          alter column ed11_i_codcenso   drop not null;
alter table turma          alter column ed57_i_censoetapa drop not null;
alter table turmacenso     alter column ed342_censoetapa  drop not null;
alter table serie          alter column ed11_i_codcenso   set default null;
alter table turma          alter column ed57_i_censoetapa set default null;
alter table turmacenso     alter column ed342_censoetapa  set default null;

insert into turmacensoetapa ( ed132_codigo, ed132_turma,  ed132_censoetapa, ed132_ano )
select nextval('turmacensoetapa_ed132_codigo_seq'), ed57_i_codigo , ed57_i_censoetapa, 2014
  from turma
 inner join calendario on ed52_i_codigo =  ed57_i_calendario
 where ed52_i_ano < 2015;

insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional)
select nextval('censoetapamediacaodidaticopedagogica_ed131_codigo_seq'), 1, ed266_i_codigo, ed266_ano, ed266_c_regular, ed266_c_especial, ed266_c_eja, 'N' from censoetapa;

insert into censoetapaturmacenso (ed134_codigo, ed134_turmacenso, ed134_censoetapa, ed134_ano)
select nextval('censoetapaturmacenso_ed134_codigo_seq'), ed342_sequencial, ed342_censoetapa, 2014 from turmacenso;

insert into seriecensoetapa (ed133_codigo, ed133_serie, ed133_censoetapa, ed133_ano)
select nextval('seriecensoetapa_ed133_codigo_seq'), ed11_i_codigo, ed11_i_codcenso, 2014 from serie;

-- retorna as constraint
alter table censoetapa add constraint  censoetapa_codi_ano_pk primary key (ed266_i_codigo,ed266_ano);

alter table censoetapamediacaodidaticopedagogica add constraint censoetapamediacaodidaticopedagogica_mediacaodidaticopedagogica_fk foreign key (ed131_mediacaodidaticopedagogica) references mediacaodidaticopedagogica;
alter table censoetapaturmacenso add constraint censoetapaturmacenso_turmacenso_fk foreign key (ed134_turmacenso) references turmacenso;
alter table seriecensoetapa add constraint seriecensoetapa_serie_fk foreign key (ed133_serie) references serie;
alter table turmacensoetapa add constraint turmacensoetapa_turma_fk foreign key (ed132_turma) references turma;

alter table censoetapamediacaodidaticopedagogica add constraint censoetapamediacaodidaticopedagogica_censoetapa_ano_fk foreign key (ed131_censoetapa,ed131_ano) references censoetapa;
alter table censoetapaturmacenso add constraint censoetapaturmacenso_censoetapa_ano_fk foreign key (ed134_censoetapa,ed134_ano) references censoetapa;
alter table seriecensoetapa add constraint seriecensoetapa_censoetapa_ano_fk foreign key (ed133_censoetapa,ed133_ano) references censoetapa;
alter table turmacensoetapa add constraint turmacensoetapa_censoetapa_ano_fk foreign key (ed132_censoetapa,ed132_ano) references censoetapa;
alter table censoregradisc add constraint censoregradisc_censoetapa_ano_fk foreign key (ed272_i_censoetapa,ed272_ano) references censoetapa;

update censoetapa set ed266_c_regular = null, ed266_c_especial = null, ed266_c_eja = null;

-- Tabela de Dependencias Existentes na Escola
update avaliacaoperguntaopcao set db104_descricao = 'Banheiro adequado a alunos com defici?ncia ou mobilidade reduzida'
  where db104_sequencial = 3000015;

update avaliacaoperguntaopcao set db104_descricao = 'Banheiro adequado ? educa??o infantil'
  where db104_sequencial = 3000014;

update avaliacaoperguntaopcao set db104_descricao = 'Banheiro dentro do pr?dio'
  where db104_sequencial = 3000013;

update avaliacaoperguntaopcao set db104_descricao = 'Banheiro fora do pr?dio'
  where db104_sequencial = 3000012;

update avaliacaoperguntaopcao set db104_descricao = 'Depend?ncias e vias adequadas a alunos com defici?ncia ou mobilidade reduzida'
  where db104_sequencial = 3000126;

update avaliacaoperguntaopcao set db104_descricao = 'Laborat?rio de ci?ncias'
  where db104_sequencial = 3000003;

update avaliacaoperguntaopcao set db104_descricao = 'Laborat?rio de inform?tica'
  where db104_sequencial = 3000002;

update avaliacaoperguntaopcao set db104_descricao = 'Parque infantil'
  where db104_sequencial = 3000010;

update avaliacaoperguntaopcao set db104_descricao = 'P?tio coberto'
  where db104_sequencial = 3000023;

update avaliacaoperguntaopcao set db104_descricao = 'P?tio descoberto'
  where db104_sequencial = 3000024;

update avaliacaoperguntaopcao set db104_descricao = 'Quadra de esportes coberta'
  where db104_sequencial = 3000005;

update avaliacaoperguntaopcao set db104_descricao = 'Quadra de esportes descoberta'
  where db104_sequencial = 3000006;

update avaliacaoperguntaopcao set db104_descricao = 'Sala de diretoria'
  where db104_sequencial = 3000000;

update avaliacaoperguntaopcao set db104_descricao = 'Sala de leitura'
  where db104_sequencial = 3000009;

update avaliacaoperguntaopcao set db104_descricao = 'Sala de professores'
  where db104_sequencial = 3000001;

update avaliacaoperguntaopcao set db104_descricao = 'Sala de recursos multifuncionais para Atendimento Educacional Especializado (AEE)'
  where db104_sequencial = 3000004;

update avaliacaoperguntaopcao set db104_descricao = 'Sala de secretaria'
  where db104_sequencial = 3000017;

update avaliacaoperguntaopcao set db104_descricao = 'Nenhuma das depend?ncias relacionadas'
  where db104_sequencial = 3000016;

-- atualiza??o na descri??o dos cursos profissionais do censo
update censocursoprofiss set ed247_c_descr = 'BIBLIOTECONOMIA' where ed247_i_codigo = 2030;
update censocursoprofiss set ed247_c_descr = 'TREINAMENTO E INSTRU??O DE C?ES-GUIA' where ed247_i_codigo = 2038;
update censocursoprofiss set ed247_c_descr = 'MANUTEN??O DE M?QUINAS NAVAIS' where ed247_i_codigo = 3042;
update censocursoprofiss set ed247_c_descr = 'MANUTEN??O DE SISTEMAS METROFERROVI?RIOS' where ed247_i_codigo = 3054;
update censocursoprofiss set ed247_c_descr = 'CONDOM?NIO' where ed247_i_codigo = 4062;
update censocursoprofiss set ed247_c_descr = 'RESTAURANTE E BAR' where ed247_i_codigo = 5072;
update censocursoprofiss set ed247_c_descr = 'ARTES CIRCENSES' where ed247_i_codigo = 10128;
update censocursoprofiss set ed247_c_descr = 'TEATRO' where ed247_i_codigo = 10129;

-- inclus?o de novos registros referentes aos cursos profissionais do censo
insert into censocursoprofiss values( 2039, 'LABORAT?RIO DE CI?NCIAS DA NATUREZA', 2 );
insert into censocursoprofiss values( 3060, 'MANUTEN??O DE M?QUINAS INDUSTRIAIS', 3 );
insert into censocursoprofiss values( 6082, 'DESENVOLVIMENTO DE SISTEMAS', 6 );
insert into censocursoprofiss values( 8133, 'BOMBEIRO AERON?UTICO', 8 );
insert into censocursoprofiss values( 10157, 'FIGURINO C?NICO', 10 );
insert into censocursoprofiss values( 12186, 'GR?OS', 12 );
insert into censocursoprofiss values( 12187, 'P?S-COLHEITA', 12 );

-- atualiza??o do c?digo e tipo do curso profissionais do censo
update censocursoprofiss set ed247_i_codigo = 11173, ed247_i_tipo = 11 where ed247_i_codigo = 1003;
update censocursoprofiss set ed247_i_codigo = 11172, ed247_i_tipo = 11 where ed247_i_codigo = 3035;
update censocursoprofiss set ed247_i_codigo = 11174, ed247_i_tipo = 11 where ed247_i_codigo = 3046;
update censocursoprofiss set ed247_i_codigo = 11175, ed247_i_tipo = 11 where ed247_i_codigo = 3047;


-- dados da censoetapa
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (1, 'Educa??o Infantil - Creche (0 a 3 anos) ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (2, 'Educa??o Infantil - Pr?-escola (4 e 5 anos) ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (3, 'Educa??o Infantil - Unificada (0 a 5 anos) ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (4, 'Ensino Fundamental de 8 anos - 1? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (5, 'Ensino Fundamental de 8 anos - 2? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (6, 'Ensino Fundamental de 8 anos - 3? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (7, 'Ensino Fundamental de 8 anos - 4? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (8, 'Ensino Fundamental de 8 anos - 5? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (9, 'Ensino Fundamental de 8 anos - 6? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (10, 'Ensino Fundamental de 8 anos - 7? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (11, 'Ensino Fundamental de 8 anos - 8? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (12, 'Ensino Fundamental de 8 anos - Multi ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (13, 'Ensino Fundamental de 8 anos - Corre??o de Fluxo ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (14, 'Ensino Fundamental de 9 anos - 1? Ano ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (15, 'Ensino Fundamental de 9 anos - 2? Ano ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (16, 'Ensino Fundamental de 9 anos - 3? Ano ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (17, 'Ensino Fundamental de 9 anos - 4? Ano ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (18, 'Ensino Fundamental de 9 anos - 5? Ano ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (19, 'Ensino Fundamental de 9 anos - 6? Ano ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (20, 'Ensino Fundamental de 9 anos - 7? Ano ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (21, 'Ensino Fundamental de 9 anos - 8? Ano ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (22, 'Ensino Fundamental de 9 anos - Multi ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (23, 'Ensino Fundamental de 9 anos - Corre??o de Fluxo ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (24, 'Ensino Fundamental de 8 e 9 anos - Multi 8 e 9 anos ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (25, 'Ensino M?dio - 1? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (26, 'Ensino M?dio - 2? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (27, 'Ensino M?dio - 3? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (28, 'Ensino M?dio - 4? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (29, 'Ensino M?dio - N?o Seriada ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (30, 'Curso T?cnico Integrado (Ensino M?dio Integrado) 1? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (31, 'Curso T?cnico Integrado (Ensino M?dio Integrado) 2? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (32, 'Curso T?cnico Integrado (Ensino M?dio Integrado) 3? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (33, 'Curso T?cnico Integrado (Ensino M?dio Integrado) 4? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (34, 'Curso T?cnico Integrado (Ensino M?dio Integrado) N?o Seriada ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (35, 'Ensino M?dio - Normal/Magist?rio 1? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (36, 'Ensino M?dio - Normal/Magist?rio 2? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (37, 'Ensino M?dio - Normal/Magist?rio 3? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (38, 'Ensino M?dio - Normal/Magist?rio 4? S?rie ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (39, 'Curso T?cnico  - Concomitante ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (40, 'Curso T?cnico  - Subsequente ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (41, 'Ensino Fundamental de 9 anos - 9? Ano ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (69, 'EJA - Ensino Fundamental -  Anos iniciais ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (70, 'EJA - Ensino Fundamental -  Anos finais ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (71, 'EJA - Ensino M?dio ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (72, 'EJA - Ensino Fundamental  - Anos iniciais e Anos finais ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (56, 'Educa??o Infantil e Ensino Fundamental (8 e 9 anos) Multietapa ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (73, 'Curso FIC integrado na modalidade EJA - N?vel Fundamental (EJA integrada ? Educa??o Profissional de N?vel Fundamental) ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (74, 'Curso T?cnico Integrado na Modalidade EJA (EJA integrada ? Educa??o Profissional de N?vel M?dio) ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (64, 'Curso T?cnico Misto ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (65, 'EJA - Ensino Fundamental - Projovem Urbano ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (67, 'Curso FIC integrado na modalidade EJA  - N?vel M?dio ', 2015 );
insert into censoetapa (ed266_i_codigo, ed266_c_descr, ed266_ano) values (68, 'Curso FIC Concomitante ', 2015 );

-- vincula a etapa do censo a sua mediacao pedagogica e a modalidade de ensino
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (62, 1, 1, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (63, 1, 2, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (64, 1, 3, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (65, 1, 4, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (66, 1, 5, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (67, 1, 6, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (68, 1, 7, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (69, 1, 8, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (70, 1, 9, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (71, 1, 10, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (72, 1, 11, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (73, 1, 12, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (74, 1, 13, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (75, 1, 14, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (76, 1, 15, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (77, 1, 16, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (78, 1, 17, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (79, 1, 18, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (80, 1, 19, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (81, 1, 20, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (82, 1, 21, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (83, 1, 22, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (84, 1, 23, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (85, 1, 24, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (86, 1, 25, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (87, 1, 26, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (88, 1, 27, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (89, 1, 28, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (90, 1, 29, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (91, 1, 30, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (92, 1, 31, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (93, 1, 32, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (94, 1, 33, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (95, 1, 34, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (96, 1, 35, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (97, 1, 36, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (98, 1, 37, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (99, 1, 38, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (100, 1, 39, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (101, 1, 40, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (102, 1, 41, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (103, 1, 69, 2015, 'N', 'S', 'S', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (104, 1, 70, 2015, 'N', 'S', 'S', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (105, 1, 71, 2015, 'N', 'S', 'S', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (106, 1, 72, 2015, 'N', 'S', 'S', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (107, 1, 56, 2015, 'S', 'S', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (108, 1, 73, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (109, 1, 74, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (110, 1, 64, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (111, 1, 65, 2015, 'N', 'N', 'S', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (112, 1, 67, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (113, 1, 68, 2015, 'N', 'S', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (114, 2, 1, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (115, 2, 2, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (116, 2, 3, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (117, 2, 4, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (118, 2, 5, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (119, 2, 6, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (120, 2, 7, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (121, 2, 8, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (122, 2, 9, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (123, 2, 10, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (124, 2, 11, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (125, 2, 12, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (126, 2, 13, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (127, 2, 14, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (128, 2, 15, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (129, 2, 16, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (130, 2, 17, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (131, 2, 18, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (132, 2, 19, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (133, 2, 20, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (134, 2, 21, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (135, 2, 22, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (136, 2, 23, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (137, 2, 24, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (138, 2, 25, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (139, 2, 26, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (140, 2, 27, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (141, 2, 28, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (142, 2, 29, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (143, 2, 30, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (144, 2, 31, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (145, 2, 32, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (146, 2, 33, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (147, 2, 34, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (148, 2, 35, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (149, 2, 36, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (150, 2, 37, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (151, 2, 38, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (152, 2, 39, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (153, 2, 40, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (154, 2, 41, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (155, 2, 69, 2015, 'N', 'S', 'S', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (156, 2, 70, 2015, 'N', 'S', 'S', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (157, 2, 71, 2015, 'N', 'S', 'S', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (158, 2, 72, 2015, 'N', 'S', 'S', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (159, 2, 56, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (160, 2, 73, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (161, 2, 74, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (162, 2, 64, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (163, 2, 65, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (164, 2, 67, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (165, 2, 68, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (166, 3, 1, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (167, 3, 2, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (168, 3, 3, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (169, 3, 4, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (170, 3, 5, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (171, 3, 6, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (172, 3, 7, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (173, 3, 8, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (174, 3, 9, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (175, 3, 10, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (176, 3, 11, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (177, 3, 12, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (178, 3, 13, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (179, 3, 14, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (180, 3, 15, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (181, 3, 16, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (182, 3, 17, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (183, 3, 18, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (184, 3, 19, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (185, 3, 20, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (186, 3, 21, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (187, 3, 22, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (188, 3, 23, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (189, 3, 24, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (190, 3, 25, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (191, 3, 26, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (192, 3, 27, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (193, 3, 28, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (194, 3, 29, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (195, 3, 30, 2015, 'N', 'N', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (196, 3, 31, 2015, 'N', 'N', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (197, 3, 32, 2015, 'N', 'N', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (198, 3, 33, 2015, 'N', 'N', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (199, 3, 34, 2015, 'N', 'N', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (200, 3, 35, 2015, 'S', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (201, 3, 36, 2015, 'S', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (202, 3, 37, 2015, 'S', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (203, 3, 38, 2015, 'S', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (204, 3, 39, 2015, 'N', 'N', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (205, 3, 40, 2015, 'N', 'N', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (206, 3, 41, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (207, 3, 69, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (208, 3, 70, 2015, 'N', 'N', 'S', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (209, 3, 71, 2015, 'N', 'N', 'S', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (210, 3, 72, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (211, 3, 56, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (212, 3, 73, 2015, 'N', 'N', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (213, 3, 74, 2015, 'N', 'N', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (214, 3, 64, 2015, 'N', 'N', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (215, 3, 65, 2015, 'N', 'N', 'N', 'N');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (216, 3, 67, 2015, 'N', 'N', 'N', 'S');
insert into censoetapamediacaodidaticopedagogica (ed131_codigo, ed131_mediacaodidaticopedagogica, ed131_censoetapa, ed131_ano, ed131_regular, ed131_especial, ed131_eja, ed131_profissional) values (217, 3, 68, 2015, 'N', 'N', 'N', 'S');

select setval('censoetapamediacaodidaticopedagogica_ed131_codigo_seq', (select max(ed131_codigo) from censoetapamediacaodidaticopedagogica));
select setval('censoregradisc_ed272_i_codigo_seq', (select max(ed272_i_codigo) from censoregradisc));

-- ETAPAS 4 ,5 ,6 ,7 ,14 ,15 ,16 ,17 ,18
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'4','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'5','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'6','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'7','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'14','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'15','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'16','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'17','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'18','99','2015');
-- ETAPA 69
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'69','99','2015');
-- ETAPAS 8, 9, 10, 11, 19, 20, 21, 41
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'8','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'9','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'10','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'11','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'19','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'20','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'21','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'41','99','2015');
-- ETAPAS 13, 23, 12, 22, 24, 56
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'13','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'23','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'12','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'22','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'24','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'56','99','2015');
-- ETAPA 70
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'70','99','2015');
-- ETAPA 72
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'72','99','2015');
-- ETAPAS 73
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','17','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','28','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'73','99','2015');
-- ETAPAS 25, 26, 27, 28, 29
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'25','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'26','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'27','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'28','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'29','99','2015');
-- ETAPA 71
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'71','99','2015');
-- ETAPAS 30, 31, 32, 33, 34
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','17','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'30','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','17','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'31','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','17','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'32','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','17','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'33','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','17','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'34','99','2015');
-- ETAPAS 74, 67
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','17','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'74','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','17','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'67','99','2015');
-- ETAPAS 35, 36, 37, 38
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','20','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','21','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','25','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'35','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','20','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','21','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','25','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'36','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','20','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','21','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','25','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'37','99','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','1','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','2','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','3','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','4','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','5','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','6','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','7','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','8','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','9','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','10','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','11','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','12','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','13','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','14','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','16','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','20','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','21','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','23','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','25','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','26','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','27','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','29','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','30','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'38','99','2015');
-- ETAPAS 39, 40, 64, 68
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'39','17','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'40','17','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'64','17','2015');
insert into censoregradisc values (nextval('censoregradisc_ed272_i_codigo_seq'),'68','17','2015');

insert into censoativcompl
     values ( 15006,  15, upper('Etnojogos') ),
            ( 17003,  17, upper('Leitura e Produ??o Textual') ),
            ( 31015,  31, upper('Campos do conhecimento (Escola do Campo)') ),
            ( 13106, 131, upper('Horta escolar e/ou Comunit?ria') ),
            ( 13107, 131, upper('Jardinagem Escolar') ),
            ( 13108, 131, upper('Economia Solid?ria e Criativa/Educa??o Econ?mica (Educa??o Financeira e Fiscal)') ),
            ( 15101, 151, upper('Mem?ria e Hist?ria das Comunidades Tradicionais') ),
            ( 15999, 159, upper('Outra categoria de Mem?ria e Hist?ria das Comunidades Tradicionais') ),
            ( 16101, 161, upper('Conserva??o do solo e composteira') ),
            ( 16102, 161, upper('Canteiros Sustent?veis') ),
            ( 16103, 161, upper('Cuidados com Animais') ),
            ( 16104, 161, upper('COM-VIDA (Comiss?o de Meio Ambiente e Qualidade de Vida)') ),
            ( 16105, 161, upper('Uso Eficiente de ?gua e Energia') ),
            ( 16999, 169, upper('Outra Categoria de Agroecologia (Escolas do Campo)') );

update censoativcompl
   set ed133_c_descr = upper('Orienta??o de Estudos e Leitura (Escola urbana)')
 where ed133_i_codigo = 31014;
update censoativcompl
   set ed133_c_descr = upper('COM-VIDAS (organiza??o de coletivos pr?-meio ambiente)')
 where ed133_i_codigo = 13101;
update censoativcompl
   set ed133_c_descr = upper('Outra categoria de Educa??o Ambiental, Desenvolvimento Sustent?vel e Economia Solid?ria e Criativa/Educa??o Econ?mica (Educa??o Financeira e Fiscal)')
 where ed133_i_codigo = 13999;
update censoativcompl
   set ed133_c_descr = upper('Esporte da Escola/Atletismo e m?ltiplas viv?ncias esportivas')
 where ed133_i_codigo = 22017;

update turmaacativ
   set ed267_i_censoativcompl = 22017
  from turmaac, calendario
 where ed267_i_turmaac        = ed268_i_codigo
   and ed52_i_codigo          = ed268_i_calendario
   and ed52_i_ano             = 2015
   and ed267_i_censoativcompl = 91002;

update turmaacativ
   set ed267_i_censoativcompl = 39999
  from turmaac, calendario
 where ed267_i_turmaac         = ed268_i_codigo
   and ed52_i_codigo           = ed268_i_calendario
   and ed52_i_ano              = 2015
   and ed267_i_censoativcompl in( 31001, 31002, 31003, 31004, 31005, 31006, 31007, 31011, 31012, 31013 );

delete from turmaacativ
      using turmaac, calendario
      where ed267_i_turmaac         = ed268_i_codigo
        and ed52_i_codigo           = ed268_i_calendario
        and ed52_i_ano              = 2015
        and ed267_i_censoativcompl in( 91001, 99999 );


create table de_para_etapa_censo (de int, para int);
insert into de_para_etapa_censo (de, para)
     values ( 1, 1),
            ( 2, 2),
            ( 3, 3),
            ( 4, 4),
            ( 5, 5),
            ( 6, 6),
            ( 7, 7),
            ( 8, 8),
            ( 9, 9),
            (10, 10),
            (11, 11),
            (12, 12),
            (13, 13),
            (14, 14),
            (15, 15),
            (16, 16),
            (17, 17),
            (18, 18),
            (19, 19),
            (20, 20),
            (21, 21),
            (22, 22),
            (23, 23),
            (24, 24),
            (25, 25),
            (26, 26),
            (27, 27),
            (28, 28),
            (29, 29),
            (30, 30),
            (31, 31),
            (32, 32),
            (33, 33),
            (34, 34),
            (35, 35),
            (36, 36),
            (37, 37),
            (38, 38),
            (39, 39),
            (40, 40),
            (41, 41),
            (43, 69),
            (44, 70),
            (45, 71),
            (51, 72),
            (56, 56),
            (60, 73),
            (62, 74),
            (64, 64),
            (65, 65);

insert into seriecensoetapa (ed133_codigo, ed133_serie, ed133_censoetapa, ed133_ano)
select nextval('seriecensoetapa_ed133_codigo_seq'), ed133_serie, para, 2015
  from seriecensoetapa
 inner join de_para_etapa_censo on de = ed133_censoetapa ;

insert into turmacensoetapa (ed132_codigo, ed132_turma, ed132_censoetapa, ed132_ano)
select nextval('turmacensoetapa_ed132_codigo_seq'), ed57_i_codigo, para, 2015
  from turma
 inner join calendario          on ed52_i_codigo     = ed57_i_calendario
 inner join calendarioescola    on ed38_i_calendario = ed52_i_codigo
                               and ed38_i_escola     = ed57_i_escola
 inner join de_para_etapa_censo on de                = ed57_i_censoetapa
 where ed52_i_ano = 2015;

DROP TABLE IF EXISTS w_migracao_agendaatividade CASCADE;
DROP TABLE IF EXISTS w_migracao_rechumanohoradisp CASCADE;
DROP TABLE IF EXISTS w_migracao_relacaotrabalho CASCADE;
DROP TABLE IF EXISTS w_migracao_tipohoratrabalho CASCADE;
CREATE TABLE w_migracao_agendaatividade   AS SELECT ed129_codigo, ed129_tipohoratrabalho FROM agendaatividade;
CREATE TABLE w_migracao_rechumanohoradisp AS SELECT ed33_i_codigo, ed33_tipohoratrabalho FROM rechumanohoradisp;
CREATE TABLE w_migracao_relacaotrabalho   AS SELECT ed23_i_codigo, ed23_tipohoratrabalho FROM relacaotrabalho;
CREATE TABLE w_migracao_tipohoratrabalho  AS SELECT * FROM tipohoratrabalho;
update agendaatividade   set ed129_tipohoratrabalho = 1;
update rechumanohoradisp set ed33_tipohoratrabalho  = 1;
update relacaotrabalho   set ed23_tipohoratrabalho  = 1;
update tipohoratrabalho  set ed128_descricao        = 'NORMAL' where ed128_codigo = 1;
DELETE FROM    tipohoratrabalho where ed128_codigo not in (1);
ALTER TABLE    tipohoratrabalho drop column if exists ed128_escola;
ALTER SEQUENCE tipohoratrabalho_ed128_codigo_seq RESTART WITH 2;



alter table ambulatorial.cgs_und alter COLUMN z01_v_nome type  varchar(255);
alter table ambulatorial.cgs_und alter COLUMN z01_v_mae type   varchar(255);
alter table ambulatorial.cgs_und alter COLUMN z01_c_pis type   varchar(11);
alter table ambulatorial.cgs_und alter COLUMN z01_v_email type varchar(255);
alter table ambulatorial.sau_cgserrado alter COLUMN s128_v_nome type  varchar(255);

-- campo cnpj na unidade
alter table ambulatorial.unidades add sd02_cnpjcpf varchar(14) default null;


-- consulta tfd
alter table tfd_situacaopedidotfd DISABLE TRIGGER tg_atualizasituacaopedidotfd;
create table bkp_tfd_situacaopedidotfd as select tf28_i_codigo as codigo, tf28_i_situacao as situacao, tf28_c_obs as obs from tfd_situacaopedidotfd;
update tfd_situacaopedidotfd set tf28_i_situacao = 2         where tf28_i_situacao = 3;
update tfd_situacaopedidotfd set tf28_c_obs = 'PEDIDO ATIVO' where tf28_c_obs = 'PEDIDO EM ANDAMENTO.';
delete from tfd_situacaotfd where tf26_i_codigo = 3;
alter table tfd_situacaopedidotfd enable trigger tg_atualizasituacaopedidotfd;

alter table rechumanohoradisp add column ed33_horaatividade bool default false not null;
------------------------------------------------------------------------------------
------------------------------ FIM TIME C ------------------------------------------
------------------------------------------------------------------------------------


------------------------------------------------------------------------------------
------------------------------ TRIBUTARIO ------------------------------------------
------------------------------------------------------------------------------------

CREATE SEQUENCE issarquivoretencao_q90_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE issarquivoretencaoregistro_q91_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE issarquivoretencaoregistrodisbanco_q94_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE issarquivoretencaoregistroissbase_q128_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE issarquivoretencaoregistroissplan_q137_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE issarquivoretencao(
q90_sequencial    int4 NOT NULL default 0,
q90_instit    int4 NOT NULL default 0,
q90_data    date NOT NULL default null,
q90_numeroremessa   int4 NOT NULL default 0,
q90_versao    int4 NOT NULL default 0,
q90_quantidaderegistro    int4 NOT NULL default 0,
q90_valortotal    float8 NOT NULL default 0,
q90_codigobanco   int4 NOT NULL default 0,
q90_oidarquivo    oid NOT NULL ,
q90_nomearquivo   varchar(50) ,
CONSTRAINT issarquivoretencao_sequ_pk PRIMARY KEY (q90_sequencial));

CREATE TABLE issarquivoretencaoregistro(
q91_sequencial    int4 NOT NULL default 0,
q91_issarquivoretencao    int4 NOT NULL default 0,
q91_sequencialregistro    int4 NOT NULL default 0,
q91_dataemissaodocumento    date NOT NULL default null,
q91_datavencimento    date NOT NULL default null,
q91_numerodocumento   varchar(12) ,
q91_cnpjtomador   varchar(14) NOT NULL default '0',
q91_codigomunicipiotomador    int4 NOT NULL default 0,
q91_cpfcnpjprestador    varchar(14) NOT NULL default '0',
q91_codigomunicipionota   int4 NOT NULL default 0,
q91_esferareceita   varchar(1) NOT NULL ,
q91_anousu    int4 NOT NULL default 0,
q91_mesusu    int4 NOT NULL default 0,
q91_valorprincipal    float8 NOT NULL default 0,
q91_valormulta    float8 default 0,
q91_valorjuros    float8 default 0,
q91_numeronotafiscal    int4 NOT NULL default 0,
q91_serienotafiscal   varchar(5) NOT NULL ,
q91_subserienotafiscal    int4 default 0,
q91_dataemissaonotafiscal   date NOT NULL default null,
q91_valornotafiscal   float8 NOT NULL default 0,
q91_aliquota    float8 NOT NULL default 0,
q91_valorbasecalculo    float8 NOT NULL default 0,
q91_observacao    text NOT NULL ,
q91_codigomunicipiofavorecido   int4 default 0,
CONSTRAINT issarquivoretencaoregistro_sequ_pk PRIMARY KEY (q91_sequencial));

CREATE TABLE issarquivoretencaoregistrodisbanco(
q94_sequencial    int4 NOT NULL default 0,
q94_issarquivoretencaoregistro    int4 NOT NULL default 0,
q94_disbanco    int4 default 0,
CONSTRAINT issarquivoretencaoregistrodisbanco_sequ_pk PRIMARY KEY (q94_sequencial));

CREATE TABLE issarquivoretencaoregistroissbase(
q128_sequencial   int4 NOT NULL default 0,
q128_inscr    int4 NOT NULL default 0,
q128_issarquivoretencaoregistro   int4 default 0,
CONSTRAINT issarquivoretencaoregistroissbase_sequ_pk PRIMARY KEY (q128_sequencial));

CREATE TABLE issarquivoretencaoregistroissplan(
q137_sequencial   int4 NOT NULL default 0,
q137_issplan    int4 NOT NULL default 0,
q137_issarquivoretencaoregistro   int4 default 0,
CONSTRAINT issarquivoretencaoregistroissplan_sequ_pk PRIMARY KEY (q137_sequencial));

ALTER TABLE issarquivoretencaoregistro
ADD CONSTRAINT issarquivoretencaoregistro_issarquivoretencao_fk FOREIGN KEY (q91_issarquivoretencao)
REFERENCES issarquivoretencao;

ALTER TABLE issarquivoretencaoregistrodisbanco
ADD CONSTRAINT issarquivoretencaoregistrodisbanco_disbanco_fk FOREIGN KEY (q94_disbanco)
REFERENCES disbanco;

ALTER TABLE issarquivoretencaoregistrodisbanco
ADD CONSTRAINT issarquivoretencaoregistrodisbanco_issarquivoretencaoregistro_fk FOREIGN KEY (q94_issarquivoretencaoregistro)
REFERENCES issarquivoretencaoregistro;

ALTER TABLE issarquivoretencaoregistroissbase
ADD CONSTRAINT issarquivoretencaoregistroissbase_inscr_fk FOREIGN KEY (q128_inscr)
REFERENCES issbase;

ALTER TABLE issarquivoretencaoregistroissbase
ADD CONSTRAINT issarquivoretencaoregistroissbase_issarquivoretencaoregistro_fk FOREIGN KEY (q128_issarquivoretencaoregistro)
REFERENCES issarquivoretencaoregistro;

ALTER TABLE issarquivoretencaoregistroissplan
ADD CONSTRAINT issarquivoretencaoregistroissplan_issplan_fk FOREIGN KEY (q137_issplan)
REFERENCES issplan;

ALTER TABLE issarquivoretencaoregistroissplan
ADD CONSTRAINT issarquivoretencaoregistroissplan_issarquivoretencaoregistro_fk FOREIGN KEY (q137_issarquivoretencaoregistro)
REFERENCES issarquivoretencaoregistro;

CREATE UNIQUE INDEX issarquivoretencao_numeroremessa_in ON issarquivoretencao(q90_numeroremessa);
CREATE UNIQUE INDEX issarquivoreqtencaoregistro_issarquivoretencao_sequencialregistro_in ON issarquivoretencaoregistro(q91_issarquivoretencao, q91_sequencialregistro);
CREATE  INDEX issarquivoretencaoregistrodisbanco_disbanco_in ON issarquivoretencaoregistrodisbanco(q94_disbanco);
CREATE  INDEX issarquivoretencaoregistrodisbanco_issarquivoretencaoregistro_in ON issarquivoretencaoregistrodisbanco(q94_issarquivoretencaoregistro);
CREATE  INDEX issarquivoretencaoregistroissbase_issarquivoretencaoregistro_in ON issarquivoretencaoregistroissbase(q128_issarquivoretencaoregistro);
CREATE  INDEX issarquivoretencaoregistroissbase_inscr_in ON issarquivoretencaoregistroissbase(q128_inscr);
CREATE  INDEX issarquivoretencaoregistroissplan_issarquivoretencaoregistro_in ON issarquivoretencaoregistroissplan(q137_issarquivoretencaoregistro);
CREATE  INDEX issarquivoretencaoregistroissplan_issplan_in ON issarquivoretencaoregistroissplan(q137_issplan);

CREATE SEQUENCE issarquivoretencaodisarq_q145_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE issarquivoretencaodisarq(
q145_sequencial   int4 NOT NULL default 0,
q145_issarquivoretencao   int4 NOT NULL default 0,
q145_disarq   int4 default 0,
CONSTRAINT issarquivoretencaodisarq_sequ_pk PRIMARY KEY (q145_sequencial));

ALTER TABLE issarquivoretencaodisarq
ADD CONSTRAINT issarquivoretencaodisarq_disarq_fk FOREIGN KEY (q145_disarq)
REFERENCES disarq;

ALTER TABLE issarquivoretencaodisarq
ADD CONSTRAINT issarquivoretencaodisarq_issarquivoretencao_fk FOREIGN KEY (q145_issarquivoretencao)
REFERENCES issarquivoretencao;

CREATE UNIQUE INDEX issarquivoretencaodisarq_issarquivoretencao_disarq_in ON issarquivoretencaodisarq(q145_issarquivoretencao,q145_disarq);

CREATE SEQUENCE issarquivoretencaoregistroissvar_q146_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- M?dulo: issqn
CREATE TABLE issarquivoretencaoregistroissvar(
q146_sequencial   int4 NOT NULL default 0,
q146_issvar   int4 NOT NULL default 0,
q146_issarquivoretencaoregistro   int4 default 0,
CONSTRAINT issarquivoretencaoregistroissvar_sequ_pk PRIMARY KEY (q146_sequencial));

ALTER TABLE issarquivoretencaoregistroissvar
ADD CONSTRAINT issarquivoretencaoregistroissvar_issvar_fk FOREIGN KEY (q146_issvar)
REFERENCES issvar;

ALTER TABLE issarquivoretencaoregistroissvar
ADD CONSTRAINT issarquivoretencaoregistroissvar_issarquivoretencaoregistro_fk FOREIGN KEY (q146_issarquivoretencaoregistro)
REFERENCES issarquivoretencaoregistro;

CREATE  INDEX issarquivoretencaoregistroissvar_issarquivoretencaoregistro_in ON issarquivoretencaoregistroissvar(q146_issarquivoretencaoregistro);

CREATE  INDEX issarquivoretencaoregistroissvar_issvar_in ON issarquivoretencaoregistroissvar(q146_issvar);


/**
 * Meio ambiente
 */
alter table empreendimento add column am05_protprocesso int4 default 0;
alter table empreendimento add constraint empreendimento_protprocesso_fk foreign key (am05_protprocesso) REFERENCES protprocesso;

alter table criterioatividadeimpacto alter column am01_descricao type varchar(60);

truncate criterioatividadeimpacto cascade;

 insert into criterioatividadeimpacto values ( 1,  '?rea alagada em hectares (ha)' );
 insert into criterioatividadeimpacto values ( 2,  '?rea constru?da em m?' );
 insert into criterioatividadeimpacto values ( 3,  '?rea degradada em hectares (ha)' );
 insert into criterioatividadeimpacto values ( 4,  '?rea drenada em hectares (ha)' );
 insert into criterioatividadeimpacto values ( 5,  '?rea inundada em hectares (ha)' );
 insert into criterioatividadeimpacto values ( 6,  '?rea requerida ao DNPM em hectares (ha)' );
 insert into criterioatividadeimpacto values ( 7,  '?rea total em hectares (ha)' );
 insert into criterioatividadeimpacto values ( 8,  '?rea ?til em hectares' );
 insert into criterioatividadeimpacto values ( 9,  '?rea ?til em m?' );
 insert into criterioatividadeimpacto values ( 10, 'Capacidade de tancagem em m?' );
 insert into criterioatividadeimpacto values ( 11, 'Comprimento em km' );
 insert into criterioatividadeimpacto values ( 12, 'Comprimento em Km' );
 insert into criterioatividadeimpacto values ( 13, 'Comprimento em metro' );
 insert into criterioatividadeimpacto values ( 14, 'Hectares (ha)' );
 insert into criterioatividadeimpacto values ( 15, 'M? de p?tio de compostagem' );
 insert into criterioatividadeimpacto values ( 16, 'Metro c?bico (m?)' );
 insert into criterioatividadeimpacto values ( 17, 'Metro quadrado (m?)' );
 insert into criterioatividadeimpacto values ( 18, 'N? de cabe?as' );
 insert into criterioatividadeimpacto values ( 19, 'N? de familias' );
 insert into criterioatividadeimpacto values ( 20, 'N? de leitos' );
 insert into criterioatividadeimpacto values ( 21, 'N? de matrizes' );
 insert into criterioatividadeimpacto values ( 22, 'N? de opera??es/dia' );
 insert into criterioatividadeimpacto values ( 23, 'N? de pintos/mes' );
 insert into criterioatividadeimpacto values ( 24, 'N? de produtos cadastrados' );
 insert into criterioatividadeimpacto values ( 25, 'N? de ve?culos / embarca??es / aeronaves' );
 insert into criterioatividadeimpacto values ( 26, 'Peso em toneladas' );
 insert into criterioatividadeimpacto values ( 27, 'Popula??o atendida em n? de habitantes' );
 insert into criterioatividadeimpacto values ( 28, 'Pot?ncia em MW' );
 insert into criterioatividadeimpacto values ( 29, 'Quantidade de res?duo em Kg/dia' );
 insert into criterioatividadeimpacto values ( 30, 'Quantidade de res?duo em toneladas/dia' );
 insert into criterioatividadeimpacto values ( 31, 'Toneladas/m?s' );
 insert into criterioatividadeimpacto values ( 32, 'Valor ?nico' );
 insert into criterioatividadeimpacto values ( 33, 'Vaz?o afluente na ETE em m?/dia' );
 insert into criterioatividadeimpacto values ( 34, 'Volume de produ??o em m?/dia' );
 insert into criterioatividadeimpacto values ( 35, 'Volume em m?/dia' );
 insert into criterioatividadeimpacto values ( 36, 'Volume m?ximo de produto aplicado/ano em Kilograma ou litro' );
 insert into criterioatividadeimpacto values ( 37, 'Volume total de res?duos em m?/mes' );

select setval('criterioatividadeimpacto_am01_sequencial_seq', 37);
select setval('atividadeimpacto_am03_sequencial_seq',         1);
select setval('atividadeimpactoporte_am04_sequencial_seq',    1);

insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.010,10', 'BENEFICIAMENTO DE MINERAIS NAO-METALICOS, COM TINGIMENTO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.010,20', 'BENEFICIAMENTO DE MINERAIS NAO-METALICOS, SEM TINGIMENTO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.010,21', 'BRITAGEM', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.020,00', 'FABRICACAO DE CAL VIRGEM HIDRATADA OU EXTINTA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.030,10', 'FABRICACAO DE TELHAS/TIJOLOS/OUTROS ARTIGOS DE BARRO COZIDO, COM TINGIMENTO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.030,20', 'FABRICACAO DE TELHAS TIJOLOS OUTROS ARTIGOS DE BARRO COZIDO, SEM TINGIMENTO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.040,10', 'FABRICACAO DE MATERIAL CERAMICO EM GERAL', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.040,20', 'FABRICACAO DE ARTEFATOS DE PORCELANA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.040,30', 'FABRICACAO DE MATERIAL REFRATARIO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.050,10', 'FABRICACAO DE CIMENTO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.050,20', 'FABRICACAO DE CLINQUER', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.051,00', 'FABRICACAO DE PECAS ORNATOS ESTRUTURAS PRE-MOLDADOS DE CIMENTO, CONCRETO, GESSO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.052,00', 'FABRICACAO DE ARGAMASSA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.053,00', 'USINA DE PRODUCAO DE CONCRETO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.060,10', 'ELABORACAO DE VIDRO E CRISTAL', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.060,20', 'FABRICACAO DE ARTEFATOS DE VIDRO E CRISTAL', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.061,10', 'FABRICACAO DE LA DE VIDRO E ASSEMELHADOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.061,20', 'FABRICACAO DE ARTEFATOS DE FIBRA DE VIDRO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.062,00', 'FABRICACAO DE ESPELHOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.070,00', 'FABRICACAO DE PECAS ESTRUTURAS DE AMIANTO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.110,10', 'FABRICACAO DE ACO E PRODUTOS SIDERURGICOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.110,20', 'FABRICACAO DE OUTROS METAIS E SUAS LIGAS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.110,21', 'METALURGIA DOS METAIS PRECIOSOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.111,10', 'FABRICACAO DE LAMINADOS LIGAS ARTEFATOS DE METAIS NAO FERROSOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.111,20', 'RELAMINACAO DE METAIS NAO FERROSOS, INCLUSIVE LIGAS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.111,30', 'PRODUCAO DE SOLDAS E ANODOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.112,10', 'PRODUCAO DE FUNDIDOS DE FERRO E ACO FORJADOS ARAMES RELAMINADOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.112,20', 'PRODUCAO DE FUNDIDOS DE OUTROS METAIS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.112,21', 'PRODUCAO DE FUNDIDOS DE ALUMINIO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.112,22', 'PRODUCAO DE FUNDIDOS DE CHUMBO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 14, '111,30', 'IRRIGACAO SUPERFICIAL', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.113,00', 'METALURGIA DO PO, INCLUSIVE PECAS MOLDADAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 14, '111,40', 'IRRIGACAO POR ASPERSAO LOCALIZADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 4, '111,60', 'DRENAGEM AGRICOLA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 3, '111,70', 'RECUPERACAO DE AREA DEGRADADA POR IRRIGACAO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '111,91', 'BARRAGEM ACUDE PARA IRRIGACAO - APENAS PARA FORNECIMENTO DE AGUA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 14, '111,92', 'FORNECIMENTO DE AGUA DE RECURSOS HIDRICOS NATURAIS SUPERFICIAIS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '112,11', 'CRIACAO DE AVES DE CORTE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.121,10', 'FABRICACAO DE ESTRUTURAS ARTEFATOS RECIPIENTES OUTROS METALICOS, COM TRATAMENTO DE SUPERFICIE E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '112,12', 'CRIACAO DE AVES DE POSTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.121,20', 'FABRICACAO DE ESTRUTURAS ARTEFATOS RECIPIENTES OUTROS METALICOS, COM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '112,13', 'CRIACAO DE MATRIZES E OVOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.121,30', 'FABRICACAO DE ESTRUTURAS ARTEFATOS RECIPIENTES OUTROS METALICOS, SEM TRATAMENTO DE SUPERFICIE E COM PINTURA (EXCETO A PINCEL)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 23, '112,14', 'INCUBATORIO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.121,40', 'FABRICACAO DE ESTRUTURAS ARTEFATOS RECIPIENTES OUTROS METALICOS, SEM TRATAMENTO DE SUPERFICIE E COM PINTURA A PINCEL', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.121,50', 'FABRICACAO DE ESTRUTURAS ARTEFATOS RECIPIENTES OUTROS METALICOS, SEM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.122,00', 'GALVANIZACAO A FOGO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '112,21', 'CUNICULTURA E OUTROS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.123,10', 'FUNILARIA, ESTAMPARIA E LATOARIA, COM TRATAMENTO DE SUPERFICIE E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.123,20', 'FUNILARIA, ESTAMPARIA E LATOARIA, COM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.123,30', 'FUNILARIA, ESTAMPARIA E LATOARIA, SEM TRATAMENTO DE SUPERFICIE E COM PINTURA (EXCETO A PINCEL)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.123,40', 'FUNILARIA, ESTAMPARIA E LATOARIA, SEM TRATAMENTO DE SUPERFICIE E COM PINTURA A PINCEL', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.123,50', 'FUNILARIA, ESTAMPARIA E LATOARIA, SEM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.124,10', 'FABRICACAO DE TELAS DE ARAME E ARTEFATOS DE ARAMADOS, COM TRATAMENTO DE SUPERFICIE E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.124,20', 'FABRICACAO DE TELAS DE ARAME E ARTEFATOS DE ARAMADOS, COM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.124,30', 'FABRICACAO DE TELAS DE ARAME E ARTEFATOS DE ARAMADOS, SEM TRATAMENTO DE SUPERFICIE E COM PINTURA (EXCETO A PINCEL)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.124,40', 'FABRICACAO DE TELAS DE ARAME E ARTEFATOS DE ARAMADOS, SEM TRATAMENTO DE SUPERFICIE E COM PINTURA A PINCEL', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.124,50', 'FABRICACAO DE TELAS DE ARAME E ARTEFATOS DE ARAMADOS, SEM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.125,10', 'FABRICACAO DE ARTIGOS DE CUTELARIA E FERRAMENTAS MANUAIS, COM TRATAMENTO DE SUPERFICIE E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.125,20', 'FABRICACAO DE ARTIGOS DE CUTELARIA E FERRAMENTAS MANUAIS, COM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.125,30', 'FABRICACAO DE ARTIGOS DE CUTELARIA E FERRAMENTAS MANUAIS, SEM TRATAMENTO DE SUPERFICIE E COM PINTURA (EXCETO A PINCEL)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.125,40', 'FABRICACAO DE ARTIGOS DE CUTELARIA E FERRAMENTAS MANUAIS, SEM TRATAMENTO DE SUPERFICIE E COM PINTURA A PINCEL', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.125,50', 'FABRICACAO DE ARTIGOS DE CUTELARIA E FERRAMENTAS MANUAIS, SEM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.130,00', 'TEMPERA E CEMENTACAO DE ACO, RECOZIMENTO DE ARAMES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.140,00', 'RECUPERACAO DE EMBALAGENS METALICAS E PLASTICAS DE PRODUTOS OU RESIDUOS NAO PERIGOSOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.141,00', 'RECUPERACAO DE EMBALAGENS METALICAS E PLASTICAS DE PRODUTOS OU RESIDUOS PERIGOSOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 21, '114,21', 'CRIACAO DE SUINOS - CICLO COMPLETO - COM MANEJO DEJETOS LIQUIDOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 21, '114,22', 'CRIACAO DE SUINOS - UNIDADE PRODUTORA DE LEITOES ATE 21 DIAS - COM MANEJO DEJETOS LIQUIDOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 21, '114,23', 'CRIACAO DE SUINOS - UNIDADE PRODUTORA DE LEITOES ATE 63 DIAS - COM MANEJO DEJETOS LIQUIDOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '114,24', 'CRIACAO DE SUINOS - TERMINACAO - COM MANEJO DEJETOS LIQUIDOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '114,25', 'CRIACAO DE SUINOS - CRECHE - COM MANEJO DEJETOS LIQUIDOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '114,26', 'CRIACAO DE SUINOS - CENTRAL DE INSEMINACAO - COM MANEJO DEJETOS LIQUIDOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 21, '114,31', 'CRIACAO DE SUINOS - CICLO COMPLETO - COM MANEJO DE DEJETOS SOBRE CAMAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 21, '114,32', 'CRIACAO DE SUINOS - UNIDADE PRODUTORA DE LEITOES ATE 21 DIAS - COM MANEJO DE DEJETOS SOBRE CAMAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 21, '114,33', 'CRIACAO DE SUINOS - UNIDADE PRODUTORA DE LEITOES ATE 63 DIAS - COM MANEJO DE DEJETOS SOBRE CAMAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '114,34', 'CRIACAO DE SUINOS - TERMINACAO - COM MANEJO DE DEJETOS SOBRE CAMAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '114,35', 'CRIACAO DE SUINOS - CRECHE - COM MANEJO DE DEJETOS SOBRE CAMAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '114,36', 'CRIACAO DE SUINOS - CENTRAL DE INSEMINACAO - COM MANEJO DE DEJETOS SOBRE CAMAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '114,40', 'CRIACAO DE OVINOS DE CORTE EM SISTEMA EXTENSIVO A CAMPO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '114,90', 'CRIACAO DE OUTROS ANIMAIS DE MEDIO PORTE CONFINADOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '116,10', 'CRIACAO DE BOVINOS CONFINADOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '116,20', 'CRIACAO DE OUTROS ANIMAIS DE GRANDE PORTE CONFINADOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '117,10', 'CRIACAO DE BOVINOS (SEMI-EXTENSIVO)', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '117,20', 'ACUDE PARA DESSEDENTACAO ANIMAL', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '117,30', 'CRIACAO DE BOVINOS DE CORTE EM SISTEMA EXTENSIVO A CAMPO', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 15, '118,10', 'CENTRAIS DE BENEFICIAMENTO DE DEJETOS SECOS DE CRIACOES DE ANIMAIS CONFINADOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 15, '118,20', 'CENTRAIS DE BENEFICIAMENTO DE DEJETOS LIQUIDOS DE CRIACOES DE ANIMAIS CONFINADOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '119,11', 'UNIDADES DE PRODUCAO DE ALEVINOS (SISTEMA INTENSIVO)', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '119,12', 'UNIDADES DE PRODUCAO DE ALEVINOS - SOMENTE ESPECIES NATIVAS - SISTEMA INTENSIVO', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '119,13', 'UNIDADES DE PRODUCAO DE ALEVINOS - ESPECIES EXOTICAS (SISTEMA INTENSIVO)', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '119,21', 'PISCICULTURA DE ESPECIES NATIVAS PARA ENGORDA (SISTEMA INTENSIVO)', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '119,22', 'PISCICULTURA DE ESPECIES EXOTICAS PARA ENGORDA (SISTEMA INTENSIVO)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '119,31', 'PISCICULTURA DE ESPECIES NATIVAS (SISTEMA SEMI-INTENSIVO)', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '119,32', 'PISCICUTURA DE ESPECIES EXOTICAS (SISTEMA SEMI-INTENSIVO)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '119,41', 'PISCICULTURA DE ESPECIES NATIVAS (SISTEMA EXTENSIVO)', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '119,42', 'PISCICULTURA DE ESPECIES EXOTICAS (SISTEMA EXTENSIVO)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '120,00', 'RANICULTURA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '121,00', 'CARCINOCULTURA (CRUSTACEOS)', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.210,10', 'FABRICACAO DE MAQUINAS E APARELHOS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.210,20', 'FABRICACAO DE MAQUINAS E APARELHOS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.210,30', 'FABRICACAO DE MAQUINAS E APARELHOS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.210,40', 'FABRICACAO DE MAQUINAS E APARELHOS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.210,50', 'FABRICACAO DE MAQUINAS E APARELHOS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.210,60', 'FABRICACAO DE MAQUINAS E APARELHOS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E COM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.210,70', 'FABRICACAO DE MAQUINAS E APARELHOS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.210,80', 'FABRICACAO DE MAQUINAS E APARELHOS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E SEM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '122,00', 'MALACOCULTURA (MOLUSCOS) E OUTROS', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.220,10', 'FABRICACAO DE UTENSILIOS, PECAS E ACESSORIOS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.220,20', 'FABRICACAO DE UTENSILIOS, PECAS E ACESSORIOS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.220,30', 'FABRICACAO DE UTENSILIOS, PECAS E ACESSORIOS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.220,40', 'FABRICACAO DE UTENSILIOS, PECAS E ACESSORIOS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.220,50', 'FABRICACAO DE UTENSILIOS, PECAS E ACESSORIOS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.220,60', 'FABRICACAO DE UTENSILIOS, PECAS E ACESSORIOS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E COM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.220,70', 'FABRICACAO DE UTENSILIOS, PECAS E ACESSORIOS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.220,80', 'FABRICACAO DE UTENSILIOS, PECAS E ACESSORIOS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E SEM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.221,00', 'FABRICACAO DE UTENSILIOS, PECAS E ACESSORIOS, COM MICROFUSAO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.222,10', 'FABRICACAO DE AUTOPECAS MOTOPECAS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.222,20', 'FABRICACAO DE AUTOPECAS MOTOPECAS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.222,30', 'FABRICACAO DE AUTOPECAS MOTOPECAS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.222,40', 'FABRICACAO DE AUTOPECAS MOTOPECAS, COM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.222,50', 'FABRICACAO DE AUTOPECAS/MOTOPECAS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.222,60', 'FABRICACAO DE AUTOPECAS/MOTOPECAS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E COM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.222,70', 'FABRICACAO DE AUTOPECAS/MOTOPECAS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, COM FUNDICAO E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.222,80', 'FABRICACAO DE AUTOPECAS MOTOPECAS, SEM TRATAMENTO SUPERFICIE INCLUSIVE TRATAMENTO TERMICO, SEM FUNDICAO E SEM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.224,00', 'FABRICACAO DE CHASSIS PARA VEICULOS AUTOMOTORES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 24, '123,11', 'CADASTRO DE PRODUTOS AGROTOXICOS E OUTROS BIOCIDAS - CLASSE TOXICOLOGICA I', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 24, '123,12', 'CADASTRO DE PRODUTOS AGROTOXICOS E OUTROS BIOCIDAS - CLASSE TOXICOLOGICA II', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 24, '123,13', 'CADASTRO DE PRODUTOS AGROTOXICOS E OUTROS BIOCIDAS - CLASSE TOXICOLOGICA III', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 24, '123,14', 'CADASTRO DE PRODUTOS AGROTOXICOS E OUTROS BIOCIDAS - CLASSE TOXICOLOGICA IV', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '123,20', 'AVIACAO AGRICOLA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 36, '124,30', 'SERVICO DE APLICACAO DE AGROTOXICOS E AFINS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 8, '125,00', 'CULTURAS AGRICOLAS NAO IRRIGADAS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 8, '126,10', 'SILVICULTURA DE EXOTICAS COM ALTA CAPACIDADE INVASORA (PINUS SP E OUTRAS)', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 8, '126,20', 'SILVICULTURA DE EXOTICAS COM BAIXA CAPACIDADE INVASORA (EUCALYPTUS SP, ACACIA MEARNSII E OUTRAS)', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 18, '130,10', 'CRIADOURO DE FAUNA SILVESTRE NAO AMADORA EM CATIVEIRO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.310,10', 'FABRICACAO DE MATERIAL ELETRICO- ELETRONICO EQUIPAMENTOS PARA COMUNICACAO INFORMATICA, COM TRATAMENTO SUPERFICIE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.310,20', 'FABRICACAO DE MATERIAL ELETRICO-ELETRONICO/EQUIPAMENTOS PARA COMUNICACAO/INFORMATICA, SEM TRATAMENTO SUPERFICIE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '132,00', 'EXTRACAO DE HUMUS PARA USO AGRICOLA', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.320,00', 'FABRICACAO DE PILHAS/BATERIAS E OUTROS ACUMULADORES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.321,00', 'RECUPERACAO DE BATERIAS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '133,00', 'AREA DE PESQUISA AGRICOLA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.330,10', 'FABRICACAO DE APARELHOS ELETRICOS E ELETRODOMESTICOS, COM TRATAMENTO DE SUPERFICIE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.330,20', 'FABRICACAO DE APARELHOS ELETRICOS E ELETRODOMESTICOS, SEM TRATAMENTO DE SUPERFICIE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.340,00', 'FABRICACAO DE LAMPADAS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.411,10', 'FABRICACAO, MONTAGEM E REPARACAO DE AUTOMOVEIS/CAMIONETES (INCLUSIVE CABINE DUPLA)', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.411,20', 'FABRICACAO, MONTAGEM E REPARACAO DE CAMINHOES, ONIBUS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.411,30', 'FABRICACAO, MONTAGEM E REPARACAO DE MOTOS, BICICLETAS, TRICICLOS, ETC', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.411,40', 'FABRICACAO, MONTAGEM E REPARACAO DE REBOQUES E OU TRAILLERS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.412,10', 'FABRICACAO, MONTAGEM E REPARACAO DE TRENS, LOCOMOTIVAS, VAGOES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.412,20', 'MANUTENCAO E ABASTECIMENTO DE LOCOMOTIVAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.413,10', 'FABRICACAO, MONTAGEM E REPARACAO DE AERONAVES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.414,10', 'FABRICACAO, MONTAGEM E REPARACAO DE EMBARCACOES ESTRUTURAS FLUTUANTES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.414,20', 'FABRICACAO, MONTAGEM E REPARACAO DE BARCOS DE FIBRA DE VIDRO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.415,00', 'FABRICACAO, MONTAGEM E REPARACAO DE TRATORES E MAQUINAS DE TERRAPLANAGEM', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.510,10', 'SERRARIA E DESDOBRAMENTO COM TRATAMENTO DE MADEIRA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.510,20', 'SERRARIA E DESDOBRAMENTO SEM TRATAMENTO DE MADEIRA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.520,10', 'PRESERVACAO DE MADEIRA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.520,20', 'SECAGEM DE MADEIRA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.520,30', 'OUTROS BENEFICIAMENTOS E OU TRATAMENTOS DE MADEIRA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.530,10', 'FABRICACAO DE PLACAS CHAPAS MADEIRA AGLOMERADA PRENSADA COMPENSADA COM UTILIZACAO DE RESINAS ( MDF, MDP E OUTRAS )', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.530,20', 'FABRICACAO DE PLACAS CHAPAS MADEIRA AGLOMERADA PRENSADA COMPENSADA SEM UTILIZACAO DE RESINAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.540,00', 'FABRICACAO DE ARTEFATOS/ ESTRUTURAS DE MADEIRA (EXCETO MOVEIS)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.540,10', 'FABRICACAO DE ARTEFATOS DE CORTICA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.540,20', 'FABRICACAO DE ARTEFATOS DE BAMBU VIME JUNCO PALHA TRANCADA (EXCETO MOVEIS)', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.611,10', 'FABRICACAO DE MOVEIS DE MADEIRA BAMBU VIME JUNCO, COM ACESSORIOS DE METAL, COM TRATAMENTO DE SUPERFICIE E COM PINTURA (EXCETO A PINCEL)', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.611,20', 'FABRICACAO DE MOVEIS DE MADEIRA BAMBU VIME JUNCO, COM ACESSORIOS DE METAL, COM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.611,30', 'FABRICACAO DE MOVEIS DE MADEIRA/ BAMBU/ VIME/ JUNCO, COM ACESSORIOS DE METAL, SEM TRATAMENTO DE SUPERFICIE E COM PINTURA (EXCETO A PINCEL)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.611,40', 'FABRICACAO DE MOVEIS DE MADEIRA BAMBU VIME JUNCO, COM ACESSORIOS DE METAL, SEM TRATAMENTO DE SUPERFICIE E COM PINTURA A PINCEL', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.611,50', 'FABRICACAO DE MOVEIS DE MADEIRA/ BAMBU/ VIME/ JUNCO, COM ACESSORIOS DE METAL, SEM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.612,10', 'FABRICACAO DE MOVEIS DE MADEIRA/ BAMBU/ VIME/ JUNCO, SEM ACESSORIOS DE METAL, COM PINTURA (EXCETO A PINCEL)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.612,20', 'FABRICACAO DE MOVEIS DE MADEIRA BAMBU VIME JUNCO, SEM ACESSORIOS DE METAL, COM PINTURA A PINCEL', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.612,30', 'FABRICACAO DE MOVEIS DE MADEIRA BAMBU VIME JUNCO, SEM ACESSORIOS DE METAL, SEM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.620,10', 'FABRICACAO DE MOVEIS DE METAL, COM TRATAMENTO DE SUPERFICIE E COM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.620,20', 'FABRICACAO DE MOVEIS DE METAL, COM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.620,30', 'FABRICACAO DE MOVEIS DE METAL, SEM TRATAMENTO DE SUPERFICIE E COM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.620,40', 'FABRICACAO DE MOVEIS DE METAL, SEM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.630,10', 'FABRICACAO DE MOVEIS MOLDADOS DE MATERIAL PLASTICO, COM TRATAMENTO DE SUPERFICIE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.630,20', 'FABRICACAO DE MOVEIS MOLDADOS DE MATERIAL PLASTICO, SEM TRATAMENTO DE SUPERFICIE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.640,10', 'FABRICACAO DE COLCHOES', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.640,20', 'FABRICACAO DE ESTOFADOS', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.710,00', 'FABRICACAO DE CELULOSE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.720,00', 'FABRICACAO DE PAPEL, PAPELAO, CARTOLINA E CARTAO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.721,10', 'FABRICACAO DE ARTEFATOS DE PAPEL PAPELAO CARTOLINA CARTAO, COM OPERACOES MOLHADAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.721,21', 'FABRICACAO DE ARTEFATOS DE PAPEL PAPELAO CARTOLINA CARTAO, COM OPERACOES SECAS, COM IMPRESSAO GRAFICA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.721,22', 'FABRICACAO DE ARTEFATOS DE PAPEL PAPELAO CARTOLINA CARTAO, COM OPERACOES SECAS, SEM IMPRESSAO GRAFICA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.730,00', 'FABRICACAO DE ARTIGOS DIVERSOS DE FIBRA PRENSADA OU ISOLANTE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.810,00', 'BENEFICIAMENTO DE BORRACHA NATURAL', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.820,00', 'FABRICACAO DE ARTIGOS ARTEFATOS DIVERSOS DE BORRACHA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.820,10', 'FABRICACAO DE PNEUMATICO CAMARA DE AR', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.820,20', 'FABRICACAO DE LAMINADOS E FIOS DE BORRACHA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.820,30', 'FABRICACAO DE ESPUMA DE BORRACHA/ ARTEFATOS DE ESPUMA DE BORRACHA, INCLUSIVE LATEX', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.830,00', 'RECUPERACAO DE SUCATA DE BORRACHA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.840,00', 'RECONDICIONAMENTO DE PNEUMATICOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.910,00', 'SECAGEM E SALGA DE COUROS E PELES (SOMENTE ZONA RURAL)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.921,11', 'CURTIMENTO DE PELES BOVINAS/ SUINAS/ CAPRINAS E EQUINAS - CURTUME COMPLETO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.921,12', 'CURTIMENTO DE PELES BOVINAS SUINAS CAPRINAS E EQUINAS - ATE WET BLUE OU ATANADO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.921,20', 'CURTIMENTO DE PELE OVINA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.922,10', 'ACABAMENTO DE COUROS, A PARTIR DE WET BLUE OU ATANADO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.922,20', 'ACABAMENTO DE COUROS, A PARTIR DE COURO SEMI-ACABADO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.930,00', 'FABRICACAO DE COLA ANIMAL', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.940,00', 'FABRICACAO DE ARTEFATOS DIVERSOS DE COUROS E PELES (EXCETO CALCADO)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '1.940,10', 'FABRICACAO DE OSSOS PARA CAES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.010,00', 'PRODUCAO DE SUBSTANCIAS QUIMICAS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.010,10', 'PRODUCAO DE GASES INDUSTRIAIS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.020,00', 'FABRICACAO DE PRODUTOS QUIMICOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.020,10', 'FABRICACAO DE POLVORA EXPLOSIVO DETONANTE FOSFORO MUNICAO ARTIGOS PIROTECNICOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.020,20', 'FABRICACAO DE CONCENTRADO AROMATICO NATURAL/ ARTIFICIAL/ SINTETICO/ MESCLA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.020,30', 'FABRICACAO DE PRODUTOS DE LIMPEZA POLIMENTO DESINFETANTE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.020,40', 'FABRICACAO DE FERTILIZANTES E AGROQUIMICOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.020,41', 'MISTURA DE FERTILIZANTES', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.020,50', 'FABRICACAO DE ALCOOL ETILICO, METANOL E SIMILARES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.021,00', 'FRACIONAMENTO DE PRODUTOS QUIMICOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.030,00', 'RECUPERACAO DE PRODUTOS QUIMICOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.040,00', 'RECUPERACAO DE METAIS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.051,00', 'FABRICACAO DE INSETICIDAS, GERMICIDAS E OU FUNGICIDAS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.052,10', 'FABRICACAO DE AGROTOXICOS BIOLOGICOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.052,20', 'FABRICACAO DE AGROTOXICOS NAO BIOLOGICOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.061,00', 'FABRICACAO DE PRODUTOS DERIVADOS DO PROCESSAMENTO DE PETROLEO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.062,00', 'REFINARIA DE PETROLEO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.063,00', 'PRODUCAO DE RESINAS DE MADEIRA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.064,00', 'EXTRACAO DE TANINO VEGETAL', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.065,10', 'USINA DE ASFALTO E CONCRETO ASFALTICO, A QUENTE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.065,20', 'USINA DE ASFALTO E CONCRETO ASFALTICO, A FRIO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.066,00', 'PRODUCAO DE OLEO GORDURA CERA VEGETAL ANIMAL ESSENCIAL E OUTRO PRODUTO DA DESTILACAO DA MADEIRA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.067,10', 'RE-REFINO DE OLEOS LUBRIFICANTES', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.067,20', 'RECUPERACAO DE SOLVENTES', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.067,30', 'RECUPERACAO DE OLEOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.068,00', 'MISTURA DE GRAXAS LUBRIFICANTES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.070,00', 'FABRICACAO DE RESINAS ADESIVOS FIBRAS FIOS ARTIFICIAIS E SINTETICOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.080,00', 'FABRICACAO DE TINTA ESMALTE LACA VERNIZ IMPERMEABILIZANTE SOLVENTE SECANTE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.080,10', 'FABRICACAO DE TINTA COM PROCESSAMENTO A SECO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.090,00', 'FABRICACAO DE COMBUSTIVEIS NAO DERIVADOS DO PETROLEO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.110,00', 'FABRICACAO DE PRODUTOS FARMACEUTICOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.110,10', 'FABRICACAO DE PRODUTOS DE HIGIENE PESSOAL DESCARTAVEIS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.120,00', 'FABRICACAO DE PRODUTOS VETERINARIOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.210,00', 'FABRICACAO DE PRODUTOS DE PERFUMARIA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.210,10', 'FABRICACAO DE COSMETICOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.220,10', 'FABRICACAO DE SABOES, COM EXTRACAO DE LANOLINA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.220,20', 'FABRICACAO DE SABOES, SEM EXTRACAO DE LANOLINA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.221,00', 'FABRICACAO DE SEBO INDUSTRIAL', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.230,00', 'FABRICACAO DE DETERGENTES', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.240,00', 'FABRICACAO DE VELAS', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.310,10', 'FABRICACAO DE ARTEFATOS DE MATERIAL PLASTICO, COM TRATAMENTO DE SUPERFICIE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.310,20', 'FABRICACAO DE ARTEFATOS DE MATERIAL PLASTICO, SEM TRATAMENTO DE SUPERFICIE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.310,21', 'FABRICACAO DE ARTEFATOS DE MATERIAL PLASTICO, SEM TRATAMENTO DE SUPERFICIE, COM IMPRESSAO GRAFICA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.310,22', 'FABRICACAO DE ARTEFATOS DE MATERIAL PLASTICO, SEM TRATAMENTO DE SUPERFICIE, SEM IMPRESSAO GRAFICA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.320,00', 'FABRICACAO DE CANOS, TUBOS E CONEXOES PLASTICAS', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.330,00', 'FABRICACAO DE PRODUTOS ACRILICOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.340,00', 'FABRICACAO DE LAMINADOS PLASTICOS', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.411,10', 'BENEFICIAMENTO DE FIBRAS TEXTEIS VEGETAIS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.411,20', 'BENEFICIAMENTO DE FIBRAS TEXTEIS ARTIFICIAIS/ SINTETICAS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.412,10', 'BENEFICIAMENTO DE MATERIAS TEXTEIS DE ORIGEM ANIMAL, COM LAVAGEM DE LA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.412,20', 'BENEFICIAMENTO DE MATERIAS TEXTEIS DE ORIGEM ANIMAL, SEM LAVAGEM DE LA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.420,10', 'FIACAO E OU TECELAGEM, COM TINGIMENTO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.420,20', 'FIACAO E OU TECELAGEM, SEM TINGIMENTO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.430,10', 'FABRICACAO DE TECIDOS ESPECIAIS, COM TINGIMENTO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.430,20', 'FABRICACAO DE TECIDOS ESPECIAIS, SEM TINGIMENTO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.440,00', 'FABRICACAO DE ESTOPA MATERIAL PARA ESTOFO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.510,00', 'FABRICACAO DE CALCADOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.511,10', 'FABRICACAO DE ARTEFATOS/COMPONENTES PARA CALCADOS, COM TRATAMENTO DE SUPERFICIE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.511,20', 'FABRICACAO DE ARTEFATOS COMPONENTES PARA CALCADOS, SEM TRATAMENTO DE SUPERFICIE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.512,00', 'ATELIER DE CALCADOS', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.520,10', 'FABRICACAO DE VESTUARIO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.520,11', 'FABRICACAO DE ROUPAS CIRURGICAS E PROFISSIONAIS DESCARTAVEIS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.520,12', 'MALHARIA (SOMENTE CONFECCAO)', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.520,20', 'FABRICACAO DE COLCHAS, ACOLCHOADOS E OUTROS ARTIGOS DE DECORACAO EM TECIDO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.530,10', 'FABRICACAO DE ARTEFATOS DE TECIDO, COM TINGIMENTO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.530,20', 'FABRICACAO DE ARTEFATOS DE TECIDO, SEM TINGIMENTO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.540,00', 'TINGIMENTO DE ROUPA PECA ARTEFATOS DE TECIDO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.550,00', 'ESTAMPARIA OUTRO ACABAMENTO EM ROUPA PECA TECIDOS ARTEFATOS DE TECIDO, EXCETO TINGIMENTO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.611,10', 'SECAGEM DE ARROZ', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.611,20', 'SECAGEM DE OUTROS GRAOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.612,00', 'MOAGEM DE GRAOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.612,10', 'MOINHO DE TRIGO E/OU MILHO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.612,20', 'MOINHO DE OUTROS GRAOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.613,10', 'TORREFACAO E MOAGEM DE CAFE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.614,11', 'ENGENHO DE ARROZ COM PARBOILIZACAO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.614,12', 'ENGENHO DE ARROZ SEM PARBOILIZACAO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.615,00', 'OUTRAS OPERACOES DE BENEFICIAMENTO DE GRAOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.621,11', 'MATADOUROS ABATEDOUROS DE BOVINOS, COM FABRICACAO DE EMBUTIDOS OU INDUSTRIALIZACAO DE CARNES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.621,12', 'MATADOUROS ABATEDOUROS DE BOVINOS, SEM FABRICACAO DE EMBUTIDOS OU INDUSTRIALIZACAO DE CARNES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.621,21', 'MATADOUROS/ ABATEDOUROS DE SUINOS, COM FABRICACAO DE EMBUTIDOS OU INDUSTRIALIZACAO DE CARNES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.621,22', 'MATADOUROS ABATEDOUROS DE SUINOS, SEM FABRICACAO DE EMBUTIDOS OU INDUSTRIALIZACAO DE CARNES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.621,31', 'MATADOUROS ABATEDOUROS DE AVES E OU COELHOS, COM FABRICACAO DE EMBUTIDOS OU INDUSTRIALIZACAO DE CARNES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.621,32', 'MATADOUROS ABATEDOUROS DE AVES E OU COELHOS, SEM FABRICACAO DE EMBUTIDOS OU INDUSTRIALIZACAO DE CARNES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.621,41', 'MATADOUROS ABATEDOUROS DE BOVINOS E SUINOS, COM FABRICACAO DE EMBUTIDOS OU INDUSTRIALIZACAO DE CARNES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.621,42', 'MATADOUROS/ ABATEDOUROS DE BOVINOS E SUINOS, SEM FABRICACAO DE EMBUTIDOS OU INDUSTRIALIZACAO DE CARNES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.621,51', 'MATADOUROS ABATEDOUROS DE OUTROS ANIMAIS, COM FABRICACAO DE EMBUTIDOS OU INDUSTRIALIZACAO DE CARNES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.621,52', 'MATADOUROS/ ABATEDOUROS DE OUTROS ANIMAIS, SEM FABRICACAO DE EMBUTIDOS OU INDUSTRIALIZACAO DE CARNES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.622,10', 'FABRICACAO DE DERIVADOS DE ORIGEM ANIMAL E FRIGORIFICOS SEM ABATE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.622,20', 'FABRICACAO DE EMBUTIDOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.622,30', 'PREPARACAO DE CONSERVAS DE CARNE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.622,40', 'PRODUCAO DE BANHA E GORDURAS ANIMAIS COMESTIVEIS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.622,50', 'BENEFICIAMENTO DE TRIPAS ANIMAIS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.623,10', 'FABRICACAO DE RACAO BALANCEADA FARINHA DE OSSO PENA ALIMENTOS PARA ANIMAIS, COM COZIMENTO E OU COM DIGESTAO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.623,20', 'FABRICACAO DE RACAO BALANCEADA/ FARINHA DE OSSO/ PENA/ ALIMENTOS PARA ANIMAIS, SEM COZIMENTO E/OU SEM DIGESTAO (SOMENTE MISTURA)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.624,10', 'PREPARACAO DE PESCADO FABRICACAO DE CONSERVAS DE PESCADO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.624,20', 'SALGAMENTO DE PESCADO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.624,30', 'ARMAZENAMENTO DE PESCADO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.625,10', 'BENEFICIAMENTO E INDUSTRIALIZACAO DE LEITE E SEUS DERIVADOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.625,20', 'FABRICACAO DE QUEIJOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.625,30', 'PREPARACAO DE LEITE, INCLUSIVE PASTEURIZACAO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.625,40', 'POSTO DE RESFRIAMENTO DE LEITE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.631,10', 'FABRICACAO DE ACUCAR REFINADO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.632,10', 'FABRICACAO DE DOCES EM PASTA, CRISTALIZADOS, EM BARRA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.632,20', 'FABRICACAO DE SORVETES BOLOS E TORTAS GELADAS COBERTURAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.632,30', 'FABRICACAO DE BALAS/ CARAMELOS/ PASTILHAS/ DROPES/ BOMBONS/ CHOCOLATES/ GOMAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.632,40', 'ENTREPOSTO DISTRIBUIDOR DE MEL', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.640,00', 'FABRICACAO DE MASSAS ALIMENTICIAS (INCLUSIVE PAES), BOLACHAS E BISCOITOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.640,10', 'PADARIA, CONFEITARIA, PASTELARIA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.651,00', 'FABRICACAO DE CONDIMENTOS', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.652,10', 'FABRICACAO DE VINAGRE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.652,20', 'PREPARACAO DE SAL DE COZINHA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.653,00', 'FABRICACAO DE FERMENTOS E LEVEDURAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.660,00', 'FABRICACAO DE CONSERVAS, EXCETO DE CARNE E PESCADO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.670,10', 'FABRICACAO DE PROTEINA TEXTURIZADA E HIDROLIZADA DE SOJA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.670,20', 'FABRICACAO DE PROTEINA TEXTURIZADA DE SOJA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.670,30', 'FABRICACAO DE PROTEINA HIDROLIZADA DE SOJA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.680,10', 'SELECAO E LAVAGEM DE OVOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.680,20', 'SELECAO E LAVAGEM DE FRUTAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.680,30', 'LAVAGEM DE LEGUMES E OU VERDURAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.680,40', 'PASTEURIZACAO DE OVO LIQUIDO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.691,00', 'PREPARACAO DE REFEICOES INDUSTRIAIS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.692,10', 'FABRICACAO DE ERVA-MATE', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.692,20', 'FABRICACAO DE CHAS E ERVAS PARA INFUSAO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.693,00', 'FABRICACAO DE PRODUTOS DERIVADOS DA MANDIOCA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.694,10', 'REFINO PREPARACAO DE OLEO GORDURA VEGETAL ANIMAL ATRAVES DE EXTRACAO POR SOLVENTES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.694,20', 'REFINO PREPARACAO DE OLEO GORDURA VEGETAL ANIMAL ATRAVES DE PROCESSO FISICO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.695,00', 'FABRICACAO DE GELATINA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.696,00', 'FABRICACAO DE OUTROS PRODUTOS ALIMENTARES NAO ESPECIFICADOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.710,10', 'FABRICACAO DE CERVEJA CHOPE MALTE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.710,20', 'FABRICACAO DE VINHOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.710,30', 'FABRICACAO DE AGUARDENTE LICORES OUTROS DESTILADOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.710,40', 'FABRICACAO DE OUTRAS BEBIDAS ALCOOLICAS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.720,10', 'FABRICACAO DE REFRIGERANTES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.720,20', 'CONCENTRADORAS DE SUCO DE FRUTAS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.720,30', 'FABRICACAO DE OUTRAS BEBIDAS NAO ALCOOLICAS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.730,00', 'ENGARRAFAMENTO DE BEBIDAS, INCLUSIVE ENGARRAFAMENTO E GASEIFICACAO DE AGUA MINERAL, COM OU SEM LAVAGEM DE GARRAFAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.810,00', 'PREPARACAO DO FUMO FABRICACAO DE CIGARRO CHARUTO CIGARRILHAS ETC', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.820,00', 'CONSERVACAO DO FUMO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '2.910,00', 'CONFECCAO DE MATERIAL IMPRESSO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.001,10', 'FABRICACAO DE JOIAS BIJUTERIAS, COM TRATAMENTO DE SUPERFICIE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.001,20', 'FABRICACAO DE JOIAS/ BIJUTERIAS, SEM TRATAMENTO DE SUPERFICIE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.002,10', 'FABRICACAO DE ENFEITES DIVERSOS, COM TRATAMENTO DE SUPERFICIE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.002,20', 'FABRICACAO DE ENFEITES DIVERSOS, SEM TRATAMENTO DE SUPERFICIE', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.003,10', 'FABRICACAO DE INSTRUMENTOS DE PRECISAO NAO ELETRICOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.003,20', 'FABRICACAO DE APARELHOS PARA USO MEDICO, ODONTOLOGICO E CIRURGICO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.003,21', 'FABRICACAO DE APARELHOS ORTOPEDICOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.003,30', 'FABRICACAO DE APARELHOS E MATERIAIS FOTOGRAFICOS E OU CINEMATOGRAFICOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.003,40', 'FABRICACAO DE INSTRUMENTOS MUSICAIS E FITAS MAGNETICAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.003,41', 'INDUSTRIA FONOGRAFICA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.003,50', 'FABRICACAO DE EXTINTORES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.003,60', 'FABRICACAO DE OUTROS APARELHOS E INSTRUMENTOS NAO ESPECIFICADOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.004,00', 'FABRICACAO DE ESCOVAS, PINCEIS, VASSOURAS, ETC', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.005,00', 'FABRICACAO DE CORDAS CORDOES E CABOS', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.006,00', 'FABRICACAO DE GELO (EXCETO GELO SECO)', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.007,10', 'LAVANDERIA PARA ROUPAS E ARTEFATOS INDUSTRIAIS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.007,20', 'LAVANDERIA PARA ROUPAS E ARTEFATOS DE USO DOMESTICO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.008,00', 'FABRICACAO DE ARTIGOS ESPORTIVOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.009,00', 'LABORATORIO DE TESTES DE PROCESSOS PRODUTOS INDUSTRIAIS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.010,10', 'SERVICOS DE GALVANOPLASTIA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.010,20', 'SERVICOS DE FOSFATIZACAO/ ANODIZACAO/ DECAPAGEM/ ETC, EXCETO GALVANOPLASTIA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.011,00', 'SERVICOS DE USINAGEM', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.012,00', 'SERVICOS DE TORNEARIA FERRARIA SERRALHERIA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 17, '3.013,10', 'LIMPEZA RESTAURACAO DE EQUIPAMENTOS COM TRATAMENTO DE SUPERFICIE E OU TRATAMENTO TERMICO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 17, '3.013,20', 'LIMPEZA RESTAURACAO DE EQUIPAMENTOS SEM TRATAMENTO DE SUPERFICIE E OU TRATAMENTO TERMICO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 34, '3.017,00', 'PRODUCAO DE CARVAO VEGETAL EM FORNOS', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.018,00', 'SECADOR DE FUMO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.020,00', 'FABRICACAO DE ARTEFATOS DE TECIDO E METAL SEM TRATAMENTO DE SUPERFICIE', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.111,10', 'ATERRO DE RESIDUO SOLIDO INDUSTRIAL CLASSE I', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.111,20', 'ATERRO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II A', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 31, '3.111,21', 'ATERRO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II A - CASCA DE ARROZ', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 31, '3.111,22', 'ATERRO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II A - CINZA ORIUNDA DA QUEIMA DE CASCA DE ARROZ', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.112,10', 'CENTRAL DE RECEBIMENTO E DESTINACAO DE RESIDUO SOLIDO INDUSTRIAL CLASSE I', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.112,20', 'CENTRAL DE RECEBIMENTO E DESTINACAO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II A', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.113,10', 'INCINERACAO DE RESIDUO SOLIDO INDUSTRIAL CLASSE I', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.113,20', 'INCINERACAO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II A', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.113,30', 'INCINERACAO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II B', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.114,10', 'INCORPORACAO DE RESIDUO INDUSTRIAL CLASSE II A EM SOLO AGRICOLA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.115,10', 'CO-PROCESSAMENTO DE RESIDUO SOLIDO INDUSTRIAL CLASSE I EM FORNOS DE CIMENTO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.115,11', 'UNIDADES DE MISTURA E PRE - CONDICIONAMENTO DE RESIDUOS CLASSE I PARA FINS DE CO-PROCESSAMENTO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.115,20', 'CO-PROCESSAMENTO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II A EM FORNOS DE CIMENTO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.115,21', 'UNIDADES DE MISTURA E PRE - CONDICIONAMENTO DE RESIDUOS CLASSE II PARA FINS DE CO-PROCESSAMENTO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.115,30', 'CO-PROCESSAMENTO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II B EM FORNOS DE CIMENTO', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 31, '3.116,10', 'COMPOSTAGEM DE RESIDUO INDUSTRIAL CLASSE II A', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 31, '3.116,20', 'VERMICOMPOSTAGEM DE RESIDUO SOLIDO INDUSTRIAL CLASSE II B', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 31, '3.117,00', 'SISTEMA DE COLETA, ARMAZENAMENTO, TRANSPORTE E DESTINACAO FINAL DE EMBALAGENS DE OLEO LUBRIFICANTES', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.117,10', 'OUTRA DESTINACAO DE RESIDUO SOLIDO CLASSE INDUSTRIAL I NAO ESPECIFICADA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.117,20', 'OUTRA DESTINACAO DE RESIDUO SOLIDO CLASSE INDUSTRIAL II A NAO ESPECIFICADA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.117,30', 'OUTRA DESTINACAO DE RESIDUO SOLIDO CLASSE INDUSTRIAL II B NAO ESPECIFICADA', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.121,10', 'TRIAGEM E ARMAZENAMENTO DE RESIDUO SOLIDO INDUSTRIAL CLASSE I', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.121,20', 'TRIAGEM E ARMAZENAMENTO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II A', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.121,30', 'TRIAGEM E ARMAZENAMENTO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II B', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.121,40', 'INCORPORACAO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II COMO MATERIA-PRIMA E/OU CARGA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.121,50', 'APLICACAO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II EM SOLO AGRICOLA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.122,10', 'PROCESSAMENTO DE RESIDUO SOLIDO INDUSTRIAL CLASSE I', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 31, '3.122,20', 'PROCESSAMENTO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II A', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 31, '3.122,30', 'PROCESSAMENTO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II B', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 37, '3.126,00', 'RECICLAGEM DE RESIDUO SOLIDO INDUSTRIAL CLASSE II', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.130,11', 'REMEDIACAO DE AREA DE ATERRO DE RESIDUO SOLIDO INDUSTRIAL CLASSE I', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.130,12', 'REMEDIACAO DE AREA DE ATERRO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II A', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.130,21', 'REMEDIACAO DE AREA DEGRADADA POR RESIDUO SOLIDO INDUSTRIAL CLASSE I', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.130,22', 'REMEDIACAO DE AREA DEGRADADA POR RESIDUO SOLIDO INDUSTRIAL CLASSE II A', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.130,31', 'REMEDIACAO DE AREA DE PROCESSO INDUSTRIAL CONTAMINADA POR PRODUTO PERIGOSO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.130,32', 'REMEDIACAO DE AREA DE PROCESSO INDUSTRIAL CONTAMINADA POR PRODUTO NAO PERIGOSO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.130,41', 'MONITORAMENTO DE AREA DE ATERRO DE RESIDUO SOLIDO INDUSTRIAL CLASSE I', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.130,42', 'MONITORAMENTO DE AREA DE ATERRO DE RESIDUO SOLIDO INDUSTRIAL CLASSE II A', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.130,51', 'MONITORAMENTO DE AREA DEGRADADA POR RESIDUO SOLIDO INDUSTRIAL CLASSE I', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.130,52', 'MONITORAMENTO DE AREA DEGRADADA POR RESIDUO SOLIDO INDUSTRIAL CLASSE II A', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.130,60', 'MONITORAMENTO DE AREA DE PROCESSO INDUSTRIAL', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.411,00', 'BERCARIO MICRO-EMPRESA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 8, '3.412,00', 'CEMITERIO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 22, '3.412,10', 'CREMATORIO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '3.413,11', 'CAMPUS UNIVERSITARIO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '3.414,11', 'LOTEAMENTO RESIDENCIAL - CONDOMINIO UNIFAMILIAR', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '3.414,12', 'LOTEAMENTO RESIDENCIAL - CONDOMINIO PLURIFAMILIAR', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '3.414,20', 'SITIOS DE LAZER', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '3.414,30', 'DESMEMBRAMENTO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '3.414,40', 'PARCELAMENTO DO SOLO PARA FINS RESIDENCIAIS:LOTEAMENTOS OU DESMEMBRAMENTO-UNIFAMILIAR (INCLUSAO DA ETE, QUANDO COUBER, E LICENCAS CORRESPONDENTES)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '3.414,50', 'PARCELAMENTO SOLO FINS RESIDENCIAIS:LOTEAMENTO OU DESMEMBRAMENTO-PLURIFAMILIAR-PREDIOS DE APARTAMENTOS(INCLUS. ETE, QDO COUBER, E SUAS LICENCAS)', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '3.414,60', 'CONDOMINIOS POR UNIDADE AUTONOMA FRACAO IDEAL- HORIZONTAL(INCLUSAO DA ETE, QUANDO COUBER)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '3.414,70', 'CONDOMINIOS POR UNIDADE AUTONOMA FRACAO IDEAL- VERTICAL - PREDIOS DE APARTAMENTOS- (INCLUSAO DA ETE, QUANDO COUBER)', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 32, '3.414,80', 'FRACIONAMENTO DE MATRICULA PARA FINS CARTORIAIS SEM INTERVENCAO', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '3.415,10', 'DISTRITO LOTEAMENTO INDUSTRIAL POLO INDUSTRIAL', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 19, '3.416,10', 'PARCELAMENTO DO SOLO RURAL PARA FINS DE REFORMA AGRARIA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.417,10', 'USOS DA FAIXA DE PRAIA', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 8, '3.417,20', 'MANEJO DE CONFLITOS DE URBANIZACAO, CAMPOS ARENOSOS E DUNAS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 27, '3.418,00', 'PLANO DIRETOR', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.419,10', 'ESTACIONAMENTO E MANUTENCAO DE VEICULOS RODOVIARIOS DE CARGA', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.419,20', 'ESTACIONAMENTO E MANUTENCAO DE VEICULOS RODOVIARIOS DE PASSAGEIROS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.419,30', 'ESTACIONAMENTO E MANUTENCAO DE VEICULOS RODOVIARIOS DE PASSEIO', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.420,00', 'BAR BOATE DANCETERIA CASA DE SHOWS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.421,00', 'LAVAGEM DE VEICULOS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 32, '3.422,00', 'FIXACAO DE PLACAS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.423,00', 'PRESTACAO DE SERVICOS DE MONTAGEM DE MAQUINAS APARELHOS UTENSILIOS PECAS ACESSORIOS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.424,00', 'MONTAGEM DE MAT ELETRICO ELETRONICO E EQUIP P COMUNICACAO INFORMATICA', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.425,00', 'MONTAGEM DE ARTEF DE MADEIRA (INCLUSIVE CARIMBOS)', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.426,00', 'MONTAGEM OU RECUPERACAO DE MOVEIS SEM TRATAMENTO DE SUPERFICIE E SEM PINTURA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.427,00', 'ESCRITORIO', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.430,00', 'BENEFICIAMENTO DE SEMENTES COM UTILIZACAO DE AGROTOXICOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.440,00', 'CENTRO DE TREINAMENTO DE COMBATE A INCENDIO', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.451,00', 'RODOVIA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.451,10', 'RODOVIA MUNICIPAL', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 13, '3.451,20', 'PONTE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 13, '3.451,30', 'VIADUTO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.452,00', 'FERROVIA METROVIA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 13, '3.452,10', 'RAMAL FERROVIARIO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.453,00', 'HIDROVIA CANAL DE NAVEGACAO BARRAGEM ECLUSA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.454,00', 'METROPOLITANOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.455,00', 'ESTACIONAMENTO COM MANUTENCAO DE VEICULOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 13, '3.457,00', 'OBRAS DE URBANIZACAO (MURO CALCADA ACESSO ETC) E VIA URBANA (ABERTURA, CONSERVACAO, REPARACAO OU AMPLIACAO)', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 5, '3.458,10', 'BARRAGENS DE SANEAMENTO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 28, '3.458,20', 'GERACAO DE HIDROELETRICIDADE', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '3.458,30', 'BARRAGEM PARA USO MULTIPLO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.459,00', 'SISTEMA PARA CONTROLE DE ENCHENTES (DIQUE BARRAGEM BACIA DE ARMAZENAMENTO POLDER ETC)', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 5, '3.460,00', 'ACUDE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.461,00', 'ABERTURA DE BARRAS, EMBOCADURAS, CANAIS (EXCETO NAVEGACAO)', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 13, '3.462,00', 'CANALIZACAO PARA DRENAGEM PLUVIAL URBANA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 13, '3.463,00', 'CANALIZACAO DE CURSOS D\'AGUA NATURAL (EXCETO ATIVIDADES AGROPECUARIAS)', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 13, '3.463,10', 'RETIFICACAO/DESVIO DE CURSO D?AGUA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.464,10', 'PONTES', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.464,20', 'VIADUTO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.465,31', 'EDIFICIOS RESIDENCIAIS ( EXCETO LOTEAMENTOS E CONDOMINIOS)', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.465,90', 'CONSTRUCAO CIVIL GENERICA', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 28, '3.510,10', 'GERACAO DE TERMOELETRICIDADE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 28, '3.510,11', 'GERACAO DE TERMOELETRICIDADE A PARTIR DE GAS NATURAL', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 28, '3.510,12', 'GERACAO DE TERMOELETRICIDADE A PARTIR DE BIOMASSA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 28, '3.510,13', 'GERACAO DE TERMOELETRICIDADE A PARTIR DE FONTE FOSSIL', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.510,21', 'LINHAS DE DISTRIBUICAO DE ENERGIA ELETRICA (ATE 34,5KV)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.510,22', 'TRANSMISSAO DE ENERGIA ELETRICA (>34,5KV)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.510,23', 'SISTEMAS DE TRANSMISSAO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 28, '3.510,30', 'GERACAO DE ENERGIA A PARTIR DE FONTE EOLICA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.510,40', 'SUBESTACAO DE ENERGIA ELETRICA', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 28, '3.510,50', 'GERACAO DE ENERGIA A PARTIR DE FONTE SOLAR', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 1, '3.511,10', 'SISTEMA DE ABASTECIMENTO DE AGUA COM BARRAGEM', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 27, '3.511,20', 'SISTEMA DE ABASTECIMENTO DE AGUA SEM BARRAGEM', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 33, '3.512,10', 'SISTEMAS DE ESGOTAMENTO SANITARIO -SES', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 27, '3.512,20', 'TRONCOS COLETORES E EMISSARIOS DE ESGOTO DOMESTICO', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.512,30', 'REDE DE ESGOTO DOMESTICO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 33, '3.512,40', 'SISTEMA DE TRATAMENTO DE RESIDUOS ORIUNDOS DE LIMPA FOSSA E OU BANHEIRO QUIMICO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 33, '3.513,10', 'COLETA/ TRATAMENTO CENTRALIZADO DE EFLUENTES LIQUIDOS INDUSTRIAIS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 35, '3.513,20', 'APLICACAO DE EFLUENTE INDUSTRIAL TRATADO EM SOLO AGRICOLA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 13, '3.514,10', 'LIMPEZA DE CANAIS (SEM MATERIAL MINERAL)', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 16, '3.514,20', 'DESASSOREAMENTO DE CURSOS D\'AGUA DORMENTE (EXCETO DE ATIVIDADES AGROPECUARIAS)', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 16, '3.514,21', 'DESASSOREAMENTO DE CURSOS D\'AGUA CORRENTE (EXCETO DE ATIVIDADES AGROPECUARIAS)', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '3.514,30', 'LIMPEZA DE CANAIS DE NAVEGACAO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.515,00', 'USO DE HERBICIDAS EM AREAS INDUSTRIAIS (CAPINA QUIMICA)', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 30, '3.541,10', 'CENTRAL TRIAGEM E COMPOSTAGEM DE RSU COM ESTACAO DE TRANSBORDO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 30, '3.541,11', 'CENTRAL TRIAGEM DE RSU COM ESTACAO DE TRANSBORDO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 30, '3.541,12', 'CENTRAL DE RECEBIMENTO DE RESIDUOS DE PODA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 30, '3.541,20', 'ESTACAO DE TRANSBORDO DE RSU', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 30, '3.541,30', 'ATERRO SANITARIO COM CENTRAL DE TRIAGEM DE RSU', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 30, '3.541,31', 'ATERRO SANITARIO COM CENTRAL DE TRIAGEM E COMPOSTAGEM DE RSU', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 30, '3.541,32', 'ATERRO SANITARIO DE RSU', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 30, '3.541,50', 'USINAS DE COMPOSTAGEM DE RSU', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 30, '3.541,60', 'INCINERACAO DE RSU', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 30, '3.541,70', 'OUTRA FORMA DE DESTINACAO DE RSU COM ATERRO, NAO ESPECIFICADA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 30, '3.541,71', 'OUTRA FORMA DE DESTINACAO DE RSU SEM ATERRO, NAO ESPECIFICADA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 17, '3.541,80', 'REMEDIACAO DE AREA DEGRADADA POR DISPOSICAO DE RSU', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 17, '3.541,90', 'MONITORAMENTO DE AREA REMEDIADA POR DISPOSICAO DE RSU', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 29, '3.543,10', 'ATERRO DE RSSS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 29, '3.543,11', 'ATERRO COM AUTOCLAVAGEM DE RSSS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 29, '3.543,12', 'ATERRO COM MICROONDAS DE RSSS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 29, '3.543,13', 'ATERRO COM OUTRO TRATAMENTO DE RSSS, NAO ESPECIFICADO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 29, '3.543,20', 'AUTOCLAVAGEM DE RSSS COM ENTREPOSTO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 27, '3.543,22', 'CENTRAIS DE TRIAGEM SEM ATERRO DE RESIDUO SOLIDO URBANO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 29, '3.543,30', 'MICROONDAS DE RSSS COM ENTREPOSTO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 29, '3.543,40', 'INCINERACAO DE RSSS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 29, '3.543,50', 'OUTRO TRATAMENTO DE RSSS, NAO ESPECIFICADO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.543,60', 'ENTREPOSTO DE RSSS', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 29, '3.543,70', 'OUTRA FORMA DE DESTINACAO DE RSSS COM ATERRO NAO ESPECIFICADA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 29, '3.543,71', 'OUTRA FORMA DE DESTINACAO DE RSSS SEM ATERRO, NAO ESPECIFICADA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 17, '3.543,80', 'REMEDIACAO DE AREA DEGRADADA POR DISPOSICAO DE RSSS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 17, '3.543,90', 'MONITORAMENTO DE AREA REMEDIADA POR DISPOSICAO DE RSSS', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 34, '3.544,10', 'ATERRO DE RSCC', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 34, '3.544,11', 'ATERRO DE RSCC COM BENEFICIAMENTO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 34, '3.544,20', 'CENTRAL DE TRIAGEM COM BENEFICIAMENTO DE RSCC', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 34, '3.544,21', 'CENTRAL DE TRIAGEM E ATERRO DE RSCC COM BENEFICIAMENTO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 34, '3.544,22', 'CENTRAL DE TRIAGEM DE RSCC', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 34, '3.544,23', 'CENTRAL DE TRIAGEM COM ATERRO DE RSCC', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 34, '3.544,30', 'ESTACAO DE TRANSBORDO DE RSCC', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 34, '3.544,31', 'ESTACAO DE TRANSBORDO DE RSCC COM BENEFICIAMENTO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 34, '3.544,40', 'OUTRA FORMA DE DESTINACAO DE RSCC COM BENEFICIAMENTO NAO ESPECIFICADA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 34, '3.544,41', 'OUTRA FORMA DE DESTINACAO DE RSCC SEM BENEFICIAMENTO NAO ESPECIFICADA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 17, '3.544,50', 'REMEDIACAO DE AREA DEGRADADA POR DISPOSICAO DE RSCC', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 17, '3.544,60', 'MONITORAMENTO DE AREA REMEDIADA POR DISPOSICAO DE RSCC', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.545,00', 'CLASSIFICACAO SELECAO DE RSU ORIUNDO DE COLETA SELETIVA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '3.550,20', 'RECUPERACAO DE AREA DEGRADADA POR RESIDUO SOLIDO URBANO, SEM USO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '3.550,40', 'ENCERRAMENTO DE ATIVIDADES EM UNID DE DESTINACAO FINAL DE RSU', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 29, '3.560,20', 'TRATAMENTO DE RESIDUOS SOLIDOS DE SERVICOS DE SAUDE', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 16, '3.570,00', 'DESTINACAO DE RESIDUOS SOLIDOS PROVENIENTES DE FOSSAS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 2, '4.110,00', 'COMERCIO DE PRODUTOS QUIMICOS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.110,10', 'COMERCIO DE PRODUTOS QUIMICOS COM MANIPULACAO', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.110,20', 'COMERCIO DE PRODUTOS QUIMICOS SEM MANIPULACAO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.111,00', 'DISTRIBUIDORA DEPOSITO DE PRODUTOS QUIMICOS, FARMACEUTICOS E OU FERTILIZANTES', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.130,30', 'DISTRIBUIDORAS DE PRODUTOS ALIMENTICIOS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.130,90', 'DISTRIBUIDORAS DE PRODUTOS EM GERAL NAO ESPECIFICADOS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.140,00', 'SHOPPING CENTER SUPERMERCADO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.170,00', 'COMERCIO EM GERAL', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.170,10', 'COMERCIO DE CARNES', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 25, '4.710,10', 'TRANSPORTE RODOVIARIO DE PRODUTOS E OU RESIDUOS PERIGOSOS', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 25, '4.710,11', 'COLETA E TRANSPORTE DE OLEO LUBRIFICANTE USADO CONTAMINADO', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 25, '4.710,20', 'TRANSPORTE FERROVIARIO DE PRODUTOS E OU RESIDUOS PERIGOSOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 25, '4.710,30', 'TRANSPORTE HIDROVIARIO DE PRODUTOS E OU RESIDUOS PERIGOSOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '4.711,10', 'TRANSPORTE POR OLEODUTOS GASODUTOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '4.711,20', 'TRANSPORTE POR MINERODUTOS', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 26, '4.716,00', 'TRANSPORTE DE CARGA EQUIPAMENTO DE GRANDE PORTE', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 13, '4.720,10', 'ATRACADOURO PIER TRAPICHE', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.720,20', 'MARINA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 13, '4.720,30', 'ANCORADOURO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '4.720,40', 'MOLHE DIQUE QUEBRA - MAR', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '4.720,50', 'PORTO COMPLEXO PORTUARIO TERMINAL DE CARGA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.730,10', 'HELIPONTO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '4.730,20', 'TELEFERICO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '4.730,30', 'AERODROMO AEROPORTO HELIPORTO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.730,40', 'TERMINAL DE MINERIOS', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.730,41', 'TERMINAL DE CARVAO', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.730,50', 'TERMINAL DE PETROLEO E DERIVADOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.730,60', 'TERMINAL DE PRODUTOS QUIMICOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 25, '4.740,10', 'COLETA E TRANSPORTE DE RESIDUO CLASSE II', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 25, '4.740,40', 'TRANSPORTE DE EQUIPAMENTOS DE GRANDE PORTE', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.750,10', 'DEPOSITOS DE GLP (EM BOTIJOES, SEM MANIPULACAO, CODIGO ONU 1075)', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.750,20', 'DEPOSITOS DE AGROTOXICOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.750,21', 'ABASTECIMENTO PARA PULVERIZADORES AGRICOLAS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.750,30', 'DEPOSITOS DE EMBALAGENS VAZIAS DE AGROTOXICOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.750,40', 'DEPOSITOS DE EXPLOSIVOS', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 10, '4.750,51', 'POSTO DE ABASTECIMENTO PROPRIO COM TANQUES SUBTERRANEOS (DEPOSITO DE COMBUSTIVEIS)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 10, '4.750,52', 'POSTO DE ABASTECIMENTO PROPRIO COM TANQUES AEREOS (DEPOSITO DE COMBUSTIVEIS) > 15 M3', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 10, '4.750,53', 'POSTO DE ABASTECIMENTO PROPRIO COM TANQUES AEREOS (DEPOSITO DE COMBUSTIVEIS) <= 15 M3', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.750,70', 'COMPLEXO LOGISTICO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.750,90', 'DEPOSITO EM GERAL', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.751,10', 'DEPOSITO COMERCIO ATACADISTA DE COMBUSTIVEIS LIQUIDOS (BASES DE DISTRIBUICAO)', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.751,20', 'DEPOSITO COMERCIO ATACADISTA DE COMBUSTIVEIS GASOSOS (BASES DE DISTRIBUICAO)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.751,30', 'DEPOSITO COMERCIO VAREJISTA DE COMBUSTIVEIS (POSTO DE GASOLINA)', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 10, '4.751,40', 'TRANSPORTADOR- REVEDENDOR- RETALHISTA (TRR)', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '4.751,50', 'DEPOSITO COMERCIO DE OLEOS USADOS', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '4.810,00', 'SERVICOS DE COMUNICACOES', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '4.810,10', 'INSTALACAO DE LINHA TELEFONICA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '4.810,11', 'INSTALACAO DE LINHA TELEFONICA SUBFLUVIAL', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '4.811,00', 'INSTALACAO DE CABOS DE FIBRA OPTICA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 12, '4.812,00', 'REDE/ANTENA PARA TELEFONIA MOVEL / ESTACAO RADIO-BASE', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '510,00', 'PESQUISA MINERAL', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.110,00', 'HOTEL POUSADA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.130,00', 'RESTAURANTE / REFEITORIO / LANCHONETE / QUIOSQUE / TRAILER FIXO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '520,00', 'RECUPERACAO DE AREAS MINERADAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.210,00', 'SERVICOS DE REPARACAO E MANUTENCAO DE MAQUINAS/ APARELHOS/ UTENSILIOS/ PECAS/ ACESSORIOS', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.220,00', 'OFICINA MECANICA CENTRO DE DESMANCHE DE VEICULOS (CDV) CHAPEACAO PINTURA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.230,00', 'ESTOFARIA - REFORMAS DE ESTOFADOS EM GERAL ESTOFARIA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.290,00', 'SERVICOS DIVERSOS DE REPARACAO E CONSERVACAO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,01', 'LAVRA DE CALCARIO CAULIM FOSFATO - A CEU ABERTO E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,02', 'LAVRA DE CARVAO TURFA COMBUSTIVEIS MINERAIS - A CEU ABERTO E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,03', 'LAVRA DE MINERIO METALICO (OBRE OURO CHUMBO ETC) - A CEU ABERTO E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,04', 'LAVRA DE GEMAS (AGATA AMETISTA ETC) - A CEU ABERTO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,05', 'LAVRA DE ROCHA ORNAMENTAL- A CEU ABERTO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,06', 'LAVRA DE ROCHA PARA USO IMEDIATO NA CONSTRUCAO CIVIL - A CEU ABERTO, COM USO DE EXPLOSIVOS, COM BRITAGEM E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,07', 'LAVRA DE ROCHA PARA USO IMEDIATO NA CONSTRUCAO CIVIL - A CEU ABERTO, SEM USO DE EXPLOSIVOS, COM BRITAGEM E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,08', 'LAVRA DE ROCHA PARA USO IMEDIATO NA CONSTRUCAO CIVIL- A CEU ABERTO, COM USO DE EXPLOSIVOS, SEM BRITAGEM E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,09', 'LAVRA DE ROCHA PARA USO IMEDIATO NA CONSTRUCAO CIVIL- A CEU ABERTO. SEM USO DE EXPLOSIVOS, SEM BRITAGEM E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,10', 'LAVRA DE SAIBRO- A CEU ABERTO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,11', 'LAVRA DE ARGILA - A CEU ABERTO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,12', 'LAVRA DE AREIA E OU CASCALHO- A CEU ABERTO, EM RECURSO HIDRICO E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,13', 'LAVRA DE AREIA - A CEU ABERTO, FORA DE RECURSO HIDRICO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '530,14', 'LAVRA DE AREIA INDUSTRIAL- A CEU ABERTO, COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '531,50', 'LAVRA DE ROCHA ORNAMENTAL (GRANITO/BASALTO/TALCO/ETC) - A CEU ABERTO, COM BENEFICIAMENTO E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '531,60', 'LAVRA DE ROCHA PARA USO IMEDIATO NA CONSTRUCAO CIVIL - A CEU ABERTO, COM BENEFICIAMENTO E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '531,70', 'LAVRA DE AREIA INDUSTRIAL - A CEU ABERTO, COM BENEFICIAMENTO E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '532,50', 'LAVRA DE ROCHA ORNAMENTAL (GRANITO/BASALTO/TALCO/ETC) - A CEU ABERTO, SEM BENEFICIAMENTO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '532,60', 'LAVRA DE ROCHA PARA USO IMEDIATO EM CONSTRUCAO CIVIL - A CEU ABERTO, SEM BENEFICIAMENTO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '532,61', 'LAVRA DE GRANITOS PARA USO IMEDIATO EM CONSTRUCAO CIVIL - A CEU ABERTO, SEM BRITAGEM E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '532,62', 'LAVRA DE BASALTOS PARA USO IMEDIATO EM CONSTRUCAO CIVIL - A CEU ABERTO, SEM BRITAGEM E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '532,63', 'LAVRA DE ARENITO PARA USO IMEDIATO EM CONSTRUCAO CIVIL - A CEU ABERTO, COM BENEFICIAMENTO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '532,70', 'LAVRA ARTESANAL DE ROCHA PARA USO IMEDIATO EM CONSTRUCAO CIVIL - A CEU ABERTO, SEM BENEFICIAMENTO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '532,71', 'LAVRA ARTESANAL DE GRANITOSPARA USO IMEDIATO EM CONSTRUCAO CIVIL - A CEU ABERTO, COM BENEFICIAMENTO, SEM BRITAGEM E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '532,72', 'LAVRA ARTESANAL DE BASALTOS PARA USO IMEDIATO EM CONSTRUCAO CIVIL -A CEU ABERTO, COM BENEFICIAMENTO, SEM BRITAGEM E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '534,20', 'LAVRA DE AREIA - A CEU ABERTO, SEM BENEFICIAMENTO, FORA DE RECURSO HIDRICO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '534,30', 'LAVRA DE SAIBRO - A CEU ABERTO, SEM BENEFICIAMENTO, FORA DE RECURSO HIDRICO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '534,40', 'LAVRA DE ARGILA - A CEU ABERTO, SEM BENEFICIAMENTO, FORA DE RECURSO HIDRICO E COM RECUPERACAO DE AREA DEGRADADA', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '540,01', 'LAVRA DE AGUA MINERAL, SUBTERRANEA', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '540,02', 'LAVRA DE CARVAO TURFA COMBUSTIVEIS MINERAIS, SUBTERRANEA E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '540,03', 'LAVRA DE MINERIO METALICO (COBRE OURO CHUMBO ETC), SUBTERRANEA E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 6, '540,04', 'LAVRA DE GEMAS(AGATA AMETISTA ETC), SUBTERRANEA E COM RECUPERACAO DE AREA DEGRADADA', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 32, '5.410,10', 'SERVICOS DE LIMPEZA E DESINFECCAO DE RESERVATORIOS DE AGUA', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.410,90', 'SERVICOS DE LIMPEZA DE INSTALACOES EM GERAL', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 25, '550,00', 'DRAGAS', 'M?dio');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.610,00', 'ESCOLAS CRECHES', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 32, '5.710,10', 'LABORATORIO DE ANALISES AMBIENTAIS - CERTICADO DE CADASTRO DE LABORATORIO', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.710,20', 'LABORATORIO DE ANALISES FISICO-QUIMICAS CLINICAS TOXICOLOGICAS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.710,50', 'LABORATORIO FOTOGRAFICO', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.720,00', 'INSTITUICOES CIENTIFICAS E TECNOLOGICAS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 32, '5.730,10', 'CADASTRO DE AUDITOR AMBIENTAL', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '5.790,00', 'OUTROS SERVICOS TECNICOS NAO ESPECIFICADOS', 'Baixo');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '6.111,00', 'AREA DE LAZER (CAMPING BALNEARIO PARQUE TEMATICO)', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 14, '6.112,00', 'AUTODROMO KARTODROMO PISTA DE MOTOCROSS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '6.112,10', 'AUTODROMO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '6.112,20', 'KARTODROMO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '6.112,30', 'PISTA DE MOTOCROSS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '6.113,00', 'PARQUE DE EXPOSICOES PARQUE DE EVENTOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '6.114,00', 'MUSEU OCEANARIO ANFITEATRO ZOOLOGICO JARDIM BOTANICO', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '6.210,00', 'ESTABELECIMENTO PRISIONAL', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 20, '8.110,00', 'HOSPITAIS COM PROCEDIMENTOS COMPLEXOS', 'Alto');
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 20, '8.110,10', 'HOSPITAIS SEM PROCEDIMENTOS COMPLEXOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '8.111,00', 'CLINICAS MEDICAS COM PROCEDIMENTOS COMPLEXOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '8.111,10', 'CLINICAS MEDICAS SEM PROCEDIMENTOS COMPLEXOS', 'M?dio');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '8.210,00', 'HOSPITAIS CLINICAS VETERINARIAS', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 2 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 3 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 4 );
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 5 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '9.110,00', 'INSTITUICAO RELIGIOSA TEMPLO CAPELA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '9.210,10', 'CENTRO ESPORTIVO E OU RECREATIVO ESTADIO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 7, '9.211,00', 'HIPICA CANCHA RETA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '9.220,00', 'PISCINAS DE USO COLETIVO', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );
insert into atividadeimpacto values ( nextval('atividadeimpacto_am03_sequencial_seq'), 9, '9.230,00', 'SAUNA', 'Baixo');
insert into atividadeimpactoporte values ( nextval('atividadeimpactoporte_am04_sequencial_seq'), (select last_value from atividadeimpacto_am03_sequencial_seq), 1 );

/**
 * IPTU JAGUARAO TAXAS
 */
/**
 * Taxa de Lixo
 */
insert into db_sysfuncoes( codfuncao, nomefuncao, nomearquivo, obsfuncao, corpofuncao, triggerfuncao )
     select 174,'fc_iptu_taxalixo_jaguarao_2015' ,'iptu_taxalixo_jaguarao_2015.sql' ,'Fun??o de taxa de lixo para o c?lculo de 2015 de jaguarao' ,'' ,'0'
      where not exists (select 1 from db_sysfuncoes where codfuncao = 174);
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 174, 1 ,'iReceita' ,'int4' ,0 ,0 ,'0' ,'RECEITA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 174 and db42_ordem = 1 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 174, 2 ,'iAliquota' ,'numeric' ,0 ,0 ,'0' ,'ALIQUOTA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 174 and db42_ordem = 2 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 174, 3 ,'iHistCalc' ,'int4' ,0 ,0 ,'0' ,'HISTORICO DO CALCULO'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 174 and db42_ordem = 3 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 174, 4 ,'iPercIsen' ,'numeric' ,0 ,0 ,'0' ,'PERCENTUAL DE ISEN??O'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 174 and db42_ordem = 4 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 174, 5 ,'nValpar' ,'numeric' ,0 ,0 ,'0' ,'VALOR DA PARCELA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 174 and db42_ordem = 5 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 174, 6 ,'lRaise' ,'bool' ,0 ,0 ,'FALSE' ,'RAISE DEBUG'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 174 and db42_ordem = 6 );

/**
 * Taxa de limpeza
 */
insert into db_sysfuncoes( codfuncao, nomefuncao, nomearquivo, obsfuncao, corpofuncao, triggerfuncao )
     select 175,'fc_iptu_taxalimpeza_jaguarao_2015' ,'iptu_taxalimpeza_jaguarao_2015.sql' ,'Fun??o de taxa de limpeza para o c?lculo de 2015 de jaguarao' ,'' ,'0'
      where not exists (select 1 from db_sysfuncoes where codfuncao = 175);
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 175, 1 ,'iReceita' ,'int4' ,0 ,0 ,'0' ,'RECEITA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 175 and db42_ordem = 1 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 175, 2 ,'iAliquota' ,'numeric' ,0 ,0 ,'0' ,'ALIQUOTA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 175 and db42_ordem = 2 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 175, 3 ,'iHistCalc' ,'int4' ,0 ,0 ,'0' ,'HISTORICO DO CALCULO'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 175 and db42_ordem = 3 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 175, 4 ,'iPercIsen' ,'numeric' ,0 ,0 ,'0' ,'PERCENTUAL DE ISEN??O'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 175 and db42_ordem = 4 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 175, 5 ,'nValpar' ,'numeric' ,0 ,0 ,'0' ,'VALOR DA PARCELA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 175 and db42_ordem = 5 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 175, 6 ,'lRaise' ,'bool' ,0 ,0 ,'FALSE' ,'RAISE DEBUG'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 175 and db42_ordem = 6 );

/**
 * Taxa de manuten??o cadastral
 */
insert into db_sysfuncoes( codfuncao, nomefuncao, nomearquivo, obsfuncao, corpofuncao, triggerfuncao )
     select 176,'fc_iptu_taxamanutencaocadastral_jaguarao_2015' ,'iptu_taxamanutencaocadastral_jaguarao_2015.sql' ,'Fun??o de taxa de manuten??o de cadastro para o c?lculo de 2015 de jaguarao' ,'' ,'0'
      where not exists (select 1 from db_sysfuncoes where codfuncao = 176);
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 176, 1 ,'iReceita' ,'int4' ,0 ,0 ,'0' ,'RECEITA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 176 and db42_ordem = 1 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 176, 2 ,'iAliquota' ,'numeric' ,0 ,0 ,'0' ,'ALIQUOTA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 176 and db42_ordem = 2 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 176, 3 ,'iHistCalc' ,'int4' ,0 ,0 ,'0' ,'HISTORICO DO CALCULO'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 176 and db42_ordem = 3 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 176, 4 ,'iPercIsen' ,'numeric' ,0 ,0 ,'0' ,'PERCENTUAL DE ISEN??O'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 176 and db42_ordem = 4 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 176, 5 ,'nValpar' ,'numeric' ,0 ,0 ,'0' ,'VALOR DA PARCELA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 176 and db42_ordem = 5 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 176, 6 ,'lRaise' ,'bool' ,0 ,0 ,'FALSE' ,'RAISE DEBUG'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 176 and db42_ordem = 6 );

/**
 * Taxa de aforamento
 */
insert into db_sysfuncoes( codfuncao ,nomefuncao ,nomearquivo ,obsfuncao ,corpofuncao ,triggerfuncao )
     select 177,'fc_iptu_taxaaforamento_jaguarao_2015' ,'iptu_taxaaforamento_jaguarao_2015.sql' ,'Fun??o de taxa de aforamento para o c?lculo de 2015 de jaguarao' ,'' ,'0'
      where not exists (select 1 from db_sysfuncoes where codfuncao = 177);
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 177, 1 ,'iReceita' ,'int4' ,0 ,0 ,'0' ,'RECEITA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 177 and db42_ordem = 1 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 177, 2 ,'iAliquota' ,'numeric' ,0 ,0 ,'0' ,'ALIQUOTA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 177 and db42_ordem = 2 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 177, 3 ,'iHistCalc' ,'int4' ,0 ,0 ,'0' ,'HISTORICO DO CALCULO'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 177 and db42_ordem = 3 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 177, 4 ,'iPercIsen' ,'numeric' ,0 ,0 ,'0' ,'PERCENTUAL DE ISEN??O'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 177 and db42_ordem = 4 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 177, 5 ,'nValpar' ,'numeric' ,0 ,0 ,'0' ,'VALOR DA PARCELA'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 177 and db42_ordem = 5 );
insert into db_sysfuncoesparam( db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao )
     select nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 177, 6 ,'lRaise' ,'bool' ,0 ,0 ,'FALSE' ,'RAISE DEBUG'
      where not exists (select 1 from db_sysfuncoesparam where db42_funcao = 177 and db42_ordem = 6 );

----------------------------------------------------------------------------------------
------------------------------ FIM TRIBUTARIO ------------------------------------------
----------------------------------------------------------------------------------------


----------------------------------------------------------------------------------------
------------------------------- CONFIGURACOES ------------------------------------------
----------------------------------------------------------------------------------------

DO
$$
BEGIN

	IF NOT EXISTS (SELECT 1 FROM pg_class WHERE relname = 'db_auditoria_migracao_depara_codarq_codmod_id_modulo' AND relkind = 'r') THEN

		CREATE TABLE configuracoes.db_auditoria_migracao_depara_codarq_codmod_id_modulo AS
		SELECT codarq,
		    codmod,
		    nomemod,
		    CASE
		        WHEN id_modulo IS NOT NULL
		            THEN id_modulo
		        WHEN id_modulo IS NULL AND codmod = 7
		            THEN 1
		        WHEN id_modulo IS NULL AND codmod = 19
		            THEN 381
		        WHEN id_modulo IS NULL AND codmod = 20
		            THEN 633
		        WHEN id_modulo IS NULL AND codmod IN (29, 33)
		            THEN 2323
		        WHEN id_modulo IS NULL AND codmod = 46
		            THEN 1985522
		        WHEN id_modulo IS NULL AND codmod = 57
		            THEN 7081
		        WHEN id_modulo IS NULL AND codmod = 58
		            THEN 1100747
		        WHEN id_modulo IS NULL AND codmod = 61
		            THEN 7159
		        WHEN id_modulo IS NULL AND codmod = 69
		            THEN 8251
		        ELSE 1 /* configuracoes */
		        END AS id_modulo
		FROM (
		    SELECT DISTINCT a.codarq,
		        am.codmod,
		        regexp_replace(lower(to_ascii(m.nomemod)), '[^A-Za-z]', '', 'g') AS nomemod,
		        (
		            SELECT id_item
		            FROM db_modulos
		            WHERE regexp_replace(lower(to_ascii(descr_modulo)), '[^A-Za-z]', '', 'g') ~ regexp_replace(lower(to_ascii(m.nomemod)), '[^A-Za-z]', '', 'g') OR regexp_replace(lower(to_ascii(nome_modulo)), '[^A-Za-z]', '', 'g') ~ regexp_replace(lower(to_ascii(m.nomemod)), '[^A-Za-z]', '', 'g') limit 1
		            ) AS id_modulo
		    FROM db_sysarquivo a
		    INNER JOIN db_sysarqmod am ON am.codarq = a.codarq
		    INNER JOIN db_sysmodulo m ON m.codmod = am.codmod
		    ) AS x
		ORDER BY codmod,
	    codarq,
	    id_modulo;
	END IF;

	PERFORM CASE
	        WHEN last_value < 2000000
	            THEN setval('db_itensmenu_id_item_seq', 2000000, false)
	        ELSE 0
	        END
	FROM db_itensmenu_id_item_seq;

	PERFORM CASE
	        WHEN max(id_item) >= 2000000
	            THEN setval('db_itensmenu_id_item_seq', max(id_item))
	        ELSE 0
	        END
	FROM db_itensmenu;

	-- INSERE MENU CASO AINDA NAO EXISTA
	IF NOT EXISTS (SELECT 1 FROM db_itensmenu WHERE descricao = 'Logs (acount) Antigo' AND help = 'Logs (acount) Antigo') THEN
		PERFORM fc_putsession('db_id_item_log', (
		            SELECT nextval('db_itensmenu_id_item_seq')
		            )::TEXT);

		INSERT INTO db_itensmenu
		VALUES (
		    fc_getsession('db_id_item_log')::INT,
		    'Logs (acount) Antigo',
		    'Logs (acount) Antigo',
		    NULL,
		    1,
		    '1',
		    'Logs (acount) Antigo',
		    true
		    );

		INSERT INTO db_menu
		VALUES (
		    31,
		    fc_getsession('db_id_item_log')::INT,
		    999,
		    1
		    );
	END IF;

	IF NOT EXISTS (SELECT 1 FROM pg_class WHERE relname = 'db_auditoria_migracao_depara_codmod_id_modulo' AND relkind = 'r') THEN

		CREATE TABLE configuracoes.db_auditoria_migracao_depara_codmod_id_modulo AS
		SELECT *,
		    nextval('db_itensmenu_id_item_seq')::INT AS id_item
		FROM (
		    SELECT DISTINCT codmod,
		        nomemod,
		        id_modulo
		    FROM configuracoes.db_auditoria_migracao_depara_codarq_codmod_id_modulo
		    ORDER BY codmod,
		        id_modulo
		    ) AS x;

		INSERT INTO db_itensmenu
		SELECT a.id_item,
		    m.nome_modulo,
		    m.descr_modulo,
		    NULL,
		    1,
		    '1',
		    m.descr_modulo,
		    true
		FROM configuracoes.db_auditoria_migracao_depara_codmod_id_modulo a
		INNER JOIN configuracoes.db_modulos m ON m.id_item = a.id_modulo;

		INSERT INTO db_menu
		SELECT fc_getsession('db_id_item_log')::INT,
		    id_item,
		    999,
		    1
		FROM configuracoes.db_auditoria_migracao_depara_codmod_id_modulo;

		ALTER TABLE configuracoes.db_auditoria_migracao_depara_codarq_codmod_id_modulo ADD id_item INT;

		UPDATE configuracoes.db_auditoria_migracao_depara_codarq_codmod_id_modulo
		SET id_item = configuracoes.db_auditoria_migracao_depara_codmod_id_modulo.id_item
		FROM configuracoes.db_auditoria_migracao_depara_codmod_id_modulo
		WHERE configuracoes.db_auditoria_migracao_depara_codarq_codmod_id_modulo.codmod = configuracoes.db_auditoria_migracao_depara_codmod_id_modulo.codmod AND configuracoes.db_auditoria_migracao_depara_codarq_codmod_id_modulo.id_modulo = configuracoes.db_auditoria_migracao_depara_codmod_id_modulo.id_modulo;

	END IF;

END;
$$ LANGUAGE plpgsql;

----------------------------------------------------------------------------------------
------------------------------- CONFIGURACOES ------------------------------------------

update db_itensmenu set id_item = 10054 , descricao = 'Tipo de Hora de Trabalho' , help = 'Tipo de Hora de Trabalho' , funcao = 'edu1_tipohoratrabalho001.php' , itemativo = '1' , manutencao = '1' , desctec = 'Tipo de Hora de Trabalho' , libcliente = 'true' where id_item = 10054;

create table w_atividade_agendaatividade_2751 as
      select distinct ed231_i_referencia as turnoreferente,
             ed22_i_codigo               as rechumanoativ,
             ed33_rechumanoescola        as rechumanoescola,
             min(ed17_h_inicio)          as horainicio,
             max(ed17_h_fim)             as horafim,
             ed33_i_diasemana            as diasemana,
             case
               when ed01_c_regencia    = 'S'
                and ed01_c_efetividade = 'PROF'
                    then 'S'
                    else 'N'
                end as regente
        from rechumanoativ
             inner join atividaderh       on ed01_i_codigo        = ed22_i_atividade
             inner join rechumanohoradisp on ed33_rechumanoescola = ed22_i_rechumanoescola
             inner join periodoescola     on ed17_i_codigo        = ed33_i_periodo
             inner join turno             on ed15_i_codigo        = ed17_i_turno
             inner join turnoreferente    on ed231_i_turno        = ed15_i_codigo
       where not exists( select 1
                           from agendaatividade
                          where ed129_rechumanoativ = ed22_i_codigo )
         and ed33_i_codigo is not null
         and ed33_ativo    is true
       group by turnoreferente, rechumanoativ, rechumanoescola, diasemana, regente
       order by ed33_rechumanoescola, diasemana;


create table w_rechumano_migrados_2751 as
      select distinct ed75_i_codigo as rechumanoescola,
             ed75_i_rechumano       as rechumano,
             ed75_i_escola          as escola
        from rechumanoescola
             inner join w_atividade_agendaatividade_2751 on rechumanoescola = rechumanoescola;


insert into agendaatividade
     select nextval('agendaatividade_ed129_codigo_seq'),
            1,
            diasemana,
            turnoreferente,
            rechumanoativ,
            horainicio,
            horafim
       from w_atividade_agendaatividade_2751;


create table w_bkp_horariosregencia_nao_regentes_2751 as
      select distinct rechumanohoradisp.*
        from rechumanohoradisp
             inner join w_atividade_agendaatividade_2751 on rechumanoescola = ed33_rechumanoescola
       where not exists( select 1
                           from rechumanoativ
                                inner join atividaderh on ed01_i_codigo = ed22_i_atividade
                          where ed22_i_rechumanoescola = ed33_rechumanoescola
                            and ed01_c_regencia        = 'S'
                            and ed01_c_efetividade     = 'PROF' );

delete from rechumanohoradisp
      using w_bkp_horariosregencia_nao_regentes_2751
      where w_bkp_horariosregencia_nao_regentes_2751.ed33_i_codigo = rechumanohoradisp.ed33_i_codigo;

create table w_bkp_horariosregencia_sem_atividade_2751 as
       select *
         from rechumanohoradisp
        where not exists( select 1
                            from rechumanoativ
                           where ed22_i_rechumanoescola = ed33_rechumanoescola );

delete from rechumanohoradisp
      using w_bkp_horariosregencia_sem_atividade_2751
      where w_bkp_horariosregencia_sem_atividade_2751.ed33_i_codigo = rechumanohoradisp.ed33_i_codigo;

