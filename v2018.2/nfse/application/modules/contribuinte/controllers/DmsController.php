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
 * Controle de DMS (Declaração Manual de Serviços)
 *
 * @package    Contribuinte
 * @subpackage Controller
 * @author     Everton Heckler <everton.heckler@dbseller.com.br>
 * @tutorial   Responsável pelo registro de documentos emitidos manualmente (talão de notas, impresso via gráfica)
 */

class Contribuinte_DmsController extends Contribuinte_Lib_Controller_AbstractController {

  /**
   * Grupo de notas do tipo DMS
   *
   * @var string
   * @tutorial Lista dos grupos de notas separados por vírgula
   */
  const GRUPO_NOTA = Contribuinte_Model_Nota::GRUPO_NOTA_DMS;

  /**
   * Código de perfil do prestador eventual
   *
   * @var integer
   */
  const PERFIL_PRESTADOR_EVENTUAL = 6;

  /**
   * @var Administrativo_Model_Usuario
   */
  protected $oUsuario = NULL;

  /**
   * Contribuinte
   *
   * @var Contribuinte_Model_ContribuinteAbstract
   */
  protected $oContribuinte = NULL;

  /**
   * Método executado antes dos métodos restantes (equivalente ao construct)
   *
   * @see Contribuinte_Lib_Controller_AbstractController::init()
   */
  public function init() {

    parent::init();

    // Dados do usuario logado
    $aUsuario       = Zend_Auth::getInstance()->getIdentity();
    $this->oUsuario = Administrativo_Model_Usuario::getById($aUsuario['id']);

    // Dados do contribuinte
    $this->oContribuinte = $this->_session->contribuinte;
  }

  /**
   * Monta a tela para requisições de AIDOF
   */
  public function requisicaoAction() {

    $this->view->bloqueado_msg = FALSE;
    $iInscricaoMunicipal       = $this->_session->contribuinte->getInscricaoMunicipal();
    $oValidacao                = self::verificaParametrosEmpresa($iInscricaoMunicipal);

    if ($oValidacao->lStatus == FALSE) {

      $this->view->bloqueado_msg = $oValidacao->sMensagem;

      return;
    }

    $oForm = new Contribuinte_Form_RequisicaoDms();
    $oForm->setAction($this->view->baseUrl('/contribuinte/dms/gerar-requisicao'));

    $this->view->requisicaoForm = $oForm;
    $this->view->historico      = Administrativo_Model_RequisicaoAidof::getRequisicoeseAidofs($iInscricaoMunicipal,
                                                                                              NULL,
                                                                                              self::GRUPO_NOTA);
  }

  /**
   * Gera requisicao [Json]
   */
  public function gerarRequisicaoAction() {

    $aDados = $this->getRequest()->getParams();
    $oForm  = new Contribuinte_Form_RequisicaoRps();

    // Busca Tipos de Nota do Grupo DMS
    $aTiposDocumento = Contribuinte_Model_Nota::getTiposNota(Contribuinte_Model_Nota::GRUPO_NOTA_DMS);

    // Popula o select com os tipos de nota para poder validar
    if (is_array($aTiposDocumento)) {
      $oForm->tipo_documento->addMultiOptions($aTiposDocumento);
    }

    // Valida o formulario e gera a requisicao
    if ($oForm->isValid($aDados)) {

      $iInscricaoMunicipal = $this->_session->contribuinte->getInscricaoMunicipal();
      $iCgmGrafica         = $this->getRequest()->getParam('cgm_grafica');
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

        Administrativo_Model_RequisicaoAidof::gerar(
                                            $aTiposDocumento,
                                            $iInscricaoMunicipal,
                                            $iCgmGrafica,
                                            $iQuantidade
        );

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('Requisição de emissão de DMS enviada.');
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
   * Cancela requisicao [Json]
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

  /**
   * Importacao de arquivo
   */
  public function importacaoAction() {

    $oFormImportacaoDms = new Contribuinte_Form_ImportacaoArquivo();
    $oFormImportacaoDms->renderizaCamposDms();
    $oFormImportacaoDms->setAction($this->view->baseUrl('/contribuinte/dms/processar-arquivo'));

    $this->view->importacaoForm = $oFormImportacaoDms;
  }

  /**
   * Importacao de arquivo [Json]
   *
   * @throws Exception
   */
  public function processarArquivoAction() {

    parent::noLayout();

    $oFormImportacaoDms = new Contribuinte_Form_ImportacaoArquivo();
    $oFormImportacaoDms->renderizaCamposDms();

    $oDoctrine = Zend_Registry::get('em');
    $oDoctrine->getConnection()->beginTransaction();

    try {

      // Id do usuário logado
      $oContador           = $this->oUsuario;
      $iCodigoUsuario      = $this->usuarioLogado->getId();
      $oContribuinteLogado = $this->oContribuinte;
      $oImportacao         = new Contribuinte_Model_ImportacaoDms();

      if (!$oFormImportacaoDms->arquivo->isUploaded()) {
        throw new Exception($this->translate->_('Informe um arquivo válido.'));
      }

      $sArquivoPdfBase64 = base64_encode(file_get_contents($_FILES['arquivo']['tmp_name']));
      $sNomeArquivo      = $_FILES['arquivo']['name'];

      // Seta a inscrição municipal do contribuinte, caso seja contador seta nulo
      $oRetorno = Contribuinte_Model_ImportarDmsEcidade::processarArquivo($oContador,
                                                                          $oContribuinteLogado,
                                                                          $sArquivoPdfBase64);

      if ($oRetorno->bStatus == FALSE) {
        throw new Exception($oRetorno->sMensagem);
      }

      if (!is_array($oRetorno->aDados)) {

        $sMensagem = 'Arquivo processado de forma incorreta! Favor entre em contato com o suporte.';
        throw new Exception($this->translate->_($sMensagem));
      }

      // Varre os contadores / escritórios
      $oEscritorio                 = NULL;
      $aImportacaoNotas            = NULL;
      $fValorTotalImportado        = NULL;
      $fValorTotalImpostoImportado = NULL;
      $iQuantidadeNotas            = NULL;

      foreach ($oRetorno->aDados['contadores'] as $aContadores) {

        // Dados do contador / escritório
        $oEscritorio = isset($aContadores['dados']) ? $aContadores['dados'] : NULL;

        if (!isset($aContadores['contribuintes']) || count($aContadores) < 1) {
          throw new Exception ('Arquivo inconsistente, não foi encontrado contribuintes.');
        }

        // Varre os contribuintes do contador
        foreach ($aContadores['contribuintes'] as $aContribuintes) {

          // Totalizadores
          $fValorTotalImpostoImportado = 0;
          $fValorTotalImportado        = 0;
          $iQuantidadeNotas            = 0;
          $iTotalImportadas            = 0;

          // Dados
          $aPlanilhas = $aContribuintes['planilha'];

          // Varre as planilhas do contribuinte
          foreach ($aPlanilhas as $sOperacao => $oPlanilha) {

            if (isset($oPlanilha->aNotas) && count($oPlanilha->aNotas) > 0) {

              $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($oPlanilha->iInscricao);
              $oDms          = new Contribuinte_Model_Dms();

              $oDms->setAnoCompetencia($oPlanilha->iAnoCompetencia);
              $oDms->setMesCompetencia($oPlanilha->iMesCompetencia);
              $oDms->setDataOperacao(new DateTime($oPlanilha->dtDatausu));
              $oDms->setStatus('aberto');
              $oDms->setOperacao($sOperacao);
              $oDms->setIdContribuinte($oContribuinte->getIdUsuarioContribuinte());
              $oDms->setIdUsuario($iCodigoUsuario);

              // Verifica se existe notas para o contribuinte
              if (isset($aContribuintes['notas'][$sOperacao])) {

                // Varre as notas do contribuinte
                foreach ($aContribuintes['notas'][$sOperacao] as $oNota) {

                  // Dados Nota
                  $oGrupoDocumento = Contribuinte_Model_Nota::getTipoNota($oNota->iCodigoTipoNota);

                  $oDmsNota = new Contribuinte_Model_DmsNota();
                  $oDmsNota->setNotaNumero($oNota->sNumeroNota);
                  $oDmsNota->setNotaSerie($oNota->sSerie);
                  $oDmsNota->setNotaData(new DateTime(date('Y-m-d', $oNota->sDataEmissao->iTimeStamp)));
                  $oDmsNota->setGrupoDocumento($oGrupoDocumento->codigo_grupo);
                  $oDmsNota->setTipoDocumento($oNota->iCodigoTipoNota);
                  $oDmsNota->setSituacaoDocumento($oNota->sSituacao);
                  $oDmsNota->setEmiteGuia($oNota->lEmiteGuia);

                  // Dados Servico
                  $bTomadorPagaIss = empty($oNota->bRetido) ? FALSE : TRUE;

                  // Formatada dados
                  $dServicoData = new DateTime(date('Y-m-d', $oNota->sDataPrestacao->iTimeStamp));

                  // Validação dos valores das notas
                  $oValidacaoValores =
                    Contribuinte_model_dms::emissaoManualCalculaValoresDms(
                                          $bTomadorPagaIss,
                                          DBSeller_Helper_Number_Format::toMoney($oNota->fValorServico),
                                          DBSeller_Helper_Number_Format::toMoney($oNota->fValorDeducao),
                                          DBSeller_Helper_Number_Format::toMoney($oNota->fValorDescontoCondicional),
                                          DBSeller_Helper_Number_Format::toMoney($oNota->fValorDescontoIncondicional),
                                          DBSeller_Helper_Number_Format::toMoney($oNota->fValorAliquota));

                  // Verifica valores do imposto
                  if ((DBSeller_Helper_Number_Format::toMoney($oNota->fValorBaseCalculo) !=
                      $oValidacaoValores['s_base_calculo'])
                    || (DBSeller_Helper_Number_Format::toMoney($oNota->fValorIssqn) !=
                      $oValidacaoValores['s_valor_imposto'])
                  ) {

                    $sMensagem = 'Arquivo possui valores inconsistentes!<br>';
                    $sMensagem .= "Nota: {$oNota->sNumeroNota} Série: {$oNota->sSerie}";

                    throw new Exception($this->translate->_($sMensagem));
                  }

                  // Dados do documento de DMS
                  $oDmsNota->setServicoData($dServicoData);
                  $oDmsNota->setServicoImpostoRetido($bTomadorPagaIss);
                  $oDmsNota->setServicoCodigoServico($oNota->iCodigoAtividade);
                  $oDmsNota->setDescricaoServico($oNota->sDescricaoServico);
                  $oDmsNota->setServicoValorPagar($oNota->fValorServico);
                  $oDmsNota->setServicoValorLiquido($oNota->fValorNota);
                  $oDmsNota->setServicoValorDeducao($oNota->fValorDeducao);
                  $oDmsNota->setServicoValorCondicionado($oNota->fValorDescontoCondicional);
                  $oDmsNota->setServicoDescontoIncondicionado($oNota->fValorDescontoIncondicional);
                  $oDmsNota->setServicoBaseCalculo($oNota->fValorBaseCalculo);
                  $oDmsNota->setServicoValorAliquota($oNota->fValorAliquota);
                  $oDmsNota->setServicoValorImposto($oNota->fValorIssqn);
                  $oDmsNota->setNumpre(0);

                  // Campos novos
                  $oDmsNota->setNaturezaOperacao($oNota->iNaturezaOperacao);
                  $oDmsNota->setServicoCodigoObra($oNota->sCodigoObra);
                  $oDmsNota->setServicoArt($oNota->sArt);
                  $oDmsNota->setServicoInformacoesComplementares($oNota->sInformacoesComplementares);

                  // Verifica a operação
                  if (strtolower($sOperacao) == Contribuinte_Model_Dms::SAIDA) {

                    $iInscricaoPrestador = $oPlanilha->iInscricao;
                    $sCpfCnpjTomador     = $oNota->iCpfCnpjTomador;

                    $oDadosPrestador = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoPrestador);
                  } else {

                    $oDadosPrestador = Contribuinte_Model_Contribuinte::getByCpfCnpj($oNota->iCpfCnpjTomador);
                    $sCpfCnpjTomador = $oContribuinte->getCgcCpf();
                  }

                  // Verifica o prestador
                  if (empty($oDadosPrestador)) {

                    $sMensagem = 'Arquivo processado de forma incorreta!<br>Existem contribuinte inválidos.';
                    throw new Exception($this->translate->_($sMensagem));
                  }

                  // Serviços prestados
                  if (strtolower($sOperacao) == Contribuinte_Model_Dms::SAIDA) {

                    $oDmsNota->setPrestadorCpfCnpj($oDadosPrestador->getCgcCpf());
                    $oDmsNota->setPrestadorInscricaoMunicipal($oDadosPrestador->getInscricaoMunicipal());
                    $oDmsNota->setPrestadorInscricaoEstadual($oDadosPrestador->getInscricaoEstadual());
                    $oDmsNota->setPrestadorEnderecoRua($oDadosPrestador->getDescricaoLogradouro());
                    $oDmsNota->setPrestadorEnderecoNumero($oDadosPrestador->getLogradouroNumero());
                    $oDmsNota->setPrestadorEnderecoComplemento($oDadosPrestador->getLogradouroComplemento());
                    $oDmsNota->setPrestadorEnderecoBairro($oDadosPrestador->getLogradouroBairro());
                    $oDmsNota->setPrestadorEnderecoCodigoMunicipio($oDadosPrestador->getCodigoIbgeMunicipio());
                    $oDmsNota->setPrestadorEnderecoEstado($oDadosPrestador->getEstado());
                    $oDmsNota->setPrestadorEnderecoCodigoPais($oDadosPrestador->getCodigoPais());
                    $oDmsNota->setPrestadorEnderecoCEP($oDadosPrestador->getCep());
                    $oDmsNota->setPrestadorTelefone($oDadosPrestador->getTelefone());
                    $oDmsNota->setPrestadorEmail($oDadosPrestador->getEmail());
                  } else {

                    // Dados Prestador
                    $oDadosPrestador = Contribuinte_Model_Empresa::getByCgcCpf($oNota->iCpfCnpjTomador);

                    // Verifica se é prestador do eCidade e NFSe
                    if (is_object($oDadosPrestador) && isset($oDadosPrestador->eCidade)) {

                      $oDadosPrestador = $oDadosPrestador->eCidade[0];

                      $oDmsNota->setPrestadorCpfCnpj($oNota->iCpfCnpjTomador);
                      $oDmsNota->setPrestadorRazaoSocial($oDadosPrestador->attr('nome'));
                      $oDmsNota->setPrestadorNomeFantasia($oDadosPrestador->attr('nome_fanta'));
                      $oDmsNota->setPrestadorInscricaoMunicipal($oDadosPrestador->attr('inscricao'));
                      $oDmsNota->setPrestadorInscricaoEstadual($oDadosPrestador->attr('inscr_est'));
                      $oDmsNota->setPrestadorEnderecoRua($oDadosPrestador->attr('logradouro'));
                      $oDmsNota->setPrestadorEnderecoNumero($oDadosPrestador->attr('numero'));
                      $oDmsNota->setPrestadorEnderecoComplemento($oDadosPrestador->attr('complemento'));
                      $oDmsNota->setPrestadorEnderecoBairro($oDadosPrestador->attr('bairro'));
                      $oDmsNota->setPrestadorEnderecoCodigoMunicipio($oDadosPrestador->attr('cod_ibge'));
                      $oDmsNota->setPrestadorEnderecoEstado($oDadosPrestador->attr('uf'));
                      $oDmsNota->setPrestadorEnderecoCodigoPais($oDadosPrestador->attr('cod_pais'));
                      $oDmsNota->setPrestadorEnderecoCEP($oDadosPrestador->attr('cep'));
                      $oDmsNota->setPrestadorTelefone($oDadosPrestador->attr('telefone'));
                      $oDmsNota->setPrestadorEmail($oDadosPrestador->attr('email'));
                    } else {

                      $oDmsNota->setPrestadorCpfCnpj($oNota->iCpfCnpjTomador);
                      $oDmsNota->setPrestadorRazaoSocial($oNota->sNomeRazaoSocial);
                      $oDmsNota->setPrestadorNomeFantasia($oNota->sNomeRazaoSocial);
                    }
                  }

                  // Dados Tomador
                  $oDadosTomador = Contribuinte_Model_Empresa::getByCgcCpf($sCpfCnpjTomador);

                  // Verifica se é tomador do eCidade e NFSe
                  if (is_object($oDadosTomador) && isset($oDadosTomador->eCidade)) {

                    $oDadosTomador = $oDadosTomador->eCidade[0];

                    $oDmsNota->setTomadorCpfCnpj($oDadosTomador->attr('cpf'));
                    $oDmsNota->setTomadorRazaoSocial($oDadosTomador->attr('nome'));
                    $oDmsNota->setTomadorNomeFantasia($oDadosTomador->attr('nome_fanta'));
                    $oDmsNota->setTomadorInscricaoMunicipal($oDadosTomador->attr('inscricao'));
                    $oDmsNota->setTomadorInscricaoEstadual($oDadosTomador->attr('inscr_est'));
                    $oDmsNota->setTomadorEnderecoRua($oDadosTomador->attr('logradouro'));
                    $oDmsNota->setTomadorEnderecoNumero($oDadosTomador->attr('numero'));
                    $oDmsNota->setTomadorEnderecoComplemento($oDadosTomador->attr('complemento'));
                    $oDmsNota->setTomadorEnderecoBairro($oDadosTomador->attr('bairro'));
                    $oDmsNota->setTomadorEnderecoCodigoMunicipio($oDadosTomador->attr('cod_ibge'));
                    $oDmsNota->setTomadorEnderecoEstado($oDadosTomador->attr('uf'));
                    $oDmsNota->setTomadorEnderecoCodigoPais($oDadosTomador->attr('cod_pais'));
                    $oDmsNota->setTomadorEnderecoCEP($oDadosTomador->attr('cep'));
                    $oDmsNota->setTomadorTelefone($oDadosTomador->attr('telefone'));
                    $oDmsNota->setTomadorEmail($oDadosTomador->attr('email'));
                  } else if (!isset($oDadosTomador->eNota)) {

                    $aDadosTomador['t_cnpjcpf']      = $sCpfCnpjTomador;
                    $aDadosTomador['t_razao_social'] = $oNota->sNomeRazaoSocial;

                    $oDadosTomador = new Contribuinte_Model_EmpresaBase();
                    $oDadosTomador->persist($aDadosTomador);

                    $oDmsNota->setTomadorCpfCnpj($oNota->iCpfCnpjTomador);
                    $oDmsNota->setTomadorRazaoSocial($oNota->sNomeRazaoSocial);
                  }

                  // Dados dos usuário e contribuinte
                  $oDmsNota->setIdUsuario($iCodigoUsuario);
                  $oDmsNota->setIdContribuinte($oContribuinte->getIdUsuarioContribuinte());

                  // Incrementa os valores
                  $fValorTotalImpostoImportado = $fValorTotalImpostoImportado + $oNota->fValorIssqn;
                  $fValorTotalImportado        = $fValorTotalImportado + $oNota->fValorNota;
                  $iQuantidadeNotas++;

                  // Se for serviço prestado, verifica se a quantidade de AIDOFs é suficiente para importação
                  if (strtolower($sOperacao) == Contribuinte_Model_Dms::SAIDA) {

                    $iTotalNotasImportadas   = count($aContribuintes['notas'][$sOperacao]);
                    $iTotalImportadas        = $iTotalImportadas + 1;
                    $oAidof                  = new Administrativo_Model_Aidof();
                    $iQuantidadeNotasEmissao = $oAidof->getQuantidadesNotasEmissao($oPlanilha->iInscricao,
                                                                                   $oNota->iCodigoTipoNota);
                    $iQuantidadeLiberada     = $iQuantidadeNotasEmissao - $iTotalImportadas;

                    if ($iQuantidadeLiberada <= 0) {

                      $sMensagem = 'Você não possui AIDOFs liberadas para importar os documentos.';
                      $sMensagem = sprintf($sMensagem, $iQuantidadeLiberada, $iTotalNotasImportadas);

                      throw new Exception($this->translate->_($sMensagem));
                    } else if ($iQuantidadeLiberada < $iTotalNotasImportadas) {

                      $sMensagem = 'Você possui apenas "%s" AIDOFs liberadas para importar "%s" documentos.';
                      $sMensagem = sprintf($sMensagem, $iQuantidadeLiberada, $iTotalNotasImportadas);

                      throw new Exception($this->translate->_($sMensagem));
                    }

                    // Valida se a numeração da nota está no intervalo confere com as AIDOF liberadas
                    $lNumeracaoNotaConfereComAidofLiberada = $oAidof->verificarNumeracaoValidaParaEmissaoDocumento(
                                                                    $oDmsNota->getPrestadorInscricaoMunicipal(),
                                                                    $oDmsNota->getNotaNumero(),
                                                                    $oDmsNota->getTipoDocumento());

                    if (!$lNumeracaoNotaConfereComAidofLiberada) {

                      $sMensagem = 'O número do documento "%s" não confere com a numeração permitida pelas AIDOF\'s.';
                      throw new Exception($this->translate->_(sprintf($sMensagem, $oDmsNota->getNotaNumero())));
                    }
                  }

                  // Verifica se ja existe o documento, ignora e anula a planilha
                  if ($oDmsNota::checarNotaEmitida($oContribuinte,
                                                   $oNota->iCodigoTipoNota,
                                                   $oNota->sNumeroNota,
                                                   NULL,
                                                   $sOperacao)
                  ) {

                    $sMensagem = 'O documento nº "%s" já consta na base de dados do sistema.';
                    throw new Exception($this->translate->_(sprintf($sMensagem, $oNota->sNumeroNota)));
                  } else {

                    // Adiciona as notas no DMS
                    $oDmsNota->setDms($oDms->getEntity());
                    $oDms->addDmsNotas($oDmsNota->getEntity());
                  }

                  // Formata os dados
                  $sCompetenciaImportacao = $oPlanilha->iMesCompetencia . '-' . $oPlanilha->iAnoCompetencia;

                  // Adiciona os dados do documento na importação
                  $oImportacaoNotas = new Contribuinte_Model_ImportacaoDmsNota();
                  $oImportacaoNotas->setNumeroNota($oNota->sNumeroNota);
                  $oImportacaoNotas->setTipoNota($oNota->iCodigoTipoNota);
                  $oImportacaoNotas->setValorTotal($oDmsNota->getServicoValorPagar());
                  $oImportacaoNotas->setValorImposto($oNota->fValorIssqn);
                  $oImportacaoNotas->setOperacaoNota($sOperacao);
                  $oImportacaoNotas->setDataEmissaoNota($oDmsNota->getNotaData());
                  $oImportacaoNotas->setCompetencia($sCompetenciaImportacao);
                  $oImportacaoNotas->setIdContribuinte($oContribuinte->getIdUsuarioContribuinte());

                  // Adiciona os dados na lista da importação
                  $aImportacaoNotas[] = $oImportacaoNotas;
                }
              }
            } else {

              $sMensagem = 'Nenhum documento foi encontrado para importar.';
              throw new Exception($this->translate->_($sMensagem));
            }

            // Salva o DMS
            $aCodigosDms[] = $oDms->persist();
          }
        }
      }

      // Formata os dados
      $sCodigoEscritorio = isset($oEscritorio->iInscricaoMunicipal) ? $oEscritorio->iInscricaoMunicipal : NULL;

      // Prepara informações da importacao
      $oImportacao->setDataOperacao(new DateTime());
      $oImportacao->setValorTotal($fValorTotalImportado);
      $oImportacao->setValorImposto($fValorTotalImpostoImportado);
      $oImportacao->setNomeArquivo($sNomeArquivo);
      $oImportacao->setQuantidadeNotas($iQuantidadeNotas);
      $oImportacao->setIdUsuario($iCodigoUsuario);
      $oImportacao->setCodigoEscritorio($sCodigoEscritorio);

      if (is_array($aImportacaoNotas)) {

        foreach ($aImportacaoNotas as $oNotaImportada) {

          $oNotaImportada->setImportacaoDms($oImportacao->getEntity());
          $oImportacao->addImportacaoNotas($oNotaImportada->getEntity());
        }
      }

      // Salva log de importação
      $iCodigoImportacao = $oImportacao->persist();

      // Retorno em Json
      $aRetornoJson['status']  = $oRetorno->bStatus;
      $aRetornoJson['success'] = $oRetorno->sMensagem;
      $aRetornoJson['url']     = $this->view->baseUrl("/contribuinte/dms/comprovante/id/{$iCodigoImportacao}");

      $oDoctrine->getConnection()->commit();

      echo $this->getHelper('json')->sendJson($aRetornoJson);
    } catch (Exception $oErro) {

      $oDoctrine->getConnection()->rollback();

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['error'][] = $oErro->getMessage();

      echo $this->getHelper('json')->sendJson($aRetornoJson);

      return;
    }
  }

  /**
   * Gera o comprovante para a importacao de DMS
   */
  public function comprovanteAction() {

    parent::noLayout();

    $iIdImportacao  = $this->getRequest()->getParam('id');
    $oImportacao    = Contribuinte_Model_ImportacaoDms::getByAttribute('id', $iIdImportacao)->getEntity();
    $oDadosContador = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($oImportacao->getCodigoEscritorio());
    $oDadosUsuario  = Administrativo_Model_Usuario::getById($oImportacao->getIdUsuario());
    $aPrefeitura    = Administrativo_Model_ParametroPrefeitura::getListAll();
    $oPrefeitura    = reset($aPrefeitura);

    $this->view->oImportacao      = $oImportacao;
    $this->view->oDadosContador   = $oDadosContador;
    $this->view->oDadosUsuario    = $oDadosUsuario;
    $this->view->oDadosPrefeitura = $oPrefeitura;
    $this->view->sNomePrefeitura  = $oPrefeitura->getEntity()->getNome();

    $this->_helper->layout->setLayout('pdf');
    $this->renderPdf($this->view->render('dms/comprovante.phtml'), 'comprovante', array('format' => 'A4'));
  }

  /**
   * Emite Dms manual de Saida
   */
  public function emissaoManualSaidaCompetenciaAction() {

    try {

      $oValidacao = self::verificaParametrosEmpresa($this->_session->contribuinte->getInscricaoMunicipal());

      if ($oValidacao->lStatus == FALSE) {

        $this->view->bloqueado_msg = $oValidacao->sMensagem;

        return;
      }

      $oForm = new Contribuinte_Form_DmsCompetencia();
      $oForm->setAction($this->view->baseUrl('/contribuinte/dms/emissao-manual-saida-lista-dms'));

      $this->view->form = $oForm;
    } catch (Exception $oError) {
      $this->view->messages[] = array('error' => $this->translate->_($oError->getMessage()));
    }
  }

  /**
   * Lista de DMS emitidos manualmente
   */
  public function emissaoManualSaidaListaDmsAction() {

    try {

      // Parametros request
      $iMes = $this->getRequest()->getParam('mes');
      $iAno = $this->getRequest()->getParam('ano');

      // Perfil do usuario logado
      $iIdPerfil = $this->oUsuario->getPerfil()->getId();

      // Dados do DMS
      $oDms       = new Contribuinte_Model_Dms();
      $aDms       = $oDms->getCompetenciaByCpfCnpj($this->oContribuinte->getCgcCpf(), $iMes, $iAno);
      $aResultado = array();

      if (count($aDms) > 0) {

        foreach ($aDms as $oDms) {

          $fValorDms = 0;

          if ($oDms->getStatus() == 'emitida') {

            $iNumpre = Contribuinte_Model_DmsNota::getNumpreByIdDms($oDms->getId());
            $sStatus = Contribuinte_Model_GuiaEcidade::atualizaSituacao($iNumpre, $iMes);

            if ($sStatus == 'ABERTO') {
              $sStatus = 'Emitida Guia';
            }
          } else {
            $sStatus = $oDms->getStatus();
          }

          foreach ($oDms->getDmsNotas() as $oNota) {
            $fValorDms += $oNota->getServicoValorImposto();
          }

          // Formata os dados
          $sMesCompetencia = DBSeller_Helper_Date_Date::mesExtenso($oDms->getMesCompetencia());

          // Dados do dms para a view
          $oDmsView                = new stdClass();
          $oDmsView->id            = $oDms->getId();
          $oDmsView->data_operacao = $oDms->getDataOperacao()->format('d/m/Y');
          $oDmsView->fechado       = $oDms->getStatus() == 'fechado';
          $oDmsView->competencia   = "{$sMesCompetencia}/{$oDms->getAnoCompetencia()}";
          $oDmsView->status_guia   = ucfirst(strtolower($sStatus));
          $oDmsView->valor_imposto = DBSeller_Helper_Number_Format::toMoney($fValorDms, 2, 'R$ ');

          // Lista de DMS da view
          $aResultado[] = $oDmsView;
        }
      }

      // Verifica se tem requisicoes liberadas (ignora para contribuinte eventual)
      if ($iIdPerfil != self::PERFIL_PRESTADOR_EVENTUAL) {

        // Verifica se tem requisicoes liberadas
        $iTiposLiberados           = 0;
        $aTiposDocumentosLiberados = Administrativo_Model_RequisicaoAidof::getRequisicoesAidof(
                                                                         $this->oContribuinte->getInscricaoMunicipal());

        if (count($aTiposDocumentosLiberados) > 0) {

          foreach ($aTiposDocumentosLiberados as $oTiposDocumentos) {

            if (in_array($oTiposDocumentos->status, array('', 'L'))) {
              $iTiposLiberados++;
            }
          }
        }

        if (count($aTiposDocumentosLiberados) <= 0 || $iTiposLiberados == 0) {
          $this->view->sem_requisicao = TRUE;
        }
      }

      // Verifica se o contribuinte declarou sem movimento
      $aDeclaracaoSemMovimento = Contribuinte_Model_Competencia::getDeclaracaoSemMovimentoPorContribuintes(
                                                               array($this->oContribuinte->getInscricaoMunicipal()),
                                                               $iAno,
                                                               $iMes);

      if (count($aDeclaracaoSemMovimento) > 0) {
        $this->view->declarado_sem_movimento = TRUE;
      }

      // Dados da competência
      $oCompetencia      = new stdClass();
      $oCompetencia->mes = $iMes;
      $oCompetencia->ano = $iAno;

      // Dados da view
      $this->view->aDms        = $aResultado;
      $this->view->competencia = $oCompetencia;

    } catch (Exception $oError) {
      $this->view->messages[] = array('error' => $this->translate->_($oError->getMessage()));
    }
  }

  /**
   * Altera o status do DMS [Json]
   */
  public function emissaoManualSaidaListaDmsAlterarStatusAction() {

    // Parametros request
    $iIdDms  = $this->getRequest()->getParam('id_dms', NULL);
    $sStatus = $this->getRequest()->getParam('status', NULL);

    // Retorno Json
    $aRetornoJson['status'] = FALSE;

    // Valida se o identificador do dms é valido
    if (!$iIdDms) {
      $aRetornoJson['error'] = $this->translate->_('Identificador de DMS inválido!');
    } else if (!$sStatus || ($sStatus != 'aberto' && $sStatus != 'fechado' && $sStatus != 'emitido')) {
      $aRetornoJson['error'] = $this->translate->_('Status inválido!');
    } else {

      try {

        $oDms = Contribuinte_Model_Dms::getById($iIdDms);
        $oDms->setStatus($sStatus);
        $oDms->persist();

        $sUrlDmsLista = '/contribuinte/dms/emissao-manual-saida-lista-dms/';
        $sUrlDmsLista .= "mes/{$oDms->getMesCompetencia()}/ano/{$oDms->getAnoCompetencia()}";

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('DMS alterado com sucesso!');
        $aRetornoJson['url']     = $this->view->baseUrl($sUrlDmsLista);
      } catch (Exception $e) {
        $aRetornoJson['error'] = $this->translate->_("Erro ao alterar o DMS: {$e->getMessage()}");
      }
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Exclui DMS [Json]
   */
  public function emissaoManualListaDmsExcluirAction() {

    // Parametros request
    $iIdDms = $this->getRequest()->getParam('id_dms', NULL);

    // Retorno Json
    $aRetornoJson['status'] = FALSE;

    // Valida se o identificador do dms é valido
    if (!$iIdDms) {
      $aRetornoJson['error'] = $this->translate->_('Identificador de DMS inválido!');
    } else {

      try {

        $oDms = Contribuinte_Model_Dms::getById($iIdDms);
        $oDms->destroy();

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('DMS excluído com sucesso!');
      } catch (Exception $oError) {
        $aRetornoJson['error'] = sprintf($this->translate->_('Erro ao excluir o DMS: %s'), $oError->getMessage());
      }
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Visualizacao do DMS Manual
   */
  public function emissaoManualSaidaVisualizarAction() {

    // Parametros request
    $iIdDms = $this->getRequest()->getParam('id_dms', NULL);

    // Valida se o identificador do dms é valido
    if (!$iIdDms) {
      throw new Zend_Exception($this->translate->_('Código do DMS não informado.'));
    }

    $oDms = Contribuinte_Model_Dms::getById($iIdDms);

    if (!$oDms) {
      throw new Zend_Exception($this->translate->_('DMS não encontrado.'));
    }

    $this->view->iCompetenciaMes = $oDms->getMesCompetencia();
    $this->view->iCompetenciaAno = $oDms->getAnoCompetencia();
    $this->view->iIdDms          = $iIdDms;
  }

  /**
   * Lista de notas do DMS
   */
  public function emissaoManualSaidaListaNotasAction() {

    parent::noTemplate();

    try {

      // Parametros request
      $iIdDms   = $this->getRequest()->getParam('id_dms', NULL);
      $oDmsNota = new Contribuinte_Model_DmsNota();

      // Não mostra os botoes editar/remover na view
      $this->view->visualizar = $this->getRequest()->getParam('visualizar', FALSE);
      $this->view->aDmsNota   = $oDmsNota->getByIdDms($iIdDms);
    } catch (Exception $oError) {
      $this->view->messages[] = array('error' => $this->translate->_($oError->getMessage()));
    }
  }

  /**
   * Emite DMS Manualmente
   */
  public function emissaoManualSaidaAction() {

      try {

        $iIdPerfil = $this->oUsuario->getPerfil()->getId();

        if ($iIdPerfil == self::PERFIL_PRESTADOR_EVENTUAL) {
          $oForm = new Contribuinte_Form_DmsSaidaEventual();
        } else {
          $oForm = new Contribuinte_Form_DmsSaida();
        }

        $oForm->setServico();
        // Parâmetros request
        $iIdDms     = $this->getRequest()->getParam('id_dms', NULL);
        $iIdDmsNota = $this->getRequest()->getParam('id_nota', NULL);
        $iMes       = $this->getRequest()->getParam('mes', NULL);
        $iAno       = $this->getRequest()->getParam('ano', NULL);

        if ($iMes) {
          $oForm->mes_comp->setValue($iMes);
        }

        if ($iAno) {
          $oForm->ano_comp->setValue($iAno);
        }

        if ($iIdDms) {

          $oDms = Contribuinte_Model_Dms::getById($iIdDms);
          $iMes = $oDms->getMesCompetencia();
          $iAno = $oDms->getAnoCompetencia();

          $oForm->id_dms->setValue($iIdDms);
          $oForm->mes_comp->setValue($iMes);
          $oForm->ano_comp->setValue($iAno);

          $this->view->oDms = $oDms;
        }

        // Carrega Dados Nota
        if ($iIdDmsNota) {

          $oDmsNota = Contribuinte_Model_DmsNota::getById($iIdDmsNota);

          // Dados Tomador
          $oForm->id->setValue($iIdDmsNota);
          $oForm->s_nota_data->setValue($oDmsNota->getNotaData()->format('d/m/Y'));
          $oForm->s_nota->setValue($oDmsNota->getNotaNumero());
          $oForm->s_nota_serie->setValue($oDmsNota->getNotaSerie());

          // Prestador eventual
          if ($iIdPerfil == self::PERFIL_PRESTADOR_EVENTUAL) {
            $oForm->tipo_documento_descricao->setValue($oDmsNota->getTipoDocumentoDescricao());
          } else {

            $oForm->setTipoDocumento($oDmsNota->getTipoDocumento());
            $oForm->setSituacaoDocumento($oDmsNota->getSituacaoDocumento());
            $oForm->setNaturezaOperacao($oDmsNota->getNaturezaOperacao());
            $oForm->s_imposto_retido->setValue($oDmsNota->getServicoImpostoRetido());
          }

          // Dados Nota
          $oForm->s_inscricao_municipal->setValue($oDmsNota->getTomadorInscricaoMunicipal());
          $oForm->s_cpf_cnpj->setValue($oDmsNota->getTomadorCpfCnpj());
          $oForm->s_razao_social->setValue($oDmsNota->getTomadorRazaoSocial());

          // Dados Servico
          $oForm->s_data->setValue($oDmsNota->getServicoData()->format('d/m/Y'));
          $oForm->s_valor_bruto->setValue(DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoValorPagar()));
          $oForm->s_valor_deducao->setValue(DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoValorDeducao()));
          $oForm->s_vl_condicionado->setValue(DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoValorCondicionado()));
          $oForm->s_vl_desc_incondicionado->setValue(DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoDescontoIncondicionado()));
          $oForm->s_aliquota->setValue(DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoAliquota()));
          $oForm->s_base_calculo->setValue(DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoBaseCalculo()));
          $oForm->s_valor_imposto->setValue(DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoValorImposto()));
          $oForm->s_valor_pagar->setValue(DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoValorLiquido()));
          $oForm->s_dados_cod_cnae->setValue($oDmsNota->getServicoCodigoCnae());
          $oForm->s_servico_prestado->setValue($oDmsNota->getServicoCodigoServico());
          $oForm->s_observacao->setValue($oDmsNota->getDescricaoServico());
          $oForm->s_codigo_obra->setValue($oDmsNota->getServicoCodigoObra());
          $oForm->s_art->setValue($oDmsNota->getServicoArt());
          $oForm->s_informacoes_complementares->setValue($oDmsNota->getServicoInformacoesComplementares());
        }

        $this->view->iCompetenciaMes = $iMes;
        $this->view->iCompetenciaAno = $iAno;
        $this->view->oForm           = $oForm;
      } catch (Exception $oError) {
        $this->view->messages[] = array('error' => $this->translate->_($oError->getMessage()));
      }
  }

  /**
   * Verifica se ja existe uma nota com o numero e se tem AIDOF [Json]
   *
   * @return boolean
   */
  public function emissaoManualSaidaVerificarDocumentoAction() {

    parent::noLayout();

    try {

      // Parâmetros request
      $iTipoDocumento = $this->getRequest()->getParam('tipo_documento', NULL);
      $sNumeroNota    = $this->getRequest()->getParam('s_nota', NULL);
      $iIdDmsNota     = $this->getRequest()->getParam('id', NULL);

      if ($iTipoDocumento) {

        // Verifica a quantidade de Aidof disponivel para o tipo de documento
        $oAidof            = new Administrativo_Model_Aidof();
        $iQtdeAidofEmissao = $oAidof->getQuantidadesNotasEmissao($this->oContribuinte->getInscricaoMunicipal(),
                                                                 $iTipoDocumento);

        // Verifica Requisicoes de AIDOF
        if (!$iIdDmsNota && $iQtdeAidofEmissao <= 0) {

          $sUrlRequisicao = $this->view->serverUrl('/contribuinte/dms/requisicao');

          $aRetornoJson['status']  = FALSE;
          $aRetornoJson['error'][] = 'O limite para emissão de notas foi atingido para este tipo de documento, ';
          $aRetornoJson['error'][] = "<a href='" . $sUrlRequisicao . "'>clique aqui</a> ";
          $aRetornoJson['error'][] = 'para emitir uma nova requisição.';

          echo $this->getHelper('json')->sendJson($aRetornoJson);

          return FALSE;
        }

        // Valida numeracao repetida
        if ($sNumeroNota) {

          $lNotaEmitida = Contribuinte_Model_DmsNota::checarNotaEmitida($this->oContribuinte,
                                                                        $iTipoDocumento,
                                                                        $sNumeroNota,
                                                                        $iIdDmsNota);

          if ($lNotaEmitida) {

            $sMensagemErro           = $this->translate->_('Já existe um documento com o número %s.');
            $aRetornoJson['status']  = FALSE;
            $aRetornoJson['error'][] = sprintf($sMensagemErro, $sNumeroNota);

            echo $this->getHelper('json')->sendJson($aRetornoJson);

            return FALSE;
          }

          if (!$oAidof->verificarNumeracaoValidaParaEmissaoDocumento($this->oContribuinte->getInscricaoMunicipal(),
                                                                     $sNumeroNota, $iTipoDocumento)
          ) {

            $sMensagemErro           = 'O número do documento está fora do intervalo permitido nas requisições.';
            $aRetornoJson['status']  = FALSE;
            $aRetornoJson['error'][] = $this->translate->_($sMensagemErro);

            echo $this->getHelper('json')->sendJson($aRetornoJson);

            return FALSE;
          }
        }
      }

      return TRUE;
    } catch (Exception $e) {

      $aRetorno['erro'] = TRUE;
      $aRetorno['mensagem'] = $e->getMessage();

      echo $this->getHelper('json')->sendJson($aRetorno);
      return FALSE;
    }
  }

  /**
   * Verifica se ja existe uma nota com o numero e se tem AIDOF [Json]
   *
   * @return boolean
   */
  public function emissaoManualSaidaVerificarDocumentoPrestadorEventualAction() {

    parent::noLayout();

    $sTipoDocumento   = $this->getRequest()->getParam('tipo_documento_descricao', NULL);
    $sNumeroDocumento = $this->getRequest()->getParam('s_nota', NULL);
    $sSerieDocumento  = $this->getRequest()->getParam('s_serie_nota', NULL);
    $iIdDocumento     = $this->getRequest()->getParam('id', NULL);

    if ($sTipoDocumento && $sNumeroDocumento) {

      $lNotaEmitida = Contribuinte_Model_DmsNota::checarNotaEmitidaPrestadorEventual($this->oContribuinte,
                                                                                     $sTipoDocumento,
                                                                                     $sNumeroDocumento,
                                                                                     $sSerieDocumento,
                                                                                     $iIdDocumento);

      if ($lNotaEmitida) {

        $sMensagemErro           = $this->translate->_('Já existe um documento com o número %s');
        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = sprintf($sMensagemErro, $sNumeroDocumento);

        echo $this->getHelper('json')->sendJson($aRetornoJson);

        return FALSE;
      }
    }

    return TRUE;
  }

  /**
   * Acao Salvar DMS
   *
   * @return boolean
   */
  public function emissaoManualSaidaSalvarAction() {

    // Perfil do usuario logado
    $iIdPerfil = $this->oUsuario->getPerfil()->getId();

    // Dados Request
    $aDados = $this->getRequest()->getParams();

    // Prestador eventual
    if ($iIdPerfil == 6) {
      $oForm = new Contribuinte_Form_DmsSaidaEventual();
    } else {
      $oForm = new Contribuinte_Form_DmsSaida();
    }

    // Popula o formulario
    $oForm->populate($aDados);

    // Valida o formulario
    if ($oForm->isValid($aDados)) {

      // Verifica se ja existe uma nota com o numero e se tem AIDOF
      self::emissaoManualSaidaVerificarDocumentoAction();

      // Valida se a data da nota esta no mes corrente
      $oValidaDataNota = new DBSeller_Validator_DateCurrentMonth();
      $oValidaDataNota->setMes($aDados['mes_comp']);
      $oValidaDataNota->setAno($aDados['ano_comp']);

      if (!$oValidaDataNota->isValid($aDados['s_nota_data'])) {

        $aErros                  = $oValidaDataNota->getMessages();
        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $aErros[$oValidaDataNota::COMPETENCIA_INVALIDA];

        echo $this->getHelper('json')->sendJson($aRetornoJson);
        exit;
      }

      // Aplica filtro de mascaras
      $aDados['s_cpf_cnpj'] = $oForm->s_cpf_cnpj->getValue();

      // SALVAR DADOS DA DMS (INI)
      if (isset($aDados['id_dms']) && !empty($aDados['id_dms'])) {
        $oDms = Contribuinte_Model_Dms::getById($aDados['id_dms']);
      } else {

        $oDms = new Contribuinte_Model_Dms();
        $oDms->setAnoCompetencia($aDados['ano_comp']);
        $oDms->setMesCompetencia($aDados['mes_comp']);
        $oDms->setOperacao(Contribuinte_Model_Dms::SAIDA);
      }

      if (!is_object($oDms)) {

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $this->translate->_('Código DMS não encontrado.');

        echo $this->getHelper('json')->sendJson($aRetornoJson);
        exit;
      }

      $oDms->setIdContribuinte($this->oContribuinte->getIdUsuarioContribuinte());
      $oDms->setIdUsuario($this->usuarioLogado->getId());
      $oDms->setDataOperacao(new DateTime());
      $oDms->setStatus('aberto');
      // SALVAR DADOS DA DMS (FIM)

      // SALVAR DADOS DA NOTA (INI)
      if (isset($aDados['id']) && !empty($aDados['id'])) {
        $oDmsNota = Contribuinte_Model_DmsNota::getById($aDados['id']);
      } else {
        $oDmsNota = new Contribuinte_Model_DmsNota();
      }

      if (!is_object($oDmsNota)) {

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $this->translate->_('Código Dms Nota não encontrado.');

        echo $this->getHelper('json')->sendJson($aRetornoJson);
        exit;
      }

      // Dados Nota
      $oDataNota = new DateTime(str_replace('/', '-', $aDados['s_nota_data']));
      $oDataNota->format('Y-m-d');
      $oDmsNota->setNotaNumero($aDados['s_nota']);
      $oDmsNota->setNotaSerie($aDados['s_nota_serie']);
      $oDmsNota->setNotaData($oDataNota);
      $oDmsNota->setSituacaoDocumento($aDados['situacao_documento']);
      $oDmsNota->setNaturezaOperacao($aDados['natureza_operacao']);
      $oDmsNota->setEmiteGuia(TRUE);
      $oDmsNota->setServicoImpostoRetido(FALSE);

      // Verifica o flag para substituição tributária
      if (isset($aDados['s_imposto_retido']) && $aDados['s_imposto_retido'] == 1) {
        $oDmsNota->setServicoImpostoRetido(TRUE);
      }

      // Prestador eventual
      if ($iIdPerfil != 6) {

        $oGrupoDocumento = Contribuinte_Model_Nota::getTipoNota($aDados['tipo_documento']);

        $oDmsNota->setGrupoDocumento($oGrupoDocumento->codigo_grupo);
        $oDmsNota->setTipoDocumento($aDados['tipo_documento']);

        /*
         * Verifica se emite guia:
         *   Se a natureza da operacao for 2 (fora da prefeitura) não emite guia
         *   Se for substituto tributário (retido pelo tomador) não emite guia
         */
        if ($aDados['natureza_operacao'] == 2 || $aDados['s_imposto_retido']) {
          $oDmsNota->setEmiteGuia(FALSE);
        } else {

          // Configura o parametro para emitir a guia
          $oChecaEmissaoGuiaStdClass                      = new stdClass();
          $oChecaEmissaoGuiaStdClass->data                = $aDados['s_nota_data'];
          $oChecaEmissaoGuiaStdClass->inscricao_municipal = $this->oContribuinte->getInscricaoMunicipal();

          $oDmsNota->setEmiteGuia(Contribuinte_Model_EmissorGuia::checarEmissaoGuia($oChecaEmissaoGuiaStdClass));
        }
      } else {
        $oDmsNota->setTipoDocumentoDescricao($aDados['tipo_documento_descricao']);
      }

      // Dados Servico
      $oDataServico = new DateTime(str_replace('/', '-', $aDados['s_data']));
      $oDataServico->format('Y-m-d');

      // Formatando dados
      $sServicoValorPagar             = DBSeller_Helper_Number_Format::toFloat($aDados['s_valor_bruto']);
      $sServicoValorDeducao           = DBSeller_Helper_Number_Format::toFloat($aDados['s_valor_deducao']);
      $sServicoValorCondicionado      = DBSeller_Helper_Number_Format::toFloat($aDados['s_vl_condicionado']);
      $sServicoDescontoIncondicionado = DBSeller_Helper_Number_Format::toFloat($aDados['s_vl_desc_incondicionado']);
      $sServicoAliquota               = DBSeller_Helper_Number_Format::toFloat($aDados['s_aliquota']);
      $sServicoBaseCalculo            = DBSeller_Helper_Number_Format::toFloat($aDados['s_base_calculo']);
      $sServicoValorImposto           = DBSeller_Helper_Number_Format::toFloat($aDados['s_valor_imposto']);
      $sServicoValorLiquido           = DBSeller_Helper_Number_Format::toFloat($aDados['s_valor_pagar']);

      // Populando o documento de dms
      $oDmsNota->setNumpre(0);
      $oDmsNota->setServicoData($oDataServico);
      $oDmsNota->setServicoImpostoRetido($aDados['s_imposto_retido']);
      $oDmsNota->setServicoValorPagar($sServicoValorPagar);
      $oDmsNota->setServicoValorDeducao($sServicoValorDeducao);
      $oDmsNota->setServicoValorCondicionado($sServicoValorCondicionado);
      $oDmsNota->setServicoDescontoIncondicionado($sServicoDescontoIncondicionado);
      $oDmsNota->setServicoAliquota($sServicoAliquota);
      $oDmsNota->setServicoBaseCalculo($sServicoBaseCalculo);
      $oDmsNota->setServicoValorImposto($sServicoValorImposto);
      $oDmsNota->setServicoValorLiquido($sServicoValorLiquido);
      $oDmsNota->setServicoCodigoCnae($aDados['s_dados_cod_cnae']);
      $oDmsNota->setServicoCodigoServico($aDados['s_servico_prestado']);
      $oDmsNota->setDescricaoServico($aDados['s_observacao']);
      $oDmsNota->setServicoCodigoObra($aDados['s_codigo_obra']);
      $oDmsNota->setServicoArt($aDados['s_art']);
      $oDmsNota->setServicoInformacoesComplementares($aDados['s_informacoes_complementares']);

      // Dados Prestador eventual
      if ($iIdPerfil == 6) {

        $oDadosPrestador = Contribuinte_Model_ContribuinteEventual::getById(
                                                                  $this->oContribuinte->getIdUsuarioContribuinte()
        );

        // Salva o código CNAE do serviço quando for prestador eventual
        $aServicoPrestado = Contribuinte_Model_Servico::getByCodServico($aDados['s_servico_prestado'], FALSE);
        $oServicoPrestado = is_array($aServicoPrestado) ? reset($aServicoPrestado) : $aServicoPrestado;

        $oDmsNota->setServicoCodigoCnae($oServicoPrestado->attr('estrut_cnae'));
      } else {
        $oDadosPrestador = Contribuinte_Model_Contribuinte::getById($this->oContribuinte->getIdUsuarioContribuinte());
      }

      $oDmsNota->setPrestadorCpfCnpj($oDadosPrestador->getCgcCpf());
      $oDmsNota->setPrestadorInscricaoMunicipal($oDadosPrestador->getInscricaoMunicipal());
      $oDmsNota->setPrestadorInscricaoEstadual($oDadosPrestador->getInscricaoEstadual());
      $oDmsNota->setPrestadorRazaoSocial($oDadosPrestador->getNome());
      $oDmsNota->setPrestadorNomeFantasia($oDadosPrestador->getNomeFantasia());
      $oDmsNota->setPrestadorEnderecoRua($oDadosPrestador->getDescricaoLogradouro());
      $oDmsNota->setPrestadorEnderecoNumero($oDadosPrestador->getLogradouroNumero());
      $oDmsNota->setPrestadorEnderecoComplemento($oDadosPrestador->getLogradouroComplemento());
      $oDmsNota->setPrestadorEnderecoBairro($oDadosPrestador->getLogradouroBairro());
      $oDmsNota->setPrestadorEnderecoCodigoMunicipio($oDadosPrestador->getCodigoIbgeMunicipio());
      $oDmsNota->setPrestadorEnderecoEstado($oDadosPrestador->getEstado());
      $oDmsNota->setPrestadorEnderecoCodigoPais($oDadosPrestador->getCodigoPais());
      $oDmsNota->setPrestadorEnderecoCEP($oDadosPrestador->getCep());
      $oDmsNota->setPrestadorTelefone($oDadosPrestador->getTelefone());
      $oDmsNota->setPrestadorEmail($oDadosPrestador->getEmail());
      $oDmsNota->setIdUsuario($this->usuarioLogado->getId());
      $oDmsNota->setIdContribuinte($this->oContribuinte->getIdUsuarioContribuinte());

      // Dados Tomador
      if ($aDados['s_cpf_cnpj'] != NULL) {
        $oDadosTomador = Contribuinte_Model_Empresa::getByCgcCpf($aDados['s_cpf_cnpj']);
      }

      if ($aDados['s_imposto_retido'] && (!isset($oDadosTomador) || !isset($oDadosTomador->eCidade))) {

        $sMensagem          = 'Tomador com CPF/CNPJ %s não cadastrado.';
        $sMensagemParametro = '"<b>' . $this->getRequest()->getParam('s_cpf_cnpj') . '</b>"';

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['fields']  = array_keys($oForm->getMessages());
        $aRetornoJson['error'][] = sprintf($this->translate->_($sMensagem), $sMensagemParametro);

        echo $this->getHelper('json')->sendJson($aRetornoJson);
        exit;
      }

      if (isset($oDadosTomador) && is_object($oDadosTomador) && isset($oDadosTomador->eCidade)) {

        $oDadosTomadorEcidade = $oDadosTomador->eCidade[0];

        $oDmsNota->setTomadorCpfCnpj($aDados['s_cpf_cnpj']);
        $oDmsNota->setTomadorNomeFantasia($oDadosTomadorEcidade->attr('nome_fanta'));
        $oDmsNota->setTomadorRazaoSocial($oDadosTomadorEcidade->attr('nome'));
        $oDmsNota->setTomadorInscricaoMunicipal($oDadosTomadorEcidade->attr('inscricao'));
        $oDmsNota->setTomadorInscricaoEstadual($oDadosTomadorEcidade->attr('inscr_est'));
        $oDmsNota->setTomadorEnderecoRua($oDadosTomadorEcidade->attr('endereco'));
        $oDmsNota->setTomadorEnderecoNumero($oDadosTomadorEcidade->attr('numero'));
        $oDmsNota->setTomadorEnderecoComplemento($oDadosTomadorEcidade->attr('complemento'));
        $oDmsNota->setTomadorEnderecoBairro($oDadosTomadorEcidade->attr('bairro'));
        $oDmsNota->setTomadorEnderecoCodigoMunicipio($oDadosTomadorEcidade->attr('cod_ibge'));
        $oDmsNota->setTomadorEnderecoEstado($oDadosTomadorEcidade->attr('uf'));
        $oDmsNota->setTomadorEnderecoCodigoPais($oDadosTomadorEcidade->attr('cod_pais'));
        $oDmsNota->setTomadorEnderecoCEP($oDadosTomadorEcidade->attr('cep'));
        $oDmsNota->setTomadorTelefone($oDadosTomadorEcidade->attr('telefone'));
        $oDmsNota->setTomadorEmail($oDadosTomadorEcidade->attr('email'));
      } else {

        if ($aDados['s_cpf_cnpj'] && (!isset($oDadosTomador) || !isset($oDadosTomador->eNota))) {

          $oDadosTomadorNFSE               = new Contribuinte_Model_EmpresaBase();
          $aDadosTomador['t_cnpjcpf']      = $aDados['s_cpf_cnpj'];
          $aDadosTomador['t_razao_social'] = $aDados['s_razao_social'];

          $oDadosTomadorNFSE->persist($aDadosTomador);
        }

        $oDmsNota->setTomadorInscricaoMunicipal($aDados['s_inscricao_municipal']);
        $oDmsNota->setTomadorCpfCnpj($aDados['s_cpf_cnpj']);
        $oDmsNota->setTomadorRazaoSocial($aDados['s_razao_social']);
      }

      // Vincula o DMS ao documento
      $oDmsNota->setDms($oDms->getEntity());

      // Adiciona o documento ao DMS
      $oDms->addDmsNotas($oDmsNota->getEntity());

      // Salva o DMS e o Documento
      $iCodigoDms = $oDms->persist();

      // Configura a mensagem de sucesso
      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['success'] = $this->translate->_('Documento lançado com sucesso!');
      $aRetornoJson['id_dms']  = $iCodigoDms;

      // Configura a mensagem para edição
      if (isset($aDados['id']) && $aDados['id']) {

        $aRetornoJson['success'] = $this->translate->_('Documento alterado com sucesso!');
        $aRetornoJson['url']     = $this->view->baseUrl("/contribuinte/dms/emissao-manual-saida/id_dms/{$iCodigoDms}");
      }
    } else {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = $this->translate->_('Preencha os dados corretamente.');
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Tela para escolha da competência na emissão manual de DMS
   */
  public function emissaoManualEntradaCompetenciaAction() {

    $oUri               = $this->_request->getPathInfo();
    $oActiveNav         = $this->view->navigation()->findByUri($oUri);

    if (is_null($oActiveNav)) {
      $oActiveNav = new stdClass();
    }

    $oActiveNav->class  = 'selected';
    $oActiveNav->active = TRUE;

    $oForm = new Contribuinte_Form_DmsCompetencia();
    $oForm->setAction($this->view->baseUrl('/contribuinte/dms/emissao-manual-entrada-lista-dms'));

    $this->view->form = $oForm;
  }

  /**
   * Tela com a lista de DMS de serviços tomados
   */
  public function emissaoManualEntradaListaDmsAction() {

    // Parametros request
    $iMes = $this->getRequest()->getParam('mes');
    $iAno = $this->getRequest()->getParam('ano');

    $oDms = new Contribuinte_Model_Dms();
    $aDms = $oDms->getCompetenciaByCpfCnpj($this->oContribuinte->getCgcCpf(), $iMes, $iAno, $oDms::ENTRADA);

    if (count($aDms) > 0) {

      // Varre a lista de DMS
      foreach ($aDms as $oDms) {

        $fValorDms = 0;

        $sStatus = $oDms->getStatus();

        if ($oDms->getStatus() == 'emitida') {

          $iNumpre        = Contribuinte_Model_DmsNota::getNumpreByIdDms($oDms->getId());
          $sStatusEcidade = Contribuinte_Model_GuiaEcidade::atualizaSituacao($iNumpre, $iMes);

          if ($sStatusEcidade == 'ABERTO') {
            $sStatus = 'Emitida Guia';
          }
        }

        foreach ($oDms->getDmsNotas() as $oNota) {
          $fValorDms += $oNota->getServicoValorImposto();
        }

        // Formata os dados
        $sMesPorExtenso = DBSeller_Helper_Date_Date::mesExtenso($oDms->getMesCompetencia());

        // Lista de DMS para view
        $oDmsView                = new stdClass();
        $oDmsView->id            = $oDms->getId();
        $oDmsView->data_operacao = $oDms->getDataOperacao()->format('d/m/Y');
        $oDmsView->competencia   = "{$sMesPorExtenso}/{$oDms->getAnoCompetencia()}";
        $oDmsView->fechado       = ($oDms->getStatus() == 'fechado');
        $oDmsView->status_guia   = DBSeller_Helper_String_Format::wordsCap($sStatus);
        $oDmsView->valor_imposto = DBSeller_Helper_Number_Format::toMoney($fValorDms, 2, 'R$ ');
        $aResultado[] = $oDmsView;
      }
    }

    // Competencia
    $oCompetencia      = new stdClass();
    $oCompetencia->mes = $iMes;
    $oCompetencia->ano = $iAno;

    // Dados da view
    $this->view->aDms        = isset($aResultado) ? $aResultado : array();
    $this->view->competencia = $oCompetencia;
  }

  /**
   * Altera o status do DMS [Json]
   */
  public function emissaoManualEntradaListaDmsAlterarStatusAction() {

    $aRetornoJson['status'] = FALSE;
    $iIdDms                 = $this->getRequest()->getParam('id_dms', NULL);
    $sStatus                = $this->getRequest()->getParam('status', NULL);

    if (!$iIdDms) {
      $aRetornoJson['error'] = $this->translate->_('Identificador de DMS inválido!');
    } else if (!$sStatus || ($sStatus != 'aberto' && $sStatus != 'fechado' && $sStatus != 'emitido')) {
      $aRetornoJson['error'] = $this->translate->_('Status inválido!');
    } else {

      try {

        $oDms = Contribuinte_Model_Dms::getById($iIdDms);
        $oDms->setStatus($sStatus);
        $oDms->persist();

        $sUrlListaDms = '/contribuinte/dms/emissao-manual-entrada-lista-dms/';
        $sUrlListaDms .= "mes/{$oDms->getMesCompetencia()}/ano/{$oDms->getAnoCompetencia()}";

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('DMS alterado com sucesso!');
        $aRetornoJson['url']     = $this->view->baseUrl($sUrlListaDms);
      } catch (Exception $oErro) {
        $aRetornoJson['error'] = $this->translate->_("Erro ao alterar o DMS: {$oErro->getMessage()}");
      }
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Exclui DMS [Json]
   */
  public function emissaoManualEntradaListaDmsExcluirAction() {

    $aRetornoJson['status'] = FALSE;
    $iIdDms                 = $this->getRequest()->getParam('id_dms', NULL);

    if (!$iIdDms) {
      $aRetornoJson['error'] = $this->translate->_('Identificador de DMS inválido!');
    } else {

      try {

        $oDms = Contribuinte_Model_Dms::getById($iIdDms);
        $oDms->setStatus('Anulada');

        foreach ($oDms->getDmsNotas() as $oDmsNota) {
          $oDmsNota->setStatus(5);
        }

        $oDms->persist();

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('DMS excluído com sucesso!');
      } catch (Exception $oErro) {
        $aRetornoJson['error'] = $this->translate->_("Erro ao excluir o DMS: {$oErro->getMessage()}");
      }
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Visualizacao do DMS Manual
   */
  public function emissaoManualEntradaVisualizarAction() {

    $iIdDms = $this->getRequest()->getParam('id_dms', NULL);

    if (!$iIdDms) {
      throw new Zend_Exception($this->translate->_('Código do DMS não informado.'));
    }

    $oDms = Contribuinte_Model_Dms::getById($iIdDms);

    if (!$oDms) {
      throw new Zend_Exception($this->translate->_('DMS não encontrado.'));
    }

    $this->view->iCompetenciaMes = $oDms->getMesCompetencia();
    $this->view->iCompetenciaAno = $oDms->getAnoCompetencia();
    $this->view->iIdDms          = $iIdDms;
  }

  /**
   * Lista de notas do DMS
   */
  public function emissaoManualEntradaListaNotasAction() {

    parent::noTemplate();

    try {

      $iIdDms      = $this->getRequest()->getParam('id_dms', NULL);
      $lVisualizar = $this->getRequest()->getParam('visualizar', FALSE); // Não mostra os botoes editar/remover na view
      $oDmsNota    = new Contribuinte_Model_DmsNota();

      // Dados da view
      $this->view->visualizar = $lVisualizar;
      $this->view->aDmsNota   = $oDmsNota->getByIdDms($iIdDms);
    } catch (Exception $oError) {
      $this->view->messages[] = array('error' => $this->translate->_($oError->getMessage()));
    }
  }

  /**
   * Emite DMS Manualmente
   */
  public function emissaoManualEntradaAction() {

      try {

        // Parametros request
        $iIdDms     = $this->getRequest()->getParam('id_dms', NULL);
        $iIdDmsNota = $this->getRequest()->getParam('id_nota', NULL);
        $iMes       = $this->getRequest()->getParam('mes', NULL);
        $iAno       = $this->getRequest()->getParam('ano', NULL);

        // Formulário e dados do contribuinte
        $oForm         = new Contribuinte_Form_DmsEntrada();
        $oContribuinte = $this->_session->contribuinte;

        // Se o contribuinte for eventual e pessoa física não pode reter o imposto
        if ($oContribuinte instanceof Contribuinte_Model_ContribuinteEventual && strlen($oContribuinte->getCgcCpf()) < 14) {

          $oElementoImpostoRetido = $oForm->getElement('s_imposto_retido');
          $oElementoImpostoRetido->setAttrib('id', 's_imposto_retido_eventual');
          $oElementoImpostoRetido->setAttrib('readonly', 'readonly');
        }

        // Se informado o parâmetro mês preenche no formulário
        if ($iMes) {
          $oForm->getElement('mes_comp')->setValue($iMes);
        }

        // Se informado o parâmetro ano preenche no formulário
        if ($iAno) {
          $oForm->getElement('ano_comp')->setValue($iAno);
        }

        // Configura os dados quando for alteração de DMS
        if ($iIdDms) {

          $oDms = Contribuinte_Model_Dms::getById($iIdDms);
          $iMes = $oDms->getMesCompetencia();
          $iAno = $oDms->getAnoCompetencia();

          // Preenche o formulario
          $oForm->getElement('id_dms')->setValue($iIdDms);
          $oForm->getElement('mes_comp')->setValue($iMes);
          $oForm->getElement('ano_comp')->setValue($iAno);

          // Dados da view
          $this->view->oDms = $oDms;
        }

        // Carrega Dados Nota quando for alteração do documento de DMS
        if ($iIdDmsNota) {

          $oDmsNota = Contribuinte_Model_DmsNota::getById($iIdDmsNota);

          // Dados Tomador
          $oForm->getElement('id')->setValue($iIdDmsNota);
          $oForm->getElement('s_nota_data')->setValue($oDmsNota->getNotaData()->format('d/m/Y'));
          $oForm->getElement('s_nota')->setValue($oDmsNota->getNotaNumero());
          $oForm->getElement('s_nota_serie')->setValue($oDmsNota->getNotaSerie());
          $oForm->getElement('s_cpf_cnpj')->setValue($oDmsNota->getPrestadorCpfCnpj());
          $oForm->getElement('s_razao_social')->setValue($oDmsNota->getPrestadorRazaoSocial());
          $oForm->setTipoDocumento($oDmsNota->getTipoDocumento());
          $oForm->setSituacaoDocumento($oDmsNota->getSituacaoDocumento());
          $oForm->setNaturezaOperacao($oDmsNota->getNaturezaOperacao());

          // Formata os dados do serviço
          $sData                = $oDmsNota->getServicoData()->format('d/m/Y');
          $sImpostoRetido       = DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoImpostoRetido());
          $sValorBruto          = DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoValorPagar());
          $sValorDeducao        = DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoValorDeducao());
          $sValorCondicionado   = DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoValorCondicionado());
          $sValorIncondicionado = DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoDescontoIncondicionado());
          $sValorAliquota       = DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoAliquota());
          $sValorBaseCalculo    = DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoBaseCalculo());
          $sValorImposto        = DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoValorImposto());
          $sValorPagar          = DBSeller_Helper_Number_Format::toMoney($oDmsNota->getServicoValorLiquido());

          // Dados do servico
          $oForm->getElement('s_data')->setValue($sData);
          $oForm->getElement('s_imposto_retido')->setValue($sImpostoRetido);
          $oForm->getElement('s_valor_bruto')->setValue($sValorBruto);
          $oForm->getElement('s_valor_deducao')->setValue($sValorDeducao);
          $oForm->getElement('s_vl_condicionado')->setValue($sValorCondicionado);
          $oForm->getElement('s_vl_desc_incondicionado')->setValue($sValorIncondicionado);
          $oForm->getElement('s_aliquota')->setValue($sValorAliquota);
          $oForm->getElement('s_base_calculo')->setValue($sValorBaseCalculo);
          $oForm->getElement('s_valor_imposto')->setValue($sValorImposto);
          $oForm->getElement('s_valor_pagar')->setValue($sValorPagar);
          $oForm->getElement('s_dados_cod_cnae')->setValue($oDmsNota->getServicoCodigoCnae());
          $oForm->getElement('s_observacao')->setValue($oDmsNota->getDescricaoServico());
          $oForm->getElement('s_imposto_retido')->setValue($oDmsNota->getServicoImpostoRetido());
          $oForm->getElement('s_codigo_obra')->setValue($oDmsNota->getServicoCodigoObra());
          $oForm->getElement('s_art')->setValue($oDmsNota->getServicoArt());
          $oForm->getElement('s_informacoes_complementares')->setValue($oDmsNota->getServicoInformacoesComplementares());
        }

        // Dados da view
        $this->view->iCompetenciaMes = $iMes;
        $this->view->iCompetenciaAno = $iAno;
        $this->view->oForm           = $oForm;

      } catch (Exception $oError) {
        $this->view->messages[] = array('error' => $this->translate->_($oError->getMessage()));
      }
  }

  /**
   * Verifica se ja existe uma nota com o numero [Json]
   *
   * @return boolean
   */
  public function emissaoManualEntradaVerificarDocumentoAction() {

    parent::noLayout();

    // Parametros request
    $sCnpjPrestador   = $this->getRequest()->getParam('s_cpf_cnpj', NULL);
    $iTipoDocumento   = $this->getRequest()->getParam('tipo_documento', NULL);
    $sNumeroDocumento = $this->getRequest()->getParam('s_nota', NULL);
    $iIdNota          = $this->getRequest()->getParam('id', NULL);

    // Valida numeracao repetida
    if ($iTipoDocumento && $sNumeroDocumento && $sCnpjPrestador) {

      // Parametros para consultar se o documento já existe na base de dados
      $sCnpjPrestador               = DBSeller_Helper_Number_Format::getNumbers($sCnpjPrestador); // Limpa mascara
      $oParametro                   = new stdClass();
      $oParametro->oContribuinte    = $this->oContribuinte;
      $oParametro->sCnpjPrestador   = $sCnpjPrestador;
      $oParametro->iTipoDocumento   = $iTipoDocumento;
      $oParametro->sNumeroDocumento = $sNumeroDocumento;
      $oParametro->iCodigoDocumento = $iIdNota;
      $lNotaEmitida                 = Contribuinte_Model_DmsNota::checarDocumentoEmitidoServicosTomados($oParametro);

      if ($lNotaEmitida) {

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $this->translate->_("Já existe um documento com o número {$sNumeroDocumento}.");

        echo $this->getHelper('json')->sendJson($aRetornoJson);

        return FALSE;
      }
    }

    return TRUE;
  }

  /**
   * Acao Salvar DMS Entrada
   *
   * @return mixed bool|json
   */
  public function emissaoManualEntradaSalvarAction() {

    // Dados Request
    $aDados = $this->getRequest()->getParams();

    // Formulario
    $oForm = new Contribuinte_Form_DmsEntrada();
    $oForm->populate($aDados);

    // Valida o formulario
    if ($oForm->isValid($aDados)) {

      // Verifica se ja existe uma nota com o numero e se tem AIDOF
      self::emissaoManualEntradaVerificarDocumentoAction();

      // Valida se a data da nota esta no mes corrente
      $oValidaDataNota = new DBSeller_Validator_DateCurrentMonth();
      $oValidaDataNota->setMes($aDados['mes_comp']);
      $oValidaDataNota->setAno($aDados['ano_comp']);

      if (!$oValidaDataNota->isValid($aDados['s_nota_data'])) {

        $aErros                  = $oValidaDataNota->getMessages();
        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $aErros[$oValidaDataNota::COMPETENCIA_INVALIDA];

        echo $this->getHelper('json')->sendJson($aRetornoJson);
        exit;
      }

      // Aplica filtro de mascaras
      $aDados['s_cpf_cnpj'] = $oForm->getElement('s_cpf_cnpj')->getValue();

      // SALVAR DADOS DA DMS (INI)
      if (isset($aDados['id_dms']) && !empty($aDados['id_dms'])) {
        $oDms = Contribuinte_Model_Dms::getById($aDados['id_dms']);
      } else {

        $oDms = new Contribuinte_Model_Dms();
        $oDms->setAnoCompetencia($aDados['ano_comp']);
        $oDms->setMesCompetencia($aDados['mes_comp']);
        $oDms->setOperacao('e');
      }

      if (!is_object($oDms)) {

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $this->translate->_('Código DMS não encontrado.');

        echo $this->getHelper('json')->sendJson($aRetornoJson);
        exit;
      }

      $oDms->setDataOperacao(new DateTime());
      $oDms->setStatus('aberto');
      $oDms->setIdContribuinte($this->oContribuinte->getIdUsuarioContribuinte());
      $oDms->setIdUsuario($this->usuarioLogado->getId());
      // SALVAR DADOS DA DMS (FIM)

      // SALVAR DADOS DA NOTA (INI)
      if (isset($aDados['id']) && !empty($aDados['id'])) {
        $oDmsNota = Contribuinte_Model_DmsNota::getById($aDados['id']);
      } else {
        $oDmsNota = new Contribuinte_Model_DmsNota();
      }

      if (!is_object($oDmsNota)) {

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $this->translate->_('Código Dms Nota não encontrado.');

        echo $this->getHelper('json')->sendJson($aRetornoJson);
        exit;
      }

      // Dados Nota
      $oGrupoDocumento = Contribuinte_model_nota::getTipoNota($aDados['tipo_documento']);

      $oDataNota = new DateTime(str_replace('/', '-', $aDados['s_nota_data']));
      $oDataNota->format('Y-m-d');
      $oDmsNota->setNotaNumero($aDados['s_nota']);
      $oDmsNota->setNotaSerie($aDados['s_nota_serie']);
      $oDmsNota->setNotaData($oDataNota);
      $oDmsNota->setGrupoDocumento($oGrupoDocumento->codigo_grupo);
      $oDmsNota->setTipoDocumento($aDados['tipo_documento']);
      $oDmsNota->setSituacaoDocumento($aDados['situacao_documento']);
      $oDmsNota->setNaturezaOperacao($aDados['natureza_operacao']);
      $oDmsNota->setEmiteGuia(TRUE);
      $oDmsNota->setServicoImpostoRetido($aDados['s_imposto_retido'] == 1);

      // Se a natureza da operação for 2 (fora da prefeitura), NÃO emite guia
      if ($aDados['natureza_operacao'] == 2) {
        $oDmsNota->setEmiteGuia(FALSE);
      }

      // Dados Servico
      $oDataServico = new DateTime(str_replace('/', '-', $aDados['s_data']));
      $oDataServico->format('Y-m-d');

      // Formata dados
      $sServicoValorPagar             = DBSeller_Helper_Number_Format::toDataBase($aDados['s_valor_bruto']);
      $sServicoValorDeducao           = DBSeller_Helper_Number_Format::toDataBase($aDados['s_valor_deducao']);
      $sServicoValorCondicionado      = DBSeller_Helper_Number_Format::toDataBase($aDados['s_vl_condicionado']);
      $sServicoDescontoIncondicionado = DBSeller_Helper_Number_Format::toDataBase($aDados['s_vl_desc_incondicionado']);
      $sServicoAliquota               = str_replace(',', '.', $aDados['s_aliquota']);
      $sServicoBaseCalculo            = DBSeller_Helper_Number_Format::toDataBase($aDados['s_base_calculo']);
      $sServicoValorImposto           = DBSeller_Helper_Number_Format::toDataBase($aDados['s_valor_imposto']);
      $sServicoValorLiquido           = DBSeller_Helper_Number_Format::toDataBase($aDados['s_valor_pagar']);

      // Seta os dados do Documento de DMS
      $oDmsNota->setNumpre(0);
      $oDmsNota->setServicoData($oDataServico);
      $oDmsNota->setServicoImpostoRetido($aDados['s_imposto_retido']);
      $oDmsNota->setServicoValorPagar($sServicoValorPagar);
      $oDmsNota->setServicoValorDeducao($sServicoValorDeducao);
      $oDmsNota->setServicoValorCondicionado($sServicoValorCondicionado);
      $oDmsNota->setServicoDescontoIncondicionado($sServicoDescontoIncondicionado);
      $oDmsNota->setServicoAliquota($sServicoAliquota);
      $oDmsNota->setServicoBaseCalculo($sServicoBaseCalculo);
      $oDmsNota->setServicoValorImposto($sServicoValorImposto);
      $oDmsNota->setServicoValorLiquido($sServicoValorLiquido);
      $oDmsNota->setDescricaoServico($aDados['s_observacao']);
      $oDmsNota->setServicoCodigoObra($aDados['s_codigo_obra']);
      $oDmsNota->setServicoArt($aDados['s_art']);
      $oDmsNota->setServicoInformacoesComplementares($aDados['s_informacoes_complementares']);

      if ($this->oContribuinte->getInscricaoMunicipal()) {

        $oDadosTomador = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal(
                                                        $this->oContribuinte->getInscricaoMunicipal());
      } else {
        $oDadosTomador = Contribuinte_Model_ContribuinteEventual::getByCpfCnpj($this->oContribuinte->getCgcCpf());
      }

      $oDmsNota->setTomadorCpfCnpj($oDadosTomador->getCgcCpf());
      $oDmsNota->setTomadorInscricaoMunicipal($oDadosTomador->getInscricaoMunicipal());
      $oDmsNota->setTomadorInscricaoEstadual($oDadosTomador->getInscricaoEstadual());
      $oDmsNota->setTomadorRazaoSocial($oDadosTomador->getNome());
      $oDmsNota->setTomadorNomeFantasia($oDadosTomador->getNomeFantasia());
      $oDmsNota->setTomadorEnderecoRua($oDadosTomador->getDescricaoLogradouro());
      $oDmsNota->setTomadorEnderecoNumero($oDadosTomador->getLogradouroNumero());
      $oDmsNota->setTomadorEnderecoComplemento($oDadosTomador->getLogradouroComplemento());
      $oDmsNota->setTomadorEnderecoBairro($oDadosTomador->getLogradouroBairro());
      $oDmsNota->setTomadorEnderecoCodigoMunicipio($oDadosTomador->getCodigoIbgeMunicipio());
      $oDmsNota->setTomadorEnderecoEstado($oDadosTomador->getEstado());
      $oDmsNota->setTomadorEnderecoCodigoPais($oDadosTomador->getCodigoPais());
      $oDmsNota->setTomadorEnderecoCEP($oDadosTomador->getCep());
      $oDmsNota->setTomadorTelefone($oDadosTomador->getTelefone());
      $oDmsNota->setTomadorEmail($oDadosTomador->getEmail());

      // Dados Prestador
      if ($this->_session->contribuinte->getCgcCpf() != DBSeller_Helper_Number_Format::getNumbers($aDados['s_cpf_cnpj'])) {

        $oDadosPrestador = Contribuinte_Model_Empresa::getByCgcCpf($aDados['s_cpf_cnpj']);

        if (empty($oDadosPrestador->eCidade)) {

        // Se não for cadastrado no eCidade, salva prestador no NFSE
          if (empty($oDadosPrestador->eNota) && !empty($aDados['s_cpf_cnpj'])) {

            $aDadosPrestador['t_cnpjcpf']      = $aDados['s_cpf_cnpj'];
            $aDadosPrestador['t_razao_social'] = $aDados['s_razao_social'];
            $oDadosPrestadorNota               = new Contribuinte_Model_EmpresaBase();
            $oDadosPrestadorNota->persist($aDadosPrestador);
          }

          $oDmsNota->setPrestadorCpfCnpj($aDados['s_cpf_cnpj']);
          $oDmsNota->setPrestadorRazaoSocial($aDados['s_razao_social']);
        } else {

          $oDadosPrestadorEcidade = $oDadosPrestador->eCidade[0];
          $oDmsNota->setPrestadorCpfCnpj($aDados['s_cpf_cnpj']);
          $oDmsNota->setPrestadorNomeFantasia($oDadosPrestadorEcidade->attr('nome_fanta'));
          $oDmsNota->setPrestadorRazaoSocial($oDadosPrestadorEcidade->attr('nome'));
          $oDmsNota->setPrestadorInscricaoMunicipal($oDadosPrestadorEcidade->attr('inscricao'));
          $oDmsNota->setPrestadorInscricaoEstadual($oDadosPrestadorEcidade->attr('inscr_est'));
          $oDmsNota->setPrestadorEnderecoRua($oDadosPrestadorEcidade->attr('endereco'));
          $oDmsNota->setPrestadorEnderecoNumero($oDadosPrestadorEcidade->attr('numero'));
          $oDmsNota->setPrestadorEnderecoComplemento($oDadosPrestadorEcidade->attr('complemento'));
          $oDmsNota->setPrestadorEnderecoBairro($oDadosPrestadorEcidade->attr('bairro'));
          $oDmsNota->setPrestadorEnderecoCodigoMunicipio($oDadosPrestadorEcidade->attr('cod_ibge'));
          $oDmsNota->setPrestadorEnderecoEstado($oDadosPrestadorEcidade->attr('uf'));
          $oDmsNota->setPrestadorEnderecoCodigoPais($oDadosPrestadorEcidade->attr('cod_pais'));
          $oDmsNota->setPrestadorEnderecoCEP($oDadosPrestadorEcidade->attr('cep'));
          $oDmsNota->setPrestadorTelefone($oDadosPrestadorEcidade->attr('telefone'));
          $oDmsNota->setPrestadorEmail($oDadosPrestadorEcidade->attr('email'));
        }

        $oDmsNota->setIdUsuario($this->usuarioLogado->getId());
        $oDmsNota->setIdContribuinte($this->oContribuinte->getIdUsuarioContribuinte());
        $oDmsNota->setDms($oDms->getEntity());

      // Adiciona o documento ao DMS
        $oDms->addDmsNotas($oDmsNota->getEntity());

      // Salva o DMS e o documento
        $iCodigoDms = $oDms->persist();

      // Configura a mensagem de retorno
        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('Documento lançado com sucesso!');
        $aRetornoJson['id_dms']  = $iCodigoDms;

      // Quando for alteração, configura a mensagem de alteração
        if (isset($aDados['id']) && $aDados['id']) {

          $sUrlDmsAlterado = "/contribuinte/dms/emissao-manual-entrada/id_dms/{$iCodigoDms}";

          $aRetornoJson['success'] = $this->translate->_('Documento alterado com sucesso!');
          $aRetornoJson['url']     = $this->view->baseUrl($sUrlDmsAlterado);
        }

      } else {
        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['fields']  = array_keys($oForm->getMessages());
        $aRetornoJson['error'][] = $this->translate->_('Não é possível informar o próprio CNPJ/CPF!');
      }
    } else {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = $this->translate->_('Preencha os dados corretamente.');
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Exclui Nota da DMS [Json]
   */
  public function emissaoManualListaNotasExcluirAction() {

    $aRetornoJson['status'] = FALSE;
    $iIdDmsNota             = $this->getRequest()->getParam('id_dms_nota', NULL);

    if (!$iIdDmsNota) {
      $aRetornoJson['error'] = $this->translate->_('Identificador inválido!');
    } else {

      try {

        $oDmsNota = Contribuinte_Model_DmsNota::getById($iIdDmsNota);
        $oDmsNota->destroy();

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('Documento excluído com sucesso!');
      } catch (Exception $oErro) {
        $aRetornoJson['error'] = sprintf($this->translate->_('Erro ao excluir o documento: %s'), $oErro->getMessage());
      }
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Busca a aliquota por servico [Json]
   */
  public function emissaoManualBuscarDadosServicoAction() {
    try {
      // Perfil do usuario
      $iIdPerfil    = $this->oUsuario->getPerfil()->getId();
      $iIdServico   = $this->getParam('id_servico');
      $aRetornoJson = array();

      // Ignora se for prestador eventual
      if ($iIdPerfil != 6) {

        $aServicos = Contribuinte_Model_Servico::getByIm($this->oContribuinte->getInscricaoMunicipal(), FALSE);

        if (is_array($aServicos)) {

          foreach ($aServicos as $oServico) {

            if ($oServico->attr('cod_atividade') == $iIdServico) {

              $aRetornoJson = array(
                'item_servico'     => $oServico->attr('desc_item_servico'),
                'cod_item_servico' => $oServico->attr('cod_item_servico'),
                'estrut_cnae'      => $oServico->attr('estrut_cnae'),
                'deducao'          => $oServico->attr('deducao'),
                'aliq'             => DBSeller_Helper_Number_Format::toMoney($oServico->attr('aliq'))
              );
              break;
            }
          }
        }
      }

      echo $this->getHelper('json')->sendJson($aRetornoJson);
    } catch (Exception $e) {

      $aRetorno['erro'] = TRUE;

      if ($e->getCode() == Global_Lib_Model_WebService::CODIGO_ERRO_CONSULTA_WEBSERVICE){
        $aRetorno['mensagem'] = "E-cidade temporariamente insdisponível. Emissão bloqueada!";
      } else {
        $aRetorno['mensagem'] = $e->getMessage();
      }

      echo $this->getHelper('json')->sendJson($aRetorno);
    }
  }

  /**
   * Calcula valores [Json]
   */
  public function emissaoManualCalculaValoresDmsAction() {

    // Parametros
    $lTomadorRetemImposto         = $this->getRequest()->getParam('s_imposto_retido', 1);
    $fValorServico                = $this->getRequest()->getParam('s_valor_bruto', 0);
    $fValorDeducao                = $this->getRequest()->getParam('s_valor_deducao', 0);
    $fValorDescontoCondicionado   = $this->getRequest()->getParam('s_vl_condicionado', 0);
    $fValorDescontoIncondicionado = $this->getRequest()->getParam('s_vl_desc_incondicionado', 0);
    $fPercentualAliquota          = $this->getRequest()->getParam('s_aliquota', 0);

    $aValidacaoValores = Contribuinte_Model_Dms::emissaoManualCalculaValoresDms($lTomadorRetemImposto,
                                                                                $fValorServico,
                                                                                $fValorDeducao,
                                                                                $fValorDescontoCondicionado,
                                                                                $fValorDescontoIncondicionado,
                                                                                $fPercentualAliquota);

    echo $this->getHelper('json')->sendJson($aValidacaoValores);
  }

  /**
   * Metodo para verificar os parametros da empresa
   * testes:
   * 1 - empresa emissora de dms
   * 2 - empresa prestadora de serviços
   *
   * @param integer
   * @return boolean
   */
  private function verificaParametrosEmpresa($iInscricaoMunicipal) {

    $oServicos         = Contribuinte_Model_Servico::getByIm($iInscricaoMunicipal, FALSE);
    $oRetorno          = new stdClass();
    $oRetorno->lStatus = TRUE;

    if ($this->view->contribuinte && ($oServicos == NULL || empty($oServicos))) {

      $oRetorno->sMensagem = 'Empresa não prestadora de serviços.';
      $oRetorno->lStatus   = TRUE;
    }

    if (!$this->view->contribuinte) {

      $oRetorno->sMensagem = 'Empresa não emissora de DMS.';
      $oRetorno->lStatus   = TRUE;
    }

    return $oRetorno;
  }

  /**
   * Documentação para importação de arquivos
   */
  public function importacaoDocumentacaoAction() {

    parent::noTemplate();

    $sFormato = $this->getRequest()->getParam('formato', 'html');

    $oTiposDocumento             = new Contribuinte_Model_Nota();
    $this->view->aTiposDocumento = $oTiposDocumento->getDescricaoTipoNota($oTiposDocumento::GRUPO_NOTA_DMS);

    // Ordena por código os tipos de documento
    asort($this->view->aTiposDocumento);

    // Gera o pdf
    if ($sFormato == 'pdf') {

      $sHtml = $this->view->render('dms/importacao-documentacao.phtml');
      $this->renderPdf($sHtml, 'Documentação para Importação de DMS', array('format' => 'A4'));
    }
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

      if (!$sData) {
        throw new Exception('Informe a data para verificar.');
      }

      $oDataSimples = new DateTime(DBSeller_Helper_Date_Date::invertDate($sData, '-'));

      if (!$oDataSimples instanceof DateTime) {
        throw new Exception('Data inválida');
      }

      $oContribuinte      = $this->_session->contribuinte;
      $aRetorno['status'] = $oContribuinte->isOptanteSimples($oDataSimples) ? TRUE : FALSE;

      echo $this->getHelper('json')->sendJson($aRetorno);
    } catch (Exception $e) {

      $aRetorno['erro'] = TRUE;

      if ($e->getCode() == Global_Lib_Model_WebService::CODIGO_ERRO_CONSULTA_WEBSERVICE){
        $aRetorno['mensagem'] = "E-cidade temporariamente insdisponível. Emissão bloqueada!";
      } else {
        $aRetorno['mensagem'] = $e->getMessage();
      }

      echo $this->getHelper('json')->sendJson($aRetorno);
    }
  }
}