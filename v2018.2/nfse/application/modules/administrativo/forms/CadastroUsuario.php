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

/**
 * Class Administrativo_Form_CadastroUsuario
 */
class Administrativo_Form_CadastroUsuario extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Renderiza o formulário
   *
   * @see Zend_Form::init()
   * @return Zend_form
   */
  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('formCadastroUsuario');
    $this->setAction($oBaseUrlHelper->baseUrl('/administrativo/usuario'));
    $this->setMethod('post');

    $oElm = $this->createElement('hidden', 'id');
    $oElm->setValue(NULL);
    $this->addElement($oElm);

    $aTipos = Administrativo_Model_TipoUsuario::getLista();

    if ($this->_view->action == 'editar') {
      unset($aTipos[3]);
    }

    $oElm   = $this->createElement('select', 'tipo', array('multiOptions' => $aTipos));
    $oElm->setLabel('Tipo:');
    $oElm->setAttrib('url-buscador', $oBaseUrlHelper->baseUrl('/administrativo/usuario/get-contadores'));
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'cnpj');
    $this->addElement($oElm);

    $aContadores      = Administrativo_Model_Contador::getAll();
    $aListaContadores = array();

    foreach ($aContadores as $oContador) {

      $sNome                                      = utf8_encode($oContador->attr('nome'));
      $aListaContadores[$oContador->attr('cnpj')] = $sNome . ' - ' . $oContador->attr('cnpj');
    }

    $oElm = $this->createElement('select', 'contador', array('multiOptions' => $aListaContadores));
    $oElm->setLabel('Contador:');
    $this->addElement($oElm);

    $oElmBuscar = $this->createElement('button', 'buscador', array(
      'label'        => '',
      'icon'         => 'search',
      'iconPosition' => Twitter_Bootstrap_Form_Element_Button::ICON_POSITION_LEFT
    ));

    $oElm = $this->createElement('hidden', 'insc_municipal');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'cnpj', array(
      'append'      => $oElmBuscar,
      'class'       => 'numerico',
      'description' => '-'
    ));
    $oElm->setAttrib('url-buscador', $oBaseUrlHelper->baseUrl('administrativo/usuario/get-contribuinte-cnpj'));
    $oElm->setLabel('CNPJ:');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'login');
    $oElm->setLabel('Login:');
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'nome');
    $oElm->setLabel('Nome:');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'email');
    $oElm->setLabel('Email:');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'fone');
    $oElm->setLabel('Telefone:');
    $oElm->setAttrib('class', 'telefone');
    $oElm->setValidators(array(
                           new Zend_Validate_Alnum(),
                           new Zend_Validate_StringLength(array('max' => 13))
                         ));
    $this->addElement($oElm);

    $aPerfis        = array();
    $oPerfilUsuario = $this->_view->user->getPerfil();

    if ($this->_view->user->getAdministrativo()) {

      $aDadosPerfis = Administrativo_Model_Perfil::getAll();

      foreach ($aDadosPerfis as $oPerfil) {
        $aPerfis[$oPerfil->getEntity()->getId()] = $oPerfil->getEntity()->getNome();
      }

      /*@todo: fix bug cadastro novo usuario */
      if ($this->_view->action == 'editar') {
        unset($aPerfis[3]);
        unset($aPerfis[5]);
      }

    } else {

      $aDadosPerfis = $oPerfilUsuario->getPerfis();
      foreach ($aDadosPerfis as $oPerfil) {
        $aPerfis[$oPerfil->getId()] = $oPerfil->getNome();
      }
      unset($aPerfis[6]);
    }

    $oElm = $this->createElement('select', 'perfil', array('multiOptions' => $aPerfis));
    $oElm->removeDecorator('errors');
    $oElm->setLabel('Perfil:');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $this->addElement('submit', 'submit', array(
      'label'      => 'Salvar',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));

    return $this;
  }
}
