<?php

/**
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
 * Classe para controle das notificações
 *
 * @package Global/controller
 */
class Global_NotificacaoController extends Global_Lib_Controller_AbstractController {

  /**
   * Responsavél pelas ações de limpar todas ou remover uma notificação da sessão
   */
  public function removerAction() {

    parent::noTemplate();

    $aParametros = $this->getRequest()->getParams();

    // Verificação para remover somente uma notificação ou todas
    if (isset($aParametros['tipo']) && isset($aParametros['codigo'])) {

      $sMensagem = "Notificação de '{$aParametros['tipo']}' removida da sessão.";
      DBSeller_Plugin_Notificacao::remove($aParametros['tipo'], $aParametros['codigo']);
    } else {

      $sMensagem = 'Todas as notificações foram removidas da sessão.';
      DBSeller_Plugin_Notificacao::limpar();
    }

    $iCount = DBSeller_Plugin_Notificacao::getCountAll();

    // Parametros de retorno do AJAX
    $aRetornoJson = array(
      'status'  => TRUE,
      'message' => $sMensagem,
      'count'   => $iCount
    );

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
}