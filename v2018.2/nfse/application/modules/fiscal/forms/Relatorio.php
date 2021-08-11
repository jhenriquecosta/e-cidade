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
 * Classe genérica para geração de relatórios fiscais
 *
 * @package Fiscal
 */
class Fiscal_Form_Relatorio extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Lista de campos do formulário
   *
   * @var array
   */
  protected static $aCampos;

  /**
   * Objeto Tradutor
   *
   * @var Zend_Translate
   */
  protected static $oTranslate;

  /**
   * Objeto Auxiliar para capturar a Url Base do sistema
   *
   * @var Zend_View_Helper_BaseUrl
   */
  protected static $oBaseUrlHelper;

  /**
   * Método construtor
   *
   * (non-PHPdoc)
   * @see Zend_Form::init()
   */
  public function init() {

    // Tradução
    self::$oTranslate = Zend_Registry::get('Zend_Translate');

    // Url base do sistema
    self::$oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    // Configurações pado do formulário
    $this->setName('formRelatorio');
    $this->setMethod(Zend_form::METHOD_POST);

    $oElm = $this->createElement('text', 'prestador_cnpj', array('divspan' => '10'));
    $oElm->setLabel('CNPJ Prestador:');
    $oElm->setAttrib('class', 'span2 mask-cnpj');
    $oElm->setAttrib('maxlength', '14');
    $oElm->setAttrib('data-url', self::$oBaseUrlHelper->baseUrl('/contribuinte/empresa/dados-cgm/'));
    $oElm->addValidator(new DBSeller_Validator_Cnpj());
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addCampo($oElm);

    $oElm = $this->createElement('hidden', 'prestador_razao_social');
    $this->addCampo($oElm);

    $oElm = $this->createElement('text', 'data_competencia_inicial', array('divspan' => '4'));
    $oElm->setLabel('Competência Inicial:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('placeholder', 'Mês/Ano');
    $oElm->addValidator(new Zend_Validate_StringLength(array('min' => 7, 'max' => 7)));
    $oElm->addValidator(new Zend_Validate_Date(array('format' => 'MM/yyyy')));
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addCampo($oElm);

    $oElm = $this->createElement('text', 'data_competencia_final', array('divspan' => '6'));
    $oElm->setLabel('Competência Final:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('placeholder', 'Mês/Ano');
    $oElm->addValidator(new Zend_Validate_StringLength(array('min' => 7, 'max' => 7)));
    $oElm->addValidator(new Zend_Validate_Date(array('format' => 'MM/yyyy')));
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addCampo($oElm);

    $oElm = $this->createElement('select', 'guia_emitida', array('divspan' => '6'));
    $oElm->setLabel('Guia Emitida:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $oElm->setMultiOptions(array(1 => 'Sim', 2 => 'Não'));
    $this->addCampo($oElm);

    $oElm = $this->createElement('select', 'tipo_relatorio', array('divspan' => '6'));
    $oElm->setLabel('Tipo de Relatório:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addCampo($oElm);

    $oElm = $this->createElement('select', 'ordenacao', array('divspan' => '4'));
    $oElm->setLabel('Ordenação:');
    $oElm->setAttrib('class', 'span4');
    $oElm->removeDecorator('errors');
    $this->addCampo($oElm);

    $oElm = $this->createElement('select', 'ordem', array('divspan' => '2'));
    $oElm->setAttrib('class', 'span2');
    $oElm->removeDecorator('errors');
    $oElm->addMultiOptions(array('asc' => 'Crescente', 'desc' => 'Decrescente'));
    $this->addCampo($oElm);

    $oElm = $this->createElement('radio', 'movimentacao', array('divspan' => '6'));
    $oElm->setLabel('Movimentação:');
    $oElm->setAttrib('class', 'pull-left');
    $oElm->removeDecorator('errors');
    $oElm->addMultiOptions(array('sim' => 'Sim', 'nao' => 'Não'));
    $oElm->setValue('sim');
    $this->addCampo($oElm);

    $oElm = $this->createElement('submit', 'btn_gerar', array(
      'divspan'     => 10,
      'label'       => 'Gerar Relatório',
      'class'       => 'span2',
      'msg-loading' => 'Aguarde...',
      'buttonType'  => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY
    ));
    $this->addCampo($oElm);

    return $this;
  }

  /**
   * Adiciona o elemento na lista para ser renderizado somente quando necessário
   *
   * @param Zend_Form_Element $oElemento
   * @throws Exception
   */
  public function addCampo(Zend_Form_Element $oElemento) {

    $sNome = $oElemento->getName();

    if (!isset(self::$aCampos[$sNome])) {
      self::$aCampos[$sNome] = $oElemento;
    } else {
      throw new Exception(self::$oTranslate->_(sprintf('O elemento "%s" já foi adicionado no formulário.', $sNome)));
    }
  }

  /**
   * Retorna o elemento da lista para ser adicionado quando necessário
   *
   * @param $sNome
   * @return null
   * @throws Exception
   */
  public static function getCampo($sNome) {

    if (isset(self::$aCampos[$sNome])) {
      return self::$aCampos[$sNome];
    } else {
      throw new Exception(self::$oTranslate->_(sprintf('O elemento "%s" não foi encontrado.', $sNome)));
    }
  }

  /**
   * Sobrescreve o método para setar a action com a url base do sistema
   *
   * (non-PHPdoc)
   * @see Zend_Form::setAction()
   */
  public function setAction($sUrl = NULL) {
    parent::setAction(self::$oBaseUrlHelper->baseUrl($sUrl));
  }
}