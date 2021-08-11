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
 * Classe para controle de competencias de impostos
 *
 * @package    Contribuinte
 * @subpackage Forms
 * @see        Twitter_Bootstrap_Form_Horizontal
 */
class Contribuinte_Form_EmitirContasDesif extends Twitter_Bootstrap_Form_Horizontal {

  /**
   *  Array que guarda as competencias que serão inseridas no select
   */
  private $aCompetencias = array();

  /**
   * Sobrescreve o método construtor da classe pai, para poder adicionar as competencias
   */
  public function __construct(array $aCompetencias) {
    $this->aCompetencias = $aCompetencias;
    parent::__construct();
  }

  /**
   * Método construtor
   *
   * @return $this|void
   */
  public function init() {

    $this->setMethod(Zend_Form::METHOD_POST);
    $this->setName('form_competencia');

    $oElm = $this->createElement('select', 'competencia', array('divspan' => '4', 'multiOptions' => $this->aCompetencias));
    $oElm->setLabel('Competência:');
    $oElm->setAttrib('class', 'span2');
    $this->addElement($oElm);

    $this->addElement('button',
                      'btn_competencia',
                      array(
                        'divspan'    => 3,
                        'label'      => 'Consultar',
                        'class'      => 'span2',
                        'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
                      ));

    $this->addDisplayGroup(array('competencia', 'btn_competencia'),
                           'group_competencia',
                           array('legend' => 'Escolha a competência'));

    return $this;
  }
}