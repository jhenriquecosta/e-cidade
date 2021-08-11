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
 * Formulario para cadastro de parametros contribuintes
 *
 * @author dbseller
 * @package Contribuinte
 * @subpackage Forms
 */
class Contribuinte_Form_ParametrosContribuinte extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Metodo para inicializacao do Formulario
   * @see Zend_Form::init()
   */
  public function init() {

    $aValidatores = array(
      new Zend_Validate_Float(array('locale' => 'br')),
      new Zend_Validate_LessThan(100),
      new Zend_Validate_GreaterThan(-0.0000001)
    );

    $this->setEnctype("multipart/form-data");
    $this->setMethod(Zend_Form::METHOD_POST);

    $oElm = $this->createElement('hidden', 'im');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('img', 'img_logo_content');
    $oElm->setAttrib('class', 'img-polaroid img-rounded');
    $oElm->setAttrib('align', 'right');
    $oElm->setAttrib('style', 'position: relative;');
    $oElm->setAttrib('src', NULL);
    $oElm->addDecorators(array(
                           array(
                             'HtmlTag',
                             array(
                               'tag' => 'div',
                               'class' => 'form-actions logo-contribuinte'
                             )
                           )
                         ));
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'nome_contribuinte');
    $oElm->setLabel('Contribuinte:');
    $oElm->setAttrib('class', 'span6');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'avisofim_emissao_nota');
    $oElm->setAttrib('class', 'span1 mask-numero');
    $oElm->setAttrib('maxlength', 3);
    $oElm->setLabel('Quantidade para aviso:');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'max_deducao', array(
      'append'      => '%',
      'description' => '"0" para desabilitar dedução'
    ));
    $oElm->setValue(0);
    $oElm->setLabel('Limite para dedução: ');
    $oElm->setAttrib('class', 'span1 mask-porcentagem');
    $oElm->setValidators($aValidatores);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'pis', array('append' => '%'));
    $oElm->setValue(0);
    $oElm->setLabel('PIS: ');
    $oElm->setAttrib('class', 'span1 mask-porcentagem');
    $oElm->setValidators($aValidatores);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'cofins', array('append' => '%'));
    $oElm->setValue(0);
    $oElm->setLabel('COFINS: ');
    $oElm->setAttrib('class', 'span1 mask-porcentagem');
    $oElm->setValidators($aValidatores);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'inss', array('append' => '%'));
    $oElm->setValue(0);
    $oElm->setLabel('INSS: ');
    $oElm->setAttrib('class', 'span1 mask-porcentagem');
    $oElm->setValidators($aValidatores);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'ir', array('append' => '%'));
    $oElm->setValue(0);
    $oElm->setLabel('IR: ');
    $oElm->setAttrib('class', 'span1 mask-porcentagem');
    $oElm->setValidators($aValidatores);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'csll', array('append' => '%'));
    $oElm->setValue(0);
    $oElm->setLabel('CSLL: ');
    $oElm->setAttrib('class', 'span1 mask-porcentagem');
    $oElm->setValidators($aValidatores);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'valor_iss_fixo', array('append' => '%'));
    $oElm->setValue(0);
    $oElm->setLabel('Aliquota ISS Fixa:');
    $oElm->setAttrib('class', 'span1 mask-porcentagem');
    $oElm->setValidators($aValidatores);
    $this->addElement($oElm);

    // Validador do file-input
    $oValidaJPG = new Zend_Validate_File_MimeType(array('image/jpeg'));
    $oValidaJPG->setMessages(array(
                               Zend_Validate_File_MimeType::FALSE_TYPE   => 'O arquivo "%value%" não possui o formato "JPG".',
                               Zend_Validate_File_MimeType::NOT_DETECTED => 'O arquivo "%value%" é inválido ou está corrompido.'
                             ));

    $oElm = $this->createElement('file', 'imagem_logo');
    $oElm->setLabel('Imagem de Logo: ');
    $oElm->setAttrib('class', 'input');
    $oElm->setAttrib('accept', '*/*');
    $oElm->addValidator($oValidaJPG);
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'codigo_parametro_tributacao');
    $this->addElement($oElm);

    // Carrega os anos para a configuração de tributação
    $iAnoCorrente       = date('Y');
    $aAnoConfTributacao = Contribuinte_Model_ParametroContribuinteTributos::getPeriodos($iAnoCorrente);

    $oElm = $this->createElement('select', 'ano', array('multiOptions' => $aAnoConfTributacao));
    $oElm->setLabel('Ano:');
    $oElm->setAttrib('class', 'span1');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'percentual_tributos', array('append' => '%'));
    $oElm->setValue(0);
    $oElm->setLabel('Valor Aproximado:');
    $oElm->setAttrib('class', 'span1 mask-porcentagem');
    $oElm->setValidators($aValidatores);
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'fonte_tributacao');
    $oElm->setAttrib('maxlength', 80);
    $oElm->setLabel('Fonte:');
    $oElm->setAttrib('class', 'span6');
    $oElm->setRequired(FALSE);
    $this->addElement($oElm);

    $this->addDisplayGroup(array(
                             'im',
                             'img_logo_content',
                             'nome_contribuinte',
                             'avisofim_emissao_nota',
                             'max_deducao',
                             'pis',
                             'cofins',
                             'inss',
                             'ir',
                             'csll',
                             'valor_iss_fixo',
                             'imagem_logo'
                           ),'parametroscontribuinte', array('legend' => 'Parâmetros Gerais'));

    $this->addDisplayGroup(array(
                             'codigo_parametro_tributacao',
                             'ano',
                             'percentual_tributos',
                             'fonte_tributacao'
                           ),'parametroscontribuintetributos', array('legend' => 'Parâmetro de Tributos'));

    $this->addElement('submit', 'submit', array(
      'label' => 'Salvar',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));

    return $this;
  }

  /**
   * Prenche os= Formulario com os dados
   * @param stdClass $oDados stdClass com as propriedades do formulario a serem preenchidas
   * @return Contribuinte_Form_ParametrosContribuinte
   */
  public function preenche(stdClass $oDados) {

    if (!is_object($oDados)) {
      return $this;
    }

    $this->im->setValue($oDados->im);

    if (!empty($oDados->nome_contribuinte)) {
      $this->nome_contribuinte->setValue($oDados->nome_contribuinte);
    }

    if ($oDados->avisofim_emissao_nota != '') {
      $this->avisofim_emissao_nota->setValue($oDados->avisofim_emissao_nota);
    } else {
      $this->avisofim_emissao_nota->setValue('0');
    }

    if (!empty($oDados->max_deducao)) {
      $this->max_deducao->setValue($oDados->max_deducao);
    } else {
      $this->max_deducao->setValue('0');
    }

    if (!empty($oDados->pis)) {
      $this->pis->setValue($oDados->pis);
    }

    if (!empty($oDados->cofins)) {
      $this->cofins->setValue($oDados->cofins);
    }

    if (!empty($oDados->inss)) {
      $this->inss->setValue($oDados->inss);
    }

    if (!empty($oDados->ir)) {
      $this->ir->setValue($oDados->ir);
    }

    if (!empty($oDados->csll)) {
      $this->csll->setValue($oDados->csll);
    }

    if (!empty($oDados->valor_iss_fixo)) {
      $this->valor_iss_fixo->setValue(DBSeller_Helper_Number_Format::toMoney($oDados->valor_iss_fixo));
    }

    if (!empty($oDados->ano)) {
      $this->ano->setValue($oDados->ano);
    }

    if (!empty($oDados->percentual_tributos)) {
      $this->percentual_tributos->setValue($oDados->percentual_tributos);
    }

    if (!empty($oDados->fonte_tributacao)) {
      $this->fonte_tributacao->setValue($oDados->fonte_tributacao);
    }

    return $this;
  }
}