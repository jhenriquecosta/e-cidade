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
 * Responsável pelo controle de erros
 *
 * @package Default/Error
 * @see     Default_Lib_Controller_AbstractController
 * @author  Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */

class Default_ErrorController extends Default_Lib_Controller_AbstractController {

  /**
   * Página de erro
   */
  public function errorAction() {

    parent::noTemplate();

    $oErrors = $this->_getParam('error_handler');

    if (!$oErrors || !$oErrors instanceof ArrayObject) {

      $this->view->message = $this->translate->_('Você está na página de erro!');

      return;
    }

    $sMsgError = $oErrors->exception->getMessage();
    
    switch ($oErrors->type) {

      case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
      case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
      case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

        // 404 error -- controller or action not found
        $this->getResponse()->setHttpResponseCode(404);
        $iPriority           = Zend_Log::NOTICE;
        $this->view->title   = $this->translate->_('Ops, encontramos um problema:');
        $this->view->message = $this->translate->_('404 - A página solicitada não foi encontrada' . $sMsgError);
        break;

      default:

        // application error
        $this->getResponse()->setHttpResponseCode(500);
        $iPriority           = Zend_Log::CRIT;
        $this->view->title   = $this->translate->_('Ops, encontramos um problema:');
        $this->view->message = $this->translate->_('500 - Ocorreu um erro na execução da página <br />' . $sMsgError);
        break;
    }

    // Salva os erros no arquivo de Log (Local: "/logs/{APLLICATION_ENV}.log")
    $oLog = parent::log();

    if ($oLog) {

      $oLog->log($this->view->message, $iPriority, $oErrors->exception);
      $oLog->log('Request Parameters', $iPriority, print_r($oErrors->request->getParams(), TRUE));
    }

    // Exibe erros apenas se permitido pelo arquivo INI
    if ($this->getInvokeArg('displayExceptions') == TRUE) {
      $this->view->exception = $oErrors->exception;
    }

    $this->view->request = $oErrors->request;

    // Retorno dos erros em JSON para requisições ajax
    if ($this->_request->isXmlHttpRequest()) {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['error'][] = $this->view->message;
      $aRetornoJson['message'] = $this->view->message;

      if ($this->getInvokeArg('displayExceptions') == TRUE) {

        $aRetornoJson['exception']['information']       = $oErrors->exception->getMessage();
        $aRetornoJson['exception']['stack_trace']       = $oErrors->exception->getTraceAsString();
        $aRetornoJson['exception']['request_parameter'] = $this->getRequest()->getParams();
      }

      $this->getResponse()->setBody(Zend_Json::encode($aRetornoJson));

      echo($this->getHelper('json')->sendJson($aRetornoJson));
    }
  }

  /**
   * Página de acesso negado
   */
  public function forbiddenAction() {

    parent::noTemplate();

    $this->view->message_title   = $this->translate->_('Acesso Negado');
    $this->view->message_content = $this->translate->_('Você não tem permissão para acessar esta página!');
  }
}