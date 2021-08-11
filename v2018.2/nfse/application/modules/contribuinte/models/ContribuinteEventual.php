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
 * Define uma classe para tratamento dos usuarios eventuais
 *
 * @author Iuri Guntchnigg
 * @version $Revision: 1.14 $
 * @package Contribuinte
 */

/**
 * Classe para controle dos usuarios eventais.
 *
 * Os dados da classe são sempre retornados atravez de uma consulta ao ecidade, pelo cgm do contribuinte
 */
final class Contribuinte_Model_ContribuinteEventual
    extends Contribuinte_Model_ContribuinteAbstract implements Contribuinte_Interface_Contribuinte {

  protected $iNumCgm;

  /**
   * Instancia um novo contribuinte eventual
   *
   * @param stdClass $oDadoContribuinteEventual Dados do contribuinte
   */
  public function __construct(stdClass $oDadoContribuinteEventual = NULL) {

  }

  /**
   * Retorna uma instancia de Contribuinte Eventual atravez do codigo do contribuinte.
   *
   * @param integer $iCodigoContribuinte
   * @return Contribuinte_Model_ContribuinteEventual|null|object
   * @throws Exception
   */
  public static function getById($iCodigoContribuinte) {

    $oContribuinte = Administrativo_Model_UsuarioContribuinte::getById($iCodigoContribuinte);

    if ($oContribuinte->getCGM() == '') {
      throw new Exception('Contribuinte eventual não possui CGM.');
    }

    $aParametros = array('cgm' => $oContribuinte->getCGM());
    $oCgm        = WebService_Model_Ecidade::processar('pesquisaCgmByCgm', $aParametros);

    if (!empty($oCgm)) {

      $oContribuinteEventual = Contribuinte_Model_ContribuinteEventual::preencherInstanciaContribuinte($oCgm);
      $oContribuinteEventual->setIdUsuarioContribuinte($oContribuinte->getId());

      return $oContribuinteEventual;
    }

    return NULL;
  }

  /**
   * Retorna o tipo de emissão do contribuinte DMS.
   *
   * Contribuintes eventuais apenas emitem DMS
   * @return integer tipo de emissao
   */
  public function getTipoEmissao() {
    return Contribuinte_Model_ContribuinteAbstract::TIPO_EMISSAO_DMS;
  }

  /**
   * Retorna os dados do contribuinte atraves do Cnpj/cpf vindos do WebService
   * @param $sCpfCnpj
   *
   * @return mixed
   * @throws Exception
   */
  public static function getByCpfCnpjWebService($sCpfCnpj) {

    if ($sCpfCnpj == '') {
      throw new Exception('CPF / CNPJ não informados.');
    }

    $aParametros = array('cpfcnpj' => $sCpfCnpj);
    return WebService_Model_Ecidade::processar('pesquisaCgmByCpfCnpj', $aParametros);
  }


  /**
   * Retorna a instancia do contribuinte atraves do Cnpj/cpf
   *
   * @param string $sCpfCnpj
   * @return bool|Contribuinte_Model_ContribuinteEventual|object
   * @throws Exception
   */
  public static function getByCpfCnpj($sCpfCnpj) {

     $oContribuinte = Administrativo_Model_UsuarioContribuinte::getByAttribute('cnpj_cpf', $sCpfCnpj);

    // Se retornar mais de um contribuinte pega o primeiro da lista
    if (is_array($oContribuinte)) {
      $oContribuinte = reset($oContribuinte);
    }

    if ($oContribuinte->getUsuario()->getCnpj() == '') {
      throw new Exception('Contribuinte eventual não possui CPF / CNPJ.');
    }

    $oCgm = self::getByCpfCnpjWebService($sCpfCnpj);

    if (!empty($oCgm)) {

      $oContribuinteEventual = Contribuinte_Model_ContribuinteEventual::preencherInstanciaContribuinte($oCgm);
      $oContribuinteEventual->setIdUsuarioContribuinte($oContribuinte->getId());

      return $oContribuinteEventual;
    }

    return FALSE;
  }

  /**
   * Preenche os dados do contribuinte pela inscriao municipal.
   * No contribuinte eventual nao podera ser utilizado
   *
   * @param integer $iInscricaoMunicipal
   * @return object|void
   * @throws Exception
   */
  public static function getByInscricaoMunicipal($iInscricaoMunicipal) {

    throw new Exception('Metodo nao disponivel para contribuintes Eventuais');
  }

  /**
   * Retorna o codigo do cgm do contrbuinte eventual
   *
   * @return integer codigo do cgm
   */
  public function getCodigoCgm() {
    return $this->iNumCgm;
  }

  /**
   * Define o numero do cgm
   *
   * @param integer $iCodigoCgm codigo do cgm
   */
  protected function setCodigoCgm($iCodigoCgm) {
    $this->iNumCgm = $iCodigoCgm;
  }

  /**
   * Preenche os dados do CGM
   *
   * @param stdClass $oCgm preenche os dados do cgm
   * @return Contribuinte_Model_ContribuinteEventual
   */
  protected static function preencherInstanciaContribuinte(stdClass $oCgm) {

    $sNumeroCpfCgc         = ($oCgm->lJuridico) ? $oCgm->iCnpj : $oCgm->iCpf;
    $oContribuinteEventual = new Contribuinte_Model_ContribuinteEventual();
    $oContribuinteEventual->setCgm($oCgm->iCodigoCgm);
    $oContribuinteEventual->setCep($oCgm->sCep);
    $oContribuinteEventual->setTipoPessoa($oCgm->lJuridico ? 'Juridico' : 'Fisica');
    $oContribuinteEventual->setCgcCpf($sNumeroCpfCgc);
    $oContribuinteEventual->setTelefone($oCgm->sTelefone);
    $oContribuinteEventual->setDescricaoMunicipio($oCgm->sMunicipio);
    $oContribuinteEventual->setEmail($oCgm->sEmail);
    $oContribuinteEventual->setDescricaoLogradouro($oCgm->sLogradouro);
    $oContribuinteEventual->setLogradouroBairro($oCgm->sBairro);
    $oContribuinteEventual->setLogradouroNumero($oCgm->sNumero);
    $oContribuinteEventual->setLogradouroComplemento($oCgm->sComplemento);
    $oContribuinteEventual->setEstado($oCgm->sUf);
    $oContribuinteEventual->setNome($oCgm->sNome);
    $oContribuinteEventual->setCodigoCgm($oCgm->iCodigoCgm);

    return $oContribuinteEventual;
  }
}