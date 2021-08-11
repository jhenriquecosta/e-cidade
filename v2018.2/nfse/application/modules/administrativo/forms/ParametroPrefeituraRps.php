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
 * Formulario para configuracao dos parametros do RPS da prefeitura
 * 
 * @package Administrativo/Form
 */

/**
 * @package Administrativo/Form
 */
class Administrativo_Form_ParametroPrefeituraRps extends Twitter_Bootstrap_Form_Horizontal {
  
  /**
   * (non-PHPdoc)
   * @see Zend_Form::init()
   */
  public function init() {
    
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    
    $this->setName('form_parametros_prefeitura_rps');
    $this->setAction($oBaseUrlHelper->baseUrl('/administrativo/parametro/prefeitura-salvar-rps'));
    
    $oParametrosPrefeituraRps = new Administrativo_Model_ParametroPrefeituraRps();    
    $aParametrosPrefeituraRps = $oParametrosPrefeituraRps->getListAll(NULL, array('tipo_nfse'=>'ASC'));
    
    foreach ($aParametrosPrefeituraRps as $oParametroRps) {
      
      $aElementos[$oParametroRps->getId()] = $this->createElement('select', (string) $oParametroRps->getTipoNfse());
      $aElementos[$oParametroRps->getId()]->setLabel("{$oParametroRps->getTipoNfseDescricao()}:");
      $aElementos[$oParametroRps->getId()]->setBelongsTo('parametros_prefeitura_rps');
      $aElementos[$oParametroRps->getId()]->setAttrib('class', 'span3');
      $aElementos[$oParametroRps->getId()]->removeDecorator('errors');
      
      self::setTiposEcidade($aElementos[$oParametroRps->getId()]);
    }
    
    $aElementos[] = $this->createElement('submit', 'btn_salvar_rps', array(
      'label'      => 'Salvar',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));
    
    $this->addElements($aElementos);
    
    return $this;
  }
  
  /**
   * Carrega os tipos que equivalem ao tipo da abrasf no elemento
   * 
   * @param Zend_Form_Element_Select $oElemento
   * @param string $iValor
   * @return Administrativo_Form_ParametroPrefeituraRps
   */
  public function setTiposEcidade(Zend_Form_Element_Select $oElemento, $iValor = '') {
    
    $aTiposNota = Contribuinte_Model_Nota::getTiposNota(Contribuinte_Model_Nota::GRUPO_NOTA_RPS);
    
    
    $tipoArrayBIzonho = array('' => 'Escolha') + $aTiposNota;
    
    $oElemento->addMultiOptions($tipoArrayBIzonho);
    $oElemento->setValue($iValor);
    
    return $this;
  }
  
  /**
   * Preenche dados do formulario com uma coleção de parametros de rps
   *
   * @param array[Administrativo_Model_ParametroPrefeituraRps] $aParametrosRps
   * @return Administrativo_Form_ParametroPrefeitura
   */
  public function preenche(array $aParametrosRps) {
    
    foreach ($aParametrosRps as $oParametrosRps) {
      
      if (is_object($this->getElement($oParametrosRps->getId()))) {
        $this->getElement($oParametrosRps->getId())->setValue($oParametrosRps->getTipoEcidade());
      }
    }
    
    return $this;
  }
}