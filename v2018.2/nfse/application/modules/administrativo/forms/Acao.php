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
 * Description of Cadastro
 */
class Administrativo_Form_Acao extends Twitter_Bootstrap_Form_Vertical {

  public function init() {
    
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    
    $this->setAttrib('id', 'form-acao');
    $this->setMethod('post');
    $this->setAction($oBaseUrlHelper->baseUrl('/administrativo/acao/novo'));
    
    $oElm = $this->createElement('hidden', 'c');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'nome');
    $oElm->setLabel('Nome');
    $oElm->setRequired(TRUE);
    $oElm->setAttrib('style', 'width:95%');
    $oElm->setAttrib('rows', '4');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'acaoacl');
    $oElm->setLabel('Ação ACL');
    $oElm->setAttrib('style', 'width:95%');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('textarea', 'sub_acoes');
    $oElm->setLabel('Sub Ações');
    $oElm->setAttrib('style', 'width:95%');
    $oElm->setAttrib('rows', '6');
    $this->addElement($oElm);

    $oElm = $this->createElement('checkbox', 'gerador_dados');
    $oElm->setLabel('Gerador Dados:');
    $oElm->setAttrib('style', 'width:95%');
    $this->addElement($oElm);
    
    return $this;
  }
  
  public function preenche($aDados = NULL) {
    
    if (isset($aDados['id']) && $aDados['id'] != NULL) {
      
      $oElm = $this->createElement('hidden', 'id');
      $oElm->setValue($aDados['id']);
      $oElm->setRequired(TRUE);
      $this->addElement($oElm);
    }
    
    if (isset($aDados['c']) && $aDados != NULL) {
      $this->c->setValue($aDados['c']);
    }
    
    if (isset($aDados['nome']) && $aDados['nome'] != NULL) {
      $this->nome->setValue($aDados['nome']);
    }
    
    if (isset($aDados['acaoacl']) && $aDados['acaoacl'] != NULL) {
      $this->acaoacl->setValue($aDados['acaoacl']);
    }
    
    if (isset($aDados['sub_acoes']) && $aDados['sub_acoes'] != NULL) {
      $this->sub_acoes->setValue($aDados['sub_acoes']);
    }

    if (isset($aDados['gerador_dados']) && $aDados['gerador_dados'] != NULL) {
      $this->gerador_dados->setValue($aDados['gerador_dados']);
    }
  }
}