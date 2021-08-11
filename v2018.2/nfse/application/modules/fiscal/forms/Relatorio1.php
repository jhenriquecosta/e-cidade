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
 * Class Relatorio1_Form
 *
 * Classe responsável pelo controle dos campos do relatório1
 *
 * @package Fiscal
 */
class Fiscal_Form_Relatorio1 extends Fiscal_Form_Relatorio {

  /**
   * Constante para o tipo de relatório 4
   */
  const TIPO4 = 4;

  /**
   * Constante para o tipo de relatório 5
   */
  const TIPO5 = 5;

  /**
   * Método construtor, renderiza os campos do formulário
   *
   * @return $this|void
   */
  public function init() {

    parent::init();

    // Elementos do formulário
    $oDataCompetenciaInicial = parent::getCampo('data_competencia_inicial');
    $this->addElement($oDataCompetenciaInicial);

    $oDataCompetenciaFinal = parent::getCampo('data_competencia_final');
    $this->addElement($oDataCompetenciaFinal);

    $oOrdenacao = parent::getCampo('ordenacao');
    $this->addElement($oOrdenacao);

    $oOrdem = parent::getCampo('ordem');
    $this->addElement($oOrdem);

    $oBtnGerar = parent::getCampo('btn_gerar');
    $this->addElement($oBtnGerar);

    // Lista de elementos do formulário
    $aElementos = array(
      'data_competencia_inicial',
      'data_competencia_final',
      'ordenacao',
      'ordem',
      'btn_gerar'
    );

    // Seta o grupo de elementos
    $this->addDisplayGroup($aElementos, 'relatorio1');

    return $this;
  }

  /**
   * Carrega os valores de ordenação da consulta do relatório no elemento informado
   *
   * @param null                     $sValor
   * @param Zend_Form_Element_Select $oElemento
   * @param integer                  $iRelatorio
   * @return $this
   */
  public function carregaOrdenacao($sValor = NULL, Zend_Form_Element_Select $oElemento, $iRelatorio = self::TIPO4) {

    $aValoresElemento[] = NULL;

    if ($iRelatorio == self::TIPO4) {

      $aValoresElemento = array(
        'inscricao' => 'Inscrição',
        'nome'      => 'Nome',
        'valor'     => 'Valor',
      );
    } else if ($iRelatorio == self::TIPO5) {

      $aValoresElemento = array(
        'atividade_servico' => 'Atividade / Serviço',
        'valor_total'       => 'Valor Total',
      );
    }

    $oElemento->addMultiOptions($aValoresElemento);
    $oElemento->setValue($sValor);

    return $this;
  }

  /**
   * Renderiza os campos do formulário
   *
   * @param integer $iRelatorio
   * @return string|void
   */
  public function render($iRelatorio = self::TIPO4) {

    $oOrdenacao = parent::getCampo('ordenacao');
    $this->carregaOrdenacao(NULL, $oOrdenacao, $iRelatorio);

    if ($iRelatorio == self::TIPO4) {
      $this->getDisplayGroup('relatorio1')->setLegend('Evolução de Arrecação');
    } else if ($iRelatorio == self::TIPO5) {
      $this->getDisplayGroup('relatorio1')->setLegend('Valores Atividade/Serviço');
    }

    return parent::render();
  }
}