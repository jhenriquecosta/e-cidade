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
 * Controller responsável pela consulta, envio e relatório do protocolo
 *
 * Class Administrativo_ProtocoloController
 * @package Administrativo\Controllers\ProtocoloController
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Administrativo_ProtocoloController extends Administrativo_Lib_Controller_AbstractController {

  /**
   * Lista os protocolos
   */
  public function consultaAction() {

    $oFormConsulta = new Administrativo_Form_ProtocoloConsulta();
    $oFormConsulta->populate($this->getRequest()->getParams());

    $this->view->oFormConsulta = $oFormConsulta;
  }

  /**
   * Processa a pesquisa e retorna o html com o resultado da consulta [Ajax]
   */
  public function consultaProcessarAction() {

    parent::noTemplate();

    $oFormConsulta = new Administrativo_Form_ProtocoloConsulta();
    $oFormConsulta->populate($this->getRequest()->getParams());

    /**
     * Valores enviados para o controller
     */
    $aParametrosBusca  = $oFormConsulta->getValues();
    $oPaginatorAdapter = new DBSeller_Controller_Paginator(Administrativo_Model_Protocolo::getQuery(),
        'Administrativo_Model_Protocolo',
        'Administrativo\Protocolo');

    $oPaginatorAdapter->where("1 = 1");

    /**
     * Filtro por usuário
     */
    if (!empty($aParametrosBusca['usuario'])) {
        $oPaginatorAdapter->andWhere("e.usuario = {$aParametrosBusca['usuario']}");
    }

    /**
     * Filtro pelo código do protocolo
     */
    if (!empty($aParametrosBusca['protocolo'])) {
      $oPaginatorAdapter->andWhere("e.protocolo = '{$aParametrosBusca['protocolo']}'");
    }

    /**
     * Filtra pela data inicial e final
     */
    if (!empty($aParametrosBusca['data_processamento_inicial']) && !empty($aParametrosBusca['data_processamento_final'])) {

      $oPaginatorAdapter->andWhere(
                        "e.data_processamento BETWEEN '{$aParametrosBusca['data_processamento_inicial']} 00:00:00' AND
                        '{$aParametrosBusca['data_processamento_final']} 23:59:59'"
      );
    } else {

      if (!empty($aParametrosBusca['data_processamento_inicial'])) {
        $oPaginatorAdapter->andWhere("e.data_processamento = '{$aParametrosBusca['data_processamento_inicial']} 00:00:00'");
      } else if (!empty($aParametrosBusca['data_processamento_final'])) {
        $oPaginatorAdapter->andWhere("e.data_processamento = '{$aParametrosBusca['data_processamento_final']} 23:59:59'");
      }
    }

    /**
     * Ordena os registros
     */
    $oPaginatorAdapter->orderBy("e.protocolo, e.data_processamento", $aParametrosBusca['ordenacao']);

    /**
     * Monta a paginação do GridPanel
     */
    $oResultado = new Zend_Paginator($oPaginatorAdapter);
    $oResultado->setItemCountPerPage(10);
    $oResultado->setCurrentPageNumber($this->_request->getParam('page'));

    /**
     * Valores enviados para a View
     */
    $this->view->oFormConsulta = $oFormConsulta;
    $this->view->protocolos    = $oResultado;

    /**
     * Valores da pesquisa
     */
    if (is_array($aParametrosBusca)) {

      foreach ($aParametrosBusca as $sParametro => $sParametroValor) {

        if ($sParametroValor) {

          $sParametroValor = str_replace('/', '-', $sParametroValor);
          $this->view->sBusca .= "{$sParametro}/{$sParametroValor}/";
        }
      }
    }
  }

  /**
   * View para envio do protocolo por email (Modal)
   */
  public function emailAction() {

    parent::noTemplate();

    $oForm = new Administrativo_Form_ProtocoloEnvioEmail();
    $oForm->populate($this->getRequest()->getParams());

    $this->view->oFormEnvioEmail = $oForm;
  }

  /**
   * Executa o envio do protocolo por email via ajax
   */
  public function enviarEmailAction() {

    $aParametros  = $this->getRequest()->getParams();
    $oForm        = new Administrativo_Form_ProtocoloEnvioEmail();
    $oForm->populate($aParametros);

    /**
     * Parametros de retorno do AJAX
     */
    $aRetornoJson = array(
      'success' => FALSE,
      'message' => NULL
    );

    if (!$oForm->isValid($aParametros)) {

      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = 'Preencha os dados corretamente.';
    } else {

      try {

        // Consulta os dados do protocolo
        $oProtocolo      = Administrativo_Model_Protocolo::getByAttribute('id', $aParametros['id']);
        $aDadosProtocolo = $oProtocolo->toArray();

        // Gera o PDF com as informações do protocolo
        $aArquivoPDF = $this->gerarPDF($aDadosProtocolo);

        // Passa o objeto Protocolo para a view protocolo/email-emissao.phtml
        $this->view->oDadosProtocolo = $oProtocolo;

        // Renderiza a visão do corpo do email
        $sMensagemEmail = $this->view->render('protocolo/email-emissao.phtml');

        // Envia o protocolo por email
        $lEmail = DBSeller_Helper_Mail_Mail::sendAttachment($aParametros['email'],
                                                            "Protocolo nº {$oProtocolo->getProtocolo()}",
                                                            $sMensagemEmail,
                                                            $aArquivoPDF);

        /**
         * Verifica se o e-mail foi enviado com sucesso
         */
        if ($lEmail) {

          $aRetornoJson['success']  = TRUE;
          $aRetornoJson['message']  = 'Email enviado com sucesso';
        } else {
          throw new Exception('Erro ao enviar o email');
        }
      } catch (Exception $oErro) {
        $aRetornoJson['error'][] = $oErro->getMessage();
      }
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Imprime do PDF gerado
   */
  public function imprimirAction() {

    $this->noLayout();

    $aParametros     = $this->getRequest()->getParams();
    $oProtocolo      = Administrativo_Model_Protocolo::getByAttribute('id', $aParametros['id']);
    $aDadosProtocolo = $oProtocolo->toArray();
    $aArquivo        = $this->gerarPDF($aDadosProtocolo);

    parent::download($aArquivo['filename']);
  }

  /**
   * Gera o arquivo PDF no diretório /tmp
   *
   * @param array $aDadosProtocolo
   * @return array
   */
  private function gerarPDF(Array $aDadosProtocolo) {

    $sNomeArquivo    = 'protocolo_' . date('YmdHis') . '.pdf';
    $sCaminhoArquivo = TEMP_PATH . "/{$sNomeArquivo}";

    $oFpdf = new Administrativo_Model_RelatorioPdfModelo1('L');
    $oFpdf->setLinhaFiltro("Relatório de Protocolo");
    $oFpdf->setLinhaFiltro('');
    $oFpdf->setLinhaFiltro("Protocolo: {$aDadosProtocolo['protocolo']}");
    $oFpdf->setLinhaFiltro("Usuário: {$aDadosProtocolo['usuario']['nome']}");
    $oFpdf->Open($sCaminhoArquivo);
    $oFpdf->carregadados();

    $oFpdf->Ln(2);

    $oFpdf->SetFont('Arial', 'B', 8);
    $oFpdf->Cell(20, 5, 'Id', 1, 0, 'C', 1);
    $oFpdf->Cell(20, 5, 'Tipo', 1, 0, 'C', 1);
    $oFpdf->Cell(125, 5, 'Mensagem', 1, 0, 'C', 1);
    $oFpdf->Cell(75, 5, 'Sistema', 1, 0, 'C', 1);
    $oFpdf->Cell(40, 5, 'Data de Processamento', 1, 1, 'C', 1);

    $oFpdf->SetFont('Arial', '', 8);
    $oFpdf->Cell(20, 5, $aDadosProtocolo['id'], 1, 0, 'L');
    $oFpdf->Cell(20, 5, $aDadosProtocolo['descricao_tipo'], 1, 0, 'L');
    $oFpdf->Cell(125, 5, $aDadosProtocolo['mensagem'], 1, 0, 'L');
    $oFpdf->Cell(75, 5, $aDadosProtocolo['sistema'], 1, 0, 'L');
    $oFpdf->Cell(40, 5, $aDadosProtocolo['data_processamento'], 1, 1, 'L');

    $oFpdf->Output();

    // Opções de retorno
    $aRetorno = array(
      'location' => $sCaminhoArquivo,
      'filename' => $sNomeArquivo,
      'type'     => 'application/pdf'
    );

    return $aRetorno;
  }
}