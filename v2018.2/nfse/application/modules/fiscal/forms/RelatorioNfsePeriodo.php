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
 * Class Relatorio1_Form
 *
 * Classe responsável pelo controle dos campos do relatório de nfse por período
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 * @package Fiscal
 */
class Fiscal_Form_RelatorioNfsePeriodo extends Twitter_Bootstrap_Form_Horizontal {

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
   * Método construtor, renderiza os campos do formulário
   *
   * @return $this|void
   */
  public function init() {

    parent::init();

    // Tradução
    self::$oTranslate = Zend_Registry::get('Zend_Translate');

    // Url base do sistema
    self::$oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    // Configurações pado do formulário
    $this->setName('formRelatorio');
    $this->setMethod(Zend_form::METHOD_POST);
    $this->setAction('/fiscal/relatorio-nfse-periodo/consultar');

    $oElm = $this->createElement('text', 'data_nota_inicial', array('divspan' => '4'));
    $oElm->setLabel('Competência Inicial:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('placeholder', 'Dia/Mês/Ano');
    $oElm->addValidator(new Zend_Validate_StringLength(array('min' => 10, 'max' => 10)));
    $oElm->addValidator(new Zend_Validate_Date(array('format' => 'dd/MM/yyyy')));
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'data_nota_final', array('divspan' => '4'));
    $oElm->setLabel('Competência Final:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('placeholder', 'Dia/Mês/Ano');
    $oElm->addValidator(new Zend_Validate_StringLength(array('min' => 10, 'max' => 10)));
    $oElm->addValidator(new Zend_Validate_Date(array('format' => 'dd/MM/yyyy')));
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'natureza_operacao',
                                  array('divspan' => '4',
                                    'multioptions' => array(
                                      '' => 'Todos',
                                      1 => 'Tributação no Município',
                                      2 => 'Tributação Fora do Município')
    ));
    $oElm->setLabel('Natureza da Operação:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setRequired(FALSE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 's_dados_iss_retido',
                                  array('divspan' => '4',
                                    'multioptions' => array(
                                      '' => 'Todos',
                                      1 => 'Sim',
                                      2 => 'Não')
    ));
    $oElm->setLabel('Subst. Tributário (Retido):');
    $oElm->setAttrib('class', 'span2');
    $oElm->setRequired(FALSE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('submit', 'btn_gerar', array(
        'divspan'     => 10,
        'label'       => 'Gerar Relatório',
        'class'       => 'span2',
        'msg-loading' => 'Aguarde...',
        'buttonType'  => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY
    ));

    $this->addElement($oElm);

    // Lista de elementos do formulário
    $aElementos = array(
      'data_nota_inicial',
      'data_nota_final',
      'natureza_operacao',
      's_dados_iss_retido',
      'btn_gerar'
    );

    // Seta o grupo de elementos
    $this->addDisplayGroup($aElementos, "relatorio-nfse-periodo");

    return $this;
  }
}