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
 * Classe responsável pelo controle dos campos dos relatório 11
 *
 * @package Fiscal/Form
 */

/**
 * @package Fiscal/Form
 */
class Fiscal_Form_Relatorio5 extends Fiscal_Form_Relatorio {

  /**
   * Método construtor, configura os campos do formulário
   *
   * @return Fiscal_Form_Relatorio5|void
   */
  public function init() {

    parent::init();

    // Elementos do formulário
    $oDataCompetenciaInicial = parent::getCampo('data_competencia_inicial');
    $oDataCompetenciaInicial->setAttrib('divspan', 10);
    $this->addElement($oDataCompetenciaInicial);

    $oBtnGerar = parent::getCampo('btn_gerar');
    $this->addElement($oBtnGerar);

    // Lista de elementos do formulário
    $aElementos = array(
      'data_competencia_inicial',
      'btn_gerar'
    );

    // Seta o grupo de elementos
    $this->addDisplayGroup($aElementos, 'relatorio', array('legend' => 'Inconsistências de Declarações'));

    return $this;
  }
}