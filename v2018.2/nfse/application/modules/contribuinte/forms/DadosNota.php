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
 * Formulario para dados da nota
 */
class Contribuinte_Form_DadosNota extends Twitter_Bootstrap_Form_Vertical {

  private $action          = '/contribuinte/nfse/index';
  private $cod_verificacao = FALSE;
  private $rps             = FALSE;

  /**
   * Construtor
   *
   * @param mixed $sCodigoVerificacao Código de verificação
   */
  public function __construct($sCodigoVerificacao = NULL) {

    $this->cod_verificacao = $sCodigoVerificacao;

    parent::__construct(array('addDecorator' => array(array('Wrapper'))));
  }

  /**
   * Cria o formulario
   *
   * @see Zend_Form::init()
   */
  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->addElement(new Twitter_Bootstrap_Form_Element_Button('nova', array(
      'label'      => 'Nova',
      'type'       => 'button',
      'style'      => 'min-width: 120px',
      'url'        => $oBaseUrlHelper->baseUrl('/contribuinte/nfse/index/'),
      'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_INFO
    )));

    $this->addElement(new Twitter_Bootstrap_Form_Element_Button('imprimir', array(
      'label'      => 'Imprimir',
      'type'       => 'button',
      'style'      => 'min-width: 120px',
      'url'        => $oBaseUrlHelper->baseUrl("/contribuinte/nfse/nota-impressa/codigo_verificacao/{$this->cod_verificacao}"),
      'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY
    )));

    $this->addDisplayGroup(
      array('imprimir', 'nova'),
      'actions',
      array('disableLoadDefaultDecorators' => true, 'decorators' => array('Actions'))
    );

    return $this;
  }
}