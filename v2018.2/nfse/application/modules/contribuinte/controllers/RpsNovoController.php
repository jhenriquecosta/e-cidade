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

class Contribuinte_RpsNovoController extends Contribuinte_Lib_Controller_AbstractController {

  /**
   * Monta a tela para emissão do RPS
   *
   * @return void
   */
  public function indexAction() {

    $oContribuinte         = $this->_session->contribuinte;
    $oParametrosPrefeitura = Administrativo_Model_ParametroPrefeitura::getAll();
    $oForm                 = new Contribuinte_Form_RpsNovo();

    // Lista de paises
    $aPaises = Default_Model_Cadenderpais::getAll();

    // Verifica código ibge do municipio de origem
    $iCodigoIbge = (isset($oParametrosPrefeitura[0])) ? $oParametrosPrefeitura[0]->getIbge() : NULL;

    $sUfEstado = (isset($oParametrosPrefeitura[0])) ? $oParametrosPrefeitura[0]->getUf() : NULL;

    // Verifica se retem imposto
    $bReterImposto = (isset($oParametrosPrefeitura[0])) ? $oParametrosPrefeitura[0]->getReterPessoaFisica() : FALSE;

    // Popula o campo com as datas de emissão
    $aDiasRetroativosEmissao = $this->getDiasRetroativosEmissaoRps($oContribuinte);

    if ($oContribuinte !== NULL) {

      $oParametros = Contribuinte_Model_ParametroContribuinte::getById($oContribuinte->getIdUsuarioContribuinte());

      if ($oParametros instanceof Contribuinte_Model_ParametroContribuinte) {
        $oForm->preencheParametrosContribuinte($oParametros);
      }

      $oForm->setRegimeTributario($oContribuinte->getRegimeTributario());
    }

    // Verifica se existe algum bloqueio
    $oBloqueio = Administrativo_Model_RequisicaoAidof::verificaBloqueio($oContribuinte, Contribuinte_Model_Nota::GRUPO_NOTA_RPS);

    if ($oBloqueio->bloqueado_msg) {

      $this->view->bloqueado_msg = $this->translate->_($oBloqueio->bloqueado_msg);
      return FALSE;
    } else if (!empty($oBloqueio->message)) {
      $this->view->messages[] = array('warning' => $this->translate->_($oBloqueio->message));
    }

    $this->view->bReterImposto           = $bReterImposto;
    $this->view->aDiasRetroativosEmissao = $aDiasRetroativosEmissao;
    $this->view->sUfEstado               = $sUfEstado;
    $this->view->iCodigoIbge             = $iCodigoIbge;
    $this->view->aPaises                 = $aPaises;

    // Aplica regra de Regime Tributario MEI e Sociedade de Profissionais
    $oForm->aplicaRegrasArbritarias($oContribuinte);

    $this->view->oForm = $oForm;
  }

  /**
   * Metodo para emissão da RPS
   * @return bool
   */
  public function emitirAction() {

    parent::noLayout();

    $oContribuinte          = $this->_session->contribuinte;
    $aDados                 = $this->getRequest()->getParams();
    $oForm                  = new Contribuinte_Form_RpsNovo();
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

      if (empty($aDados['n_rps']) || empty($aDados['data_rps'])) {
        throw new Exception('Informe os dados da RPS.');
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

          if (count($aDeclaracaoSemMovimento) > 0
            && $oContribuinte->getOptanteSimplesCategoria()
            != Contribuinte_Model_ContribuinteAbstract::OPTANTE_SIMPLES_TIPO_MEI) {

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

        if ( isset($aDados['s_dados_fora_incide'])     &&
             $aDados['s_dados_fora_incide'] == 0       &&
             $aDados['t_cod_pais']          == '01058' &&
             $aDados['s_dados_cod_pais']    == '01058' ) {

          $sMensagemErro  = 'Não incide tributação: é necessário Tomador ou que o efeito do serviço seja fora do Brasil!';
          throw new Exception($sMensagemErro);

        } else if (!isset($aDados['s_dados_fora_incide'])) {
          $aDados['s_dados_fora_incide'] = TRUE;
        }

        $oNota = new Contribuinte_Model_Nota();

        if ($oNota::existeRps($oContribuinte, $aDados['n_rps'], $aDados['tipo_nota'])) {
           throw new Exception('Já existe um RPS com esta numeração!');
        } else if ($oForm->valid($aDados)) {

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
            throw new Exception('A numeração do RPS não confere com os AIDOFs liberados.');
          }


          // Remova chaves inválidas
          unset($aDados['enviar'], $aDados['action'], $aDados['controller'], $aDados['module'], $aDados['estado']);

          // filtro para retornar somente numeros
          $aFilterDigits = new Zend_Filter_Digits();

          $aDados['p_im']       = $oContribuinte->getInscricaoMunicipal();
          $aDados['t_cnpjcpf']  = $aFilterDigits->filter($aDados['t_cnpjcpf']);
          $aDados['t_cep']      = $aFilterDigits->filter($aDados['t_cep']);
          $aDados['t_telefone'] = $aFilterDigits->filter($aDados['t_telefone']);
          $aDados['grupo_nota'] = Contribuinte_Model_Nota::GRUPO_NOTA_RPS;

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

            /*
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
              $sMensagemErro .= '- A nota informada não possui guia emitida.';

              throw new Exception($sMensagemErro);
            }

            unset($aDados['nota_substituta'], $aDados['nota_substituida']);
          }

          // Persiste os dados na base de dados
          $oNota = new Contribuinte_Model_Nota();
          // Instancia o Model responsavel por tratar os retornos de validações
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
          $aRetornoJson['url']        = $oBaseUrlHelper->baseUrl("/contribuinte/nfse/dados-nota/id/{$oNota->getId()}/tipo_nota/rps");
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
    $oFormRequisicao->setAction($oBaseUrlHelper->baseUrl('/contribuinte/rps-novo/gerar-requisicao'));

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
   * Calcula quantos dias no passado a nota pode ser emtidida
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte      Dados do contribuinte
   * @return array Dias de emissão retroativa
   */
  private function getDiasRetroativosEmissaoRps(Contribuinte_Model_ContribuinteAbstract $oContribuinte) {

    $oParametrosPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    $max                   = $oParametrosPrefeitura->getNotaRetroativa();
    $oUltimaGuia           = Contribuinte_Model_Guia::getUltimaGuiaNota($oContribuinte);
    $uDataUltimaNota       = Contribuinte_Model_Nota::getUltimaNotaEmitidaByContribuinte($oContribuinte->getContribuintes());
    $dia                   = new DateTime();
    $maxNota              = 0;
    $maxGuia              = 0;

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

    // Vetor com os dias em que a nota pode ser emitida
    $aDiasEmissao = array();
    $oDia         = new DateTime();

    do {

      $aDiasEmissao[$oDia->format('Y-m-d')] = $oDia->format('d/m/Y');
      $oDia                                 = $oDia->sub(new DateInterval('P1D'));
    } while ($oDia->format('Ymd') >= $dia->format('Ymd'));

    return $aDiasEmissao;
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
   * Gera o PDF da RPS
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
}