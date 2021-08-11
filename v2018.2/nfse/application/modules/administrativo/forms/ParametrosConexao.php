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
 * Classe Formulário para instalação
 *
 * @package Administrativo/Forms
 * @see Twitter_Bootstrap_Form_Horizontal
 */

/**
 * @package Administrativo/Forms
 * @see Twitter_Bootstrap_Form_Horizontal
 */
class Administrativo_Form_ParametrosConexao extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Método construtor
   *
   * @return $this|void
   */
  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('form-configuracao');
    $this->setAction($oBaseUrlHelper->baseUrl('/administrativo/instalacao'));
    $this->setMethod('post');

    $oElm = $this->createElement('text', 'base_dados');
    $oElm->setLabel('Base de Dados: ');
    $oElm->setRequired(TRUE);
    $oElm->setAttrib('class', 'span3');
    $oElm->setAttrib('autofocus', TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'servidor');
    $oElm->setLabel('Servidor: ');
    $oElm->setRequired(TRUE);
    $oElm->setAttrib('class', 'span3');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'porta');
    $oElm->setLabel('porta: ');
    $oElm->setAttrib('class', 'span1');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'usuario');
    $oElm->setLabel('Usuário: ');
    $oElm->setRequired(TRUE);
    $oElm->setAttrib('class', 'span3');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'senha');
    $oElm->setLabel('Senha: ');
    $oElm->setAttrib('class', 'span3');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'client_url');
    $oElm->setLabel('Cliente Url: ');
    $oElm->setRequired(TRUE);
    $oElm->setAttrib('class', 'span8');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'client_location');
    $oElm->setLabel('Cliente Location: ');
    $oElm->setAttrib('class', 'span8');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'client_uri');
    $oElm->setLabel('Cliente Uri: ');
    $oElm->setAttrib('class', 'span8');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $this->addElement('submit', 'submit', array(
      'label'      => 'Salvar',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));

    $this->addDisplayGroup(array('base_dados', 'servidor', 'porta', 'usuario', 'senha'), 'db',
                           array('legend' => 'Base de Dados'));
    $this->addDisplayGroup(array('client_url', 'client_location', 'client_uri'), 'url',
                           array('legend' => 'WebService'));
    $this->addDisplayGroup(array('submit'), 'teste');

    return $this;
  }

  /**
   * Preenche os dados do formulário
   */
  public function preenche() {

    $oConfiguracoesDoctrine   = Zend_Registry::get('config')->doctrine->connectionParameters;
    $oConfiguracoesWebService = Zend_Registry::get('config')->webservice->client;

    $oServidor = $this->getElement('servidor');
    $oServidor->setValue($oConfiguracoesDoctrine->host);

    $oUsuario = $this->getElement('usuario');
    $oUsuario->setValue($oConfiguracoesDoctrine->user);

    $oSenha = $this->getElement('senha');
    $oSenha->setValue($oConfiguracoesDoctrine->password);

    $oPorta = $this->getElement('porta');
    $oPorta->setValue($oConfiguracoesDoctrine->port);

    $oBaseDados = $this->getElement('base_dados');
    $oBaseDados->setValue($oConfiguracoesDoctrine->dbname);

    $oClienteUrl = $this->getElement('client_url');
    $oClienteUrl->setValue($oConfiguracoesWebService->url);

    $oClienteLocation = $this->getElement('client_location');
    $oClienteLocation->setValue($oConfiguracoesWebService->location);

    $oClienteUri = $this->getElement('client_uri');
    $oClienteUri->setValue($oConfiguracoesWebService->uri);
  }
}