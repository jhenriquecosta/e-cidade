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
 * Validações Extra para cada permissão criada
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 * @package DBSeller\Acl\validacaoExtraAcl
 */

class DBSeller_Acl_validacaoExtraAcl implements Zend_Acl_Assert_Interface { 
  
  public function __construct(Zend_Acl $oAcl                         = NULL, 
                                Zend_Acl_Role_Interface $oRole         = NULL,
                                Zend_Acl_Resource_Interface $oResource = NULL,
                                $sPrivilegio                           = NULL) {
    
    return true; //$this->assert($oAcl, $oRole, $oResource, $sPrivilegio);
  }
  
  /**
   * Chamada das funções extra das acls.
   * chamada é feita quando é definido a negação ou liberação da permissão
   * 
   * @see Zend_Acl_Assert_Interface::assert()
   * @return bool
   */
  public function assert (Zend_Acl $oAcl                         = NULL, 
                            Zend_Acl_Role_Interface $oRole         = NULL,
                            Zend_Acl_Resource_Interface $oResource = NULL,
                            $sPrivilegio                           = NULL) {
    
    $lResultadoValidacoes = self::validaControleAtivo($oResource, $sPrivilegio);
    
    return $lResultadoValidacoes;
  }
  
  
  /**
   * validacao se o controle está ativo
   * @param Zend_Acl_Resource_Interface $oResource
   * @param string $sPrivilegio
   */
  protected function validaControleAtivo (Zend_Acl_Resource_Interface $oResource, $sPrivilegio) {
    
    $aIdentidadeControle = explode(':', $oResource->getResourceId());
    $sIdentidadeControle = $aIdentidadeControle[1];
    $sIdentidadeModulo   = $aIdentidadeControle[0];
    
    $oModulo = Administrativo_Model_Modulo::getByAttribute('identidade', $sIdentidadeModulo);
    
    $aControles = $oModulo->getControles();
    
    foreach ($aControles as $oControle) {
      
      if ($oControle->getIdentidade() != $sIdentidadeControle) continue;
      
      if (!$oControle->getVisivel())  {
        return TRUE;
      }
    }
    
    return TRUE;
  }
}