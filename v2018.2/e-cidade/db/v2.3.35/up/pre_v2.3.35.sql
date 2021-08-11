----- TRIBUTARIO ------
insert into db_syscampo values(20929,' j38_datalancamento','date','Date de Lan�amento','null', 'Date de Lan�amento',10,'t','f','f',1,'text','Date de Lan�amento');
insert into db_sysarqcamp values(18,20929,3,0);

insert into db_sysarquivo values (3770, 'agrupamentocaracterisca', 'Caracter�sticas', 'j139', '2015-01-12', 'Caracter�sticas', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (69,3770);
insert into db_sysarquivo values (3771, 'agrupamentocaracteristicavalor', 'Agrupamento de Caracter�sticas', 'j140', '2015-01-12', 'Agrupamento Caracter�sticas', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (69,3771);
insert into db_syscampo values(20933,'j139_sequencial','int4','Caracter�stica','0', 'Caracter�stica',10,'f','f','f',1,'text','Caracter�stica');
insert into db_syscampo values(20934,'j139_anousu','int4','Exerc�cio da Caracter�stica','0', 'Exerc�cio',4,'f','f','f',1,'text','Exerc�cio');
insert into db_syscampo values(20935,'j139_agrupamentocaracteristicavalor','int4','Agrupamento','0', 'Agrupamento',10,'t','f','f',1,'text','Agrupamento');
insert into db_syscampo values(20936,'j139_caracter','int4','Caracter�stica','0', 'Caracter�stica',10,'f','f','f',1,'text','Caracter�stica');
insert into db_syscampo values(20937,'j140_sequencial','int4','Agrupamento Valor','0', 'Agrupamento Valor',10,'f','f','f',1,'text','Agrupamento Valor');
insert into db_syscampo values(20938,'j140_valor','float8','Valor das Caracteristicas','0', 'Valor',15,'f','f','f',4,'text','Valor');
update db_sysarquivo set nomearq = 'agrupamentocaracteristicavalor', descricao = 'Agrupamento de Caracter�sticas', sigla = 'j140', dataincl = '2015-01-12', rotulo = 'Agrupamento Caracter�sticas', tipotabela = 0, naolibclass = 'f', naolibfunc = 'f', naolibprog = 'f', naolibform = 'f' where codarq = 3771;
update db_sysarquivo set nomearq = 'agrupamentocaracterisca', descricao = 'Caracter�sticas', sigla = 'j139', dataincl = '2015-01-12', rotulo = 'Caracter�sticas', tipotabela = 0, naolibclass = 'f', naolibfunc = 'f', naolibprog = 'f', naolibform = 'f' where codarq = 3770;
insert into db_sysarqcamp values(3771,20937,1,0);
insert into db_sysarqcamp values(3771,20938,2,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3771,20937,1,20938);
update db_sysarquivo set nomearq = 'agrupamentocaracteristica', descricao = 'Caracter�sticas', sigla = 'j139', dataincl = '2015-01-12', rotulo = 'Caracter�sticas', tipotabela = 0, naolibclass = 'f', naolibfunc = 'f', naolibprog = 'f', naolibform = 'f' where codarq = 3770;
insert into db_syssequencia values(1000428, 'agrupamentocaracteristicavalor_j140_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000428 where codarq = 3771 and codcam = 20937;
insert into db_sysarqcamp values(3770,20933,1,0);
insert into db_sysarqcamp values(3770,20934,2,0);
insert into db_sysarqcamp values(3770,20935,3,0);
insert into db_sysarqcamp values(3770,20936,4,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3770,20933,1,20936);
insert into db_sysforkey values(3770,20935,1,3771,0);
insert into db_sysforkey values(3770,20936,1,13,0);
insert into db_syssequencia values(1000429, 'agrupamentocaracteristica_j139_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000429 where codarq = 3770 and codcam = 20933;
update db_itensmenu set descricao = 'Gerar Arquivo', help = 'Gerar arquivo', funcao = 'edu4_exportarsituacaoalunonovo001.php', itemativo = '1', desctec = 'gerar arquivo de exporta��o da situa��o do aluno', libcliente = '1' where id_item = 8043;

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10044 ,'Meio Ambiente' ,'Parametros do modulo Meio Ambiente' ,'' ,'1' ,'1' ,'Mensagens para o m�dulo Meio Ambiente' ,'false' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 9945 ,10044 ,2 ,1 );
insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10045 ,'Licen�as a Vencer' ,'Mensagem para Licen�as que ir�o vencer' ,'amb4_licencasvencer001.php' ,'1' ,'1' ,'Configura��o de mensagem para Licen�as que ir�o vencer' ,'false' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 10044 ,10045 ,1 ,1 );

insert into db_sysarquivo values (3778, 'mensagerialicenca', 'Mensagem', 'am14', '2015-02-04', 'Mensagem', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (64,3778);
insert into db_syscampo values(20974,'am14_sequencial','int4','C�digo da Mensagem','0', 'C�digo da Mensagem',10,'f','f','f',1,'text','C�digo da Mensagem');
insert into db_syscampo values(20975,'am14_assunto','varchar(100)','Assunto','', 'Assunto',100,'f','f','f',0,'text','Assunto');
insert into db_syscampo values(20976,'am14_mensagem','text','Mensagem','', 'Mensagem',500,'f','f','f',0,'text','Mensagem');
insert into db_sysarqcamp values(3778,20974,1,0);
insert into db_sysarqcamp values(3778,20975,2,0);
insert into db_sysarqcamp values(3778,20976,3,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3778,20974,1,20976);
insert into db_sysindices values(4163,'mensagerialicenca_sequencial_in',3778,'1');
insert into db_syscadind values(4163,20974,1);
insert into db_syssequencia values(1000436, 'mensagerialicenca_am14_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000436 where codarq = 3778 and codcam = 20974;
insert into db_sysarquivo values (3779, 'mensagerialicencaprocessado', 'Licen�as Notificadas', 'am15', '2015-02-04', 'Licen�as Notificadas', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (64,3779);
insert into db_syscampo values(20977,'am15_sequencial','int4','Licen�as Notificadas','0', 'Licen�as Notificadas',10,'f','f','f',1,'text','Licen�as Notificadas');
insert into db_syscampo values(20978,'am15_mensagerialicencadb_usuarios','int4','Usu�rio','0', 'Usu�rio',10,'f','f','f',1,'text','Usu�rio');
insert into db_syscampo values(20979,'am15_licencaempreendimento','int4','Licen�a','0', 'Licen�a',10,'f','f','f',1,'text','Licen�a');
insert into db_sysarqcamp values(3779,20977,1,0);
insert into db_sysarqcamp values(3779,20978,2,0);
insert into db_sysarqcamp values(3779,20979,3,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3779,20977,1,20979);
insert into db_sysindices values(4164,'mensagerialicencaprocessado_sequencial_in',3779,'1');
insert into db_syscadind values(4164,20977,1);
insert into db_sysforkey values(3779,20979,1,3754,0);
insert into db_sysarquivo values (3780, 'mensagerialicenca_db_usuarios', 'Usu�rio', 'am16', '2015-02-04', 'Usu�rio', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (64,3780);
insert into db_syscampo values(20980,'am16_sequencial','int4','Sequencial','0', 'Sequencial',10,'f','f','f',1,'text','Sequencial');
insert into db_syscampo values(20981,'am16_usuario','int4','Usu�rio','0', 'Usu�rio',10,'f','f','f',1,'text','Usu�rio');
insert into db_syscampo values(20982,'am16_dias','int4','Dias','0', 'Dias',10,'f','f','f',1,'text','Dias');
insert into db_sysarqcamp values(3780,20980,1,0);
insert into db_sysarqcamp values(3780,20981,2,0);
insert into db_sysarqcamp values(3780,20982,3,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3780,20980,1,20981);
insert into db_sysforkey values(3780,20981,1,109,0);
insert into db_syssequencia values(1000437, 'mensagerialicenca_db_usuarios_am16_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000437 where codarq = 3780 and codcam = 20980;
insert into db_sysforkey values(3779,20978,1,3780,0);
insert into db_syssequencia values(1000438, 'mensagerialicencaprocessado_am15_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000438 where codarq = 3779 and codcam = 20977;


----- FIM TRIBUTARIO ------


---------------------------
------- TIME C ------------
---------------------------
insert into db_sysarquivo values (3772, 'setorambulatorial', 'cadastro dos setores do ambulatorio', 'sd91', '2015-01-12', 'Setor ambulatorial', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (1000004,3772);
insert into db_sysarquivo values (3773, 'movimentacaoprontuario', 'Movimenta��o da ficha de atendimento ambulatorial', 'sd102', '2015-01-12', 'Movimenta��o da FAA', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (1000004,3773);
insert into db_syscampo values(20939,'sd91_codigo','int4','C�digo do setor','0', 'C�digo',10,'f','f','f',1,'text','C�digo');
insert into db_syscampo values(20940,'sd91_unidades','int4','Unidade a qual pertence o setor','0', 'Unidade',10,'f','f','f',1,'text','Unidade');
insert into db_syscampo values(20941,'sd91_descricao','varchar(60)','Nome do setor','', 'Setor',60,'f','t','f',0,'text','Setor');
insert into db_syscampo values(20942,'sd91_local','int4','Local do setor','0', 'Local',10,'f','f','f',1,'text','Local');
insert into db_syscampodef values(20942,'1','RECEP��O');
insert into db_syscampodef values(20942,'2','TRIAGEM');
insert into db_syscampodef values(20942,'3','CONSULTA M�DICA');
insert into db_syscampodef values(20942,'4','EXTERNO');
insert into db_syscampo values(20943,'sd24_setorambulatorial','int4','Setor ambulatorial','0', 'Setor ambulatorial',10,'f','f','f',1,'text','Setor ambulatorial');
insert into db_syscampo values(20944,'sd102_codigo','int4','C�digo da movimenta��o','0', 'C�digo',10,'f','f','f',1,'text','C�digo');
insert into db_syscampo values(20945,'sd102_prontuarios','int4','Ficha de atendimento ambulatorial','0', 'Ficha de atendimento',10,'f','f','f',1,'text','Ficha de atendimento');
insert into db_syscampo values(20946,'sd102_db_usuarios','int4','Usu�rio que estava logado ao gerar a movimenta��o','0', 'Usu�rio',10,'f','f','f',1,'text','Usu�rio');
insert into db_syscampo values(20947,'sd102_setorambulatorial','int4','Setor ambulatorial','0', 'Setor ambulatorial',10,'f','f','f',1,'text','Setor ambulatorial');
insert into db_syscampo values(20948,'sd102_data','date','Data da movimenta��o','null', 'Data',10,'f','f','f',1,'text','Data');
insert into db_syscampo values(20949,'sd102_hora','varchar(5)','Hora da movimenta��o','', 'Hora',5,'f','t','f',0,'text','Hora');
insert into db_syscampo values(20950,'sd102_observacao','text','Observa��o','', 'Observa��o',1,'t','t','f',0,'text','Observa��o');
insert into db_syscampo values(20951,'sd102_situacao','int4','Situa��o','', 'Situa��o',10,'f','t','f',0,'text','Situa��o');
insert into db_syscampodef values(20951,'1','ENTRADA');
insert into db_syscampodef values(20951,'2','ENCAMINHADA');
insert into db_syscampodef values(20951,'3','FINALIZADA');
insert into db_sysarqcamp values(3773,20944,1,0);
insert into db_sysarqcamp values(3773,20945,2,0);
insert into db_sysarqcamp values(3773,20946,3,0);
insert into db_sysarqcamp values(3773,20947,4,0);
insert into db_sysarqcamp values(3773,20948,5,0);
insert into db_sysarqcamp values(3773,20949,6,0);
insert into db_sysarqcamp values(3773,20951,7,0);
insert into db_sysarqcamp values(3773,20950,8,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3773,20944,1,20944);
insert into db_sysarqcamp values(3772,20939,1,0);
insert into db_sysarqcamp values(3772,20940,2,0);
insert into db_sysarqcamp values(3772,20941,3,0);
insert into db_sysarqcamp values(3772,20942,4,0);
insert into db_sysforkey values(3772,20940,1,100011,0);
insert into db_sysindices values(4148,'setorambulatorial_unidades_in',3772,'0');
insert into db_syscadind values(4148,20940,1);
insert into db_sysarqcamp values(1010134,20943,21,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3772,20939,1,20941);
insert into db_sysforkey values(1010134,20943,1,3772,0);
insert into db_sysindices values(4149,'prontuarios_setorambulatorial_in',1010134,'0');
insert into db_syscadind values(4149,20943,1);
insert into db_sysforkey values(3773,20945,1,1010134,0);
insert into db_sysforkey values(3773,20946,1,109,0);
insert into db_sysforkey values(3773,20947,1,3772,0);
insert into db_sysindices values(4150,'movimentacaoprontuario_prontuarios_in',3773,'0');
insert into db_syscadind values(4150,20945,1);
insert into db_sysindices values(4151,'movimentacaoprontuario_db_usuarios_in',3773,'0');
insert into db_syscadind values(4151,20946,1);
insert into db_sysindices values(4152,'movimentacaoprontuario_setorambulatorial_in',3773,'0');
insert into db_syscadind values(4152,20947,1);
insert into db_syssequencia values(1000430, 'movimentacaoprontuario_sd102_codigo_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000430 where codarq = 3773 and codcam = 20944;
insert into db_syssequencia values(1000431, 'setorambulatorial_sd91_codigo_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000431 where codarq = 3772 and codcam = 20939;

insert into db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente )
  values (10035, 'Setor Ambulatorial', 'Cadastro de Setor Ambulatorial', '', '1', 1, 'Cadastro de Setor Ambulatorial', '1');
insert into db_processa (codarq, id_item) values (3772, 10035);
insert into db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
  values (10036, 'Inclus�o', 'Inclus�o de Setor Ambulatorial', 'amb1_setorambulatorial001.php', '1', 1, 'Inclus�o de Setor Ambulatorial', '1');
insert into db_arquivos values(5836, 'amb1_setorambulatorial001.php', 'Inclus�o: cadastro dos setores do ambulatorio');
insert into db_itensfilho values(10036, 5836);
insert into db_processa (codarq, id_item) values (3772, 10036);
insert into db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
 values (10037, 'Altera��o', 'Altera��o de Setor Ambulatorial', 'amb1_setorambulatorial002.php', '1', 1, 'Altera��o de Setor Ambulatorial', '1');
insert into db_arquivos values(5837, 'amb1_setorambulatorial002.php', 'Inclus�o: cadastro dos setores do ambulatorio');
insert into db_itensfilho values(10037, 5837);
insert into db_processa (codarq, id_item) values (3772, 10037);
insert into db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
  values (10038, 'Exclus�o', 'Exclus�o de Setor Ambulatorial', 'amb1_setorambulatorial003.php', '1', 1, 'Exclus�o de Setor Ambulatorial', '1');
insert into db_arquivos values(5838, 'amb1_setorambulatorial003.php', 'Inclus�o: cadastro dos setores do ambulatorio');
insert into db_itensfilho values(10038, 5838);
insert into db_processa (codarq, id_item) values (3772, 10038);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values(3470, 10035, 1, 1000004);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values(10035, 10036, 1, 1000004);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values(10035, 10037, 1, 1000004);
insert into db_menu (id_item, id_item_filho, menusequencia, modulo) values(10035, 10038, 1, 1000004);
insert into db_arquivos values(5839, 'db_func_setorambulatorial.php', 'Arquivo com os campos para a fun��o da tabela : Setor Ambulatorial');
insert into db_itensfilho values(10036, 5839);
insert into db_itensfilho values(10037, 5839);
insert into db_itensfilho values(10038, 5839);
insert into db_arquivos values(5840, 'func_setorambulatorial.php', 'Fun��o de consulta aos dados da tabela : Setor Ambulatorial');
insert into db_itensfilho values(10036, 5840);
insert into db_itensfilho values(10037, 5840);
insert into db_itensfilho values(10038, 5840);
insert into db_arquivos values(5841, 'db_frmsetorambulatorial.php', 'Formulario utilizado para a tabela : Setor Ambulatorial');
insert into db_itensfilho values(10036, 5841);
insert into db_itensfilho values(10037, 5841);
insert into db_itensfilho values(10038, 5841);

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10039 ,'Ficha de Atendimento Ambulatorial' ,'Ficha de Atendimento Ambulatorial' ,'sau3_consultafaa.php' ,'1' ,'1' ,'Consulta para ficha de atendimento do paciente' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 31 ,10039 ,179 ,1000004 );

-- Requisi��o de exames ---
insert into db_sysarquivo values (3775, 'requisicaoexameprontuario', 'Requisi��o de exame do prontuario', 'sd103', '2015-01-16', 'Requisi��o de exame do prontuario', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (1000004,3775);
insert into db_syscampo values(20960,'sd103_codigo','int4','Requisi��o de exame do prontuario','0', 'Requisi��o',10,'f','f','f',1,'text','Requisi��o de exame do prontuario');
insert into db_syscampo values(20961,'sd103_prontuarios','int4','Prontu�rios ','0', 'Prontuarios',10,'f','f','f',1,'text','Prontuarios');
insert into db_syscampo values(20962,'sd103_medicos','int4','M�dicos','0', 'M�dicos',10,'f','f','f',1,'text','M�dicos');
insert into db_syscampo values(20963,'sd103_observacao','text','Observa��o','', 'Observa��o',1,'t','t','f',0,'text','Observa��o');
insert into db_syscampo values(20964,'sd103_data','date','Data da requisi��o','null', 'Data',10,'f','f','f',1,'text','Data da requisi��o');
insert into db_syscampo values(20965,'sd103_hora','varchar(5)','Hora da requisi��o','', 'Hora',5,'f','t','f',0,'text','Hora da requisi��o');
insert into db_sysarqcamp values(3775,20960,1,0);
insert into db_sysarqcamp values(3775,20961,2,0);
insert into db_sysarqcamp values(3775,20962,3,0);
insert into db_sysarqcamp values(3775,20964,4,0);
insert into db_sysarqcamp values(3775,20965,5,0);
insert into db_sysarqcamp values(3775,20963,6,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3775,20960,1,20960);
insert into db_sysforkey values(3775,20961,1,1010134,0);
insert into db_sysforkey values(3775,20962,1,100012,0);
insert into db_sysindices values(4158,'requisicaoexameprontuario_prontuarios_in',3775,'0');
insert into db_syscadind values(4158,20961,1);
insert into db_sysindices values(4159,'requisicaoexameprontuario_medicos_in',3775,'0');
insert into db_syscadind values(4159,20962,1);
insert into db_syssequencia values(1000433, 'requisicaoexameprontuario_sd103_codigo_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000433 where codarq = 3775 and codcam = 20960;
insert into db_sysarquivo values (3776, 'examerequisicaoexame', 'Exame da requisi��o de exames', 'sd104', '2015-01-16', 'Exame da requisi��o de exames', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (1000004,3776);
insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) values ( 20966 ,'sd104_codigo' ,'int4' ,'Codigo' ,'' ,'Codigo' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Codigo' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3776 ,20966 ,1 ,0 );
insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) values ( 20967 ,'sd104_requisicaoexameprontuario' ,'int4' ,'Requisi��o' ,'' ,'Requisi��o' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Requisi��o' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3776 ,20967 ,2 ,0 );
insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) values ( 20968 ,'sd104_lab_exame' ,'int4' ,'Exame' ,'' ,'Exame' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Exame' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3776 ,20968 ,3 ,0 );
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3776,20966,1,20966);
insert into db_sysforkey values(3776,20967,1,3775,0);
insert into db_sysforkey values(3776,20968,1,2758,0);
insert into db_sysindices values(4160,'examerequisicaoexame_requisicaoexameprontuario_in',3776,'0');
insert into db_syscadind values(4160,20967,1);
insert into db_sysindices values(4161,'examerequisicaoexame_lab_exame_in',3776,'0');
insert into db_syscadind values(4161,20968,1);
insert into db_syssequencia values(1000434, 'examerequisicaoexame_sd104_codigo_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000434 where codarq = 3776 and codcam = 20966;

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10041 ,'Requisi��o de Exame' ,'Requisi��o de Exame' ,'sau2_requisicaoexame001.php' ,'1' ,'1' ,'Emiss�o da requisi��o de exames' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 30 ,10041 ,443 ,1000004 );

insert into db_syscampo values(20969,'sd29_sigilosa','bool','Ao marcado como true, informa que a informa��o lan�ada em sd29_t_tratamento � sigilosa.','f', 'Sigiloso',1,'f','f','f',5,'text','Sigiloso');
insert into db_sysarqcamp values(1006042,20969,12,0);

insert into db_syscampo (codcam, nomecam, conteudo, descricao, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
     values (20973, 's152_evolucao', 'text', 'Evolu��o do paciente', 'Evolu��o', 1, 't', 't', 'f', 0, 'text', 'Evolu��o');
insert into db_sysarqcamp values(3043, 20973, 17, 0);
delete from db_sysindices where codind = 2847;
delete from db_syscadind where codind = 2847  and codcam = 17213;

insert into db_sysarquivo values (3781, 'regracalculocargahoraria', 'Regra Calculo Carga Horaria', 'ed127', '2015-02-04', 'Regra Calculo Carga Horaria', 0, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (1008004,3781);
insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) values ( 20983 ,'ed127_codigo' ,'int4' ,'C�digo' ,'' ,'C�digo' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'C�digo' );
insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) values ( 20984 ,'ed127_ano' ,'int4' ,'Ano de vig�ncia ' ,'' ,'Ano' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Ano' );
insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) values ( 20985 ,'ed127_calculaduracaoperiodo' ,'bool' ,'Como deve proceder o calculo da carga hor�ria.nse true aplica o seguinte calculo:n(Somat�rio das Aulas Dadas * dura��o dos periodos ) / 60 "1 hora em min"nnse false o calculo � o Somat�rio das Aulas Dadas' ,'false' ,'Calculo da Carga Hor�ria ' ,1 ,'false' ,'false' ,'false' ,5 ,'text' ,'Calculo da Carga Hor�ria ' );
insert into db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) values ( 20986 ,'ed127_escola' ,'int4' ,'Escola' ,'' ,'Escola' ,10 ,'false' ,'false' ,'false' ,1 ,'text' ,'Escola' );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3781 ,20983 ,1 ,0 );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3781 ,20984 ,2 ,0 );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3781 ,20985 ,3 ,0 );
insert into db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) values ( 3781 ,20986 ,4 ,0 );
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3781,20983,1,20983);
insert into db_sysforkey values(3781,20986,1,1010031,0);
insert into db_sysindices values(4165,'regracalculocargahoraria_escola_ano_in',3781,'1');
insert into db_syscadind values(4165,20986,1);
insert into db_syscadind values(4165,20984,2);
insert into db_syssequencia values(1000439, 'regracalculocargahoraria_ed127_codigo_seq', 1, 1, 9223372036854775807, 1, 1);
update db_sysarqcamp set codsequencia = 1000439 where codarq = 3781 and codcam = 20983;

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente ) values ( 10046 ,'C�lculo da Carga Hor�ria' ,'C�lculo da Carga Hor�ria' ,'edu4_calculocargahoraria001.php' ,'1' ,'1' ,'Configura��o do par�metro do c�lculo da carga hor�ria.' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 9307 ,10046 ,4 ,1100747 );

update db_syscampo set descricao = 'Data da Consulta /Exame na Prestadora.', rotulo = 'Data Cons./Exame', rotulorel = 'Data Cons./Exame' where codcam = 16398;
---------------------------
------- FIM TIME C --------
---------------------------


----- TRIBUTARIO DAEB ------

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
values ( 10034 ,'Altera��o de Vencimentos para os d�bitos' ,'Altera��o de Vencimentos para os d�bitos' ,
'arr4_alteravencimento001.php' ,'1' ,'1' ,'Respons�vel por alterar o vencimento dos d�bitos selecionados.' ,'true' );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 32 ,10034 ,452 ,1985522 );

----- FIM TRIBUTARIO DAEB------

---------------------------
--------  TIME NFSE -------
---------------------------

insert into db_sysarquivo values (3774, 'confvencissqnvariavel', 'Configura��es de ISSQN Vari�vel', 'q144', '2015-01-14', 'Configura��es de ISSQN Vari�vel', 1, 'f', 'f', 'f', 'f' );
insert into db_sysarqmod values (3,3774);
insert into db_syscampo values(20952,'q144_sequencial','int4','Campo Sequencial','0', 'Campo Sequencial',10,'f','f','f',1,'text','Campo Sequencial');

update db_syscampo set nomecam = 'q144_sequencial', conteudo = 'int4', descricao = 'C�digo Sequencial', valorinicial = '0', rotulo = 'C�digo Sequencial', nulo = 'f', tamanho = 10, maiusculo = 'f', autocompl = 'f', aceitatipo = 1, tipoobj = 'text', rotulorel = 'C�digo Sequencial' where codcam = 20952;

insert into db_syscampo values(20953,'q144_ano','int4','Ano Compet�ncia','0', 'Ano Compet�ncia',10,'f','f','f',1,'text','Ano Compet�ncia');
insert into db_syscampo values(20954,'q144_codvenc','int4','C�digo do Vencimento','0', 'C�digo do Vencimento',10,'f','f','f',1,'text','C�digo do Vencimento');
insert into db_syscampo values(20955,'q144_receita','int4','C�digo da Receita','0', 'C�digo da Receita',10,'f','f','f',1,'text','C�digo da Receita');
insert into db_syscampo values(20956,'q144_diavenc','int4','Dia do Vencimento','1', 'Dia do Vencimento',2,'f','f','f',1,'text','Dia do Vencimento');

update db_syscampo set nomecam = 'q144_codvenc', conteudo = 'int4', descricao = 'C�digo do Vencimento', valorinicial = '0', rotulo = 'C�digo do Vencimento', nulo = 'f', tamanho = 10, maiusculo = 'f', autocompl = 'f', aceitatipo = 1, tipoobj = 'text', rotulorel = 'C�digo do Vencimento' where codcam = 20954;

insert into db_syscampodep values(20954,'259');

update db_syscampo set nomecam = 'q144_receita', conteudo = 'int4', descricao = 'C�digo da Receita', valorinicial = '0', rotulo = 'C�digo da Receita', nulo = 'f', tamanho = 10, maiusculo = 'f', autocompl = 'f', aceitatipo = 1, tipoobj = 'text', rotulorel = 'C�digo da Receita' where codcam = 20955;

insert into db_syscampodep values(20955,'382');
insert into db_sysarqcamp values(3774,20952,1,0);
insert into db_sysarqcamp values(3774,20953,2,0);
insert into db_sysarqcamp values(3774,20954,3,0);
insert into db_sysarqcamp values(3774,20955,4,0);
insert into db_sysarqcamp values(3774,20956,5,0);
insert into db_sysprikey (codarq,codcam,sequen,camiden) values(3774,20952,1,20952);
insert into db_sysforkey values(3774,20954,1,54,0);
insert into db_sysforkey values(3774,20955,1,75,0);
insert into db_sysindices values(4153,'confvencissqnvariavel_cadvencdesc_in',3774,'0');
insert into db_syscadind values(4153,20954,1);
insert into db_sysindices values(4154,'confvencissqnvariavel_tabrec_in',3774,'0');
insert into db_syscadind values(4154,20955,1);
insert into db_syssequencia values(1000432, 'confvencissqnvariavel_q144_sequencial_seq', 1, 1, 9223372036854775807, 1, 1);

update db_sysarqcamp set codsequencia = 1000432 where codarq = 3774 and codcam = 20952;

insert into db_syscampo values(20957,'q144_hist','int4','Codigo do historico de calculo para identificar o d�bito','1019', 'Campo Hist�rico',4,'f','f','f',0,'text','Campo Hist�rico');
insert into db_syscampodep values(20957,'369');
insert into db_syscampo values(20958,'q144_tipo','int4','Tipo de d�bito, para possibilitar e facilitar saber o tipo buscando na tabela arretipo onde estao as descric�es','33', 'Tipo de D�bito',4,'f','f','f',0,'text','Tipo de D�bito');
insert into db_syscampodep values(20958,'380');
insert into db_syscampo values(20959,'q144_valor','float4','Campo Valor','0', 'Campo Valor',4,'t','f','f',4,'text','Campo Valor');

update db_syscampo set nomecam = 'q144_valor', conteudo = 'float4', descricao = 'Valor m�nimo do recibo a ser gerado.', valorinicial = '0', rotulo = 'Campo Valor M�nimo', nulo = 't', tamanho = 4, maiusculo = 'f', autocompl = 'f', aceitatipo = 4, tipoobj = 'text', rotulorel = 'Campo Valor M�nimo' where codcam = 20959;

insert into db_sysarqcamp values(3774,20957,6,0);
insert into db_sysarqcamp values(3774,20958,7,0);
insert into db_sysarqcamp values(3774,20959,8,0);
insert into db_sysforkey values(3774,20958,1,82,0);
insert into db_sysforkey values(3774,20957,1,73,0);
insert into db_sysindices values(4155,'confvencissqnvariavel_arretipo_in',3774,'0');
insert into db_syscadind values(4155,20958,1);
insert into db_sysindices values(4156,'confvencissqnvariavel_histcalc_in',3774,'0');
insert into db_syscadind values(4156,20957,1);
insert into db_sysindices values(4157,'confvencissqnvariavel_cadvenccompetencia_in',3774,'1');
insert into db_syscadind values(4157,20953,1);
insert into db_syscadind values(4157,20954,2);

update db_syscampo set nomecam = 'q144_codvenc', conteudo = 'int4', descricao = 'C�digo do Vencimento', valorinicial = '0', rotulo = 'Vencimento', nulo = 'f', tamanho = 10, maiusculo = 'f', autocompl = 'f', aceitatipo = 1, tipoobj = 'text', rotulorel = 'Vencimento' where codcam = 20954;
update db_syscampo set nomecam = 'q144_hist', conteudo = 'int4', descricao = 'Codigo do historico de calculo para identificar o d�bito', valorinicial = '1019', rotulo = 'Hist�rico', nulo = 'f', tamanho = 4, maiusculo = 'f', autocompl = 'f', aceitatipo = 0, tipoobj = 'text', rotulorel = 'Hist�rico' where codcam = 20957;
update db_syscampo set nomecam = 'q144_receita', conteudo = 'int4', descricao = 'C�digo da Receita', valorinicial = '0', rotulo = 'Receita', nulo = 'f', tamanho = 10, maiusculo = 'f', autocompl = 'f', aceitatipo = 1, tipoobj = 'text', rotulorel = 'Receita' where codcam = 20955;
update db_syscampo set nomecam = 'q144_valor', conteudo = 'float4', descricao = 'Valor m�nimo do recibo a ser gerado.', valorinicial = '0', rotulo = 'Valor M�nimo', nulo = 't', tamanho = 4, maiusculo = 'f', autocompl = 'f', aceitatipo = 4, tipoobj = 'text', rotulorel = 'Valor M�nimo' where codcam = 20959;

-- Alterado menus
update db_itensmenu set id_item = 3889, descricao = 'Inclus�o', help = 'Inclus�o de Db_confplan', funcao = 'pre1_db_confplan001.php', itemativo = '1', manutencao = '1', desctec = 'Inclus�o de Db_confplan', libcliente = 'false' where id_item = 3889;
update db_itensmenu set id_item = 3890, descricao = 'Altera��o', help = 'Altera��o de Db_confplan', funcao = 'pre1_db_confplan002.php', itemativo = '1', manutencao = '1', desctec = 'Altera��o de Db_confplan', libcliente = 'false' where id_item = 3890;
update db_itensmenu set id_item = 3891, descricao = 'Exclus�o', help = 'Exclus�o de Db_confplan', funcao = 'pre1_db_confplan003.php', itemativo = '1', manutencao = '1', desctec = 'Exclus�o de Db_confplan', libcliente = 'false' where id_item = 3891;
update db_itensmenu set id_item = 3888, descricao = 'Configura��o da Planilha', help = 'Configura��o da Planilha', funcao = 'pre1_db_confplan.php', itemativo = '1', manutencao = '1', desctec = 'Altera os dados das tabelas db_confplan e confvencissqnvariavel.', libcliente = 'true' where id_item = 3888;
update db_itensmenu set id_item = 1925, descricao = 'Manuten��o de Planilhas', help = 'Manuten��o de Planilhas', funcao = 'pre1_db_confplanalt002.php', itemativo = '1', manutencao = '1', desctec = 'Altera��o da tabela db_confplan que possui somente um registro', libcliente = 'true' where id_item = 1925;

---------------------------
------ FIM TIME NFSE ------
---------------------------


-------------------------------
------ IN�CIO TIME FOLHA ------
-------------------------------
-- Alterando menus
UPDATE db_itensmenu
   SET descricao = 'Processamento de Dados do Ponto',
       help      = 'Processamento de Dados do Ponto'
 WHERE id_item   = 10032;

insert into db_itensmenu ( id_item ,descricao ,help ,funcao ,itemativo ,manutencao ,desctec ,libcliente )
values ( 10042 ,'Suplementar' ,'Suplementar' ,'pes1_gerffx001.php?gerf=supl' ,'1' ,'1' ,'Implanta��o do Ponto Suplementar.' ,true );
insert into db_menu ( id_item ,id_item_filho ,menusequencia ,modulo ) values ( 5205 ,10042 ,5 ,952 );

-- Tabela "tipodeficiencia"
SELECT fc_executa_ddl('
  insert into db_sysarquivo   values (3777 , ''tipodeficiencia'', ''Tabela respons�vel por armazenar os tipos de defici�ncia do servidor.'', ''rh150'', ''2015-01-27'', ''Tipo de Defici�ncia'', 0, ''f'', ''f'', ''f'', ''f'' );
');
SELECT fc_executa_ddl('
  insert into db_sysarqmod    values (28 ,3777 );
');
SELECT fc_executa_ddl('
  insert into db_syssequencia values (1000435, ''tipodeficiencia_rh150_sequencial_seq'', 1, 1, 9223372036854775807, 1, 1 );
');
SELECT fc_executa_ddl('
  insert into db_syscampo     values (20970 ,''rh150_sequencial'' ,''int4''        ,''Representa a primary key da tabela.''           ,'''' ,''Sequencial'' ,10 ,''false'' ,''false'' ,''false'' ,1 ,''text'' ,''Sequencial'' );
');
SELECT fc_executa_ddl('
  insert into db_syscampo     values (20971 ,''rh150_descricao''  ,''varchar(50)'' ,''Representa o tipo de defici�ncia do servidor.'' ,'''' ,''Descri��o''  ,50 ,''false'' ,''true''  ,''false'' ,0 ,''text'' ,''Descri��o'' );
');
SELECT fc_executa_ddl('
  insert into db_sysarqcamp   values (3777 ,20970 ,1 , 1000435);
');
SELECT fc_executa_ddl('
  insert into db_sysarqcamp   values (3777 ,20971 ,2 ,0 );
');
SELECT fc_executa_ddl('
  insert into db_sysprikey    values (3777 ,20970 ,1 ,20970 );
');
SELECT fc_executa_ddl('
  insert into db_sysindices   values (4162 ,''tipodeficiencia_sequencial_in'', 3777, ''0'' );
');
SELECT fc_executa_ddl('
  insert into db_syscadind    values (4162, 20970, 1);
');

-- Tabela "rhpessoalmov"
SELECT fc_executa_ddl('
  insert into db_syscampo     values (20972 ,''rh02_tipodeficiencia'' ,''int4'' ,''Representa a foreign key da tabela "tipodeficiencia".'' ,''0'' ,''Tipo de Defici�ncia'' ,10 ,''true'' ,''false'' ,''false'' ,1 ,''text'' ,''Tipo de Defici�ncia'' );
');
SELECT fc_executa_ddl('
  insert into db_sysarqcamp   values (1158 ,20972 ,25 ,0 );
');
SELECT fc_executa_ddl('
  insert into db_sysforkey    values (1158 ,20972 ,1  ,3777, 0);
');

-- Menu
delete from db_menu      where id_item_filho = 10043;
delete from db_itensmenu where id_item = 10043;

insert into db_itensmenu values (10043, 'Caged Mensal', 'Gera��o de arquivo para Caged Mensal', 'pes1_caged_mensal001.php', '1', '1', 'Gera��o de arquivo para Caged Mensal.', 'true');
insert into db_menu      values (5106 , 10043, 20, 952);

update db_menu set menusequencia = 1  where id_item = 5106 and modulo = 952 and id_item_filho = 5098;
update db_menu set menusequencia = 2  where id_item = 5106 and modulo = 952 and id_item_filho = 5000;
update db_menu set menusequencia = 3  where id_item = 5106 and modulo = 952 and id_item_filho = 5107;
update db_menu set menusequencia = 4  where id_item = 5106 and modulo = 952 and id_item_filho = 10043;
update db_menu set menusequencia = 5  where id_item = 5106 and modulo = 952 and id_item_filho = 5733;
update db_menu set menusequencia = 6  where id_item = 5106 and modulo = 952 and id_item_filho = 48643;
update db_menu set menusequencia = 7  where id_item = 5106 and modulo = 952 and id_item_filho = 228040;
update db_menu set menusequencia = 8  where id_item = 5106 and modulo = 952 and id_item_filho = 268991;
update db_menu set menusequencia = 9  where id_item = 5106 and modulo = 952 and id_item_filho = 608584;
update db_menu set menusequencia = 10 where id_item = 5106 and modulo = 952 and id_item_filho = 7761;
update db_menu set menusequencia = 11 where id_item = 5106 and modulo = 952 and id_item_filho = 8747;
update db_menu set menusequencia = 12 where id_item = 5106 and modulo = 952 and id_item_filho = 8756;
update db_menu set menusequencia = 13 where id_item = 5106 and modulo = 952 and id_item_filho = 8779;
update db_menu set menusequencia = 14 where id_item = 5106 and modulo = 952 and id_item_filho = 9847;
update db_menu set menusequencia = 15 where id_item = 5106 and modulo = 952 and id_item_filho = 9866;
update db_menu set menusequencia = 16 where id_item = 5106 and modulo = 952 and id_item_filho = 9935;

