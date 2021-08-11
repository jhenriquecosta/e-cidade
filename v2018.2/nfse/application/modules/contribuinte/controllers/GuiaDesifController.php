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
 * Controlador para geração e consulta de Guias DES-IF do contribuinte
 *
 * Class Contribuinte_GuiaDesifController
 * @package Contribuinte/Guia
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */

class Contribuinte_GuiaDesifController extends Contribuinte_Lib_Controller_AbstractController {

  /**
   * Exibe a lista das guias geradas
   */
  public function consultaEmissaoAction() {

    if ($this->getRequest()->isPost()) {

      parent::noTemplate();

      $aRecord = array();
      $iLimit  = $this->_request->getParam('rows')? $this->_request->getParam('rows') : 10;
      $iPage   = $this->_request->getParam('page')? $this->_request->getParam('page') : 0;

      $oContribuinte   = $this->_session->contribuinte;
      $iIdContribuinte = $oContribuinte->getIdUsuarioContribuinte();

      $aGuias = Contribuinte_Model_Guia::consultaGuiasDesif($iIdContribuinte);
      $aGuias = Contribuinte_Model_Guia::atualizaSituacaoGuias($aGuias, $iLimit, $iPage);

      $oPaginatorAdapter = new DBSeller_Controller_PaginatorArray($aGuias);
      $aResultado        = new Zend_Paginator($oPaginatorAdapter);
      $aResultado->setItemCountPerPage($iLimit);
      $aResultado->setCurrentPageNumber($iPage);

      $iTotal      = $aResultado->getTotalItemCount();
      $iTotalPages = $aResultado->getPages()->pageCount;

      foreach ($aResultado as $oResultado) {

        $sSituacaoLabel = null;

        switch ($oResultado->getSituacao()) {
          case 'a' :
            $sSituacaoLabel = 'label label-warning';
            break;
          case 'p' :
            $sSituacaoLabel = 'label label-success';
            break;
          case 'c' :
            $sSituacaoLabel = 'label label-important';
            break;
          case 'd' :
          case 'x' :
          default  :
            $sSituacaoLabel = 'label';
        }
        
        $oGuia = new StdClass();
        $oGuia->id                = $oResultado->getId();
        $oGuia->competencia       = $oResultado->getAnoComp() . $oResultado->getMesComp();
        $oGuia->competencia_label = $oResultado->getAnoComp() . '/' . $oResultado->getMesComp();
        $oGuia->data_vencimento   = $oResultado->getVencimento()->format('d/m/Y');
        $oGuia->valor_corrigido   = DBSeller_Helper_Number_Format::toMoney($oResultado->getValorCorrigido(), 2, 'R$');
        $oGuia->valor_historico   = DBSeller_Helper_Number_Format::toMoney($oResultado->getValorHistorico(), 2, 'R$');
        $oGuia->situacao          = $oResultado->getSituacao();
        $oGuia->situacao_label    = "<span class='" . $sSituacaoLabel . "'>";
        $oGuia->situacao_label   .= Contribuinte_Model_Guia::$SITUACAO[$oResultado->getSituacao()]."</span>";

        $aRecord[] = $oGuia;
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
  
  /**
   * Exibe a lista com os valores dos serviços acomulados para geraçao das guias
   */
  public function geracaoAction() {

    if ($this->getRequest()->isPost()) {

      parent::noTemplate();

      $aRetornoJson = $this->retornaContasGuiaDesif($this->getAllParams());

      echo $this->getHelper('json')->sendJson($aRetornoJson);
    }
  }

  /**
   * Exibe a lista de serviços com os valores para cada competência
   */
  public function geracaoDetalhesAction() {

    if ($this->getRequest()->isPost()) {

      parent::noTemplate();

      $aParametros = $this->getAllParams();
      if (!isset($aParametros['id'])) {
        $aRetornoJson['error'] = 'Informe os dados corretamente!';
      } else {
        $aRetornoJson = $this->retornaContasGuiaDesif($aParametros, TRUE);
      }

      echo $this->getHelper('json')->sendJson($aRetornoJson);
    }
  }

  /**
   * Realiza a reemisao das guias da Desif
   */
  public function reemitirAction() {

    parent::noTemplate();

    $aDadosRequest = $this->getRequest()->getParams();
    $oContribuinte = $this->_session->contribuinte;

    $oGuia         = Contribuinte_Model_Guia::getById($aDadosRequest['guia']);

    //$oCompetencia  = new Contribuinte_Model_Competencia($oGuia->getAnoComp(), $oGuia->getMesComp(), $oContribuinte);
    //$oCompetencia->getNotas();
    //$oCompetencia->setTotaisCompetencia();

    $oFormCompetencia = new Contribuinte_Form_GuiaCompetencia();
    $oFormCompetencia->setAction('/contribuinte/guia-desif/reemitir/guia/' . $aDadosRequest['guia']);
    //$oFormCompetencia->preenche($oCompetencia, $oGuia);
    $oFormCompetencia->getElement('data_guia')->setValue(date('d/m/Y'));
    $oFormCompetencia->removeElement('total_iss');
    $oFormCompetencia->removeElement('total_servico');

    // Validação do forumlário e geração da guia
    if ($this->getRequest()->isPost()) {

      if ($oFormCompetencia->isValidPartial($aDadosRequest)) {

        $sDataGuia = str_replace('/', '-', $aDadosRequest['data_guia']);
        $oDataGuia = new DateTime($sDataGuia);

        if ($oDataGuia->format('Ymd') < date('Ymd')) {
          $this->view->mensagem_erro = $this->translate->_('Informe uma Data de Pagamento posterior a data atual.');
        } else {

          $aNovaGuia = $oGuia->reemitir($oDataGuia->format('d/m/Y'));

          $this->view->arquivo = $aNovaGuia['arquivo'];
          $this->view->guia    = $aNovaGuia['objeto'];
        }
      } else {
        $this->view->mensagem_erro = $this->translate->_('Preencha os dados corretamente.');
      }
    }

    $this->view->form = $oFormCompetencia;
  }


  /**
   * Emite e gera as guias conforme a receita e aliquota informadas
   */
  public function emitirGuiaAction() {

    parent::noTemplate();
    $aParametros = $this->getAllParams();

    try {

      $iIdImportacao = $aParametros['id'];

      $fAliquota     = (isset($aParametros['aliq_issqn'])) ? $aParametros['aliq_issqn'] : NULL;
      $oContribuinte = $this->_session->contribuinte;

      $aReceitaDesif = Contribuinte_Model_ImportacaoDesif::getTotalReceitaGuiaDesif($oContribuinte,
                                                                                    $iIdImportacao,
                                                                                    $fAliquota);

      $sTotalReceita   = DBSeller_Helper_Number_Format::toMoney($aReceitaDesif->total_receita, 2, 'R$ ');
      $sTotalIss       = DBSeller_Helper_Number_Format::toMoney($aReceitaDesif->total_iss, 2, 'R$ ');
      
      $oFormEmitirGuia = new Contribuinte_Form_GuiaCompetencia();

      $oFormEmitirGuia->setName('form-emitir-guia');
      $oFormEmitirGuia->setAction('/contribuinte/guia-desif/emitir-guia');
      $oFormEmitirGuia->getElement('ano')->setValue($aReceitaDesif->ano_competencia);
      $oFormEmitirGuia->getElement('mes')->setValue($aReceitaDesif->mes_competencia);
      //$oFormEmitirGuia->getElement('aliq_issqn')->setValue($fAliquota);
      $oFormEmitirGuia->getElement('total_servico')->setValue($sTotalReceita);
      $oFormEmitirGuia->getElement('total_iss')->setValue($sTotalIss);
      $oFormEmitirGuia->getElement('data_guia')->setValue(date('d/m/Y'));

      $this->view->form = $oFormEmitirGuia;

      // Verifica se for enviado os dados via $_POST
      if ($this->getRequest()->isPost()) {

        // Formata a data de pagamento da guia
        $sDataInvertida = DBSeller_Helper_Date_Date::invertDate($this->getRequest()->getParam('data_guia'));
        $oDataPagamento = new DateTime($sDataInvertida);

        // Gera a guia e emite o PDF da geração
        $oGuia = Contribuinte_Model_GuiaEcidade::gerarGuiaDesif($oContribuinte,
                                                                $aParametros['ano'],
                                                                $aParametros['mes'],
                                                                $oDataPagamento,
                                                                $fAliquota, true);

        $this->view->arquivo = $oGuia->arquivo_guia;
      }
    } catch (Exception $oErro) {
      $this->view->mensagem_erro = $oErro->getMessage();
    }
  }

  /**
   * Método para retornar os dados das contas em formato json para a DBJqGrid
   *
   * @param array $aParametros
   * @param bool  $bDetalhes
   * @return array
   */
  protected function retornaContasGuiaDesif(array $aParametros, $bDetalhes = FALSE) {

    $aRecord               = array();
    $iLimit                = $aParametros['rows'];
    $iPage                 = $aParametros['page'];
    $sSord                 = $aParametros['sord'];
    $oContribuinte         = $this->_session->contribuinte;
    $sCodigosContribuintes = NULL;

    $oPaginatorAdapter = new DBSeller_Controller_Paginator(Contribuinte_Model_ImportacaoDesif::getQuery(),
                                                           'Contribuinte_Model_ImportacaoDesif',
                                                           'Contribuinte\ImportacaoDesif');


    foreach ($oContribuinte->getContribuintes() as $iIdContribuinte) {

      if ($sCodigosContribuintes == NULL) {
        $sCodigosContribuintes .= $iIdContribuinte;
      } else {
        $sCodigosContribuintes .= ',' . $iIdContribuinte;
      }
    }

    $oPaginatorAdapter->where("e.contribuinte in ({$sCodigosContribuintes})");

    if (isset($aParametros['id'])) {
      $oPaginatorAdapter->andWhere("e.id = {$aParametros['id']}");
    }

    $oPaginatorAdapter->orderBy("e.competencia_inicial, e.competencia_final", $sSord);

    /**
     * Monta a paginação do GridPanel
     */
    $oResultado = new Zend_Paginator($oPaginatorAdapter);
    $oResultado->setItemCountPerPage($iLimit);
    $oResultado->setCurrentPageNumber($iPage);

    foreach ($oResultado as $oDesif) {

      $aValores = Contribuinte_Model_ImportacaoDesif::getTotalReceitasGuia($oDesif->getId(), $bDetalhes);

      /**
       * Verifica se for para exibir as aliquotas detalhadas
       */

      if ($bDetalhes) {

        foreach ($aValores['aliquotas_issqn'] as $iAliqIssqn => $aReceitas) {

          $aRecord[] = array(
            'id_importacao_desif' => $oDesif->getId(),
            'aliq_issqn'          => DBSeller_Helper_Number_Format::toFloat($iAliqIssqn),
            'total_receita'       => DBSeller_Helper_Number_Format::toMoney($aReceitas['total_receita'], 2, 'R$ '),
            'total_iss'           => DBSeller_Helper_Number_Format::toMoney($aReceitas['total_iss'], 2, 'R$ ')
          );
        }
      } else {

        if ($aValores['total_receita'] > 0 && $aValores['total_iss'] > 0) {

          $iAnoCompetencia = substr($oDesif->getCompetenciaInicial(), 0, 4);
          $iMesCompetencia = substr($oDesif->getCompetenciaInicial(), 4, 6);

          $oContribuinteGuia = Contribuinte_Model_Contribuinte::getById($sCodigosContribuintes);

          $lTemGuiaEmitida = Contribuinte_Model_Guia::existeGuia($oContribuinteGuia,
                                                          $iMesCompetencia,
                                                          $iAnoCompetencia,
                                                          Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE);
          
          $aRecord[] = array(
            'id' => $oDesif->getId(),
            'competencia_inicial' => $oDesif->getCompetenciaInicial(),
            'competencia_final'   => $oDesif->getCompetenciaFinal(),
            'total_receita'       => DBSeller_Helper_Number_Format::toMoney($aValores['total_receita'], 2, 'R$ '),
            'total_iss'           => DBSeller_Helper_Number_Format::toMoney($aValores['total_iss'], 2, 'R$ '),
            'guia_emitida'        => $lTemGuiaEmitida,
            'aValores' => $aValores
          );
        }
      }
    }

    $iTotal      = $oResultado->getTotalItemCount();
    $iTotalPages = ($iTotal > 0 && $iLimit > 0) ? ceil($iTotal/$iLimit) : 0;

    /**
     * Parametros de retorno do AJAX
     */
    $aRetornoJson = array(
      'total'   => $iTotalPages,
      'page'    => $iPage,
      'records' => $iTotal,
      'rows'    => $aRecord
    );

    return $aRetornoJson;
  }
}