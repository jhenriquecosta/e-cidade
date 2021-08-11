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
 * Form Responsável pela Busca de Usuários
 */
class Administrativo_Form_BuscaUsuario extends Twitter_Bootstrap_Form_Vertical {

  protected $iIdPerfil;

  protected $sBusca;

  /**
   * Construtor da classe, utilizado padrão HTML para uso do TwitterBootstrap
   *
   * @param string $aOptions
   * @see Twitter_Bootstrap_Form_Horizontal
   */
  public function __construct($iIdPerfil = null, $sBusca = null, $aOptions = NULL) {
    $this->iIdPerfil = $iIdPerfil;
    $this->sBusca    = $sBusca;
    parent::__construct($aOptions);
  }

  /**
   * Renderiza o formulário
   *
   * @see Zend_Form::init()
   * @return Zend_form
   */
  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('formBuscarUsuario');
    $this->setAction($oBaseUrlHelper->baseUrl('administrativo/usuario/index'));
    $this->setMethod('post');

    $aDadosPerfis = Administrativo_Model_Perfil::getAll();

    $aPerfis = array('' => 'Todos');

    foreach ($aDadosPerfis as $oPerfil) {
      $aPerfis[$oPerfil->getEntity()->getId()] = $oPerfil->getEntity()->getNome();
    }


    $oElm = $this->createElement('select', 'id_perfil', array('multiOptions' => $aPerfis, 'divspan' => 4));
    $oElm->setLabel('Perfil:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setRequired(TRUE);
    $oElm->setValue($this->iIdPerfil);
    $this->addElement($oElm);


    $oElm = $this->createElement('text', 'busca', array('divspan' => 2));
    $oElm->setAttrib('class', 'span3');
    $oElm->setAttrib('maxlength', 18);
    $oElm->setValue($this->sBusca);
    $this->addElement($oElm);

    $this->addElement('submit', 'Buscar', array(
                      'divspan' => 3,
                      'style' => 'margin-bottom: 10px',
                      'label' => 'Buscar',
                      'buttonType'  => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY)
    );

    return $this;
  }
}