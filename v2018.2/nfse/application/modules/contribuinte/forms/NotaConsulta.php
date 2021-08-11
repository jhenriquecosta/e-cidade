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
 * Formulário para Consulta de Notas
 *
 * @package Contribuinte/Form
 */

/**
 * @package Contribuinte/Form
 * @author  Everton Catto <everton.heckler@dbseller.com.br>
 */
class Contribuinte_Form_NotaConsulta extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Cria Formulário
   *
   * @see Zend_Form::init()
   */
  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('formConsulta');
    $this->setMethod(Zend_form::METHOD_POST);
    $this->setAction($oBaseUrlHelper->baseUrl('/contribuinte/nfse/consulta-processar'));

    $oElm = $this->createElement('text', 'numero_nota', array('divspan' => '4'));
    $oElm->setLabel('Número da Nota:');
    $oElm->setAttrib('class', 'span2 mask-numero');
    $oElm->setAttrib('maxlength', '15');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('checkbox', 'retido', array('divspan' => '6'));
    $oElm->setLabel('Subst. Tributária: ');
    $oElm->setAttrib('class', 'span1');
    $oElm->addValidator(new Zend_Validate_Date(array('locale' => 'pt-Br')));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'cpfcnpj', array('divspan' => '4'));
    $oElm->setLabel('CPF / CNPJ (Tomador):');
    $oElm->setAttrib('class', 'span2 mask-cpf-cnpj');
    $oElm->setAttrib('maxlength', '14');
    $oElm->setAttrib('data-url', $oBaseUrlHelper->baseUrl('/contribuinte/empresa/dados-cgm/'));
    $oElm->addValidator(new DBSeller_Validator_CpfCnpj());
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_razao_social', array('divspan' => '6'));
    $oElm->setLabel('Razão Social:');
    $oElm->setAttrib('class', 'span5');
    $oElm->setAttrib('maxlength', 150);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'data_emissao_inicial', array('divspan' => '4'));
    $oElm->setLabel('Data Inicial:');
    $oElm->setAttrib('class', 'span2');
    $oElm->addValidator(new Zend_Validate_Date(array('locale' => 'pt-Br')));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'data_emissao_final', array('divspan' => '6'));
    $oElm->setLabel('Data Final:');
    $oElm->setAttrib('class', 'span2');
    $oElm->addValidator(new Zend_Validate_Date(array('locale' => 'pt-Br')));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'ordenacao_campo', array('divspan' => '4'));
    $oElm->setLabel('Campo da Ordenação:');
    $oElm->setAttrib('class', 'span2');
    $oElm->addMultiOptions(array(
                             's_vl_bc'        => 'Base de Cálculo',
                             'competencia'    => 'Competência',
                             'dt_nota'        => 'Data de Emissão',
                             's_vl_iss'       => 'ISS',
                             'nota'           => 'Número',
                             't_razao_social' => 'Tomador'
                           ));
    $oElm->setValue('nota');
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'ordenacao_direcao', array('divspan' => '6'));
    $oElm->setLabel('Direção da Ordenação:');
    $oElm->setAttrib('class', 'span2');
    $oElm->addMultiOptions(array('desc' => 'Decrescente', 'asc' => 'Crescente'));
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $this->addElement('submit', 'btn_consultar', array(
      'divspan'    => 2,
      'label'      => 'Consultar',
      'class'      => 'input-medium',
      'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY,
    ));

    $this->addDisplayGroup(array(
                             'numero_nota',
                             'retido',
                             'cpfcnpj',
                             's_razao_social',
                             'data_emissao_inicial',
                             'data_emissao_final',
                             'ordenacao_campo',
                             'ordenacao_direcao',
                             'btn_consultar'
                           ),
                           'dados_consulta',
                           array('legend' => 'Parâmetros'));

    return $this;
  }
}