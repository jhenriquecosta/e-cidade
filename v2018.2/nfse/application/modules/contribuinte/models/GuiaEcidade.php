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
 * Classe responsável pela comunicacao com o Ecidade dos dados referentes as Guias geradas para pagamento do ISS
 */
class Contribuinte_Model_GuiaEcidade {

  const SERVICO_TOMADO       = 'e';
  const SERVICO_PRESTADO     = 's';
  const TIPO_DEBITO_VARIAVEL = 'P';
  const TIPO_DEBITO_RETIDO   = 'T';

  /**
   * Gera a guia do prestador no eCidade
   *
   * @param                                $oContribuinte
   * @param Contribuinte_Model_Competencia $oCompetencia
   * @param DateTime                       $oDataPagamento
   * @param bool                           $lGerarPdf
   * @return mixed
   */
  public static function gerarGuiaNFSE($oContribuinte,
                                       Contribuinte_Model_Competencia $oCompetencia,
                                       DateTime $oDataPagamento,
                                       $lGerarPdf = TRUE) {

    try {

      $iMesCompetencia      = $oCompetencia->getMesComp();
      $iAnoCompetencia      = $oCompetencia->getAnoComp();
      $aNotas               = $oCompetencia->getNotas();
      $sDataPagamento       = $oDataPagamento->format('d/m/Y');
      $oUsuarioContribuinte = Administrativo_Model_UsuarioContribuinte::getById($oContribuinte->getIdUsuarioContribuinte());

      $oDoctrine = Zend_Registry::get('em');
      $oDoctrine->getConnection()->beginTransaction();

      // Salva guia antes de ser gerada
      $oGuia = new Contribuinte_Model_Guia();
      $oGuia->gerarGuiaPrestador($oContribuinte, $oCompetencia, $oDataPagamento);

      $oGuiaGerar = self::montaDadosGuia($oUsuarioContribuinte,
                                         $iAnoCompetencia,
                                         $iMesCompetencia,
                                         $aNotas,
                                         $sDataPagamento,
                                         $oGuia->getId(),
                                         Contribuinte_Model_GuiaEcidade::TIPO_DEBITO_VARIAVEL);

      $oGuiaGerada = NULL;
      $oGuiaGerada = self::gerarGuia($oGuiaGerar,
                                     $sDataPagamento,
                                     Contribuinte_Model_GuiaEcidade::TIPO_DEBITO_VARIAVEL);

      // Complementa a guia com os dados retornados do webservice
      $oGuia->complementaGuiaPrestador($oGuiaGerada);

      if ($lGerarPdf) {
        $oGuiaGerada->arquivo_guia = Contribuinte_Model_GuiaEcidade::salvarPdf($oGuiaGerada->debito->dados_boleto->arquivo_guia,
                                                                               'guia_substituto');
      }

      $oDoctrine->getConnection()->commit();
      return $oGuiaGerada;
    } catch (Exception $oError) {

      $oDoctrine->getConnection()->rollback();
      throw new Exception($oError->getMessage());
    }
  }

  /**
   * Gera a guia de DES-IF no eCidade
   *
   * @param Contribuinte_Model_Contribuinte $oContribuinte
   * @param                                 $iAnoCompetencia
   * @param                                 $iMesCompetencia
   * @param DateTime                        $oDataPagamento
   * @param                                 $fAliquota
   * @param bool                            $lGerarPdf
   * @return bool
   * @throws Exception
   */
  public static function gerarGuiaDesif(Contribuinte_Model_Contribuinte $oContribuinte,
                                        $iAnoCompetencia,
                                        $iMesCompetencia,
                                        DateTime $oDataPagamento,
                                        $fAliquota = NULL,
                                        $lGerarPdf = TRUE) {


    // Verifica se já possui uma guia emitida
    $lTemGuiaEmitida = Contribuinte_Model_Guia::existeGuia($oContribuinte,
                                                           $iMesCompetencia,
                                                           $iAnoCompetencia,
                                                           Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE);

    if ($lTemGuiaEmitida) {
      throw new Exception('Guia já emitida.');
    }

    $aReceitasDesif = Contribuinte_Model_ImportacaoDesif::getTotalReceitasCompetencia($oContribuinte,
                                                                                      $iAnoCompetencia,
                                                                                      $iMesCompetencia,
                                                                                      $fAliquota);

    $sDataPagamento       = $oDataPagamento->format('d/m/Y');
    $oUsuarioContribuinte = Administrativo_Model_UsuarioContribuinte::getById($oContribuinte->getIdUsuarioContribuinte());

    $oValidateDate  = new Zend_Validate_Date();
    $sData          = DBSeller_Helper_Date_Date::invertDate($sDataPagamento);
    $sDataValidacao = DBSeller_Helper_Date_Date::invertDate($sDataPagamento, '');

    if ($sDataValidacao < date('Ymd')) {
      throw new Exception('Informe uma data posterior a data atual!');
    }

    if ($oValidateDate->isValid($sDataPagamento)) {
      $oData = new DateTime($sData);
    } else {
      throw new Exception('Informe uma data para pagamento válida!');
    }

    /**
     * Alterado o parametro de envio do cpf_cnpj para o e-cidade pois não estava sendo passado corretamente.
     */
    $iCpfCnpj = $oUsuarioContribuinte->getCnpjCpf();
    $iCpf     = strlen($iCpfCnpj) == 11 ? $iCpfCnpj : NULL;
    $iCnpj    = strlen($iCpfCnpj) == 14 ? $iCpfCnpj : NULL;

    $oGuiaGerar                            = new StdClass();
    $oGuiaGerar->id_importacao_desif       = $aReceitasDesif->id_importacao_desif;
    $oGuiaGerar->id_importacao_desif_conta = $aReceitasDesif->id_importacao_desif_conta;
    $oGuiaGerar->inscricao_municipal       = $oUsuarioContribuinte->getIm();
    $oGuiaGerar->cpf                       = $iCpf;
    $oGuiaGerar->cnpj                      = $iCnpj;
    $oGuiaGerar->numcgm                    = $oUsuarioContribuinte->getCgm();
    $oGuiaGerar->mes_competencia           = $iMesCompetencia;
    $oGuiaGerar->ano_competencia           = $iAnoCompetencia;
    $aListaReceitas                        = array();

    foreach ($aReceitasDesif->aliquotas_issqn as $fAliquota => $aDadosReceita) {

      $sNumeroNotaFiscal = date('YmdHs', time())
                         . $aReceitasDesif->id_importacao_desif
                         . str_replace('.', '', $fAliquota);

      $oReceita                         = new stdClass();
      $oReceita->numero_nota_fiscal     = $sNumeroNotaFiscal;
      $oReceita->codigo_documento       = $aReceitasDesif->id_importacao_desif;
      $oReceita->data_nota_fiscal       = $aReceitasDesif->data_importacao->format('Y-m-d');
      $oReceita->serie_nota_fiscal      = NULL;
      $oReceita->valor_base_calculo     = $aDadosReceita['total_receita'];
      $oReceita->valor_deducao          = 0;
      $oReceita->valor_imposto_retido   = $aDadosReceita['total_iss'];
      $oReceita->valor_servico_prestado = $aDadosReceita['total_receita'];
      $oReceita->aliquota               = $fAliquota;
      $oReceita->data_pagamento         = $sDataPagamento;
      $oReceita->retido                 = $aDadosReceita['total_iss'];
      $oReceita->situacao               = 1;
      $oReceita->status                 = 1;
      $oReceita->servico_prestado       = 'Receita Importada Desif';
      $oReceita->cnpj_prestador         = $oUsuarioContribuinte->getCnpjCpf();
      $oReceita->inscricao_prestador    = $oUsuarioContribuinte->getIm();
      $oReceita->nome                   = $oContribuinte->getNome();
      $oReceita->operacao               = 2;

      $aListaReceitas[] = $oReceita;
    }

    $oGuiaGerar->notas = $aListaReceitas;
    $aDados            = array(
      'planilha'       => $oGuiaGerar,
      'data_pagamento' => $oData->format('Y-m-d'),
      'tipo_debito'    => Contribuinte_Model_GuiaEcidade::TIPO_DEBITO_VARIAVEL
    );

    $oGuiaGerada = WebService_Model_Ecidade::processar('geraDebitoIssContribribuinte', $aDados);

    $oGuiaGerada->id_importacao_desif = $aReceitasDesif->id_importacao_desif;

    $oGuia = new Contribuinte_Model_Guia();
    $oGuia->gerarGuiaDesifPrestador($oContribuinte, $oGuiaGerada, $iAnoCompetencia, $iMesCompetencia, $oDataPagamento);

    $sArquivoGuiaPdf = $oGuiaGerada->debito->dados_boleto->arquivo_guia;

    if ($lGerarPdf) {
      $oGuiaGerada->arquivo_guia = Contribuinte_Model_GuiaEcidade::salvarPdf($sArquivoGuiaPdf, 'guia_substituto');
    }

    return $oGuiaGerada;
  }

  /**
   * Metodo responsavel por criar as guias dms do prestador
   *
   * @param Contribuinte_Model_Dms $oDms
   * @param                        $sDataPagamento
   * @return StdClass
   */
  public static function gerarGuiaDmsPrestador(Contribuinte_Model_Dms $oDms, $sDataPagamento) {

    try {

      $oDoctrine = Zend_Registry::get('em');
      $oDoctrine->getConnection()->beginTransaction();

      $aNotas = array();

      foreach ($oDms->getDmsNotas() as $oDadosNota) {

        $oNota = new Contribuinte_Model_DmsNota($oDadosNota);

        // Ignora notas prestadas e retidas pelo tomador
        if ($oDms->getOperacao() == 's' && $oNota->getServicoImpostoRetido() == TRUE) {
          continue;
        }

        // Ignora notas tomadas e retidas pelo tomador
        if ($oDms->getOperacao() == 'e' && $oNota->getServicoImpostoRetido() == FALSE) {
          continue;
        }

        // Ignora notas anuladas, extraviadas ou canceladas
        if ($oNota->getStatus() == 5 || in_array($oNota->getSituacaoDocumento(), array('E', 'C'))) {
          continue;
        }

        // Ignora notas isentas
        if ($oNota->getEmiteGuia() == FALSE) {
          continue;
        }

        // Ignora notas com aliquota ou servico zerados
        if (floatval($oNota->getServicoAliquota()) <= 0) {
          continue;
        } else if (floatval($oNota->getServicoValorImposto()) <= 0) {
          continue;
        }

        $aNotas[$oNota->getId()] = $oNota;
      }

      $iMesCompetencia      = $oDms->getMesCompetencia();
      $iAnoCompetencia      = $oDms->getAnoCompetencia();
      $oUsuarioContribuinte = Administrativo_Model_UsuarioContribuinte::getById($oDms->getIdContribuinte());
      $oContribuinte  = Administrativo_Model_UsuarioContribuinte::getContribuinte($oDms->getIdContribuinte());

      // Salva guia antes de ser gerada no e-cidade
      $oGuia          = new Contribuinte_Model_Guia();
      $sDataPagamentoGuia = DBSeller_Helper_Date_Date::invertDate($sDataPagamento);
      $oGuia->gerarGuiaDmsPrestador($oContribuinte, new DateTime($sDataPagamentoGuia), $iMesCompetencia,
                                    $iAnoCompetencia);

      // Envia Guia para o e-cidade
      $oGuiaGerar = self::montaDadosGuia($oUsuarioContribuinte,
                                         $iAnoCompetencia,
                                         $iMesCompetencia,
                                         $aNotas,
                                         $sDataPagamento,
                                         $oGuia->getId(),
                                         self::TIPO_DEBITO_RETIDO);

      $oGuiaGerada = self::gerarGuia($oGuiaGerar,
                                     $sDataPagamento,
                                     self::TIPO_DEBITO_RETIDO);

      $oDms->setCodigoPlanilha($oGuiaGerada->codigo_planilha);
      $oDms->setStatus('emitida');

      $aDadosNotas  = $oGuiaGerar->notas;
      $aDadosNotas += $oGuiaGerada->notas;

      foreach ($aDadosNotas as $oNotaProcessada) {

        $iCodigoPlanilha = $oGuiaGerada->codigo_planilha;
        if (isset($oNotaProcessada->codigo_nota_planilha) && !is_null($oNotaProcessada->codigo_nota_planilha)) {
          $iCodigoPlanilha = $oNotaProcessada->codigo_nota_planilha;
        }

        $oNota = $aNotas[$oNotaProcessada->codigo_documento];
        $oNota->setCodigoNotaPlanilha($iCodigoPlanilha);
        $oNota->setNumpre($oGuiaGerada->debito_planilha);
      }

      $oDms->persist();

      $oGuia->complementaGuiaDmsPrestador($oGuiaGerada->debito, $oDms);

      $oGuiaGerada->arquivo_guia = self::salvarPdf($oGuiaGerada->debito->dados_boleto->arquivo_guia, 'guia_substituto');

      $oDoctrine->getConnection()->commit();
      return $oGuiaGerada;

    } catch (Exception $oError) {

      $oDoctrine->getConnection()->rollback();
      return $oError->getMessage();
    }
  }

  /**
   * Remite a guia no eCidade
   *
   * @param object   $oGuia
   * @param dateTime $oData
   * @return object
   */

  public static function reemitirGuia($oGuia, $oData) {

    if (is_string($oData)) {
      $oData = new DateTime($oData);
    }

    $aDados  = array(
      'numero_debito'  => $oGuia->getNumpre(),
      'parcela_debito' => $oGuia->getMesComp(),
      'data'           => $oData->format('Y-m-d')
    );

    $oRetornoWebService               = WebService_Model_Ecidade::processar('reemitirGuia', $aDados);
    $oRetornoWebService->arquivo_guia = self::salvarPdf($oRetornoWebService->arquivo_guia, 'reemissao');

    return $oRetornoWebService;
  }

  /**
   * Gera a planilha de retencao no eCidade
   *
   * @param integer $iCpfCnpj
   * @param integer $iInscricaoMunicipal
   * @param integer $iAnoCompetencia
   * @param integer $iMesCompetencia
   * @throws Exception
   * @return integer
   */
  public static function gerarPlanilhaRetencao($iCpfCnpj, $iInscricaoMunicipal, $iAnoCompetencia, $iMesCompetencia) {

    throw new Exception('Metodo Deprecated Contribuinte_Model_GuiaEcidade::gerarPlanilhaRetencao');
    /*
    $iCpf  = strlen($iCpfCnpj) == 11 ? $iCpfCnpj : NULL;
    $iCnpj = strlen($iCpfCnpj) == 14 ? $iCpfCnpj : NULL;

    $aDados          = array(
      'cpf'               => $iCpf,
      'cnpj'              => $iCnpj,
      'inscricao_tomador' => $iInscricaoMunicipal,
      'competencia_ano'   => $iAnoCompetencia,
      'competencia_mes'   => $iMesCompetencia
    );
    $iCodigoPlanilha = Contribuinte_Lib_Model_WebService::processar('gerarPlanilhaRetencao', $aDados);

    return $iCodigoPlanilha;
    */
  }

  /**
   * Lanca a planilha de retencao no eCidade
   *
   * @param $iCodigoPlanilha
   * @param $oNota
   * @param $dData
   * @param $dServico
   * @return mixed
   * @throws Exception
   */
  public static function lancarPlanilhaRetencao($iCodigoPlanilha, $oNota, $dData, $dServico) {

    throw new Exception('Metodo Deprecated Contribuinte_Model_GuiaEcidade::lancarPlanilhaRetencao');
    /*
    $aDados = array(
      'cod_planilha'           => $iCodigoPlanilha,
      'cnpj_prestador'         => $oNota->getP_cnpjcpf(),
      'inscricao_prestador'    => $oNota->getP_im(),
      'nome'                   => $oNota->getP_razao_social(),
      'numero_nf'              => $oNota->getNota(),
      'data_nf'                => $oNota->getDt_nota()->format('Y-m-d'),
      'servico_prestado'       => $dServico, //$dServico,
      'valor_servico_prestado' => $oNota->getS_vl_servicos(),
      'valor_deducao'          => $oNota->getS_vl_deducoes(),
      'valor_base_calculo'     => $oNota->getS_vl_bc(),
      'aliquota'               => $oNota->getS_vl_aliquota(),
      'valor_imposto_retido'   => $oNota->getS_vl_iss(),
      'ano_competencia'        => $oNota->getAno_comp(),
      'mes_competencia'        => $oNota->getMes_comp(),
      'data_pagamento'         => $dData->format('Y-m-d'),
      'retido'                 => TRUE
    );

    return parent::processar('lancarPlanilhaRetencao', $aDados);
    */
  }

  /**
   * Lançamento dos valores das receitas na planilha
   *
   * @param $oDms
   * @param $oDmsNota
   * @param $dDataPagamento
   * @return mixed
   * @throws Exception
   */
  public static function lancarPlanilhaDmsRetencao($oDms, $oDmsNota, $dDataPagamento) {

    throw new Exception('Metodo Deprecated Contribuinte_Model_GuiaEcidade::lancarPlanilhaDmsRetencao');
    /*
    $aDadosPlanilhaRetencao = array(
      'codigo_nota_planilha'   => $oDmsNota->getCodigoNotaPlanilha(),
      'codigo_planilha'        => $oDms->getCodigoPlanilha(),
      'ano_competencia'        => $oDms->getAnoCompetencia(),
      'mes_competencia'        => $oDms->getMesCompetencia(),
      'numero_nf'              => $oDmsNota->getNotaNumero(),
      'data_nf'                => $oDmsNota->getNotaData()->format('Y-m-d'),
      'valor_base_calculo'     => $oDmsNota->getServicoBaseCalculo(),
      'valor_deducao'          => $oDmsNota->getServicoValorDeducao(),
      'valor_imposto_retido'   => $oDmsNota->getServicoValorImposto(),
      'valor_servico_prestado' => $oDmsNota->getServicoValorPagar(),
      'aliquota'               => $oDmsNota->getServicoAliquota(),
      'data_pagamento'         => $dDataPagamento,
      'retido'                 => (bool) $oDmsNota->getServicoImpostoRetido(),
      'situacao'               => $oDmsNota->getSituacaoDocumento() == 'N' ? 0 : 1,
      'status'                 => 1,
      'servico_prestado'       => $oDmsNota->getDescricaoServico(),
    );
    if ($oDms->getOperacao() == self::SERVICO_PRESTADO) {

      $aDadosPlanilhaRetencao['cnpj_prestador']      = $oDmsNota->getTomadorCpfCnpj();
      $aDadosPlanilhaRetencao['inscricao_prestador'] = $oDmsNota->getTomadorInscricaoMunicipal();
      $aDadosPlanilhaRetencao['nome']                = $oDmsNota->getTomadorRazaoSocial();
      $aDadosPlanilhaRetencao['operacao']            = 2;
    } else {

      $aDadosPlanilhaRetencao['operacao']            = 1;
      $aDadosPlanilhaRetencao['cnpj_prestador']      = $oDmsNota->getPrestadorCpfCnpj();
      $aDadosPlanilhaRetencao['inscricao_prestador'] = $oDmsNota->getPrestadorInscricaoMunicipal();
      $aDadosPlanilhaRetencao['nome']                = $oDmsNota->getPrestadorRazaoSocial();
    }

    return Contribuinte_Lib_Model_WebService::processar('lancarPlanilhaRetencao', $aDadosPlanilhaRetencao);
    */
  }

  /**
   * Anula os valores das receitas na planilha do eCidade
   *
   * @param $iCodigoNotaPlanilha
   * @return mixed
   */
  public static function anularPlanilhaDmsRetencao($iCodigoNotaPlanilha) {

    $aDadosPlanilhaRetencao = array(
      'codigo_nota_planilha' => $iCodigoNotaPlanilha
    );

    return WebService_Model_Ecidade::processar('anularNotaPlanilhaRetencao', $aDadosPlanilhaRetencao);
  }

  /**
   * Gera a guia do tomador no eCidade
   *
   * @param $iCodigoPlanilha
   * @deprecated
   * @return mixed
   * @throws Exception
   */
  public static function gerarGuiaTomador($iCodigoPlanilha) {

    DBSeller_Plugin_Notificacao::addErro('Metodo Deprecated Contribuinte_Model_GuiaEcidade::gerarGuiaTomador');
    throw new Exception('Metodo Deprecated Contribuinte_Model_GuiaEcidade::gerarGuiaTomador');
    /*
    $oData                            = new DateTime();
    $aDados                           = array(
      'codigo_planilha' => $iCodigoPlanilha,
      'data'            => $oData->format('Y-m-d')
    );
    $oRetornoWebService               = Contribuinte_Lib_Model_WebService::processar('gerarGuiaTomador', $aDados);
    $oRetornoWebService->arquivo_guia = self::salvarPdf($oRetornoWebService->arquivo_guia, 'guia_substituto');

    return $oRetornoWebService;
    */
  }

  /**
   * Atualiza a situação da guia no eCidade
   *
   * @param Integer $iNumpre
   * @param Integer $iNumpar
   * @return null
   */
  public static function atualizaSituacao($iNumpre, $iNumpar) {

    $aFiltros  = array(
      'numpre' => $iNumpre,
      'numpar' => $iNumpar
    );
    $aCampos   = array(
      'status'
    );

    $aSituacao = WebService_Model_Ecidade::consultar('getSituacaoGuia', array($aFiltros, $aCampos));

    if (!is_array($aSituacao)) {

      DBSeller_Plugin_Notificacao:addErro('W0010', 'Houve um erro no retorno do WebService do E-cidade');
      return NULL;
    }

    return (isset($aSituacao[0]->status)) ? $aSituacao[0]->status : NULL;
  }

  /**
   * Salva o PDF gerado
   *
   * @param $sArquivoBase64
   * @param $sNomeArquivo
   * @return mixed <null, object>
   */
  private static function salvarPdf($sArquivoBase64, $sNomeArquivo) {

    $sArquivo = tempnam(TEMP_PATH . '/', $sNomeArquivo) . '.pdf';
    fopen($sArquivo, "wb+");
    file_put_contents($sArquivo, base64_decode($sArquivoBase64));
    $tmp = explode('/', $sArquivo);
    $oArquivo = end($tmp);

    return $oArquivo;
  }

  /**
   * Anula planilha de retenção no eCidade
   *
   * @param integer $iCodigoPlanilha
   * @param string  $sMotivo
   * @return object
   */

  public static function anularPlanilha($iCodigoPlanilha, $sMotivo) {

    $aDados   = array(
      'motivo_anulacao' => $sMotivo,
      'codigo_planilha' => $iCodigoPlanilha
    );
    $sRetorno = WebService_Model_Ecidade::processar('anularPlanilhaRetencao', $aDados);

    return $sRetorno;
  }

  /**
   * Gera as guias de pagamento
   *
   * @param  object                                   $oGuiaGerar
   * @param  string                                   $sDataPagamento
   * @param  string                                   $sTipoDebito
   * @return mixed
   * @throws Exception
   */
  public static function gerarGuia($oGuiaGerar,
                                   $sDataPagamento,
                                   $sTipoDebito = self::TIPO_DEBITO_VARIAVEL) {

    $oValidateDate  = new Zend_Validate_Date();
    $sData          = DBSeller_Helper_Date_Date::invertDate($sDataPagamento);
    $sDataValidacao = DBSeller_Helper_Date_Date::invertDate($sDataPagamento, '');

    if ($sDataValidacao < date('Ymd')) {
      throw new Exception('Informe uma data posterior a data atual!');
    }

    if ($oValidateDate->isValid($sDataPagamento)) {
      $oData = new DateTime($sData);
    } else {
      throw new Exception('Informe uma data para pagamento válida!');
    }

    $aDados            = array(
      'planilha'       => $oGuiaGerar,
      'data_pagamento' => $oData->format('Y-m-d'),
      'tipo_debito'    => $sTipoDebito
    );

    $oRetorno = WebService_Model_Ecidade::processar('geraDebitoIssContribribuinte', $aDados);

    return $oRetorno;
  }

  /**
   * Pesquisa a situação da guia informando um conjunto de numpre e numpar
   *
   * @param $aDadosSituacao
   * @return array
   * @throws Exception
   */
  public static function pesquisaSituacaoGuias($aDadosSituacao) {

    // Verifica se foi informado uma coleção de numpre, numpar para consultar a situação
    if (!is_array($aDadosSituacao)) {
      throw new Exception('Informe os dados da guia para consultar a situação!');
    }

    $aParametros      = array('aDadosSituacao' => $aDadosSituacao);
    $aRetornoSituacao = WebService_Model_Ecidade::processar('PesquisaSituacaoGuias', $aParametros);

    return $aRetornoSituacao;
  }

  /**
   * Prepara os dados da guia a ser gerada
   *
   * @param  Administrativo_Model_UsuarioContribuinte $oContribuinte
   * @param  int                                      $iAnoCompetencia
   * @param  int                                      $iMesCompetencia
   * @param  array                                    $aNotas
   * @param  int                                      $iIdGuia
   * @param  GuiaEcidade::TIPO_DEBITO_RETIDO          $iTipoDebito
   * @return object                                   $oGuiaGerar
   */
  public static function montaDadosGuia(Administrativo_Model_UsuarioContribuinte $oContribuinte,
                                        $iAnoCompetencia,
                                        $iMesCompetencia,
                                        $aNotas,
                                        $sDataPagamento,
                                        $iIdGuia,
                                        $iTipoDebito = self::TIPO_DEBITO_VARIAVEL) {

    $sData = DBSeller_Helper_Date_Date::invertDate($sDataPagamento);
    $oData = new DateTime($sData);

    $oGuiaGerar                      = new StdClass();
    $oGuiaGerar->inscricao_municipal = $oContribuinte->getIm();
    $oGuiaGerar->cpf_cnpj            = $oContribuinte->getCnpjCpf();
    $oGuiaGerar->numcgm              = $oContribuinte->getCgm();
    $oGuiaGerar->mes_competencia     = $iMesCompetencia;
    $oGuiaGerar->ano_competencia     = $iAnoCompetencia;
    $oGuiaGerar->codigo_guia         = $iIdGuia;
    $aListaNotas                     = array();

    foreach ($aNotas as $oDocumentoNota) {

      $oNota                         = new stdClass();
      $oNota->numero_nota_fiscal     = $oDocumentoNota->getNotaNumero();
      $oNota->codigo_documento       = $oDocumentoNota->getId();
      $oNota->data_nota_fiscal       = $oDocumentoNota->getNotaData()->format('Y-m-d');
      $oNota->serie_nota_fiscal      = $oDocumentoNota->getNotaSerie();
      $oNota->valor_base_calculo     = $oDocumentoNota->getServicoBaseCalculo();
      $oNota->valor_deducao          = $oDocumentoNota->getServicoValorDeducao();
      $oNota->valor_imposto_retido   = $oDocumentoNota->getServicoValorImposto();
      $oNota->valor_servico_prestado = $oDocumentoNota->getServicoValorPagar();
      $oNota->aliquota               = $oDocumentoNota->getServicoAliquota();
      $oNota->data_pagamento         = $oData->format('Y-m-d');
      $oNota->retido                 = $oDocumentoNota->getServicoImpostoRetido();

      // Se for guia de DMS
      if ($iTipoDebito == self::TIPO_DEBITO_RETIDO) {
        $oNota->situacao = '3';
      } else {
        $oNota->situacao               = $oDocumentoNota->getSituacaoDocumento() == 'N' ? '0' : '1';
      }

      $oNota->status                 = 1;
      $oNota->servico_prestado       = urlencode($oDocumentoNota->getDescricaoServico());

      // Serviços prestados
      if ($oDocumentoNota->getOperacao() == self::SERVICO_PRESTADO) {

        $oNota->cnpj_prestador      = $oDocumentoNota->getPrestadorCpfCnpj();
        $oNota->inscricao_prestador = $oDocumentoNota->getPrestadorInscricaoMunicipal();
        $oNota->nome                = urlencode($oDocumentoNota->getPrestadorRazaoSocial());
        $oNota->operacao            = 2;
      } else {

        $oNota->cnpj_prestador      = $oDocumentoNota->getTomadorCpfCnpj();
        $oNota->inscricao_prestador = $oDocumentoNota->getTomadorInscricaoMunicipal();
        $oNota->nome                = urlencode($oDocumentoNota->getTomadorRazaoSocial());
        $oNota->operacao            = 1;

        // Se for uma guia de DMS
        if ($iTipoDebito == self::TIPO_DEBITO_RETIDO) {

          $oNota->cnpj_prestador      = $oDocumentoNota->getPrestadorCpfCnpj();;
          $oNota->inscricao_prestador = $oDocumentoNota->getPrestadorInscricaoMunicipal();
          $oNota->nome                = urlencode($oDocumentoNota->getPrestadorRazaoSocial());

          // Busca dados do e-Cidade para ver se a empresa está cadastrada no municipio
          $aEmpresa = Contribuinte_Model_EmpresaEcidade::getByCgcCpf($oDocumentoNota->getPrestadorCpfCnpj());

          // Verificação feita para solucionar momentaneamente o problema com os contribuintes que não possuem cadastro de CGM do e-cidade.
          if (!empty($aEmpresa)) {

            $oNota->cnpj_prestador      = $oDocumentoNota->getPrestadorCpfCnpj();
            $oNota->inscricao_prestador = $oDocumentoNota->getPrestadorInscricaoMunicipal();
            $oNota->nome                = urlencode($oDocumentoNota->getPrestadorRazaoSocial());
          }
        }
      }

      // Limita para o tamanho do campo no ecidade
      if (strlen($oNota->nome) > 60) {
        $oNota->nome = substr($oNota->nome, 57) . '...';
      }

      // Adiciona a nota na lista
      $aListaNotas[] = $oNota;
    }

    $oGuiaGerar->notas = $aListaNotas;

    return $oGuiaGerar;
  }
}
