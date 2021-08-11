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


class PopulaTabelaControles extends Ruckusing_Migration_Base {

  public function up() {

    $sSql = "
      BEGIN;
        INSERT INTO controles VALUES (1, 2, 'Dms', 'dms', true);
        INSERT INTO controles VALUES (2, 1, 'Usuário', 'usuario', true);
        INSERT INTO controles VALUES (3, 1, 'Perfil', 'perfil', true);
        INSERT INTO controles VALUES (4, 1, 'Index', 'index', false);
        INSERT INTO controles VALUES (5, 1, 'Parâmetros Prefeitura', 'parametro', true);
        INSERT INTO controles VALUES (6, 2, 'Parâmetros Contribuinte', 'parametro', true);
        INSERT INTO controles VALUES (7, 2, 'NFSe', 'nota', true);
        INSERT INTO controles VALUES (8, 2, 'Guias', 'guia', true);
        INSERT INTO controles VALUES (9, 2, 'Index', 'index', false);
        INSERT INTO controles VALUES (10, 2, 'RPS', 'rps', true);
        INSERT INTO controles VALUES (11, 6, 'Usuários Eventuais', 'usuario-eventual', true);
        INSERT INTO controles VALUES (12, 5, 'Index', 'index', false);
        INSERT INTO controles VALUES (13, 6, 'Index', 'index', false);
        INSERT INTO controles VALUES (16, 1, 'Módulos', 'modulo', true);
        INSERT INTO controles VALUES (17, 7, 'Sessão', 'sessao', false);
        INSERT INTO controles VALUES (18, 7, 'Logout', 'logout', false);
        INSERT INTO controles VALUES (19, 7, 'Login', 'login', false);
        INSERT INTO controles VALUES (15, 1, 'Controles', 'controle', true);
        INSERT INTO controles VALUES (14, 1, 'Ações', 'acao', true);
        INSERT INTO controles VALUES (20, 2, 'Empresa', 'empresa', false);
        INSERT INTO controles VALUES (21, 5, 'Cadastro Eventual', 'cadastro-eventual', false);
        INSERT INTO controles VALUES (22, 7, 'NFSe', 'nfse', false);
        INSERT INTO controles VALUES (23, 2, 'Importação Arquivos', 'importacao-arquivo', true);
        INSERT INTO controles VALUES (24, 2, 'Relatórios', 'relatorio', true);
        INSERT INTO controles VALUES (25, 6, 'Relatório Fiscal 1', 'relatorio1', true);
        INSERT INTO controles VALUES (26, 6, 'Relatório Fiscal 2', 'relatorio2', true);
        INSERT INTO controles VALUES (27, 6, 'Relatório Fiscal 3', 'relatorio3', true);
        INSERT INTO controles VALUES (28, 6, 'Relatório Fiscal 4', 'relatorio4', true);
        INSERT INTO controles VALUES (29, 6, 'Relatório Fiscal 5', 'relatorio5', true);
        INSERT INTO controles VALUES (30, 6, 'Relatório Fiscal 6', 'relatorio6', true);
        INSERT INTO controles VALUES (31, 6, 'Acesso ao usuário', 'usuario-acesso', true);

        SELECT pg_catalog.setval('controles_id_seq', 31, true);
      COMMIT;
    ";
    
    $this->execute($sSql);
  }

  public function down() {
    
    $sSql  = "
      BEGIN;
        DELETE FROM controles where id <= 30;
        SELECT pg_catalog.setval('controles_id_seq', 1, true);
      COMMIT;
    ";
    
    $this->execute($sSql);
  }
}