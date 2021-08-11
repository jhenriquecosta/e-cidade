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
 * Class for exceptions by importing data by a XMl File
 *
 * @author dbseller
 */
final class DBSeller_Exception_ImportacaoXmlException extends Exception {
  
  protected $aErrors = array();
  
  
 /**
  * @param string $message error message
  * @param string $code code of error
  * @param string $previous previus error
  */
 public function __construct($message = null, $aErrors = null) {

   parent::__construct($message, null, null);
   if (!empty($aErrors) && is_array($aErrors)) {
     
     $this->aErrors = $aErrors;
     $sMessage = $this->message;
     if (count($this->aErrors) > 0) {
       
       $sMessage .= "\n - ";
       $sMessage .= implode("\n - ", $this->aErrors);
     }
     $this->message = $sMessage;
   }
 }

  /**
   * Set the errors raised with the exception
   * @param array $aErrors array with errors
   */
  public function setErrors(array $aErrors) {
    $this->aErrors = $aErrors;
  }
  
  /**
   * Return the
   * @return array list of errors
   */
  public function getErrors() {
    return $this->aErrors;
  }

}