----- TRIBUTARIO ------
alter table carface add j38_datalancamento date;

CREATE SEQUENCE agrupamentocaracteristica_j139_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE agrupamentocaracteristicavalor_j140_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE agrupamentocaracteristica(
j139_sequencial   int4 NOT NULL default 0,
j139_anousu   int4 NOT NULL default 0,
j139_agrupamentocaracteristicavalor   int4  default 0,
j139_caracter   int4 default 0,
CONSTRAINT agrupamentocaracteristica_sequ_pk PRIMARY KEY (j139_sequencial));

CREATE TABLE agrupamentocaracteristicavalor(
j140_sequencial   int4 NOT NULL default 0,
j140_valor    float8 default 0,
CONSTRAINT agrupamentocaracteristicavalor_sequ_pk PRIMARY KEY (j140_sequencial));

ALTER TABLE agrupamentocaracteristica
ADD CONSTRAINT agrupamentocaracteristica_agrupamentocaracteristicavalor_fk FOREIGN KEY (j139_agrupamentocaracteristicavalor)
REFERENCES agrupamentocaracteristicavalor;

ALTER TABLE agrupamentocaracteristica
ADD CONSTRAINT agrupamentocaracteristica_caracter_fk FOREIGN KEY (j139_caracter)
REFERENCES caracter;

/**
 * Inserimos as tabelas agrupamentocaracteristica e agrupamentocaracteristicavalor no iptutabelas
 */

select setval('iptutabelas_j121_sequencial_seq', (select max(j121_sequencial) from iptutabelas));
insert into iptutabelas ( j121_sequencial, j121_codarq )
     select nextval('iptutabelas_j121_sequencial_seq'), 3770
      where not exists ( select 1 from iptutabelas where j121_codarq = 3770 );

insert into iptutabelas ( j121_sequencial, j121_codarq )
     select nextval('iptutabelas_j121_sequencial_seq'), 3771
      where not exists ( select 1 from iptutabelas where j121_codarq = 3771 );

/**
 * Adicionamos uma mensagem para quando nao houver fator de deprecia??o
 */
insert into iptucadlogcalc values (109, 'N?O H? FATOR DE DEPRECIA??O PARA O EXERC?CIO ', 't');
insert into iptucadlogcalc values (110, 'N?O H? VALOR DO METRO QUADRADO PARA O EXERC?CIO ', 't');
insert into iptucadlogcalc values (108, 'N?O H? FATOR DE COMERCIALIZA??O PARA O EXERC?CIO ', 't');
insert into iptucadlogcalc values (111, 'VERIFIQUE A TESTADA CADASTRADA PARA ESTA MATR?CULA ', 't');
insert into iptucadlogcalc values (112, '?REA DA CONSTRU??O ZERADA', 't');

/**
 * Funcao calculo iptu guaiba
 */
insert into db_sysfuncoes (codfuncao, nomefuncao, obsfuncao, corpofuncao, triggerfuncao, nomearquivo) values (168, 'fc_calculoiptu_guaiba_2015',      'calculo de iptu',            '.', '0', 'calculoiptu_guaiba_2015.sql');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 168, 1, 'iMatricula',    'int4',    0, 0, '0',     'MATRICULA');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 168, 2, 'iAnousu',       'int4',    0, 0, '0',     'ANO DE CALCULO');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 168, 3, 'bGerafinanc',   'bool',    0, 0, '0',     'SE GERA FINANCEIRO');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 168, 4, 'bAtualizap',    'bool',    0, 0, '0',     'ATUALIZA PARCELAS');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 168, 5, 'bNovonumpre',   'bool',    0, 0, '0',     'SE GERA UM NOVO NUMPRE');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 168, 6, 'bCalculogeral', 'bool',    0, 0, '0',     'SE CALCULO GERAL');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 168, 7, 'bDemo',         'bool',    0, 0, '0',     'SE E DEMONSTRATIVO');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 168, 8, 'iParcelaini',   'int4',    0, 0, '0',     'PARCELA INICIAL');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 168, 9, 'iParcelafim',   'int4',    0, 0, '0',     'PARCELA FINAL');

insert into db_sysfuncoes (codfuncao, nomefuncao, obsfuncao, corpofuncao, triggerfuncao, nomearquivo) values (169, 'fc_iptu_taxalimpeza_guaiba_2015', 'calculo da taxa de limpeza', 'a', '0', 'iptu_taxalimpeza_guaiba_2015.sql');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 169, 1, 'iReceita',      'int4',    0, 0, '0',     'RECEITA');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 169, 2, 'iAliquota',     'numeric', 0, 0, '0',     'ALIQUOTA');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 169, 3, 'iHistCalc',     'int4',    0, 0, '0',     'HISTORICO DE CALCULO');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 169, 4, 'iPercIsen',     'numeric', 0, 0, '0',     'PERCENTUAL DE ISENCAO');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 169, 5, 'nValpar',       'numeric', 0, 0, '0',     'VALOR POR PARAMETRO');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 169, 6, 'bRaise',        'bool',    0, 0, 'FALSE', 'DEBUG');

insert into db_sysfuncoes (codfuncao, nomefuncao, obsfuncao, corpofuncao, triggerfuncao, nomearquivo) values (170, 'fc_iptu_taxalixo_guaiba_2015', 'calculo da taxa de lixo', 'a', '0', 'iptu_taxalixo_guaiba_2015.sql');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 170, 1, 'iReceita',      'int4',    0, 0, '0',     'RECEITA');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 170, 2, 'iAliquota',     'numeric', 0, 0, '0',     'ALIQUOTA');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 170, 3, 'iHistCalc',     'int4',    0, 0, '0',     'HISTORICO DE CALCULO');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 170, 4, 'iPercIsen',     'numeric', 0, 0, '0',     'PERCENTUAL DE ISENCAO');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 170, 5, 'nValpar',       'numeric', 0, 0, '0',     'VALOR POR PARAMETRO');
insert into db_sysfuncoesparam (db42_sysfuncoesparam, db42_funcao, db42_ordem, db42_nome, db42_tipo, db42_tamanho, db42_precisao, db42_valor_default, db42_descricao) values ( nextval('db_sysfuncoesparam_db42_sysfuncoesparam_seq'), 170, 6, 'bRaise',        'bool',    0, 0, 'FALSE', 'DEBUG');

-- Criando  sequences
CREATE SEQUENCE mensagerialicenca_db_usuarios_am16_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE SEQUENCE mensagerialicencaprocessado_am15_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE mensagerialicenca_db_usuarios(
am16_sequencial   int4 NOT NULL default 0,
am16_usuario    int4 NOT NULL default 0,
am16_dias   int4 default 0,
CONSTRAINT mensagerialicenca_db_usuarios_sequ_pk PRIMARY KEY (am16_sequencial));

CREATE TABLE mensagerialicencaprocessado(
am15_sequencial   int4 NOT NULL default 0,
am15_mensagerialicencadb_usuarios   int4 NOT NULL default 0,
am15_licencaempreendimento    int4 default 0,
CONSTRAINT mensagerialicencaprocessado_sequ_pk PRIMARY KEY (am15_sequencial));

ALTER TABLE mensagerialicenca_db_usuarios
ADD CONSTRAINT mensagerialicenca_db_usuarios_usuario_fk FOREIGN KEY (am16_usuario)
REFERENCES db_usuarios;

ALTER TABLE mensagerialicencaprocessado
ADD CONSTRAINT mensagerialicencaprocessado_usuarios_fk FOREIGN KEY (am15_mensagerialicencadb_usuarios)
REFERENCES mensagerialicenca_db_usuarios;

ALTER TABLE mensagerialicencaprocessado
ADD CONSTRAINT mensagerialicencaprocessado_licencaempreendimento_fk FOREIGN KEY (am15_licencaempreendimento)
REFERENCES licencaempreendimento;

CREATE UNIQUE INDEX mensagerialicencaprocessado_sequencial_in ON mensagerialicencaprocessado(am15_sequencial);

CREATE SEQUENCE mensagerialicenca_am14_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE mensagerialicenca(
am14_sequencial   int4 NOT NULL default 0,
am14_assunto    varchar(100) NOT NULL ,
am14_mensagem   text ,
CONSTRAINT mensagerialicenca_sequ_pk PRIMARY KEY (am14_sequencial));

CREATE UNIQUE INDEX mensagerialicenca_sequencial_in ON mensagerialicenca(am14_sequencial);

insert into mensagerialicenca values (1, 'Assunto', 'Mensagem');

insert into db_sysfuncoes( codfuncao ,nomefuncao ,nomearquivo ,obsfuncao ,corpofuncao ,triggerfuncao ) values ( 171 ,'fc_iptu_taxalixo_capivari_2015' ,'iptu_taxalixo_capivari_2015.sql' ,'Fun??o de taxa de lixo para o c?lculo de 2015 de Capivari' ,'create or replace function fc_iptu_taxalixo_capivari_2015(integer,numeric,integer,numeric,numeric,boolean) returns boolean as $$ declare iReceita alias for $1; iAliquota alias for $2; iHistCalc alias for $3; iPercIsen alias for $4; nValpar alias for $5; lRaise alias for $6; nValTaxa numeric default 0; nValorBase numeric default 0; nVlrEdi numeric default 0; nVlrTes numeric default 0; nVlrMin numeric default 0; n80PercViptu numeric default 0; nViptu numeric default 0; iNumConstr integer default 0; iIdbql integer default 0; iNparc integer default 0; iCaracteristica integer default 0; lPredial boolean default false; tSql text default \'\'; iAnousu integer default 0; valor numeric; nTestada numeric; nTotalAreaConstr numeric; nFracao float8; begin /* nValorBase - valref do cfiptu */ /* SO CALCULA SE FOR PREDIAL */ if lRaise then raise notice \'CALCULANDO TAXA DE COLETA DE LIXO ...\'; raise notice \' receita - % aliq - % historico - % raise - % \',iReceita,iAliquota,iHistCalc,lRaise; end if; select count(*) into iNumConstr from iptuconstr inner join tmpdadostaxa on j39_matric = tmpdadostaxa.matric where j39_dtdemo is null; if iNumConstr > 0 then lPredial := true; end if; if lRaise then raise notice \'PREDIAL %\', lPredial; end if; select anousu into iAnousu from tmpdadostaxa inner join tmpdadosiptu on tmpdadostaxa.matric = tmpdadostaxa.matric; -- verifica a faixa que se enquadra a taxa de lixo select j71_valor * (select min(i02_valor) from infla where infla.i02_codigo = \'UFM\' and extract (year from infla.i02_data) = tmpdadostaxa.anousu), j31_codigo into nValTaxa, iCaracteristica from tmpdadostaxa left join carlote on carlote.j35_idbql = tmpdadostaxa.idbql left join caracter on caracter.j31_codigo = carlote.j35_caract left join carvalor on carlote.j35_caract = carvalor.j71_caract where caracter.j31_grupo = 6; if (not found and lPredial) or iCaracteristica = 60 then return false; end if; select min(i02_valor) into valor from infla where infla.i02_codigo = \'UFM\' and extract (year from infla.i02_data) = iAnousu; if lRaise then raise notice \'valorrrrrrr % anousu % ----- %\', valor, iAnousu, iPercIsen; end if; if lPredial is false then nValTaxa = 25 * (select min(i02_valor) from infla where infla.i02_codigo = \'UFM\' and extract (year from infla.i02_data) = iAnousu); end if; if iPercIsen > 0 then nValTaxa := nValTaxa * (100 - iPercIsen) / 100; end if; if nValTaxa > 0 then insert into tmptaxapercisen values (iReceita,iPercIsen,0,nValTaxa); tSql := \'insert into tmprecval values (\'||iReceita||\',\'||nValTaxa||\',\'||iHistCalc||\',true)\'; if lRaise then raise notice \'%\',tSql; end if; execute tSql; return true; else return false; end if; end; $$ language \'plpgsql\'; ' ,'0' );
insert into db_sysfuncoesparam( db42_sysfuncoesparam ,db42_funcao ,db42_ordem ,db42_nome ,db42_tipo ,db42_tamanho ,db42_precisao ,db42_valor_default ,db42_descricao ) values ( 896 ,171 ,1 ,'iReceita' ,'int4' ,0 ,0 ,'0' ,'RECEITA' );
insert into db_sysfuncoesparam( db42_sysfuncoesparam ,db42_funcao ,db42_ordem ,db42_nome ,db42_tipo ,db42_tamanho ,db42_precisao ,db42_valor_default ,db42_descricao ) values ( 897 ,171 ,2 ,'iAliquota' ,'numeric' ,0 ,0 ,'0' ,'ALIQUOTA' );
insert into db_sysfuncoesparam( db42_sysfuncoesparam ,db42_funcao ,db42_ordem ,db42_nome ,db42_tipo ,db42_tamanho ,db42_precisao ,db42_valor_default ,db42_descricao ) values ( 898 ,171 ,3 ,'iHistCalc' ,'int4' ,0 ,0 ,'0' ,'HISTORICO DO CALCULO' );
insert into db_sysfuncoesparam( db42_sysfuncoesparam ,db42_funcao ,db42_ordem ,db42_nome ,db42_tipo ,db42_tamanho ,db42_precisao ,db42_valor_default ,db42_descricao ) values ( 899 ,171 ,4 ,'iPercIsen' ,'numeric' ,0 ,0 ,'0' ,'PERCENTUAL DE ISEN??O' );
insert into db_sysfuncoesparam( db42_sysfuncoesparam ,db42_funcao ,db42_ordem ,db42_nome ,db42_tipo ,db42_tamanho ,db42_precisao ,db42_valor_default ,db42_descricao ) values ( 900 ,171 ,5 ,'nValpar' ,'numeric' ,0 ,0 ,'0' ,'VALOR DA PARCELA' );
insert into db_sysfuncoesparam( db42_sysfuncoesparam ,db42_funcao ,db42_ordem ,db42_nome ,db42_tipo ,db42_tamanho ,db42_precisao ,db42_valor_default ,db42_descricao ) values ( 901 ,171 ,6 ,'lRaise' ,'bool' ,0 ,0 ,'FALSE' ,'RAISE DEBUG' );

select setval('db_sysfuncoes_codfuncao_seq', (select max(codfuncao) from db_sysfuncoes));
SELECT setval('db_sysfuncoesparam_db42_sysfuncoesparam_seq', (SELECT MAX(db42_sysfuncoesparam) FROM db_sysfuncoesparam));

select setval ('cnae_q71_sequencial_seq', coalesce((select max(q71_sequencial) from cnae), 1));
select setval ('cnaeanalitica_q72_sequencial_seq', coalesce((select max(q72_sequencial) from cnaeanalitica), 1));
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'C2013401', 'Fabrica??o de adubos e fertilizantes organo-minerais' from cnae where not exists (select 1 from cnae where q71_estrutural = 'C2013401') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2396 and not exists (select 1 from cnaeanalitica where q72_cnae = 2396) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'C2013402', 'Fabrica??o de adubos e fertilizantes, exceto organo-minerais' from cnae where not exists (select 1 from cnae where q71_estrutural = 'C2013402') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2397 and not exists (select 1 from cnaeanalitica where q72_cnae = 2397) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'H5030103', 'Servi?o de rebocadores e empurradores' from cnae where not exists (select 1 from cnae where q71_estrutural = 'H5030103') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2398 and not exists (select 1 from cnaeanalitica where q72_cnae = 2398) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'H5231103', 'Gest?o de terminais aquavi?rios' from cnae where not exists (select 1 from cnae where q71_estrutural = 'H5231103') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2399 and not exists (select 1 from cnaeanalitica where q72_cnae = 2399) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'H5239701', 'Servi?os de praticagem' from cnae where not exists (select 1 from cnae where q71_estrutural = 'H5239701') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2400 and not exists (select 1 from cnaeanalitica where q72_cnae = 2400) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'H5239799', 'Atividades auxiliares dos transportes aquavi?rios n?o especificadas anteriormente' from cnae where not exists (select 1 from cnae where q71_estrutural = 'H5239799') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2401 and not exists (select 1 from cnaeanalitica where q72_cnae = 2401) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'J5812301', 'Edi??o de jornais di?rios' from cnae where not exists (select 1 from cnae where q71_estrutural = 'J5812301') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2402 and not exists (select 1 from cnaeanalitica where q72_cnae = 2402) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'J5812302', 'Edi??o de jornais n?o di?rios' from cnae where not exists (select 1 from cnae where q71_estrutural = 'J5812302') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2403 and not exists (select 1 from cnaeanalitica where q72_cnae = 2403) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'J5822101', 'Edi??o integrada ? impress?o de jornais di?rios' from cnae where not exists (select 1 from cnae where q71_estrutural = 'J5822101') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2404 and not exists (select 1 from cnaeanalitica where q72_cnae = 2404) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'J5822102', 'Edi??o integrada ? impress?o de jornais n?o di?rios' from cnae where not exists (select 1 from cnae where q71_estrutural = 'J5822102') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2405 and not exists (select 1 from cnaeanalitica where q72_cnae = 2405) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'J6201501', 'Desenvolvimento de programas de computador sob encomenda' from cnae where not exists (select 1 from cnae where q71_estrutural = 'J6201501') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2406 and not exists (select 1 from cnaeanalitica where q72_cnae = 2406) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'J6201502', 'Web design' from cnae where not exists (select 1 from cnae where q71_estrutural = 'J6201502') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2407 and not exists (select 1 from cnaeanalitica where q72_cnae = 2407) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'K64387', 'Bancos de c?mbio e outras institui??es de intermedia??o n?o-monet?ria' from cnae where not exists (select 1 from cnae where q71_estrutural = 'K64387') limit 1;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'M7410203', 'Design de produto' from cnae where not exists (select 1 from cnae where q71_estrutural = 'M7410203') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2409 and not exists (select 1 from cnaeanalitica where q72_cnae = 2409) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'M7410299', 'Atividades de design n?o especificadas anteriormente' from cnae where not exists (select 1 from cnae where q71_estrutural = 'M7410299') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2410 and not exists (select 1 from cnaeanalitica where q72_cnae = 2410) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'N8020001', 'Atividades de monitoramento de sistemas de seguran?a eletr?nico' from cnae where not exists (select 1 from cnae where q71_estrutural = 'N8020001') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2411 and not exists (select 1 from cnaeanalitica where q72_cnae = 2411) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'N8020002', 'Outras atividades de servi?os de seguran?a' from cnae where not exists (select 1 from cnae where q71_estrutural = 'N8020002') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2412 and not exists (select 1 from cnaeanalitica where q72_cnae = 2412) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'S9412001', 'Atividades de fiscaliza??o profissional' from cnae where not exists (select 1 from cnae where q71_estrutural = 'S9412001') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2413 and not exists (select 1 from cnaeanalitica where q72_cnae = 2413) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'S9412099', 'Outras atividades associativas profissionais' from cnae where not exists (select 1 from cnae where q71_estrutural = 'S9412099') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2414 and not exists (select 1 from cnaeanalitica where q72_cnae = 2414) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'S9609207', 'Alojamento de animais dom?sticos' from cnae where not exists (select 1 from cnae where q71_estrutural = 'S9609207') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2415 and not exists (select 1 from cnaeanalitica where q72_cnae = 2415) limit 1;;
insert into cnae select nextval('cnae_q71_sequencial_seq'), 'S9609208', 'Higiene e embelezamento de animais dom?sticos' from cnae where not exists (select 1 from cnae where q71_estrutural = 'S9609208') limit 1;
insert into cnaeanalitica select nextval('cnaeanalitica_q72_sequencial_seq'), q71_sequencial from cnae where q71_sequencial = 2416 and not exists (select 1 from cnaeanalitica where q72_cnae = 2416) limit 1;;


----- FIM TRIBUTARIO ------


---------------------------
------- TIME C ------------
---------------------------

CREATE SEQUENCE movimentacaoprontuario_sd102_codigo_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE setorambulatorial_sd91_codigo_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE movimentacaoprontuario(
sd102_codigo int4 NOT NULL default 0,
sd102_prontuarios int4 NOT NULL default 0,
sd102_db_usuarios int4 NOT NULL default 0,
sd102_setorambulatorial int4 NOT NULL default 0,
sd102_data date NOT NULL default null,
sd102_hora varchar(5) NOT NULL ,
sd102_situacao int4 NOT NULL default 1,
sd102_observacao text ,
CONSTRAINT movimentacaoprontuario_codi_pk PRIMARY KEY (sd102_codigo));


CREATE TABLE setorambulatorial(
sd91_codigo   int4 NOT NULL default 0,
sd91_unidades   int4 NOT NULL default 0,
sd91_descricao    varchar(60) NOT NULL ,
sd91_local    int4 default 0,
CONSTRAINT setorambulatorial_codi_pk PRIMARY KEY (sd91_codigo));

insert into setorambulatorial
     select nextval('setorambulatorial_sd91_codigo_seq'), sd02_i_codigo, 'RECEP??O', 1
       from unidades;

insert into setorambulatorial
     select nextval('setorambulatorial_sd91_codigo_seq'), sd02_i_codigo, 'TRIAGEM', 2
       from unidades;

insert into setorambulatorial
     select nextval('setorambulatorial_sd91_codigo_seq'), sd02_i_codigo, 'CONSULTA M?DICA', 3
       from unidades;

insert into setorambulatorial
     select nextval('setorambulatorial_sd91_codigo_seq'), sd02_i_codigo, 'EXTERNO', 4
       from unidades;


ALTER TABLE prontuarios ADD COLUMN sd24_setorambulatorial int ;

update prontuarios set sd24_setorambulatorial = sd91_codigo
  from setorambulatorial
 where sd24_i_unidade = sd91_unidades
   and sd91_local = 4 ;

ALTER TABLE prontuarios alter COLUMN sd24_setorambulatorial set default 1;

ALTER TABLE movimentacaoprontuario ADD CONSTRAINT movimentacaoprontuario_prontuarios_fk FOREIGN KEY (sd102_prontuarios) REFERENCES prontuarios;
ALTER TABLE movimentacaoprontuario ADD CONSTRAINT movimentacaoprontuario_usuarios_fk FOREIGN KEY (sd102_db_usuarios) REFERENCES db_usuarios;
ALTER TABLE movimentacaoprontuario ADD CONSTRAINT movimentacaoprontuario_setorambulatorial_fk FOREIGN KEY (sd102_setorambulatorial) REFERENCES setorambulatorial;

ALTER TABLE prontuarios ADD CONSTRAINT prontuarios_setorambulatorial_fk FOREIGN KEY (sd24_setorambulatorial) REFERENCES setorambulatorial;
ALTER TABLE setorambulatorial ADD CONSTRAINT setorambulatorial_unidades_fk FOREIGN KEY (sd91_unidades) REFERENCES unidades;

CREATE  INDEX movimentacaoprontuario_setorambulatorial_in ON movimentacaoprontuario(sd102_setorambulatorial);
CREATE  INDEX movimentacaoprontuario_db_usuarios_in ON movimentacaoprontuario(sd102_db_usuarios);
CREATE  INDEX movimentacaoprontuario_prontuarios_in ON movimentacaoprontuario(sd102_prontuarios);
CREATE  INDEX prontuarios_setorambulatorial_in ON prontuarios(sd24_setorambulatorial);
CREATE  INDEX setorambulatorial_unidades_in ON setorambulatorial(sd91_unidades);

CREATE SEQUENCE examerequisicaoexame_sd104_codigo_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;
CREATE SEQUENCE requisicaoexameprontuario_sd103_codigo_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE examerequisicaoexame(
sd104_codigo    int4 NOT NULL  default nextval('examerequisicaoexame_sd104_codigo_seq'),
sd104_requisicaoexameprontuario   int4 NOT NULL ,
sd104_lab_exame   int4 ,
CONSTRAINT examerequisicaoexame_codi_pk PRIMARY KEY (sd104_codigo));

CREATE TABLE requisicaoexameprontuario(
sd103_codigo    int4 NOT NULL default 0,
sd103_prontuarios   int4 NOT NULL default 0,
sd103_medicos   int4 NOT NULL default 0,
sd103_data    date NOT NULL default null,
sd103_hora    varchar(5) NOT NULL ,
sd103_observacao    text ,
CONSTRAINT requisicaoexameprontuario_codi_pk PRIMARY KEY (sd103_codigo));

ALTER TABLE examerequisicaoexame ADD CONSTRAINT examerequisicaoexame_requisicaoexameprontuario_fk FOREIGN KEY (sd104_requisicaoexameprontuario) REFERENCES requisicaoexameprontuario;
ALTER TABLE examerequisicaoexame ADD CONSTRAINT examerequisicaoexame_exame_fk FOREIGN KEY (sd104_lab_exame) REFERENCES lab_exame;
ALTER TABLE requisicaoexameprontuario ADD CONSTRAINT requisicaoexameprontuario_medicos_fk FOREIGN KEY (sd103_medicos) REFERENCES medicos;
ALTER TABLE requisicaoexameprontuario ADD CONSTRAINT requisicaoexameprontuario_prontuarios_fk FOREIGN KEY (sd103_prontuarios) REFERENCES prontuarios;
CREATE  INDEX examerequisicaoexame_lab_exame_in ON examerequisicaoexame(sd104_lab_exame);
CREATE  INDEX examerequisicaoexame_requisicaoexameprontuario_in ON examerequisicaoexame(sd104_requisicaoexameprontuario);
CREATE  INDEX requisicaoexameprontuario_medicos_in ON requisicaoexameprontuario(sd103_medicos);
CREATE  INDEX requisicaoexameprontuario_prontuarios_in ON requisicaoexameprontuario(sd103_prontuarios);

alter table prontproced add column sd29_sigilosa boolean default false;
alter table sau_triagemavulsa add column s152_evolucao text;
drop index sau_triagemavulsapront_s155_pront_uin;

CREATE SEQUENCE regracalculocargahoraria_ed127_codigo_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

CREATE TABLE regracalculocargahoraria(
ed127_codigo int4 NOT NULL  default nextval('regracalculocargahoraria_ed127_codigo_seq'),
ed127_ano int4 NOT NULL ,
ed127_calculaduracaoperiodo bool NOT NULL default 'false',
ed127_escola int4 ,
CONSTRAINT regracalculocargahoraria_codi_pk PRIMARY KEY (ed127_codigo));

ALTER TABLE regracalculocargahoraria ADD CONSTRAINT regracalculocargahoraria_escola_fk FOREIGN KEY (ed127_escola) REFERENCES escola;
CREATE UNIQUE INDEX regracalculocargahoraria_escola_ano_in ON regracalculocargahoraria(ed127_escola,ed127_ano);


create temp table w_escolacalendario as
select distinct ed18_i_codigo, ed52_i_ano
  from escola
 inner join calendarioescola on calendarioescola.ed38_i_escola = escola.ed18_i_codigo
 inner join calendario       on calendario.ed52_i_codigo = calendarioescola.ed38_i_calendario
order by ed52_i_ano, ed18_i_codigo;

insert into regracalculocargahoraria
 select nextval('regracalculocargahoraria_ed127_codigo_seq'), ed52_i_ano, false, ed18_i_codigo  from w_escolacalendario ;

insert into db_viradacaditem values (33, 'CONFIGURA??ES DO C?LCULO DA CARGA HOR?RIA');

---------------------------
------- FIM TIME C --------
---------------------------

---------------------------
--------  TIME NFSE -------
---------------------------

-- Tabela temporario para armazenar as configura??es dos ?ltimos 3 anos
CREATE TABLE w_migracao_confvencissqnvariavel(
ano		    int4 NOT NULL default 0,
codvenc		int4 NOT NULL default 0,
receita		int4 NOT NULL default 0,
tipo		  int4 NOT NULL default 33,
hist		  int4 NOT NULL default 1019,
diavenc		int4 NOT NULL default 1,
valor		  float4 default 0
);

-- Novas configura??es do ISSQN V?riavel
CREATE SEQUENCE confvencissqnvariavel_q144_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE confvencissqnvariavel(
q144_sequencial	int4 NOT NULL default 0,
q144_ano		    int4 NOT NULL default 0,
q144_codvenc		int4 NOT NULL default 0,
q144_receita		int4 NOT NULL default 0,
q144_tipo		    int4 NOT NULL default 33,
q144_hist		    int4 NOT NULL default 1019,
q144_diavenc		int4 NOT NULL default 1,
q144_valor		  float4 default 0,
CONSTRAINT confvencissqnvariavel_sequ_pk PRIMARY KEY (q144_sequencial));

ALTER TABLE confvencissqnvariavel
ADD CONSTRAINT confvencissqnvariavel_codvenc_fk FOREIGN KEY (q144_codvenc)
REFERENCES cadvencdesc;

ALTER TABLE confvencissqnvariavel
ADD CONSTRAINT confvencissqnvariavel_receita_fk FOREIGN KEY (q144_receita)
REFERENCES tabrec;

ALTER TABLE confvencissqnvariavel
ADD CONSTRAINT confvencissqnvariavel_tipo_fk FOREIGN KEY (q144_tipo)
REFERENCES arretipo;

ALTER TABLE confvencissqnvariavel
ADD CONSTRAINT confvencissqnvariavel_hist_fk FOREIGN KEY (q144_hist)
REFERENCES histcalc;

CREATE UNIQUE INDEX confvencissqnvariavel_cadvenccompetencia_in ON confvencissqnvariavel(q144_ano,q144_codvenc);
CREATE  INDEX confvencissqnvariavel_histcalc_in ON confvencissqnvariavel(q144_hist);
CREATE  INDEX confvencissqnvariavel_arretipo_in ON confvencissqnvariavel(q144_tipo);
CREATE  INDEX confvencissqnvariavel_tabrec_in ON confvencissqnvariavel(q144_receita);
CREATE  INDEX confvencissqnvariavel_cadvencdesc_in ON confvencissqnvariavel(q144_codvenc);

-- Inclui configura??es dos 3 anos anteriores da virada em uma tabela temporaria
INSERT INTO w_migracao_confvencissqnvariavel
SELECT CASE
         WHEN TRIM(SUBSTR(descvencimento.q92_descr, ( CHAR_LENGTH(descvencimento.q92_descr) - 3 ), 4)) = ''
           THEN 2009
         WHEN TRIM(SUBSTR(descvencimento.q92_descr, ( CHAR_LENGTH(descvencimento.q92_descr) - 3 ), 4)) ~ '^[-0-9]+$'
           THEN TRIM(SUBSTR(descvencimento.q92_descr, ( CHAR_LENGTH(descvencimento.q92_descr) - 3 ), 4))::integer
         ELSE 2010
       END AS anousu,
       vencimento.q82_codigo,
       ( SELECT q60_receit FROM parissqn LIMIT 1 ) AS receita,
       ( SELECT q92_tipo FROM cadvencdesc WHERE q92_codigo = vencimento.q82_codigo ) AS tipo,
       ( SELECT q92_hist FROM cadvencdesc WHERE q92_codigo = vencimento.q82_codigo ) AS historico,
       DATE_PART('day', vencimento.q82_venc)::integer as diavenc,
       0.00 AS valor
  FROM (   SELECT q82_codigo, max(q82_venc) AS maiordata
             FROM cadvenc
         GROUP BY q82_codigo
         ORDER BY q82_codigo ) maiorvencimento
         JOIN cadvenc vencimento ON maiorvencimento.maiordata  = vencimento.q82_venc
                                AND maiorvencimento.q82_codigo = vencimento.q82_codigo
         JOIN cadvencdesc descvencimento ON descvencimento.q92_codigo = vencimento.q82_codigo
   WHERE descvencimento.q92_descr ILIKE '%ISSQN VARIAVEL%'
ORDER BY anousu DESC
   LIMIT 3;

-- Ajusta o ano caso possua valores duplicados para menos um anos apartir do menos codigo de vencimento cadastrado
UPDATE w_migracao_confvencissqnvariavel
   SET ano = ( tbe.ano - 1 )
  FROM ( select * from ( select ano from w_migracao_confvencissqnvariavel group by ano having count(ano) > 1 ) AS anoduplicado, ( select MIN(codvenc) AS codvenc from w_migracao_confvencissqnvariavel ) AS menorcodigovenc )  tbe
WHERE w_migracao_confvencissqnvariavel.ano = tbe.ano AND w_migracao_confvencissqnvariavel.codvenc = tbe.codvenc;

-- Inclui valores iniciais para as novas configura??es do ISSQN V?riavel das 3 compet?ncias anteriores
INSERT INTO confvencissqnvariavel
SELECT nextval('confvencissqnvariavel_q144_sequencial_seq'),
       ano,
       codvenc,
       receita,
       tipo,
       hist,
       diavenc,
       valor
  FROM w_migracao_confvencissqnvariavel;

---------------------------
------ FIM TIME NFSE ------
---------------------------

-------------------------------
------ INICIO FINANCEIRO ------
-------------------------------


select fc_executa_ddl('
  insert into db_layouttxt values (222, \'SIAFEM - EXPORTA??O\', 0, \'\', 1);
  insert into db_layoutlinha values (727, 222, \'HEADER\', 1, 35, 0, 0, \'\', \'\', false);
  insert into db_layoutlinha values (728, 222, \'DETAIL\', 3, 670, 0, 0, \'\', \'\', false);
  insert into db_layoutlinha values (729, 222, \'ITEM DETAIL\', 3, 670, 0, 0, \'\', \'\', false);
  insert into db_layoutlinha values (730, 222, \'TRAILLER\', 5, 8, 0, 0, \'\', \'\', false);

  insert into db_layoutcampos values (11875, 727, \'tipo_registro\', \'TIPO DE REGISTRO\', 1, 1, \'\', 1, true, true, \'d\', \'0\', 0);
  insert into db_layoutcampos values (11876, 727, \'numero_lote\', \'N?MERO DO LOTE\', 1, 2, \'\', 5, false, true, \'d\', \'0\', 0);
  insert into db_layoutcampos values (11877, 727, \'data_geracao_lote\', \'DATA DE GERA??O DO LOTE\', 1, 7, \'\', 8, false, true, \'d\', \'0\', 0);
  insert into db_layoutcampos values (11878, 727, \'hora_geracao_lote\', \'HORA DE GERA??O DO LOTE\', 1, 15, \'\', 4, false, true, \'d\', \'0\', 0);
  insert into db_layoutcampos values (11879, 727, \'ano_referencia\', \'ANO DE REFER?NCIA\', 1, 19, \'\', 4, false, true, \'d\', \'0\', 0);
  insert into db_layoutcampos values (11880, 727, \'ug_responsavel\', \'UNIDADE GESTORA RESPONS?VEL\', 1, 23, \'\', 6, false, true, \'d\', \'0\', 0);
  insert into db_layoutcampos values (11881, 727, \'gestao\', \'GEST?O\', 1, 29, \'\', 5, false, true, \'d\', \'0\', 0);
  insert into db_layoutcampos values (11882, 727, \'tipo_documento\', \'TIPO DE DOCUMENTO\', 1, 34, \'\', 2, false, true, \'d\', \'0\', 0);
  insert into db_layoutcampos values (11883, 728, \'tipo_registro\', \'TIPO DE REGISTRO\', 1, 1, \'2\', 1, true, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11884, 728, \'data_emissao\', \'DATA DE EMISS?O\', 1, 2, \'\', 9, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11885, 728, \'numero_empenho\', \'NUMERO DO EMPENHO\', 1, 11, \'\', 20, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11886, 728, \'gestao\', \'GEST?O\', 1, 31, \'\', 5, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11887, 728, \'unidade_gestora\', \'UNIDADE GESTORA\', 1, 36, \'\', 6, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11888, 728, \'evento\', \'EVENTO\', 1, 42, \'\', 6, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11889, 728, \'historico_empenho\', \'HIST?RICO DO EMPENHO\', 1, 48, \'\', 231, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11890, 728, \'identificacao_credor\', \'IDENTIFICA??O DO CREDOR\', 1, 279, \'\', 14, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11891, 728, \'esfera\', \'ESFERA\', 1, 293, \'\', 1, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11892, 728, \'fonte_recurso\', \'FONTE DE RECURSO\', 1, 294, \'\', 10, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11893, 728, \'natureza_despesa\', \'NATUREZA DA DESPESA\', 1, 304, \'\', 8, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11894, 728, \'unidade_orcamentaria\', \'UNIDADE OR?AMENT?RIA\', 1, 312, \'\', 5, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11895, 728, \'programa_trabalho\', \'PROGRAMA DE TRABALHO\', 1, 317, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11896, 728, \'modalidade\', \'MODALIDADE\', 1, 334, \'\', 1, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11897, 728, \'modalidade_licitacao\', \'MODALIDADE DA LICITA??O\', 1, 335, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11898, 728, \'referencia_legal\', \'REFER?NCIA LEGAL\', 1, 337, \'\', 20, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11899, 728, \'numero_processo\', \'NUMERO DO PROCESSO\', 1, 357, \'\', 15, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11900, 728, \'valor_empenho\', \'VALOR EMPENHO\', 1, 372, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11901, 728, \'local_entrega\', \'LOCAL DE ENTREGA\', 1, 389, \'\', 45, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11902, 728, \'data_entrega\', \'DATA DE ENTREGA\', 1, 434, \'\', 8, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11903, 728, \'tipo_empenho\', \'TIPO DE EMPENHO\', 1, 442, \'\', 1, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11904, 728, \'mes_cronograma_1\', \'MES CRONOGRAMA\', 1, 443, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11905, 728, \'valor_cronograma_1\', \'VALOR DO CRONOGRAMA\', 1, 445, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11906, 728, \'mes_cronograma_2\', \'MES CRONOGRAMA\', 1, 462, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11907, 728, \'valor_cronograma_2\', \'VALOR DO CRONOGRAMA\', 1, 464, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11908, 728, \'mes_cronograma_3\', \'MES CRONOGRAMA\', 1, 481, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11909, 728, \'valor_cronograma_3\', \'VALOR\', 1, 483, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11910, 728, \'mes_cronograma_4\', \'MES CRONOGRAMA\', 1, 500, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11911, 728, \'valor_cronograma_4\', \'VALOR\', 1, 502, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11912, 728, \'mes_cronograma_5\', \'MES CRONOGRAMA\', 1, 519, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11913, 728, \'valor_cronograma_5\', \'VALOR\', 1, 521, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11914, 728, \'mes_cronograma_6\', \'MES CRONOGRAMA\', 1, 538, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11915, 728, \'valor_cronograma_6\', \'VALOR\', 1, 540, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11916, 728, \'mes_cronograma_7\', \'MES\', 1, 557, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11917, 728, \'valor_cronograma_7\', \'VALOR\', 1, 559, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11918, 728, \'mes_cronograma_8\', \'MES\', 1, 576, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11919, 728, \'valor_cronograma_8\', \'VALOR\', 1, 578, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11920, 728, \'mes_cronograma_9\', \'MES\', 1, 595, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11921, 728, \'valor_cronograma_9\', \'VALOR\', 1, 597, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11922, 728, \'mes_cronograma_10\', \'MES\', 1, 614, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11923, 728, \'valor_cronograma_10\', \'VALOR\', 1, 616, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11924, 728, \'mes_cronograma_11\', \'MES\', 1, 633, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11925, 728, \'valor_cronograma_11\', \'VALOR\', 1, 635, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11926, 728, \'mes_cronograma_12\', \'MES\', 1, 652, \'\', 2, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11927, 728, \'valor_cronograma_12\', \'VALOR\', 1, 654, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11928, 729, \'tipo_registro\', \'TIPO DE REGISTRO\', 1, 1, \'3\', 1, true, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11929, 729, \'unidade_medida\', \'UNIDADE DE MEDIDA\', 1, 2, \'\', 4, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11930, 729, \'quantidade\', \'QUANTIDADE\', 1, 6, \'\', 4, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11931, 729, \'valor_unitario\', \'VALOR UNITARIO\', 1, 10, \'\', 12, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11932, 729, \'valor_total\', \'VALOR TOTAL\', 1, 22, \'\', 17, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11933, 729, \'observacao\', \'OBSERVA??O\', 1, 39, \'\', 250, false, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11934, 730, \'tipo_registro\', \'TIPO DE REGISTRO\', 1, 1, \'\', 1, true, true, \'d\', \'\', 0);
  insert into db_layoutcampos values (11935, 730, \'quantidade_registro\', \'QUANTIDADE DE REGISTRO\', 1, 2, \'\', 7, false, true, \'d\', \'\', 0);
');

update db_layoutcampos set db52_nome = trim(db52_nome) , db52_descr = trim(db52_descr);


----------------------------
------ FIM FINANCEIRO ------
----------------------------

-------------------------------
------ IN?CIO TIME FOLHA ------
-------------------------------

-- Tabela "tipodeficiencia"
SELECT fc_executa_ddl('
  CREATE SEQUENCE tipodeficiencia_rh150_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
');

SELECT fc_executa_ddl('
  CREATE TABLE tipodeficiencia(
  rh150_sequencial  int4 NOT NULL DEFAULT 0,
  rh150_descricao   varchar(50),
  CONSTRAINT tipodeficiencia_sequ_pk PRIMARY KEY (rh150_sequencial));
');

SELECT fc_executa_ddl('
  CREATE INDEX tipodeficiencia_sequencial_in ON tipodeficiencia(rh150_sequencial);
');

SELECT fc_executa_ddl('
  INSERT INTO tipodeficiencia VALUES (0, ''Nenhum'');
');
SELECT fc_executa_ddl('
  INSERT INTO tipodeficiencia VALUES (1, ''F?sica'');
');
SELECT fc_executa_ddl('
  INSERT INTO tipodeficiencia VALUES (2, ''Auditiva'');
');
SELECT fc_executa_ddl('
  INSERT INTO tipodeficiencia VALUES (3, ''Visual'');
');
SELECT fc_executa_ddl('
  INSERT INTO tipodeficiencia VALUES (4, ''Intelectual'');
');
SELECT fc_executa_ddl('
  INSERT INTO tipodeficiencia VALUES (5, ''M?ltipla'');
');
SELECT fc_executa_ddl('
  INSERT INTO tipodeficiencia VALUES (6, ''Reabilitado'');
');

-- Tabela "rhpessoalmov"
SELECT fc_executa_ddl('
  ALTER TABLE rhpessoalmov ADD COLUMN rh02_tipodeficiencia int4 DEFAULT 0;
');

SELECT fc_executa_ddl('
  ALTER TABLE rhpessoalmov
  ADD CONSTRAINT rhpessoalmov_tipodeficiencia_fk FOREIGN KEY (rh02_tipodeficiencia)
  REFERENCES tipodeficiencia;
');

SELECT fc_executa_ddl('
  UPDATE rhpessoalmov SET rh02_tipodeficiencia = 1 WHERE rh02_deficientefisico = true;
');

-- Tabela de nacionalidade ajuste para emiss?o da RAIS
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (26, ''VENEZUELANO'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (27, ''COLOMBIANO'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (28, ''PERUANO'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (29, ''EQUATORIANO'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (34, ''CANADENSE'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (35, ''ESPANHOL'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (37, ''FRANCES'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (38, ''SUI?O'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (39, ''ITALIANO'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (40, ''HAITIANO'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (41, ''JAPONES'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (42, ''CHINES'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (43, ''COREANO'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (44, ''RUSSO'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (45, ''PORTUGUES'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (46, ''PAQUISTANES'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (47, ''INDIANO'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (48, ''OUTROS LATINO-AMERICANOS'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (49, ''OUTROS ASIATICOS'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (51, ''OUTROS EUROPEUS'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (60, ''ANGOLANO'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (61, ''CONGOLES'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (62, ''SUL-AFRICANO'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (63, ''GANES'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (64, ''SENEGALES'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (70, ''OUTROS AFRICANOS'');');
SELECT fc_executa_ddl('INSERT INTO rhnacionalidade VALUES (80, ''OUTROS'');');

-- Ajustando antigo c?digo de outros 50 para 80
SELECT fc_executa_ddl('
  UPDATE rhnacionalidade SET rh06_descr = ''BENGALES'' WHERE rh06_nacionalidade = 50;
');
SELECT fc_executa_ddl('UPDATE rhpessoal SET rh01_nacion = 80 WHERE rh01_nacion = 50;');

----------------------------
------ FIM TIME FOLHA ------
----------------------------