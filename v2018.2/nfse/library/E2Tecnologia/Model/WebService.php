<?php

class E2Tecnologia_Model_WebService {
  
  private static $soapClient  = NULL;
  private static $objeto      = NULL;
  
  public function __construct($o) {
    $this->objeto = $o;
  }    
  
  private static function decode($val) {
    
    if (is_string($val)) {
      return urldecode($val);
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
      throw new Exception("Problemas na comunicação com o webservice ({$e->getMessage()})");
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
      
      return NULL;
    }
    
    return $this->objeto->$attr;
  }
  
  public function toArray() {
    return self::_toArray($this->objeto);
  }
}
