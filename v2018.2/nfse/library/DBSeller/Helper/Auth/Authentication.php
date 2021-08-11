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


class DBSeller_Helper_Auth_Authentication extends Zend_View_Helper_Abstract {
  
  /**
   * Retorna o objeto do usuario
   *
   * @return ambiguos <Administrativo_Model_Usuario(), null>
   */
  public static function getAuthData() {
    
    $oAuth  = Zend_Auth::getInstance();
    $sLogin = $oAuth->getIdentity();
    
    if (isset($sLogin['login'])) {
      return Administrativo_Model_Usuario::getByAttribute('login', $sLogin['login']);
    }
    
    return NULL;
  }
  
  /**
   * Checa se o usuario esta autenticado
   *
   * @return boolean
   */
  public static function checkAuth() {
    return Zend_Auth::getInstance()->hasIdentity();
  }
}