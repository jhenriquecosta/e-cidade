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
 * Controller para importação de arquivos Desif
 *
 * @package Contribuinte/Controllers
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */

class Contribuinte_ContaAbrasfController extends Contribuinte_Lib_Controller_AbstractController {

  /**
   * Action responsável por listar as contas
   */
  public function listarContasAction() {

    if ($this->getRequest()->isPost()) {

      parent::noTemplate();

      $aRecord = array();
      $iLimit  = $this->_request->getParam('rows');
      $iPage   = $this->_request->getParam('page');
      $sSord   = $this->_request->getParam('sord');

      $oPaginatorAdapter = new DBSeller_Controller_Paginator(Contribuinte_Model_PlanoContaAbrasf::getQuery(),
                                                             'Contribuinte_Model_PlanoContaAbrasf',
                                                             'Contribuinte\PlanoContaAbrasf');

      /**
       * Ordena os registros
       */
      $oPaginatorAdapter->orderBy("e.id, e.conta_abrasf", $sSord);

      /**
       * Monta a paginação do GridPanel
       */
      $oResultado = new Zend_Paginator($oPaginatorAdapter);
      $oResultado->setItemCountPerPage($iLimit);
      $oResultado->setCurrentPageNumber($iPage);

      $iTotal      = $oResultado->getTotalItemCount();
      $iTotalPages = ($iTotal > 0 && $iLimit > 0) ? ceil($iTotal/$iLimit) : 0;

      foreach ($oResultado as $oPlanoContaAbrasf) {

        $oDadosColuna = new StdClass();
        $oDadosColuna->id                   = $oPlanoContaAbrasf->getId();
        $oDadosColuna->conta_abrasf         = $oPlanoContaAbrasf->getContaAbrasf();
        $oDadosColuna->titulo_contabil_desc = $oPlanoContaAbrasf->getTituloContabilDesc();
        $oDadosColuna->tributavel           = $oPlanoContaAbrasf->getTributavel();
        $oDadosColuna->obrigatorio          = $oPlanoContaAbrasf->getObrigatorio();

        $aRecord[] = $oDadosColuna;
      }

      /**
       * Parametros de retorno do AJAX
       */
      $aRetornoJson = array(
        'total'   => $iTotalPages,
        'page'    => $iPage,
        'records' => $iTotal,
        'rows'    => $aRecord
      );

      echo $this->getHelper('json')->sendJson($aRetornoJson);
    }
  }
}