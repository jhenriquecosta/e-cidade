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
 * Controller para emissao de RPC (Recibo Provisorio de Servico)
 *
 * @package Contribuinte/Controllers
 */

class Contribuinte_RpsController extends Contribuinte_Lib_Controller_AbstractController {

  /**
   * Monta a tela para emissão do RPS
   *
   * @return void
   */
  public function indexAction() {

    try {

      $aDados        = $this->getRequest()->getParams();
      $oContribuinte = $this->_session->contribuinte;

      $this->view->empresa_nao_prestadora    = FALSE;
      $this->view->empresa_nao_emissora_nfse = FALSE;
      $this->view->bloqueado_msg             = FALSE;


      $oForm = $this->formNota(NULL, $oContribuinte);

      // Verifica se o contribuinte tem permissão para emitir nfse/rps
      if ($oContribuinte->getTipoEmissao() != Contribuinte_Model_ContribuinteAbstract::TIPO_EMISSAO_NOTA) {

        $this->view->empresa_nao_emissora_nfse = TRUE;

        return;
      }

      // Verifica se a empresa é prestadora de serviços
      $aServicos = Contribuinte_Model_Servico::getByIm($oContribuinte->getInscricaoMunicipal());

      if ($aServicos == NULL || empty($aServicos)) {

        $this->view->empresa_nao_prestadora = TRUE;

        return;
      }

      // Verifica o prazo de emissão de documentos e retorna as mensagens de erro
      self::mensagemPrazoEmissao();

      // Configura o formulário
      $oForm->preenche($aDados);
      $oForm->setListaServicos($aServicos);

      $this->view->form = $oForm;

      // Validadores
      $oValidaData = new Zend_Validate_Date(array('format' => 'yyyy-MM-dd'));

      // Bloqueia a emissão se possuir declarações sem movimento
      if (isset($aDados['dt_nota']) && $oValidaData->isValid($aDados['dt_nota'])) {

        $oDataSimples = new DateTime($aDados['dt_nota']);

        $aDeclaracaoSemMovimento = Contribuinte_Model_Competencia::getDeclaracaoSemMovimentoPorContribuintes(
                                                                 $oContribuinte->getInscricaoMunicipal(),
                                                                 $oDataSimples->format('Y'),
                                                                 $oDataSimples->format('m'));

        if (count($aDeclaracaoSemMovimento) > 0) {

          $sMensagemErro = 'Não é possível emitir um documento nesta data, pois a competência foi declarada como ';
          $sMensagemErro .= 'sem movimento.<br>Entre em contato com o setor de arrecadação da prefeitura.';

          $this->view->messages[] = array('error' => $sMensagemErro);

          return;
        }
      }

      // Trata o post do formulário
      if ($this->getRequest()->isPost()) {

        $oNota = new Contribuinte_Model_Nota();

        // Valida os dados informados no formulário
        if (!$oForm->isValid($aDados)) {

          $this->view->form       = $oForm;
          $this->view->messages[] = array('error' => $this->translate->_('Preencha os dados corretamente.'));
        } else if ($oNota::existeRps($oContribuinte, $aDados['n_rps'], $aDados['tipo_nota'])) {

          $this->view->form       = $oForm;
          $this->view->messages[] = array('error' => $this->translate->_('Já existe um RPS com esta numeração.'));
        } else {

          $oAidof              = new Administrativo_Model_Aidof();
          $iInscricaoMunicipal = $oContribuinte->getInscricaoMunicipal();

          /*
           * Verifica se a numeração do AIDOF é válida
           */
          $lVerificaNumeracao = $oAidof->verificarNumeracaoValidaParaEmissaoDocumento(
                                       $iInscricaoMunicipal,
                                       $aDados['n_rps'],
                                       $aDados['tipo_nota']);

          if (!$lVerificaNumeracao) {

            $sMensagem              = 'A numeração do RPS não confere com os AIDOFs liberados.';
            $this->view->messages[] = array('error' => $this->translate->_($sMensagem));

            return;
          }

          // Remove chaves inválidas
          unset($aDados['enviar'], $aDados['action'], $aDados['controller'], $aDados['module'], $aDados['estado']);

          // Filtro para retornar somente numeros
          $aFilterDigits = new Zend_Filter_Digits();

          $aDados['p_im']            = $oContribuinte->getInscricaoMunicipal();
          $aDados['grupo_nota']      = Contribuinte_Model_Nota::GRUPO_NOTA_RPS;
          $aDados['t_cnpjcpf']       = $aFilterDigits->filter($aDados['t_cnpjcpf']);
          $aDados['t_cep']           = $aFilterDigits->filter($aDados['t_cep']);
          $aDados['t_telefone']      = $aFilterDigits->filter($aDados['t_telefone']);
          $aDados['id_contribuinte'] = $oContribuinte->getIdUsuarioContribuinte();
          $aDados['id_usuario']      = $this->usuarioLogado->getId();

          if (!$oNota->persist($aDados)) {

            $this->view->form       = $oForm;
            $this->view->messages[] = array('error' => $this->translate->_('Houver um erro ao tentar emitir a nota.'));

            return NULL;
          }

          $this->view->messages[] = array('success' => $this->translate->_('Nota emitida com sucesso.'));
          $this->_redirector->gotoSimple('dados-nota', 'nfse', NULL, array('id' => $oNota->getId(), 'tipo_nota' => 'rps'));
        }
      }
    } catch (Exception $oError) {

      $this->view->messages[] = array('error' => $oError->getMessage());

      return;
    }
  }

  /**
   * Action para montar o formulario de requisica de AIDOF
   *
   * @return void
   */
  public function requisicaoAction() {

    $oBaseUrlHelper      = new Zend_View_Helper_BaseUrl();
    $oContribuinte       = $this->_session->contribuinte;
    $iInscricaoMunicipal = $oContribuinte->getInscricaoMunicipal();
    $aServicos           = Contribuinte_Model_Servico::getByIm($iInscricaoMunicipal);

    // Verifica se a empresa é prestadora de serviços
    if ($aServicos == NULL || empty($aServicos)) {

      $this->view->sMensagemBloqueio = $this->translate->_('Empresa não prestadora de serviço.');

      return;
    }

    // Verifica se a empresa é emissora de NFSe
    $iTipoEmissaoNota = Contribuinte_Model_ContribuinteAbstract::TIPO_EMISSAO_NOTA;

    if ($oContribuinte->getTipoEmissao($iInscricaoMunicipal) != $iTipoEmissaoNota) {

      $this->view->sMensagemBloqueio = $this->translate->_('Empresa não emissora de NFS-E.');

      return;
    }

    $oFormRequisicao = new Contribuinte_Form_RequisicaoRps();
    $oFormRequisicao->setAction($oBaseUrlHelper->baseUrl('/contribuinte/rps/gerar-requisicao'));

    $this->view->oFormRequisicao  = $oFormRequisicao;
    $this->view->aTipoDocumento   = Contribuinte_Model_nota::getTiposNota(Contribuinte_Model_Nota::GRUPO_NOTA_RPS);
    $this->view->aListaRequisicao = Administrativo_Model_RequisicaoAidof::getRequisicoeseAidofs(
                                                                        $iInscricaoMunicipal,
                                                                        NULL,
                                                                        Contribuinte_Model_Nota::GRUPO_NOTA_RPS);
  }

  /**
   * Gera uma requisicao de AIDOF
   *
   * @return void
   */
  public function gerarRequisicaoAction() {

    $aDados = $this->getRequest()->getParams();
    $oForm  = new Contribuinte_Form_RequisicaoRps();

    // Busca Tipos de Nota do Grupo RPS
    $aTiposNota = Contribuinte_Model_Nota::getTiposNota(Contribuinte_Model_Nota::GRUPO_NOTA_RPS);

    // Popula o select com os tipos de nota para poder validar
    if (is_object($oForm->tipo_documento) && is_array($aTiposNota)) {
      $oForm->tipo_documento->addMultiOptions($aTiposNota);
    }

    // Valida o formulario e gera a requisicao
    if ($oForm->isValid($aDados)) {

      $iInscricaoMunicipal = $this->_session->contribuinte->getInscricaoMunicipal();
      $iCgmGrafica         = $this->_getParam('cgm_grafica');
      $iTipoDocumento      = $this->_getParam('tipo_documento');
      $iQuantidade         = $this->_getParam('quantidade');

      // Verifica se possui requisicoes pendentes
      $iQuantidadeRequisicaoPendente = Administrativo_Model_RequisicaoAidof::verificarRequisicaoPendente(
                                                                           $iInscricaoMunicipal,
                                                                           $iTipoDocumento,
                                                                           Contribuinte_Model_Nota::GRUPO_NOTA_RPS);

      if ($iQuantidadeRequisicaoPendente > 0) {

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $this->translate->_('Existem requisições pendentes para este tipo de documento.');
      } else {

        Administrativo_Model_RequisicaoAidof::gerar(
                                            $iTipoDocumento,
                                            $iInscricaoMunicipal,
                                            $iCgmGrafica,
                                            $iQuantidade);

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('Requisição de emissão de RPS enviada.');
        $aRetornoJson['reload']  = TRUE;
      }
    } else {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = $this->translate->_('Preencha os dados corretamente.');
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Action para realizar o cancelamento de uma requisicao de AIDOF.
   * O request da action deverá receber o 'id' do Aidof.
   *
   * @return void
   */
  public function cancelarRequisicaoAction() {

    $iCodigoRequisicao  = $this->_getParam('id');
    $aRetorno['status'] = FALSE;
    $oRetornoWebService = Administrativo_Model_RequisicaoAidof::cancelar($iCodigoRequisicao);

    if (is_object($oRetornoWebService) && $oRetornoWebService->bStatus) {

      $aRetorno['status']  = TRUE;
      $aRetorno['success'] = $this->translate->_('Requisição cancelada com sucesso.');
    } else if (is_object($oRetornoWebService) && !$oRetornoWebService->bStatus) {
      $aRetorno['error'][] = $oRetornoWebService->sMensagem;
    }

    echo $this->getHelper('json')->sendJson($aRetorno);
  }

  /**
   * Action responsável pela montagem do relatório Aidof e download do mesmo
	 *
   * @return void
   */
  public function aidofImpressaAction() {

    parent::noLayout();

    $iRpsInicial   = parent::getParam('inicial');
    $iRpsFinal     = parent::getParam('final');
    $oContribuinte = $this->_session->contribuinte;
    $oPrefeitura   = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();

    $oImpressao  = new Contribuinte_Model_ImpressaoAidof();
    $aArquivo    = $oImpressao->montarelatorio(array(
    	'inicial'            => $iRpsInicial,
      'final'              => $iRpsFinal,
      'incricao_municipal' => $oContribuinte->getInscricaoEstadual(),
      'nome_razao'         => $oContribuinte->getNome(),
      'cnpj'               => $oContribuinte->getCgcCpf(),
      'endereco'           => $oContribuinte->getDescricaoLogradouro(),
      'uf'                 => $oContribuinte->getEstado(),
      'cep'                => $oContribuinte->getCep(),
      'email'              => $oContribuinte->getEmail(),
      'fone'               => $oContribuinte->getTelefone(),
      'municipio'          => $oContribuinte->getDescricaoMunicipio(),
      'nome_prefeitura'    => $oPrefeitura->getNome(),
      'url_prefeitura'     => $oPrefeitura->getUrl(),
      'ambiente'           => getenv("APPLICATION_ENV")
    ));

    parent::download($aArquivo['filename']);
  }

  /**
   * Emite a mensagem do prazo de emissao da RPS
   * Verifica o prazo/quantidade limite para emissao de notas ou rps conforme parametros
   * configurados pelo contribuinte ou pela prefeitura e mostra um aviso para realizar uma
   * nova requisicao para emissao
   *
   * @throws Exception Erro ao acesso do webservice
   * @return boolean
   */
  private function mensagemPrazoEmissao() {

    $oContribuinte       = $this->_session->contribuinte;
    $iInscricaoMunicipal = $oContribuinte->getInscricaoMunicipal();
    $iIdContribuinte     = $oContribuinte->getIdUsuarioContribuinte();

    try {

      $iQuantidadeNotasEmissao = Contribuinte_Model_NotaAidof::getQuantidadeNotasPendentes(
                                                             $iInscricaoMunicipal,
                                                             NULL,
                                                             Contribuinte_Model_Nota::GRUPO_NOTA_RPS);

      if ($iQuantidadeNotasEmissao == 0) {

        $sMensagem                 = 'Limite de notas para emissão atingido, faça uma nova requisição.';
        $this->view->bloqueado_msg = $this->translate->_($sMensagem);

        return FALSE;
      }

      $oParamContribuinte   = Contribuinte_Model_ParametroContribuinte::getById($iIdContribuinte);
      $sMensagemErroEmissao = 'Você possui "%s" notas para emissão. É importante gerar uma nova requisição.';

      // Verifica a quantidade de notas pela configuracao do Contribuinte
      if (is_object($oParamContribuinte) && $oParamContribuinte->getAvisofimEmissaoNota() > 0) {

        if ($iQuantidadeNotasEmissao <= $oParamContribuinte->getAvisofimEmissaoNota()) {

          $this->view->messages[] = array(
            'warning' => sprintf($this->translate->_($sMensagemErroEmissao), $iQuantidadeNotasEmissao)
          );
        }
      } else {

        $oParamPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();

        if (is_object($oParamPrefeitura) && $oParamPrefeitura->getQuantidadeAvisoFimEmissao() > 0) {

          if ($iQuantidadeNotasEmissao <= $oParamPrefeitura->getQuantidadeAvisoFimEmissao()) {

            $this->view->messages[] = array(
              'warning' => sprintf($this->translate->_($sMensagemErroEmissao), $iQuantidadeNotasEmissao)
            );
          }
        }
      }
    } catch (Exception $e) {

      echo $this->translate->_('Ocorreu um erro ao verificar a quantidade limite para emissão de notas.');

      return FALSE;
    }

    return TRUE;
  }

  /**
   * Instancia o formulario de emissão de RPS
   *
   * @param string                                  $sCodigoVerificacao Código de Verificação
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte      Dados do contribuinte
   * @return Contribuinte_Form_RpsEmissao
   */
  private function formNota($sCodigoVerificacao, Contribuinte_Model_ContribuinteAbstract $oContribuinte = NULL) {

    // Seta o contribuinte da sessão se não for enviado por parâmetro
    $oContribuinte        = $oContribuinte ? $oContribuinte : $this->_session->contribuinte;
    $iIdContribuinte      = $oContribuinte->getIdUsuarioContribuinte();
    $maxNota              = 0;
    $maxGuia              = 0;
    $aListaIdContribuinte = $oContribuinte->getContribuintes();

    // Calcula quantos dias no passado a nota pode ser emtidida
    $oParametrosPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    $max                   = $oParametrosPrefeitura->getNotaRetroativa();
    $oUltimaGuia           = Contribuinte_Model_Guia::getUltimaGuiaNota($oContribuinte);
    $uDataUltimaNota       = Contribuinte_Model_Nota::getUltimaNotaEmitidaByContribuinte($aListaIdContribuinte);
    $dia                   = new DateTime();

    if ($oUltimaGuia != NULL) {

      if (($oUltimaGuia->getMesComp() + 1) > 12) {
        $iMes = 1;
      } else {
        $iMes = $oUltimaGuia->getMesComp();
      }

      $uDataUltimoDiaCompetencia = new Zend_Date("01/{$iMes}/{$oUltimaGuia->getAnoComp()}");
      $uDataUltimoDiaCompetencia->sub(1, Zend_date::DAY);

      $diff    = $dia->diff(new DateTime($uDataUltimoDiaCompetencia->get('YYYY-MM-dd')), TRUE);
      $maxGuia = ($diff->d < $max) ? $diff->d : $max;
    }

    if ($uDataUltimaNota != NULL) {

      $diff    = $dia->diff(new DateTime($uDataUltimaNota), TRUE);
      $maxNota = ($diff->d < $max) ? $diff->d : $max;
    }

    if (($maxNota - $maxGuia) < $maxGuia) {
      $max = $maxGuia - 1;
    } else if ($maxNota > 0) {
      $max = $maxNota;
    } else {
      $max = 0;
    }

    $dia   = $dia->sub(new DateInterval('P' . $max . 'D'));
    $oForm = new Contribuinte_Form_RpsEmissao($sCodigoVerificacao, $dia, '/contribuinte/rps/index', TRUE);

    if ($oContribuinte !== NULL) {

      $oParametros = Contribuinte_Model_ParametroContribuinte::getById($iIdContribuinte);
      $oForm->preencheParametros($oParametros);
    }

    return $oForm;
  }
}