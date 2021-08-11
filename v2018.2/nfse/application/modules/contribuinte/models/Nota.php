<?php

use Doctrine\ORM\Query\AST\Join;

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
 * Define uma classe para tratamento das notas fiscais de serviço eletrônicas
 *
 * @package Contribuinte_Model
 * @see     Contribuinte_Interface_DocumentoNota
 * @see     Contribuinte_Lib_Model_Doctrine
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */

class Contribuinte_Model_Nota extends Contribuinte_Lib_Model_Doctrine implements Contribuinte_Interface_DocumentoNota {

  /**
   * Grupo dos documentos NFSe
   *
   * @var integer
   */
  const GRUPO_NOTA_NFSE = 2;

  /**
   * Grupo dos documentos RPS (Recibo Provisório de Serviços)
   *
   * @var integer
   */
  const GRUPO_NOTA_RPS = 7;

  /**
   * Prestador do serviço, fica como responsavel pelo imposto
   *
   * @var integer
   */
  const PRESTADOR_RETEM_ISS = 1;

  /**
   * Substituicao Tributaria - o Tomador do serviço, fica como responsavel pelo imposto
   *
   * @var integer
   */
  const TOMADOR_RETEM_ISS = 2;

  /**
   * Grupo dos documentos DMS (Declaração Manual de Serviços)
   *
   * @var string
   */
  const GRUPO_NOTA_DMS = '1,3,4,5,6,8';

  /**
   * Todos os grupo de documentos
   *
   * @var string
   */
  const GRUPO_NOTA_ALL = '1,2,3,4,5,6,7,8';

  const NATUREZA_TRIBUTACAO_NO_MUNICIPIO   = 1;
  const NATUREZA_TRIBUTACAO_FORA_MUNICIPIO = 2;

  /**
   * Objeto Entidade
   *
   * @var string
   */
  static protected $entityName = 'Contribuinte\Nota';

  /**
   * Nome da classe
   *
   * @var string
   */
  static protected $className = __CLASS__;

  /**
   * Descrição da lista de serviço
   *
   * @var string
   */
  private $descricao_lista_servico = NULL;

  /**
   * Interface de tratamento de irregularidades
   *
   * @var object
   */
  private $oIrregularidadeInterface = NULL;

  /**
   * Construtor
   *
   * @param string $oEntidadeDoctrine
   */
  public function __construct($oEntidadeDoctrine = NULL) {

    parent::__construct($oEntidadeDoctrine);
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getId()
   */
  public function getId() {

    return $this->entity->getId();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getCompetenciaMes()
   */
  public function getCompetenciaMes() {

    return $this->entity->getMes_comp();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getCompetenciaAno()
   */
  public function getCompetenciaAno() {

    return $this->entity->getAno_comp();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getCodigoNotaPlanilha()
   */
  public function getCodigoNotaPlanilha() {

    return NULL;
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getNotaNumero()
   */
  public function getNotaNumero() {

    return $this->entity->getNota();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getNotaData()
   */
  public function getNotaData() {

    return $this->entity->getDt_nota();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoAliquota()
   */
  public function getServicoAliquota() {

    return $this->entity->getS_vl_aliquota();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoImpostoRetido()
   */
  public function getServicoImpostoRetido() {

    return $this->entity->getS_dados_iss_retido();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoBaseCalculo()
   */
  public function getServicoBaseCalculo() {

    return $this->entity->getS_vl_bc();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoValorDeducao()
   */
  public function getServicoValorDeducao() {

    return $this->entity->getS_vl_deducoes();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoValorImposto()
   */
  public function getServicoValorImposto() {

    return $this->entity->getS_vl_iss();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoValorPagar()
   */
  public function getServicoValorPagar() {

    return $this->entity->getS_vl_servicos();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getSituacaoDocumento()
   */
  public function getSituacaoDocumento() {

    return NULL;
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getDescricaoServico()
   */
  public function getDescricaoServico() {

    return $this->entity->getS_dados_discriminacao();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getPrestadorCpfCnpj()
   */
  public function getPrestadorCpfCnpj() {

    return $this->entity->getP_cnpjcpf();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getPrestadorInscricaoMunicipal()
   */
  public function getPrestadorInscricaoMunicipal() {

    return $this->entity->getP_im();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getPrestadorRazaoSocial()
   */
  public function getPrestadorRazaoSocial() {

    return $this->entity->getP_razao_social();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getTomadorCpfCnpj()
   */
  public function getTomadorCpfCnpj() {

    return $this->entity->getT_cnpjcpf();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getTomadorInscricaoMunicipal()
   */
  public function getTomadorInscricaoMunicipal() {

    return $this->entity->getT_im();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getTomadorRazaoSocial()
   */
  public function getTomadorRazaoSocial() {

    return $this->entity->getT_razao_social();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getOperacao()
   */
  public function getOperacao() {

    return 's';
  }

  /**
   * @return string
   */
  public function getNotaSerie() {

    return '';
  }

  /**
   * Define qual vai ser a interface para tratamento de irregularidades
   * @param Contribuinte_Interface_IrregularidadeNota $oIrregularidadeInterface Interface
   */
  public function setIrregularidadeInterface(Contribuinte_Interface_IrregularidadeNota $oIrregularidadeInterface) {
    $this->oIrregularidadeInterface = $oIrregularidadeInterface;
  }

  /**
   * Implementa a interface de controle de Irregularidades de Nota
   * @param  string $sMensagem        Mensagem disparada pela validação
   */
  public function adicionaIrregularidade($sMensagem) {
    $this->oIrregularidadeInterface->adicionarIrregularidade($sMensagem);
  }

  /**
   * Busca os documentos por Código de verificação e CPF / CNPJ
   *
   * @param string $sCodigoVerificacao
   * @param string $sCpfCnpj
   * @return NULL|Contribuinte_Model_Nota|Contribuinte_Model_Nota[]
   */
  public static function getByCodigoAndCpfCnpj($sCodigoVerificacao, $sCpfCnpj) {

    $oEntityManager = parent::getEm();
    $oRepositorio   = $oEntityManager->getRepository(static::$entityName);
    $aResultado     = $oRepositorio->findBy(array('cod_verificacao' => $sCodigoVerificacao, 't_cnpjcpf' => $sCpfCnpj));

    if (count($aResultado) == 0) {
      return NULL;
    }

    if (count($aResultado) == 1) {
      return new Contribuinte_Model_Nota($aResultado[0]);
    }

    $aRetorno = array();

    foreach ($aResultado as $oResultado) {
      $aRetorno[] = new Contribuinte_Model_Nota($oResultado);
    }

    return $aRetorno;
  }

  /**
   * Retorna as notas sem guia do prestador
   *
   * @param array $aListaContribuintes
   * @return Contribuinte_Model_Nota[]
   */
  public static function getNotasRetidasSemGuiaByContribuinte(array $aListaContribuintes) {

    $oEm        = parent::getEm();
    $sSql       = 'SELECT notas FROM Contribuinte\Nota notas
                    WHERE notas.s_dados_iss_retido = ' . self::PRESTADOR_RETEM_ISS . ' AND
                          notas.emite_guia = true AND
                          notas.id_contribuinte in(?1) AND
                          notas.id NOT IN (SELECT n.id FROM Contribuinte\Guia g JOIN g.notas n)';
    $oQuery     = $oEm->createQuery($sSql)->setParameter('1', $aListaContribuintes);
    $aResultado = $oQuery->getResult();
    $aRetorno   = array();

    if (is_array($aResultado) && count($aResultado) > 0) {

      foreach ($aResultado as $oResultado) {
        $aRetorno[] = new Contribuinte_Model_Nota($oResultado);
      }
    }

    return $aRetorno;
  }

  /**
   * Retorna as notas retidas para o contribuinte
   *
   * @param integer $iIdContribuinte
   * @return Contribuinte_Model_Nota[]
   */
  public static function getNotasRetidasByContribuinte($iIdContribuinte) {

    $aCamposPesquisa = array(
      's_dados_iss_retido' => self::PRESTADOR_RETEM_ISS,
      'id_contribuinte'    => $iIdContribuinte,
      'cancelada'          => FALSE
    );

    $aCamposOrdem = array('nota' => 'DESC');
    $aResultado   = self::getByAttributes($aCamposPesquisa, $aCamposOrdem);

    return $aResultado;
  }

  /**
   * Retorna as notas do prestador
   *
   * @param integer $iIdContribuinte
   * @return Contribuinte_Model_Nota[]
   */
  public static function getNotasPrestadorByContribuinte($iIdContribuinte) {

    $oEntityManager = parent::getEm();
    $oRepositorio   = $oEntityManager->getRepository(static::$entityName);
    $aResultado     = $oRepositorio->findBy(array('id_contribuinte' => $iIdContribuinte), array('nota' => 'DESC'));
    $aRetorno       = array();

    if (is_array($aResultado) && count($aResultado) > 0) {

      foreach ($aResultado as $oResultado) {
        $aRetorno[] = new Contribuinte_Model_Nota($oResultado);
      }
    }

    return $aRetorno;
  }

  /**
   * Retorna as notas do tipo/grupo informado para o contribuinte
   *
   * @param array $aIdContribuinte
   * @param integer $iTipoNota
   * @param integer $iGrupoNota
   * @return mixed
   * @throws Exception
   */
  public static function getNotasEmitidasByContribuinteAndTipoNotaAndGrupoNota(array $aIdContribuinte, $iTipoNota, $iGrupoNota) {

    if (empty($aIdContribuinte)) {
      throw new Exception('Informe um contribuinte!');
    }

    if (empty($iTipoNota) && empty($iGrupoNota)) {
      throw new Exception('Informe o tipo ou grupo da nota!');
    }

    $oQueryBuilder = Contribuinte_Lib_Model_Doctrine::getQuery();
    $oQueryBuilder->select('COUNT(n.id)');
    $oQueryBuilder->from('Contribuinte\Nota', 'n');
    $oQueryBuilder->where('n.id_contribuinte in (:id_contribuinte)');
    $oQueryBuilder->setParameter('id_contribuinte', $aIdContribuinte);

    // Verifica se foi informado o tipo da nota
    if (!empty($iTipoNota)) {

      $oQueryBuilder->andWhere('n.tipo_nota = :tiponota');
      $oQueryBuilder->setParameter('tiponota', $iTipoNota);
    }

    // Verifica se foi informado o grupo da nota
    if (!empty($iGrupoNota)) {

      $oQueryBuilder->andWhere('n.grupo_nota = :gruponota');
      $oQueryBuilder->setParameter('gruponota', $iGrupoNota);
    }

    return $oQueryBuilder->getQuery()->getSingleScalarResult();
  }

  /**
   * Retorna a quantidade de RPS emitidos para o contribuinte
   *
   * @param array $aListaContribuinte
   * @return mixed
   */
  public static function getRpsEmitidosByContribuinte(array $aListaContribuinte) {

    $oEm    = parent::getEm();
    $sSql   = 'SELECT COUNT(n.id) FROM Contribuinte\Nota n
                WHERE n.id_contribuinte in (:id_contribuinte) AND
                      n.n_rps IS NOT NULL';
    $oQuery = $oEm->createQuery($sSql);
    $oQuery->setParameter('id_contribuinte', $aListaContribuinte);

    return $oQuery->getSingleScalarResult();
  }

  /**
   * Retorna as notas por id do contribuinte e competência
   *
   * @param integer                                 $iAnoCompetencia
   * @param integer                                 $iMesCompetencia
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @return Contribuinte_Model_Nota[]
   */
  public static function getNotasRetidasNaCompetenciaDoContribuinte($iAnoCompetencia,
                                                                    $iMesCompetencia,
                                                                    Contribuinte_Model_ContribuinteAbstract $oContribuinte) {

    $oEntityManager = parent::getEm();
    $sSql           = 'SELECT e FROM Contribuinte\Nota e
                        WHERE e.ano_comp           = :ano
                          AND e.mes_comp           = :mes
                          AND e.id_contribuinte    in(:id_contribuinte)
                          AND e.cancelada          = false
                          AND e.s_dados_iss_retido = ' . self::PRESTADOR_RETEM_ISS . '
                          AND e.s_vl_iss           > 0
                          AND e.emite_guia         = true';

    $oQuery = $oEntityManager->createQuery($sSql);
    $oQuery->setParameters(array(
                             'mes'             => $iMesCompetencia,
                             'ano'             => $iAnoCompetencia,
                             'id_contribuinte' => $oContribuinte->getContribuintes()
                           ));

    $aResultado = $oQuery->getResult();
    $aRetorno   = array();

    if (is_array($aResultado)) {

      foreach ($aResultado as $oResultado) {
        $aRetorno[] = new self($oResultado);
      }
    }

    return $aRetorno;
  }

  /**
   * Retorna o número da última RPS emitida
   *
   * @param string $sCnpj
   * @return mixed
   */
  public static function getNRpsByCnpj($sCnpj) {

    $oEm    = parent::getEm();
    $sSql   = 'SELECT MAX(e.n_rps) FROM Contribuinte\Nota e WHERE e.p_cnpjcpf = :cnpj';
    $oQuery = $oEm->createQuery($sSql)->setParameter('cnpj', $sCnpj);

    return $oQuery->getSingleScalarResult();
  }

  /**
   * Retorna verdadeiro se o RPS existe para o contribuinte
   *
   * @param array   $aListaContribuintes
   * @param integer $iNumeroRps
   * @param integer $iTipoDocumento
   * @return boolean
   */
  public static function checkRpsExistsByContribuinteAndNumeroRps($aListaContribuintes, $iNumeroRps, $iTipoDocumento) {

    $oEm    = parent::getEm();
    $sSql   = 'SELECT 1 FROM Contribuinte\Nota nota
                WHERE nota.id_contribuinte in (:contribuintes)  AND
                      nota.grupo_documento   = :grupo_documento AND
                      nota.tipo_documento    = :tipo_documento  AND
                      nota.n_rps             = :numero_rps';
    $oQuery = $oEm->createQuery($sSql);
    $oQuery->setParameter('contribuintes', $aListaContribuintes);
    $oQuery->setParameter('grupo_documento', Contribuinte_Model_Nota::GRUPO_NOTA_RPS);
    $oQuery->setParameter('tipo_documento', $iTipoDocumento);
    $oQuery->setParameter('numero_rps', $iNumeroRps);

    $aResultado = $oQuery->getResult();

    return (count($aResultado) > 0);
  }

  /**
   * Verifica se o RPS já foi registrado pelo contribuinte
   *
   * @tutorial Retorna TRUE caso já exista o RPS
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @param integer                                 $iNumeroRps
   * @param integer                                 $iTipoDocumento
   * @return boolean
   */
  public static function existeRps(Contribuinte_Model_ContribuinteAbstract $oContribuinte,
                                   $iNumeroRps,
                                   $iTipoDocumento) {

    $oEm    = parent::getEm();
    $sSql   = 'SELECT 1 FROM Contribuinte\Nota nota
                WHERE nota.id_contribuinte  = :id_contribuinte AND
                      nota.grupo_nota       = :grupo_documento AND
                      nota.tipo_nota        = :tipo_documento  AND
                      nota.n_rps            = :numero_rps';
    $oQuery = $oEm->createQuery($sSql);
    $oQuery->setParameter('id_contribuinte', $oContribuinte->getIdUsuarioContribuinte());
    $oQuery->setParameter('grupo_documento', Contribuinte_Model_Nota::GRUPO_NOTA_RPS);
    $oQuery->setParameter('tipo_documento', $iTipoDocumento);
    $oQuery->setParameter('numero_rps', $iNumeroRps);

    $aResultado = $oQuery->getResult();

    return (count($aResultado) > 0);
  }

  /**
   * Método para salvar a nota (ajustado para salvar por array ou objeto)
   *
   * @param $uDados
   * @return bool|NULL
   * @throws Exception
   */
  public function persist($uDados) {

    if (is_array($uDados)) {
      return self::notaPersist($uDados);
    } else if (is_object($uDados)) {

      $this->em->persist($uDados);
      $this->em->flush();

      return TRUE;
    } else {
      throw new Exception('O parâmetro informado é inválido para persistência de dados.');
    }
  }

  /**
   * Salva a nota (por array)
   *
   * @param array $aDados
   * @throws Exception
   * @return boolean|NULL
   */
  public function notaPersist(array $aDados) {

    // Se o numero da nota vier no vetor nao precisa salvar a nota porque provavelmente é um refresh do navegador
    if (isset($aDados['nota'])) {
      return FALSE;
    }

    // Nova verificação de alguns dados obrigatórios que a nota não seja emitida caso o cliente mude algum valor pelo
    // firebug
    if (empty($aDados['natureza_operacao'])
        || empty($aDados['s_dados_cod_tributacao'])
        || empty($aDados['s_vl_liquido'])
        || empty($aDados['descricao'])) {

      return FALSE;
    }

    // Se nao for emitida pelo web/service ou importacao de XML
    if (!isset($aDados['webservice'])) {
      $aDados['webservice'] = FALSE;
    }

    // Dados do prestador
    $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($aDados['p_im']);

    if (!is_object($oContribuinte)) {

      throw new Exception('E-cidade temporariamente indisponível. Emissão bloqueada!',
                          WebService_Model_Ecidade::CODIGO_ERRO_CONSULTA_WEBSERVICE);
    }

    //Regra de contribuinte IMUNE e ISENTO
    if ($aDados['s_dados_iss_retido'] == 1
        && (in_array($oContribuinte->getExigibilidade(), array(Contribuinte_Model_Contribuinte::EXIGIBILIDADE_IMUNE, Contribuinte_Model_Contribuinte::EXIGIBILIDADE_ISENTO)))) {
      $this->adicionaIrregularidade("Não é possível reter o imposto para o Tomador!");
    }

    $aDados['s_dados_exigibilidadeiss'] = (int) $oContribuinte->getExigibilidade();


    if ($aDados['webservice'] == FALSE){
      $oServico = Contribuinte_Model_Servico::getByCodServico($aDados['s_dados_cod_tributacao'], FALSE);

      $oServico = Contribuinte_Model_Servico::getServicosByExercicio($oServico, $aDados['dt_nota']->format('Y'));

      $oServico = is_array($oServico) ? $oServico[0] : $oServico;

      /* Define informações do serviço*/
      $aDados['s_tributacao_municipio'] = $oServico->attr('tributacao_municipio');
      $sTributacaoNaoIncide = $oServico->attr('tributacao_nao_incide');
      $sServicoAliq         = $oServico->attr('aliq');
      $sEstrutCnae          = $oServico->attr('estrut_cnae');
      $sCodItemServico      = $oServico->attr('cod_item_servico');

      if (!is_object($oServico)) {
        $this->adicionaIrregularidade('O código de atividade do serviço é inválido.');
      }

    } else {

      $oServicoCnae = Contribuinte_Model_Servico::getServicoPorAtividade($aDados['p_im'], $aDados['s_dados_item_lista_servico'], TRUE, NULL, $aDados['s_dados_cod_tributacao']);

      if (empty($oServicoCnae)) {
        $this->adicionaIrregularidade('Item da lista de serviço ou CNAE irregular.');
      } else {

        $sAliquotaInformada = $this->toFloat($aDados['s_vl_aliquota']);
        $sAliquotaServico   = $this->toFloat($oServicoCnae->attr('aliq'));

        if (($sAliquotaInformada != $sAliquotaServico) && $aDados['natureza_operacao'] == 1
            && (!in_array($oContribuinte->getExigibilidade(), array(Contribuinte_Model_Contribuinte::EXIGIBILIDADE_IMUNE, Contribuinte_Model_Contribuinte::EXIGIBILIDADE_ISENTO)))
            && !$oContribuinte->isOptanteSimples($aDados['dt_nota'])) {
          $this->adicionaIrregularidade("O valor de {$aDados['s_vl_aliquota']}% informado para a alíquota é diferente do determinado para o serviço prestado.");
        }
      }

      $aDados['s_tributacao_municipio'] = ($aDados['natureza_operacao'] == 1 ? 't' : 'f');
      $sTributacaoNaoIncide = 'f';
      $sServicoAliq         = $aDados['s_vl_aliquota'];
      $sEstrutCnae          = $aDados['s_dados_cod_tributacao'];
      $sCodItemServico      = $aDados['s_dados_item_lista_servico'];
    }

    // Verifica se o tomador e o serviço foram prestados no Brasil
    if (($aDados['t_cod_pais'] == '01058' && $aDados['s_dados_cod_pais'] == '01058') || $aDados['webservice'] == TRUE) {

    // Verifica se o serviço foi prestado no municipio
      if ($this->servicoPrestadoMunicipio($aDados)) {

        $bRuleSubsTributario = $this->ruleTomadorSubistitutoTributario($aDados);
        if (is_string($bRuleSubsTributario)
            && !$oContribuinte->isRegimeTributarioSociedadeProfissionais()
            && !$oContribuinte->isMEIAndOptanteSimples()
            && !$oContribuinte->isRegimeTributarioFixado()
            && utf8_encode($sTributacaoNaoIncide) != 't'
            && !in_array($oContribuinte->getExigibilidade(), array(Contribuinte_Model_Contribuinte::EXIGIBILIDADE_IMUNE, Contribuinte_Model_Contribuinte::EXIGIBILIDADE_ISENTO))) {

          $this->adicionaIrregularidade($bRuleSubsTributario);
        }

        /**
         * Validamos se a alíquota do xml está de acordo com a do serviço, desde que o contribuinte seja obrigado a utiliza-la
         */

        $sAliquotaFormatada = str_replace(',', '.', (string)$aDados['s_vl_aliquota']);

        if (   (float) $sAliquotaFormatada!= (float) $sServicoAliq
            && !$oContribuinte->isRegimeTributarioSociedadeProfissionais()
            && !$oContribuinte->isMEIAndOptanteSimples()
            && !$oContribuinte->isOptanteSimples($aDados['dt_nota'])
            && utf8_encode($sTributacaoNaoIncide) != 't'
            && !in_array($oContribuinte->getExigibilidade(), array(Contribuinte_Model_Contribuinte::EXIGIBILIDADE_IMUNE, Contribuinte_Model_Contribuinte::EXIGIBILIDADE_ISENTO))
            && Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_FIXADO != $oContribuinte->getRegimeTributario()
            && (   Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_COOPERATIVA != $oContribuinte->getRegimeTributario()
                || (   Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_COOPERATIVA == $oContribuinte->getRegimeTributario()
                    && isset($aDados['t_cooperado'])
                    && $aDados['t_cooperado'] != 'true'))
        ){

          $fAliquota = (float) $sAliquotaFormatada;

          $this->adicionaIrregularidade("O valor de {$fAliquota}% informado para a alíquota é diferente do determinado para o serviço prestado");
        }
      } else {

        /* Verifica reteñção fora do municipio*/
        $bRuleServico = $this->ruleServicoRetemForaMunicipio($aDados);

        if (is_string($bRuleServico)) {
          $this->adicionaIrregularidade($bRuleServico);
        }
      }
    }

    // Se o serviço não inicde
    if ($aDados['webservice'] == FALSE) {
      $aDados['s_vl_aliquota'] = (utf8_encode($sTributacaoNaoIncide) == 't' ? '0,00' : $aDados['s_vl_aliquota']);
    }

    $oParametros                          = new stdClass();
    $oParametros->vlr_servico             = $aDados['s_vl_servicos'];
    $oParametros->s_vl_deducoes           = $aDados['s_vl_deducoes'];
    $oParametros->perc_aliquota           = $aDados['s_vl_aliquota'];
    $oParametros->vlr_pis                 = $aDados['s_vl_pis'];
    $oParametros->vlr_cofins              = $aDados['s_vl_cofins'];
    $oParametros->vlr_inss                = $aDados['s_vl_inss'];
    $oParametros->vlr_ir                  = $aDados['s_vl_ir'];
    $oParametros->vlr_csll                = $aDados['s_vl_csll'];
    $oParametros->vlr_outras_retencoes    = $aDados['s_vl_outras_retencoes'];
    $oParametros->vlr_desc_condicionado   = $aDados['s_vl_condicionado'];
    $oParametros->vlr_desc_incondicionado = $aDados['s_vl_desc_incondicionado'];
    $oParametros->imposto_retido_tomador  = $aDados['s_dados_iss_retido'];
    $oParametros->deducao_editavel        = (isset($aDados['deducao_editavel'])) ? $aDados['deducao_editavel'] : 0;
    $oParametros->formatar_valores_ptbr   = TRUE;
    $oParametros->servico_nao_incide      = utf8_encode($sTributacaoNaoIncide) == 't' ? true : false;
    $oParametros->exigibilidade           = $aDados['s_dados_exigibilidadeiss'];

    // Corrigido data da nota enviado pelo RPS
    $oDataNota = ($aDados['dt_nota'] instanceof DateTime) ? $aDados['dt_nota'] : new DateTime($aDados['dt_nota']);

    // Verifica se o contribuinte é optante do simples pela data da nota para descontar o iss do valor liquido
    $oParametros->isOptanteSimples = $oContribuinte->isOptanteSimples($oDataNota) ? TRUE : FALSE;

    // Verifica qual a categoria caso o contribuinte for optante do simples nacional
    $oParametros->optanteSimplesCategoria = ($oParametros->isOptanteSimples) ? $oContribuinte->getOptanteSimplesCategoria() : 0;


    // Verifica incidencia de ISS para tomador/servico no exterior
    $oParametros->incideFora = (!$aDados['webservice'] ? $aDados['s_dados_fora_incide'] : TRUE);

    // Se não incide tributação no exterior zera a aliquota
    if (!$aDados['s_dados_fora_incide'] && !$aDados['webservice']) {
      $aDados['s_vl_aliquota'] = (float) 0.00;
    }

    // Calcula os valores da nota
    $oCalculoValores = $this->calcularValores($oParametros);

     // Valores calculados
    $aDados['s_vl_deducoes']            = $oCalculoValores->s_vl_deducoes;
    $aDados['s_vl_bc']                  = $oCalculoValores->vlr_base;
    $aDados['s_vl_iss']                 = $oCalculoValores->vlr_iss;
    $aDados['s_vl_pis']                 = $oCalculoValores->vlr_pis;
    $aDados['s_vl_cofins']              = $oCalculoValores->vlr_cofins;
    $aDados['s_vl_inss']                = $oCalculoValores->vlr_inss;
    $aDados['s_vl_ir']                  = $oCalculoValores->vlr_ir;
    $aDados['s_vl_csll']                = $oCalculoValores->vlr_csll;
    $aDados['s_vl_outras_retencoes']    = $oCalculoValores->vlr_outras_retencoes;
    $aDados['s_vl_condicionado']        = $oCalculoValores->vlr_desc_condicionado;
    $aDados['s_vl_desc_incondicionado'] = $oCalculoValores->vlr_desc_incondicionado;
    $aDados['s_vl_liquido']             = $oCalculoValores->vlr_liquido;

    // Limpa mascaras
    $aFilterDigits        = new Zend_Filter_Digits(); // filtro para retornar somente numeros
    $aDados['t_cnpjcpf']  = $aFilterDigits->filter($aDados['t_cnpjcpf']);
    $aDados['t_cep']      = $aFilterDigits->filter($aDados['t_cep']);
    $aDados['t_telefone'] = $aFilterDigits->filter($aDados['t_telefone']);

    // Converte para o formato do DB
    $aDados['s_vl_servicos']                = $this->toFloat($aDados['s_vl_servicos']);
    $aDados['s_vl_liquido']                 = $this->toFloat($aDados['s_vl_liquido']);
    $aDados['s_vl_deducoes']                = $this->toFloat($aDados['s_vl_deducoes']);
    $aDados['s_vl_bc']                      = $this->toFloat($aDados['s_vl_bc']);
    $aDados['s_vl_aliquota']                = $this->toFloat($aDados['s_vl_aliquota']);
    $aDados['s_vl_iss']                     = $this->toFloat($aDados['s_vl_iss']);
    $aDados['s_vl_pis']                     = $this->toFloat($aDados['s_vl_pis']);
    $aDados['s_vl_cofins']                  = $this->toFloat($aDados['s_vl_cofins']);
    $aDados['s_vl_inss']                    = $this->toFloat($aDados['s_vl_inss']);
    $aDados['s_vl_ir']                      = $this->toFloat($aDados['s_vl_ir']);
    $aDados['vl_liquido_nfse']              = $aDados['s_vl_liquido'];
    $aDados['s_vl_csll']                    = $this->toFloat($aDados['s_vl_csll']);
    $aDados['s_vl_condicionado']            = $this->toFloat($aDados['s_vl_condicionado']);
    $aDados['s_vl_desc_incondicionado']     = $this->toFloat($aDados['s_vl_desc_incondicionado']);
    $aDados['s_vl_outras_retencoes']        = $this->toFloat($aDados['s_vl_outras_retencoes']);

    $aDados['s_dados_discriminacao']        = DBSeller_Helper_String_Format::sanitize($aDados['descricao']);
    $aDados['s_informacoes_complementares'] = DBSeller_Helper_String_Format::sanitize($aDados['s_informacoes_complementares']);

    // Converte a data/hora de emissão da nota
    $aDados['dt_nota']  = self::getDateTime($aDados['dt_nota']);
    $aDados['hr_nota']  = self::getDateTime($aDados['dt_nota']);
    $aDados['ano_comp'] = (int)$aDados['dt_nota']->format('Y');
    $aDados['mes_comp'] = (int)$aDados['dt_nota']->format('m');

    // Flag marcado ou nao
    $lPrestadorRetemISS = $aDados['s_dados_iss_retido'] == 0 ? TRUE : FALSE;

    $aDados['s_dados_iss_retido'] = $lPrestadorRetemISS ? self::PRESTADOR_RETEM_ISS : self::TOMADOR_RETEM_ISS;

    // Outros dados do serviço
    $aDados['s_dados_cod_cnae']           = utf8_encode($sEstrutCnae);
    $aDados['s_dados_item_lista_servico'] = utf8_encode($sCodItemServico);
    $aDados['s_nao_incide']               = utf8_encode($sTributacaoNaoIncide) == 't' ? true : false;

    $aDados['p_cnpjcpf']         = $oContribuinte->getCgcCpf();
    $aDados['p_razao_social']    = $oContribuinte->getNome();
    $aDados['p_nome_fantasia']   = $oContribuinte->getNomeFantasia();
    $aDados['p_ie']              = $oContribuinte->getInscricaoEstadual();
    $aDados['p_cod_pais']        = $oContribuinte->getCodigoPais();
    $aDados['p_uf']              = $oContribuinte->getEstado();
    $aDados['p_cod_municipio']   = $oContribuinte->getCodigoIbgeMunicipio();
    $aDados['p_cep']             = $oContribuinte->getCep();
    $aDados['p_bairro']          = $oContribuinte->getLogradouroBairro();
    $aDados['p_endereco_numero'] = $oContribuinte->getLogradouroNumero();
    $aDados['p_endereco_comp']   = $oContribuinte->getLogradouroComplemento();
    $aDados['p_telefone']        = $oContribuinte->getTelefone();

    // Pega o email do Usuario principal do contribuinte se ñãot iver email cadastrado no CGM no e-cidade
    $sContribuinteEmail = trim($oContribuinte->getEmail());

    if (empty($sContribuinteEmail)) {

      $oUsuarioPrincipal = Administrativo_Model_UsuarioContribuinte::getUsuarioPrincipal($aDados['p_cnpjcpf']);

      $sContribuinteEmail = '';
      if ( is_object($oUsuarioPrincipal) ) {
        $sContribuinteEmail = $oUsuarioPrincipal->getEmail();
      }
    }

    // if ( empty($sContribuinteEmail) ) {
    //   $this->adicionaIrregularidade('Email do prestador não encontrado');
    // }

    $aDados['p_email']    = $sContribuinteEmail;
    $aDados['p_endereco'] = $oContribuinte->getTipoLogradouro() . ' ' .

    $oContribuinte->getDescricaoLogradouro();

    /*
     * Dados do RPS
     */
    if (isset($aDados['data_rps'])) {

      if (is_string($aDados['data_rps'])) {

        $aDataRps           = explode('/', $aDados['data_rps']);
        $oDataRps           = new DateTime($aDataRps[2] . '-' . $aDataRps[1] . '-' . $aDataRps[0]);
        $aDados['data_rps'] = $oDataRps;
      }

      if ($aDados['n_rps'] == '') {
        $aDados['n_rps'] = $this->getNRpsByCnpj($aDados['p_cnpjcpf']) + 1;
      } else {

        // Se o numero do RPS ja existe para este contribuinte, retorna erro
        if (self::existeRps($oContribuinte, $aDados['n_rps'], $aDados['tipo_nota'])) {
          return NULL;
        }
      }
    }

    /*
     * Dados do tomador
     */

    // Se o tomador for substituto então busca CGM apenas do e-cidade
    $oTomador = Contribuinte_Model_Empresa::getByCgcCpf($aDados['t_cnpjcpf']);

    /*
     * @todo Refatorar esse trecho de codigo
     */
    if (!empty($oTomador->eCidade)) {
      $oTomador = is_array($oTomador->eCidade) ? reset($oTomador->eCidade) : $oTomador->eCidade;
    } else if (!empty($oTomador->eNota)) {
      $oTomador = is_array($oTomador->eNota) ? reset($oTomador->eNota) : $oTomador->eNota;
    }

    // Se nao encontrou tomador, entao cadastra no banco do sistema
    if ($aDados['t_cod_pais'] == '01058' && (!is_object($oTomador) || empty($oTomador))) {

      $oTomador = new Contribuinte_Model_EmpresaBase();

      if ($oTomador instanceof Contribuinte_Model_EmpresaBase && $oTomador->isEntity()) {
        $oTomador->persist($aDados);
      }
    }

    // Dados da tributacao
    $aDados['s_dec_reg_esp_tributacao'] = (int) $oContribuinte->getRegimeTributario();
    $aDados['s_dec_incentivo_fiscal']   = (int) $oContribuinte->getIncentivoFiscal();
    $aDados['s_dec_simples_nacional']   = ($oParametros->isOptanteSimples) ? 1 : 2;

    // Busca a proxima numeracao da nota para o contribuinte
    $aDados['nota'] = $this->proximaNotaByContribuinte($oContribuinte->getContribuintes());

    // Configura o parametro para checar se deve adicionar a nota na guia de pagamento
    $oChecaEmissaoGuia                         = new stdClass();
    $oChecaEmissaoGuia->data                   = $aDados['dt_nota']->format('d/m/Y');
    $oChecaEmissaoGuia->inscricao_municipal    = $oContribuinte->getInscricaoMunicipal();

    // Se for RPS pega a data do mesmo
    if (isset($aDados['data_rps'])) {
      $oChecaEmissaoGuia->data = $aDados['data_rps']->format('d/m/Y');

      $oParametrosPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
      $aDados['data_processamento'] = new DateTime();
      $aDados['prazo_rps'] = $oParametrosPrefeitura->getPrazoRps();
    }

    /*
     * Verifica se deve incluir a nota na guia de pagamento, conforme as
     * regras de emissão do contribuinte (sobrescreve todas as regras anteriores)
     */
    $lEmiteGuia           = Contribuinte_Model_EmissorGuia::checarEmissaoGuia($oChecaEmissaoGuia);

    $lTributacaoMunicipio = ($aDados['s_tributacao_municipio'] == 't') ? TRUE : FALSE;
    $iNaturezaOperacao    = $aDados['natureza_operacao'];

    if ($lEmiteGuia && $iNaturezaOperacao == 2 && $lTributacaoMunicipio && $aDados['s_dados_fora_incide']) {

      $aDados['s_dados_iss_retido'] = '1';
      $lEmiteGuia                   = TRUE;
    }

    $aDados['emite_guia'] = $lEmiteGuia;

    // Se o prestador não for responsável pela retenção não inclui a nota na guia de pagamento
    if (in_array($oContribuinte->getExigibilidade(), array(Contribuinte_Model_Contribuinte::EXIGIBILIDADE_ISENTO, Contribuinte_Model_Contribuinte::EXIGIBILIDADE_IMUNE))
        || (!$lPrestadorRetemISS || ($iNaturezaOperacao == 2 && !$lTributacaoMunicipio)) && $aDados['emite_guia']) {
      $aDados['emite_guia'] = FALSE;
    }

    // Persiste na base de dados
    $this->setAttributes($aDados);

    $this->em->persist($this->entity);
    $this->em->flush();

    $this->oIrregularidadeInterface->salvarIrregularidade($this);

    // Gera o código hash para autenticação
    $this->salvarCodigoHash($this->getNota());

    return TRUE;
  }

  /**
   * Retorna a data e hora de emissão da nota
   *
   * @tutorial
   *  Caso nenhuma data válida for informada, retorna a data do sistema
   *  Se for informado uma data como string 'dd/mm/yyyy' ou 'dd/mm/yyyy H:i:s' converte para DateTime
   * @param string|datetime|null $uData
   * @return DateTime
   */
  public static function getDateTime($uData = NULL) {

    if ($uData instanceof DateTime) {
      return $uData;
    }

    if (is_string($uData)) {

      // Ajusta a hora, caso não tenha sido informada
      if (strlen($uData) <= 10) {
        $uData = $uData . date(' H:i:s');
      }

      return new DateTime($uData);
    }

    return new DateTime();
  }

  /**
   * Salva email do tomador na tabela tomador_email
   *
   * @param string $sCpf   CPF do tomador
   * @param string $sEmail Email do tomador
   */
  public function salvaEmailTomador($sCpf, $sEmail) {

    $oTomadorEmail = Contribuinte_Model_EmpresaEmail::getByAttribute('cpfcnpj', $sCpf);

    if ($oTomadorEmail === NULL) {

      $oTomadorEmail = new Contribuinte_Model_EmpresaEmail();
      $oTomadorEmail->setCpfcnpj($sCpf);
    }

    $oTomadorEmail->persist(array('email' => $sEmail));
  }

  /**
   * Retorna a data formatada
   *
   * @return string
   */
  public function formatedData() {

    return $this->getDt_nota()->format('d/m/Y');
  }

  /**
   * Retorna a hora formatada
   *
   * @return string
   */
  public function formatedHora() {

    return strftime('%H:%M', $this->getHr_nota()->getTimestamp());
  }

  /**
   * Retorna a competencia formatada
   *
   * @return string
   */
  public function getComp() {

    return "{$this->getMes_comp()}/{$this->getAno_comp()}";
  }

  /**
   * Retorna o pais do prestador
   *
   * @return string
   */
  public function getPrestadorPais() {

    $pais = Default_Model_Cadenderpais::getByAttribute('cod_bacen', $this->getP_cod_pais());

    if ($pais == NULL || empty($pais)) {
      return '';
    }

    return $pais->getNome();
  }

  /**
   * Retorna o municipio do prestador
   *
   * @return string
   */
  public function getPrestadorMunicipio() {

    $oMunicipio = Default_Model_Cadendermunicipio::getByAttribute('cod_ibge', $this->getP_cod_municipio());

    if ($oMunicipio == NULL || empty($oMunicipio)) {
      return '';
    }

    return $oMunicipio->getNome();
  }

  /**
   * Retorna o pais do tomador
   *
   * @return string
   */
  public function getTomadorPais() {

    $oPais = Default_Model_Cadenderpais::getByAttribute('cod_bacen', $this->getT_cod_pais());

    if ($oPais == NULL || empty($oPais)) {
      return '';
    }

    return $oPais->getNome();
  }

  /**
   * Retorna o municipio do tomador
   *
   * @return string
   */
  public function getTomadorMunicipio() {

    $oMunicipio = Default_Model_Cadendermunicipio::getByAttribute('cod_ibge', $this->getT_cod_municipio());

    if ($oMunicipio == NULL || empty($oMunicipio)) {
      return '';
    }

    return $oMunicipio->getNome();
  }

  /**
   * Retorna o pais do serviço
   *
   * @return string
   */
  public function getServicoPais() {

    $oPais = Default_Model_Cadenderpais::getByAttribute('cod_bacen', $this->getS_dados_cod_pais());

    if ($oPais == NULL || empty($oPais)) {
      return '';
    }

    return $oPais->getNome();
  }

  /**
   * Retorna o municipio do serviço
   *
   * @return string
   */
  public function getServicoMunicipio() {

    $oMunicipio = Default_Model_Cadendermunicipio::getByAttribute('cod_ibge', $this->getS_dados_municipio_incidencia());

    if ($oMunicipio == NULL || empty($oMunicipio)) {
      return '';
    }

    return $oMunicipio->getNome();
  }

  /**
   * Retorna a descrição do serviço
   *
   * @return string
   */
  public function getDescricaoListaServico() {

    if ($this->descricao_lista_servico === NULL) {
      $this->obtemDadosServico();
    }

    return $this->descricao_lista_servico;
  }

  /**
   * Retorna o substituto tributario
   *
   * @return mixed
   */
  public function getSubstitudoTributario() {

    return Contribuinte_Model_IssRetido::getById($this->getS_dados_iss_retido());
  }

  /**
   * Retorna os dados do serviço
   */
  private function obtemDadosServico() {

    $sDescServico = null;

    if ($this->entity->getS_dados_cod_tributacao()) {

      $servico = Contribuinte_Model_Servico::getByCodServico($this->entity->getS_dados_cod_tributacao());

      if (empty($servico)) {
        $servico = Contribuinte_Model_Servico::getByCnae($this->entity->getS_dados_cod_tributacao());
      }

      if(!empty($servico)){
        $sDescServico = $servico[0]->attr('desc_item_servico');
      }
    }

    $this->descricao_lista_servico = 'Serviço/Atividade Não Informado';
    if (!empty($sDescServico)) {
      $this->descricao_lista_servico = $sDescServico;
    }

  }

  /**
   * Converte valores para float
   *
   * @param string $sString
   * @return float
   */
  private function toFloat($sString) {

    $fRetorno = 0;

    if ($sString != '' && $sString != NULL) {

      $sString  = str_replace('.', '', $sString);
      $fRetorno = str_replace(',', '.', $sString);
    }

    return (float) $fRetorno;
  }

  /**
   * Define o(s) atributos informados na lista
   *
   * @param array $aAtributos ['nome_do_atributo' => 'valor']
   */
  private function setAttributes(array $aAtributos) {

    // Chama todos os set de todos os tributos contidos na array
    foreach ($aAtributos as $sIndice => $sValor) {

      $sMetodo = 'set' . ucfirst($sIndice);

      if (method_exists($this->entity, $sMetodo)) {
        call_user_func_array(array($this->entity, $sMetodo), array($sValor));
      }
    }
  }

  /**
   * Gera o código Hash
   *
   * @param integer $iIdNota
   * @param integer $iContador
   * @return string
   */
  private function gerarCodigoHash($iIdNota, $iContador) {

    // Pega o unixtime atual
    $tTime = time();

    // Gera o hash md5 referente a: "id da nota . unix-time . numero de tentativas" e pega os 8 primeiros caracteres
    $sCodigoHash = substr(md5("{$iIdNota}{$tTime}{$iContador}"), 0, 8);

    return $sCodigoHash;
  }

  /**
   * Salva o código Hash
   *
   * @param integer $iIdNota
   * @param integer $iContador
   * @throws Exception
   */
  private function salvarCodigoHash($iIdNota, $iContador = 0) {

    try {

      $sCodigoHash = $this->gerarCodigoHash($iIdNota, $iContador);

      $this->entity->setCod_verificacao($sCodigoHash);
      $this->em->persist($this->entity);
      $this->em->flush();
    } catch (Exception $oError) {

      /*
       * Pega o código da exceção do banco. Caso o código da exceção seja
       * '23505' (chave única violada) então tenta gerar outro código de verificação.
       * Se for outro código, então mostra a exceção.
       */
      $iCodigoErro = $oError->getPrevious()->getCode();

      if ($iCodigoErro == 23505 && $iContador < 5) {
        $this->salvaCodigo($iIdNota, $iContador + 1);
      } else {

        $this->em->getConnection()->rollback();
        $this->em->close();

        throw new Exception ($oError->getMessage());
      }
    }
  }

  /**
   * Retorna o número para ser utilizado na próxima Nota do contribuinte
   *
   * @param array $aListaContribuinte Lista de contribuintes
   * @return mixed
   */
  private function proximaNotaByContribuinte(array $aListaContribuinte) {

    $sSql   = 'SELECT (COALESCE(MAX(n.nota), MAX(n.nota), 0) + 1)
                 FROM Contribuinte\Nota n
                WHERE n.id_contribuinte in (:id_contribuinte)';
    $oQuery = $this->em->createQuery($sSql);
    $oQuery->setParameter('id_contribuinte', $aListaContribuinte);

    return $oQuery->getSingleScalarResult();
  }

  /**
   * Retorna a quantidade de AIDOFs liberadas para emissão conforme tipo de documento
   *
   * @param null $iCodigoContribuinte
   * @param null $iTipoNota
   * @return int
   * @throws Zend_Exception
   */
  public static function getQuantidadeNotasPendentesByContribuinteAndTipoNota($iCodigoContribuinte = NULL,
                                                                              $iTipoNota = NULL) {

    if (!$iCodigoContribuinte) {
      throw new Zend_Exception('Informe o código do contribuinte');
    }

    if (!$iTipoNota) {
      throw new Zend_Exception('Informe o tipo de documento');
    }

    $oContribuinte = Contribuinte_Model_Contribuinte::getById($iCodigoContribuinte);

    $aFiltro  = array('inscricao_municipal' => $oContribuinte->getInscricaoMunicipal(), 'tipo_documento' => $iTipoNota);
    $aCampos  = array('qntLiberadas');
    $oRetorno = WebService_Model_Ecidade::consultar('getQuantidadeAidofsLiberadas', array($aFiltro, $aCampos));

    if (is_array($oRetorno) && isset($oRetorno[0])) {
      return $oRetorno[0]->quantidade_aidofs_liberadas;
    }

    return 0;
  }

  /**
   * Busca os tipos de nota do e-Cidade
   *
   * @param string $sGrupoNota
   * @param bool   $lRetonarArraySimples
   * @return array
   * @throws Exception
   */
  public static function getTiposNota($sGrupoNota, $lRetonarArraySimples = TRUE) {

    if (!$sGrupoNota) {
      throw new Exception('Informe o Grupo de Nota');
    }

    $aFiltro     = array('codigo_grupo_notaiss' => $sGrupoNota);
    $aCampos     = array('codigo', 'nota', 'descricao', 'codigo_grupo');
    $oWebService = new WebService_Model_Ecidade();
    $aTipoNota   = $oWebService::consultar('getTiposNota', array($aFiltro, $aCampos));

    if (is_array($aTipoNota)) {

      if ($lRetonarArraySimples) {

        foreach ($aTipoNota as $oTipoNota) {
          $aRetorno[$oTipoNota->codigo] = DBSeller_Helper_String_Format::wordsCap($oTipoNota->descricao);
        }
      } else {
        $aRetorno = $aTipoNota;
      }
    }

    return isset($aRetorno) ? $aRetorno : array();
  }

  /**
   * Busca a descricao do tipos de nota do e-Cidade
   *
   * @param string $iTipoNota
   * @param bool   $lRetonarArraySimples
   * @return array
   * @throws Exception
   */
  public static function getDescricaoTipoNota($iTipoNota, $lRetonarArraySimples = TRUE) {

    if (!$iTipoNota) {
      throw new Exception('Informe o tipo de nota');
    }

    $aRetorno    = array();
    $aFiltro     = array('codigo' => $iTipoNota);
    $aCampos     = array('codigo', 'nota', 'descricao', 'codigo_grupo');
    $oWebService = new WebService_Model_Ecidade();
    $aTipoNota   = $oWebService::consultar('getTiposNota', array($aFiltro, $aCampos));

    if (is_array($aTipoNota)) {

      if ($lRetonarArraySimples) {

        foreach ($aTipoNota as $oTipoNota) {
          $aRetorno[$oTipoNota->codigo] = DBSeller_Helper_String_Format::wordsCap($oTipoNota->descricao);
        }
      } else {
        $aRetorno = $aTipoNota;
      }
    }

    return $aRetorno;
  }

  /**
   * Busca dados do tipos de nota do e-Cidade
   *
   * @param string $iTipoNota
   * @return mixed|null|stdClass
   */
  public static function getTipoNota($iTipoNota) {

    if (!$iTipoNota) {

      $oTipoNota               = new stdClass();
      $oTipoNota->codigo       = '';
      $oTipoNota->nota         = '';
      $oTipoNota->descricao    = 'Nota Fiscal de Serviço Eletrônica';
      $oTipoNota->codigo_grupo = '';

      return $oTipoNota;
    }

    // Sessão
    $oSessaoTipoNota = new Zend_Session_Namespace('webservice_contribuinte_tipo_nota');

    // Retorna o tipo de nota da sessão, caso exista
    if (!$iTipoNota && isset($oSessaoTipoNota->lista[$iTipoNota])) {
      return $oSessaoTipoNota->lista[$iTipoNota];
    }

    $aFiltro     = array('codigo' => $iTipoNota);
    $aCampos     = array('codigo', 'nota', 'descricao', 'codigo_grupo');
    $oWebService = new WebService_Model_Ecidade();
    $aTipoNota   = $oWebService::consultar('getTiposNota', array($aFiltro, $aCampos));

    if (count($aTipoNota) > 0) {

      // Salva na sessão para evitar consultas no web service e retorna os dados
      return $oSessaoTipoNota->lista[$iTipoNota] = reset($aTipoNota);
    }

    return NULL;
  }

  /**
   * Retorna a ultima nota emitida do contribuinte
   *
   * @param array $aIdContribuintes lista de id_contribuintes
   * @return null
   */
  public static function getUltimaNotaEmitidaByContribuinte($aIdContribuintes) {

    $oEntityManager = parent::getEm();
    $oQuery         = $oEntityManager->createQueryBuilder();

    $oQuery->select('MAX(n.dt_nota)');
    $oQuery->from('Contribuinte\Nota', 'n');
    $oQuery->where('n.id_contribuinte in(?1)');
    $oQuery->andWhere('n.cancelada <> true');
    $oQuery->setParameters(array('1' => $aIdContribuintes));

    $aResultado = $oQuery->getQuery()->getResult();

    if (is_array($aResultado) && count($aResultado[0]) > 0) {

      foreach ($aResultado[0] as $uData) {
        return $uData;
      }
    }

    return NULL;
  }

  /**
   * Busca o documento por Código de Verificação e CPF/CNPJ do Prestador
   *
   * @param string $sPrestadorCnpjCpf
   * @param string $sCodigoVerificacao
   * @return array|Contribuinte_Model_Nota|null
   * @throws Exception
   */
  public static function getByPrestadorAndCodigoVerificacao($sPrestadorCnpjCpf, $sCodigoVerificacao) {

    if (empty($sPrestadorCnpjCpf)) {
      throw new Exception('Informe o CNPJ do Prestador.');
    }

    if (empty($sCodigoVerificacao)) {
      throw new Exception('Informe o Código de Verificação da NFSe.');
    }

    $oEntityManager    = parent::getEm();
    $oZendFilter       = new Zend_Filter_Digits();
    $sPrestadorCnpjCpf = $oZendFilter->filter($sPrestadorCnpjCpf);
    $oRepositorio      = $oEntityManager->getRepository(static::$entityName);
    $aResultado        = $oRepositorio->findBy(array(
                                                 'cod_verificacao' => $sCodigoVerificacao,
                                                 'p_cnpjcpf'       => $sPrestadorCnpjCpf
                                               ));

    if (count($aResultado) == 0) {
      return NULL;
    }

    if (count($aResultado) == 1) {
      return new Contribuinte_Model_Nota($aResultado[0]);
    }

    $aRetorno = array();

    foreach ($aResultado as $oResultado) {
      $aRetorno[] = new Contribuinte_Model_Nota($oResultado);
    }

    return $aRetorno;
  }

  /**
   * Retorna os valores da NFSE calculado
   *
   * @param stdClass $oParametros
   *                                 $oParametros->perc_deducao;            // Percentual Deducao
   *                                 $oParametros->perc_inss;               // Percentual INSS
   *                                 $oParametros->perc_pis;                // Percentual PIS
   *                                 $oParametros->perc_cofins;             // Percentual COFINS
   *                                 $oParametros->perc_ir;                 // Percentual IR
   *                                 $oParametros->perc_csll;               // Percentual CSLL
   *                                 $oParametros->perc_aliquota;           // Percentual Aliquota
   *                                 $oParametros->vlr_servico;             // Valor Bruto do Serviço
   *                                 $oParametros->vlr_outras_retencoes;    // Valor Outras Retenções
   *                                 $oParametros->vlr_desc_condicionado;   // Valor Desconto Condicionado
   *                                 $oParametros->vlr_desc_incondicionado; // Valor Desconto Incondicionado
   *                                 $oParametros->imposto_retido_tomador;  // Imposto retido pelo tomador
   *                                 $oParametros->deducao_editavel;        // Habilita edição da dedução
   *                                 $oParametros->formatar_valores_ptbr;   // Retorna os valores em formato PTBR
   *                                 $oParametros->incideFora;              // Incide tributação mesmo que fora do Brasil
   * @throws Exception
   * @see DBSeller_Helper_Number_Format
   * @return object stdClass
   */
  public static function calcularValores($oParametros) {

    if (!is_object($oParametros)) {
      throw new Exception('O parâmetro deve ser um objeto com os valores.');
    }

    // Limpa máscaras
    $oParametros->vlr_servico             = DBSeller_Helper_Number_Format::toFloat($oParametros->vlr_servico);
    $oParametros->s_vl_deducoes           = DBSeller_Helper_Number_Format::toFloat($oParametros->s_vl_deducoes);
    $oParametros->perc_aliquota           = DBSeller_Helper_Number_Format::toFloat($oParametros->perc_aliquota);
    $oParametros->vlr_inss                = DBSeller_Helper_Number_Format::toFloat($oParametros->vlr_inss);
    $oParametros->vlr_pis                 = DBSeller_Helper_Number_Format::toFloat($oParametros->vlr_pis);
    $oParametros->vlr_cofins              = DBSeller_Helper_Number_Format::toFloat($oParametros->vlr_cofins);
    $oParametros->vlr_ir                  = DBSeller_Helper_Number_Format::toFloat($oParametros->vlr_ir);
    $oParametros->vlr_csll                = DBSeller_Helper_Number_Format::toFloat($oParametros->vlr_csll);
    $oParametros->vlr_outras_retencoes    = DBSeller_Helper_Number_Format::toFloat($oParametros->vlr_outras_retencoes);
    $oParametros->vlr_desc_condicionado   = DBSeller_Helper_Number_Format::toFloat($oParametros->vlr_desc_condicionado);
    $oParametros->vlr_desc_incondicionado = DBSeller_Helper_Number_Format::toFloat($oParametros->vlr_desc_incondicionado);

    /*
     * Calculo dos os valores
     */
    $oParametros->vlr_base = $oParametros->vlr_servico - $oParametros->s_vl_deducoes;
    $oParametros->vlr_base -= $oParametros->vlr_desc_incondicionado;


    if ($oParametros->servico_nao_incide || $oParametros->exigibilidade == Contribuinte_Model_ContribuinteAbstract::EXIGIBILIDADE_IMUNE || !$oParametros->incideFora) {
      $oParametros->vlr_iss = 0;
    } else {
      $oParametros->vlr_iss = DBSeller_Helper_Number_Format::toFloat($oParametros->vlr_base * ($oParametros->perc_aliquota / 100));
    }

    $oParametros->vlr_liquido = $oParametros->vlr_servico;
    $oParametros->vlr_liquido -= $oParametros->vlr_inss;
    $oParametros->vlr_liquido -= $oParametros->vlr_pis;
    $oParametros->vlr_liquido -= $oParametros->vlr_cofins;
    $oParametros->vlr_liquido -= $oParametros->vlr_ir;
    $oParametros->vlr_liquido -= $oParametros->vlr_csll;
    $oParametros->vlr_liquido -= $oParametros->vlr_outras_retencoes;
    $oParametros->vlr_liquido -= $oParametros->vlr_desc_condicionado;
    $oParametros->vlr_liquido -= $oParametros->vlr_desc_incondicionado;

    // Desconta o ISS do valor liquido se o tomador for o responsavel pelo ISS
    if ($oParametros->imposto_retido_tomador
      && (!$oParametros->isOptanteSimples
        || $oParametros->optanteSimplesCategoria != Contribuinte_Model_ContribuinteAbstract::OPTANTE_SIMPLES_TIPO_MEI || !$oParametros->servico_nao_incide)) {

      $oParametros->vlr_liquido -= $oParametros->vlr_iss;
    }

    // Configura para o formato de moeda PTBR
    if (isset($oParametros->formatar_valores_ptbr) || $oParametros->formatar_valores_ptbr) {

      $oParametros->vlr_servico             = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_servico);
      $oParametros->vlr_liquido             = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_liquido);
      $oParametros->s_vl_deducoes           = DBSeller_Helper_Number_Format::toMoney($oParametros->s_vl_deducoes);
      $oParametros->vlr_base                = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_base);
      $oParametros->vlr_iss                 = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_iss);
      $oParametros->vlr_pis                 = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_pis);
      $oParametros->vlr_cofins              = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_cofins);
      $oParametros->vlr_inss                = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_inss);
      $oParametros->vlr_ir                  = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_ir);
      $oParametros->vlr_csll                = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_csll);
      $oParametros->vlr_outras_retencoes    = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_outras_retencoes);
      $oParametros->vlr_desc_condicionado   = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_desc_condicionado);
      $oParametros->vlr_desc_incondicionado = DBSeller_Helper_Number_Format::toMoney($oParametros->vlr_desc_incondicionado);
    }

    return $oParametros;
  }

  /**
   * Busca o documento por CPF/CNPJ do Prestador e Número do RPS
   *
   * @param string $sPrestadorCnpjCpf
   * @param string $sNumeroRps
   * @return array|Contribuinte_Model_Nota|null
   * @throws Exception
   */
  public static function getByPrestadorAndNumeroRps($sPrestadorCnpjCpf, $sNumeroRps) {

    if (empty($sPrestadorCnpjCpf)) {
      throw new Exception('Informe o CPF/CNPJ do Prestador.');
    }

    if (empty($sNumeroRps)) {
      throw new Exception('Informe o Número do RPS.');
    }

    $oEntityManager    = parent::getEm();
    $oZendFilter       = new Zend_Filter_Digits();
    $sPrestadorCnpjCpf = $oZendFilter->filter($sPrestadorCnpjCpf);
    $oRepositorio      = $oEntityManager->getRepository(static::$entityName);
    $aResultado        = $oRepositorio->findBy(array('p_cnpjcpf' => $sPrestadorCnpjCpf, 'n_rps' => $sNumeroRps));

    if (count($aResultado) == 0) {
      return NULL;
    }

    if (count($aResultado) == 1) {
      return new Contribuinte_Model_Nota($aResultado[0]);
    }

    $aRetorno = array();

    foreach ($aResultado as $oResultado) {
      $aRetorno[] = new Contribuinte_Model_Nota($oResultado);
    }

    return $aRetorno;
  }

  /**
   * Retorna a url criptografada para verificacao da NFSe
   *
   * @param string $sTipoRetornoParametros
   * @return array|string
   */
  public function getUrlVerificacaoNota($sTipoRetornoParametros = 'string') {

    $aUrlVerificacao = array(
      'module'     => 'default',
      'controller' => 'index',
      'action'     => 'autentica',
      'url'        => array(
        'codigo_verificacao' => $this->entity->getCod_verificacao(),
        'prestador_cnpjcpf'  => $this->entity->getP_cnpjcpf()
      )
    );

    return DBSeller_Helper_Url_Encrypt::encrypt($aUrlVerificacao, $sTipoRetornoParametros);
  }

  /**
   * @deprecated
   * @param integer $iInscricaoMunicipal
   * @return Contribuinte_Model_Nota[]
   */
  public static function getNotasRetidasSemGuia($iInscricaoMunicipal) {

    $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

    return self::getNotasRetidasSemGuiaByContribuinte($oContribuinte->getContribuintes());
  }

  /**
   * @deprecated
   * @param integer $iInscricaoMunicipal
   * @return Contribuinte_Model_Nota[]
   */
  public static function getNotasRetidas($iInscricaoMunicipal) {

    $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

    return self::getNotasRetidasByContribuinte($oContribuinte->getContribuintes());
  }

  /**
   * @deprecated
   * @param integer $iInscricaoMunicipal
   * @return Contribuinte_Model_Nota[]
   */
  public static function getNotasPrestador($iInscricaoMunicipal) {

    $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

    return self::getNotasPrestadorByContribuinte($oContribuinte->getContribuintes());
  }

  /**
   * @param $iInscricaoMunicipal
   * @param $iTipoNota
   * @param $iGrupoNota
   *
   * @return mixed
   */
  public static function getNotasEmitidas($iInscricaoMunicipal, $iTipoNota, $iGrupoNota) {

    $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

    return self::getNotasEmitidasByContribuinteAndTipoNotaAndGrupoNota($oContribuinte->getContribuintes(), $iTipoNota, $iGrupoNota);
  }

  /**
   * @deprecated
   * @param integer $iInscricaoMunicipal
   * @return mixed
   */
  public static function getRpsEmitidos($iInscricaoMunicipal) {

    $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

    return self::getRpsEmitidosByContribuinte($oContribuinte->getContribuintes());
  }

  /**
   * @deprecated
   * @param integer $iAnoCompetencia
   * @param integer $iMesCompetencia
   * @param integer $iInscricaoMunicipal
   * @return mixed
   */
  public static function getByCompetenciaIm($iAnoCompetencia, $iMesCompetencia, $iInscricaoMunicipal) {

    $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

    return self::getByCompetenciaAndContribuinte(
               $iAnoCompetencia,
               $iMesCompetencia,
               $oContribuinte->getContribuintes()
    );
  }

  /**
   * @deprecated
   * @param string $iInscricaoMunicipal
   * @param string $iTipoNota
   */
  public static function getQuantidadeNotasPendentes($iInscricaoMunicipal = NULL, $iTipoNota = NULL) {

    $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

    return self::getQuantidadeNotasPendentesByIdContribuinteAndTipoNota(
               $oContribuinte->getContribuintes(),
               $iTipoNota
    );
  }

  /**
   * @deprecated
   * @param integer $iInscricaoMunicipal
   * @return null
   */
  public static function getUltimaNotaEmitida($iInscricaoMunicipal) {

    $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($iInscricaoMunicipal);

    return self::getUltimaNotaEmitidaByContribuinte($oContribuinte->getContribuintes());
  }

  /**
   * Retorna as notas lançadas pelo contribuinte na competencia informada
   *
   * @param array    $aIdContribuinte
   * @param stdClass $oCompetencia
   *                 $oCompetencia->iMes
   *                 $oCompetencia->iAno
   * @param integer  $iNumeroNota
   * @return mixed
   */
  public static function getByContribuinteAndCompetencia(array $aIdContribuinte, stdClass $oCompetencia, $iNumeroNota = NULL) {

    $aCamposPesquisa = array(
      'id_contribuinte' => $aIdContribuinte,
      'ano_comp'        => $oCompetencia->iAno,
      'mes_comp'        => $oCompetencia->iMes
    );

    if (!is_null($iNumeroNota)) {
      $aCamposPesquisa['nota'] = $iNumeroNota;
    }

    $aCamposOrdem    = array('nota' => 'DESC');
    $aResultado      = self::getByAttributes($aCamposPesquisa, $aCamposOrdem);

    return $aResultado;
  }

  /**
   * Retora o Cancelamento da nota
   * @return Contribuinte_Model_CancelamentoNota
   */
  public function getCancelamento() {

    if ($this->getCancelada()) {

      $oCancelamento = Contribuinte_Model_CancelamentoNota::getByAttribute('nota', $this->getId());
      if (!empty($oCancelamento)) {
         return new Contribuinte_Model_CancelamentoNota($oCancelamento);
      }
    }
  }

  /**
   * Buscar notas para o webservice de ConsultaNfse
   * @param array $aParametros
   * @return array
   */
  public static function getNotaByConsultaNfse($aParametros){

    $oEntityManager = parent::getEm();
    $oQuery         = $oEntityManager->createQueryBuilder();

    $oQuery->select('n');
    $oQuery->from('Contribuinte\Nota', 'n');
    $oQuery->where('n.p_cnpjcpf = ?1');
    $oQuery->andWhere('n.p_im = ?2');

    $aWhere = array(
      '1' => $aParametros['p_cnpjcpf'],
      '2' => $aParametros['p_im']
    );

    /**
     * Verifica data inicial e data final
     */
    if (isset($aParametros['dt_nota_inicial']) && isset($aParametros["dt_nota_final"])) {

      $oDataInicial = new DateTime($aParametros['dt_nota_inicial']);
      $oDataFinal   = new DateTime($aParametros['dt_nota_final']);

      $oQuery->andWhere('n.dt_nota BETWEEN ?3 and ?4');
      $aWhere['3'] = $oDataInicial->format('Y-m-d');
      $aWhere['4'] = $oDataFinal->format('Y-m-d');
    }

    /**
     * Verifica cnpjcpf do tomador
     */
    if (isset($aParametros["t_cnpjcpf"])) {
      $oQuery->andWhere('n.t_cnpjcpf = ?5');
      $aWhere['5'] = $aParametros["t_cnpjcpf"];
    }

    /**
     * Verifica a inscrição municipal
     */
    if (isset($aParametros["t_im"])) {
      $oQuery->andWhere('n.t_im = ?6');
      $aWhere['6'] = $aParametros["t_im"];
    }

    $oQuery->setParameters($aWhere);
    $aRecord = $oQuery->getQuery()->getResult();

    $aResultado = array();
    foreach ($aRecord as $oRegistro) {
      $aResultado[] = new Contribuinte_Model_Nota($oRegistro);
    }

    unset($aRecord);
    return $aResultado;
  }

  /**
   * Busca as quantidades dos valores das notas por período
   *
   * @param $aParametros
   * @return array
   * @throws Exception
   */
  public function getNotaPorPeriodo($aParametros) {

    try {

      $oEntityManager = parent::getEm();
      $oQuery         = $oEntityManager->createQueryBuilder();

      $sSelect  = 'count(n) as notas,';
      $sSelect .= 'n.p_im,';
      $sSelect .= 'n.p_razao_social,';
      $sSelect .= 'sum(n.vl_liquido_nfse) as vl_liquido_nfse,';
      $sSelect .= 'sum(n.s_vl_iss) as s_vl_iss';

      $oQuery->select($sSelect);
      $oQuery->from('Contribuinte\Nota', 'n');

      /**
       * Verifica data inicial e data final
       */
      if (isset($aParametros['data_nota_inicial']) && isset($aParametros["data_nota_final"])) {

        $oDataInicial = new DateTime(str_replace("/", "-", $aParametros['data_nota_inicial']));
        $oDataFinal   = new DateTime(str_replace("/", "-", $aParametros['data_nota_final']));

        $oQuery->andWhere('n.dt_nota BETWEEN :dt_nota_inicial and :dt_nota_final');
        $aWhere['dt_nota_inicial'] = $oDataInicial->format('Y-m-d');
        $aWhere['dt_nota_final']   = $oDataFinal->format('Y-m-d');
      }

      if (!empty($aParametros['natureza_operacao'])) {
        $oQuery->andWhere("n.natureza_operacao = {$aParametros['natureza_operacao']}");
      }

      if (!empty($aParametros['s_dados_iss_retido'])) {
        $oQuery->andWhere("n.s_dados_iss_retido = {$aParametros['s_dados_iss_retido']}");
      }

      $oQuery->setParameters($aWhere);
      $oQuery->groupBy('n.id_contribuinte, n.p_im, n.p_razao_social');
      $aResultado = $oQuery->getQuery()->getResult();

      return $aResultado;
    } catch (Exception $e) {
      throw $e;
    }
  }

  /**
   * Retorna os dados para a emissão da nfse
   *
   * @param string $sCodigoVerificacao
   * @param object $oNota
   * @param object $oPrefeitura
   * @return array
   */
  public static function getDadosEmissao($sCodigoVerificacao, $oNota, $oPrefeitura) {

    /**
     * Verifica se os dados foram enviados pela verificar de autenticidade sem nescessidade de estar logado ao sistema
     */
    if ($oNota->getId_contribuinte()) {
      $oPrestador = Contribuinte_Model_Contribuinte::getById($oNota->getId_contribuinte());
    } else {
      $oPrestador = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($oNota->getP_im());
    }

    $oBaseUrlHelper   = new Zend_View_Helper_BaseUrl();
    $oServerUrlHelper = new Zend_View_Helper_ServerUrl();

    // Calcula e divide a quantidade de páginas conforme os dados descritos no campo de 'Descrição do Serviço'
    $iTamanhoTotalTexto = strlen($oNota->getS_dados_discriminacao());
    $iQndPaginas        = ($iTamanhoTotalTexto > 800) ? 2 : 1;
    $aDados             = array();

    // Quebra os modelos de nota em páginas conforme os dados descritos no campo de 'Descrição do Serviço'
    for ($iIndex = 1; $iIndex <= $iQndPaginas; $iIndex++) {

      // Dados de manipulação do cabeçalho
      $oDadosCabecalho                   = new StdClass();
      $oDadosCabecalho->sBrasao          = $oBaseUrlHelper->baseUrl('/global/img/brasao.jpg');
      $oDadosCabecalho->oDadosPrefeitura = $oPrefeitura;

      if (getenv('APPLICATION_ENV') != 'production') {
        $oDadosCabecalho->sUrlTarja = $oBaseUrlHelper->baseUrl('/administrativo/img/nfse/tarja_sem_valor.png');
      } else if ($oNota->getIdNotaSubstituta()) {
        $oDadosCabecalho->sUrlTarja = $oBaseUrlHelper->baseUrl('/administrativo/img/nfse/tarja_substituida.png');
      } else if ($oNota->getCancelada()) {
        $oDadosCabecalho->sUrlTarja = $oBaseUrlHelper->baseUrl('/administrativo/img/nfse/tarja_cancelada.png');
      }

      // Gera o QRCode apenas para os modelos que exibem o mesmo
      if (in_array($oPrefeitura->getModeloImpressaoNfse(), array(2, 3, 5))) {

        $aVerificacao = array(
                              'module' => 'auth',
                              'controller' => 'nfse',
                              'action' => 'autenticar-post',
                              'prestador_cnpjcpf' => $oNota->getP_cnpjcpf(),
                              'codigo_verificacao' => $sCodigoVerificacao
                            );
        $sUrlVerificada = DBSeller_Helper_Url_Encrypt::encrypt(array('module'     => 'default',
                                                                     'controller' => 'index',
                                                                     'action'     => 'autentica',
                                                                     'url'        => $aVerificacao));//"codigo_verificacao/{$sCodigoVerificacao}/prestador_cnpjcpf/{$oNota->getP_cnpjcpf()}"));

        $sQRCodeImagem = DBSeller_Helper_QRCode_QRCode::getQrCodeNfse($sUrlVerificada,
                                                                      $sCodigoVerificacao);
        $oDadosCabecalho->sQRCode = $oBaseUrlHelper->baseUrl("/tmp/{$sQRCodeImagem}");
      }

      // Verifica o regime tributário considerando a regra do simples
      if ($oNota->getS_dec_simples_nacional() == 1) {
        $sDescRegime = Contribuinte_Model_Contribuinte::getCategoriaSimplesByCodigo($oNota->getP_categoria_simples_nacional());
      } else {
        $sDescRegime = Contribuinte_Model_Contribuinte::getRegimeTributarioByCodigo($oNota->getS_dec_reg_esp_tributacao());
      }

      // Dados de manipulação do prestador
      $oDadosPrestador                             = new StdClass();
      $oDadosPrestador->sDescricaoRegimeTributario = $sDescRegime;
      $oDadosPrestador->sDescricaoOptanteSimples   = ($oNota->getS_dec_simples_nacional() == 1) ? 'Sim' : 'Não';
      $oDadosPrestador->sDescricaoExibilidade      = Contribuinte_Model_Contribuinte::getExibilidadeByCodigo($oNota->getS_dados_exigibilidadeiss());
      $oDadosPrestador->oPrestador                 = $oPrestador;
      $sLogoPrestador                              = Administrativo_Model_Empresa::getLogoByIm($oNota->getP_im());
      $oDadosPrestador->sLogoPrestador             = $oBaseUrlHelper->baseUrl("/tmp/{$sLogoPrestador}");

      // Dados de manipulação do serviço
      $oDadosServico             = new StdClass();
      $oDadosServico->oDadosNota = $oNota;

      // Verifica se não é a primeira página que será impressa e quebra as demais 'Descrição do Serviço'
      $iInicioCaracterPagina = 0;
      $iQndCaracterPagina    = 800;
      if ($iIndex == 2)  {

        $iInicioCaracterPagina = 800;
        $iQndCaracterPagina    = $iTamanhoTotalTexto;
      }

      $sDiscriminacaoServico = substr($oNota->getS_dados_discriminacao(), $iInicioCaracterPagina, $iQndCaracterPagina);
      $oDadosServico->sDiscriminacaoServico = $sDiscriminacaoServico;

      // Dados de manipulação da nota subtstituida
      $iIdNotaSubstituida = $oNota->getIdNotaSubstituida();
      if ($iIdNotaSubstituida) {
        $oDadosServico->oDadosNotaSubstituida = Contribuinte_Model_Nota::getById($iIdNotaSubstituida);
      }

      $oRegistro = new StdClass();
      $oRegistro->iPagina         = $iIndex;
      $oRegistro->oDadosCabecalho = $oDadosCabecalho;
      $oRegistro->oDadosPrestador = $oDadosPrestador;
      $oRegistro->oDadosServico   = $oDadosServico;

      $aDados[] = $oRegistro;
    }

    return $aDados;
  }

  /**
   * Método para ver se a nota pode ser cancelada ou não
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte Model do contribuinte
   * @return boolean
   */
  public function podeCancelar(Contribuinte_Model_ContribuinteAbstract $oContribuinte = NULL) {

    // Se o contribuinte não foi passado para o metodo busca ele pelo id_contribuinte da Nota
    if (is_null($oContribuinte)) {
      $oContribuinte = Contribuinte_Model_Contribuinte::getById($this->getId_contribuinte());
    }

    $oNota                    = $this->getEntity();
    $lExisteGuia              = Contribuinte_Model_Guia::existeGuia($oContribuinte,
                                                                   $oNota->getMes_comp(),
                                                                   $oNota->getAno_comp(),
                                                                   Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE);

    $oSolicitacaoCancelamento = Contribuinte_Model_SolicitacaoCancelamento::getByAttribute('nota', $oNota);

    $uDataUltimaNota = Contribuinte_Model_Nota::getUltimaNotaEmitidaByContribuinte($oContribuinte->getContribuintes());
    $oDataUltimaNota = new DateTime($uDataUltimaNota);

    $oCompetencia             = new Contribuinte_Model_Competencia($oNota->getAno_comp(), $oNota->getMes_comp(), $oContribuinte);
    $aCompetenciaSemMovimento = $oCompetencia->getDeclaracaoSemMovimento();

    $oParametrosPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();

    // Calcula a diferença entre o dia atual e a data de emissão da nota
    $oDataCorrente = new DateTime();
    $oDiff =  $oDataCorrente->diff(new DateTime($oNota->getDt_nota()->format("Y-m-d")), TRUE);

    // Permite cancelar a nota se ela estiver dentro do prazo de retroatividade de emissão e sem guia da competencia emitida
    if (!$lExisteGuia && !$oNota->getCancelada() && !$oNota->getImportada() && empty($oSolicitacaoCancelamento)
        && ($oNota->getAno_comp() < $oDataUltimaNota->format('Y')
            || ($oNota->getAno_comp() == $oDataUltimaNota->format('Y') && $oNota->getMes_comp() < $oDataUltimaNota->format('m')))) {
      return TRUE;
    } else if  ($oNota->getAno_comp() < $oDataUltimaNota->format('Y')) {
      return FALSE;
    } else if ($oNota->getAno_comp() == $oDataUltimaNota->format('Y')
               && $oNota->getMes_comp() < $oDataUltimaNota->format('m')) {
      return FALSE;
    } else if ($oNota->getCancelada() || $lExisteGuia || $oNota->getImportada() || !empty($oSolicitacaoCancelamento)) {
      return FALSE;
    } else if (isset($aCompetenciaSemMovimento[0]) && $oNota->getAno_comp() < $aCompetenciaSemMovimento[0]->ano) {
      return FALSE;
    } else if (isset($aCompetenciaSemMovimento[0])
               && $oNota->getAno_comp() == $aCompetenciaSemMovimento[0]->ano
               && $oNota->getMes_comp() <= $aCompetenciaSemMovimento[0]->mes) {

      return FALSE;
    }

    return TRUE;
  }

  /**
   * Método para verificar se o serviço foi prestado no municipio
   *
   * @param array $aDados array de dados da nota
   * @return boolean|string Mensagem de validação
   */
  private function servicoPrestadoMunicipio($aDados) {

    $oParametrosPrefeitura = Administrativo_Model_ParametroPrefeitura::getAll();
    if ($aDados['s_dados_municipio_incidencia'] == $oParametrosPrefeitura[0]->getIbge()) {
      if ($aDados['natureza_operacao'] == '2') {
        return 'A tributação deve ser no município.';
      }
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Método para aplicar a regra de Tomador substituto tributario
   * caso o usuário faça injection no formulário/POST
   *
   * @param array $aDados
   * @return boolean|string Mengassem de validação
   */
  private function ruleTomadorSubistitutoTributario($aDados) {

    if (!empty($aDados['t_cnpjcpf'])) {

      $iCnpjCpfTomador = DBSeller_Helper_Number_Format::unmaskCPF_CNPJ($aDados['t_cnpjcpf']);
      // Obtem os dados do tomador no e-Cidade
      $oTomador = Contribuinte_Model_Empresa::getByCgcCpf($iCnpjCpfTomador);

      if (!empty($oTomador->eCidade)) {
        $oTomador = $oTomador->eCidade;
      } else if (!empty($oTomador->eNota)) {
        $oTomador = $oTomador->eNota;
      } else {
        // Se o tomador não existe no e-Cidade
        return TRUE;
      }

      $oTomador = array_map(function($v) { return $v->toObject(); }, $oTomador);

      // Tomador é substituto tributario e é do municipio do sistema
      if ($oTomador[0]->substituto_tributario && $oTomador[0]->cod_ibge == $aDados['s_dados_municipio_incidencia']) {

        if ($aDados['natureza_operacao'] != '1') {
          return 'A tributação deve ser no municipio';
        } else if ($aDados['s_dados_iss_retido'] != '1') {
          return 'A tributação deve ser retida no Tomador';
        }

        return TRUE;
      }

      return TRUE;
    } else if (isset($aDados['s_dados_iss_retido']) && $aDados['s_dados_iss_retido'] == '2') {
      return 'Não pode reter no tomador';
    }
    return TRUE;
  }

  private function ruleServicoRetemForaMunicipio($aDados) {

    $iIdServico = $aDados['s_dados_cod_tributacao'];
    $oServicos = Contribuinte_Model_Servico::getByCodServico($iIdServico, FALSE);
    if (empty($oServicos)) {
      $oServicos = Contribuinte_Model_Servico::getServicoPorAtividade($aDados['p_im'], $aDados['s_dados_item_lista_servico'], FALSE, NULL, $aDados['s_dados_cod_tributacao']);
    }
    $oServicos = is_array($oServicos) ? $oServicos[0] : $oServicos;

    // Obriga reter no municipio?
    if ($oServicos->attr('tributacao_municipio') == 't'){
      if ($aDados['s_dados_iss_retido'] == 1) {
        return 'O serviço não pode ser retido pelo tomador';
      }
      if ($aDados['natureza_operacao'] != 1) {
        return 'O serviço não pode ser tributado fora do município';
      }
    }
    return TRUE;
  }


  /**
   * Método para obter a entidade do Administrativo_Model_UsuarioContribuinte
   * pelo id_contribuinte da Nota
   *
   * @return Administrativo_Model_UsuarioContribuinte
   */
  public function getContribuinte() {

    $iIdContribuinte = $this->getId_contribuinte();
    $oContribuinte = Administrativo_Model_UsuarioContribuinte::getById($iIdContribuinte);

    return $oContribuinte->getEntity();
  }

  /**
   * Obtem a quantidade de NFS-e emitidas com requisição de Aidof do contribuinte
   * @param Contribuinte_Model_Contribuinte $oContribuinte
   * @return integer $iQuantidade Quantidade de notas
   * @throw Exception
   */
  public static function getQuantidadeNotasAidofContribuinte($oContribuinte) {

    try {

      $sCodigosContribuintes = NULL;

      $oEntityManager = parent::getEm();
      $oQuery         = $oEntityManager->createQueryBuilder();

      foreach ($oContribuinte->getContribuintes() as $iIdContribuinte) {

        if ($sCodigosContribuintes == NULL) {
          $sCodigosContribuintes .= $iIdContribuinte;
        } else {
          $sCodigosContribuintes .= ',' . $iIdContribuinte;
        }
      }

      $oQuery->select('count(n) as quantidade');
      $oQuery->from('Contribuinte\Nota', 'n');
      $oQuery->where("n.id_contribuinte in ({$sCodigosContribuintes})");
      $oQuery->andWhere("n.requisicao_aidof = true");

      $aResultado = $oQuery->getQuery()->getResult();
      $iQuantidade = $aResultado[0]['quantidade'];

      return $iQuantidade;

    } catch (Exception $e) {
      throw $e;
    }
  }

/**
   * Retorna o valor do imposto retido na nota
   * @return float
   */
  public function getValorImpostoRetido() {

    if ($this->entity->getS_dados_iss_retido() == 2) {
      return $this->entity->getS_vl_iss();
    } else {
      return 0.00;
    }

  }

  /**
   * Retorna a situação da nota
   * podendo receber a entidade da nota ou o id
   *
   * @param  Contribuinte_Model_nota $oNota   Entidade da nota
   * @param  integer $iIdNota Id da nota
   * @return string          Descrição da Situação da Nota
   */
  public static function getNotaSituacao($oNota = NULL, $iIdNota = NULL){

    if (!is_object($oNota) && !empty($iIdNota)) {
      $oNota = Contribuinte_Model_Nota::getByAttribute('id', $iIdNota);
    }

    $oContribuinte = Contribuinte_Model_Contribuinte::getById($oNota->getId_contribuinte());
    $lGuiaEmitida  = Contribuinte_Model_Guia::existeGuia($oContribuinte,
                                                        $oNota->getMes_comp(),
                                                        $oNota->getAno_comp(),
                                                        Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE);

    $sSituacao = null;

    /* Situação disponivel para todos os casos */
    if ($oNota->getIdNotaSubstituta()) {
      $sSituacao .= 'Nota Substituida';
    } else if ($oNota->getCancelada()) {
      $sSituacao .= 'Cancelada';
    } else if (!empty($oSolicitacaoCancelamento)) {
      $sSituacao .= 'Cancelamento Solicitado';
    /* Guia Emitida/Importada */
    } else if ($lGuiaEmitida) {
      $sSituacao .='Guia Emitida';
    } else if ($oNota->getImportada()) {
      $sSituacao .= 'Importada';
    } else {
      $sSituacao .= ' - ';
    }

    return $sSituacao;
  }

 /**
   * Busca as RPS que foram emitidas por inscrição municiapal
   * @param  string  $sCampos             Campos de retorno
   * @param  integer $iInscricaoMunicipal Inscricao Municipal
   * @return array                        Array de RPS com as notas
   */
  public static function getRpsEmitidasByInscricao($sCampos = "*", $iInscricaoMunicipal = NULL) {

    $oQueryBuilder = Global_Lib_Model_Doctrine::getQuery();
    $oQueryBuilder->select($sCampos);

    $oQueryBuilder->from('Contribuinte\Nota', 'n');

    $oQueryBuilder->innerJoin('Administrativo\UsuarioContribuinte', 'uc', 'WITH', 'uc.id = n.id_contribuinte');
    $oQueryBuilder->innerJoin('Administrativo\Usuario', 'u', 'WITH', 'u.id = uc.id_usuario');
    $oQueryBuilder->andWhere("n.n_rps is not null");

    if (!empty($iInscricaoMunicipal) && $iInscricaoMunicipal != 0) {
      $oQueryBuilder->andWhere("uc.im  = {$iInscricaoMunicipal}");
    }

    $oQueryBuilder->orderBy('uc.cnpj_cpf, n.id', 'DESC');

    return $oQueryBuilder->getQuery()->getArrayResult();
  }

  /**
   * Retorna a data da primeira nota emitida do contribuinte
   *
   * @param array $aIdContribuintes lista de id_contribuintes
   * @return null
   */
  public static function getDataPrimeiraNotaEmitidaByContribuinte($aIdContribuintes) {

    $oEntityManager = parent::getEm();
    $oQuery         = $oEntityManager->createQueryBuilder();

    $oQuery->select('MIN(n.dt_nota)');
    $oQuery->from('Contribuinte\Nota', 'n');
    $oQuery->where('n.id_contribuinte in(?1)');
    $oQuery->andWhere('n.cancelada <> true');
    $oQuery->andWhere('n.importada <> true');
    $oQuery->setParameters(array('1' => $aIdContribuintes));

    $aResultado = $oQuery->getQuery()->getResult();

    if (is_array($aResultado) && count($aResultado[0]) > 0) {

      foreach ($aResultado[0] as $uData) {
        return $uData;
      }
    }

    return NULL;
  }


}
