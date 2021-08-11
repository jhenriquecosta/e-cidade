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

class Contribuinte_Form_RequisicaoNfse extends Contribuinte_Form_RequisicaoAidof {
  
  public function init() {
    
    parent::init();
    
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    
    $this->setAction($oBaseUrlHelper->baseUrl('/contribuinte/nfse/requisicao'));
    $this->removeElement('cgm_grafica');

    // Tipos de Nota do Grupo NFSE
    $aTiposDocumento = Contribuinte_Model_Nota::getTiposNota(Contribuinte_Model_Nota::GRUPO_NOTA_NFSE);

    // Popula o select com os tipos de nota
    if (is_object($this->tipo_documento) && is_array($aTiposDocumento)) {
      $this->tipo_documento->setMultiOptions($aTiposDocumento);
    }
    
    // Alterando a descrição do label
    if (is_object($this->quantidade)) {
      $this->quantidade->setLabel('Quantidade de NF');
    }
    
    return $this;
  }
  
  public function preenche($aDados = NULL) {
    return parent::preenche($aDados);
  }
}