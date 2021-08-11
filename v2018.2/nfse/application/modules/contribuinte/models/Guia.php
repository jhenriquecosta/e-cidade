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
 * Emissão da guia de notas
 *
 * @package Contribuinte/Model
 *
 */

use \Doctrine\ORM\Query\ResultSetMapping;
class Contribuinte_Model_Guia extends Contribuinte_Lib_Model_Doctrine {

  static protected $className = __CLASS__;
  static protected $entityName = 'Contribuinte\Guia';

  /**
   * Situação do débito como é salvo no banco de dados do NFSE
   *
   * @var array
   */
  static public $SITUACAO = array(
    'a' => 'Em aberto',
    'p' => 'Paga',
    'c' => 'Cancelado',
    'v' => 'Inscrito em Dívida',
    'd' => 'Prescrita',
    'x' => ''
  );

  static public $ABERTA = 'a';
  static public $PAGA = 'p';
  static public $CANCELADA = 'c';
  static public $PRESCRITA = 'd';
  static public $NULA = 'x';

  /**
   * Tipo da guia
   *
   * @var array
   */
  static public $TIPO = array(
    't' => 'Tomador',
    'p' => 'Contribuinte'
  );

  static public $TOMADOR = 't';
  static public $PRESTADOR = 'p';

  /**
   * Documento de origem NFSe/RPS
   *
   * @var int
   */
  static public $DOCUMENTO_ORIGEM_NFSE = 10;

  /**
   * Documento de origem DMS
   *
   * @var int
   */
  static public $DOCUMENTO_ORIGEM_DMS = 11;

  /**
   * Mapeamento da situação do débito como vem do webservice => como é representado no nfse
   *
   * @var array
   */
  static public $WS_NFSE_SITUACAO = array(
    'ABERTO'    => 'a',
    'PAGO'      => 'p',
    'CANCELADO' => 'c',
    'DIVIDA'    => 'v',
    'PRESCRITO' => 'd',
    ''          => 'x'
  );

  /**
   * Competência relacionada a guia
   *
   * @var int|null
   */
  private $competencia = NULL;

  /**
   * Cria uma nova Instancia da guia, atravez de uma entidade
   *
   * @param Contribuinte\Guia $entity Instancia da entity
   */
  public function __construct(Contribuinte\Guia $entity = NULL) {

    parent::__construct($entity);
  }

  /**
   * Retorna Guia filtrando por mes/ano da competencia, contribuinte e tipo de guia
   *
   * @param  integer                                $iAno
   * @param  integer                                $iMes
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @param                                         $iTipo
   * @return Contribuinte_Model_Guia[]
   */
  public static function getByCompetenciaAndContribuinte($iAno,
                                                         $iMes,
                                                         Contribuinte_Model_ContribuinteAbstract $oContribuinte,
                                                         $iTipo) {

    $oEntityManager = self::getEm();
    $oRepositorio   = $oEntityManager->getRepository(self::$entityName);
    $aResultado     = $oRepositorio->findBy(array(
                                              'id_contribuinte' => $oContribuinte->getContribuintes(),
                                              'ano_comp'        => $iAno,
                                              'mes_comp'        => $iMes,
                                              'tipo'            => $iTipo
                                            ));
    $aRetorno       = array();

    if (is_array($aResultado)) {

      foreach ($aResultado as $oGuia) {
        $aRetorno[] = new self($oGuia);
      }
    }

    return $aRetorno;
  }

  /**
   * Retorna a ultima guia da Nota por contribuinte
   *
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @return Contribuinte_Model_Guia|null
   */
  public static function getUltimaGuiaNota(Contribuinte_Model_ContribuinteAbstract $oContribuinte) {

    $oEntityManager = self::getEm();
    $oRepositorio   = $oEntityManager->getRepository(self::$entityName);
    $aResultado     = $oRepositorio->findBy(array(
                                              'id_contribuinte'       => $oContribuinte->getContribuintes(),
                                              'tipo_documento_origem' => 10
                                            ),
                                            array('id' => 'DESC'),
                                            1);

    if (count($aResultado) > 0) {
      return new Contribuinte_Model_Guia($aResultado[0]);
    }

    return NULL;
  }

  /**
   * Salva Guia no banco de dados
   */
  public function persist() {

    if ($this->getId() == NULL) {
      $this->setDataFechamento(new DateTime());
    }

    if ($this->getVencimento() == NULL) {
      $this->setVencimento(new DateTime());
    }

    $this->getEm()->persist($this->entity);
    $this->getEm()->flush();
  }

  /**
   * Gera guia prestador
   *
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @param Contribuinte_Model_Competencia          $oCompetencia
   * @param DateTime                                $oDataPagamento
   * @return object                                 $this
   */
  public function gerarGuiaPrestador(Contribuinte_Model_ContribuinteAbstract $oContribuinte,
                                     $oCompetencia,
                                     $oDataPagamento) {

    $oDebito = NULL;

    try {

      $this->setNumpre(NULL);
      $this->setAnoComp($oCompetencia->getAnoComp());
      $this->setMesComp($oCompetencia->getMesComp());
      $this->setIdContribuinte($oContribuinte->getIdUsuarioContribuinte());
      $this->setVencimento($oDataPagamento);
      $this->setSituacao(self::$ABERTA);
      $this->setTipo(self::$PRESTADOR);
      $this->setTipoDocumentoOrigem(self::$DOCUMENTO_ORIGEM_NFSE);

      // Adiciona as notas da guia
      $aNotasGuia = $oCompetencia->getNotas();

      foreach ($aNotasGuia as $oNota) {
        $this->addNota($oNota->getEntity());
      }

      $this->persist();

    } catch (Exception $oErro) {

      echo $oErro->getMessage();

    }

    return $this;
  }

  /**
   * Complementa o gastro da guia do prestador NFS-e
   *
   * @param  object $oGuiaGerada
   * @return array
   */
  public function complementaGuiaPrestador($oGuiaGerada) {

    $oDebito = NULL;

    $iCodigoNumpre = $oGuiaGerada->debito_planilha;
    $oDebito       = $oGuiaGerada->debito->dados_boleto;

    $this->setValorCorrigido($oDebito->valor_corrigido);
    $this->setValorHistorico($oDebito->valor_historico);
    $this->setCodigoBarras($oDebito->codigo_barras);
    $this->setLinhaDigitavel($oDebito->linha_digitavel);
    $this->setJurosMulta($oDebito->juros_multa);
    $this->setCodigoGuia($oDebito->codigo_guia);
    $this->setValorOrigem($oDebito->valor_historico);
    $this->setNumpre($iCodigoNumpre);

    foreach ($oGuiaGerada->debito->lista_debitos as $oDebitoNumpre) {

      $this->addNumpre($oDebitoNumpre->numpre);
      $this->setNumpre($oDebitoNumpre->numpre);
    }

    $this->persist();

    return array('objeto' => $this, 'arquivo' => $oDebito->arquivo_guia);
  }

  /**
   * Gera guia de DES-IF
   *
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @param                                         $oGuiaGerada
   * @param                                         $iAno
   * @param                                         $iMes
   * @param                                         $oDataPagamento
   * @return array
   */
  public function gerarGuiaDesifPrestador(Contribuinte_Model_ContribuinteAbstract $oContribuinte,
                                     $oGuiaGerada,
                                     $iAno,
                                     $iMes,
                                     $oDataPagamento) {

    $this->getEm()->beginTransaction();

    $oDebito = NULL;

    try {

      $iCodigoNumpre = $oGuiaGerada->debito_planilha;
      $oDebito       = $oGuiaGerada->debito->dados_boleto;

      $this->setValorCorrigido($oDebito->valor_corrigido);
      $this->setValorHistorico($oDebito->valor_historico);
      $this->setCodigoBarras($oDebito->codigo_barras);
      $this->setLinhaDigitavel($oDebito->linha_digitavel);
      $this->setJurosMulta($oDebito->juros_multa);
      $this->setCodigoGuia($oDebito->codigo_guia);
      $this->setNumpre($iCodigoNumpre);
      $this->setAnoComp($iAno);
      $this->setMesComp($iMes);
      $this->setIdContribuinte($oContribuinte->getIdUsuarioContribuinte());
      $this->setVencimento($oDataPagamento);
      $this->setSituacao(self::$ABERTA);
      $this->setTipo(self::$PRESTADOR);
      $this->setTipoDocumentoOrigem(self::$DOCUMENTO_ORIGEM_NFSE);

      foreach ($oGuiaGerada->debito->lista_debitos as $oDebitoNumpre) {

        $this->addNumpre($oDebitoNumpre->numpre);
        $this->setNumpre($oDebitoNumpre->numpre);
      }

      $this->persist();

      $aSets  = array('guia' => $this->getEntity()->getId());
      $aWhere = array(
        'importacao_desif'       => $oGuiaGerada->id_importacao_desif //,
        //'importacao_desif_conta' => $oGuiaGerada->id_importacao_desif_conta,
      );

      Contribuinte_Model_DesifContaGuia::update($aSets, $aWhere);

      $this->getEm()->commit();
    } catch (Exception $oErro) {

      echo $oErro->getMessage();

      $this->getEm()->rollback();
    }

    return array('objeto' => $this, 'arquivo' => $oDebito->arquivo_guia);
  }

  /**
   * Gera guia de Dms para uma lista de dms
   *
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte   Contribuinte
   * @param DateTime                                $sDataPagamento  Data do pagamento
   * @param integer                                 $iMesCompetencia Mês de compentência
   * @param integer                                 $iAnoCompetencia Ano de compentência
   */
  public function gerarGuiaDmsPrestador(Contribuinte_Model_ContribuinteAbstract $oContribuinte,
                                        $sDataPagamento,
                                        $iMesCompetencia,
                                        $iAnoCompetencia) {

    $this->setAnoComp($iAnoCompetencia);
    $this->setMesComp($iMesCompetencia);
    $this->setIdContribuinte($oContribuinte->getIdUsuarioContribuinte());
    $this->setVencimento($sDataPagamento);
    $this->setSituacao(self::$ABERTA);
    $this->setTipo(self::$PRESTADOR);
    $this->setTipoDocumentoOrigem(self::$DOCUMENTO_ORIGEM_DMS);

    $this->persist();
  }

  /**
   * Complementa os dados da Guia DMS após retornar do webservice
   *
   * @param object                   $oDadosGuia
   * @param Contribuinte_Model_Dms   $oDms
   * @return Contribuinte_Model_Guia $this
   */
  public function complementaGuiaDmsPrestador($oDadosGuia,
                                              Contribuinte_Model_Dms $oDms) {

    $this->setValorCorrigido($oDadosGuia->dados_boleto->valor_corrigido);
    $this->setValorHistorico($oDadosGuia->dados_boleto->valor_historico);
    $this->setCodigoBarras($oDadosGuia->dados_boleto->codigo_barras);
    $this->setLinhaDigitavel($oDadosGuia->dados_boleto->linha_digitavel);
    $this->setJurosMulta($oDadosGuia->dados_boleto->juros_multa);
    $this->setCodigoGuia($oDadosGuia->dados_boleto->codigo_guia);
    $this->setValorOrigem($oDadosGuia->dados_boleto->valor_historico);
    $this->addDms($oDms->getEntity());

    foreach ($oDadosGuia->lista_debitos as $oDebito) {

      $this->addNumpre($oDebito->numpre);
      $this->setNumpre($oDebito->numpre);
    }

    $this->persist();
    return $this;
  }

  /**
   * Rotina para reemissão de uma guia
   *
   * @param string|DateTime $uData
   * @return array
   */
  public function reemitir($uData) {

    if ($uData == '') {
      $oData = new DateTime();
    } else if ($uData instanceof DateTime) {
      $oData = $uData;
    } else {
      $oData = parent::stringToDate($uData);
    }

    $aGuiaWebService = Contribuinte_Model_GuiaEcidade::reemitirGuia($this, $oData);

    $this->setValorCorrigido($aGuiaWebService->valor_corrigido);
    $this->setValorHistorico($aGuiaWebService->valor_historico);
    $this->setCodigoBarras($aGuiaWebService->codigo_barras);
    $this->setLinhaDigitavel($aGuiaWebService->linha_digitavel);
    $this->setJurosMulta($aGuiaWebService->juros_multa);
    $this->setCodigoGuia($aGuiaWebService->codigo_guia);

    $aNumpre = each($aGuiaWebService->debitos_guia);

    $this->setNumpre($aNumpre['value']->iNumpre);
    $this->setVencimento($oData);
    $this->persist();

    return array('objeto' => $this, 'arquivo' => $aGuiaWebService->arquivo_guia);
  }

  /**
   * Gera guia para substituto tributário
   *
   * @param $notas
   * @param $data
   * @return array
   */
  public function gerarGuiaTomador($notas, $data) {

    if ($data == '') {
      $data = new DateTime();
    } else {
      $data = parent::stringToDate($data);
    }

    $cpfcnpj        = $notas[0]->getT_cnpjcpf();
    $inscricao      = $notas[0]->getT_im();
    $ano_comp       = $notas[0]->getAno_comp();
    $mes_comp       = $notas[0]->getMes_comp();
    $planilha       = Contribuinte_Model_GuiaEcidade::gerarPlanilhaRetencao($cpfcnpj, $inscricao, $ano_comp, $mes_comp);
    $array_servicos = array(); // Vetor que faz cache das descricoes dos servicos

    foreach ($notas as $n) {

      $this->addNota($n->getEntity());
      $cod_serv = $n->getS_dados_cod_tributacao();

      if (!isset($array_servicos[$cod_serv])) {

        $serv                      = Contribuinte_Model_Servico::getByCodServico($cod_serv);
        $descr_serv                = urlencode($serv[0]->attr('desc_item_servico'));
        $array_servicos[$cod_serv] = $descr_serv;
      }

      Contribuinte_Model_GuiaEcidade::lancarPlanilhaRetencao($planilha, $n, $data, $array_servicos[$cod_serv]);
    }

    $guiaWS = Contribuinte_Model_GuiaEcidade::gerarGuiaTomador($planilha);

    $this->setValorCorrigido($guiaWS->valor_corrigido);
    $this->setValorHistorico($guiaWS->valor_historico);
    $this->setCodigoBarras($guiaWS->codigo_barras);
    $this->setLinhaDigitavel($guiaWS->linha_digitavel);
    $this->setJurosMulta($guiaWS->juros_multa);
    $this->setCodigoGuia($guiaWS->codigo_guia);

    $numpre = each($guiaWS->debitos_guia);

    $this->setNumpre($numpre['value']->iNumpre);
    $this->setAnoComp($ano_comp);
    $this->setMesComp($mes_comp);
    $this->setTipo(self::$TOMADOR);
    $this->setSituacao(self::$ABERTA);
    $this->setTipoDocumentoOrigem(self::$DOCUMENTO_ORIGEM_DMS);
    $this->setIm($inscricao);
    $this->setVencimento($data);
    $this->persist();

    return array('objeto' => $this, 'arquivo' => $guiaWS->arquivo_guia);
  }

  /**
   * Retorna todas as guias em que o contribuinte é substituto tributário
   *
   * @param integer $im Inscrição municipal
   * @return array
   */
  public function getSubstituto($im) {

    $em    = parent::getEm();
    $dql   = 'SELECT g FROM Contribuinte\Guia g WHERE g.tipo = :t AND g.im = :im';
    $query = $em->createQuery($dql)->setParameters(array('im' => $im, 't' => self::$TOMADOR))->getResult();
    $r     = array();

    if ($query != NULL) {

      foreach ($query as $q) {
        $r[] = new self($q);
      }
    }

    return $r;
  }

  /**
   * Formata total de serviço em moeda (R$ x.xxx,xx)
   *
   * @return string
   */
  public function getFormatedTotalServico() {

    return number_format($this->getTotalServico(), 2, ',', '.');
  }

  /**
   * Formata total de ISS em moeda (R$ x.xxx,xx)
   *
   * @return string
   */
  public function getFormatedTotalIss() {

    return number_format($this->getTotalIss(), 2, ',', '.');
  }

  /**
   * Total de serviços declarados na guia
   *
   * @return float
   */
  public function getTotalServico() {

    if ($this->getTipo() == self::$TOMADOR) {

      $notas = $this->getNotas();
      $total = 0;

      foreach ($notas as $n) {
        $total += $n->getS_vl_servicos();
      }

      return $total;
    } else {

      $competencia = Contribuinte_Model_Competencia::getByImCompetencia($this->getAnoComp(),
                                                                        $this->getMesComp(),
                                                                        $this->getIm());

      return $competencia->getTotalServico();
    }
  }

  /**
   * Total de ISS pago na guia
   *
   * @return float
   */
  public function getTotalIss() {

    if ($this->getTipo() == self::$TOMADOR) {

      $notas = $this->getNotas();
      $total = 0;

      foreach ($notas as $n) {
        $total += $n->getS_vl_iss();
      }

      return $total;
    } else {
      return $this->getCompetencia()->getTotalIss();
    }
  }

  /**
   * Vetor com todas as notas referentes a esta guia
   *
   * @return Contribuinte_Model_Nota[]
   */
  public function getNotas() {

    if ($this->getTipo() == self::$TOMADOR) {

      $notas = $this->getEntity()->getNotas();
      $r     = array();

      if ($notas != NULL) {

        foreach ($notas as $n) {
          $r[] = new Contribuinte_Model_Nota($n);
        }
      }

      return $r;
    } else {
      return $this->getCompetencia()->getNotas();
    }
  }

  /**
   * Atualiza situação do débito referente a esta guia
   *
   * @throws Exception
   */
  public function atualizaSituacao() {

    if ($this->getNumpre()) {

      $sSitucao = Contribuinte_Model_GuiaEcidade::atualizaSituacao($this->getNumpre(), $this->getMesComp());

      if (!isset(self::$WS_NFSE_SITUACAO[$sSitucao])) {
        throw new Exception("Situação de débito {$sSitucao} não mapeada para o modelo Guia");
      }

      $this->setSituacao(self::$WS_NFSE_SITUACAO[$sSitucao]);
    }
  }

  /**
   * Competencia referente a esta guia
   *
   * @return \Contribuinte_Model_Competencia
   */
  private function getCompetencia() {

    if ($this->competencia === NULL) {

      $this->competencia = Contribuinte_Model_Competencia::getByImCompetencia($this->getAnoComp(),
                                                                              $this->getMesComp(),
                                                                              $this->getIm());
    }

    return $this->competencia;
  }

  /**
   * Retorna todas as notas referentes ao tipo de documento origem e inscricao
   *
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @param integer|null                            $iTipoDocumento
   * @return array|Contribuinte_Model_Nota[]
   */
  public static function getGuiasByDocumentoOrigem(Contribuinte_Model_ContribuinteAbstract $oContribuinte,
                                                   $iTipoDocumento = NULL) {

    if ($iTipoDocumento == NULL) {
      $iTipoDocumento = $oContribuinte->getTipoEmissao();
    }

    $aCamposPesquisa = array(
      'tipo_documento_origem' => $iTipoDocumento,
      'id_contribuinte'       => $oContribuinte->getContribuintes()
    );
    $aCamposOrdem    = array(
      'ano_comp' => 'DESC',
      'mes_comp' => 'DESC'
    );

    $aResultado = self::getByAttributes($aCamposPesquisa, $aCamposOrdem);

    if (count($aResultado) > 0) {
      return $aResultado;
    }

    return array();
  }

  /**
   * Retorna se existe guia para aquela nota
   *
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @param integer                                 $iMesCompetencia
   * @param integer                                 $iAnoCompetencia
   * @param integer|null                            $iDocumentoOrigem
   * @return bool
   * @throws Zend_Exception
   */
  public static function existeGuia(Contribuinte_Model_ContribuinteAbstract $oContribuinte,
                                    $iMesCompetencia,
                                    $iAnoCompetencia,
                                    $iDocumentoOrigem = NULL) {

    if (empty($oContribuinte)) {
      throw new Zend_Exception('Informe um contribuinte válido');
    }

    if (!$iMesCompetencia) {
      throw new Zend_Exception('Informe o mês de competência');
    }

    if (!$iAnoCompetencia) {
      throw new Zend_Exception('Informe o ano de competência');
    }

    $oEntityManager = self::getEm();
    $oRepositorio   = $oEntityManager->getRepository(self::$entityName);
    $aParametros    = array(
      'id_contribuinte' => $oContribuinte->getContribuintes(),
      'mes_comp'        => $iMesCompetencia,
      'ano_comp'        => $iAnoCompetencia
    );

    if (!empty($iDocumentoOrigem)) {
      $aParametros['tipo_documento_origem'] = $iDocumentoOrigem;
    }

    $aResultado = $oRepositorio->findOneBy($aParametros);

    return (!empty($aResultado));
  }

  /**
   * Atualiza a situação das guias conforme uma coleção de numpre e numpar informados
   *
   * @param array $aGuias
   * @param integer $iLimit
   * @param integer $iOffset
   * @return array
   * @throws Exception
   */
  public static function atualizaSituacaoGuias(array $aGuias, $iLimit = null, $iOffset = null) {

    $aResultado = array();

    $iIndiceinicio = ($iOffset * $iLimit) - $iLimit;
    $iIndiceFim    = $iOffset * $iLimit;

    // Agrupa os Numpres e Numpars do Contribuinte
    for($i = $iIndiceinicio; $i < $iIndiceFim; $i++){

      if(isset($aGuias[$i])){

        $sChaveNumpreNumpar                             = "{$aGuias[$i]->getNumpre()}/{$aGuias[$i]->getMesComp()}";
        $aDadosSituacao[$sChaveNumpreNumpar]['iNumpre'] = $aGuias[$i]->getNumpre();
        $aDadosSituacao[$sChaveNumpreNumpar]['iNumpar'] = $aGuias[$i]->getMesComp();
      }
    }

    if (isset($aDadosSituacao)) {

      $aSitucao = Contribuinte_Model_GuiaEcidade::pesquisaSituacaoGuias($aDadosSituacao);

      // Altera a situacao da guia conforme as situacoes encontradas na pesquisa
      for($i = $iIndiceinicio; $i < $iIndiceFim; $i++){

        if(isset($aGuias[$i])){

          $sChaveNumpreNumpar = "{$aGuias[$i]->getNumpre()}/{$aGuias[$i]->getMesComp()}";
          $sSituacao          = $aSitucao[$sChaveNumpreNumpar];

          if (!isset(self::$WS_NFSE_SITUACAO[$sSituacao])) {
            throw new Exception("Situação de débito {$sSituacao} não mapeada para o modelo Guia");
          }

          $aGuias[$i]->setSituacao(self::$WS_NFSE_SITUACAO[$sSituacao]);

          $oComparaData = new Zend_Date("01-{$aGuias[$i]->getMesComp()}-{$aGuias[$i]->getAnoComp()}");
          $oComparaData->add(1,'MM');

          // Verifica se a guia de débito foi cancelada no E-cidade remove o vinculo da guia, caso seja NFSE e não
          // estiver um mês retroativo apenas exibe como "Cancelada"
          if ($aGuias[$i]->getTipoDocumentoOrigem() == self::$DOCUMENTO_ORIGEM_DMS) {

            if (!empty($sSituacao) && $sSituacao == 'CANCELADO') {

              $aAtributos = array(
                                  'set' => array('guia' => NULL),
                                  'where' => array('guia' => $aGuias[$i]->getEntity())
              );

              Contribuinte_Model_DesifContaGuia::update($aAtributos['set'], $aAtributos['where']);
              Contribuinte_Model_Guia::removeGuiaCancelada($aGuias[$i]);
            } else {
              $aResultado[] = $aGuias[$i];
            }
          } else {
            $aResultado[] = $aGuias[$i];
          }
        }
      }
    }

    return $aResultado;
  }

  /**
   * Retorna todas guias pagas pelo contribuinte optante pelo simples nacional
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte contribuinte optante pelo simples
   * @param integer $iTipoDebito Tipo do Debito no e-Cidade
   * @return array
   */
  public static function getGuiasPagasOptanteSimples(Contribuinte_Model_ContribuinteAbstract $oContribuinte, $iTipoDebito = 3) {

    $aCampos = array(
                     'competencia',
                     'data_vencimento',
                     'valor_historico',
                     'valor_corrigido',
                     'valor_pago'
                    );

    $aParametros = array(array('inscricao_municipal' => $oContribuinte->getInscricaoMunicipal(), 'tipo_debito' => $iTipoDebito), $aCampos);
    $aGuiasPagas = WebService_Model_Ecidade::consultar('getPagamentosEfetuadosOptanteSimples', $aParametros);

    if (!is_array($aGuiasPagas)) {
      $aGuiasPagas = array();
    } else {

      //Reverte a ordenação para DESC
      $aGuiasPagas = array_reverse($aGuiasPagas);
    }

    return $aGuiasPagas;
  }

  /**
   * Cancela uma guia existente
   *
   * @param $oGuia
   */
  public static function removeGuiaCancelada($oGuia) {

    $aGuiasDMS  = $oGuia->getEntity()->getDms();
    $aGuiasNfse = $oGuia->getEntity()->getNotas();

    // Remove os vinculos de guias de DMS
    foreach ($aGuiasDMS as $oGuiasDms) {

      $oGuiasDms->setStatus('fechado');
      $oGuiasDms->setCodigoPlanilha(NULL);

      foreach ($oGuiasDms->getDmsNotas() as $oGuiasDmsNota) {
        $oGuiasDmsNota->setNumpre(0);
      }
    }

    //  Remove os vinculos de NFSE
    foreach ($aGuiasNfse as $oGuiasNota) {
      $oGuia->remNota($oGuiasNota);
    }

    $oGuia->persist();
    $oGuia->destroy();
  }

  /**
   * @param $iIdContribuinte
   *
   * @throws Exception
   * @throws Excpetion
   */
  public static function consultaGuiasDesif ($iIdContribuinte) {

    try {

      $oUsuarioContribuinte = Administrativo_Model_UsuarioContribuinte::getByAttribute('id', $iIdContribuinte);

      // $em         = parent::getEm();
      // $sDql       = 'SELECT g FROM Contribuinte\Guia g INNER JOIN  Contribuinte\DesifContaGuia d WITH g.id = d.guia';
      // $sDql      .= ' WHERE g.id_contribuinte = :c AND g.tipo_documento_origem = :t';
      // $oQuery     = $em->createQuery($sDql)->setParameters(array('t' => self::$DOCUMENTO_ORIGEM_NFSE, 'c' => $oUsuarioContribuinte->getEntity()));
      // $aResultado = $oQuery->getResult();
      // $aGuias     = array();

      $em         = parent::getEm();
      $sDql       = 'SELECT g FROM Contribuinte\Guia g';
      $sDql      .= ' WHERE g.id_contribuinte = :c AND g.tipo_documento_origem = :t';
      $oQuery     = $em->createQuery($sDql)->setParameters(array('t' => self::$DOCUMENTO_ORIGEM_NFSE, 'c' => $oUsuarioContribuinte->getEntity()));
      $aResultado = $oQuery->getResult();
      $aGuias     = array();


      // if ($aResultado != NULL) {

      //   foreach ($aResultado as $q) {

      //     die(print_r($q));

      //     $aGuias[] = new self($q);
      //   }
      // }


      return $aResultado;
    } catch (Excpetion $oErro) {
      throw $oErro;
    }
  }

  /**
   * Verifica se o débito está em aberto, consulta se existe pagamento parcial ele reecalcula os valores da guia
   * @param array $aGuias
   *
   * @return array
   * @throws Exception
   */
  public static function atualizaValorPagamentoParcialGuiasEmAberto(array $aGuias) {

    $aResultado = array();

    foreach($aGuias as $oGuia) {

      // Verifica guias em aberto
      if ($oGuia->getSituacao() == self::$ABERTA || $oGuia->getSituacao() == self::$PAGA) {

        $aValoresPagamentoParcial = WebService_Model_Ecidade::consultar('getValorPagamentoParcial', array(
          array(
            'numpre' => $oGuia->getNumpre(),
            'numpar' => $oGuia->getMesComp()
          ),
          array(
            'valor_pago'
          )
        ));

        // Verifica se retornou algum valor da consulta dos valores vindos do pagamento parcial
        if (is_array($aValoresPagamentoParcial)) {

          if (!empty($aValoresPagamentoParcial[0]->valor_pago)) {

            // Desconta o valor pago do original
            if ($aValoresPagamentoParcial[0]->valor_pago < $oGuia->getValorOrigem()) {

              $nValorDebito = $oGuia->getValorOrigem() - $aValoresPagamentoParcial[0]->valor_pago;
              $oGuia->setValorHistorico($nValorDebito);
            }

            // Se existir parcela em aberto e retornar algum valor pago seta flag do pagamento parcial
            if ($oGuia->getSituacao() == self::$ABERTA) {
              $oGuia->setPagamentoParcial(TRUE);
            }

            $oGuia->setValorPago($aValoresPagamentoParcial[0]->valor_pago);
            $oGuia->persist();
          }
        }
      }

      $aResultado[] = $oGuia;
    }

    return $aResultado;
  }


  /**
   * Busca Entidades por 1 ou mais campos podendo definir uma distinção e ordenação
   * @param array $aAtributos Atributos para utilizar na pesquisa
   * @param array $aCamposOrdem Campos e suas formas de ordenação na pesquisa
   * @return Contribuinte_Model_Nota[]
   */
  public function findAllTest(array $aAtributos, array $aCamposOrdem = array()) {

    return parent::findAllTest($aAtributos, $aCamposOrdem);
  }

  /**
   * Ontem o Valor total de servicos de Nfse
   * @return float valor total de servico
   */
  public function getValorTotalServicosPrestados() {

    $oEntityManager = self::getEm();
    $sSql = "SELECT SUM(notas.s_vl_servicos) AS total_servicos
              FROM notas
              INNER JOIN guias_notas ON id_nota = notas.id
              WHERE id_guia = :id_guia
                AND notas.cancelada = false
                AND notas.importada = false
                AND notas.id_nota_substituta IS NULL";

    $oConn = $oEntityManager->getConnection();
    $oQuery = $oConn->prepare($sSql);
    $oQuery->bindValue('id_guia', $this->getId());

    if (!$oQuery->execute()) {
      return NULL;
    }
    if ($oQuery->rowCount() > 1) {
      return NULL;
    }
    return (float) $oQuery->fetchColumn(0);
  }
}
