<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa é software livre; voce pode redistribui-lo e/ou
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
 * Controller responsável por gerenciar as solicitações de cancelamento dos contribuintes pelo fiscal
 *
 * Class Fiscal_CancelamentoNfseController
 * @package Fiscal\Controllers\CancelamentoNfseController
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Fiscal_CancelamentoNfseController extends Fiscal_Lib_Controller_AbstractController {

  /**
   * Consulta os cancelamentos solicitados pelos contribuintes
   */
  public function consultarAction() {

    if ($this->getRequest()->isPost()) {

      parent::noTemplate();

      $aSolicitacoes = array();
      $aParametros   = $this->getAllParams();
      $iLimit        = $aParametros['rows'];
      $iPage         = $aParametros['page'];

      $aFiltros = array(
        'rejeitado'  => NULL,
        'autorizado' => NULL
      );

      $aOrdem = array(
        'dt_solicitacao' => 'DESC'
      );

      $aSolicatacoesCancelamento = Contribuinte_Model_SolicitacaoCancelamento::getByAttributes($aFiltros, $aOrdem);
      $oPaginatorAdapter         = new DBSeller_Controller_PaginatorArray($aSolicatacoesCancelamento);

      $aResultado = new Zend_Paginator($oPaginatorAdapter);
      $aResultado->setItemCountPerPage($iLimit);
      $aResultado->setCurrentPageNumber($iPage);

      $iTotal      = $aResultado->getTotalItemCount();
      $iTotalPages = $aResultado->getPages()->pageCount;

      foreach ($aResultado as $oSolicatacaoCancelamento) {

      	$sMotivo = $this->getMotivoDescricaoCancelamento($oSolicatacaoCancelamento->getMotivo());

        $sData 				= $oSolicatacaoCancelamento->getDtSolicitacao()->format("d/m/Y");
        $sRazaoSocial = $oSolicatacaoCancelamento->getNota()->getP_razao_social();
        $sCpfCnpj 		= DBSeller_Helper_Number_Format::maskCPF_CNPJ($oSolicatacaoCancelamento->getNota()->getP_cnpjcpf());
        $iNota    		= $oSolicatacaoCancelamento->getNota()->getNota();

        // Montado objeto que será retorna à grid
        $oSolicitacao 						 				= new StdClass();
        $oSolicitacao->id 				 				= $oSolicatacaoCancelamento->getId();
        $oSolicitacao->motivo_label				= is_string($sMotivo) ? $sMotivo : "-";
        $oSolicitacao->dt_solicitacao			= $sData;
        $oSolicitacao->nome_contribuinte  = $sRazaoSocial;
        $oSolicitacao->nota   		 				= $iNota;
        $oSolicitacao->cnpj   		 				= $sCpfCnpj;

        $aSolicitacoes[] = $oSolicitacao;
      }

      /**
       * Parametros de retorno do AJAX
       */
      $aRetornoJson = array(
        'total'   => $iTotalPages,
        'page'    => $iPage,
        'records' => $iTotal,
        'rows'    => $aSolicitacoes
      );

      echo $this->getHelper('json')->sendJson($aRetornoJson);
    }
  }

  /**
   * Action que busca os dados da solicitação de cancelamento por id e retorna para o modal
   */
  public function visualizarAction() {

  	parent::noTemplate();

		$aDados 									= $this->getRequest()->getParams();
		$oSolicitacaoCancelamento = Contribuinte_Model_SolicitacaoCancelamento::getById($aDados['id']);

		$sMotivo = $this->getMotivoDescricaoCancelamento($oSolicitacaoCancelamento->getMotivo());

		$oSolicitacaoView 							 = new StdClass();
		$oSolicitacaoView->id 					 = $oSolicitacaoCancelamento->getId();
		$oSolicitacaoView->nota  				 = $aDados['nota'];
		$oSolicitacaoView->justificativa = $oSolicitacaoCancelamento->getJustificativa();
		$oSolicitacaoView->motivo 			 = is_string($sMotivo) ? $sMotivo : "-";
    $oSolicitacaoView->dtNota        = $oSolicitacaoCancelamento->getNota()->getDt_nota()->format('d/m/Y');

		$this->view->oSolicitacao = $oSolicitacaoView;
  }

  /**
   * Action que autoriza e efetua o cancelamento solicitado pelo contribuinte
   */
  public function confirmarAction() {

  	parent::noLayout();

    $oDoctrine = Zend_Registry::get('em');
    $oDoctrine->getConnection()->beginTransaction();

    try {

      $aDados            = $this->getRequest()->getParams();
      $aLoginUsuario     = Zend_Auth::getInstance()->getIdentity();
      $oUsuario          = Administrativo_Model_Usuario::getByAttribute('login', $aLoginUsuario['login']);
      $oSolicitacao      = Contribuinte_Model_SolicitacaoCancelamento::getById($aDados['id']);
      $oNota             = Contribuinte_Model_Nota::getById($oSolicitacao->getNota()->getId());
      $oDataCancelamento = new DateTime();

      $oCancelamentoNota = new Contribuinte_Model_CancelamentoNota();

      $oCancelamentoNota->setUsuarioCancelamento($oUsuario);
      $oCancelamentoNota->setNotaCancelada($oNota);
      $oCancelamentoNota->setJustificativa($oSolicitacao->getJustificativa());
      $oCancelamentoNota->setMotivoCancelmento($oSolicitacao->getMotivo());
      $oCancelamentoNota->setDataHora($oDataCancelamento);
      $oCancelamentoNota->salvar();

      $sRetornoEmail    = $this->enviarEmailCancelamento($oNota, $oSolicitacao);
      $sMensagemRetorno = "Cancelamento efetuado com sucesso!";
      $sMensagemRetorno = (is_null($sRetornoEmail)) ? $sMensagemRetorno : $sRetornoEmail;

      $oSolicitacao->destroy();

      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['success'] = $sMensagemRetorno;

      $oDoctrine->getConnection()->commit();

    } catch (Exception $oError) {

      $oDoctrine->getConnection()->rollback();

  		$aRetornoJson['status']  = FALSE;
  		$aRetornoJson['error'][] = $oError->getMessage();
  	}

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Método que retorna a descrição do motivo do cancelamento
   */
  public function getMotivoDescricaoCancelamento($iMotivo) {

  	if ($iMotivo == Contribuinte_Model_CancelamentoNota::CANCELAMENTO_ERRO_EMISSAO) {
  	  $sMotivo = 'Erro na emissão.';
  	} else if ($iMotivo == Contribuinte_Model_CancelamentoNota::CANCELAMENTO_NOTA_DUPLICADA) {
  	  $sMotivo = 'Duplicidade da nota.';
  	} else if ($iMotivo == Contribuinte_Model_CancelamentoNota::CANCELAMENTO_SERVICO_NAO_PRESTADO) {
  	  $sMotivo = 'Serviço não prestado.';
  	} else if ($iMotivo == Contribuinte_Model_CancelamentoNota::CANCELAMENTO_OUTROS){
  	  $sMotivo = 'Outros.';
  	} else {
  		return FALSE;
  	}

  	return $sMotivo;
  }

  /**
   * Gera o PDF da NFSE
   *
   * @param string  $sCodigoVerificacao
   * @return string
   */
  private function getNotaImpressao($sCodigoVerificacao) {

    $oNota                  = Contribuinte_Model_Nota::getByAttribute('cod_verificacao', $sCodigoVerificacao);
    $oPrefeitura            = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    $this->view->aDadosNota = Contribuinte_Model_Nota::getDadosEmissao($sCodigoVerificacao, $oNota, $oPrefeitura);

    $sHtml         = "pdf/nota_modelo_{$oPrefeitura->getModeloImpressaoNfse()}.phtml";
    $sHtml         = $this->view->render($sHtml);
    $sNomeArquivo  = "nfse_{$oNota->getNota()}";
    $sLocalArquivo = APPLICATION_PATH . "/../public/tmp/{$sNomeArquivo}";

    DBSeller_Helper_Pdf_Pdf::renderPdf($sHtml,
                                       $sLocalArquivo,
                                       array('format' => 'A4', 'output' => 'F'));

    return array(
      'location' => "{$sLocalArquivo}.pdf",
      'filename' => "{$sNomeArquivo}.pdf",
      'type'     => 'application/pdf'
    );
  }

  /**
   * Método responsável pelo envio de email no cancelamento ou na solicitação do mesmo
   * @param  Contribuinte_Model_Nota 										$oNota
   * @param  Contribuinte_Model_SolicitacaoCancelamento $oSolicitacao
   * @return string|null
   */
  public function enviarEmailCancelamento($oNota, $oSolicitacao) {

		//Retorna os usuarios do tipo fiscal
		$aUsuariosFiscal   = Administrativo_Model_Usuario::getByAttribute('tipo',
		                                                             Administrativo_Model_Usuario::USUARIO_TIPO_FISCAL);

		//Remove o usuário admin do array
		if ($aUsuariosFiscal[0]->getAdministrativo()) {
		  unset($aUsuariosFiscal[0]);
		}

		$aEmailBCC = array();

		//Pega os emails cadastrados dos usuarios fiscais
		foreach ($aUsuariosFiscal as $oUsuarioFiscal) {

		  $sEmail = $oUsuarioFiscal->getEmail();

      if (!is_null($sEmail) && $sEmail != '' && $oUsuarioFiscal->getHabilitado()) {
        $aEmailBCC[] = $sEmail;
      }
    }

		$oValidadorEmail  = new Zend_Validate_EmailAddress();
		$emailTO          = $oNota->getT_email();
		$sMensagemRetorno = NULL;

		$sEmailTomador = $oSolicitacao->getEmailTomador();

		if ($oValidadorEmail->isValid($emailTO)
		  || (!empty($sEmailTomador) && $oValidadorEmail->isValid($sEmailTomador))
		  || (count($aEmailBCC) > 0)) {


		  $iInscricaoMunicipal = $oNota->getP_im();
		  $oContribuinte       = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

		  $this->view->nota          = $oNota;
		  $this->view->tomadorNome   = $oNota->getT_razao_social();
		  $this->view->prestadorNome = $oContribuinte->getNome();
		  $this->view->prestadorCnpj = DBSeller_Helper_Number_Format::maskCPF_CNPJ($oContribuinte->getCgcCpf());
		  $this->view->nfseNumero    = $oNota->getNota();
		  $this->view->nfseUrl       = $oNota->getUrlVerificacaoNota();
		  $this->mensagem            = $this->view->render('nfse/email-emissao.phtml');

		  $aArquivoPdfNfse = $this->getNotaImpressao($oNota->getCod_verificacao(), TRUE, TRUE);

		  // Verifica se foi mudado o e-mail do Tomador para enviar uma cópia oculta do cancelamento
		  if (!empty($sEmailTomador)
		    && $sEmailTomador != $oNota->getT_email()
		    && $oValidadorEmail->isValid($sEmailTomador)) {

		    $emailTO  = $sEmailTomador;

		    if ($oValidadorEmail->isValid($oNota->getT_email())) {
		      $aEmailBCC[] = $oNota->getT_email();
		    }

		    $sMensagemRetorno = "Cancelamento efetuado com sucesso.<br>Email foi enviado para {$emailTO}";
		  }

      // Caso não haja email cadastrado na nota e nem email informado no cancelamento,
      // ou se for uma solicitação de cancelamento, o primeiro email de fiscal é colocado
      // como destinatário principal para que seja possível o envio
		  if (is_null($emailTO) || empty($emailTO)) {

		    $emailTO = $aEmailBCC[0];
		    unset($aEmailBCC[0]);

	      $sMensagemRetorno = "Cancelamento efetuado com sucesso.<br>Email foi enviado para {$emailTO}";
		  }

		  // Envia Email
		  DBSeller_Helper_Mail_Mail::sendAttachment($emailTO,
		                                            "Nota Fiscal Eletrônica nº {$oNota->getNota()}",
		                                            $this->mensagem,
		                                            $aArquivoPdfNfse,
		                                            $aEmailBCC);

		  // Apaga o arquivo temporario gerado para envio do email
		  unlink($aArquivoPdfNfse['location']);
		}

		return $sMensagemRetorno;
  }

  /**
   * Método para rejeitar a solicitação de cancelamento de NFSE
   */
  public function rejeitarAction() {

    parent::noTemplate();
    $aDados = $this->getRequest()->getParams();
    $oForm  = new Fiscal_Form_CancelamentoRejeitar();

    $this->view->solicitacao = $aDados;
    $oForm->populate(array('id' => $aDados['id']));
    $this->view->form = $oForm;

    if ($this->getRequest()->isPost()) {

      parent::noLayout();

      $oDoctrine = Zend_Registry::get('em');
      $oDoctrine->getConnection()->beginTransaction();

      try {

        $aDados       = $this->getRequest()->getParams();
        $oSolicitacao = Contribuinte_Model_SolicitacaoCancelamento::getById($aDados['id']);
        $oNota        = Contribuinte_Model_Nota::getById($oSolicitacao->getNota()->getId());

        $sRetornoEmail    = $this->enviarEmailRejeicao($oNota, $oSolicitacao, $aDados['justificativa_fiscal']);
        $sMensagemRetorno = 'Solicitação rejeitada com sucesso!';
        $sMensagemRetorno = (is_null($sRetornoEmail)) ? $sMensagemRetorno : $sRetornoEmail;

        $oSolicitacao->destroy();

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $sMensagemRetorno;
        $oDoctrine->getConnection()->commit();

      } catch (Exception $oError) {

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $oError->getMessage();
        $oDoctrine->getConnection()->rollback();
      }

      echo $this->getHelper('json')->sendJson($aRetornoJson);
    }
  }

  /**
   * Método responsável pelo envio de email no cancelamento ou na solicitação do mesmo
   *
   * @param $oNota
   * @param $oSolicitacao
   * @param $sJustificativaFiscal
   * @return null|string
   */
  public function enviarEmailRejeicao($oNota, $oSolicitacao, $sJustificativaFiscal) {

    $sMensagemRetorno = NULL;

    //Retorna os usuarios do tipo fiscal
    $aUsuariosFiscal   = Administrativo_Model_Usuario::getByAttribute('tipo',
                                                                      Administrativo_Model_Usuario::USUARIO_TIPO_FISCAL);

    //Remove o usuário admin do array
    if ($aUsuariosFiscal[0]->getAdministrativo()) {
      unset($aUsuariosFiscal[0]);
    }

    // Monta os destinatarios do email
    $aEmailBCC = array();

    //Pega os emails cadastrados dos usuarios fiscais
    foreach ($aUsuariosFiscal as $oUsuarioFiscal) {

      $sEmail = $oUsuarioFiscal->getEmail();

      if (!is_null($sEmail) && $sEmail != '' && $oUsuarioFiscal->getHabilitado()) {
        $aEmailBCC[] = trim($sEmail);
      }
    }

    $sMensagemRetorno = "Cancelamento rejeitado com sucesso.";

    // Email do prestador da nota
    $emailTO = $oNota->getP_email();

    $oValidadorEmail = new Zend_Validate_EmailAddress();
    $sEmailTomador = $oSolicitacao->getEmailTomador();

    if ($oValidadorEmail->isValid($emailTO)
      || (count($aEmailBCC) > 0)) {


      // Monta conteudo do e-mail
      $iInscricaoMunicipal = $oNota->getP_im();
      $oContribuinte       = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

      $this->view->nota                 = $oNota;
      $this->view->justificativa_fiscal = $sJustificativaFiscal;
      $this->view->tomadorNome          = $oNota->getT_razao_social();
      $this->view->prestadorNome        = $oContribuinte->getNome();
      $this->view->prestadorCnpj        = DBSeller_Helper_Number_Format::maskCPF_CNPJ($oContribuinte->getCgcCpf());
      $this->view->nfseNumero           = $oNota->getNota();
      $this->view->nfseUrl              = $oNota->getUrlVerificacaoNota();

      $this->mensagem                   = $this->view->render('nfse/email-rejeicao-cancelamento.phtml');

      // Verifica se foi mudado o e-mail do Tomador para enviar uma cópia oculta do cancelamento
      if (!empty($sEmailTomador)
        && $oValidadorEmail->isValid($sEmailTomador)) {
        $aEmailBCC[] = $sEmailTomador;
      }

      if ($oValidadorEmail->isValid($oNota->getT_email()) && $oNota->getT_email() != $sEmailTomador) {
        $aEmailBCC[] = $oNota->getT_email();
      }

      // Envia Email
      if (DBSeller_Helper_Mail_Mail::send($emailTO,
                                      "Nota Fiscal Eletrônica nº {$oNota->getNota()}",
                                      $this->mensagem,
                                      'utf-8',
                                      $aEmailBCC)) {

        $sMensagemRetorno .= "<br>Email foi enviado para {$emailTO}";
      }
    }

    return $sMensagemRetorno;
  }
}