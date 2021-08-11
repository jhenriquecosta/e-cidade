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
 * Classe responsável pelo controle dos campos dos relatório 9 e 10
 *
 * @package Fiscal/Form
 */

/**
 * @package Fiscal/Form
 */
class Fiscal_Form_Relatorio4 extends Fiscal_Form_Relatorio {

  /**
   * Constante para o tipo de relatório 9
   */
  const TIPO9 = 'NAO_RETIDO_TOMADOR_E_RETIDO_PRESTADOR';

  /**
   * Constante para o tipo de relatório 10
   */
  const TIPO10 = 'NAO_RETIDO_PRESTADOR_E_RETIDO_TOMADOR';

  /**
   * Método construtor, configura os campos do formulário
   *
   * @return Fiscal_Form_Relatorio4|void
   */
  public function init() {

    parent::init();

    // Elementos do formulário
    $oDataCompetenciaInicial = parent::getCampo('data_competencia_inicial');
    $oDataCompetenciaInicial->setAttrib('divspan', 10);
    $this->addElement($oDataCompetenciaInicial);

    $oTipoRelatorio = parent::getCampo('tipo_relatorio');
    $oTipoRelatorio->setAttrib('divspan', 10);
    $oTipoRelatorio->setAttrib('class', 'span6');
    $this->carregaTipoRelatorio(NULL, $oTipoRelatorio);
    $this->addElement($oTipoRelatorio);

    $oOrdenacao = parent::getCampo('ordenacao');
    $this->addElement($oOrdenacao);

    $oOrdem = parent::getCampo('ordem');
    $this->addElement($oOrdem);

    $oBtnGerar = parent::getCampo('btn_gerar');
    $this->addElement($oBtnGerar);

    // Lista de elementos do formulário
    $aElementos = array(
      'data_competencia_inicial',
      'tipo_relatorio',
      'ordenacao',
      'ordem',
      'btn_gerar'
    );

    // Seta o grupo de elementos
    $this->addDisplayGroup($aElementos, 'relatorio');

    return $this;
  }

  /**
   * Carrega os valores para os tipos de relatório no elemento informado
   *
   * @param string                   $sValor
   * @param Zend_Form_Element_Select $oElemento
   * @return Fiscal_Form_Relatorio4
   */
  public function carregaTipoRelatorio($sValor = NULL, Zend_Form_Element_Select $oElemento) {

    $aValoresElemento = array(
      self::TIPO9  => parent::$oTranslate->_('Não retido pelo Tomador e retido pelo Prestador'),
      self::TIPO10 => parent::$oTranslate->_('Não retido pelo Prestador e retido pelo Tomador')
    );

    $oElemento->addMultiOptions($aValoresElemento);
    $oElemento->setValue($sValor);

    return $this;
  }

  /**
   * Carrega os valores de ordenação da consulta do relatório no elemento informado
   *
   * @param string                   $sValor
   * @param Zend_Form_Element_Select $oElemento
   * @return Fiscal_Form_Relatorio4
   */
  public function carregaOrdenacao($sValor = NULL, Zend_Form_Element_Select $oElemento) {

    $aValoresElemento = array(
      'cabecalho_contribuinte_cnpjcpf'      => parent::$oTranslate->_('CNPJ/CPF'),
      'cabecalho_contribuinte_razao_social' => parent::$oTranslate->_('Nome/Razão')
    );

    $oElemento->addMultiOptions($aValoresElemento);
    $oElemento->setValue($sValor);

    return $this;
  }

  /**
   * Renderiza os campos do formulário
   *
   * @param Zend_View_Interface $oView
   * @param string              $sRelatorio
   * @return string
   */
  public function render(Zend_View_Interface $oView = NULL, $sRelatorio = self::TIPO9) {

    $oOrdenacao = parent::getCampo('ordenacao');

    $this->carregaOrdenacao(NULL, $oOrdenacao, $sRelatorio);
    $this->getDisplayGroup('relatorio')->setLegend('Comparativo de Retenções');

    return parent::render($oView);
  }
}