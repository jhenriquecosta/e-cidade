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
 * Classe responsável pela manipulação dos dados da NFS-e
 *
 * @package Contribuinte/Controllers
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */

class Contribuinte_NfseController extends Contribuinte_Lib_Controller_AbstractController {

  /**
   * Tipo de Nota
   */
  const TIPO_NOTA = NULL;

  /**
   * Cadastro de emissão da NFS-e
   */
  public function indexAction() {

    $oContribuinte         = $this->_session->contribuinte;
    $oParametrosPrefeitura = Administrativo_Model_ParametroPrefeitura::getAll();
    $oForm                 = new Contribuinte_Form_NfseEmissao();

    // Lista de paises
    $aPaises = Default_Model_Cadenderpais::getAll();

    // Verifica código ibge do municipio de origem
    $iCodigoIbge = (isset($oParametrosPrefeitura[0])) ? $oParametrosPrefeitura[0]->getIbge() : NULL;

    $sUfEstado = (isset($oParametrosPrefeitura[0])) ? $oParametrosPrefeitura[0]->getUf() : NULL;

    // Verifica se retem imposto
    $bReterImposto = (isset($oParametrosPrefeitura[0])) ? $oParametrosPrefeitura[0]->getReterPessoaFisica() : FALSE;

    // Popula o campo com as datas de emissão
    $aDiasRetroativosEmissao = $this->getDiasRetroativosEmissao($oContribuinte);

    if ($oContribuinte !== NULL) {

      $oParametros = Contribuinte_Model_ParametroContribuinte::getById($oContribuinte->getIdUsuarioContribuinte());

      if ($oParametros instanceof Contribuinte_Model_ParametroContribuinte) {
        $oForm->preencheParametrosContribuinte($oParametros);
      }

      $oForm->setRegimeTributario($oContribuinte->getRegimeTributario());
    }

      // Verifica se existe algum bloqueio
      $oBloqueio = Administrativo_Model_RequisicaoAidof::verificaBloqueio($oContribuinte, Contribuinte_Model_Nota::GRUPO_NOTA_NFSE);

    // Verifica se o parametro de requisições nfse está ativado
    if (Administrativo_Model_RequisicaoAidof::permiteRequisicaoAidofNfse() && $oBloqueio != FALSE) {
      if ($oBloqueio->bloqueado_msg) {
        $this->view->bloqueado_msg = $this->translate->_($oBloqueio->bloqueado_msg);
        return FALSE;
      } else if (!empty($oBloqueio->message)) {
        $this->view->messages[] = array('warning' => $this->translate->_($oBloqueio->message));
      }
    }

    $this->view->bReterImposto           = $bReterImposto;
    $this->view->aDiasRetroativosEmissao = $aDiasRetroativosEmissao;
    $this->view->sUfEstado               = $sUfEstado;
    $this->view->iCodigoIbge             = $iCodigoIbge;
    $this->view->aPaises                 = $aPaises;

    // Aplica regra de Regime Tributario MEI e Sociedade de Profissionais
    $oForm->aplicaRegrasArbritarias($oContribuinte);

    $this->view->oForm                   = $oForm;
  }

  /**
   * Emite a NFS-e
   * @return bool
   */
  public function emitirAction() {

    parent::noLayout();

    $oContribuinte          = $this->_session->contribuinte;
    $aDados                 = $this->getRequest()->getParams();
    $oForm                  = new Contribuinte_Form_NfseEmissao();
    $aRetornoJson['status'] = FALSE;

    try {

      $aServicos = Contribuinte_Model_Servico::getByIm($oContribuinte->getInscricaoMunicipal());
      $oForm->setListaServicos($aServicos);

      // Verifica se o contribuinte é prestador de serviços
      if ($aServicos == NULL || empty($aServicos)) {
        throw new Exception('Empresa não prestadora de serviço.');
      }

      // Verifica se o contribuinte é emissor de NFSe
      if ($oContribuinte->getTipoEmissao() != Contribuinte_Model_ContribuinteAbstract::TIPO_EMISSAO_NOTA) {
        throw new Exception('Empresa não emissora de NFS-E.');
      }

      $oForm->populate($aDados);

      if ($this->getRequest()->isPost()) {

        // Verifica Cooperativa
        if(isset($aDados['t_cooperado']) && $aDados['t_cooperado'] == 'true'){

          if(Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_COOPERATIVA != $oContribuinte->getRegimeTributario()){
            throw new Exception('Impossivel emitir NFS-e para Associado!');
          }

          if(Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_COOPERATIVA == $oContribuinte->getRegimeTributario() &&
             isset($aDados['natureza_operacao']) && $aDados['natureza_operacao'] == 2
          ){
            throw new Exception('Impossivel tributar fora do município ao emitir NFS-e para Associado!');
          }
        }

        // Verifica se é tomador pode reter imposto
        if (!$this->podeReterPessoaFisica($aDados)) {
          throw new Exception('Permitido reter apenas para Pessoa Jurídica.');
        }

        // Limpa espaços no email
        $aDados['t_email'] = trim($aDados['t_email']);

        // Validadores
        $oValidaData = new Zend_Validate_Date(array('format' => 'yyyy-MM-dd'));

        // Bloqueia a emissão se possuir declarações sem movimento
        if (isset($aDados['dt_nota']) && $oValidaData->isValid($aDados['dt_nota'])) {

          $oDataSimples            = new DateTime($aDados['dt_nota']);
          $aDeclaracaoSemMovimento = Contribuinte_Model_Competencia::getDeclaracaoSemMovimentoPorContribuintes(
            $oContribuinte->getInscricaoMunicipal(),
            $oDataSimples->format('Y'),
            $oDataSimples->format('m')
          );

          if (count($aDeclaracaoSemMovimento) > 0) {

            $sMensagemErro  = 'Não é possível emitir um documento nesta data, pois a competência foi declarada como ';
            $sMensagemErro .= 'sem movimento.<br>Entre em contato com o setor de arrecadação da prefeitura.';

            throw new Exception($sMensagemErro);
          }
        }

        $s_vl_servicos = (float) str_replace(',', '.', $aDados['s_vl_servicos']);

        if (empty($s_vl_servicos) || $s_vl_servicos <= 0) {

          $sMensagemErro  = 'Valor do Serviço não pode ser zero!';

          throw new Exception($sMensagemErro);
        }

        if (isset($aDados['nota_substituta']) && $aDados['nota_substituta'] && empty($aDados['nota_substituida'])) {

          $sMensagemErro  = 'É necessário o número da nota a substituir!';

          throw new Exception($sMensagemErro);
        }

        // Tomador / serviço foara do pais
        if (isset($aDados['s_dados_fora_incide']) && $aDados['s_dados_fora_incide'] == 0 &&
            $aDados['t_cod_pais'] == '01058' &&
            $aDados['s_dados_cod_pais'] == '01058') {

          $sMensagemErro  = 'Não incide tributação: é necessário Tomador ou que o efeito do serviço seja fora do Brasil!';
          throw new Exception($sMensagemErro);

        } else if (!isset($aDados['s_dados_fora_incide'])) {
          $aDados['s_dados_fora_incide'] = TRUE;
        }

        if ($oForm->valid($aDados)) {

          // Remova chaves inválidas
          unset($aDados['enviar'], $aDados['action'], $aDados['controller'], $aDados['module'], $aDados['estado']);

          // filtro para retornar somente numeros
          $aFilterDigits = new Zend_Filter_Digits();

          $aDados['p_im']       = $oContribuinte->getInscricaoMunicipal();
          $aDados['t_cnpjcpf']  = $aFilterDigits->filter($aDados['t_cnpjcpf']);
          $aDados['t_cep']      = $aFilterDigits->filter($aDados['t_cep']);
          $aDados['t_telefone'] = $aFilterDigits->filter($aDados['t_telefone']);
          $aDados['tipo_nota']  = self::TIPO_NOTA;

          // Recalcula valores para garantir a integridade dos cálculos
          $aServico = Contribuinte_Model_Servico::getByCodServico($aDados['s_dados_cod_tributacao']);
          $oServico = reset($aServico);

          /* caso a atividade sejá retida no municipio de acordo com a legislação
           * envia para o teste de guia um parametro = true
           */
          $aDados['s_tributacao_municipio'] = $oServico->attr('tributacao_municipio');

          $aDados['deducao_editavel'] = $oServico->attr('deducao') == 't';
          $aDados['dt_nota']          = Contribuinte_Model_Nota::getDateTime($aDados['dt_nota']);
          $aDados['id_contribuinte']  = $oContribuinte->getIdUsuarioContribuinte();
          $aDados['id_usuario']       = $this->usuarioLogado->getId();

          if ($oForm->getElement('nota_substituta')->isChecked()) {

            $aAtributosPesquisaNotaSubstituida = array(
              'id_contribuinte' => $oContribuinte->getIdUsuarioContribuinte(),
              'nota'            => $aDados['nota_substituida'],
              'cancelada'       => FALSE
            );

            $oNotaSubstituida = Contribuinte_Model_Nota::getByAttributes($aAtributosPesquisaNotaSubstituida);
            $oNotaSubstituida = reset($oNotaSubstituida);

            /**
             * Caso exista a nota a ser substituida, verifica:
             *  - Se já não possue nota substituta
             *  - Se não possui guia emitida
             */
            if ($oNotaSubstituida instanceof Contribuinte_Model_Nota &&
              !$oNotaSubstituida->getIdNotaSubstituta() &&
              !Contribuinte_Model_Guia::existeGuia($oContribuinte,
                                                   $oNotaSubstituida->getMes_comp(),
                                                   $oNotaSubstituida->getAno_comp(),
                                                   Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE)
            ) {

              // Seta os dados da nota
              $aDados['idNotaSubstituida'] = $oNotaSubstituida->getId();
            } else {

              $sMensagemErro  = '<b>Erro ao substituir a nota, verifique se:</b><br>';
              $sMensagemErro .= '- A nota informada já foi emitida no sistema.<br>';
              $sMensagemErro .= '- A nota informada não foi substituida.<br>';
              $sMensagemErro .= '- A nota informada não possui guia emitida.<br>';
              $sMensagemErro .= '- A nota informada não foi emitida por outro usuário.';

              throw new Exception($sMensagemErro);
            }

            unset($aDados['nota_substituta'], $aDados['nota_substituida']);
          }

          $iQuantidadeRequisicaoPendente = Contribuinte_Model_NotaAidof::getQuantidadeNotasPendentes($oContribuinte, NULL, Contribuinte_Model_Nota::GRUPO_NOTA_NFSE);

          $aDados['requisicao_aidof'] = FALSE;

          // Verifica se o parametro de requisições nfse está ativado
          if ($iQuantidadeRequisicaoPendente > 0) {
            $aDados['requisicao_aidof'] = TRUE;
          } else if (Administrativo_Model_RequisicaoAidof::permiteRequisicaoAidofNfse()) {

            $sMensagemErro = 'Limite de notas para emissão atingido, faça uma nova requisição.';
            throw new Exception($sMensagemErro);

          }

          // Persiste os dados na base de dados
          $oNota = new Contribuinte_Model_Nota();

          $oNota->setIrregularidadeInterface(new Contribuinte_Model_NotaIrregularidadeManual());

          if ($oNota->persist($aDados)) {

            // Se for nota substituta
            if (isset($oNotaSubstituida) && $oNotaSubstituida instanceof Contribuinte_Model_Nota) {

              $sMensagemCancelamento = "Substituida pela Nota nº {$oNota->getNota()}";

              $oNotaSubstituida->setIdNotaSubstituta($oNota->getId());
              $oNotaSubstituida->setCancelada(TRUE);
              $oNotaSubstituida->setCancelamentoJustificativa($this->translate->_($sMensagemCancelamento));
              $oNotaSubstituida->setEmite_guia(FALSE);
              $oNotaSubstituida->persist($oNotaSubstituida->getEntity());
            }
          } else {
            throw new Exception('Não foi possível emitir a nota!');
          }

          // Envia email para o tomador
          $oValidaEmail = new Zend_Validate_EmailAddress();

          if ($oValidaEmail->isValid($aDados['t_email'])) {

            $iInscricaoMunicipal = $aDados['p_im'];
            $oContribuinte       = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

            // Informações da view
            $this->view->nota          = $oNota;
            $this->view->tomadorNome   = $aDados['t_razao_social'];
            $this->view->prestadorNome = $oContribuinte->getNome('nome');
            $this->view->prestadorCnpj = DBSeller_Helper_Number_Format::maskCPF_CNPJ($oContribuinte->getCgcCpf());
            $this->view->nfseNumero    = $oNota->getNota();
            $this->view->nfseUrl       = $oNota->getUrlVerificacaoNota();

            // Renderiza o email com o texto diferente para notas substitutas
            if (isset($oNotaSubstituida) && $oNotaSubstituida instanceof Contribuinte_Model_Nota) {

              // Informações da View
              $this->view->sUrlNotaSubstituida = $oNotaSubstituida->getUrlVerificacaoNota();
              $this->view->oNotaSubstituida    = $oNotaSubstituida;
              $sMensagemEmail                  = $this->view->render('nfse/email-emissao-substituida.phtml');
            } else {
              $sMensagemEmail = $this->view->render('nfse/email-emissao.phtml');
            }

            $sArquivoPdfNfse = $this->getNotaImpressao($oNota->getCod_verificacao(), TRUE, TRUE);

            // Envia Email
            DBSeller_Helper_Mail_Mail::sendAttachment($aDados['t_email'],
                                                      "Nota Fiscal Eletrônica nº {$oNota->getNota()}",
                                                      $sMensagemEmail,
                                                      $sArquivoPdfNfse);
          }

          $oBaseUrlHelper             = new Zend_View_Helper_BaseUrl();
          $aRetornoJson['status']     = TRUE;
          $aRetornoJson['messages'][] = array('success' => $this->translate->_('Nota emitida com sucesso.'));
          $aRetornoJson['url']        = $oBaseUrlHelper->baseUrl("/contribuinte/nfse/dados-nota/id/{$oNota->getId()}");
        } else {
          throw new Exception('Preencha os dados corretamente!');
        }
      } else {
        throw new Exception('Verifique os dados enviados!');
      }
    } catch (Exception $oError) {

      $aRetornoJson['status']     = FALSE;
      $aRetornoJson['messages'][] = array('error' => $this->translate->_($oError->getMessage()));
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Lista das NFSE
   */
  public function consultaAction() {

    // Verifica se foi adicionado o parametro de tributação miníma
    $oContribuinte = $this->_session->contribuinte;
    /*if (!Contribuinte_Model_ParametroContribuinteTributos::existeParametro($oContribuinte, date('Y'))) {

      $this->_helper->getHelper('FlashMessenger')->addMessage(
        array('alert' => $this->translate->_(Contribuinte_Model_ParametroContribuinteTributos::retonaMensagemAvisoSemParametro()))
      );

      $this->_redirector->gotoSimple('contribuinte', 'parametro', 'contribuinte');
    }*/

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    $oFormConsulta  = new Contribuinte_Form_NotaConsulta();
    $oFormConsulta->setAction($oBaseUrlHelper->baseUrl('/contribuinte/nfse/consulta-processar'));
    $oFormConsulta->populate($this->getRequest()->getParams());

    $this->view->oFormConsulta = $oFormConsulta;
  }

  /**
   * Processa a pesquisa e retorna o html com o resultado da consulta [Ajax]
   */
  public function consultaProcessarAction() {

    parent::noTemplate();

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    $oFormConsulta  = new Contribuinte_Form_NotaConsulta();
    $oFormConsulta->setAction($oBaseUrlHelper->baseUrl('/contribuinte/nfse/consulta-processar'));
    $oFormConsulta->populate($this->getRequest()->getParams());

    $sCodigosContribuintes = NULL;
    $oContribuinte         = $this->_session->contribuinte;
    $aParametrosBusca      = $oFormConsulta->getValues();
    $oPaginatorAdapter     = new DBSeller_Controller_Paginator(Contribuinte_Model_Nota::getQuery(),
                                                               'Contribuinte_Model_Nota',
                                                               'Contribuinte\Nota');

    foreach ($oContribuinte->getContribuintes() as $iIdContribuinte) {

      if ($sCodigosContribuintes == NULL) {
        $sCodigosContribuintes .= $iIdContribuinte;
      } else {
        $sCodigosContribuintes .= ',' . $iIdContribuinte;
      }
    }

    $oPaginatorAdapter->where("e.id_contribuinte in ({$sCodigosContribuintes}) ");

    if (!empty($aParametrosBusca['numero_nota'])) {
      $oPaginatorAdapter->andWhere("e.nota = '{$aParametrosBusca['numero_nota']}' ");
    }

    if (!empty($aParametrosBusca['retido'])) {
      $oPaginatorAdapter->andWhere('e.s_dados_iss_retido = 2 ');
    }

    if (!empty($aParametrosBusca['cpfcnpj'])) {
      $oPaginatorAdapter->andWhere("e.t_cnpjcpf = '{$aParametrosBusca['cpfcnpj']}'");
    }

    if (!empty($aParametrosBusca['im'])) {
      $oPaginatorAdapter->andWhere("e.im = '{$aParametrosBusca['im']}'");
    }

    if (!empty($aParametrosBusca['s_razao_social'])) {
      $oPaginatorAdapter->andWhere("(lower(e.t_razao_social) like lower('%{$aParametrosBusca['s_razao_social']}%') OR
                                   lower(e.t_nome_fantasia) like lower('%{$aParametrosBusca['s_razao_social']}%'))");
    }

    if (!empty($aParametrosBusca['data_emissao_inicial']) && !empty($aParametrosBusca['data_emissao_final'])) {

      $oPaginatorAdapter->andWhere(
        "e.dt_nota BETWEEN '{$aParametrosBusca['data_emissao_inicial']}' AND
                        '{$aParametrosBusca['data_emissao_final']}'"
      );
    } else {

      if (!empty($aParametrosBusca['data_emissao_inicial'])) {
        $oPaginatorAdapter->andWhere("e.dt_nota >= '{$aParametrosBusca['data_emissao_inicial']}' ");
      } else if (!empty($aParametrosBusca['data_emissao_final'])) {
        $oPaginatorAdapter->andWhere("e.dt_nota <= '{$aParametrosBusca['data_emissao_final']}' ");
      }
    }

    if ($aParametrosBusca['ordenacao_campo'] == 'competencia') {

      $oPaginatorAdapter->orderBy('e.ano_comp', $aParametrosBusca['ordenacao_direcao']);
      $oPaginatorAdapter->orderBy('e.mes_comp', $aParametrosBusca['ordenacao_direcao']);
    } else {
      $oPaginatorAdapter->orderBy("e.{$aParametrosBusca['ordenacao_campo']}", $aParametrosBusca['ordenacao_direcao']);
    }

    $oResultado = new Zend_Paginator($oPaginatorAdapter);

    $oResultado->setItemCountPerPage(10);
    $oResultado->setCurrentPageNumber($this->_request->getParam('page'));

    $this->view->oFormConsulta = $oFormConsulta;
    $this->view->notas         = $oResultado;

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
   * Cancela NFSE
   */
  public function cancelarAction() {

    parent::noTemplate();

    $aDados          = $this->getRequest()->getParams();
    $oNota           = Contribuinte_Model_Nota::getById($aDados['id']);

    $oValidadorEmail = new Zend_Validate_EmailAddress();
    $oForm           = new Contribuinte_Form_NotaCancelar();
    $oForm->getElement('id')->setValue($aDados['id']);

    if ($oNota instanceof Contribuinte_Model_Nota && $oValidadorEmail->isValid($oNota->getT_email())) {
      $oForm->getElement('email')->setValue($oNota->getT_email());
    }

    $this->view->nota = $aDados['numero'];
    $this->view->form = $oForm;
  }

  /**
   * Execucao do cancelamento de NFSE via ajax
   */
  public function cancelarPostAction() {

    $aDados = $this->getRequest()->getParams();
    $oForm  = new Contribuinte_Form_NotaCancelar();
    $oForm->populate($aDados);

    if (!$oForm->isValid($aDados)) {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = 'Preencha os dados corretamente.';
    } else {

      try {

        $oContribuinte     = $this->_session->contribuinte;
        $oPrefeitura       = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
        $aLoginUsuario     = Zend_Auth::getInstance()->getIdentity();
        $oUsuario          = Administrativo_Model_Usuario::getByAttribute('login', $aLoginUsuario['login']);
        $oDataCancelamento = new DateTime();
        $oNota             = Contribuinte_Model_Nota::getById($aDados['id']);
        $bExisteGuia       = Contribuinte_Model_Guia::existeGuia($oContribuinte,
                                                                 $oNota->getMes_comp(),
                                                                 $oNota->getAno_comp(),
                                                                 Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE);

        if ($oNota->podeCancelar($oContribuinte) && !$bExisteGuia) {

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

          //Obtem a data da ultima nota
          $uDataUltimaNota = Contribuinte_Model_Nota::getUltimaNotaEmitidaByContribuinte($oContribuinte->getContribuintes());
          $oDataUltimaNota = new DateTime($uDataUltimaNota);

          // Calcula a diferentça entre a data atual e a data da nota a ser cancelada
          $oDataCorrente = new DateTime();
          $oDiff = $oDataCorrente->diff(new DateTime($oNota->getDt_nota()->format("Y-m-d")), TRUE);

          /*Faz a solicitação de cancelamento se o parametro estiver habilitado ou
          se a nota estiver dentro da regra de retroatividade podendo ser cancelada*/
          if (($oNota->getAno_comp() < $oDataUltimaNota->format('Y')
              || ($oNota->getAno_comp() == $oDataUltimaNota->format('Y') && $oNota->getMes_comp() < $oDataUltimaNota->format('m')))
              || $oPrefeitura->getSolicitaCancelamento()
              || $oDiff->days > $oPrefeitura->getNotaRetroativa()) {

            $oSolicitacaoCancelamento = new Contribuinte_Model_SolicitacaoCancelamento();
            $oSolicitacaoCancelamento->solicitar($oNota->getEntity(), $aDados, $oUsuario->getEntity());

            $sJustificativa   = $oSolicitacaoCancelamento->getJustificativa();
            $sRetornoEmail    = $this->enviarEmailCancelamento($oNota, $aDados, $aEmailBCC, TRUE, $sJustificativa);
            $sMensagemRetorno = "Cancelamento solicitado com sucesso!";
          } else {

            $oCancelamentoNota = new Contribuinte_Model_CancelamentoNota();
            $oCancelamentoNota->setUsuarioCancelamento($oUsuario);
            $oCancelamentoNota->setNotaCancelada($oNota);
            $oCancelamentoNota->setJustificativa($aDados['cancelamento_justificativa']);
            $oCancelamentoNota->setMotivoCancelmento($aDados['cancelamento_motivo']);
            $oCancelamentoNota->setDataHora($oDataCancelamento);
            $oCancelamentoNota->salvar();

            $sRetornoEmail    = $this->enviarEmailCancelamento($oNota, $aDados, $aEmailBCC, FALSE);
            $sMensagemRetorno = "Cancelamento efetuado com sucesso!";
          }

          $sMensagemRetorno        = (is_null($sRetornoEmail)) ? $sMensagemRetorno : $sRetornoEmail;
          $aRetornoJson['status']  = TRUE;
          $aRetornoJson['success'] = $sMensagemRetorno;
        } else {
          throw new Exception("Esta nota não pode mais ser cancelada!");
        }
      } catch (Exception $oErro) {

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $oErro->getMessage();
      }
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * View para reenvio de email (Modal)
   */
  public function emailEnviarAction() {

    parent::noTemplate();

    $aDados = $this->getRequest()->getParams();
    $oForm  = new Contribuinte_Form_NotaEmail();
    $oForm->populate($aDados);

    $this->view->form = $oForm;
  }

  /**
   * Execucao do reenvio de email via ajax
   */
  public function emailEnviarPostAction() {

    $aDados = $this->getRequest()->getParams();
    $oForm  = new Contribuinte_Form_NotaEmail();
    $oForm->populate($aDados);

    if (!$oForm->isValid($aDados)) {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = 'Preencha os dados corretamente.';
    } else {

      try {

        $oNota               = Contribuinte_Model_Nota::getById($aDados['id_nfse']);
        $iInscricaoMunicipal = $oNota->getP_im();
        $oContribuinte       = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);
        $aArquivoPdfNfse     = $this->getNotaImpressao($oNota->getCod_verificacao(), TRUE, TRUE);

        // Informações da View
        $this->view->nota          = $oNota;
        $this->view->tomadorNome   = $oNota->getT_razao_social();
        $this->view->prestadorNome = $oContribuinte->getNome();
        $this->view->prestadorCnpj = DBSeller_Helper_Number_Format::maskCPF_CNPJ($oContribuinte->getCgcCpf());
        $this->view->nfseNumero    = $oNota->getNota();
        $this->view->nfseUrl       = $oNota->getUrlVerificacaoNota();

        // Se for nota substituda exibe o texto do email diferente
        if ($oNota->getIdNotaSubstituida()) {

          $oNotaSubstituida = Contribuinte_Model_Nota::getById($oNota->getIdNotaSubstituida());

          // Informações da view
          $this->view->sUrlNotaSubstituida = $oNotaSubstituida->getUrlVerificacaoNota();
          $this->view->oNotaSubstituida    = $oNotaSubstituida;
          $sMensagemEmail                  = $this->view->render('nfse/email-emissao-substituida.phtml');
        } else {
          $sMensagemEmail = $this->view->render('nfse/email-emissao.phtml');
        }

        // Envia Email
        $lEmail = DBSeller_Helper_Mail_Mail::sendAttachment($aDados['email'],
                                                            "Nota Fiscal Eletrônica nº {$oNota->getNota()}",
                                                            $sMensagemEmail,
                                                            $aArquivoPdfNfse);

        if ($lEmail) {

          $aRetornoJson['status']  = TRUE;
          $aRetornoJson['success'] = 'Email enviado com sucesso';
        } else {
          throw new Exception('Erro ao enviar o email');
        }

        // Apaga o arquivo temporario gerado para envio do email
        unlink($aArquivoPdfNfse['location']);
      } catch (Exception $oErro) {

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $oErro->getMessage();
      }
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Verifica se o contribuinte é optante pelo simples na data especificada
   * Utiliza o mesmo método utilizado no DMS
   *
   * @see Contribuinte_Lib_Controller_AbstractController::verificarContribuinteOptanteSimplesAction()
   * @throws Exception
   */
  public function verificarContribuinteOptanteSimplesAction() {

    try {

      $sData = $this->getRequest()->getParam('data');
      $oContribuinte = $this->_session->contribuinte;

      if (!$sData) {
        throw new Exception('Informe a data para verificar!');
      }

      $aRetorno = Contribuinte_Model_Contribuinte::getInformacaoContribuinteAtual($oContribuinte, 'all', $sData);

      echo $this->getHelper('json')->sendJson($aRetorno);
    } catch (Exception $oError) {

      $aRetorno['erro'] = TRUE;
      $aRetorno['mensagem'] = $oError->getMessage();

      echo $this->getHelper('json')->sendJson($aRetorno);
    }
  }

  /**
   * Detalhes da NFSE
   */
  public function notaImpressaAction() {

    parent::noLayout();

    $sCodigoVerificacao = $this->getRequest()->getParam('codigo_verificacao');
    $lImprimir          = $this->getRequest()->getParam('print', FALSE);

    if ($lImprimir) {
      echo $this->getNotaImpressao($sCodigoVerificacao, FALSE);
    } else {
      $this->getNotaImpressao($sCodigoVerificacao, TRUE);
    }
  }

  /**
   * Busca os dados do servico [Json]
   */
  public function servicoAction() {

    $iIdServico = $this->getParam('servico');

    try {

      $aServicos = Contribuinte_Model_Servico::getByIm($this->_session->contribuinte->getInscricaoMunicipal(), FALSE);
      $aDados    = array();

      foreach ($aServicos as $oServico) {

        if ($oServico->attr('cod_atividade') == $iIdServico) {

          $aDados = array(
            'item_servico'          => $oServico->attr('desc_item_servico'),
            'cod_item_servico'      => $oServico->attr('cod_item_servico'),
            'estrut_cnae'           => $oServico->attr('estrut_cnae'),
            'desc_cnae'             => $oServico->attr('desc_cnae'),
            'deducao'               => $oServico->attr('deducao'),
            'aliq'                  => $oServico->attr('aliq'),
            'tributacao_municipio'  => $oServico->attr('tributacao_municipio'),
            'tributacao_nao_incide' => $oServico->attr('tributacao_nao_incide')
          );
          break;
        }
      }

      echo $this->getHelper('json')->sendJson($aDados);
    } catch (Exception $oError) {

      $aRetorno['erro'] = TRUE;
      if ($oError->getCode() == Global_Lib_Model_WebService::CODIGO_ERRO_CONSULTA_WEBSERVICE) {

        $aRetorno['mensagem'] = "E-cidade temporariamente insdisponível. Emissão bloqueada!";
        $aRetorno['servico']  = $iIdServico;
      } else {
        $aRetorno['mensagem'] = $oError->getMessage();
      }

      echo $this->getHelper('json')->sendJson($aRetorno);
    }
  }

  /**
   * Dados da NFSE Emitida
   */
  public function dadosNotaAction() {

    $iCodigoNota          = $this->getRequest()->getParam('id');
    $oDadosNota           = Contribuinte_Model_Nota::getByAttribute('id', $iCodigoNota);
    $oDadosNota           = $oDadosNota->getEntity();

    $oFormDadoNotaEmitida = new Contribuinte_Form_DadosNota($oDadosNota->getCod_verificacao());

    // RPS
    if ($oDadosNota->getN_rps()) {

      $aTiposDocumento      = Contribuinte_Model_Nota::getTiposNota(Contribuinte_Model_Nota::GRUPO_NOTA_RPS);
      $this->view->rps      = TRUE;
      $this->view->sTipoRps = $aTiposDocumento[$oDadosNota->getTipo_nota()];

      $oFormDadoNotaEmitida->nova->setAttrib('url', $this->view->baseUrl('/contribuinte/rps-novo/index'));
    }

    $this->view->oForm        = $oFormDadoNotaEmitida;
    $this->view->oDadosNota   = $oDadosNota;
    $this->view->notaImpressa = self::getNotaImpressao($oDadosNota->getCod_verificacao(), FALSE, FALSE);
  }

  /**
   * Responsável por atualizar a lista de atividades de acordo com as atividades finalizadas ou não
   * para a não prestação do serviço
   */
  public function defineListaAtividadesAction() {

    try {

      $sData              = $this->getRequest()->getParam('data_emissao');
      $oContribuinte      = $this->_session->contribuinte;
      $aServicos          = Contribuinte_Model_Servico::getByIm($oContribuinte->getInscricaoMunicipal(), true);
      $aListaAtividades   = array();

      foreach ($aServicos as $oServico) {

        $DataFim     = new DateTime($oServico->attr('dt_fim'));
        $DataEmissao = new DateTime($sData);

        if ($DataEmissao->getTimestamp() < $DataFim->getTimestamp()) {
          $aListaAtividades[$oServico->attr('cod_atividade')] = DBSeller_Helper_String_Format::wordsCap($oServico->attr('atividade'));
        }
      }

      echo $this->getHelper('json')->sendJson($aListaAtividades);

    } catch (Exception $oError) {

      $aRetorno['erro']     = TRUE;
      $aRetorno['mensagem'] = $oError->getMessage();

      echo $this->getHelper('json')->sendJson($aRetorno);
    }
  }

  /**
   * Busca os dados do servico [Json]
   */
  public function getServicoAction() {

    $iIdServico = $this->getParam('servico');
    $aDataNota = explode('-', $this->getParam('exercicio'));

    try {

      $aServicos = Contribuinte_Model_Servico::getByIm($this->_session->contribuinte->getInscricaoMunicipal(), FALSE);
      $aDados    = array();

      foreach ($aServicos as $oServico) {

        if ($oServico->attr('cod_atividade') == $iIdServico && $oServico->attr('exercicio') == $aDataNota[0]) {

          $aDados = array(
            'item_servico'          => $oServico->attr('desc_item_servico'),
            'cod_item_servico'      => $oServico->attr('cod_item_servico'),
            'estrut_cnae'           => $oServico->attr('estrut_cnae'),
            'desc_cnae'             => $oServico->attr('desc_cnae'),
            'deducao'               => $oServico->attr('deducao'),
            'aliq'                  => $oServico->attr('aliq'),
            'tributacao_municipio'  => $oServico->attr('tributacao_municipio'),
            'tributacao_fixada'     => $oServico->attr('tributacao_fixada'),
            'tributacao_nao_incide' => $oServico->attr('tributacao_nao_incide')
          );
          break;
        }
      }

      echo $this->getHelper('json')->sendJson($aDados);
    } catch (Exception $oError) {

      $aRetorno['erro'] = TRUE;
      if ($oError->getCode() == Global_Lib_Model_WebService::CODIGO_ERRO_CONSULTA_WEBSERVICE) {

        $aRetorno['mensagem'] = "E-cidade temporariamente insdisponível. Emissão bloqueada!";
        $aRetorno['servico']  = $iIdServico;
      } else {
        $aRetorno['mensagem'] = $oError->getMessage();
      }

      echo $this->getHelper('json')->sendJson($aRetorno);
    }
  }

  /**
   * Método responsável pelo envio de email no cancelamento ou na solicitação do mesmo
   * @param  Contribuinte_Model_Nota $oNota
   * @param  array                   $aDados
   * @param  array                   $aEmailBCC
   * @param  boolean                 $lSolicitacao
   * @param  string                  $sJustificativa
   * @return string|null
   * @throws Exception
   */
  private function enviarEmailCancelamento($oNota, $aDados, $aEmailBCC, $lSolicitacao = FALSE, $sJustificativa = null) {

    try {

      $oValidadorEmail  = new Zend_Validate_EmailAddress();
      $emailTO          = $oNota->getT_email();
      $sMensagemRetorno = NULL;

      if ($oValidadorEmail->isValid($emailTO)
        || (!empty($aDados['email']) && $oValidadorEmail->isValid($aDados['email']))
        || (count($aEmailBCC) > 0)) {


        $iInscricaoMunicipal = $oNota->getP_im();
        $oContribuinte       = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

        $this->view->justificativa = $sJustificativa;
        $this->view->solicitacao   = $lSolicitacao;
        $this->view->nota          = $oNota;
        $this->view->tomadorNome   = $oNota->getT_razao_social();
        $this->view->prestadorNome = $oContribuinte->getNome();
        $this->view->prestadorCnpj = DBSeller_Helper_Number_Format::maskCPF_CNPJ($oContribuinte->getCgcCpf());
        $this->view->nfseNumero    = $oNota->getNota();
        $this->view->nfseUrl       = $oNota->getUrlVerificacaoNota();
        $this->mensagem            = $this->view->render('nfse/email-emissao.phtml');

        $aArquivoPdfNfse = $this->getNotaImpressao($oNota->getCod_verificacao(), TRUE, TRUE);

        // Verifica se foi mudado o e-mail do Tomador para enviar uma cópia oculta do cancelamento
        if (!empty($aDados['email'])
          && $aDados['email'] != $oNota->getT_email()
          && $oValidadorEmail->isValid($aDados['email'])) {

          $emailTO  = $aDados['email'];

          if ($oValidadorEmail->isValid($oNota->getT_email())) {
            $aEmailBCC[] = $oNota->getT_email();
          }

          $sMensagemRetorno = "Cancelamento efetuado com sucesso.<br>Email foi enviado para {$emailTO}";
        }

        /*Caso não haja email cadastrado na nota e nem email informado no cancelamento,
          ou se for uma solicitação de cancelamento, o primeiro email de fiscal é colocado
          como destinatário principal para que seja possível o envio*/
        if (is_null($emailTO) || empty($emailTO) || $lSolicitacao) {
          $emailTO = $aEmailBCC[0];
          unset($aEmailBCC[0]);

          if ($lSolicitacao) {
            $sMensagemRetorno = "Cancelamento solicitado com sucesso.<br>Email foi enviado para {$emailTO}";
          }
        }

        // Envia Email
        DBSeller_Helper_Mail_Mail::sendAttachment($emailTO,
                                                  "Nota Fiscal Eletrônica nº {$oNota->getNota()}",
                                                  $this->mensagem,
                                                  $aArquivoPdfNfse,
                                                  $aEmailBCC);

        // Apaga o arquivo temporario gerado para envio do email
        unlink($aArquivoPdfNfse['location']);

        return $sMensagemRetorno;
      }
    } catch (Exception $oError) {
      throw new Exception($oError->getMessage());
    }
  }

  /**
   * Gera o PDF da NFSE
   *
   * @param string  $sCodigoVerificacao
   * @param boolean $lPdf
   * @param boolean $lEmail
   * @return string
   */
  private function getNotaImpressao($sCodigoVerificacao, $lPdf = TRUE, $lEmail = FALSE) {

    // Flag para retirar as tags body e css
    if (!$lPdf) {
      $this->view->lHtmlEmbutido = TRUE;
    }

    $oNota                  = Contribuinte_Model_Nota::getByAttribute('cod_verificacao', $sCodigoVerificacao);
    $oPrefeitura            = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    $this->view->aDadosNota = Contribuinte_Model_Nota::getDadosEmissao($sCodigoVerificacao, $oNota, $oPrefeitura);

    $sHtml         = "pdf/nota_modelo_{$oPrefeitura->getModeloImpressaoNfse()}.phtml";
    $sHtml         = $this->view->render($sHtml);
    $sNomeArquivo  = "nfse_{$oNota->getNota()}";
    $sLocalArquivo = APPLICATION_PATH . "/../public/tmp/{$sNomeArquivo}";

    // Verifica se gera o PDF ou retorna apenas o HTML
    if ($lPdf) {

      // Verifica se deve retornar os parametros do documento para envio por email
      if ($lEmail) {

        DBSeller_Helper_Pdf_Pdf::renderPdf($sHtml,
                                           $sLocalArquivo,
                                           array('format' => 'A4', 'output' => 'F'));

        return array(
          'location' => "{$sLocalArquivo}.pdf",
          'filename' => "{$sNomeArquivo}.pdf",
          'type'     => 'application/pdf'
        );
      } else {
        return DBSeller_Helper_Pdf_Pdf::renderPdf($sHtml, $sNomeArquivo, array('format' => 'A4', 'output' => 'D'));
      }
    } else {
      return $sHtml;
    }
  }
  /**
   * Verifica se esta na regra do parametro da prfeitura para reter tomador pessoa fisica na emissão de nota
   * @param  array   $aDados array de dados do formulário
   * @return boolean true|false
   */
  private function podeReterPessoaFisica(array $aDados) {

    if (isset($aDados['s_dados_iss_retido']) && $aDados['s_dados_iss_retido'] == 0) {
      return TRUE;
    }

    if (strlen($aDados['t_cnpjcpf']) > 14) {
      return TRUE;
    }

    $oParametrosPrefeitura = Administrativo_Model_ParametroPrefeitura::getAll();
    if ($aDados['natureza_operacao'] == 1 && $oParametrosPrefeitura[0]->getReterPessoaFisica() == 1) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * @param object $oContribuinte
   * @return bool
   * @throws Exception
   */
  private function getDiasRetroativosEmissao($oContribuinte) {

    // Calcula quantos dias no passado a nota pode ser emitida
    $oParametrosPrefeitura       = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    $iDiasRetroativosEmissaoNota = $oParametrosPrefeitura->getNotaRetroativa();
    $oDataCorrente               = new DateTime();
    $iMaxNota                    = 0;
    $iMaxGuia                    = 0;
    $oUltimaGuia                 = Contribuinte_Model_Guia::getUltimaGuiaNota($oContribuinte);
    $uDataUltimaNota             = Contribuinte_Model_Nota::getUltimaNotaEmitidaByContribuinte(
      $oContribuinte->getContribuintes()
    );

    if ($uDataUltimaNota != NULL) {

      $oDiff    = $oDataCorrente->diff(new DateTime($uDataUltimaNota), TRUE);
      $iMaxNota = ($oDiff->days < $iDiasRetroativosEmissaoNota) ? $oDiff->days : $iDiasRetroativosEmissaoNota;
    }

    if (!empty($oUltimaGuia)) {

      $iMes = $oUltimaGuia->getMesComp();
      $iAno = $oUltimaGuia->getAnoComp();

      if (($oUltimaGuia->getMesComp() + 1) > 12) {
        $iMes = 1;
      }

      $iMes = str_pad($iMes, 2, '0', STR_PAD_LEFT);

      $uDataUltimoDiaCompetencia = new Zend_Date("01/{$iMes}/{$iAno}");

      $uDataUltimoDiaCompetencia->sub(-1, Zend_Date::MONTH);

      $oDiff    = $oDataCorrente->diff(new DateTime($uDataUltimoDiaCompetencia->get('Y-M-d')), TRUE);
      $iMaxGuia = ($oDiff->days < $iDiasRetroativosEmissaoNota) ? $oDiff->days : $iDiasRetroativosEmissaoNota;
    } else if (empty($uDataUltimaNota)) {

      /* Caso o contribuinte não tenha emitido nenhuma nota, monta data pelo periodo de retroatividade*/
      $iMaxNota = $iDiasRetroativosEmissaoNota;
    }

    if ($iMaxNota > $iMaxGuia && $iMaxGuia > 0) {
      $iDiasRetroativosEmissaoNota = $iMaxGuia;
    } else if ($iMaxNota > 0) {
      $iDiasRetroativosEmissaoNota = $iMaxNota;
    } else if (!$iDiasRetroativosEmissaoNota || $iMaxNota == 0) {
      $iDiasRetroativosEmissaoNota = 0;
    }

    $oDataCorrente = new DateTime();
    $oDataCorrente = $oDataCorrente->sub(date_interval_create_from_date_string("{$iDiasRetroativosEmissaoNota} days"));

    // Vetor com os dias em que a nota pode ser emitida
    $aDiasEmissao = array();
    $oDia         = new DateTime();

    do {

      $aDiasEmissao[$oDia->format('Y-m-d')] = $oDia->format('d/m/Y');
      $oDia                                 = $oDia->sub(new DateInterval('P1D'));
    } while ($oDia->format('Ymd') >= $oDataCorrente->format('Ymd'));

    return $aDiasEmissao;
  }

  /**
   * Obtem os dados da nota e retorna um JSON
   * @param integer $id_copia Id nota
   * @return object $aNota [JSON]
   */
  public function obtemDadosNotaAction() {

    parent::noLayout();

    $id_copia_nota  = $this->getRequest()->getParam('id_copia');
    $oContribuinte  = $this->_session->contribuinte;
    $oContribuintes = $oContribuinte->getContribuintes();

    $aRetorno = array();
    $aRetorno['status'] = 'error';

    try {

      $aNota = Contribuinte_Model_Nota::getByAttribute('id', $id_copia_nota, '=', Contribuinte_Model_Nota::TIPO_RETORNO_ARRAY);

      if (!isset($aNota[0])) {
        throw new Exception('Nota não existe.');
      }

      if (in_array($aNota[0]['id_contribuinte'], $oContribuintes)) {

        // Procura o estado do serviço prestado, pois essa informação não consta na nota apenas o cod_ibge do municipio
        if (!empty($aNota[0]['s_dados_municipio_incidencia'])) {

          $iCodigoMunicipio   = $aNota[0]['s_dados_municipio_incidencia'];
          $aNota[0]['estado'] = Default_Model_Cadendermunicipio::getByCodIBGE($iCodigoMunicipio)->getUf();
        }

        $aNota[0]['descricao']                = $aNota[0]['s_dados_discriminacao'];
        $aNota[0]['s_iss_retido']             = ($aNota[0]['s_dados_iss_retido'] == 2) ? 1 : 0;
        $aNota[0]['s_vl_aliquota']            = number_format($aNota[0]['s_vl_aliquota'], 2, ',', '.');
        $aNota[0]['s_vl_servicos']            = DBSeller_Helper_Number_Format::toMoney($aNota[0]['s_vl_servicos'], 2);
        $aNota[0]['s_vl_deducoes']            = DBSeller_Helper_Number_Format::toMoney($aNota[0]['s_vl_deducoes'], 2);
        $aNota[0]['s_vl_bc']                  = DBSeller_Helper_Number_Format::toMoney($aNota[0]['s_vl_bc'], 2);
        $aNota[0]['s_vl_iss']                 = DBSeller_Helper_Number_Format::toMoney($aNota[0]['s_vl_iss'], 2);
        $aNota[0]['s_vl_pis']                 = DBSeller_Helper_Number_Format::toMoney($aNota[0]['s_vl_pis'], 2);
        $aNota[0]['s_vl_cofins']              = DBSeller_Helper_Number_Format::toMoney($aNota[0]['s_vl_cofins'], 2);
        $aNota[0]['s_vl_inss']                = DBSeller_Helper_Number_Format::toMoney($aNota[0]['s_vl_inss'], 2);
        $aNota[0]['s_vl_ir']                  = DBSeller_Helper_Number_Format::toMoney($aNota[0]['s_vl_ir'], 2);
        $aNota[0]['s_vl_csll']                = DBSeller_Helper_Number_Format::toMoney($aNota[0]['s_vl_csll'], 2);
        $aNota[0]['s_vl_outras_retencoes']    = DBSeller_Helper_Number_Format::toMoney($aNota[0]['s_vl_outras_retencoes'], 2);
        $aNota[0]['s_vl_desc_incondicionado'] = DBSeller_Helper_Number_Format::toMoney($aNota[0]['s_vl_desc_incondicionado'], 2);
        $aNota[0]['vl_liquido_nfse']          = DBSeller_Helper_Number_Format::toMoney($aNota[0]['vl_liquido_nfse'], 2);
        $aNota                                = $aNota[0];

        $aRetorno['data']   = $aNota;
        $aRetorno['status'] = 'success';
      }

      echo $this->getHelper('json')->sendJson($aRetorno);
    } catch (Exception $oError) {

      $aRetorno['error'] = array(
        'message' => $oError->getMessage()
      );

      echo $this->getHelper('json')->sendJson($aRetorno);
    }
  }

  /**
   * Tela das requisiçções de AIDOF
   */
  public function requisicaoAction() {

    $iInscricaoMunicipal = $this->_session->contribuinte->getInscricaoMunicipal();

    $oForm = new Contribuinte_Form_RequisicaoNfse();
    $oForm->setAction($this->view->baseUrl('/contribuinte/nfse/gerar-requisicao'));

    $this->view->oFormRequisicao  = $oForm;
    $this->view->aTipoDocumento   = Contribuinte_Model_nota::getTiposNota(Contribuinte_Model_Nota::GRUPO_NOTA_NFSE);
    $this->view->aListaRequisicao = Administrativo_Model_RequisicaoAidof::getRequisicoeseAidofs(
      $iInscricaoMunicipal,
      NULL,
      Contribuinte_Model_Nota::GRUPO_NOTA_NFSE
    );
  }

  /**
   * Gera requisição de AIDOF
   */
  public function gerarRequisicaoAction() {

    $aDados = $this->getRequest()->getParams();
    $oForm  = new Contribuinte_Form_RequisicaoNfse();

    // Busca Tipos de Nota do Grupo NFSE
    $aTiposDocumento = Contribuinte_Model_Nota::getTiposNota(Contribuinte_Model_Nota::GRUPO_NOTA_NFSE);

    // Popula o select com os tipos de nota para poder validar
    if (is_array($aTiposDocumento)) {
      $oForm->tipo_documento->addMultiOptions($aTiposDocumento);
    }

    // Valida o formulario e gera a requisicao
    if ($oForm->isValid($aDados)) {

      $iInscricaoMunicipal = $this->_session->contribuinte->getInscricaoMunicipal();
      $aTiposDocumento     = $this->getRequest()->getParam('tipo_documento');
      $iQuantidade         = $this->getRequest()->getParam('quantidade');

      // Verifica se possui requisicoes pendentes
      $iQuantidadeRequisicaoPendente = Administrativo_Model_RequisicaoAidof::verificarRequisicaoPendente(
        $iInscricaoMunicipal,
        $aTiposDocumento
      );

      if ($iQuantidadeRequisicaoPendente > 0) {

        $sMensagemDeErro = 'Você possui requisições pendentes para este tipo de documento.';

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $this->translate->_($sMensagemDeErro);
      } else {

        $iCgmPrefeitura = Administrativo_Model_Prefeitura::getCgmPrefeitura();

        Administrativo_Model_RequisicaoAidof::gerar(
          $aTiposDocumento,
          $iInscricaoMunicipal,
          $iCgmPrefeitura,
          $iQuantidade
        );

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('Requisição de emissão de NFSE enviada.');
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
   * Cancela requisição de AIDOF
   */
  public function cancelarRequisicaoAction() {

    parent::noLayout();

    $iCodigoRequisicao  = $this->getRequest()->getParam('id');
    $oRetornoWebService = Administrativo_Model_RequisicaoAidof::cancelar($iCodigoRequisicao);

    if (is_object($oRetornoWebService) && $oRetornoWebService->bStatus) {

      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['success'] = $this->translate->_('Requisição cancelada com sucesso.');
    } else if (is_object($oRetornoWebService) && !$oRetornoWebService->bStatus) {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['error'][] = $oRetornoWebService->sMensagem;
    } else {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['error'][] = $this->translate->_('Erro ao cancelar a requisição.');
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
}