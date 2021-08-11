<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2014  DBSeller Servicos de Informatica           
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

class V010005 extends Ruckusing_Migration_Base {

  public function up() {
    $sSql = "
          BEGIN;
        
          INSERT INTO versoes VALUES ('V010005', '2.3.23');
        
          -- Adiciona o número do lote na importação de arquivo
          ALTER TABLE importacao_arquivo ADD numero_lote INTEGER;

          -- Cria a tabela de controle dos protocolos gerados
          CREATE TABLE protocolo (
            id integer NOT NULL,
            id_usuario integer NOT NULL,
            protocolo varchar NOT NULL,
            tipo integer NOT NULL,
            mensagem varchar,
            sistema varchar NOT NULL,
            data_processamento timestamp NOT NULL
          );
          CREATE SEQUENCE protocolo_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
          CREATE INDEX protocolo_id_usuario_indice ON protocolo USING btree (id_usuario);
          ALTER TABLE ONLY protocolo
            ADD CONSTRAINT protocolo_id_pk PRIMARY KEY (id),
            ADD CONSTRAINT id_and_protocolo_uk UNIQUE (id, protocolo),
            ADD CONSTRAINT protocolo_id_usuario_fk FOREIGN KEY (id_usuario) REFERENCES usuarios(id);

          -- Cria tabela de vinculo entre o protocolo e a importacao_arquivo com o número do lote
          CREATE TABLE protocolo_importacao (
            id integer NOT NULL,
            id_protocolo integer NOT NULL,
            id_importacao integer,
            numero_lote integer
          );
          CREATE SEQUENCE protocolo_importacao_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
          CREATE INDEX protocolo_importacao_id_protocolo_indice ON protocolo_importacao USING btree (id_protocolo);
          CREATE INDEX protocolo_importacao_id_importacao_indice ON protocolo_importacao USING btree (id_importacao);
          ALTER TABLE ONLY protocolo_importacao
            ADD CONSTRAINT protocolo_importacao_id_pk PRIMARY KEY (id),
            ADD CONSTRAINT id_protocolo_and_numero_lote_uk UNIQUE (id_protocolo, numero_lote),
            ADD CONSTRAINT protocolo_importacao_id_protocolo_fk FOREIGN KEY (id_protocolo) REFERENCES protocolo(id),
            ADD CONSTRAINT protocolo_importacao_id_importacao_fk FOREIGN KEY (id_importacao) REFERENCES importacao_arquivo(id);
          ALTER TABLE ONLY protocolo_importacao ALTER COLUMN id SET DEFAULT nextval('protocolo_importacao_id_seq'::regclass);
        
          -- Cria tabela com os codigos de erro
          CREATE TABLE importacao_rps_erros (
            id          integer NOT NULL,
            modelo      integer NOT NULL,
            codigo_erro varchar NOT NULL,
            mensagem    varchar NOT NULL,
            solucao     varchar NOT NULL 
          );
          CREATE SEQUENCE importacao_rps_erros_id_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
          ALTER TABLE ONLY importacao_rps_erros
            ADD CONSTRAINT importacao_rps_erros_id_pk PRIMARY KEY (id),
            ADD CONSTRAINT importacao_rps_erros_modelo_codigo_erro_uk UNIQUE (modelo, codigo_erro);
          ALTER SEQUENCE importacao_rps_erros_id_seq OWNED BY importacao_rps_erros.id; 
          ALTER TABLE ONLY importacao_rps_erros ALTER COLUMN id SET DEFAULT nextval('importacao_rps_erros_id_seq'::regclass); 
        
          -- Modelo de mensagem de retorno dos erros versão 1.0 da ABRASF
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E1', 'Assinatura do Hash não confere', 'Reenvie asssinatura do Hash conforme algoritmo estabelecido no Manual de Instrução da NFS-e');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E2', 'Mês de competência superior ao de emissão do RPS ou da Nota', 'Informe um mês de competência inferior ou igual ao de emissão do RPS ou da Nota.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E3', 'Natureza da operação não informada.', 'Utilize um dos tipos: 01 – Tributação no municipio; 02 – Tributação fora do municipio; 03 – Isenção; 04 – Imune; 05 – Exigibilidade suspensa por decisão judicial; 06 – Exigibilidade suspensa por procedimento administrativo.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E4', 'Esse RPS não foi enviado para a nossa base de dados', 'Envie o RPS para emissão da NFS-e.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E5', 'O número da NFS-E substituída informado não existe na base de dados do município.', 'Informe um número de NFS-E substituída que já tenha sido emitida.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E6', 'Essa NFS-e não pode ser cancelada através desse serviço, pois há crédito informado', 'O cancelamento de uma NFS-e com crédito deve ser feito através de processo administrativo aberto em uma repartição fazendária.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E7', 'Essa NFS-e já foi substituída', 'Confira e informe novamente os dados da NFS-e que deseja substituir.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E8', 'Campo de optante pelo simples nacional não informado', 'Utilize um dos tipos: 1 – Sim; 2 - Não.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E9', 'Campo de incentivador cultural não informado', 'Utilize um dos tipos: 1 – Sim; 2 - Não.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E10', 'RPS já informado.', 'Para essa Inscrição Municipal/CNPJ já existe um RPS informado com o mesmo número, série e tipo.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E11', 'Número do RPS não informado', 'Informe o número do RPS');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E12', 'Tipo do RPS não informado', 'Informe o tipo do RPS');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E13', 'Campo tipo do RPS inválido.', 'Utilize um dos tipos especificados: \"RPS\", \"RPSC\" ou \"RPSM\".');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E14', 'Data da emissão do RPS não informada', 'Informe a Data da emissão do RPS no formato Date');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E15', 'Data da emissão do RPS inválida', 'Informe a Data da emissão do RPS no formato Date');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E16', 'A data da emissão do RPS não poderá ser superior a data de hoje', 'Informe uma data de emissão de RPS válida');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E17', 'A data da emissão do RPS não poderá ser inferior à data de habilitação do prestador para emissão da NFS-e.', 'Informe uma data de emissão de RPS válida');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E18', 'O valor dos serviços deverá ser superior a R$0,00 (zero)', 'Não é permitido envio de valor de serviços igual a zero.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E19', 'O valor das deduções deverá ser inferior ou igual ao valor dos serviços', 'Não é permitido valor de dedução superior ao valor de serviços.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E20', 'O valor das deduções deverá ser superior ou igual a R$ 0,00 (zero)', 'Não é permitido valor de dedução inferior a zero (negativo).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E21', 'O valor dos descontos deverá ser inferior ou igual ao valor dos serviços', 'Não é permitido valor de desconto superior ao valor de serviços.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E22', 'O valor dos descontos deverá ser superior ou igual a R$ 0,00 (zero)', 'Não é permitido valor de desconto inferior a zero(negativo).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E23', 'O valor do PIS deverá ser superior ou igual a R$ 0,00 (zero)', 'Não é permitido valor de retenção inferior a zero (negativo).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E24', 'O valor da Cofins deverá ser superior ou igual a R$ 0,00 (zero)', 'Não é permitido valor de retenção inferior a zero(negativo).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E25', 'O valor do INSS deverá ser superior ou igual a R$ 0,00 (zero)', 'Não é permitido valor de retenção inferior a zero(negativo).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E26', 'O valor do IR deverá ser superior ou igual a', 'Não é permitido valor de retenção inferior a zero R$ 0,00 (zero) (negativo).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E27', 'O valor da CSLL deverá ser superior ou igual a R$ 0,00 (zero)', 'Não é permitido valor de retenção inferior a zero(negativo).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E28', 'Item da lista de serviço informado é incompatível com a informação de optante pelo simples nacional', 'Consulte a legislação vigente para saber se o item informado permite a opção pelo simples nacional');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E29', 'O código de serviço prestado não permite retenção de ISS.', 'Altere o campo \"ISS Retido\" para: 2 (Nota Fiscal sem ISS Retido).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E30', 'Item da lista de serviço inexistente', 'Consulte a legislação vigente para saber o item da lista de serviço que deverá ser informado neste campo.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E31', 'Item da lista de serviço não informado para a operação', 'Informe o item relativo ao serviço prestado nessa operação.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E32', 'Código CNAE informado é incompatível com a informação de optante pelo simples nacional', 'Consulte a legislação vigente para saber se o código informado permite a opção pelo simples nacional.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E33', 'Código CNAE inexistente', 'Consulte a legislação vigente para saber o código CNAE que deverá ser informado neste campo.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E34', 'Código de tributação informado é incompatível com a informação de optante pelo simples nacional', 'Consulte a legislação vigente para saber se o código informado permite a opção pelo simples nacional.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E35', 'Código de tributação inexistente', 'Consulte a legislação vigente para saber o Código de tributação que deverá ser informado neste campo.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E36', 'Campo ISSRetido inválido.', 'Utilize um dos tipos: 1 para ISS Retido ou 2 para ISS não Retido.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E37', 'Apenas serviços tributados, no município ou fora, podem sofrer retenção de ISS', 'Operações isentas, imunes ou com exigibilidade suspensa por decisão judicial ou procedimento administrativo não podem sofrer retenção de ISS.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E38', 'Contribuintes enquadrados como Microempresa Municipal, Estimativa, Sociedade de Profissionais ou Incentivador Cultural não podem sofrer retenção de ISS.', 'Não faça a retenção do ISS nos casos de empresas enquadradas como Microempresa Municipal, Estimativa, Sociedade de Profissionais ou Incentivador Cultural.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E39', 'Apenas empresas tomadoras de serviços inscritas neste municipio podem efetuar retenção de ISS.', 'O CNPJ e/ou a Inscrição Municipal informada do tomador não foi encontrada na base de dados do município, não sendo permitida a retenção. Acerte o CNPJ e/ou Inscrição Municipal ou altere o campo ISS Retido para 2 (Sem retenção de ISS).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E40', 'Valor do ISS retido não informado.', 'O valor do ISS retido deve ser informado quando o campo \"IssRetido\" for marcado com 1- Sim.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E41', 'O campo discriminação dos serviços não foi preenchido.', 'O preenchimento da discriminação dos serviços é obrigatório por lei, devendo ser preenchido adequadamente.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E42', 'Código do município da prestação do serviço inválido', 'Consulte a tabela do IBGE e utilize um dos tipos listados na tabela');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E43', 'Inscrição Municipal do prestador não encontrada na base de dados do município.', 'Informe a inscrição municipal correta do prestador.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E44', 'CNPJ do prestador inválido', 'Informe o número do CNPJ correto do prestador.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E45', 'CNPJ não encontrado na base de dados', 'Confira o numero do CNPJ informado. Caso esteja correto, o prestador não está inscrito no município.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E46', 'CNPJ do prestador não informado', 'Informe o CNPJ do prestador.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E47', 'CPF/CNPJ do tomador inválido', 'Informe o CPF/CNPJ correto do tomador.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E48', 'O campo CPF/CNPJ do tomador deverá ser preenchido com zeros quando for de CPF não-informado.', 'Preencher o campo CPF/CNPJ do Tomador com zeros quando se tratar de tomador com CPF não informado.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E49', 'Lote de RPS com excesso de inconsistências. O serviço de validação de RPS é abortado quando atinge o número de 50 inconsistências.', 'Corrija os erros e reenvie o lote de RPS.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E50', 'Inscricao Municipal do pretador inválida', 'Informe a inscricao municipal correta do prestador.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E51', 'Inscricao Municipal do tomador inválida', 'Informe a inscricao municipal correta do tomador.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E52', 'O tomador de serviços informado é o próprio prestador.', 'Na emissão da NFS-e não é permitido que o prestador seja igual ao tomador.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E53', 'O campo Inscrição Municipal do tomador só deverá ser preenchido para tomadores estabelecidos neste município', 'Para tomadores estabelecidos fora deste município não preencher inscrição municipal.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E54', 'CNPJ do tomador () está vinculado a mais de uma inscrição municipal.', 'Informe a Inscrição Municipal do tomador vinculada ao CNPJ informado.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E55', 'Endereço do tomador (logradouro) não corresponde ao CEP informado', 'Corrija o endereço (logradouro) ou o CEP do tomador do serviço');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E56', 'Campo endereço do tomador não informado (obrigatório para tomador com CNPJ)', 'O preenchimento do endereço (logradouro) é obrigatório para tomadores Pessoas Jurídicas (com CNPJ).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E57', 'Bairro não corresponde ao CEP informado', 'Corrija o Bairro ou o CEP do tomador do serviço.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E58', 'Código do municipio do tomador não corresponde ao CEP informado', 'Corrija o codigo do municipio ou o CEP do tomador do serviço');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E59', 'Campo cidade do tomador não informado (obrigatório para tomador com CNPJ)', 'O preenchimento da Cidade do Tomador é obrigatório para tomadores Pessoas Jurídicas (com CNPJ).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E60', 'A cidade do tomador informada não foi encontrada na base de dados da prefeitura.', 'Informe a cidade correta do tomador. No caso de cidade do exterior (fora do país), informe o campo com 99999.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E61', 'Sigla da UF do tomador não corresponde ao CEP informado', 'Corrija a sigla da UF ou o CEP do tomador do serviço');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E62', 'Cep não existe na tabela DNE dos Correios.', 'Informar o Cep correto');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E63', 'Razao social do intermediário do serviço não informada com CNPJ/CPF ou Inscrição Municipal do intermediário informada.', 'Informe a razao social do intermediário do serviço');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E64', 'Inscrição Municipal do intermediário do serviço inválida', 'Informe a Inscrição Municipal correta do intermediário do serviço.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E65', 'Inscrição Municipal do intermediário do serviço não esta vinculada ao CNPJ/CPF informado.', 'Acerte a Inscrição Municipal ou o CNPJ/CPF do intermediário do serviço.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E66', 'CNPJ/CPF do Intermediario do Serviço invalido', 'Informe o CNPJ/CPF correto do intermediario do serviço.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E67', 'Código da obra inválido', 'Informe o código da obra correto');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E68', 'Status do RPS inválido', 'Utilize um dos tipos:1 – Normal; 2 – Cancelado;');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E69', 'Quantidade de RPS incorreta', 'Informe a quantidade de RPS correta');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E70', 'Inscrição Municipal do prestador especificada no lote não confere com o prestador informado no RPS.', 'Informe corretamente a Inscrição Municipal do prestador no lote e no RPS.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E71', 'RPS em duplicidade no arquivo enviado.', 'Remova do arquivo o registro de RPS excedente.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E72', 'Campo Quantidade de RPS informado incorretamente.', 'O campo quantidade de RPS é numérico e deverá ter tamanho máximo de 4 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E73', 'Campo tipo do RPS inválido para o tipo de registro=\"3\" (Cupons).', 'Utilize o tipo \"RPS-C\"');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E74', 'Data de emissão da Nota Fiscal não está compreendida entre  e  conforme especificado no cabeçalho do arquivo.', 'Utilize no cabeçalho do arquivo datas de emissão da Nota Fiscal compreendidas entre a data início de emissão do lote e a data fim de emissão do lote.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E75', 'Número do RPS substituído não informado para status do RPS igual a \"S\"', 'Informe o número do RPS substituído.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E76', 'O número do RPS substituído informado não existe na base de dados', 'Informe o número do RPS substituído correto');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E77', 'Número da NFS-e não informado', 'Informe o número da NFS-e.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E78', 'Número da NFS-e inexistente na base de dados para o prestador de serviço pesquisado', 'Informe o número correto da NFS-e.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E79', 'Essa NFS-e já está cancelada', 'Confira e informe novamente os dados da NFS-e que deseja cancelar.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E80', 'Código de verificação não informado', 'Informe o código de verificação da NFS-e.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E81', 'Código de verificação não corresponde à NFSe consultada', 'Informe o código de verificação correto.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E82', 'Pesquisa pela atividade só pode ser feita com a indicação de um cep ou bairro', 'Informe um cep ou um bairro.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E83', 'Campo Inscrição Municipal do tomador informado incorretamente', 'O campo Inscrição Municipal do tomador é numérico e deverá ter tamanho máximo de 15 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E84', 'Pesquisa pelo cep só pode ser feita com a indicação de uma atividade', 'Informe uma atividade.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E85', 'Pesquisa pelo bairro só pode ser feita com a indicação de uma atividade', 'Informe uma atividade.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E86', 'Número do protocolo de recebimento do lote inexistente na base de dados', 'Confira se o lote foi enviado e informe o número correto do protocolo de recebimento.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E87', 'Número de lote inexistente na base de dados', 'Confira se o lote foi enviado e informe o número correto.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E88', 'Número de lote não informado', 'Informe o número do lote.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E89', 'Não existe na base de dados uma NFS-e emitida para o número de RPS informado', 'Informe o número correto do RPS.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E90', 'Número do RPS inválido', 'Informe um número de RPS que corresponda à seqüência utilizada pelo prestdor de serviço.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E91', 'Esse RPS não foi enviado para a nossa base de dados', 'Exija do prestador do serviço a emissão da NFSe.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E92', 'Esse RPS foi enviado para a nossa base de dados, mas ainda não foi processado', 'Faça uma nova consulta mais tarde.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E93', 'Série informada inválida', 'Informe a série correta para o RPS pesquisado.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E94', 'Mês de competência não informado.', 'Informe o mês de competência no formato AAAAMM.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E95', 'Mês de competência informado incorretamente.', 'Informe o mês de competência no formato AAAAMM.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E96', 'Campo número do RPS informado incorretamente', 'O campo Número do RPS é númerico e deverá ter tamanho máximo de 15 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E97', 'Campo série do RPS informado incorretamente', 'O campo Série do RPS é alfa-númerico e deverá ter tamanho máximo de 5 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E98', 'Valor dos serviços não informado.', 'Informe o valor dos serviços.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E99', 'Valor da retenção deverá ser inferior ou igual ao valor dos serviços', 'Não é permitido valor de retenção superior ao valor de serviços.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E100', 'Campo valor dos serviços informado incorretamente', 'O campo valor dos serviços é númerico e deverá ter tamanho máximo de 15,2, ou seja, 15 números inteiros e dois decimais.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E101', 'Campo deduções informado incorretamente', 'O campo valor das deduções é númerico e deverá ter tamanho máximo de 15,2, ou seja, 15 números inteiros e dois decimais.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E102', 'Campo descontos informado incorretamente', 'O campo valor dos descontos é númerico e deverá ter tamanho máximo de 15,2, ou seja, 15 números inteiros e dois decimais.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E103', 'Retençao de tributo federal informada incorretamente', 'O campo referente a retenção de tributo federal é númerico e deverá ter tamanho máximo de 15,2, ou seja, 15 números inteiros e dois decimais.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E104', 'Campo item da lista de serviço informado incorretamente', 'O campo item da lista de serviço deverá ter tamanho máximo de 4 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E105', 'Campo código CNAE informado incorretamente', 'O campo código CNAE deverá ter tamanho máximo de 7 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E106', 'Campo código de tributação do município informado incorretamente', 'O campo código de tributação do município deverá ter tamanho máximo de 20 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E107', 'Campo discriminação do serviço informado incorretamente.', 'O campo discriminação do serviço deverá ter tamanho máximo de 2000 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E108', 'Campo município da prestação do serviço informado incorretamente.', 'O campo município da prestação do serviço deverá ter tamanho máximo de 7 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E109', 'Campo cidade do tomador informado incorretamente.', 'O campo cidade do tomador deverá ter tamanho máximo de 7 dígitos, consulte tabela do IBGE.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E110', 'Quando a natureza da operação for tributação fora do município, o campo município da prestação do serviço deverá ser diferente do município do prestador', 'Informar o município da prestação do serviço corretamente.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E111', 'Município da prestação do serviço não informado.', 'Informe o município da prestação do serviço, de acordo com a tabela do IBGE.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E112', 'Campo Inscrição Municipal do intermediario informado incorretamente', 'O campo Inscrição Municipal do intermediario é numérico e deverá ter tamanho máximo de 15 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E113', 'Campo número do endereço do tomador não informado (obrigatório para tomador com CNPJ)', 'A informação do número do endereço do tomador é obrigatória para tomadores pessoas jurídicas (com CNPJ).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E114', 'Campo bairro do tomador não informado (obrigatório para tomador com CNPJ)', 'A informação do bairro do tomador é obrigatória para tomadores Pessoas Jurídicas (com CNPJ).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E115', 'Campo UF do tomador não informado (obrigatório para tomador com CNPJ)', 'O preenchimento da UF do tomador é obrigatório para tomadores pessoas jurídicas (com CNPJ).');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E116', 'A UF do tomador informada não foi encontrada na base de dados.', 'Informe a UF correta do tomador. Em caso de cidades do exterior (fora do país), preencher a UF com \"EX\" e a cidade do tomador com 99999.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E117', 'Campo razão social do tomador informado incorretamente.', 'O campo razão social do tomador deverá ter tamanho máximo de 115 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E118', 'Campo razão social do tomador não informado', 'O campo razão social do tomador deverá ser informado quando o campo Indicador de CPF/CNPJ do tomador for preenchido com 1 - CPF ou 2 - CNPJ.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E119', 'Campo endereço do tomador informado incorretamente.', 'O campo endereço do tomador deverá ter tamanho máximo de 125 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E120', 'Campo número do endereço do tomador informado incorretamente.', 'O campo número do endereço do tomador deverá ter tamanho máximo de 10 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E121', 'Campo complemento do endereço do tomador informado incorretamente.', 'O campo complemento do endereço do tomador deverá ter tamanho máximo de 60 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E122', 'Campo bairro do tomador informado incorretamente.', 'O campo bairro do tomador deverá ter tamanho máximo de 60 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E123', 'Campo AliquotaServicos não informado para tributação fora do município.', 'Informe a aliquota do ISS quando a tributação for fora do município');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E124', 'Campo UF do tomador informado incorretamente.', 'O campo UF do tomador deverá ter tamanho máximo de 2 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E125', 'Campo CEP do tomador informado incorretamente.', 'O campo CEP do tomador deverá ter tamanho máximo de 8 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E126', 'Campo e-mail do tomador informado incorretamente.', 'O campo e-mail do tomador deverá ter tamanho máximo de 80 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E127', 'Campo telefone do tomador informado incorretamente.', 'O campo telefone do tomador deverá ter tamanho máximo de 11 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E128', 'Campo razão social do intermediário do serviço informado incorretamente.', 'O campo razão social do intermediário do serviço deverá ter tamanho máximo de 115 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E129', 'Campo código da obra informado incorretamente.', 'O campo código da obra deverá ter tamanho máximo de 15 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E130', 'Campo ART informado incorretamente.', 'O campo ART deverá ter tamanho máximo de 15 caracteres.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E131', 'Campo data inicial preenchido incorretamente', 'A data informada deverá estar no formato DD/MM/AAAA, ou seja, dia (2 dígitos), seguido de mês (2 dígitos) e ano (4 dígitos) e deve ser uma data válida.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E132', 'Campo data final preenchido incorretamente', 'A data informada deverá estar no formato DD/MM/AAAA, ou seja, dia (2 dígitos), seguido de mês (2 dígitos) e ano (4 dígitos) e deve ser uma data válida.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E133', 'Data final da pesquisa não poderá ser supeiror a data de hoje.', 'Informe uma data final igual ou anterior a data de hoje');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E134', 'A data final não poderá ser anterior à data inicial', 'Informe uma data final igual ou superior a data inicial da pesquisa');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E135', 'O período de pesquisa não poderá ser superior a um ano.', 'Limitar as datas de início e final a um período de um ano');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E136', 'Campo número da NFS-e informado', 'O campo número da NFS-e é númerico e deverá incorretamente ter tamanho máximo de 15 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E137', 'Data de emissão da NFS-e informada incorretamente', 'Informe a data correta da emissão da NFS-e a ser consultada.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E138', 'CNPJ não autorizado a realizar o serviço', 'Informe o CNPJ autorizado a executar o serviço.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E139', 'Campo número da NFS-e substituída informado incorretamente', 'O campo número da NFS-e substituída é númerico e deverá ter tamanho máximo de 15 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E140', 'Bairro do prestador inexistente', '');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E141', 'Inscrição Municipal do prestador não informada', 'informe a Inscrição Municipal do prestador.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E142', 'Inscrição Municipal do prestador não está vinculada ao CNPJ informado.', 'Acerte a Inscrição Municipal ou o CNPJ do prestador.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E143', 'Inscrição Municipal do tomador não está vinculada ao CNPJ informado.', 'Acerte a Inscrição Municipal ou o CNPJ do tomador.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E144', 'Natureza da operação inválida.', 'Utilize um dos tipos: 01 – Tributação no municipio; 02 – Tributação fora do municipio; 03 – Isenção; 04 – Imune; 05 – Exigibilidade suspensa por decisão judicial; 06 – Exigibilidade suspensa por procedimento administrativo.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E145', 'Regime Especial de Tributação inválido.', 'Utilize um dos tipos: 01 – Microempresa Municipal; 02 – Estimativa; 03 – Sociedade de Profissionais; 4 – Cooperativa.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E146', 'Informação de optante pelo simples nacional inválida.', 'Utilize um dos tipos: 1 – Sim; 2 - Não.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E147', 'informação de incentivador cultural inválida.', 'Utilize um dos tipos: 1 – Sim; 2 - Não.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E148', 'Status do RPS não informado', 'Informe o status do RPS.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E149', 'Campo CNPJPrestador informado incorretamente', 'O campo CNPJPrestador é númerico e deverá ter tamanho máximo de 14 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E150', 'Série do RPS não informada', 'Campo de preenchimento obrigatório, caso não utilize série, preencha o campo com 00000.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E151', 'Quantidade de RPS não informada', 'Informe a quantidade de RPS.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E152', 'Campo ISSRetido não informado.', 'Informe um dos tipos: 1 para ISS Retido ou 2 para ISS não Retido.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E153', 'Campo ValorISSRetido informado incorretamente', 'O campo ValorISSRetido é númerico e deverá ter tamanho máximo de 15,2, ou seja, 15 números inteiros e dois decimais.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E154', 'Campo CNPJ/CPF do Intermediario do Serviço informado incorretamente', 'O campo CNPJ/CPF do Intermediario do Serviço é númerico e deverá ter tamanho máximo de 14 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E155', 'Campo CPFCNPJTomador informado incorretamente', 'O campo CPFCNPJTomador é númerico e deverá ter tamanho máximo de 14 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E156', 'CNPJ do prestador não autorizado a emitir NFS-e', 'Solicite autorização para emitir NFS-e para o CNPJ informado.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E157', 'Usuário não está autorizado a utilizar esse serviço para esse contribuinte.', 'Solicite ao contribuinte autorização para utilizar o serviço em seu nome.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E158', 'Campo Inscrição Municipal do prestador informado incorretamente', 'O campo Inscrição Municipal do prestador é numérico e deverá ter tamanho máximo de 15 dígitos.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E159', 'CNPJ do prestador especificado no lote não confere com o prestador informado no RPS.', 'Informe corretamente o CNPJ do prestador no lote e no RPS.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E160', 'Arquivo enviado fora da estrutura do arquivo XML de entrada.', 'Envie um arquivo dentro do schema do arquivo XML de entrada.');
          INSERT INTO importacao_rps_erros (modelo, codigo_erro, mensagem, solucao) VALUES (1, 'E161', 'Campo Valor ISS não informado para tributação fora do município.', 'Informe o valor do ISS quando a tributação for fora do município.');        
        
          -- Adiciona rotina de consulta do protocolo ao menu do módulo administrativo
          INSERT INTO controles (id,id_modulo,controle,identidade,visivel) VALUES (32,1,'Protocolo','protocolo',true);
          INSERT INTO acoes (id,id_controle,acao,acaoacl,sub_acoes) VALUES (50,32,'Consultar Protocolo','consulta','consulta-processar,email,enviar-email,imprimir');
          INSERT INTO perfis_acoes (id_acao,id_perfil) VALUES (50,3);
          INSERT INTO usuarios_acoes (id_usuario,id_acao) VALUES (1,50);

          -- Adiciona novo módulo webservice e o controle de métodos permitidos
          INSERT INTO modulos (id,modulo,identidade,visivel) VALUES (8,'WebService','webservice',true);
          INSERT INTO controles (id,id_modulo,controle,identidade,visivel) VALUES (33,8,'Homologação','homologacao',true);
          INSERT INTO controles (id,id_modulo,controle,identidade,visivel) VALUES (34,8,'Produção','producao',true);

          -- Adiciona os métodos permitidos pelo webservice para o contribuinte
          INSERT INTO acoes (id,id_controle,acao,acaoacl) VALUES (51,33,'Recepcionar Lote RPS','recepcionar-lote-rps');
          INSERT INTO acoes (id,id_controle,acao,acaoacl) VALUES (52,34,'Recepcionar Lote RPS','recepcionar-lote-rps');
          COMMIT;
      ";

    $this->execute($sSql);
  }

  public function down() {

    $sSql = "
          BEGIN;
          -- Remove o número do lote na importação de arquivo e cria uma tabela temporária
          CREATE TABLE IF NOT EXISTS w_importacao_arquivo AS SELECT id, numero_lote FROM importacao_arquivo;
          ALTER TABLE importacao_arquivo DROP numero_lote;

          -- Remove tabela de protocolo_importacao existente
          ALTER TABLE ONLY protocolo_importacao DROP CONSTRAINT protocolo_importacao_id_pk;
          ALTER TABLE ONLY protocolo_importacao DROP CONSTRAINT protocolo_importacao_id_protocolo_fk;
          ALTER TABLE ONLY protocolo_importacao DROP CONSTRAINT protocolo_importacao_id_importacao_fk;
          DROP INDEX protocolo_importacao_id_protocolo_indice;
          DROP INDEX protocolo_importacao_id_importacao_indice;
          DROP SEQUENCE protocolo_importacao_id_seq;
          DROP TABLE protocolo_importacao;
        
          -- Remove tabela de protocolo existente
          ALTER TABLE ONLY protocolo DROP CONSTRAINT protocolo_id_pk;
          ALTER TABLE ONLY protocolo DROP CONSTRAINT protocolo_id_usuario_fk;
          DROP INDEX protocolo_id_usuario_indice;
          DROP SEQUENCE protocolo_id_seq;
          DROP TABLE protocolo;
        
          -- Remove a tabela de importacao_rps_erros
          DROP TABLE importacao_rps_erros;
          DROP SEQUENCE importacao_rps_erros_id_seq;

          -- Remove a rotina de consulta do protocolo do módulo administrativo existente
          DELETE FROM usuarios_acoes WHERE id_acao = 50;
          DELETE FROM perfis_acoes WHERE id_acao = 50;
          DELETE FROM acoes WHERE id = 50;
          DELETE FROM controles WHERE id = 32;

          -- Remove o módulo webservice e os controle de método permitido existente
          DELETE FROM usuarios_contribuintes_acoes WHERE id_acao = 51;
          DELETE FROM usuarios_contribuintes_acoes WHERE id_acao = 52;
          DELETE FROM acoes WHERE id = 51;
          DELETE FROM acoes WHERE id = 52;
          DELETE FROM controles WHERE id = 33;
          DELETE FROM controles WHERE id = 34;
          DELETE FROM modulos WHERE id = 8;
          COMMIT;
      ";

    $this->execute($sSql);
  }
}