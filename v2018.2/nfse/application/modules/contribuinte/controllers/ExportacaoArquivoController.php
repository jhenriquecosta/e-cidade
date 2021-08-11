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
 * Controller responsável pela exportação para arquivos (XML)
 *
 * Class Contribuinte_ExportacaoArquivoController
 * @package Contribuinte\Controllers\ExportacaoArquivoController
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Contribuinte_ExportacaoArquivoController extends Contribuinte_Lib_Controller_AbstractController {

  /**
   * Formulario de exportar RPS
   */
  public function rpsAction() {

    $oForm             = new Contribuinte_Form_ExportacaoArquivo();
    $this->view->oForm = $oForm;
  }

  /**
   * Consulta notas para exportar RPS
   */
  public function rpsConsultarAction() {

    parent::noTemplate();

    $aParametros = $this->getRequest()->getParams();

    /**
     * Verifica se foi informado mês e ano da competência
     */
    if (!empty($aParametros['mes_competencia']) && !empty($aParametros['ano_competencia'])) {

     $oContribuinte         = $this->_session->contribuinte;
     $sCodigosContribuintes = implode(',', $oContribuinte->getContribuintes());
     $oPaginatorAdapter     = new DBSeller_Controller_Paginator(Contribuinte_Model_Nota::getQuery(),
                                                               'Contribuinte_Model_Nota',
                                                               'Contribuinte\Nota');

      /**
       * Monta a query de consulta
       */
      $oPaginatorAdapter->where("e.id_contribuinte in ({$sCodigosContribuintes})");
      $oPaginatorAdapter->andWhere("e.mes_comp = {$aParametros['mes_competencia']}");
      $oPaginatorAdapter->andWhere("e.ano_comp = {$aParametros['ano_competencia']}");
      if (!empty($aParametros['numero_rps'])) {
        $oPaginatorAdapter->andWhere("e.nota = {$aParametros['numero_rps']}");
      }
      $oPaginatorAdapter->orderBy('e.nota', 'DESC');

      /**
       * Monta a paginação do GridPanel
       */
      $oResultado = new Zend_Paginator($oPaginatorAdapter);
      $oResultado->setItemCountPerPage(10);
      $oResultado->setCurrentPageNumber($this->_request->getParam('page'));

      foreach ($oResultado as $oNota) {

        $oNota->oContribuinte = $oContribuinte;
        $oNota->lNaoGeraGuia  = !$oNota->getEmite_guia();
        $oNota->lGuiaEmitida  = Contribuinte_Model_Guia::existeGuia($oContribuinte,
                                                                    $oNota->getMes_comp(),
                                                                    $oNota->getAno_comp(),
                                                                    Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE);
        
        /**
         * Informações da nota substituta
         */
        $oNota->oNotaSubstituida = NULL;
        if ($oNota->getIdNotaSubstituida()) {
          $oNota->oNotaSubstituida = Contribuinte_Model_Nota::getById($oNota->getIdNotaSubstituida());
        }

        /**
         * Informações da nota substituta
         */
        $oNota->oNotaSubstituta = NULL;
        if ($oNota->getIdNotaSubstituta()) {
          $oNota->oNotaSubstituta = Contribuinte_Model_Nota::getById($oNota->getIdNotaSubstituta());
        }
      }

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

      $this->view->oDadosNota = $oResultado;
    }
  }

  /**
   * Exporta os dados para XML
   */
  public function rpsExportarAction() {

    parent::noLayout();

    $aParametros = $this->getRequest()->getParams();

    /**
     * Parametros de retorno do AJAX
     */
    $aRetornoJson = array(
      'success' => FALSE,
      'message' => NULL
    );

    /**
     * Verifica se foi informado mês e ano da competência
     */
    if (!empty($aParametros['mes_competencia']) && !empty($aParametros['ano_competencia'])) {

      $oContribuinte = $this->_session->contribuinte;

      $oCompetencia       = new StdClass();
      $oCompetencia->iMes = $aParametros['mes_competencia'];
      $oCompetencia->iAno = $aParametros['ano_competencia'];

      $iNumeroRps = ((!empty($aParametros['numero_rps']))? $aParametros['numero_rps'] : NULL);

      $aNotas = Contribuinte_Model_Nota::getByContribuinteAndCompetencia($oContribuinte->getContribuintes(),
                                                                         $oCompetencia, 
                                                                         $iNumeroRps);
      /**
       * Verifica se existe alguma NFSe para a competência informada
       */
      if (count($aNotas) > 0) {

        $oXml                       = new DOMDocument("1.0", "UTF-8");
        $oXml->formatOutput         = TRUE;
        $oXmlConsultaRPSCompetencia = $oXml->createElement("ii:ConsultaRPSCompetencia");
        $oXmlConsultaRPSCompetencia->setAttribute("xmlns:ii", "urn:DBSeller");

        $oMes         = $oXml->createElement("ii:Mes", $oCompetencia->iMes);
        $oAno         = $oXml->createElement("ii:Ano", $oCompetencia->iAno);
        $oNoListaNfse = $oXml->createElement('ii:ListaNfse');

        foreach ($aNotas as $oNota) {

          $oNotaAbrasf = new WebService_Model_NotaAbrasf($oNota);
          $oNoListaNfse->appendChild($oXml->importNode($oNotaAbrasf->getNota(), true));
        }

        $oXmlConsultaRPSCompetencia->appendChild($oMes);
        $oXmlConsultaRPSCompetencia->appendChild($oAno);
        $oXmlConsultaRPSCompetencia->appendChild($oNoListaNfse);
        $oXml->appendChild($oXmlConsultaRPSCompetencia);

        /**
         * Path do arquivo
         */
        $sNomeArquivo    = "lista_rps_{$oCompetencia->iMes}_{$oCompetencia->iAno}.xml";
        $sCaminhoArquivo = TEMP_PATH . "/{$sNomeArquivo}";

        if (file_exists($sCaminhoArquivo)) {
          unlink($sCaminhoArquivo);
        }

        /**
         * Escreve os dados no arquivo
         */
        $aArquivo = fopen($sCaminhoArquivo, 'w');
        fputs($aArquivo, print_r($oXml->saveXML(), TRUE));
        fclose($aArquivo);

        $aRetornoJson['success']  = TRUE;
        $aRetornoJson['filename'] = $sNomeArquivo;
        $aRetornoJson['message']  = 'Notas exportadas com sucesso.';
      } else {
        $aRetornoJson['message'] = 'Nenhum registro encontrado.';
      }
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Faz o download do arquivo informado
   */
  public function downloadAction() {

    parent::noLayout();

    $aParametros = $this->getRequest()->getParams();
    if (!empty($aParametros['file'])) {
      self::download($aParametros['file']);
    }
  }
}