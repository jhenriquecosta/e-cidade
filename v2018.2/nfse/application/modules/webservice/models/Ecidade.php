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
 *  PARTICULAR. Consulte a Licenca Publica Geral /GNU para obter mais
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
 * Responsável pelo tratamento de requisições ao webservice do E-cidade
 *
 * @package WebService/Models
 * @see     WebService_Model_Ecidade
 * @author  Davi Busanello <davi@dbseller.com.br>
 */

class WebService_Model_Ecidade {

  const CODIGO_ERRO_CONSULTA_WEBSERVICE = 153;

  private static $oSoapClient = NULL;
  private $oModelo = NULL;

  private static $iTempoOcorrido = NULL;
  private static $sLogPath       = NULL;

  public function __construct($oEcidade = NULL) {
    $this->oModelo = $oEcidade;
  }

  /**
   * Começa a gravar o log
   * @param  string $metodo    método
   * @param  array $arguments  Argumentos
   * @return time
   */
  private static function initLogging($metodo, $arguments) {

    self::$sLogPath = APPLICATION_PATH . '/data/webservice.log';
    $config = Zend_Registry::get('config');

    if ($config->webservice->logging) {

      $now = new Zend_Date();
      $arguments = print_r($arguments, 1);
      self::$iTempoOcorrido = time();
      $string = "{$now->now()} - " . self::$iTempoOcorrido . " - REQ {$metodo} - {$arguments}\n";
      file_put_contents(self::$sLogPath, $string, FILE_APPEND);

      return self::$iTempoOcorrido;
    }
  }

  /**
   * Método para gravar no log o fim da requisição
   * @param  string  $metodo    Método
   * @param  array  $arguments  Argumentos
   * @param  boolean $fail      Se está em uma Exception ou não
   */
  private static function finishLogging($metodo, $arguments, $fail = false) {

    $config = Zend_Registry::get('config');

    if ($config->webservice->logging) {

      $now       = new Zend_Date();
      $time      = time();
      $diff_time = $time - self::$iTempoOcorrido;
      $type      = $fail ? 'ERR' : 'RES';
      $string    = "{$now->now()} - {$time} - {$type} - {$metodo} - " . date('s', $diff_time) . "\n";

      file_put_contents(self::$sLogPath, $string, FILE_APPEND);
    }
  }

  /**
   * Método para encodar o retorno do WebService do E-Cidade em UTF8
   * @param  string|array|object $val  retorno do webservice
   * @return string|array|object $val  retorno em UTF8
   */
  private static function decode($val) {

    if (is_string($val)) {

      $val = urldecode($val);
      if (mb_detect_encoding($val) != 'UTF8') {
        $val = utf8_encode($val);
      }
      return $val;
    }

    if (is_array($val)) {

      foreach ($val as $k => $a) {
        $val[$k] = self::decode($a);
      }
      return $val;
    }

    if (is_object($val)) {

      foreach (get_object_vars($val) as $k => $a) {
        $val->$k = self::decode($a);
      }

      return $val;
    }
  }

  /**
   * Método para preparar os paremtros Globais que o E-Cidade precisa receber
   *
   * @return array $aParametrosGlobais Array de parametros nescessarios ao E-Cidade
   * @throws WebService_Lib_Exception
   */
  private static function preparaParametrosGlobais() {

    $config = Zend_Registry::get('webservice.ecidade');
    if (empty($config)) {
      throw new WebService_Lib_Exception(null,null, 'W03');
    }

    $aBackTrace = debug_backtrace();

    if ($aBackTrace[1]['function'] = 'consultar') {
      $aParametrosGlobais = $config->consultar->toArray();
    } else {
      $aParametrosGlobais = $config->processar->toArray();
    }

    return array('webservice' => $aParametrosGlobais);
  }

  /**
   * @return null|Zend_Soap_Client
   */
  public static function getSoapClient() {

    if (self::$oSoapClient != NULL) {
      return self::$oSoapClient;
    }

    $config = Zend_Registry::get('config');

    self::$oSoapClient = new Zend_Soap_Client(NULL, array(
      'location' => $config->webservice->client->location,
      'uri'      => $config->webservice->client->uri,
      'login' => $config->webservice->cliente->user
    ));

    return self::$oSoapClient;
  }

  /**
   * Método para fazer requisiçõe de consulta no WebService do E-Cidade
   * @param  string $metodo    Método do E-Cidade
   * @param  array $arguments Argumentos do método
   * @return [type]            [description]
   */
  public static function consultar($metodo, $arguments) {

    try {

      $iTempoOcorrido     = self::initLogging($metodo, $arguments);
      $aParametrosGlobais = self::preparaParametrosGlobais();
      $aRetornoEcidade    = self::getSoapClient()->consultar($metodo, array($arguments[0],$aParametrosGlobais), $arguments[1]);

      self::finishLogging($metodo, $arguments, $iTempoOcorrido);
      $aRetornoEcidade = self::decode($aRetornoEcidade);

//      //Comentado o bloco que verifica o retorno do E-cidade
//      if (empty($aRetornoEcidade)) {
//        throw new WebService_Lib_Exception('Não houve retorno do WebService!');
//      }

      return $aRetornoEcidade;
    } catch (Exception $oError) {

      self::finishLogging($metodo, $arguments, $iTempoOcorrido, true);
      throw new Exception("E-cidade temporariamente indisponível. Emissão bloqueada! ({$oError->getMessage()})",
                          self::CODIGO_ERRO_CONSULTA_WEBSERVICE);

      return $oError->getMessage();
    } catch (WebService_Lib_Exception $oError) {

      self::finishLogging($metodo, $arguments, $iTempoOcorrido, true);
      return $oError->getMessage();
    } catch (SoapFault $oError) {

      self::finishLogging($metodo, $arguments, $iTempoOcorrido, true);
      return $oError->getMessage();
    }
  }

  /**
   * Método para fazer as requisições de processamento no WebService do E-Cidade
   * @param  string $metodo  metodo no E-Cidade
   * @param  array $valores  Argumentos do método
   * @return [type]          [description]
   */
  public static function processar($metodo, $valores) {

    try {

      $iTempoOcorrido     = self::initLogging($metodo, $valores);
      $aParametrosGlobais = self::preparaParametrosGlobais();
      $aRetorno           = self::getSoapClient()->processar($metodo, array($valores, $aParametrosGlobais));

      self::finishLogging($metodo, $valores, $iTempoOcorrido);

      // Gera problemas quando á streaming de arquivos binarios pelo webservice
      // $aRetorno = self::decode($aRetorno);

      return $aRetorno;
    } catch (Exception $oError) {

      $sMensagem = str_replace("\\n", '', $oError->getMessage());
      $sMensagem = "E-cidade temporariamente indisponível. Emissão bloqueada! ({$sMensagem})";
      self::finishLogging($metodo, $valores, $iTempoOcorrido, true);
      throw new Exception($sMensagem, self::CODIGO_ERRO_CONSULTA_WEBSERVICE);

      return $sMensagem;
    } catch (WebService_Lib_Exception $oError) {

      self::finishLogging($metodo, $valores, $iTempoOcorrido, true);
      return str_replace("\\n", '', $oError->getMessage());
    } catch (SoapFault $oError) {

      self::finishLogging($metodo, $valores, $iTempoOcorrido, true);
      return str_replace("\\n", '', $oError->getMessage());
    }
  }

  /**
   * Converte um objeto em array
   * @param  object $object Objeto
   * @return array         Objeto convertido em array
   */
  public static function _toArray($object) {

    if (is_object($object)) {
      $object = get_object_vars($object);
    }

    return $object;
  }

  /**
   * @param $attr
   * @return null
   */
  public function attr($attr) {

    if (is_null($this->oModelo) || !property_exists($this->oModelo, $attr)) {
      return NULL;
    }

    return $this->oModelo->$attr;
  }

  /**
   * @return array
   */
  public function toArray() {
    return self::_toArray($this->oModelo);
  }
}