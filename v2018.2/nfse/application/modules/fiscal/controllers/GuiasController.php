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
 * Controller responsável pela geração automatica das guias pelo fiscal
 *
 * Class Fiscal_GuiasController
 * @package Fiscal\Controllers\GuiasController
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Fiscal_GuiasController extends Fiscal_Lib_Controller_AbstractController {

  /**
   * Formulário de geração automatica das guias
   */
  public function geracaoAutomaticaAction() {

    $oForm             = new Fiscal_Form_Guias();
    $this->view->oForm = $oForm;
  }

  /**
   * Consulta as guias dos contribuintes por competência
   */
  public function consultarAction() {

    parent::noTemplate();

    $aParametros = $this->getRequest()->getParams();

    /**
     * Verifica se foi informado mês e ano da competência
     */
    if (!empty($aParametros['mes_competencia']) && !empty($aParametros['ano_competencia'])) {

      $iMesCompetencia   = str_pad($aParametros['mes_competencia'], 2, '0', STR_PAD_LEFT);
      $iAnoCompetencia   = $aParametros['ano_competencia'];
      $aGuiasCompetencia = Contribuinte_Model_Competencia::getByGuiasContribuinteAndCompetencia($iMesCompetencia,
                                                                                                $iAnoCompetencia);

      $oPaginatorAdapter = new DBSeller_Controller_PaginatorArray($aGuiasCompetencia);
      $oPaginator        = new Zend_Paginator($oPaginatorAdapter);
      $oPaginator->setItemCountPerPage(10);
      $oPaginator->setCurrentPageNumber($this->_request->getParam('page'));

      /**
       * Valores da pesquisa para montar a paginação
       */
      if (is_array($aParametros)) {

        foreach ($aParametros as $sParametro => $sParametroValor) {

          if ($sParametroValor) {

            $sParametroValor = str_replace('/', '-', $sParametroValor);
            $this->view->sBusca .= "{$sParametro}/{$sParametroValor}/";
          }
        }
      }

      $this->view->oGuiasCompetencia = $oPaginator;
    }
  }

  /**
   * Gerar as guias em aberto dos contribuintes
   */
  public function gerarAction() {

    parent::noLayout();

    $aParametros = $this->getRequest()->getParams();

    /**
     * Parametros de retorno do AJAX
     */
    $aRetornoJson = array(
      'success' => FALSE,
      'message' => NULL
    );

    try {

      /**
       * Verifica competência informada
       */
      if (empty($aParametros['mes_competencia']) || empty($aParametros['ano_competencia'])) {
        throw new Exception('Informe a competência.');
      }

      $iMesCompetencia = str_pad($aParametros['mes_competencia'], 2, '0', STR_PAD_LEFT);
      $iAnoCompetencia = $aParametros['ano_competencia'];
      $iMesCorrente    = date('m');
      $iAnoCorrente    = date('Y');

      /**
       * Verifica mês e ano corrente
       */
      if ($iMesCompetencia >= $iMesCorrente && $iAnoCompetencia == $iAnoCorrente) {
        throw new Exception('Competência corrente não é gerado guia. <br />Selecione os meses anteriores ao corrente.');
      }

      $oDataPagamento    = new DateTime();
      $aGuiasCompetencia = Contribuinte_Model_Competencia::getByGuiasContribuinteAndCompetencia($iMesCompetencia,
                                                                                                $iAnoCompetencia);


      /**
       * Verifica se encontro alguma guia em aberto
       */
      if (count($aGuiasCompetencia) == 0) {
        throw new Exception('Nenhum registro encontrado para a competência selecionada.');
      }

      foreach ($aGuiasCompetencia as $oGuiaCompetencia) {

        $oContribuinte   = $oGuiaCompetencia->getContribuinte();
        $iMesCompetencia = $oGuiaCompetencia->getMesComp();
        $iAnoCompetencia = $oGuiaCompetencia->getAnoComp();
        $aNotas          = $oGuiaCompetencia->getNotas();

        if (empty($iMesCompetencia)) {
          throw new Exception("O mês de competência do contribuinte {$oContribuinte->getInscricaoMunicipal()} não foi informado.");
        }

        if (empty($iAnoCompetencia)) {
          throw new Exception("O ano de competência do contribuinte {$oContribuinte->getInscricaoMunicipal()} não foi informado.");
        }

        if (count($aNotas) == 0) {
          throw new Exception("Não existem notas na competência do contribuinte {$oContribuinte->getInscricaoMunicipal()} não foi informado.");
        }

        $oCompetenciaEnceramento = new Contribuinte_Model_CompetenciaEnceramento($oContribuinte,
                                                                                 $iAnoCompetencia,
                                                                                 $iMesCompetencia,
                                                                                 $oDataPagamento);
        $oRetorno = $oCompetenciaEnceramento->encerrar();
      }

      $aRetornoJson['success'] = TRUE;
      $aRetornoJson['message'] = "Guias de competência {$iMesCompetencia}/{$iAnoCompetencia} geradas com sucesso.";
      /**
       * Para uso como debug de retorno do e-cidade
       */
      //$aRetornoJson['retorno_ecidade'] = $aRetornoGuiaEcidade;
    } catch (Exception $oErro) {
      $aRetornoJson['message'] = $oErro->getMessage();
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Formulário de impressão automatica das guias
   */
  public function impressaoGeracaoAutomaticaAction() {

    $oForm             = new Fiscal_Form_Guias();
    $oForm->getElement('btn_gerar')->setAttrib('style', 'display:none;');
    $oForm->getElement('btn_consultar')->setLabel('Imprimir');
    $oForm->getElement('btn_consultar')->setAttrib('type', 'submit');
    $oForm->setAction($this->action);

    $this->view->oForm = $oForm;

    if ($this->getRequest()->isPost()) {

      $aParametros = $this->getRequest()->getParams();
      parent::noTemplate();

        $iMesCompetencia   = str_pad($aParametros['mes_competencia'], 2, '0', STR_PAD_LEFT);
        $iAnoCompetencia   = $aParametros['ano_competencia'];
        $aGuiasCompetencia = Contribuinte_Model_Competencia::getByGuiasContribuinteAndCompetencia($iMesCompetencia,
                                                                                                  $iAnoCompetencia);
        $oPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();

        $aDadosRelatorio = array();

        foreach ($aGuiasCompetencia as $oGuia) {

          $oDados = new stdClass();
          $oDados->competencia = $oGuia->getCompetencia();
          $oDados->valorTotal  = $oGuia->getFormatedTotalServico();
          $oDados->valorIss    = $oGuia->getFormatedTotalIss();
          $oDados->razaoSocial = $oGuia->getContribuinte()->getNome();
          $oDados->im          = $oGuia->getContribuinte()->getInscricaoMunicipal();
          $oDados->cnpj        = $oGuia->getContribuinte()->getCgcCpf();

          $aDadosRelatorio[]   = $oDados;
        }

        $oImpressaoRelatorio = new Fiscal_Model_ImpressaoRelatorioDeGuias();
        $oImpressaoRelatorio->setAmbiente(getenv("APPLICATION_ENV"));
        $oImpressaoRelatorio->setPrefeitura($oPrefeitura->getNome());
        $oImpressaoRelatorio->setDados($aDadosRelatorio);

        $aArquivo = $oImpressaoRelatorio->montaRelatorio();
        parent::download($aArquivo['filename']);

    }
  }
}