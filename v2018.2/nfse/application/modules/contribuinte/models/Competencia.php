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

use \Doctrine\ORM\Query\ResultSetMapping;
/**
 * Model para o controle da compentencia das guias
 *
 * @author dbseller
 * @package Contribuinte_Model_Competencia
 * @subpackage Contribuinte_Model
 * @see Contribuinte_Lib_Model_Doctrine
 */
class Contribuinte_Model_Competencia extends Contribuinte_Lib_Model_Doctrine {

  static protected $entityName = 'Contribuinte\Competencia';
  static protected $className = __class__;

  /**
   * Constantes que definem os códigos das situações de competência
   */
  const SITUACAO_EM_ABERTO                = 1;
  const SITUACAO_EM_ABERTO_SEM_MOVIMENTO  = 2;
  const SITUACAO_EM_ABERTO_SEM_IMPOSTO    = 3;
  const SITUACAO_ENCERRANDO               = 4;
  const SITUACAO_ENCERRANDO_SEM_MOVIMENTO = 5;
  const SITUACAO_ENCERRANDO_SEM_IMPOSTO   = 6;

  private $aNotas              = array();
  private $aGuia               = array();
  private $oContribuinte       = null;
  private $iMesCompetencia     = null;
  private $iAnoCompetencia     = null;
  private $iTipo               = null;
  private $fTotalValorServicos = null;
  private $fTotalValorIss      = null;
  private $lExisteGuia         = false;
  private $iSituacao           = null;
  private $lHabilitado         = false;
  private static $SITUACAO     = array(self::SITUACAO_EM_ABERTO                => 'Em Aberto',
                                       self::SITUACAO_EM_ABERTO_SEM_MOVIMENTO  => 'Em Aberto',
                                       self::SITUACAO_EM_ABERTO_SEM_IMPOSTO    => 'Em Aberto',
                                       self::SITUACAO_ENCERRANDO               => 'Encerrado',
                                       self::SITUACAO_ENCERRANDO_SEM_MOVIMENTO => 'Encerrado Sem Movimento',
                                       self::SITUACAO_ENCERRANDO_SEM_IMPOSTO   => 'Encerrado Sem Imposto');

  /**
   * Instancia a compentencia para um Contribuinte
   *
   * @param integer $iAnoCompetencia Ano da competencia
   * @param integer $iMesCompetencia Mes da Competencia
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte Instância do contribuinte
   */
  public function __construct($iAnoCompetencia = NULL,
                              $iMesCompetencia = NULL,
                              Contribuinte_Model_ContribuinteAbstract $oContribuinte = NULL,
                              Contribuinte\Competencia $entity = NULL)
  {

    parent::__construct($entity);

    $this->iAnoCompetencia = $iAnoCompetencia;
    $this->iMesCompetencia = $iMesCompetencia;
    $this->oContribuinte   = $oContribuinte;
  }

  /**
   * Retorna EntityManager do Doctrine
   *
   * @return \Doctrine\ORM\EntityManager
   */
  protected static function getEm() {
    return Zend_Registry::get('em');
  }

  public function persist(){

    $this->getEm()->persist($this->entity);
    $this->getEm()->flush();
  }

  /**
   * Verifica se a competência está habilitada a ser encerrada
   * @return boolean
   */
  public function isHabilitado() {
    return true;
    // return $this->lHabilitado;
  }

  /**
   * Habilita ou desabilita encerramento da competência
   * @param boolean $lHabilitado
   */
  public function setHabilitado( $lHabilitado ) {
    $this->lHabilitado = $lHabilitado;
  }

  /**
   * Retorna o objeto relativo a compentência do contribuinte
   *
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @return Contribuinte_Model_Competencia[]
   */
  public static function getByContribuinte(Contribuinte_Model_ContribuinteAbstract $oContribuinte) {

    $oEntityManager = self::getEm();
    $sSql           = 'SELECT DISTINCT
                              nota.ano_comp, nota.mes_comp,
                              SUM(nota.s_vl_iss) as s_vl_iss , SUM(nota.s_vl_servicos) as s_vl_servicos
                         FROM Contribuinte\Nota nota
                        WHERE nota.id_contribuinte    in(:id_contribuinte) AND
                              nota.cancelada          = false AND
                              nota.s_dados_iss_retido = 1 AND
                              nota.importada          = false
                     GROUP BY nota.ano_comp, nota.mes_comp
                     ORDER BY nota.ano_comp DESC,
                              nota.mes_comp DESC';

    $oQuery = $oEntityManager->createQuery($sSql);
    $oQuery->setParameter('id_contribuinte', $oContribuinte->getContribuintes());

    $aResultados = $oQuery->getResult();
    $aRetorno    = array();

    foreach ($aResultados as $aCompetencia) {

      $oCompetencia = new self($aCompetencia['ano_comp'], $aCompetencia['mes_comp'], $oContribuinte);
      $oCompetencia->setTotalIss($aCompetencia['s_vl_iss']);
      $oCompetencia->setTotalServico($aCompetencia['s_vl_servicos']);

      $lExisteGuia = Contribuinte_Model_Guia::existeGuia($oContribuinte, $aCompetencia['mes_comp'], $aCompetencia['ano_comp'], 10);
      $oCompetencia->setExisteGuia($lExisteGuia);

      $aRetorno[] = $oCompetencia;
    }

    return $aRetorno;
  }

  /**
   * Consulta todas as guias dos contribuintes por competência
   * @param $iMes
   * @param $iAno
   * @return array
   */
  public static function getByGuiasContribuinteAndCompetencia($iMes, $iAno) {

    $oEntityManager = self::getEm();
    $sSql           = 'SELECT nota.id_contribuinte,
                              nota.ano_comp, nota.mes_comp,
                              SUM(nota.s_vl_iss) AS s_vl_iss , SUM(nota.s_vl_servicos) AS s_vl_servicos
                         FROM Contribuinte\Nota nota
                        WHERE nota.mes_comp           = :mes_comp AND
                              nota.ano_comp           = :ano_comp AND
                              nota.cancelada          = false AND
                              nota.s_vl_iss           > 0 AND
                              nota.s_dados_iss_retido = 1 AND
                              nota.emite_guia         = true AND
                              nota.importada          = false AND
                              NOT EXISTS(SELECT 1
                                           FROM Contribuinte\Guia guia
                                          WHERE guia.mes_comp = :mes_comp
                                            AND guia.ano_comp = :ano_comp
                                            AND guia.id_contribuinte = nota.id_contribuinte
                                            AND guia.tipo_documento_origem = 10)
                     GROUP BY nota.id_contribuinte, nota.ano_comp, nota.mes_comp
                     ORDER BY nota.ano_comp,
                              nota.mes_comp DESC';


    $oQuery = $oEntityManager->createQuery($sSql);
    $oQuery->setParameter('mes_comp', $iMes);
    $oQuery->setParameter('ano_comp', $iAno);

    $aResultados = $oQuery->getResult();

    $aRetorno    = array();

    foreach ($aResultados as $aGuiaCompetencia) {

      $oContribuinte = Contribuinte_Model_Contribuinte::getById($aGuiaCompetencia['id_contribuinte']);
      if (is_null($oContribuinte)) {
        continue;
      }

      $oCompetencia  = new Contribuinte_Model_Competencia($aGuiaCompetencia['ano_comp'],
                                                          $aGuiaCompetencia['mes_comp'],
                                                          $oContribuinte);
      $oCompetencia->setTotalIss($aGuiaCompetencia['s_vl_iss']);
      $oCompetencia->setTotalServico($aGuiaCompetencia['s_vl_servicos']);

      $lExisteGuia = Contribuinte_Model_Guia::existeGuia($oContribuinte,
                                                         $aGuiaCompetencia['mes_comp'],
                                                         $aGuiaCompetencia['ano_comp'],
                                                         10);
      if ($lExisteGuia) {
        continue;
      }

      $aRetorno[] = $oCompetencia;
    }

    unset($aResultados);
    return $aRetorno;
  }

  public function getContribuinte() {
    return $this->oContribuinte;
  }

  public function setTotaisCompetencia() {

    $fTotalIss     = 0;
    $fTotalServico = 0;

    foreach ($this->aNotas as $oNota) {

      if ($oNota->getCancelada() || !is_null($oNota->getIdNotaSubstituta())) {
        continue;
      }

      $fTotalIss     += $oNota->getS_vl_iss();
      $fTotalServico += $oNota->getS_vl_servicos();
    }

    $this->setTotalIss($fTotalIss);
    $this->setTotalServico($fTotalServico);
  }

  /**
   * Soma ISS de todas as notas da competência
   *
   * @return number
   */
  public function getTotalIss() {
    return $this->fTotalValorIss;
  }

  /**
   * Soma do valor de todas as notas da competência
   *
   * @return number
   */
  public function getTotalServico() {
    return $this->fTotalValorServicos;
  }

  /**
   * Soma ISS de todas as notas da competência
   *
   * @return number
   */
  public function setTotalIss($fTotalValorIss) {
    $this->fTotalValorIss = $fTotalValorIss;
  }

  /**
   * Soma do valor de todas as notas da competência
   *
   * @return number
   */
  public function setTotalServico($fTotalValorServicos) {
    $this->fTotalValorServicos = $fTotalValorServicos;
  }

  /**
   * Soma do valor de todas as notas da competência
   *
   * @return number
   */
  public function getExisteGuia() {
    return $this->lExisteGuia;
  }

  /**
   * Soma ISS de todas as notas da competência
   *
   * @return number
   */
  public function setExisteGuia($lExisteGuia) {
    $this->lExisteGuia = $lExisteGuia;
  }


  /**
   * Retorna o valor do servico formatado como moeda
   *
   * @return string
   */
  public function getFormatedTotalServico() {
    return 'R$ ' . number_format($this->getTotalServico(), 2, ',', '.');
  }

  /**
   * Retorna o valor do iss formatado como moeda
   *
   * @return string
   */
  public function getFormatedTotalIss() {
    return 'R$ ' . number_format($this->getTotalIss(), 2, ',', '.');
  }

  /**
   * Retorna a competencia no formato mm/YYYY
   *
   * @return string
   */
  public function getCompetencia() {
    return "{$this->iMesCompetencia}/{$this->iAnoCompetencia}";
  }

  /**
   * Retorna o mes da competencia
   *
   * @return integer
   */
  public function getMesComp() {
    return $this->iMesCompetencia;
  }

  /**
   * Retorna o ano da competencia
   *
   * @return integer
   */
  public function getAnoComp() {
    return $this->iAnoCompetencia;
  }

  /**
   * Verifica se a competencia é corrente
   *
   * @return boolean
   */
  public function isCorrente() {

    $oDataAtual        = new DateTime();
    $oDataCompetencia  = new DateTime(DBSeller_Helper_Date_Date::invertDate('01/'.$this->getCompetencia(), '/'));

    $sCompetenciaAtual = $oDataAtual->format('Ym');
    $sCompetencia      = $oDataCompetencia->format('Ym');

    return ($sCompetencia === $sCompetenciaAtual);
  }

  /**
   * Retorna a guia de pagamento referente a esta competencia, se a competencia ainda estiver aberta entao retorna NULL
   *
   * @return boolean
   */
  public function getGuia() {

    if ($this->aGuia === NULL) {

      // @TODO Analisar o tipo de guia (dms | nota)
      $aGuia = Contribuinte_Model_Guia::getNotasRetidasNaCompetenciaDoContribuinte($this->iAnoCompetencia,
                                                                                   $this->iMesCompetencia,
                                                                                   $this->oContribuinte,
                                                                                   NULL);

      if (empty($aGuia)) {
        $this->aGuia = NULL;
      } else {
        $this->aGuia = $aGuia[0];
      }
    }

    return $this->aGuia;
  }

  /**
   * Verifica se existe guia emitida
   *
   * @return boolean
   */
  public function existeGuiaEmitida() {

    return Contribuinte_Model_Guia::existeGuia($this->oContribuinte,
                                               $this->iMesCompetencia,
                                               $this->iAnoCompetencia,
                                               10);
  }


  /**
   * Retorna as notas do mes
   *
   * @return array|Contribuinte_Model_Nota[]
   */
  public function getNotas() {

    if (count($this->aNotas) == 0) {

      $this->aNotas = Contribuinte_Model_Nota::getNotasRetidasNaCompetenciaDoContribuinte($this->iAnoCompetencia,
                                                                                          $this->iMesCompetencia,
                                                                                          $this->oContribuinte);
    }

    return $this->aNotas;
  }

  /**
   * Buscamos a quantidade de notas que foram emitidas nesta competência
   * @return integer
   */
  public function getQuantidadeNotas() {
    return count($this->aNotas);
  }

  /**
   * Retorna as notas do mes
   *
   * @return array|Contribuinte_Model_Nota[]
   */
  public function getTodasNotas() {

    $aCamposPesquisa = array(
      'ano_comp'        => $this->iAnoCompetencia,
      'mes_comp'        => $this->iMesCompetencia,
      'id_contribuinte' => $this->oContribuinte->getContribuintes()
    );

    $aCamposOrdem = array('nota' => 'DESC');
    $aResultado   = Contribuinte_Model_Nota::getByAttributes($aCamposPesquisa, $aCamposOrdem);

    $this->aNotas = $aResultado;
  }

  /**
   * Busca Declaracoes de insencao de ISSQN variavel (Declaracao de Sem Movimento)
   *
   * @return array|null
   */
  public function getDeclaracaoSemMovimento() {

    $oWebService = new WebService_Model_Ecidade();

    $iMes = '';
    if( !empty($this->iMesCompetencia) ){
      $iMes = $this->iMesCompetencia;
    }

    $aFiltro = array('inscricao_municipal' => $this->oContribuinte->getInscricaoMunicipal());

    if (!empty($this->iAnoCompetencia)) {
      $aFiltro['ano'] = $this->iAnoCompetencia;
    }

    if (!empty($this->iMes)) {
      $aFiltro['mes'] = $this->iMes;
    }

    $aCampos     = array('inscricao_municipal', 'mes', 'ano');
    $aRetorno    = $oWebService::consultar('getCancelamentoISSQNVariavel', array($aFiltro, $aCampos));

    return is_array($aRetorno) ? $aRetorno : NULL;
  }

  /**
   * Retorna varias declaracoes de sem movimento para varias contribuintes
   *
   * @param array $aInscricaoMunicipal
   * @param integer $iAnoCompetencia
   * @param integer $iMesCompetencia
   * @return array|null
   */
  public static function getDeclaracaoSemMovimentoPorContribuintes($aInscricaoMunicipal,
                                                                   $iAnoCompetencia = NULL,
                                                                   $iMesCompetencia = NULL) {

    if (is_array($aInscricaoMunicipal)) {
      $aInscricaoMunicipal = implode("','", $aInscricaoMunicipal);
    }

    $oWebService = new WebService_Model_Ecidade();
    $aCampos     = array('inscricao_municipal', 'ano', 'mes');
    $aFiltro     = array('inscricao_municipal' => $aInscricaoMunicipal);

    if ($iAnoCompetencia) {
      $aFiltro['ano'] = $iAnoCompetencia;
    }

    if ($iMesCompetencia) {
      $aFiltro['mes'] = $iMesCompetencia;
    }

    $aRetorno = $oWebService::consultar('getCancelamentoISSQNVariavel', array($aFiltro, $aCampos));

    return is_array($aRetorno) ? $aRetorno : NULL;
  }

  /**
   * Gera declaracao de insencao de ISSQN Variavel (Declaracao de Sem Movimento)
   *
   * @return array|null
   * @throws Exception
   */
  public function gerarDeclaracaoSemMovimento() {

    try {

      $aParamentos = array(
        'inscricaomunicipal' => $this->oContribuinte->getInscricaoMunicipal(),
        'mes'                => $this->iMesCompetencia,
        'ano'                => $this->iAnoCompetencia
      );

      $aRetorno = WebService_Model_Ecidade::processar('CancelamentoISSQNVariavel', $aParamentos);
    } catch(Exception $oErro) {
      DBSeller_Plugin_Notificacao::addErro('W007', "Erro ao declarar sem movimento: {$$oErro->getMessage()}");
      throw new Exception(sprintf($this->translate->_('Erro ao declarar sem movimento: %s'), $oErro->getMessage()));
    }

    return $aRetorno;
  }

  /**
   * Busca Cancelamentos de ISSQN variavel
   *
   * @return array|null
   */
  public function getCancelamentoISSQNVariavel() {

    $oWebService = new WebService_Model_Ecidade();
    $aFiltro     = array('inscricao_municipal' => $this->oContribuinte->getInscricaoMunicipal(),
                         'ano'                 => $this->iAnoCompetencia);
    $aCampos     = array('inscricao_municipal', 'mes', 'ano');
    $aRetorno    = $oWebService::consultar('getCancelamentoISSQNVariavel', array($aFiltro, $aCampos));

    return is_array($aRetorno) ? $aRetorno : NULL;
  }

  /**
   * Retorna varios cancelamentos de ISSQN variavel
   *
   * @param array $aInscricaoMunicipal
   * @param integer $iAnoCompetencia
   * @param integer $iMesCompetencia
   * @return array|null
   */
  public static function getCancelamentoISSQNVariavelPorContribuintes($aInscricaoMunicipal,
                                                                   $iAnoCompetencia = NULL,
                                                                   $iMesCompetencia = NULL) {

    if (is_array($aInscricaoMunicipal)) {
      $aInscricaoMunicipal = implode("','", $aInscricaoMunicipal);
    }

    $oWebService = new WebService_Model_Ecidade();
    $aCampos     = array('inscricao_municipal', 'ano', 'mes');
    $aFiltro     = array('inscricao_municipal' => $aInscricaoMunicipal);

    if ($iAnoCompetencia) {
      $aFiltro['ano'] = $iAnoCompetencia;
    }

    if ($iMesCompetencia) {
      $aFiltro['mes'] = $iMesCompetencia;
    }

    $aRetorno = $oWebService::consultar('getCancelamentoISSQNVariavel', array($aFiltro, $aCampos));

    return is_array($aRetorno) ? $aRetorno : NULL;
  }

  public function getFormatedSituacao(){
    return self::$SITUACAO[$this->getSituacao()];
  }

  /**
   * Retorna se existe competencia fechada
   *
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @param integer                                 $iMesCompetencia
   * @param integer                                 $iAnoCompetencia
   * @param integer|null                            $iDocumentoOrigem
   * @return bool
   * @throws Zend_Exception
   */
  public static function getCompetenciaInformacao(Contribuinte_Model_ContribuinteAbstract $oContribuinte,
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
      'mes'             => $iMesCompetencia,
      'ano'             => $iAnoCompetencia
    );

    if (!empty($iDocumentoOrigem)) {
      $aParametros['tipo'] = $iDocumentoOrigem;
    }

    $aResultado = $oRepositorio->findOneBy($aParametros);

    return (!empty($aResultado));
  }

  public function getSituacao(){
    return $this->iSituacao;
  }

  public function setSituacaoCompetencia($iSituacao){
    $this->iSituacao = $iSituacao;
  }

  public function getCompetenciaNfseByContribuinte()
  {

    $aCompetenciaAberto    = $this->getAbertoByContribuinte();
    $aCompetenciaEncerrado = $this->getEncerradoByContribuinte(Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE);

    $aCompetencia = array_merge($aCompetenciaAberto, $aCompetenciaEncerrado);

    // TODO - inicio - faz a ordenação
    $aCompetenciaAux = array();

    foreach($aCompetencia as $oCompetencia){

      $sIndexComp = (integer)($oCompetencia->getAnoComp().str_pad($oCompetencia->getMesComp(), 2, '0', STR_PAD_LEFT));
      $aCompetenciaAux[$sIndexComp] = $oCompetencia;
    }

    ksort($aCompetenciaAux);
    $aCompetencia = array_reverse($aCompetenciaAux);
    // TODO - fim - faz a ordenação

    return $aCompetencia;
  }

  public function getAbertoByContribuinte()
  {

    $sDataPrimeiraNota = Contribuinte_Model_Nota::getDataPrimeiraNotaEmitidaByContribuinte($this->oContribuinte->getContribuintes());

    /* @note: se não tem notas emitidas ele obtem a data de inicio das atividades da empresa */
    if (empty($sDataPrimeiraNota)) {

      $sDataPrimeiraNota = date('Y-m-d');

      $oData = Contribuinte_Model_Contribuinte::getInicioAtividades($this->oContribuinte);

      if (!empty($oData)) {
        $sDataPrimeiraNota = $oData->format('Y-m-d');
      }
    }

    $aDataPrimeiraNota = explode('-', $sDataPrimeiraNota);

    $sSql  = "   select ano_comp,                                                          ";
    $sSql .= "          mes_comp,                                                          ";
    $sSql .= "          sum(s_vl_servicos) as s_vl_servicos,                               ";
    $sSql .= "          sum(s_vl_iss) as s_vl_iss                                          ";
    $sSql .= "    from (select distinct                                                    ";
    $sSql .= "              nota.ano_comp,                                                 ";
    $sSql .= "              nota.mes_comp,                                                 ";
    $sSql .= "              sum(nota.s_vl_servicos) as s_vl_servicos,                      ";
    $sSql .= "              case                                                           ";
    $sSql .= "                  when (    nota.s_dados_iss_retido     = 1                  ";
    $sSql .= "                        and nota.natureza_operacao      = 1                  ";
    $sSql .= "                        and nota.s_dec_simples_nacional = 2                  ";
    $sSql .= "                        and nota.id_nota_substituta is null                  ";
    $sSql .= "                        and nota.s_dados_exigibilidadeiss not in (:iExigibilidade) ";
    $sSql .= "                        and nota.s_dec_reg_esp_tributacao not in (:iRegime)) ";
    $sSql .= "                  then sum(nota.s_vl_iss)                                    ";
    $sSql .= "                  else 0                                                     ";
    $sSql .= "              end as s_vl_iss                                                ";
    $sSql .= "            from notas nota                                                  ";
    $sSql .= "           where nota.id_contribuinte in(:id_contribuinte)                   ";
    $sSql .= "             and nota.cancelada = false                                      ";
    $sSql .= "             and nota.importada = false                                      ";
    $sSql .= "             and nota.ano_comp  >= {$aDataPrimeiraNota[0]}                                      ";

    if(!empty($this->iAnoCompetencia)){
      $sSql .= "           and nota.ano_comp  = ".$this->iAnoCompetencia;
    }

    if(!empty($this->iMesCompetencia)){
      $sSql .= "           and nota.mes_comp  = ".$this->iMesCompetencia;
    }

    $sSql .= "             and not exists(select 1                                                ";
    $sSql .= "                              from competencias comptencia                          ";
    $sSql .= "                             where comptencia.mes = nota.mes_comp                   ";
    $sSql .= "                               and comptencia.ano = nota.ano_comp                   ";
    $sSql .= "                               and comptencia.id_contribuinte in (:id_contribuinte) ";
    $sSql .= "                               and comptencia.tipo = 10)                            ";
    $sSql .= "        group by nota.ano_comp,                                                     ";
    $sSql .= "                 nota.mes_comp,                                                     ";
    $sSql .= "                 nota.s_dados_iss_retido,                                           ";
    $sSql .= "                 nota.s_dec_simples_nacional,                                       ";
    $sSql .= "                 nota.id_nota_substituta,                                           ";
    $sSql .= "                 nota.natureza_operacao,                                            ";
    $sSql .= "                 nota.s_dec_reg_esp_tributacao,                                      ";
    $sSql .= "                 nota.s_dados_exigibilidadeiss                                      ";
    $sSql .= " union ";
    $sSql .= "   select extract(year  from CAST(generate_series('{$aDataPrimeiraNota[0]}-{$aDataPrimeiraNota[1]}-01', now(), cast('1 month' as interval)) as date)), ";
    $sSql .= "          extract(month from CAST(generate_series('{$aDataPrimeiraNota[0]}-{$aDataPrimeiraNota[1]}-01', now(), cast('1 month' as interval)) as date)), ";
    $sSql .= "          0,    ";
    $sSql .= "          0     ";
    $sSql .= " ) as notas_iss ";

    if(!empty($this->iAnoCompetencia) or !empty($this->iMesCompetencia)){

      $sWhere = null;
      $sSql .= " where ";

      if(!empty($this->iAnoCompetencia)){
        $sWhere = " notas_iss.ano_comp = ".$this->iAnoCompetencia;
      }

      if(!empty($this->iMesCompetencia)){

        if(!empty($sWhere)){
          $sWhere .= " and ";
        }

        $sWhere .= " notas_iss.mes_comp = ".$this->iMesCompetencia;
      }

      $sSql .= $sWhere;
    }

    $sSql .= " group by notas_iss.ano_comp,      ";
    $sSql .= "          notas_iss.mes_comp       ";
    $sSql .= " order by notas_iss.ano_comp desc, ";
    $sSql .= "          notas_iss.mes_comp desc  ";

    $oRsm = new ResultSetMapping();
    $oRsm->addEntityResult('Contribuinte\Nota', 'notas_iss');
    $oRsm->addFieldResult('notas_iss', 'ano_comp', 'ano_comp');
    $oRsm->addFieldResult('notas_iss', 'mes_comp', 'mes_comp');
    $oRsm->addFieldResult('notas_iss', 's_vl_servicos', 's_vl_servicos');
    $oRsm->addFieldResult('notas_iss', 's_vl_iss', 's_vl_iss');

    $oEntityManager = self::getEm();
    $oQuery = $oEntityManager->createNativeQuery($sSql, $oRsm);

    $oQuery->setParameter('id_contribuinte', $this->oContribuinte->getContribuintes());
    $oQuery->setParameter(
      "iExigibilidade",
      array(
        Contribuinte_Model_Contribuinte::EXIGIBILIDADE_ISENTO,
        Contribuinte_Model_ContribuinteAbstract::EXIGIBILIDADE_IMUNE
      )
    );
    $oQuery->setParameter('iRegime', array(Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_ESTIMATIVA,
                                           Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_SOCIEDADE_PROFISSIONAIS,
                                           Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_FIXADO));

    $aResultado = $oQuery->getArrayResult();

    $aCompetenciaAberto = array();

    foreach ($aResultado as $aCompetencia) {

      $oCompetencia = new self($aCompetencia['ano_comp'], $aCompetencia['mes_comp'], $this->oContribuinte);

      $oCompetencia->setTotalIss($aCompetencia['s_vl_iss']);
      $oCompetencia->setTotalServico($aCompetencia['s_vl_servicos']);
      $oCompetencia->setTipo(Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE);

      $oCompetencia->verificaSituacaoAberto();

      $aCompetenciaAberto[] = $oCompetencia;
    }

    return $aCompetenciaAberto;
  }

  public function getEncerradoByContribuinte($iTipo = null)
  {

    if (is_null($iTipo)) {
      $iTipo = Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE;
    }

    $oQueryBuilder = self::getQuery();

    $oQueryBuilder->select('competencia');
    $oQueryBuilder->from('Contribuinte\Competencia', 'competencia');
    $oQueryBuilder->andWhere("competencia.id_contribuinte in(:id_contribuinte)");

    $oQueryBuilder->andWhere("competencia.tipo = :iTipo");
    $oQueryBuilder->setParameter('id_contribuinte', $this->oContribuinte->getContribuintes());
    $oQueryBuilder->setParameter('iTipo', $iTipo);
    $oQueryBuilder->orderBy('competencia.ano DESC, competencia.mes', 'DESC');

    $aResultado = $oQueryBuilder->getQuery()->execute();

    $aCompetenciaEncerrado = array();

    foreach($aResultado as $oCompetencia){

      $oCompetencia = new self($oCompetencia->getAno(), $oCompetencia->getMes(), $this->oContribuinte, $oCompetencia);

      $fTotalValorServicos = 0;
      $fTotalValorIss      = 0;

      $aGuias = $oCompetencia->getGuias();

      foreach($aGuias as $oGuia){
        $oGuia = new Contribuinte_Model_Guia($oGuia);

        $fTotalValorIss      += $oGuia->getValorCorrigido();
        $fTotalValorServicos += $oGuia->getValorTotalServicosPrestados();
      }

      $oCompetencia->setTotalIss($fTotalValorIss);
      $oCompetencia->setTotalServico($fTotalValorServicos);

      $oCompetencia->verificaSituacaoEncerrado();

      $aCompetenciaEncerrado[] = $oCompetencia;
    }

    return $aCompetenciaEncerrado;
  }

  public function verificaSituacaoAberto(){

    if($this->getTotalIss() > 0 && $this->getTotalServico() > 0){
      $this->setSituacaoCompetencia(self::SITUACAO_EM_ABERTO);
    }elseif($this->getTotalIss() == 0 && $this->getTotalServico() > 0){
      $this->setSituacaoCompetencia(self::SITUACAO_EM_ABERTO_SEM_IMPOSTO);
    }elseif($this->getTotalIss() == 0 && $this->getTotalServico() == 0){
      $this->setSituacaoCompetencia(self::SITUACAO_EM_ABERTO_SEM_MOVIMENTO);
    }
  }

  public function verificaSituacaoEncerrado(){
    $this->setSituacaoCompetencia($this->entity->getSituacao());
  }

  public function isSituacaoAberto(){

    if(   $this->getSituacao() == self::SITUACAO_EM_ABERTO
       or $this->getSituacao() == self::SITUACAO_EM_ABERTO_SEM_IMPOSTO
       or $this->getSituacao() == self::SITUACAO_EM_ABERTO_SEM_MOVIMENTO){
      return true;
    }

    return false;
  }

  public function processSituacaoParaFechado(){

    $iSituacao = $this->getSituacao();

    if($iSituacao == self::SITUACAO_EM_ABERTO){
      $iSituacao = self::SITUACAO_ENCERRANDO;
    }elseif($iSituacao == self::SITUACAO_EM_ABERTO_SEM_IMPOSTO){

      if(   $this->oContribuinte->isRegimeTributarioMei()
         or $this->oContribuinte->isRegimeTributarioFixado()
         or $this->oContribuinte->isRegimeTributarioSociedadeProfissionais()
         or $this->oContribuinte->isRegimeTributarioEstimativa()
      ) {

        $iSituacao = self::SITUACAO_ENCERRANDO;
      }else{

        $iSituacao = self::SITUACAO_ENCERRANDO_SEM_IMPOSTO;

        /**
         * Varificamos se há notas que não foram retidas no tomador nesta competência
         * Se houver, a situação deve ser 'Encerrado'
         */
        $aCamposPesquisa = array(
          's_dados_iss_retido' => Contribuinte_Model_Nota::PRESTADOR_RETEM_ISS,
          'natureza_operacao'  => Contribuinte_Model_Nota::NATUREZA_TRIBUTACAO_NO_MUNICIPIO,
          'id_contribuinte'    => $this->oContribuinte->getContribuintes(),
          'mes_comp'           => $this->getMesComp(),
          'ano_comp'           => $this->getAnoComp(),
          'cancelada'          => FALSE,
          'id_nota_substituta' => NULL
        );

        $aCamposOrdem = array('nota' => 'DESC');
        $aResultado   = Contribuinte_Model_Nota::getByAttributes($aCamposPesquisa, $aCamposOrdem);

        if ( !empty($aResultado) && !$this->oContribuinte->isExegibilidadeIsentoImuni() ) {
          $iSituacao = self::SITUACAO_ENCERRANDO;
        }
      }

    }elseif($iSituacao == self::SITUACAO_EM_ABERTO_SEM_MOVIMENTO){
      $iSituacao = self::SITUACAO_ENCERRANDO_SEM_MOVIMENTO;
    }

    $this->entity->setSituacao($iSituacao);

    return $iSituacao;
  }

  /**
   * Verifica se existe encerramento da competencia
   * @param  Contribuinte_Model_ContribuinteAbstract $oContribuinte   Contribuinte
   * @param  integer                                  $iMesCompetencia Mes
   * @param  integer                                  $iAnoCompetencia Ano
   * @param  integer                                  $iTipo           Tipo da competencia DMS / NFSe
   * @return Zend_Exception
   */
  public static function existeEncerramento(Contribuinte_Model_ContribuinteAbstract $oContribuinte,
                                            $iMesCompetencia,
                                            $iAnoCompetencia,
                                            $iTipo = NULL)
  {

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
      'mes'             => $iMesCompetencia,
      'ano'             => $iAnoCompetencia
    );

    if (!empty($iTipo)) {
      $aParametros['tipo'] = $iTipo;
    }

    $aResultado = $oRepositorio->findOneBy($aParametros);

    return (!empty($aResultado));

  }

  /**
   * Verifica se encontra alguma nota que foi emitida retido no prestador
   * @return boolean
   */
  public function isEmissaoNormal() {

    foreach( $this->aNotas as $oNota ) {

      if ( $oNota->getS_dados_iss_retido() == Contribuinte_Model_Nota::PRESTADOR_RETEM_ISS ) {
        return true;
      }
    }

    return false;
  }

  /**
   * Setter ID
   * @param integer $iId Id da Competencia
   */
  public function setId($iId) {
    $this->iId = $iId;
  }

  /**
   * Getter ID
   * @return integer ID da Competencia
   */
  public function getId() {
    return $this->iId;
  }

  /**
   * @return integer ID da Competencia
   */
  public function getId_competencia() {
    return $this->entity->getId();
  }

  /**
   * @return entity Competencia
   */
  public function getEntityCompetencia() {
    return $this->entity;
  }
}
