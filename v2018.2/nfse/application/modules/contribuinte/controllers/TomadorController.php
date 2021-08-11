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
 * Description of TomadorController
 */
class Contribuinte_TomadorController extends Contribuinte_Lib_Controller_AbstractController {
  
  public function init() {
    parent::init();
  }
  
  public function indexAction() {
    
    parent::noTemplate();
    
    $oForm = new Contribuinte_Form_Tomador();
    
    if ($this->getRequest()->isPost()) {
      
      $aDados = $this->getRequest()->getPost();
      
      $oForm->preenche($aDados);
      
      if (!$oForm->isValid($aDados)) {
        
        $this->view->form = $oForm;
        $this->getResponse()->setHttpResponseCode(406); // Evita o Fechamento da Modal JS
      } else {
        
        $iCodigoIbge = Administrativo_Model_Prefeitura::getDadosPrefeituraBase()->getIbge();
        
        if ($aDados['z01_munic'] == $iCodigoIbge) {
          
          $aDados['z01_bairro'] = $aDados['z01_bairro_munic'];
          $aDados['z01_ender']  = $aDados['z01_ender_munic'];
        } else {
          
          $aDados['z01_bairro'] = $aDados['z01_bairro_fora'];
          $aDados['z01_ender']  = $aDados['z01_ender_fora'];
        }
        
        // Salva Novo CGM (eCidade)
        //Contribuinte_Model_Cgm::persist($aDados);
        
        // Salva Novo Tomador (NFSE)
        $aDadosNfse                      = array();
        $aDadosNfse['t_cnpjcpf']         = $aDados['z01_cgccpf'];
        $aDadosNfse['t_razao_social']    = $aDados['z01_nome'];
        $aDadosNfse['t_cod_pais']        = $aDados['z01_nome'];
        $aDadosNfse['t_uf']              = $aDados['z01_uf'];
        $aDadosNfse['t_cod_municipio']   = $aDados['z01_munic'];
        $aDadosNfse['t_cep']             = $aDados['z01_cep'];
        $aDadosNfse['t_bairro']          = $aDados['z01_bairro_fora'];
        $aDadosNfse['t_endereco']        = $aDados['z01_ender_fora'];
        $aDadosNfse['t_endereco_numero'] = $aDados['z01_numero'];
        $aDadosNfse['t_endereco_comp']   = $aDados['z01_compl'];
        $aDadosNfse['t_telefone']        = $aDados['z01_telef'];
        $aDadosNfse['t_email']           = $aDados['z01_email'];
        
        $oTomador = new Contribuinte_Model_TomadorBase();
        $oTomador->persist($aDadosNfse);
        
        $this->_helper->getHelper('FlashMessenger')->addMessage(array('success' => 'Tomador cadastrado com sucesso.'));
        
        return;
      }
    } else {
      
      $this->view->form = $oForm;
    }
  }
  
  /**
   * Consulta detalhes da empresa
   * 
   * @return json
   */
  public function dadosCgmAction() {
    
    $bSubstituto = $this->_getParam('substituto', FALSE);
    $sCgcCpf     = $this->_getParam('term', NULL);
    $sCgcCpf     = DBSeller_Helper_Number_Format::getNumbers($sCgcCpf);
    $aData    = Contribuinte_Model_Empresa::getByCgcCpf($sCgcCpf);
    
    if (!empty($aData) && !empty($aData->eCidade)) {
      $aData = $aData->eCidade;
    } else if (!empty($aData) && !empty($aData->eNota)) {
      $aData = $aData->eNota;
    } else {
      
      echo $this->getHelper('json')->sendJson(NULL);
      return;
    }
    
    $aRetornoJson = array_map(function($v) { return $v->toObject(); }, $aData);
    
    // Retorna apenas o primeiro resultado
    if (count($aRetornoJson) > 1) {
      $aRetornoJson = $aRetornoJson[0];
    }
    
    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
}