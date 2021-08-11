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
 * Formulario para configuracao dos parametros da prefeitura
 *
 * @package Administrativo/Forms
 * @see Twitter_Bootstrap_Form_Horizontal
 * @author dbeverton.heckler
 */
class Administrativo_Form_ParametroPrefeituraNfse extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Construtor da classe
   *
   * @see Zend_Form::init()
   */
  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('form_parametros_prefeitura_nfse');
    $this->setAction($oBaseUrlHelper->baseUrl('/administrativo/parametro/prefeitura-salvar-nfse'));

    $oElm = $this->createElement('select', 'modelo_importacao_rps');
    $oElm->setLabel('Modelo de Importação de RPS:');
    $oElm->setAttrib('class', 'span3');
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    // Carrega os modelos de impressao
    self::setModelosImportacaoRps($oElm);

    $oElm = $this->createElement('select', 'modelo_impressao_nfse');
    $oElm->setLabel('Modelo de Impressão:');
    $oElm->setAttrib('class', 'span3');
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    // Carrega os modelos de impressao
    self::setModelosImpressao($oElm);

    $oElm = $this->createElement('textarea', 'informacoes_complementares_nfse');
    $oElm->setLabel('Informações Complementares da Nota:');
    $oElm->setAttrib('class', 'span6 exibir-contador-maxlength');
    $oElm->setAttrib('rows', 4);
    $oElm->setAttrib('maxlength', 600);
    $oElm->removeDecorator('errors');
    $oElm->setValidators(array(new Zend_Validate_StringLength(array('max' => 600)))); // TODO Ver tamanho no PDF
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'secretaria');
    $oElm->setLabel('Secretaria:');
    $oElm->setAttrib('class', 'span6');
    $oElm->setAttrib('maxlength', 100);
    $oElm->removeDecorator('errors');
    $oElm->setValidators(array(new Zend_Validate_StringLength(array('max' => 100)))); // TODO Ver tamanho no PDF
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'setor');
    $oElm->setLabel('Setor:');
    $oElm->setAttrib('class', 'span6');
    $oElm->setAttrib('maxlength', 100);
    $oElm->removeDecorator('errors');
    $oElm->setValidators(array(new Zend_Validate_StringLength(array('max' => 100)))); // TODO Ver tamanho no PDF
    $this->addElement($oElm);

    $this->addElement('submit', 'btn_salvar_nfse', array(
      'label'      => 'Salvar',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));

    $this->btn_salvar_nfse->setDecorators(array('ViewHelper'));

    return $this;
  }

  /**
   * Carrega os modelos de importação de RPS no elemento
   *
   * @param Zend_Form_Element $oElemento
   * @param string            $sValor
   * @return Administrativo_Form_ParametroPrefeituraNfse
   */
  public function setModelosImportacaoRps(Zend_Form_Element $oElemento, $sValor = '') {

    $aValores = array('1' => 'ABRASF 1.0');

    $oElemento->addMultiOptions($aValores);
    $oElemento->setValue($sValor);

    return $this;
  }

  /**
   * Carrega os modelos de impressao no elemento
   *
   * @param Zend_Form_Element $oElemento
   * @param string            $sValor
   * @return $this
   */
  public function setModelosImpressao(Zend_Form_Element $oElemento, $sValor = '') {

    $aValores = array(
      '1' => 'Modelo 1',
      '2' => 'Modelo 2',
      '3' => 'Modelo 3',
      '4' => 'Modelo 4',
      '5' => 'Modelo 5'
    );

    $oElemento->addMultiOptions($aValores);
    $oElemento->setValue($sValor);

    return $this;
  }

  /**
   * Preenche dados do formulario
   *
   * @param Administrativo_Model_ParametroPrefeitura $oParametroPrefeitura
   * @return Administrativo_Form_ParametroPrefeitura
   */
  public function preenche(Administrativo_Model_ParametroPrefeitura $oParametroPrefeitura) {

    if ($oParametroPrefeitura->getModeloImportacaoRps() && isset($this->modelo_importacao_rps)) {
      $this->modelo_importacao_rps->setValue($oParametroPrefeitura->getModeloImportacaoRps());
    }

    if ($oParametroPrefeitura->getModeloImpressaoNfse() && isset($this->modelo_impressao_nfse)) {
      $this->modelo_impressao_nfse->setValue($oParametroPrefeitura->getModeloImpressaoNfse());
    }

    if ($oParametroPrefeitura->getInformacoesComplementaresNfse() && isset($this->informacoes_complementares_nfse)) {
      $this->informacoes_complementares_nfse->setValue($oParametroPrefeitura->getInformacoesComplementaresNfse());
    }

    if ($oParametroPrefeitura->getSetor() && isset($this->setor)) {
      $this->setor->setValue($oParametroPrefeitura->getSetor());
    }

    if ($oParametroPrefeitura->getSecretaria() && isset($this->secretaria)) {
      $this->secretaria->setValue($oParametroPrefeitura->getSecretaria());
    }

    return $this;
  }
}