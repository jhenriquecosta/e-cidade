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
 * Define uma classe para tratamento das notas fiscais emitidas manualmente pelo contribuinte (notas de talão)
 *
 * @package Contribuinte_Model
 */

/**
 * Classe para controle de notas fiscais emitidas manualmente pelo contribuinte (notas de talão)
 *
 * @package Contribuinte_Model
 * @see     Contribuinte_Interface_DocumentoNota
 * @see     Contribuinte_Lib_Model_Doctrine
 */
class Contribuinte_Model_DmsNota extends Contribuinte_Lib_Model_Doctrine
  implements Contribuinte_Interface_DocumentoNota {

  static protected $entityName = 'Contribuinte\DmsNota';
  static protected $className = __CLASS__;

  public function __construct($entity = NULL) {

    parent::__construct($entity);
  }

  public function persist() {

    $oEntity = $this->getEm();
    $oEntity->persist($this->entity);
    $oEntity->flush();

    return TRUE;
  }

  /**
   * Retorna Notas do Dms filtrando por id do Dms
   *
   * @param integer $iIdDms
   * @return \self
   */
  public static function getByIdDms($iIdDms) {

    $oEntidade = self::getEm();
    $sSql      = 'SELECT e 
                    FROM Contribuinte\DmsNota e 
                   WHERE e.id_dms = :id_dms 
                ORDER By e.dt_nota, 
                         e.tipo_documento,
                         e.nota';
    $sQuery    = $oEntidade->createQuery($sSql);
    $oResult   = $sQuery->setParameters(array('id_dms' => $iIdDms))->getResult();
    $aRetorno  = array();

    if (count($oResult) > 0) {

      foreach ($oResult as $oRetorno) {
        $aRetorno[] = new self($oRetorno);
      }
    }

    return $aRetorno;
  }

  /**
   * Retorna o numpre (número prefeitura) do DMS
   *
   * @param int $iIdDms
   * @return int|null
   */
  public static function getNumpreByIdDms($iIdDms) {

    $oEntidade   = self::getEm();
    $sSql        = $oEntidade->createQueryBuilder('nota')
                             ->select('nota.numpre as numpre')
                             ->where('nota.id_dms = :id_dms')
                             ->setParameter(':id_dms', $iIdDms)
                             ->from('Contribuinte\DmsNota', 'nota')
                             ->orderBy('nota.numpre', 'DESC')
                             ->setMaxResults(1);
    $rsQuery     = $sSql->getQuery();
    $rsResultado = $rsQuery->getResult();

    return isset($rsResultado[0]['numpre']) ? $rsResultado[0]['numpre'] : NULL;
  }

  /**
   * Verifica se exista nota emitida com o numero e serie informados
   *
   * @param  Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @param  integer                                 $iTipoDocumento
   * @param  string                                  $sNumero
   * @param  integer                                 $iIdNota
   * @param  string                                  $sOperacao Contribuinte_Model_Dms::SAIDA | Contribuinte_Model_Dms::ENTRADA
   * @return boolean
   *                                                            [TRUE : Existe Nota Emitida]
   */
  public static function checarNotaEmitida(
    Contribuinte_Model_ContribuinteAbstract $oContribuinte,
    $iTipoDocumento = NULL,
    $sNumero = NULL,
    $iIdNota = NULL,
    $sOperacao = Contribuinte_Model_Dms::SAIDA
  ) {

    if (!$sNumero) {
      throw new Exception('Informe o número do documento para checar a emissão.');
    }

    if (!$iTipoDocumento) {
      throw new Exception('Informe o tipo de documento para checar a emissão.');
    }

    if ($sOperacao != Contribuinte_Model_Dms::ENTRADA && $sOperacao != Contribuinte_Model_Dms::SAIDA) {
      throw new Exception('Informa um tipo de operação válida para checar a emissão.');
    }

    if (!is_object($oContribuinte)) {
      throw new Exception('Informe o contribuinte para checar a emissão.');
    }

    $oEntityManager = Zend_Registry::get('em');
    $oQuery         = $oEntityManager->createQueryBuilder();
    $oQuery->select('1');
    $oQuery->from('Contribuinte\DmsNota', 'n');
    $oQuery->leftJoin('Contribuinte\Dms', 'd', \Doctrine\ORM\Query\Expr\Join::WITH, 'n.id_dms = d.id');
    $oQuery->where('n.id_contribuinte   in(:id_contribuinte)');
    $oQuery->andWhere('n.nota           = :nota');
    $oQuery->andWhere('n.tipo_documento = :tipo_documento');
    $oQuery->andWhere('d.operacao       = :operacao');
    $oQuery->setParameter('id_contribuinte', $oContribuinte->getContribuintes());
    $oQuery->setParameter('nota', trim($sNumero));
    $oQuery->setParameter('tipo_documento', $iTipoDocumento);
    $oQuery->setParameter('operacao', $sOperacao);
    $oQuery->setMaxResults(1);

    if ($iIdNota) {

      $oQuery->andWhere('n.id <> :id_nota');
      $oQuery->setParameter('id_nota', $iIdNota);
    }

    $aResultado = $oQuery->getQuery()->getResult();

    if (is_array($aResultado) && count($aResultado) > 0) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Verifica se exista nota emitida com o numero e serie informados
   *
   * @param  Contribuinte_Model_ContribuinteAbstract $oContribuinte
   * @param  string                                  $sTipoDocumentoDescricao
   * @param  string                                  $sNumeroDocumento
   * @param  string                                  $sSerieDocumento
   * @param  integer                                 $iIdDocumento
   * @return boolean
   *           [TRUE : Existe Nota Emitida]
   */
  public static function checarNotaEmitidaPrestadorEventual(
    Contribuinte_Model_ContribuinteAbstract $oContribuinte,
    $sTipoDocumentoDescricao,
    $sNumeroDocumento,
    $sSerieDocumento = NULL,
    $iIdDocumento = NULL
  ) {

    if (empty($oContribuinte)) {
      throw new Exception('Informe um contribuinte válido para checar a emissão');
    }

    if (!$sTipoDocumentoDescricao) {
      throw new Exception('Informe o Tipo de Nota para checar a emissão');
    }

    if (!$sNumeroDocumento) {
      throw new Exception('Informe o Número da Nota para checar a emissão');
    }

    $oEntityManager = parent::getEm();
    $oQuery         = $oEntityManager->createQueryBuilder();
    $oQuery->select('1');
    $oQuery->from('Contribuinte\DmsNota', 'n');
    $oQuery->leftJoin('Contribuinte\Dms', 'd', \Doctrine\ORM\Query\Expr\Join::WITH, 'n.id_dms = d.id');
    $oQuery->where('n.id_contribuinte             in (:id_contribuinte)');
    $oQuery->andWhere('n.nota                     = :nota');
    $oQuery->andWhere('n.tipo_documento_descricao = :tipo_documento_descricao');
    $oQuery->andWhere('d.operacao                 = :operacao');
    $oQuery->setParameter('id_contribuinte', $oContribuinte->getContribuintes());
    $oQuery->setParameter('nota', $sNumeroDocumento);
    $oQuery->setParameter('tipo_documento_descricao', $sTipoDocumentoDescricao);
    $oQuery->setParameter('operacao', 's');
    $oQuery->setMaxResults(1);

    if ($sSerieDocumento) {

      $oQuery->andWhere('n.serie = TRIM(:serie)');
      $oQuery->setParameter('serie', $sSerieDocumento);
    }

    // Verifica se existem outros documentos somente na alteração
    if ($iIdDocumento) {

      $oQuery->andWhere('n.id <> :id_nota');
      $oQuery->setParameter('id_nota', $iIdDocumento);
    }

    $aResultado = $oQuery->getQuery()->getResult();

    if (is_array($aResultado) && count($aResultado) > 0) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Retorna a quantidade de notas emitidas por tipo de documento
   *
   * @param  integer $iInscricaoMunicipal
   * @param  integer $iTipoDocumento
   * @return integer
   */
  public static function getQuantidadeNotasEmitidas($iInscricaoMunicipal, $iTipoDocumento) {

    $sDql   = 'SELECT COUNT(n.id) quantidade_notas_emitidas
               FROM Contribuinte\DmsNota n
               WHERE n.p_im           = :inscricao_municipal
                 AND n.tipo_documento = :tipo_documento ';
    $oQuery = parent::getEm()->createQuery($sDql);
    $oQuery->setParameter('inscricao_municipal', $iInscricaoMunicipal);
    $oQuery->setParameter('tipo_documento', $iTipoDocumento);

    return $oQuery->getSingleScalarResult();
  }

  /**
   * Verifica se exista nota emitida com o numero, serie, tipo documento e inscricao municipal
   *
   * @deprecated       Considerar:
   *                   Contribuinte_Model_DmsNota::checarNotaEmitida()
   *                   Contribuinte_Model_DmsNota::checarNotaEmitidaPrestadorEventual()
   * @param stdclass $oParametro
   *           string   $oParametro->sTipoOperacao
   *           integer  $oParametro->iTipoDocumento
   *           string   $oParametro->sNumero
   *           string   $oParametro->sSerie
   *           integer  $oParametro->iInscricaoMunicipal
   * @return boolean
   *           [TRUE : Existe Nota Emitida]
   */
  public static function existeNotaEmitida($oParametro = NULL) {

    if (!is_object($oParametro)) {
      throw new Exception('Informe o Parâmetro');
    }

    if (!isset($oParametro->sTipoOperacao)) {
      throw new Exception('Informe o Tipo de Operação do Documento');
    }

    if (!isset($oParametro->iTipoDocumento)) {
      throw new Exception('Informe o Tipo do Documento');
    }

    if (!isset($oParametro->sNumero)) {
      throw new Exception('Informe o Número do Documento');
    }

    if (!isset($oParametro->sSerie)) {
      throw new Exception('Informe a Série do Documento');
    }

    if (!isset($oParametro->iInscricaoMunicipal)) {
      throw new Exception('Informe o Contribuinte');
    }

    $oQuery = parent::getEm()->createQueryBuilder();
    $oQuery->select('1');
    $oQuery->from('Contribuinte\DmsNota', 'n');
    $oQuery->leftJoin('Contribuinte\Dms', 'd', \Doctrine\ORM\Query\Expr\Join::WITH, 'n.id_dms = d.id');

    if ($oParametro->sTipoOperacao == 's') {
      $oQuery->where('n.p_im = :im');
    } else {
      $oQuery->where('n.t_im = :im');
    }

    $oQuery->andWhere('d.operacao       = :operacao');
    $oQuery->andWhere('n.tipo_documento = :tipo_documento');
    $oQuery->andWhere('n.nota           = TRIM(:nota)');
    $oQuery->andWhere('n.serie          = :serie');
    $oQuery->setParameter('im', $oParametro->iInscricaoMunicipal);
    $oQuery->setParameter('operacao', $oParametro->sTipoOperacao);
    $oQuery->setParameter('tipo_documento', $oParametro->iTipoDocumento);
    $oQuery->setParameter('nota', $oParametro->sNumero);
    $oQuery->setParameter('serie', $oParametro->sSerie);
    $oQuery->setMaxResults(1);

    $aResultado = $oQuery->getQuery()->getResult();

    return (is_array($aResultado) && count($aResultado) > 0);
  }

  /**
   * Verifica se exista nota emitida, validando: contribuinte + tipo_nota + numero_nota + (id_nota) + cnpj_prestador
   *
   * @param  stdclass $oParametro
   *         Contribuinte_Model_ContribuinteAbstract $oParametro->oContribuinte
   *         string                                  $oParametro->sCnpjPrestador
   *         integer                                 $oParametro->iTipoDocumento
   *         string                                  $oParametro->sNumeroDocumento
   *         integer                                 $oParametro->iCodigoDocumento
   * @return boolean
   *         [TRUE : Existe Nota Emitida]
   */
  public static function checarDocumentoEmitidoServicosTomados($oParametro = NULL) {

    if (!is_object($oParametro)) {
      throw new Exception('Informe um parâmetro válido para checar a emissão do documento.');
    }

    if (!is_object($oParametro->oContribuinte)) {
      throw new Exception('Informe o contribuinte para checar a emissão do documento.');
    }

    if (!$oParametro->sCnpjPrestador) {
      throw new Exception('Informe o CNPJ do prestador para checar a emissão do documento.');
    }

    if (!$oParametro->sNumeroDocumento) {
      throw new Exception('Informe o número do documento para checar a emissão do documento.');
    }

    if (!$oParametro->iTipoDocumento) {
      throw new Exception('Informe o tipo de documento para checar a emissão do documento.');
    }

    $oEntityManager = Zend_Registry::get('em');
    $oQuery         = $oEntityManager->createQueryBuilder();
    $oQuery->select('1');
    $oQuery->from('Contribuinte\DmsNota', 'n');
    $oQuery->leftJoin('Contribuinte\Dms', 'd', \Doctrine\ORM\Query\Expr\Join::WITH, 'n.id_dms = d.id');
    $oQuery->where('n.id_contribuinte   = :id_contribuinte');
    $oQuery->andWhere('n.nota           = :numero_documento');
    $oQuery->andWhere('n.p_cnpjcpf      = :cnpj_prestador');
    $oQuery->andWhere('n.tipo_documento = :tipo_documento');
    $oQuery->andWhere('d.operacao       = :operacao');
    $oQuery->setParameter('id_contribuinte', $oParametro->oContribuinte->getIdUsuarioContribuinte());
    $oQuery->setParameter('numero_documento', trim($oParametro->sNumeroDocumento));
    $oQuery->setParameter('cnpj_prestador', trim($oParametro->sCnpjPrestador));
    $oQuery->setParameter('tipo_documento', $oParametro->iTipoDocumento);
    $oQuery->setParameter('operacao', Contribuinte_Model_Dms::ENTRADA);
    $oQuery->setMaxResults(1);

    if ($oParametro->iCodigoDocumento) {

      $oQuery->andWhere('n.id <> :codigo_documento');
      $oQuery->setParameter('codigo_documento', $oParametro->iCodigoDocumento);
    }

    $aResultado = $oQuery->getQuery()->getResult();

    if (is_array($aResultado) && count($aResultado) > 0) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getId()
   */
  public function getId() {

    return $this->entity->getCodigoNota();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getCompetenciaMes()
   */
  public function getCompetenciaMes() {

    return NULL; // Nao existe, esta no DMS
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getCompetenciaAno()
   */
  public function getCompetenciaAno() {

    return NULL; // Nao existe, esta no DMS
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getCodigoNotaPlanilha()
   */
  public function getCodigoNotaPlanilha() {

    return $this->entity->getCodigoNotaPlanilha();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getNotaNumero()
   */
  public function getNotaNumero() {

    return $this->entity->getNotaNumero();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getNotaData()
   */
  public function getNotaData() {

    return $this->entity->getNotaData();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoAliquota()
   */
  public function getServicoAliquota() {

    return $this->entity->getServicoAliquota();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoImpostoRetido()
   */
  public function getServicoImpostoRetido() {

    return $this->entity->getServicoImpostoRetido();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoBaseCalculo()
   */
  public function getServicoBaseCalculo() {

    return $this->entity->getServicoBaseCalculo();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoValorDeducao()
   */
  public function getServicoValorDeducao() {

    return $this->entity->getServicoValorDeducao();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoValorImposto()
   */
  public function getServicoValorImposto() {

    return $this->entity->getServicoValorImposto();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getServicoValorPagar()
   */
  public function getServicoValorPagar() {

    return $this->entity->getServicoValorPagar();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getSituacaoDocumento()
   */
  public function getSituacaoDocumento() {

    return $this->entity->getSituacaoDocumento();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getDescricaoServico()
   */
  public function getDescricaoServico() {

    return $this->entity->getDescricaoServico();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getPrestadorCpfCnpj()
   */
  public function getPrestadorCpfCnpj() {

    return $this->entity->getPrestadorCpfCnpj();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getPrestadorInscricaoMunicipal()
   */
  public function getPrestadorInscricaoMunicipal() {

    return $this->entity->getPrestadorInscricaoMunicipal();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getPrestadorRazaoSocial()
   */
  public function getPrestadorRazaoSocial() {

    return $this->entity->getPrestadorRazaoSocial();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getTomadorCpfCnpj()
   */
  public function getTomadorCpfCnpj() {

    return $this->entity->getTomadorCpfCnpj();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getTomadorInscricaoMunicipal()
   */
  public function getTomadorInscricaoMunicipal() {

    return $this->entity->getTomadorInscricaoMunicipal();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getTomadorRazaoSocial()
   */
  public function getTomadorRazaoSocial() {

    return $this->entity->getTomadorRazaoSocial();
  }

  /**
   * @see Contribuinte_Interface_DocumentoNota::getOperacao()
   */
  public function getOperacao() {

    return $this->entity->getDms()->getOperacao();
  }
}