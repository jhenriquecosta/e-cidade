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
 * Formulário para configuração dos parâmetros da prefeitura
 *
 * @package Administrativo/Forms
 * @see Twitter_Bootstrap_Form_Horizontal
 * @see Zend_Form
 */

/**
 * @package Administrativo/Forms
 * @see Twitter_Bootstrap_Form_Horizontal
 * @see Zend_Form
 */
class Administrativo_Form_ParametroPrefeitura extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Construtor da classe
   *
   * @return $this|void
   */
  public function init() {
    
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    
    $this->setName('form_parametros_prefeitura');
    $this->setAction($oBaseUrlHelper->baseUrl('/administrativo/parametro/prefeitura-salvar'));
    
    $oElm = $this->createElement('text', 'ibge');
    $oElm->setLabel('Código Ibge:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->setValidators(array(new Zend_Validate_Int()));
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'cnpj');
    $oElm->setLabel('CNPJ:');
    $oElm->setAttrib('class', 'span3 mask-cnpj');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'nome');
    $oElm->setLabel('Nome da Instituição:');
    $oElm->setAttrib('class', 'span4');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'nome_relatorio');
    $oElm->setLabel('Nome para Relatórios:');
    $oElm->setAttrib('class', 'span4');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'endereco');
    $oElm->setLabel('Endereço:');
    $oElm->setAttrib('class', 'span6');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'numero');
    $oElm->setLabel('Número:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'complemento');
    $oElm->setLabel('Complemento:');
    $oElm->setAttrib('class', 'span4');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'bairro');
    $oElm->setLabel('Bairro:');
    $oElm->setAttrib('class', 'span4');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'municipio');
    $oElm->setLabel('Município:');
    $oElm->setAttrib('class', 'span4');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'uf');
    $oElm->setLabel('UF:');
    $oElm->setAttrib('class', 'span1');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'cep');
    $oElm->setLabel('CEP:');
    $oElm->setAttrib('class', 'span2 mask-cep');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'telefone');
    $oElm->setLabel('Telefone:');
    $oElm->setAttrib('class', 'span2 mask-fone');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'fax');
    $oElm->setLabel('Fax:');
    $oElm->setAttrib('class', 'span2 mask-fone');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'email');
    $oElm->setLabel('Email:');
    $oElm->setAttrib('class', 'span4');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'url');
    $oElm->setLabel('Url:');
    $oElm->setAttrib('class', 'span4');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('image', 'logo');
    $oElm->setAttrib('src', $oBaseUrlHelper->baseUrl('/global/img/brasao.jpg?v='.date('Ymdhis')));
    $oElm->setAttrib('class', 'img-polaroid img-rounded');
    $this->addElement($oElm);
    
    $this->addElement('submit', 'btn_atualizar', array(
      'label'      => 'Sincronizar com e-Cidade',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY
    ));
    
    $this->btn_atualizar->setDecorators(array('ViewHelper'));
    
    return $this;
  }
  
  /**
   * Preenche dados do formulario
   * 
   * @param Administrativo/ParametroPrefeitura $oParametroPrefeitura
   * @return Administrativo_Form_ParametroPrefeitura
   */
  public function preenche($oParametroPrefeitura) {
    
    if (!is_object($oParametroPrefeitura)) {
      return $this;
    }
    
    if ($oParametroPrefeitura->getIbge() && isset($this->ibge)) {
      $this->ibge->setValue($oParametroPrefeitura->getIbge());
    }
    
    if ($oParametroPrefeitura->getCnpj() && isset($this->cnpj)) {
      $this->cnpj->setValue($oParametroPrefeitura->getCnpj());
    }
    
    if ($oParametroPrefeitura->getNome() && isset($this->nome)) {
      $this->nome->setValue($oParametroPrefeitura->getNome());
    }
    
    if ($oParametroPrefeitura->getNomeRelatorio() && isset($this->nome_relatorio)) {
      $this->nome_relatorio->setValue($oParametroPrefeitura->getNomeRelatorio());
    }
    
    if ($oParametroPrefeitura->getEndereco() && isset($this->endereco)) {
      $this->endereco->setValue($oParametroPrefeitura->getEndereco());
    }
    
    if ($oParametroPrefeitura->getNumero() && isset($this->numero)) {
      $this->numero->setValue($oParametroPrefeitura->getNumero());
    }
    
    if ($oParametroPrefeitura->getComplemento() && isset($this->complemento)) {
      $this->complemento->setValue($oParametroPrefeitura->getComplemento());
    }
    
    if ($oParametroPrefeitura->getMunicipio() && isset($this->municipio)) {
      $this->municipio->setValue($oParametroPrefeitura->getMunicipio());
    }
    
    if ($oParametroPrefeitura->getUf() && isset($this->uf)) {
      $this->uf->setValue($oParametroPrefeitura->getUf());
    }
    
    if ($oParametroPrefeitura->getCep() && isset($this->cep)) {
      $this->cep->setValue($oParametroPrefeitura->getCep());
    }
    
    if ($oParametroPrefeitura->getTelefone() && isset($this->telefone)) {
      $this->telefone->setValue($oParametroPrefeitura->getTelefone());
    }
    
    if ($oParametroPrefeitura->getFax() && isset($this->fax)) {
      $this->fax->setValue($oParametroPrefeitura->getFax());
    }
    
    if ($oParametroPrefeitura->getEmail() && isset($this->email)) {
      $this->email->setValue($oParametroPrefeitura->getEmail());
    }
    
    if ($oParametroPrefeitura->getUrl() && isset($this->url)) {
      $this->url->setValue($oParametroPrefeitura->getUrl());
    }
    
    return $this;
  }
}