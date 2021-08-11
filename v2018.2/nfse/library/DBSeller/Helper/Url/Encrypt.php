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
 * Classe auxilixar para criptografia de URL
 *
 * @package Library/DBSeller/Helpers
 * @see     Zend_View_Helper_Abstract
 */

/**
 * @package Library/DBSeller/Helpers
 * @see     Zend_View_Helper_Abstract
 */
class DBSeller_Helper_Url_Encrypt extends Zend_View_Helper_Abstract {

  /**
   * Criptografa a URL
   *
   * @param array  $arrayParams
   * @param string $paramReturnType
   * @return array|string
   */
  public static function encrypt(array $arrayParams, $paramReturnType = 'string') {

    if (isset($arrayParams['url']) && count($arrayParams['url']) > 0) {

      $_zendUrlHelper                      = new Zend_View_Helper_Url();
      Zend_Json::$useBuiltinEncoderDecoder = TRUE;

      $_strUrl                             = Zend_Json::encode($arrayParams['url']);
      Zend_Json::$useBuiltinEncoderDecoder = TRUE;

      if ($paramReturnType == 'string') {

        $_url = $_zendUrlHelper->url(array('module'     => $arrayParams['module'],
                                           'controller' => $arrayParams['controller'],
                                           'action'     => $arrayParams['action'],
                                           'url'        => base64_encode($_strUrl)
                                          ), NULL, TRUE, TRUE);

        return urldecode($_url);
      } else if ($paramReturnType == 'array') {
        return array('url' => urldecode(base64_encode($_strUrl)));
      }
    } else {

      $_zendUrlHelper = new Zend_View_Helper_Url();
      return $_zendUrlHelper->url(array('module'     => $arrayParams['module'],
                                        'controller' => $arrayParams['controller'],
                                        'action'     => $arrayParams['action']),
                                        NULL, TRUE, TRUE);
    }
  }

  /**
   * Descriptografa a URL
   *
   * @param null $paramValue
   * @return mixed
   */
  public static function decrypt($paramValue = NULL) {

    $_zendView = Zend_Controller_Front::getInstance();

    if ($paramValue == NULL) {
      $_strUrl = base64_decode($_zendView->getRequest()->getParam('url'));
    } else {
      $_strUrl = base64_decode($paramValue);
    }

    Zend_Json::$useBuiltinEncoderDecoder = TRUE;

    return Zend_Json::decode($_strUrl);
  }
}