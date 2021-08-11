<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2016  DBSeller Servicos de Informatica
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
 * Controller responsável pelo processamento de fechamento de competência
 *
 * @package Contribuinte/Controllers
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
class Contribuinte_CompetenciaController extends Contribuinte_Lib_Controller_AbstractController {

  public function nfseEncerramentoAction() {

    $oContribuinte = $this->_session->contribuinte;

    $oCompetenciaGeral = new Contribuinte_Model_Competencia(null, null, $oContribuinte);
    $aCompetencia = $oCompetenciaGeral->getCompetenciaNfseByContribuinte();

    /**
     * Verificamos a situação de todas as Competencias para salvarmos a indíce no array
     * da última competência em aberto
     */
    $iCompetenciaHabilitada = null;

    foreach ($aCompetencia as $iIndice => $oCompetencia) {

      if (    $oCompetencia->getSituacao() ==  Contribuinte_Model_Competencia::SITUACAO_EM_ABERTO
           || $oCompetencia->getSituacao() ==  Contribuinte_Model_Competencia::SITUACAO_EM_ABERTO_SEM_IMPOSTO
           || $oCompetencia->getSituacao() ==  Contribuinte_Model_Competencia::SITUACAO_EM_ABERTO_SEM_MOVIMENTO){
        $iCompetenciaHabilitada = $iIndice;
      }
    }

    /**
     * Deixamos essa competência como habilitada, para habilitar o seu encerramento
     */
    if ( !is_null($iCompetenciaHabilitada) ) {
      $aCompetencia[$iCompetenciaHabilitada]->setHabilitado(true);
    }

    $oPaginatorAdapter = new DBSeller_Controller_PaginatorArray($aCompetencia);
    $oPaginator        = new Zend_Paginator($oPaginatorAdapter);
    $oPaginator->setItemCountPerPage(12);
    $oPaginator->setCurrentPageNumber($this->_request->getParam('page'));

    $this->view->oCompetencias = $oPaginator;
  }

  public function detalhesAction() {

    $iMes          = $this->getRequest()->getParam('mes');
    $iAno          = $this->getRequest()->getParam('ano');
    $oContribuinte = $this->_session->contribuinte;
    $oCompetencia  = new Contribuinte_Model_Competencia($iAno, $iMes, $oContribuinte);

    $this->view->contribuinte = $oContribuinte;
    $oCompetencia->getTodasNotas();
    $oCompetencia->setTotaisCompetencia();

    $this->view->competencia  = $oCompetencia;
  }

  /**
   * Fecha a competência para as Notas Fiscais (NFSE)
   */
  public function confirmarEncerramentoAction() {

    parent::noTemplate();

    $iMes = $this->getRequest()->getParam('mes');
    $iAno = $this->getRequest()->getParam('ano');
    $oContribuinte = $this->_session->contribuinte;

    $oCompetencia       = new Contribuinte_Model_Competencia($iAno, $iMes, $oContribuinte);
    $aCompetenciaAberto = $oCompetencia->getAbertoByContribuinte();
    $oCompetencia       = $aCompetenciaAberto[0];

    $oCompetencia->verificaSituacaoAberto();

    $oFormCompetencia = new Contribuinte_Form_CompetenciaEncerramento();
    $oFormCompetencia->setAction('/contribuinte/competencia/encerrar-competencia');
    $oFormCompetencia->preenche($oContribuinte, $oCompetencia);
    $oFormCompetencia->getElement('data_guia')->setValue(date('d/m/Y'));

    $this->view->competencia = $oCompetencia;
    $this->view->form        = $oFormCompetencia;
  }

  public function encerrarCompetenciaAction(){

    try {
t
      parent::noLayout();

      $aRetorno = array('lErro'            => false,
                        'sMensagemRetorno' => null,
                        'sArquivoGuia'     => null);

      $oContribuinte = $this->_session->contribuinte;

      $iMes = (integer)$this->getRequest()->getParam('mes');
      $iAno = (integer)$this->getRequest()->getParam('ano');

      $sDataPagamento = DBSeller_Helper_Date_Date::invertDate($this->getRequest()->getParam('data_guia'));
      $oDataPagamento = new DateTime($sDataPagamento);

      $oCompetenciaEnceramento = new Contribuinte_Model_CompetenciaEnceramento($oContribuinte,
                                                                               $iAno,
                                                                               $iMes,
                                                                               $oDataPagamento);
      $oRetorno = $oCompetenciaEnceramento->encerrar();

      if($oRetorno->lGuia){
        $aRetorno['sArquivoGuia'] = $oRetorno->oGuia->arquivo_guia;
      }

      $aRetorno['sMensagemRetorno'] = "Competência encerrada com sucesso.";

    } catch (Exception $oException) {

      $aRetorno['lErro']            = true;
      $aRetorno['sMensagemRetorno'] = $oException->getMessage();
    }

    echo $this->getHelper('json')->sendJson($aRetorno);
  }
}
