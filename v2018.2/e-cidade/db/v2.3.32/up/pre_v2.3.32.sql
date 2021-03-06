----------------------------------------------------
---- TIME C
----------------------------------------------------

----------------------------------------------------
---- Tarefa: 1023
----------------------------------------------------
insert into db_syscampo values(20826,'ed59_procedimento','int8','C?digo do Procedimento','0', 'C?digo do Procedimento',20,'f','f','f',1,'text','C?digo do Procedimento');
insert into db_sysarqcamp values(1010084,20826,15,0);
insert into db_sysforkey values(1010084,20826,1,1010074,0);
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
                  values ( 9993 ,'Alterar Proc. Avalia??o Disciplina' ,'Alterar Proc. Avalia??o Disciplina' ,'edu1_alteraprocedimentoavaliacaodisciplina001.php' ,'1' ,'1' ,'Menu para altera??o do procedimento de avalia??o das disciplinas vinculadas a uma turma.' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 1100873 ,9993 ,6 ,1100747 );
update db_itensmenu set libcliente = '0' where id_item = 1100958;
update db_itensmenu set descricao = 'Di?rio de Classe', help = 'Di?rio de Classe ', desctec = 'Emiss?o do di?rio de classe.', libcliente = '1' where id_item = 9941;

----------------------------------------------------
---- Tarefa: 10658
----------------------------------------------------
delete from db_sysarqcamp where codarq = 2874;
insert into db_sysarqcamp values(2874,16411,1,1785);
insert into db_sysarqcamp values(2874,16414,2,0);
insert into db_sysarqcamp values(2874,16412,3,0);
insert into db_sysarqcamp values(2874,16413,4,0);
insert into db_sysarqcamp values(2874,16416,5,0);
insert into db_sysarqcamp values(2874,16417,6,0);
insert into db_sysarqcamp values(2874,17299,7,0);
insert into db_sysarqcamp values(2874,17300,8,0);
delete from db_syscampo where codcam = 16415;

update db_itensmenu set libcliente = false where id_item = 8437;

----------------------------------------------------
---- Tarefa: 102508
----------------------------------------------------
update db_syscampo set rotulorel = 'In?cio', rotulo = 'In?cio' where codcam = 12510;


----------------------------------------------------
---- Acerto em Base #1663
----------------------------------------------------
update db_syscampo set nomecam = 'la06_c_cns', conteudo = 'char(15)', descricao = 'Cart?o SUS do Profissional', valorinicial = '', rotulo = 'Cart?o SUS', nulo = 'f', tamanho = 15, maiusculo = 't', autocompl = 'f', aceitatipo = 0, tipoobj = 'text', rotulorel = 'Cart?o SUS' where codcam = 16768;

----------------------------------------------------
---- FIM TIME C
----------------------------------------------------

/**
 * [FINANCEIRO - INICIO]
 */
 -- 97192
insert into db_itensmenu values( 9992, 'Emiss?o de Atas', 'Relat?rio de atas vigentes', 'com2_relatorioatasvigentes001.php', '1', '1', 'com2_relatorioatasvigentes001.php', '1'	);
insert into db_itensfilho (id_item, codfilho) values(9992,1);
insert into db_menu values(7952,9992,6,28);

-- 97216
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
     values ( 9994 ,'Manuten??o Estrutural PCASP' ,'Manuten??o Estrutural PCASP' ,'con4_manutencaoEstruturalPCASP.php' ,'1' ,'1' ,'Manuten??o Estrutural PCASP' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 4197 ,9994 ,13 ,209 );


update db_itensmenu set descricao = 'Anexo XII - Dem.dos Imp.e Desp.com Sa?de' where id_item = '8066';
update orcparamseqcoluna set o115_tipo = 1, o115_valoresdefault = '' , o115_nomecoluna = 'insc_rp_np' where o115_sequencial = 35;
UPDATE orcparamseqorcparamseqcoluna
   SET o116_orcparamseqcoluna = 35
 WHERE o116_orcparamseqcoluna = 155
   and o116_codseq in(30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 63, 64, 64, 65, 66, 67, 68, 69, 70)
   and o116_codparamrel = 124
   and o116_periodo in (11, 13);

-- 97248
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
  values ( 9995 ,'Delib. 200/96 - TCE RJ' ,'Delib. 200/96 - TCE RJ' ,'' ,'1' ,'1' ,'Delib. 200/96 - TCE RJ' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo )
  values ( 3331 ,9995 ,45 ,209 );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
  values ( 9996 ,'Modelo 5' ,'Modelo 5' ,'con2_deliberacao20096restosapagar001.php' ,'1' ,'1' ,'Modelo 5' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo )
  values ( 9995 ,9996 ,1 ,209 );

insert into db_tipodoc( db08_codigo ,db08_descr )
  values ( 5015 ,'ASSINATURA DELIBERA??O 200/96 - MODELO 5' );

insert into db_documentopadrao( db60_coddoc ,db60_descr ,db60_tipodoc ,db60_instit )
  select nextval('db_documentopadrao_db60_coddoc_seq'), 'ASSINATURA DELIBERA??O 200/96 - MODELO 5' ,5015 , codigo from db_config;

drop table if exists db_paragrafopadrao_97248;
create temp table db_paragrafopadrao_97248 as select nextval('db_paragrafopadrao_db61_codparag_seq') as sequencial, codigo from db_config;

insert into db_paragrafopadrao( db61_codparag ,db61_descr ,db61_texto ,db61_alinha ,db61_inicia ,db61_espaco ,db61_alinhamento ,db61_altura ,db61_largura ,db61_tipo )
  select sequencial ,'ASSINATURA' ,' $nWidth = $this->oPdf->getAvailWidth(); $this->oPdf->setBold(true); $this->oPdf->cell($nWidth*0.33, 4, \"Elaborado Por\", 1, 0, \'C\'); $this->oPdf->cell($nWidth*0.33, 4, \"Conferido Por\", 1, 0, \'C\'); $this->oPdf->cell($nWidth*0.24, 4, \"Visto\", 1, 0, \'C\'); $this->oPdf->cell($nWidth*0.10, 4, \"Data\", 1, 1, \'C\'); $this->oPdf->setBold(false); $this->oPdf->cell($nWidth*0.33, 4, \"Nome\", \'L:R\'); $this->oPdf->cell($nWidth*0.33, 4, \'\', \'L:R\'); $this->oPdf->cell($nWidth*0.24, 4, \'\', \'L:R\'); $this->oPdf->cell($nWidth*0.10, 4, \'\', \'L:R\', 1); $this->oPdf->cell($nWidth*0.33, 4, \"Matr?cula\", \'L:R\'); $this->oPdf->cell($nWidth*0.33, 4, \'\', \'L:R\'); $this->oPdf->cell($nWidth*0.24, 4, \'\', \'L:R\'); $this->oPdf->cell($nWidth*0.10, 4, \'\', \'L:R\', 1); $this->oPdf->cell($nWidth*0.33, 4, \"Assinatura\", \'L:R:B\'); $this->oPdf->cell($nWidth*0.33, 4, \'\', \'L:R:B\'); $this->oPdf->cell($nWidth*0.24, 4, \'\', \'L:R:B\'); $this->oPdf->cell($nWidth*0.10, 4, \'\', \'L:R:B\', 1);' ,0 ,0 ,1 ,'J' ,0 ,0 ,3
    from db_paragrafopadrao_97248;

insert into db_docparagpadrao( db62_coddoc ,db62_codparag ,db62_ordem )
  select db60_coddoc, db_paragrafopadrao_97248.sequencial, db60_instit
    from db_documentopadrao inner join db_paragrafopadrao_97248 on db_paragrafopadrao_97248.codigo = db60_instit where db60_tipodoc = 5015;


update db_menu set menusequencia = 11 where id_item_filho = 8066;
update db_menu set menusequencia = 12 where id_item_filho = 8699;
update db_menu set menusequencia = 13 where id_item_filho = 8704;



/*
 * Menus do Registro de Pre?o
 */
insert into db_itensmenu values(10004, 'Por Quantidade', 'Registro de pre?o por quantidade', '', '1', '1', 'Registro de pre?o por quantidade', '1'	);
insert into db_itensmenu values(10005, 'Por Valor', 'Registro de pre?o por valor', '', '1', '1', 'Registro de pre?o por valor', '1'	);
insert into db_menu values(7941, 10004, 8, 28);
insert into db_menu values(7941, 10005, 9, 28);
update db_menu set id_item = 10004 where id_item = 7941 and id_item_filho in (7942, 7943, 7962);

insert into db_itensmenu values( 10006, 'Abertura', 'Abertura do registro de pre?o controlado por valor', 'com4_aberturaregistroprecoporvalor001.php', '1', '1', 'Abertura do registro de pre?o controlado por valor', '1'	);
insert into db_itensfilho (id_item, codfilho) values(10006,1);

insert into db_itensmenu values( 10007, 'Manifestar Interesse', 'Manifestar interesse em um registro de pre?o controlado por valor', '', '1', '1', 'Manifestar interesse em um registro de pre?o controlado por valor', '1'	);
insert into db_itensfilho (id_item, codfilho) values(10007,1);

insert into db_itensmenu values( 10008, 'Compila??o', 'Processamento do registro de pre?o controlado por valor', '', '1', '1', 'Processamento do registro de pre?o controlado por valor', '1'	);
insert into db_itensmenu values( 10009, 'Inclus?o', 'Processamento do registro de pre?o controlado por valor', 'com4_processamentoregistroprecoporvalor001.php', '1', '1', 'compila??o do registro de pre?o controlado por valor', '1'	);
insert into db_itensmenu (id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10010 ,'Anula??o' ,'Anula??o da Compila??o' ,'com4_anulcompregistro001.php?formacontrole=2' ,'1' ,'1' ,'Anula??o da Compila??o' , 'true' );
insert into db_itensfilho (id_item, codfilho) values(10008, 1);
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10008 ,10010 ,2 ,28 );

insert into db_menu (id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10008 ,10009 ,1 ,28 );
insert into db_menu values(10005, 10006, 1, 28);
insert into db_menu values(10005, 10007, 2, 28);
insert into db_menu values(10005, 10008, 3, 28);

update db_menu set menusequencia = 1 where id_item_filho = 10004 and id_item = 7941;
update db_menu set menusequencia = 2 where id_item_filho = 10005 and id_item = 7941;

update db_menu set id_item = 7941, menusequencia=6  where id_item_filho in (7968) and id_item = 7962;
update db_menu set id_item = 7941, menusequencia=6  where id_item_filho in (7969) and id_item = 7962;


insert into db_itensmenu values( 10011, 'Inclus?o', 'Abertura de um registro de pre?o por valor', 'com4_aberturaregistroprecoporvalor001.php?opcao=1', '1', '1', 'Inclus?o de um registro de pre?o', '1'	);
insert into db_itensfilho (id_item, codfilho) values(10011,1);
insert into db_itensmenu values( 10012, 'Altera??o', 'Altera a abertura de um registro de pre?o', 'com4_aberturaregistroprecoporvalor001.php?opcao=2', '1', '1', 'Altera a abertura de um registro de pre?o', '1'	);
insert into db_itensfilho (id_item, codfilho) values(10012,1);
insert into db_itensmenu values( 10013, 'Anula??o', 'Anula a abertura de um registro de pre?o', 'com4_anulabertregistro001.php?formacontrole=2', '1', '1', 'Anula??o de um registro de pre?o', '1'	);
insert into db_itensfilho (id_item, codfilho) values(10013,1);
insert into db_menu values(10006,10011,1,28);
insert into db_menu values(10006,10012,2,28);
insert into db_menu values(10006,10013,3,28);


insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
  values ( 10014 ,'Inclus?o' ,'Inclus?o de Estimativa de Registro de Pre?o por Valor' ,'com4_manifestarinteresseregistroprecoporvalor001.php?acao=1' ,'1' ,'1' ,'Inclus?o de Registro de Pre?o por Valor' ,'true' );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
  values ( 10015 ,'Altera??o' ,'Altera??o de Estimativa de Registro de Pre?o por Valor' ,'com4_manifestarinteresseregistroprecoporvalor001.php?acao=2' ,'1' ,'1' ,'Altera??o de Registro de Pre?o por Valor' ,'true' );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
  values ( 10016 ,'Anula??o' ,'Anula??o de Estimativa de Registro de Pre?o por Valor' ,'com4_anulestimregistro001.php?formacontrole=2' ,'1' ,'1' ,'Anula??o de Estimativa de Registro de Pre?o por Valor' ,'true' );

insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10007 ,10014 ,1 ,28 );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10007 ,10015 ,2 ,28 );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10007 ,10016 ,3 ,28 );


insert into db_syscampo values(20853,'pc54_formacontrole','int4','Forma de controle de um registro de pre?o controlado ou por valor ou por quantidade 1 - Quantidade 2 - Valor','0', 'Forma de Controle',10,'f','f','f',1,'text','Forma de Controle');
insert into db_sysarqcamp values(2679,20853,6,0);
insert into db_syscampo values(20854,'l20_formacontroleregistropreco','int4','Forma de Controle do Registro de Pre?o','1', 'Forma de Controle do RP',10,'t','f','f',1,'text','Forma de Controle do RP');
insert into db_syscampodef values(20854,'1','Por Quantidade');
insert into db_syscampodef values(20854,'2','Por Valor');
insert into db_sysarqcamp values(1260,20854,26,0);
insert into db_syscampo values(20855,'pc23_percentualdesconto','float4','Percentual do Desconto','0', 'Percentual do Desconto',10,'t','f','f',4,'text','Percentual do Desconto');
insert into db_sysarqcamp values(863,20855,8,0);


insert into db_itensmenu values( 10020, 'Execu??o Financeira', 'Visualizar a execu??o financeira do acordo', 'con4_mapaexecucao001.php?execucao=2', '1', '1', 'con4_mapaexecucao001.php?execucao=2', '1'	);
insert into db_itensfilho (id_item, codfilho) values(10020,1);
insert into db_itensmenu values( 10021, 'Execu??o do Contrato', 'Visualizar os dados com base na execu??o do contrato', 'con4_mapaexecucao001.php?execucao=1', '1', '1', 'Visualizar os dados com base na execu??o do contrato', '1'	);
insert into db_itensfilho (id_item, codfilho) values(10021,1);
insert into db_menu values(9937,10021,1,8251);
insert into db_menu values(9937,10020,2,8251);

/**
 * 97317 - Encerramento do exercicio
 */
insert into db_sysarquivo
     values (3756, 'regraencerramentonaturezaorcamentaria', 'Regra Encerramento Natureza Or?ament?ria', 'c117', '2014-11-21', 'Regra Encerramento Natureza Or?ament?ria', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (32, 3756);

insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel )
  values ( 20874 ,'c117_sequencial' ,'int4' ,'Sequencial' ,'' ,'Sequencial' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Sequencial' ),
         ( 20875 ,'c117_anousu' ,'int4' ,'Ano' ,'' ,'Ano' ,4 ,'false' ,'false' ,'false' ,1 ,'text' ,'Ano' ),
         ( 20876 ,'c117_instit' ,'int4' ,'Institui??o' ,'' ,'Institui??o' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Institui??o' ),
         ( 20877 ,'c117_contadevedora' ,'varchar(15)' ,'Se refere ao estrutural do PCASP' ,'' ,'Conta Devedora' ,15 ,'false' ,'true' ,'false' ,0 ,'text' ,'Conta Devedora' ),
         ( 20878 ,'c117_contacredora' ,'varchar(15)' ,'Se refere ao estrutural do PCASP' ,'' ,'Conta Credora' ,15 ,'false' ,'true' ,'false' ,0 ,'text' ,'Conta Credora' );

insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia )
     values ( 3756 ,20874 ,1 ,0 ),
            ( 3756 ,20875 ,2 ,0 ),
            ( 3756 ,20876 ,3 ,0 ),
            ( 3756 ,20877 ,4 ,0 ),
            ( 3756 ,20878 ,5 ,0 );

insert into db_syssequencia
     values (1000419, 'regraencerramentonaturezaorcamentaria_c117_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

update db_sysarqcamp
   set codsequencia = 1000419
 where codarq = 3756 and codcam = 20874;

insert into db_sysprikey (codarq,codcam,sequen,camiden)
     values (3756, 20874, 1, 20874);

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
     values ( 10022 ,'Encerramento do Exerc?cio PCASP' ,'Encerramento do Exerc?cio PCASP' ,'con4_processaencerramentopcasp.php' ,'1' ,'1' ,'Encerramento do Exerc?cio PCASP' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo )
     values ( 4197 ,10022 ,14 ,209 );

insert into conencerramentotipo
     values (6, 'Encerramento das Varia??es Patrimoniais'),
            (7, 'Natureza Or?ament?ria de controle');

insert into conhistdoc
     values (1008, 'INSCRI??O DE RP PROCESSADOS', 1000),
            (1009, 'ENCERRAMENTO VARIA??ES PATRIMONIAIS', 1000),
            (1010, 'ENCERRAMENTO NATUREZA OR?AMENTARIA E CONTROLE', 1000);

select setval('vinculoeventoscontabeis_c115_sequencial_seq', (select max(c115_sequencial)+1 from vinculoeventoscontabeis));

insert into vinculoeventoscontabeis (c115_sequencial, c115_conhistdocinclusao, c115_conhistdocestorno )
     values (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 1008, null),
            (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 1009, null),
            (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 1010, null);


insert into db_syscampo values(20879,'pc67_processoadministrativo','varchar(20)','Processo administrativo','', 'Processo Administrativo',20,'t','t','f',0,'text','Processo Administrativo');
delete from db_sysarqcamp where codarq = 3020;
insert into db_sysarqcamp values(3020,17093,1,1920);
insert into db_sysarqcamp values(3020,17094,2,0);
insert into db_sysarqcamp values(3020,17095,3,0);
insert into db_sysarqcamp values(3020,17096,4,0);
insert into db_sysarqcamp values(3020,17097,5,0);
insert into db_sysarqcamp values(3020,17098,6,0);
insert into db_sysarqcamp values(3020,20879,7,0);

insert into db_itensmenu values(10023, 'Anula??o', 'Anula a solicita??o de compras', 'com4_anularsolicitacaocompras001.php', '1', '1', 'Anula a solicita??o de compras.', '1'	);
insert into db_itensfilho (id_item, codfilho) values(10023,1);
insert into db_menu values(3485,10023,5,28);


/**
 * [FINANCEIRO - FIM]
 */
----------------------------------------------------
---- TRIBUTARIO
----------------------------------------------------
delete from db_sysprikey where codarq = 410;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(410,2482,1,2483);
delete from db_sysprikey where codarq = 13;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(13,56,1,57);

update db_syscampo set rotulo = 'Exerc?cio', rotulorel = 'Exerc?cio' where codcam = 9667;
insert into db_sysarquivo values (3750, 'tipolicenca', 'Tabela que registra os tipos de licen?as ambientais', 'am09', '2014-11-13', 'Tipos de Licen?as', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (64,3750);
insert into db_syscampo values(20844,'am09_sequencial','int4','Tipo de Licen?as','0', 'Tipo de Licen?a',10,'f','f','f',1,'text','Tipo de Licen?a');
insert into db_syscampo values(20845,'am09_descricao','varchar(50)','Descri??o da Licen?a','', 'Descri??o da Licen?a',50,'f','f','f',3,'text','Descri??o da Licen?a');
delete from db_sysarqcamp where codarq = 3750;
insert into db_sysarqcamp values(3750,20844,1,0);
insert into db_sysarqcamp values(3750,20845,2,0);
delete from db_sysprikey where codarq = 3750;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3750,20844,1,20845);
delete from db_sysforkey where codarq = 3744 and referen = 0;
insert into db_sysforkey values(3744,20811,1,3750,0);
insert into db_sysarquivo values (3751, 'condicionante', 'Condicionantes para Pareceres T?cnicos Ambientais', 'am10', '2014-11-13', 'Condicionante', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (64,3751);
insert into db_syscampo values(20846,'am10_sequencial','int4','C?digo da Condicionante','0', 'Condicionante',10,'f','f','f',1,'text','Condicionante');
insert into db_syscampo values(20847,'am10_descricao','text','Descri??o da Condicionante','', 'Descri??o',300,'f','f','f',0,'text','Descri??o');
insert into db_syscampo values(20848,'am10_padrao','bool','Condicionante Padr?o','false', 'Padr?o',1,'f','f','f',5,'text','Padr?o');
insert into db_syscampo values(20849,'am10_tipolicenca','int4','Tipo de Licen?a','0', 'Tipo de Licen?a',10,'t','f','f',1,'text','Tipo de Licen?a');
delete from db_sysarqcamp where codarq = 3751;
insert into db_sysarqcamp values(3751,20846,1,0);
insert into db_sysarqcamp values(3751,20847,2,0);
insert into db_sysarqcamp values(3751,20848,3,0);
insert into db_sysarqcamp values(3751,20849,4,0);
delete from db_sysprikey where codarq = 3751;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3751,20846,1,20847);
delete from db_sysforkey where codarq = 3751 and referen = 0;
insert into db_sysforkey values(3751,20849,1,3750,0);
insert into db_syssequencia values(1000412, 'tipolicenca_am09_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000412 where codarq = 3750 and codcam = 20844;
insert into db_syssequencia values(1000413, 'condicionante_am10_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000413 where codarq = 3751 and codcam = 20846;
insert into db_sysarquivo values (3752, 'condicionanteatividadeimpacto', 'V?nculo entre condicionantes e atividades', 'am11', '2014-11-13', 'Condicionante/Atividade', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (64,3752);
insert into db_syscampo values(20850,'am11','int4','Condicionante/Atividade','0', 'Condicionante/Atividade',10,'f','f','f',1,'text','Condicionante/Atividade');
insert into db_syscampo values(20851,'am11_condicionante','int4','Condicionante','0', 'Condicionante',10,'f','f','f',1,'text','Condicionante');
update db_syscampo set nomecam = 'am11_sequencial', conteudo = 'int4', descricao = 'Condicionante/Atividade', valorinicial = '0', rotulo = 'Condicionante/Atividade', nulo = 'f', tamanho = 10, maiusculo = 'f', autocompl = 'f', aceitatipo = 1, tipoobj = 'text', rotulorel = 'Condicionante/Atividade' where codcam = 20850;
delete from db_syscampodep where codcam = 20850;
delete from db_syscampodef where codcam = 20850;
insert into db_syscampo values(20852,'am11_atividadeimpacto','int4','Atividade','0', 'Atividade',10,'f','f','f',1,'text','Atividade');
delete from db_sysarqcamp where codarq = 3752;
insert into db_sysarqcamp values(3752,20850,1,0);
insert into db_sysarqcamp values(3752,20851,2,0);
insert into db_sysarqcamp values(3752,20852,3,0);
delete from db_sysprikey where codarq = 3752;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3752,20850,1,20851);
delete from db_sysforkey where codarq = 3752 and referen = 0;
insert into db_sysforkey values(3752,20852,1,3737,0);
delete from db_sysforkey where codarq = 3752 and referen = 0;
insert into db_sysforkey values(3752,20851,1,3751,0);
insert into db_syssequencia values(1000414, 'condicionanteatividadeimpacto_am11_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
delete from db_syssequencia where codsequencia in ( 1000412,  1000413, 1000414);
update db_sysarqcamp set codsequencia = 1000414 where codarq = 3752 and codcam = 20850;
insert into db_sysindices values(4137,'condicionanteatividadeimpacto_condicionante_atividadeimpacto_in',3752,'1');
insert into db_syscadind values(4137,20851,1);
insert into db_syscadind values(4137,20852,2);

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10000 ,'Condicionantes' ,'Cadastro de Condicionantes' ,'' ,'1' ,'1' ,'Cadastro de Condicionantes' ,'true' );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10001 ,'Inclus?o' ,'Inclus?o de Condicionantes' ,'amb1_condicionante001.php' ,'1' ,'1' ,'Inclus?o de Condicionantes' ,'true' );
delete from db_menu where id_item_filho = 10000 AND modulo = 7808;
delete from db_menu where id_item_filho in ( 10000, 10001, 10002, 10003 ) AND modulo = 7808;
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 29 ,10000 ,258 ,7808 );
delete from db_menu where id_item_filho = 10001 AND modulo = 7808;
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10000 ,10001 ,1 ,7808 );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10002 ,'Altera??o' ,'Altera??o de Condicionante' ,'amb1_condicionante002.php' ,'1' ,'1' ,'Altera??o de Condicionante' ,'true' );
delete from db_menu where id_item_filho = 10002 AND modulo = 7808;
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10000 ,10002 ,2 ,7808 );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10003 ,'Exclus?o' ,'Exclus?o de Condicionante' ,'amb1_condicionante003.php' ,'1' ,'1' ,'Exclus?o de Condicionante' ,'true' );
delete from db_menu where id_item_filho = 10003 AND modulo = 7808;
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10000 ,10003 ,3 ,7808 );

update db_sysarquivo set nomearq = 'parecertecnico', descricao = 'Cadastro de Emissao de Pareceres T?cnicos', sigla = 'am08', dataincl = '2014-11-18', rotulo = 'Cadastro de Emissao de Pareceres T?cnicos', tipotabela = 0, naolibclass = 'f', naolibfunc = 'f', naolibprog = 'f', naolibform = 'f' where codarq = 3744;
delete from db_sysarqarq where codarq = 3744;
insert into db_sysarqarq values(0,3744);
update db_syscampo set nomecam = 'am08_pareceranterior', conteudo = 'int4', descricao = 'C?digo do Parecer Anterior a ser prorrogado ou renovado', valorinicial = '0', rotulo = 'Parecer Anterior', nulo = 't', tamanho = 10, maiusculo = 'f', autocompl = 'f', aceitatipo = 1, tipoobj = 'text', rotulorel = 'Parecer Anterior' where codcam = 20808;
delete from db_syscampodep where codcam = 20808;
delete from db_syscampodef where codcam = 20808;
insert into db_syscampo values(20856,'am08_datageracao','date','Data de Gera??o','null', 'Data de Gera??o',10,'f','f','f',0,'text','Data de Gera??o');
insert into db_syscampo values(20857,'am08_favoravel','bool','Parecer Favor?vel','f', 'Favor?vel',1,'f','f','f',5,'text','Favor?vel');
insert into db_syscampo values(20858,'am08_observacao','text','Observa??es','', 'Observa??es',1,'f','f','f',0,'text','Observa??es');
insert into db_syscampo values(20872,'am08_arquivo','oid','Arquivo Parecer T?cnico','', 'Arquivo Parecer T?cnico',1,'f','f','f',1,'text','Arquivo Parecer T?cnico');
delete from db_sysarqcamp where codarq = 3744;
insert into db_sysarqcamp values(3744,20805,1,1000406);
insert into db_sysarqcamp values(3744,20806,2,0);
insert into db_sysarqcamp values(3744,20807,3,0);
insert into db_sysarqcamp values(3744,20808,4,0);
insert into db_sysarqcamp values(3744,20809,5,0);
insert into db_sysarqcamp values(3744,20810,6,0);
insert into db_sysarqcamp values(3744,20811,7,0);
insert into db_sysarqcamp values(3744,20856,8,0);
insert into db_sysarqcamp values(3744,20857,9,0);
insert into db_sysarqcamp values(3744,20858,10,0);
insert into db_sysarqcamp values(3744,20872,11,0);
insert into db_sysarquivo values (3753, 'parecertecnicocondicionante', 'V?nculo entre parecer e condicionantes', 'am12', '2014-11-18', 'Parecer/Condicionante', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (64,3753);
insert into db_syscampo values(20859,'am12_sequencial','int4','V?nculo entre parecer e condicionantes','0', 'Condicionante',10,'f','f','f',1,'text','Condicionante');
update db_sysindices set nomeind = 'parecertecnico_sequencial_in',campounico = '1' where codind = 4126;
delete from db_syscadind where codind = 4126;
insert into db_syscadind values(4126,20805,1);
update db_syssequencia set nomesequencia = 'licencaempreendimento_am08_sequencial_seq', incrseq = 1, minvalueseq = 1, maxvalueseq = 9223372036854775807, startseq = 1, cacheseq = 1 where codsequencia = 1000406;
update db_sysarqcamp set codsequencia = 1000406 where codarq = 3744 and codcam = 20805;
insert into db_syscampo values(20860,'am12_parecertecnico','int4','Parecer T?cnico','0', 'Parecer T?cnico',10,'f','f','f',1,'text','Parecer T?cnico');
insert into db_syscampo values(20861,'am12_arquivo','oid','Licen?a','', 'Licen?a',1,'f','f','f',0,'text','Licen?a');
delete from db_sysarqcamp where codarq = 3753;
insert into db_sysarqcamp values(3753,20859,1,0);
insert into db_sysarqcamp values(3753,20860,2,0);
insert into db_sysarqcamp values(3753,20861,3,0);
delete from db_sysprikey where codarq = 3753;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3753,20859,1,20861);
delete from db_sysforkey where codarq = 3753 and referen = 0;
insert into db_sysforkey values(3753,20860,1,3744,0);
insert into db_syscampo values(20862,'am12_condicionante','int4','Condicionante','0', 'Condicionante',10,'f','f','f',1,'text','Condicionante');
delete from db_sysarqcamp where codarq = 3753;
insert into db_sysarqcamp values(3753,20859,1,0);
insert into db_sysarqcamp values(3753,20860,2,0);
insert into db_sysarqcamp values(3753,20862,3,0);
delete from db_sysforkey where codarq = 3753 and referen = 0;
insert into db_sysforkey values(3753,20862,1,3751,0);
insert into db_syssequencia values(1000415, 'parecertecnicocondicionante_am12_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000415 where codarq = 3753 and codcam = 20859;

delete from db_menu where id_item_filho = 9981 AND modulo = 7808;
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 30 ,9981 ,440 ,7808 );
update db_itensmenu set descricao = 'Emiss?o de Licen?a' where id_item = 9981;
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10018 ,'Emiss?o de Parecer T?cnico' ,'Emiss?o de Parecer T?cnico' ,'amb4_emissaodeparecertecnico001.php' ,'1' ,'1' ,'Emiss?o de Parecer T?cnico' ,'true' );
delete from db_menu where id_item_filho = 10018 AND modulo = 7808;
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 32 ,10018 ,451 ,7808 );

insert into db_sysarquivo values (3754, 'licencaempreendimento', 'Licen?a', 'am13', '2014-11-18', 'Licen?a', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (64,3754);
insert into db_syscampo values(20863,'am13_sequencial','int4','Licen?a','0', 'Licen?a',10,'f','f','f',1,'text','Licen?a');
insert into db_syscampo values(20864,'am13_parecertecnico','int4','Parecer T?cnico','0', 'Parecer T?cnico',10,'f','f','f',1,'text','Parecer T?cnico');
insert into db_syscampo values(20865,'am13_arquivo','oid','Arquivo da Licen?a','', 'Arquivo',1,'f','f','f',0,'text','Arquivo');
delete from db_sysarqcamp where codarq = 3754;
insert into db_sysarqcamp values(3754,20863,1,0);
insert into db_sysarqcamp values(3754,20864,2,0);
insert into db_sysarqcamp values(3754,20865,3,0);
delete from db_sysprikey where codarq = 3754;
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3754,20863,1,20865);
delete from db_sysforkey where codarq = 3754 and referen = 0;
insert into db_sysforkey values(3754,20864,1,3744,0);
insert into db_syssequencia values(1000416, 'licencaempreendimento_am13_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000416 where codarq = 3754 and codcam = 20863;

--Template tipo e padr?o
insert into db_documentotemplatetipo ( db80_sequencial, db80_descricao ) values ( 52, 'Parecer T?cnico Favor?vel' );
insert into db_documentotemplatetipo ( db80_sequencial, db80_descricao ) values ( 53, 'Parecer T?cnico Desfavor?vel' );
insert into db_documentotemplatetipo ( db80_sequencial, db80_descricao ) values ( 54, 'Licen?a Ambiental' );
insert into db_documentotemplatepadrao ( db81_sequencial, db81_templatetipo, db81_nomearquivo, db81_descricao ) values ( 55 , 52, 'documentos/templates/meioambiente/parecer_tecnico_favoravel.sxw',    'Parecer T?cnico Favor?vel'    );
insert into db_documentotemplatepadrao ( db81_sequencial, db81_templatetipo, db81_nomearquivo, db81_descricao ) values ( 56 , 53, 'documentos/templates/meioambiente/parecer_tecnico_desfavoravel.sxw', 'Parecer T?cnico Desfavor?vel' );
insert into db_documentotemplatepadrao ( db81_sequencial, db81_templatetipo, db81_nomearquivo, db81_descricao ) values ( 57 , 54, 'documentos/templates/meioambiente/licenca_ambiental.sxw', 'Licen?a Ambiental' );

update db_syscampo set nomecam = 'am08_sequencial', conteudo = 'int4', descricao = 'Parecer T?cnico', valorinicial = '0', rotulo = 'Parecer T?cnico', nulo = 'f', tamanho = 10, maiusculo = 'f', autocompl = 'f', aceitatipo = 1, tipoobj = 'text', rotulorel = 'Parecer T?cnico' where codcam = 20805;

----------------------------------------------------
---- FIM TRIBUTARIO
----------------------------------------------------

----------------------------------------------------
---- FOLHA
----------------------------------------------------

-- 96909
INSERT INTO db_itensmenu(id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
VALUES (9997,  'Manuten??o e-Cidade Online', 'Manuten??o e-Cidade Online', '',                                         '1', '1', 'Libera a gera??o de contacheques da folha',        'true'),
       (9999,  'Liberar Folhas',             'Liberar Folhas',             'pes4_liberarfolhadbpref001.php',           '1', '1', 'Libera a gera??o de contracheques no DBPref',      'true'),
       (10017, 'Gerar Arquivo de Retorno',   'Gerar Arquivo de Retorno',   'pes4_geracaoarquivoretornoeconsig001.php', '1', '1', 'Rotina de gera??o do arquivo de retorno econsig.', 'true');

INSERT INTO db_menu(id_item, id_item_filho, menusequencia, modulo)
VALUES (1818, 9997,  103, 952),
       (9997, 9999,  2,   952),
       (9866, 10017, 3,   952);

update db_menu set menusequencia =  1 where id_item = 1818 and modulo = 952 and id_item_filho = 5016;
update db_menu set menusequencia =  2 where id_item = 1818 and modulo = 952 and id_item_filho = 9767;
update db_menu set menusequencia =  3 where id_item = 1818 and modulo = 952 and id_item_filho = 5050;
update db_menu set menusequencia =  4 where id_item = 1818 and modulo = 952 and id_item_filho = 5047;
update db_menu set menusequencia =  5 where id_item = 1818 and modulo = 952 and id_item_filho = 5112;
update db_menu set menusequencia =  6 where id_item = 1818 and modulo = 952 and id_item_filho = 5156;
update db_menu set menusequencia =  7 where id_item = 1818 and modulo = 952 and id_item_filho = 4504;
update db_menu set menusequencia =  8 where id_item = 1818 and modulo = 952 and id_item_filho = 9958;
update db_menu set menusequencia =  9 where id_item = 1818 and modulo = 952 and id_item_filho = 9959;
update db_menu set menusequencia = 10 where id_item = 1818 and modulo = 952 and id_item_filho = 9972;
update db_menu set menusequencia = 11 where id_item = 1818 and modulo = 952 and id_item_filho = 9997;
update db_menu set menusequencia = 12 where id_item = 1818 and modulo = 952 and id_item_filho = 5036;
update db_menu set menusequencia = 13 where id_item = 1818 and modulo = 952 and id_item_filho = 5005;
update db_menu set menusequencia = 14 where id_item = 1818 and modulo = 952 and id_item_filho = 4755;
update db_menu set menusequencia = 15 where id_item = 1818 and modulo = 952 and id_item_filho = 5106;
update db_menu set menusequencia = 16 where id_item = 1818 and modulo = 952 and id_item_filho = 5110;
update db_menu set menusequencia = 17 where id_item = 1818 and modulo = 952 and id_item_filho = 8815;
update db_menu set menusequencia = 18 where id_item = 1818 and modulo = 952 and id_item_filho = 5204;
update db_menu set menusequencia = 19 where id_item = 1818 and modulo = 952 and id_item_filho = 5280;
update db_menu set menusequencia = 20 where id_item = 1818 and modulo = 952 and id_item_filho = 5305;
update db_menu set menusequencia = 21 where id_item = 1818 and modulo = 952 and id_item_filho = 5234;
update db_menu set menusequencia = 22 where id_item = 1818 and modulo = 952 and id_item_filho = 5136;
update db_menu set menusequencia = 23 where id_item = 1818 and modulo = 952 and id_item_filho = 3516;
update db_menu set menusequencia = 24 where id_item = 1818 and modulo = 952 and id_item_filho = 331384;
update db_menu set menusequencia = 25 where id_item = 1818 and modulo = 952 and id_item_filho = 782400;
update db_menu set menusequencia = 26 where id_item = 1818 and modulo = 952 and id_item_filho = 5196;
update db_menu set menusequencia = 27 where id_item = 1818 and modulo = 952 and id_item_filho = 7150;
update db_menu set menusequencia = 28 where id_item = 1818 and modulo = 952 and id_item_filho = 7570;
update db_menu set menusequencia = 29 where id_item = 1818 and modulo = 952 and id_item_filho = 7684;
update db_menu set menusequencia = 30 where id_item = 1818 and modulo = 952 and id_item_filho = 8679;
update db_menu set menusequencia = 31 where id_item = 1818 and modulo = 952 and id_item_filho = 8806;
update db_menu set menusequencia = 32 where id_item = 1818 and modulo = 952 and id_item_filho = 8827;
update db_menu set menusequencia = 33 where id_item = 1818 and modulo = 952 and id_item_filho = 9514;
update db_menu set menusequencia = 34 where id_item = 1818 and modulo = 952 and id_item_filho = 9793;

--97262
insert into db_sysarquivo   values (3755, 'econsigmotivo', 'Tabela respons?vel por armazenar as justificativas dos servidores.', 'rh147', '2014-11-18', 'E-Consig Motivo', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqarq    values (0,3755);
insert into db_sysarqmod    values (28,3755);
insert into db_syscampo     values (20869,'rh147_sequencial','int4','Identificador ?nico da tabela.','', 'Sequencial',10,'f','f','f',1,'text','Sequencial');
insert into db_syscampo     values (20870,'rh147_motivo','varchar(100)','S?o os motivos dispon?veis do E-Consig para os servidores.','', 'Motivo',100,'f','t','f',0,'text','Motivo');
insert into db_syssequencia values (1000418, 'econsigmotivo_rh147_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
insert into db_sysarqcamp   values (3755,20869,1,1000418);
insert into db_sysarqcamp   values (3755,20870,2,0);
insert into db_sysprikey    values (3755,20869,1,20869);
insert into db_sysindices   values (4139, 'econsigmotivo_sequencial_in',3755,0);
insert into db_syscadind    values (4139,20869,1);

insert into db_syscampo     values (20871,'rh134_econsigmotivo','int4','Relacionamento com a tabela econsigmotivo.','', 'Motivo',10,'t','f','f',1,'text','Motivo');
insert into db_sysarqcamp   values (3676,20871,4,0);
insert into db_sysforkey    values (3676,20871,1,3755,1);
----------------------------------------------------
--- Layout Retorno e-Consig
----------------------------------------------------
/**
 * db_layouttxt
 */
insert into db_layouttxt    values (220, 'ARQUIVO REMESSA E-CONSIG', 0, 'Arquivo de remessa de integra??o com o sistema e-consig.', 1);

/**
 * db_layoutlinha
 */
insert into db_layoutlinha  values (723, 220, 'REGISTRO', 3, 148, 0, 0, 'linha de registro', '', false);

/**
 * db_layoutcampos
 */
insert into db_layoutcampos values (11841, 723, 'matricula', 'MATR?CULA DO SERVIDOR', 2, 1, '', 10, false, true, 'e', '', 0);
insert into db_layoutcampos values (11842, 723, 'cpf', 'CPF DO SERVIDOR', 1, 11, '', 11, false, true, 'e', '', 0);
insert into db_layoutcampos values (11843, 723, 'nome', 'NOME DO SERVIDOR', 1, 22, '', 50, false, true, 'd', '', 0);
insert into db_layoutcampos values (11844, 723, 'estabelecimento', 'CODIGO DO ESTABELECIMENTO DO SERVIDOR', 2, 72, '', 3, false, true, 'e', '', 0);
insert into db_layoutcampos values (11845, 723, 'orgao', 'CODIGO DO ORGAO DO SERVIDOR', 2, 75, '', 3, false, true, 'e', '', 0);
insert into db_layoutcampos values (11846, 723, 'rubrica', 'RUBRICA DE DESCONTO DO SERVIDOR', 1, 78, '', 4, false, true, 'e', '', 0);
insert into db_layoutcampos values (11847, 723, 'desconto_previsto', 'VALOR DO DESCONTO PREVISTO', 1, 82, '', 10, false, true, 'e', '', 0);
insert into db_layoutcampos values (11848, 723, 'desconto_realizado', 'VALOR DO DESCONTO REALIZADO', 1, 92, '', 10, false, true, 'e', '', 0);
insert into db_layoutcampos values (11849, 723, 'competencia', 'COMPETENCIA(PER?ODO)', 2, 102, '', 6, false, true, 'e', '', 0);
insert into db_layoutcampos values (11850, 723, 'situacao', 'SITUA??O', 1, 108, '', 40, false, true, 'd', '', 0);
----------------------------------------------------
---- Relat?rio Importa??o
----------------------------------------------------
insert into db_syscampo values (20873, 'rh133_relatorio', 'oid', 'Esse campo ir? armazenar o relat?rio de importa??o do econsig.', '', 'Relat?rio de Importa??o', 1, 't', 'f', 'f', 0, 'text', 'Relat?rio de Importa??o');
insert into db_sysarqcamp values (3675, 20873, 6, 0);
----------------------------------------------------
---- Menu Relat?rio de Impotacao
----------------------------------------------------
insert into db_itensmenu values( 10019, 'Reemitir Relat?rio de Importa??o', 'Reemitir Relat?rio de Importa??o', 'pes4_econsigrelatorioimportacao001.php', '1', '1', 'Item de menu respons?vel por imprimir o relat?rio de import??o do e-consig', '1' );
insert into db_itensfilho (id_item, codfilho) values(10019,1008396);
insert into db_menu values(9866,10019,4,952);
----------------------------------------------------
---- Remove as refer?ncias econsig
----------------------------------------------------
delete from db_sysforkey where codcam in (20449, 20452, 20453);
----------------------------------------------------
---- Adicionado campo nome na econsig
----------------------------------------------------
insert into db_syscampo   values(20880, 'rh134_nome', 'varchar(50)', 'Nome do servidor importado na rotina e-consig.', '', 'Nome do Servidor', 50, 'f', 't', 'f', 0, 'text', 'Nome do Servidor');
insert into db_sysarqcamp values(3676, 20880, 5, 0);

------------------------
---- Altera??o Nome de Menu
------------------------
update db_itensmenu set descricao = 'Importar Arquivo de Movimento', help = 'Importar Arquivo de Movimento', funcao = 'pes4_importacaoarquivoeconsig001.php', itemativo = '1', desctec = 'Rotina respons?vel pela importa??o do arquivo enviado pela Zetra referente ao e-consig, que s?o os eventos financeiros que devem ser lan?ados no ponto do servidor', libcliente = '0' where id_item = 9898;
 
