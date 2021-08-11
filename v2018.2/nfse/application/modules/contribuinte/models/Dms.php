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
 * Modelo para manipulação de DMS
 *
 * @package Contribuinte/Model
 * @see     Contribuinte_Lib_Model_Doctrine
 */

/**
 * @package Contribuinte/Model
 * @see     Contribuinte_Lib_Model_Doctrine
 */
class Contribuinte_Model_Dms extends Contribuinte_Lib_Model_Doctrine {

  /**
   * Nome da entidade doctrine
   *
   * @var string
   */
  static protected $entityName = 'Contribuinte\Dms';

  /**
   * Nome da classe
   *
   * @var string
   */
  static protected $className = __CLASS__;

  /**
   * Tipo de DMS de serviços tomados
   *
   * @var string
   */
  CONST ENTRADA = 'e';

  /**
   * Tipo de DMS de serviços prestados
   *
   * @var string
   */
  CONST SAIDA = 's';

  /**
   * Instancia uma nova DMS
   *
   * @param object|string|null $uEntity nome ou instancia da entidade
   */
  public function __construct($uEntity = NULL) {

    parent::__construct($uEntity);
  }

  /**
   * Salva os dados da DMS atraves da Entidade
   *
   * @return mixed
   */
  public function persist() {

    $oEntityManager = $this->getEm();
    $oEntityManager->persist($this->entity);
    $oEntityManager->flush();

    return $this->getId();
  }

  /**
   * Informacoes da Dms filtrando por inscricao municipal, competencia e operacao.
   *
   * @param string|null $sCpfCnpj  CPF/CNPJ do Contribuinte
   * @param integer     $iMes      Mês da competência
   * @param integer     $iAno      Ano da competência
   * @param string      $sOperacao Tipo da Operacao Contribuinte_Model_Dms::SAIDA|Contribuinte_Model_Dms::ENTRADA
   * @return array
   * @throws Exception
   */
  public static function getCompetenciaByCpfCnpj($sCpfCnpj = NULL, $iMes, $iAno, $sOperacao = self::SAIDA) {

    if ($sCpfCnpj == NULL) {
      throw new Exception ('Parametro Cnpj/Cpf é obrigatório.');
    }

    $aUsuariosContribuintes = Administrativo_Model_UsuarioContribuinte::getByAttribute('cnpj_cpf', $sCpfCnpj);

    if (!is_array($aUsuariosContribuintes)) {
      $aUsuariosContribuintes = array($aUsuariosContribuintes);
    }

    $aContribuintes = array();

    foreach ($aUsuariosContribuintes as $oContribuinte) {
      $aContribuintes[] = $oContribuinte->getId();
    }

    $sCampoPesquisa = array(
      'id_contribuinte' => $aContribuintes,
      'ano_comp'        => $iAno,
      'mes_comp'        => $iMes,
      'operacao'        => $sOperacao
    );

    $sCamposOrdem = array('id' => 'DESC');

    return self::getByAttributes($sCampoPesquisa, $sCamposOrdem);
  }

  /**
   * Retorna todas as DMS da Competencia.
   * Informacoes das dms e suas respectivas notas filtrados por operacao, inscricao municipal e competencia
   *
   * @param array   $aIdContribuintes Id do contribuinte
   * @param integer $iAno             Ano da competência
   * @param integer $iMes             Mês da competência
   * @param string  $sOperacao        Tipo da Operacao
   * @return array
   */
  public static function getDadosPorCompetencia($aIdContribuintes, $iAno, $iMes, $sOperacao = self::SAIDA) {

    $oEntidade = self::getEm();
    $sDql      = 'SELECT e FROM Contribuinte\Dms e
                   WHERE e.id_contribuinte in (:id_contribuinte)
                     AND e.ano_comp        = :ano
                     AND e.mes_comp        = :mes
                     AND e.operacao        = :operacao';
    $oQuery    = $oEntidade->createQuery($sDql);
    $oResult   = $oQuery->setParameters(array(
                                          'id_contribuinte' => $aIdContribuintes,
                                          'ano'             => $iAno,
                                          'mes'             => $iMes,
                                          'operacao'        => $sOperacao
                                        ))->getResult();

    if (count($oResult) > 0) {

      foreach ($oResult as $oDadosDms) {

        $sAnoCompetencia = $oDadosDms->getAnoCompetencia();
        $sMesCompetencia = $oDadosDms->getMesCompetencia();

        if (isset($aRetorno[$sAnoCompetencia][$sMesCompetencia])) {

          $aRetorno[$sAnoCompetencia][$sMesCompetencia]->iQuantidadeNotas += count($oDadosDms->getDmsNotas());

          foreach ($oDadosDms->getDmsNotas() as $oDadosNota) {

            $aRetorno[$sAnoCompetencia][$sMesCompetencia]->fValorTotalNotas += $oDadosNota->getServicoValorPagar();
            $aRetorno[$sAnoCompetencia][$sMesCompetencia]->fValorTotalImposto += $oDadosNota->getServicoAliquota();
          }

          continue;
        }

        $aRetorno[$sAnoCompetencia][$sMesCompetencia]                     = new StdClass();
        $aRetorno[$sAnoCompetencia][$sMesCompetencia]->fValorTotalNotas   = 0;
        $aRetorno[$sAnoCompetencia][$sMesCompetencia]->fValorTotalImposto = 0;
        $aRetorno[$sAnoCompetencia][$sMesCompetencia]->iQuantidadeNotas   = count($oDadosDms->getDmsNotas());

        foreach ($oDadosDms->getDmsNotas() as $oDadosNota) {

          $aRetorno[$sAnoCompetencia][$sMesCompetencia]->fValorTotalNotas += $oDadosNota->getServicoValorPagar();
          $aRetorno[$sAnoCompetencia][$sMesCompetencia]->fValorTotalImposto += $oDadosNota->getServicoAliquota();
        }

        $aRetorno[$sAnoCompetencia][$sMesCompetencia]->oNotas = $oDadosDms->getDmsNotas();
      }
    }

    return isset($aRetorno) ? $aRetorno : array();
  }

  /**
   * Retorna Notas do Dms filtrando por id do Dms
   *
   * @param Contribuinte_Model_ContribuinteAbstract $oContribuinte Instância do contribuinte
   * @param integer                                 $iAno          Ano da competência
   * @param integer                                 $iMes          Mês da competência
   * @param string                                  $sOperacao     Tipo de operação
   * @return Contribuinte_Model_Dms[] Coleção de contribuinte
   */
  public static function getDMSSemGuiaNaCompetencia(Contribuinte_Model_ContribuinteAbstract $oContribuinte,
                                                    $iAno,
                                                    $iMes,
                                                    $sOperacao = self::SAIDA) {

    $sDql      = 'SELECT e FROM Contribuinte\Dms e
                   WHERE e.id_contribuinte in(:id_contribuinte) AND
                         e.operacao         = :operacao         AND
                         e.ano_comp         = :ano              AND
                         e.mes_comp         = :mes              AND
                         e.codigo_planilha  IS NULL             AND
                        (e.status           = \'fechado\' OR e.status = \'emitida\')';
    $oEntidade = self::getEm();
    $sQuery    = $oEntidade->createQuery($sDql);
    $oResult   = $sQuery->setParameters(array(
                                          'id_contribuinte' => $oContribuinte->getContribuintes(),
                                          'mes'             => $iMes,
                                          'ano'             => $iAno,
                                          'operacao'        => $sOperacao
                                        ))->getResult();

    if (count($oResult) > 0) {

      foreach ($oResult as $oRetorno) {
        $aRetorno[] = new self($oRetorno);
      }
    }

    return isset($aRetorno) ? $aRetorno : array();
  }

  /**
   * Calcula Valores para Dms
   *
   * @param boolean $lTomadorRetemImposto
   * @param string  $fValorServico
   * @param string  $fValorDeducao
   * @param string  $fValorDescontoCondicionado
   * @param string  $fValorDescontoIncondicionado
   * @param string  $fPercentualAliquota
   * @return Array  $aRetorno
   */
  public static function emissaoManualCalculaValoresDms($lTomadorRetemImposto,
                                                        $fValorServico,
                                                        $fValorDeducao,
                                                        $fValorDescontoCondicionado,
                                                        $fValorDescontoIncondicionado,
                                                        $fPercentualAliquota) {

    $fValorServico                = DBSeller_Helper_Number_Format::toDataBase($fValorServico);
    $fValorDeducao                = DBSeller_Helper_Number_Format::toDataBase($fValorDeducao);
    $fValorDescontoCondicionado   = DBSeller_Helper_Number_Format::toDataBase($fValorDescontoCondicionado);
    $fValorDescontoIncondicionado = DBSeller_Helper_Number_Format::toDataBase($fValorDescontoIncondicionado);
    $fPercentualAliquota          = str_replace(',', '.', $fPercentualAliquota);

    // Validacao
    if ($fValorDeducao >= $fValorServico) {
      $fValorDeducao = 0;
    }

    if ($fValorDescontoCondicionado >= $fValorServico) {
      $fValorDescontoCondicionado = 0;
    }

    if ($fValorDescontoIncondicionado >= $fValorServico) {
      $fValorDescontoIncondicionado = 0;
    }

    // Calculos
    $fValorBaseCalculo = $fValorServico - $fValorDeducao - $fValorDescontoIncondicionado;
    $fValorImposto     = $fValorBaseCalculo * ($fPercentualAliquota / 100);
    $fValorLiquido     = $fValorServico - $fValorDescontoCondicionado - $fValorDescontoIncondicionado;

    if ($lTomadorRetemImposto == 1) {
      $fValorLiquido -= $fValorImposto;
    }

    // Retorno Json
    $aRetorno['s_valor_bruto']            = DBSeller_Helper_Number_Format::toMoney($fValorServico);
    $aRetorno['s_valor_deducao']          = DBSeller_Helper_Number_Format::toMoney($fValorDeducao);
    $aRetorno['s_vl_condicionado']        = DBSeller_Helper_Number_Format::toMoney($fValorDescontoCondicionado);
    $aRetorno['s_vl_desc_incondicionado'] = DBSeller_Helper_Number_Format::toMoney($fValorDescontoIncondicionado);
    $aRetorno['s_base_calculo']           = DBSeller_Helper_Number_Format::toMoney($fValorBaseCalculo);
    $aRetorno['s_valor_imposto']          = DBSeller_Helper_Number_Format::toMoney($fValorImposto);
    $aRetorno['s_valor_pagar']            = DBSeller_Helper_Number_Format::toMoney($fValorLiquido);

    return $aRetorno;
  }
}