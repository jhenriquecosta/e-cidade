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

class Fiscal_ContaAbrasfController extends Fiscal_Lib_Controller_AbstractController {

  /**
   * Adiciona o form de consulta
   */
  public function consultarAction() {

    $oForm = new Fiscal_Form_ContaAbrasf();
    $this->view->oFormConsulta = $oForm;
  }


  /**
   * Action responsável por listar as contas
   */
  public function listarContasAction() {

    parent::noTemplate();

    $aRecord = array();
    $iLimit  = $this->_request->getParam('rows');
    $iPage   = $this->_request->getParam('page');
    $sSord   = $this->_request->getParam('sord');

    /**
     * Valores enviados para o controller
     */
    $aParametrosBusca  = $this->_request->getParam('form');
    $oPaginatorAdapter = new DBSeller_Controller_Paginator(Contribuinte_Model_PlanoContaAbrasf::getQuery(),
                                                           'Contribuinte_Model_PlanoContaAbrasf',
                                                           'Contribuinte\PlanoContaAbrasf');

    $oPaginatorAdapter->where("1 = 1");

    /**
     * Filtro pela conta abrasf
     */
    if (!empty($aParametrosBusca['conta_abrasf'])) {
      $oPaginatorAdapter->andWhere("e.conta_abrasf = '{$aParametrosBusca['conta_abrasf']}'");
    }

    /**
     * Filtro pela tributação
     */
    if (!empty($aParametrosBusca['tributavel'])) {
      $oPaginatorAdapter->andWhere("e.tributavel = '{$aParametrosBusca['tributavel']}'");
    }

    /**
     * Filtro pela obrigatoriedade
     */
    if (!empty($aParametrosBusca['obrigatorio'])) {
      $oPaginatorAdapter->andWhere("e.obrigatorio = '{$aParametrosBusca['obrigatorio']}'");
    }

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
  
  /**
   * Action responsável por salvar as alterações das obrigatoriedades das contas 
   */
  public function salvarContasAction() {
    
    parent::noTemplate();
    
    $aDados = $this->getRequest()->getParam('selecionados');

    if ($this->getRequest()->isPost()) {

      try {

        $oPlanoContaAbrasf = new Contribuinte_Model_PlanoContaAbrasf();

        if (!empty($aDados)) {
          $oPlanoContaAbrasf->salvarObrigatorio($aDados);
        }

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success']  = 'Alterações realizadas com sucesso';
      } catch (Exception $oErro) {

        $aRetornoJson['error'][]  = $oErro->getMessage();
        $aRetornoJson['status']  = FALSE;
      }
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
}