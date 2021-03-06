----------------------------------------------------
---- TIME C
----------------------------------------------------

----------------------------------------------------
---- Tarefa: A1023
----------------------------------------------------

ALTER TABLE regencia ADD COLUMN ed59_procedimento int8;

ALTER TABLE regencia add CONSTRAINT regencia_procedimento_fk FOREIGN KEY (ed59_procedimento) REFERENCES procedimento;

with novos_procedimentos as (
  select ed220_i_procedimento, ed59_i_codigo
    from regencia
    inner join turmaserieregimemat on turmaserieregimemat.ed220_i_turma = regencia.ed59_i_turma
    inner join serieregimemat      on serieregimemat.ed223_i_codigo     = turmaserieregimemat.ed220_i_serieregimemat
    where serieregimemat.ed223_i_serie = regencia.ed59_i_serie
)
update regencia
  set ed59_procedimento = novos_procedimentos.ed220_i_procedimento
  from novos_procedimentos
  where novos_procedimentos.ed59_i_codigo = regencia.ed59_i_codigo;

ALTER TABLE regencia ALTER COLUMN ed59_procedimento SET NOT NULL;

----------------------------------------------------
---- Tarefa: 10658
----------------------------------------------------
alter table tfd_veiculodestino drop column tf18_c_localsaida;


----------------------------------------------------
---- Tarefa: 102508
----------------------------------------------------
update undmedhorario
    set sd30_d_valinicial = min
   from (select min(sd23_d_agendamento), sd23_i_undmedhor from agendamentos group by sd23_i_undmedhor) as x
  where sd30_d_valinicial is null
    and sd30_i_codigo = sd23_i_undmedhor;

update undmedhorario
   set sd30_d_valinicial = now()::date
 where sd30_d_valinicial is null;


----------------------------------------------------
---- FIM TIME C
----------------------------------------------------

----------------------------------------------------
---- TRIBUTARIO
----------------------------------------------------
insert into iptucadlogcalc(j62_codigo, j62_descr, j62_erro) values (106, 'Sem valor informado para caracterÝstica ', true);
insert into iptucadlogcalc(j62_codigo, j62_descr, j62_erro) values (107, 'Valor do m2 da construšŃo nŃo encontrado, verifique caracterÝsticas da construšŃo.', true);

INSERT INTO db_sysfuncoes (codfuncao, nomefuncao, obsfuncao, corpofuncao, triggerfuncao, nomearquivo) VALUES (165, 'fc_iptu_taxalimpeza_osorio',      'calculo da taxa de limpeza', 'a', '0', 'iptu_taxalimpeza_osorio.sql');

SELECT setval('db_sysfuncoesparam_db42_sysfuncoesparam_seq', (SELECT MAX(db42_sysfuncoesparam) FROM db_sysfuncoesparam));

INSERT INTO db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) VALUES ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 165, 1, 'iReceita',      'int4',    0, 0, '0',     'RECEITA');
INSERT INTO db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) VALUES ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 165, 2, 'iAliquota',     'numeric', 0, 0, '0',     'ALIQUOTA');
INSERT INTO db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) VALUES ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 165, 3, 'iHistCalc',     'int4',    0, 0, '0',     'HISTORICO DE CALCULO');
INSERT INTO db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) VALUES ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 165, 4, 'iPercIsen',     'numeric', 0, 0, '0',     'PERCENTUAL DE ISENCAO');
INSERT INTO db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) VALUES ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 165, 5, 'nValpar',       'numeric', 0, 0, '0',     'VALOR POR PARAMETRO');
INSERT INTO db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) VALUES ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 165, 6, 'bRaise',        'bool',    0, 0, 'FALSE', 'DEBUG');

-- Criando  sequences
CREATE SEQUENCE condicionante_am10_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE condicionanteatividadeimpacto_am11_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE tipolicenca_am09_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- TABELAS E ESTRUTURA
CREATE TABLE condicionante(
am10_sequencial   int4 NOT NULL default 0,
am10_descricao    text NOT NULL ,
am10_padrao   bool NOT NULL default 'false',
am10_tipolicenca    int4 default 0,
CONSTRAINT condicionante_sequ_pk PRIMARY KEY (am10_sequencial));

CREATE TABLE condicionanteatividadeimpacto(
am11_sequencial   int4 NOT NULL default 0,
am11_condicionante    int4 NOT NULL default 0,
am11_atividadeimpacto   int4 default 0,
CONSTRAINT condicionanteatividadeimpacto_sequ_pk PRIMARY KEY (am11_sequencial));

CREATE TABLE tipolicenca(
am09_sequencial   int4 NOT NULL default 0,
am09_descricao    varchar(50) ,
CONSTRAINT tipolicenca_sequ_pk PRIMARY KEY (am09_sequencial));

-- CHAVE ESTRANGEIRA
ALTER TABLE condicionante
ADD CONSTRAINT condicionante_tipolicenca_fk FOREIGN KEY (am10_tipolicenca)
REFERENCES tipolicenca;

ALTER TABLE condicionanteatividadeimpacto
ADD CONSTRAINT condicionanteatividadeimpacto_condicionante_fk FOREIGN KEY (am11_condicionante)
REFERENCES condicionante;

ALTER TABLE condicionanteatividadeimpacto
ADD CONSTRAINT condicionanteatividadeimpacto_atividadeimpacto_fk FOREIGN KEY (am11_atividadeimpacto)
REFERENCES atividadeimpacto;

ALTER TABLE licencaempreendimento
ADD CONSTRAINT licencaempreendimento_tipolicenca_fk FOREIGN KEY (am08_tipolicenca)
REFERENCES tipolicenca;

CREATE UNIQUE INDEX condicionanteatividadeimpacto_condicionante_atividadeimpacto_in ON condicionanteatividadeimpacto(am11_condicionante,am11_atividadeimpacto);

insert into tipolicenca values (1, 'PrÚvia');
insert into tipolicenca values (2, 'InstalašŃo');
insert into tipolicenca values (3, 'OperašŃo');

CREATE SEQUENCE parecertecnico_am08_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE parecertecnicocondicionante_am12_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- TABELAS E ESTRUTURA
-- Mˇdulo: meioambiente
CREATE TABLE parecertecnico(
am08_sequencial   int4 NOT NULL default 0,
am08_empreendimento   int4 NOT NULL default 0,
am08_protprocesso   int4 NOT NULL default 0,
am08_pareceranterior    int4  default 0,
am08_dataemissao    date NULL default null,
am08_datavencimento   date NULL default null,
am08_tipolicenca    int4 NOT NULL default 0,
am08_datageracao    date NOT NULL default null,
am08_favoravel    bool NOT NULL default 'f',
am08_observacao   text ,
am08_arquivo    oid,
CONSTRAINT parecertecnico_sequ_pk PRIMARY KEY (am08_sequencial));

-- Mˇdulo: meioambiente
CREATE TABLE parecertecnicocondicionante(
am12_sequencial   int4 NOT NULL default 0,
am12_parecertecnico   int4 NOT NULL default 0,
am12_condicionante    int4 default 0,
CONSTRAINT parecertecnicocondicionante_sequ_pk PRIMARY KEY (am12_sequencial));

-- CHAVE ESTRANGEIRA
ALTER TABLE parecertecnico
ADD CONSTRAINT parecertecnico_protprocesso_fk FOREIGN KEY (am08_protprocesso)
REFERENCES protprocesso;

ALTER TABLE parecertecnico
ADD CONSTRAINT parecertecnico_tipolicenca_fk FOREIGN KEY (am08_tipolicenca)
REFERENCES tipolicenca;

ALTER TABLE parecertecnico
ADD CONSTRAINT parecertecnico_empreendimento_fk FOREIGN KEY (am08_empreendimento)
REFERENCES empreendimento;

ALTER TABLE parecertecnicocondicionante
ADD CONSTRAINT parecertecnicocondicionante_parecertecnico_fk FOREIGN KEY (am12_parecertecnico)
REFERENCES parecertecnico;

ALTER TABLE parecertecnicocondicionante
ADD CONSTRAINT parecertecnicocondicionante_condicionante_fk FOREIGN KEY (am12_condicionante)
REFERENCES condicionante;

-- INDICES
CREATE UNIQUE INDEX parecertecnico_sequencial_in ON parecertecnico(am08_sequencial);


-- Criando  sequences
CREATE SEQUENCE licencaempreendimento_am13_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;
-- TABELAS E ESTRUTURA

DROP TABLE IF EXISTS licencaempreendimento CASCADE;

-- Mˇdulo: meioambiente
CREATE TABLE licencaempreendimento(
am13_sequencial   int4 NOT NULL default 0,
am13_parecertecnico   int4 NOT NULL default 0,
am13_arquivo    oid ,
CONSTRAINT licencaempreendimento_sequ_pk PRIMARY KEY (am13_sequencial));
-- CHAVE ESTRANGEIRA
ALTER TABLE licencaempreendimento
ADD CONSTRAINT licencaempreendimento_parecertecnico_fk FOREIGN KEY (am13_parecertecnico)
REFERENCES parecertecnico;

----------------------------------------------------
---- FIM TRIBUTARIO
----------------------------------------------------

----------------------------------------------------
---- FOLHA
----------------------------------------------------

--97262
-- Drop da tabela
DROP TABLE IF EXISTS econsigmotivo CASCADE;

-- Drop do sequence
DROP SEQUENCE IF EXISTS econsigmotivo_rh147_sequencial_seq;

-- Cria a sequence
CREATE SEQUENCE econsigmotivo_rh147_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- Cria a tabela
CREATE TABLE econsigmotivo(
rh147_sequencial int4 NOT NULL default nextval('econsigmotivo_rh147_sequencial_seq'),
rh147_motivo varchar(100) NOT NULL,
CONSTRAINT econsigmotivo_sequ_pk PRIMARY KEY (rh147_sequencial));

-- Cria o Ýndice
CREATE INDEX econsigmotivo_sequencial_in ON econsigmotivo(rh147_sequencial);

-- Cria a coluna
ALTER TABLE econsigmovimentoservidor ADD COLUMN rh134_econsigmotivo int4;

-- Altera a tabela econsigmovimentoservidor para receber mais um campo
ALTER TABLE econsigmovimentoservidor
ADD CONSTRAINT econsigmovimentoservidor_econsigmotivo_fk FOREIGN KEY (rh134_econsigmotivo)
REFERENCES econsigmotivo;

-- Preenchimento da tabela
INSERT INTO econsigmotivo values (1,'FALECIMENTO');
INSERT INTO econsigmotivo values (2,'SERVIDOR N├O IDENTIFICADO');
INSERT INTO econsigmotivo values (3,'TIPO DE CONTRATO N├O PERMITE EMPR╔STIMO');
INSERT INTO econsigmotivo values (4,'MARGEM CONSIGN┴VEL EXCEDIDA');
INSERT INTO econsigmotivo values (5,'N├O DESCONTADO - OUTROS MOTIVOS');
INSERT INTO econsigmotivo values (6,'SERVIDOR DESLIGADO');
INSERT INTO econsigmotivo values (7,'SERVIDOR AFASTADO EM LICENăA SA┌DE');


----------------------------------------------------
---- Relatˇrio ImportašŃo
----------------------------------------------------
truncate econsigmovimento cascade;
alter table econsigmovimento add column rh133_relatorio oid null;
----------------------------------------------------
---- Remove as referŕncias econsig
----------------------------------------------------
ALTER TABLE econsigmovimentoservidor
DROP CONSTRAINT econsigmovimentoservidor_regist_fk;

ALTER TABLE econsigmovimentoservidorrubrica
DROP CONSTRAINT econsigmovimentoservidorrubrica_rubrica_instit_fk;

----------------------------------------------------
---- Adicionado campo nome na econsig
----------------------------------------------------
ALTER TABLE econsigmovimentoservidor ADD COLUMN rh134_nome varchar(50);
----------------------------------------------------
---- FIM FOLHA
----------------------------------------------------

----------------------------------------------------
---- INICIO FINANCEIRO / PATRIMONIAL
----------------------------------------------------

alter table solicitaregistropreco add column pc54_formacontrole integer;
update solicitaregistropreco set pc54_formacontrole = 1;
alter table solicitaregistropreco alter column pc54_formacontrole set default 1;

alter table liclicita add l20_formacontroleregistropreco integer;
update liclicita set l20_formacontroleregistropreco = 1;
alter table pcorcamval add pc23_percentualdesconto numeric(10, 2) default 0;

/**
 * 97317 - Encerramento do Exercicio
 */
create sequence regraencerramentonaturezaorcamentaria_c117_sequencial_seq
increment 1
minvalue 1
maxvalue 9223372036854775807
start 1
cache 1;

create table regraencerramentonaturezaorcamentaria(
  c117_sequencial int4 not null default nextval('regraencerramentonaturezaorcamentaria_c117_sequencial_seq'),
  c117_anousu int4 not null,
  c117_instit int4 not null,
  c117_contadevedora varchar(15) not null,
  c117_contacredora varchar(15) ,
  constraint regraencerramentonaturezaorcamentaria_sequ_pk primary key (c117_sequencial)
);

alter table solicitaanulada add column pc67_processoadministrativo varchar(20) default null;
















