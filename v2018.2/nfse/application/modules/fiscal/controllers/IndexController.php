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


/**
 * Classe para controle do módulo fiscal
 *
 * @package Fiscal/controller
 */

/**
 * @package Fiscal/controller
 */
class Fiscal_IndexController extends Fiscal_Lib_Controller_AbstractController {

  /**
   * Tela inicial do módulo fiscal
   *
   *  @return void
   */
  public function indexAction () {

    $aAuth = Zend_Session::namespaceGet('Zend_Auth');
    $oUsuario = Administrativo_Model_Usuario::getById($aAuth['storage']['id']);

    // Verifica se o usuário é do tipo fiscal
    if ($oUsuario->getTipo() == 3 || $oUsuario->getPerfil()->getTipo() == 3) {

      $oBaseUrl = new Zend_View_Helper_BaseUrl();
      // Verifica se possui cadastros eventuais
      $aCadastrosEventuais = Contribuinte_Model_CadastroPessoa::getCadastrosParaLiberacao();

      if (count($aCadastrosEventuais) > 0) {

        $sMensagem = "Hà " . count($aCadastrosEventuais) . " Cadastros Eventuais Pendentes <br/>";
        $sMensagem .= " <a href=". $oBaseUrl->baseUrl("/fiscal/usuario-eventual/listar-novos-cadastros") ."> Verificar </a>";
        DBSeller_Plugin_Notificacao::addAviso('F001', $sMensagem);

      }

      // Verifica se possui solicitações de cancelamento
      $aSolicitacoesCancelamento = Contribuinte_Model_SolicitacaoCancelamento::getAll();

      if (count($aSolicitacoesCancelamento) > 0) {

        $sMensagem = "Hà " . count($aSolicitacoesCancelamento) . " Solicitações de cancelamento de NFS-e <br/>";
        $sMensagem .= " <a href=". $oBaseUrl->baseUrl("/fiscal/cancelamento-nfse/consultar") ."> Verificar </a>";
        DBSeller_Plugin_Notificacao::addAviso('F002', $sMensagem);

      }

    }

    $this->view->oculta_breadcrumbs = TRUE;
  }
}