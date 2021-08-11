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


class Default_ManutencaoController extends Default_Lib_Controller_AbstractController {
  
  public function indexAction() {
    
    parent::noTemplate();
    
    $this->view->title       = 'Sistema em manutenção';
    $this->view->message     = 'O sistema encontra-se em manutenção no momento, acesse novamente em alguns instantes.';
    $this->view->information = 'Para mais informações entre em contato com o suporte do sistema.';
  }

  public function bloqueioAction() {

    parent::noTemplate();

    $this->view->title       = 'Sistema encontra-se bloqueado.';
    $this->view->message     = 'O sistema encontra-se bloqueado através deste link.';
    $this->view->message    .= '<br> Neste ambiente somente é liberado as homologações dos serviços de webservice.';
    $this->view->information = 'Para mais informações entre em contato com o suporte da prefeitura.';
  }
  
  public function versaoAction() {
  
    parent::noTemplate();
  
    $this->view->title       = 'Sistema encontra-se bloqueado.';
    $this->view->message     = 'O sistema encontra-se bloqueado através deste link.';
    $this->view->message    .= '<br> Isto ocorre porque atualmente o sistema de webservice do ambiente E-Cidade';
    $this->view->message    .= '<br> encontra-se com uma versão diferente ao qual o E-CidadeOnline2 suporta.';
    $this->view->information = 'Para mais informações entre em contato com o suporte da prefeitura.';
    
  }
}