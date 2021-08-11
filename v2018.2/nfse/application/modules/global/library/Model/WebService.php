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
 * Responsável pelo tratamento de dados do webservice
 *
 * @package Global/Library/Models
 * @see     Global_Lib_Model_WebService
 * @author  Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */

class Global_Lib_Model_WebService {

  const CODIGO_ERRO_CONSULTA_WEBSERVICE = 153;

  private static $soapClient  = NULL;
  private static $objeto      = NULL;

  public function __construct($o = NULL) {
    $this->objeto = $o;
  }

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

  public static function getSoapClient() {

    if (self::$soapClient != NULL) {
      return self::$soapClient;
    }

    $config = Zend_Registry::get('config');

    self::$soapClient = new Zend_Soap_Client(NULL, array(
      'location' => $config->webservice->client->location,
      'uri'      => $config->webservice->client->uri,
      'login'    => $config->webservice->cliente->user
    ));

    return self::$soapClient;
  }

  public static function consultar($metodo, $arguments) {

    $init_time = self::initLogging($metodo, $arguments);

    try {
      $a = self::getSoapClient()->consultar($metodo, $arguments[0], $arguments[1]);
    } catch (Exception $e) {

      self::finishLogging($metodo, $arguments, $init_time, true);
      throw new Exception("E-cidade temporariamente indisponível. Emissão bloqueada! ({$e->getMessage()})",
                          self::CODIGO_ERRO_CONSULTA_WEBSERVICE);
    }

    self::finishLogging($metodo, $arguments, $init_time);
    self::decode($a);

    if (empty($a)) {
      return NULL;
    }

    return $a;
  }

  public static function processar($metodo, $valores) {

    try {
      $a = self::getSoapClient()->processar($metodo, $valores);
    } catch (Excepetion $e) {
      throw new Exception("Problemas na comunicação com o webservice ({$e->getMessage()})");
    }

    return $a;
  }

  public static function _toArray($object) {

    if (is_object($object)) {
      $object = get_object_vars($object);
    }

    return $object;
  }

  private static function initLogging($metodo, $arguments) {

    $config = Zend_Registry::get('config');

    if ($config->webservice->logging) {

      $file    = fopen(APPLICATION_PATH . '/data/webservice.log', 'a+');
      $time    = time();
      $string  = "{$time} REQ {$metodo}\n";

      fwrite($file, $string);

      return $time;
    }
  }

  private static function finishLogging($metodo, $arguments, $init_time, $fail = false) {

    $config = Zend_Registry::get('config');

    if ($config->webservice->logging) {

      $file       = fopen(APPLICATION_PATH . '/data/webservice.log', 'a+');
      $time       = time();
      $diff_time  = $time - $init_time;
      $type       = $fail ? 'ERR' : 'RES';
      $string     = "{$time} {$type} {$metodo} " . date('s', $diff_time) . "\n";

      fwrite($file, $string);
    }
  }

  public function attr($attr) {

    if (!property_exists($this->objeto, $attr)) {

      //throw new Exception("Propriedade $attr não existe.");
      return NULL;
    }

    return $this->objeto->$attr;
  }

  public function toArray() {
    return self::_toArray($this->objeto);
  }
}