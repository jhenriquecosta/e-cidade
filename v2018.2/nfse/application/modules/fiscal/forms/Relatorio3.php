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
 * Class Relatorio3_Form
 * Classe responsável pelo controle dos campos do relatório3
 *
 * @package Fiscal/Form
 */

/**
 * @package Fiscal/Form
 */
class Fiscal_Form_Relatorio3 extends Fiscal_Form_Relatorio {

  /**
   * Método construtor, renderiza os campos do formulário
   *
   * @return $this|void
   */
  public function init() {

    parent::init();

    // Elementos do formulário
    $oDataCompetencia = parent::getCampo('data_competencia_inicial');
    $oDataCompetencia->setAttrib('divspan', 10);
    $this->addElement($oDataCompetencia);

    $oOrdenacao = parent::getCampo('ordenacao');
    $this->addElement($oOrdenacao);

    $oOrdem = parent::getCampo('ordem');
    $this->addElement($oOrdem);

    $oBtnGerar = parent::getCampo('btn_gerar');
    $this->addElement($oBtnGerar);

    // Lista de elementos do formulário
    $aElementos = array(
      'data_competencia_inicial',
      'ordenacao',
      'ordem',
      'btn_gerar'
    );

    // Seta o grupo de elementos
    $this->addDisplayGroup($aElementos, 'relatorio3');

    return $this;
  }

  /**
   * Renderiza os campos do formulário
   *
   * @return string|void
   */
  public function render() {

    $oOrdenacao = parent::getCampo('ordenacao');
    $this->carregaOrdenacao(NULL, $oOrdenacao);
    $this->getDisplayGroup('relatorio3')->setLegend('Comparativo de Declarações');

    return parent::render();
  }

  /**
   * Carrega os valores de ordenação da consulta do relatório no elemento informado
   *
   * @param null                     $sValor
   * @param Zend_Form_Element_Select $oElemento
   * @return $this
   */
  public function carregaOrdenacao($sValor = NULL, Zend_Form_Element_Select $oElemento) {

    $aValoresElemento        = array(
      'tomador_cnpjcpf'      => parent::$oTranslate->_('CPF/CNPJ Tomador'),
      'tomador_razao_social' => parent::$oTranslate->_('Nome/Razão Social Tomador')
    );

    $oElemento->addMultiOptions($aValoresElemento);
    $oElemento->setValue($sValor);

    return $this;
  }
}