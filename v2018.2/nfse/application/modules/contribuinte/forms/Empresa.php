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
 * Formulário para empresa
 */
class Contribuinte_Form_Empresa extends Twitter_Bootstrap_Form_Horizontal {
  
  var $sAction = '/contribuinte/empresa/index';
  var $bSubmit = TRUE;
  
  public function __construct($sAction = '/contribuinteempresa/index', $bSubmit = TRUE) {
    
    parent::__construct();
    
    $this->sAction = $sAction;
    $this->bSubmit = $bSubmit;
  }
  
  public function init() {
    
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    
    $this->setAction($oBaseUrlHelper->getBaseUrl($this->sAction));
    $this->setMethod(Zend_Form::METHOD_POST);
    $this->setAttrib('id', 'formEmpresa');
    
    $oElm = $this->createElement('hidden', 'endereco_fora');
    $oElm->setValue('1');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'z01_cgccpf');
    $oElm->setLabel('CNPJ: ');
    $oElm->setAttrib('class', 'mask-cnpj');
    $oElm->setAttrib('maxlength', '14');
    $oElm->addValidator(new DBSeller_Validator_Cnpj());
    $oElm->addValidator(new Zend_Validate_StringLength(array('min' => 14, 'max' => 18)));
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'z01_nome');
    $oElm->setLabel('Razão Social: ');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $aEstados = Default_Model_Cadenderestado::getEstados('01058');
    
    $oElm = $this->createElement('select', 'z01_uf', array('multiOptions' => $aEstados));
    $oElm->setLabel('Estado: ');
    $oElm->setAttrib('class', 'select-estados');
    $oElm->setAttrib('select-munic', 'z01_munic');
    $oElm->setAttrib('ajax-url', $oBaseUrlHelper->getBaseUrl('/endereco/get-municipios/'));
    $oElm->setAttrib('key', FALSE);
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_Alpha());
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('select', 'z01_munic');
    $oElm->setLabel('Cidade: ');
    $oElm->setAttrib('key', TRUE);
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_Digits());
    $oElm->addValidator(new Zend_Validate_GreaterThan(array('min' => 0)));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'z01_cep');
    $oElm->setLabel('CEP: ');
    $oElm->setAttrib('maxlength', 8);
    $oElm->setAttrib('class', 'mask-cep');
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_Digits());
    $oElm->addValidator(new Zend_Validate_StringLength(array('min' => 8)));
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    // pega codigo do IBGE do municipio no arquivo de configuracao
    $iCodigoIbge = Administrativo_Model_Prefeitura::getDadosPrefeituraBase()->getIbge();
    
    // Lista de bairros do municipio
    $aBairros    = Default_Model_Cadenderbairro::getBairros();
    
    $oElm = $this->createElement('select', 'z01_bairro_munic', array('multiOptions' => $aBairros));
    $oElm->setLabel('Bairro: ');
    $oElm->setAttrib('municipio', $iCodigoIbge);
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_Digits());
    $oElm->addValidator(new Zend_Validate_GreaterThan(array('min' => 0)));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $aMunicipios = Default_Model_Cadenderrua::getRuas();
    
    $oElm = $this->createElement('select', 'z01_ender_munic', array('multiOptions' => $aMunicipios));
    $oElm->setLabel('Endereço: ');
    $oElm->setAttrib('municipio', $iCodigoIbge);
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_Digits());
    $oElm->addValidator(new Zend_Validate_GreaterThan(array('min' => 0)));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'z01_bairro_fora');
    $oElm->setLabel('Bairro: ');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'z01_ender_fora');
    $oElm->setLabel('Endereço: ');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'z01_numero');
    $oElm->setLabel('Número: ');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'z01_compl');
    $oElm->setLabel('Complemento: ');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'z01_telef');
    $oElm->setLabel('Telefone: ');
    $oElm->setAttrib('class', 'mask-fone');
    $oElm->addFilter(new Zend_Filter_Digits());
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'z01_email');
    $oElm->setLabel('Email: ');
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_EmailAddress());
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    if ($this->bSubmit) {
      $this->addElement(new Zend_Form_Element_Submit('Cadastrar', 'Cadastrar', array('label' => 'Criar')));
    }
    
    return $this;
  }

  public function preenche($aDados) {
    
    if (isset($aDados['z01_uf'])) {
      
      $aCidades = Default_Model_Cadendermunicipio::getByEstado($aDados['z01_uf']);

      if (isset($aDados['z01_munic'])) {
        $this->z01_uf->setValue($aDados['z01_munic']);
      }
      
      $this->z01_munic->setMultiOptions($aCidades);
    }
    
    if (isset($aDados['z01_munic'])) {
      $this->z01_munic->setValue($aDados['z01_munic']);
    }
    
    $this->populate($aDados);
    
    return $this;
  }  
}