<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

/**
 * Classe genérica para criação do formulário de consulta
 * @author  Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 * @author  Davi <davi@dbseller.com.br>
 * @package Fiscal
 */
class Fiscal_Form_ContaAbrasf extends Twitter_Bootstrap_Form_Horizontal {

  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    $this->setName('formListarContas');
    $this->setMethod(Zend_form::METHOD_POST);
    $this->setAction($oBaseUrlHelper->baseUrl('/fiscal/conta-abrasf/listar-contas'));

    $oElm = $this->createElement('text', 'conta_abrasf', array('divspan' => '5'));
    $oElm->setLabel('Conta Abrasf:');
    $oElm->setAttrib('placeholder', 'Número da conta');
    $oElm->setAttrib('class', 'span2');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'tributavel', array('divspan' => '5'));
    $oElm->setLabel('Tributável:');
    $oElm->setAttrib('placeholder', 'Selecione');
    $oElm->setAttrib('class', 'span2');
    $oElm->addMultiOptions(array(NULL => 'Todos', 't' => 'Sim', 'f' => 'Não'));
    $oElm->setValue(NULL);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'obrigatorio', array('divspan' => '10'));
    $oElm->setLabel('Obrigatório:');
    $oElm->setAttrib('placeholder', 'Selecione');
    $oElm->setAttrib('class', 'span2');
    $oElm->addMultiOptions(array(NULL => 'Todos', 't' => 'Sim', 'f' => 'Não'));
    $oElm->setValue(NULL);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $this->addElement('button', 'btn_consultar', array(
      'divspan'    => 2,
      'label'      => 'Consultar',
      'class'      => 'input-medium',
      'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY,
    ));

    $this->addDisplayGroup(
      array(
        'conta_abrasf',
        'tributavel',
        'obrigatorio',
        'btn_consultar'
      ),
      'dados_contas',
      array('legend' => 'Consulta')
    );

    return $this;
  }
}
