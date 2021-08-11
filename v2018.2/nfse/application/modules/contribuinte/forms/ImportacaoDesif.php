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
 * Classe para manipulação do formulário de importação de arquivo
 * 
 * @package Contribuinte/Forms
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
class Contribuinte_Form_ImportacaoDesif extends Twitter_Bootstrap_Form_Horizontal {
  
  public function init() {
    
    $this->setName('form_importacao_desif');
    $this->setMethod('post');
    
    $oElm = $this->createElement('file', 'arquivoContas');
    $oElm->setLabel('Arquivo de Contas: ');
    $oElm->setAttrib('class', 'input');
    $oElm->setAttrib('accept', '*/*');
    $oElm->setRequired(true);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('file', 'arquivoReceita');
    $oElm->setLabel('Arquivo de Receitas: ');
    $oElm->setAttrib('class', 'input');
    $oElm->setAttrib('accept', '*/*');
    $oElm->setRequired(true);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('submit', 'processar', array(
      'label'      => 'Processar',
      'class'      => 'input-medium',
      'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY)
    );

    $this->addElement($oElm);
    
    $this->addDisplayGroup(array(
                            'arquivoContas',
                            'arquivoReceita',
                            'processar',
                          ),
                          'desif',
                          array('legend' => 'Arquivos para Importação'));
    
    return $this;
  }
}