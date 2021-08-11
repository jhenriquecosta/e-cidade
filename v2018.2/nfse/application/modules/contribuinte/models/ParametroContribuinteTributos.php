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
 * Modelo responsável pelo controle dos parametros da tributação aproximada de cada contribuinte
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Contribuinte_Model_ParametroContribuinteTributos extends Contribuinte_Lib_Model_Doctrine {

  static protected $entityName = 'Contribuinte\ParametroContribuinteTributos';
  static protected $className  = __CLASS__;

  // LEI Nº 12.741, DE 8 DE DEZEMBRO DE 2012
  static protected $anoLei = 2012;

  /**
   * Persiste os dados dos parametros da tributação aproximada de cada contribuinte
   */
  public function salvar() {

    $oEntidade = $this->getEntity();
    $this->getEm()->persist($oEntidade);
    $this->getEm()->flush();
  }

  /**
   * Busca os parametros de tributação por contribuinte
   *
   * @param $oUsuarioContribuinte \Administrativo\UsuarioContribuinte | Contribuinte_Model_Contribuinte
   * @param $iAno integer
   * @return null|object
   * @throws Exception
   */
  public static function getParametroByContribuinteAno($oUsuarioContribuinte, $iAno) {

    // Verifica se o usuário contribuinte informado é do tipo UsuarioContribuinte
    if (is_a($oUsuarioContribuinte, 'Contribuinte_Model_Contribuinte')) {

      // Carrega a entidade do UsuarioContribuinte
      $rsUsuarioContribuinte = Administrativo_Model_UsuarioContribuinte::getByAttribute('id', $oUsuarioContribuinte->getContribuintes());
      if (is_array($rsUsuarioContribuinte)) {
        $oUsuarioContribuinte = $rsUsuarioContribuinte[0]->getEntity();
      } else {
        $oUsuarioContribuinte = $rsUsuarioContribuinte->getEntity();
      }
    }

    $aRetorno                    = NULL;
    $aParametros['contribuinte'] = $oUsuarioContribuinte;
    $aParametros['ano']          = $iAno;
    $aParametroTributos          = Contribuinte_Model_ParametroContribuinteTributos::getByAttributes($aParametros);

    if (!empty($aParametroTributos)) {
      $aRetorno = $aParametroTributos[0];
    }

    return $aRetorno;
  }

  /**
   * Busca os dados do parametro de tributação por id
   *
   * @param $Id integer
   * @return null|object
   * @throws Exception
   */
  public static function getParametroById($Id) {

    $aRetorno           = NULL;
    $aParametros['id']  = $Id;
    $aParametroTributos = Contribuinte_Model_ParametroContribuinteTributos::getByAttributes($aParametros);

    if (!empty($aParametroTributos)) {
      $aRetorno = $aParametroTributos[0];
    }

    return $aRetorno;
  }

  /**
   * Busca os períodos do anos compativeis com as configurações de tributos
   *
   * @param $iAnoCorrente integer
   * @return array
   */
  public static function getPeriodos($iAnoCorrente) {

    $iAnoLei        = Contribuinte_Model_ParametroContribuinteTributos::$anoLei;
    $aPeriodoRetono = array();

    // Adiciona a lista de período que corresponde a configuração
    while ($iAnoLei <= $iAnoCorrente) {

      $aPeriodoRetono[$iAnoLei] = $iAnoLei;

      $iAnoLei++;
    }

    if (empty($aPeriodoRetono)) {
      $aPeriodoRetono[$iAnoCorrente] = $iAnoCorrente;
    }

    krsort($aPeriodoRetono);

    return $aPeriodoRetono;
  }

  /**
   * @param $oContribuinte Contribuinte_Model_Contribuinte
   * @param $iAno integer
   * @param $fValorBase float
   * @return null|string
   */
  public static function retornaMensagemTributos($oContribuinte, $iAno, $fValorBase) {

    $oParametroTributos = Contribuinte_Model_ParametroContribuinteTributos::getParametroByContribuinteAno($oContribuinte, $iAno);
    if (!empty($oParametroTributos)) {


      $nPercentual = $oParametroTributos->getPercentualTributos();
      $sValor      = $fValorBase * ($nPercentual/100);
      $sValor      = DBSeller_Helper_Number_Format::toMoney($sValor, 2, 'R$ ');
      $sFonte      = $oParametroTributos->getFonteTributacao();

      return "Valor Aprox. Tributos {$sValor} ({$nPercentual}%) Fonte: {$sFonte}";
    }

    return NULL;
  }

  /**
   * Verifica se existe algum parametro de tributação configurado por ano e contribuinte
   *
   * @param $oContribuinte Contribuinte_Model_Contribuinte
   * @param $iAno integer
   * @return bool
   */
  public static function existeParametro($oContribuinte, $iAno) {

    // Verifica se o contribuinte e optante pelo simples e com o tipo de regime tributário MEI
    if ($oContribuinte->isMEIAndOptanteSimples()) {
      return TRUE;
    }

    // Verifica se o contribuinte possui algum parâmetro de tributação configurado
    $aParametroTributos = Contribuinte_Model_ParametroContribuinteTributos::getParametroByContribuinteAno($oContribuinte, $iAno);
    if (!empty($aParametroTributos) && count($aParametroTributos) > 0) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Retorna a mensagem de aviso quando não existir parâmetros de tributos configurado
   *
   * @return string
   */
  public static function retonaMensagemAvisoSemParametro() {

    $oBaseUrl        = new Zend_View_Helper_BaseUrl();
    $sUrlInformativo = $oBaseUrl->baseUrl('/default/atualizacao/versao/v/1-6-0');

    $sMensagem  = '<h5>Valor aproximado dos tributos na nota:</h5><br>';
    $sMensagem .= 'A partir de agora o valor aproximado dos tributos será exibido nas notas fiscais ';
    $sMensagem .= 'emitidas pelo sistema, a fim de estar em conformidade com a Lei nº 12.741, de 8 de dezembro de 2012.<br>';
    $sMensagem .= 'A lei pode ser consultada no Portal da Legislação (<a href="http://www4.planalto.gov.br/legislacao" target="_blank">';
    $sMensagem .= 'http://www4.planalto.gov.br/legislacao</a>).<br>';
    $sMensagem .= 'Para que o valor aproximado dos tributos seja mostrado nas notas, o primeiro passo é configurar os ';
    $sMensagem .= '<b>“Parâmetros de Tributos”</b> nos parâmetros do contribuinte. <br>';
    $sMensagem .= 'O valor aproximado dos tributos pode ser calculado no site do IBPT (<a href="https://www.ibpt.org.br" target="_blank">';
    $sMensagem .= 'https://www.ibpt.org.br</a>).<br>';
    $sMensagem .= 'Após configurado, o valor aproximado dos tributos será exibido em todas as notas fiscais.<br>';
    $sMensagem .= 'As notas só poderão ser emitidas após o preenchimento dos parâmetros.<br>';
    $sMensagem .= 'Verifique o informativo sobre as atualizações de versão (<a href="';
    $sMensagem .= $sUrlInformativo . '" target="_blank">';
    $sMensagem .= 'Ver</a>).<br>';

    return $sMensagem;
  }
}