<?php

 /**
  * Classe abstrata para métodos genéricos do módulo Fiscal
  */
class Fiscal_Lib_AbstractController extends Global_Lib_Controller_AbstractController {
  
  /**
   * Método equivalente ao _construct()
   * Método para checar a autenticação do usuário
   *
   * @see Global_Lib_Controller_AbstractController::init()
   */
  public function init() {
    
    parent::init();
    parent::checkIdentity();
  }
}