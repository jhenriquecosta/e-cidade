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
 * Formulário para emissão de DMS para prestadores eventuais
 *
 * @package Contribuinte/Forms
 * @see Contribuinte_Form_Dms
 */

/**
 * @package Contribuinte/Forms
 * @see Contribuinte_Form_Dms
 */
class Contribuinte_Form_DmsSaidaEventual extends Contribuinte_Form_Dms {

  /**
   * Construtor
   *
   * @return $this|void
   */
  public function init() {
    
    parent::init();
    
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
    
    $this->setAction($oBaseUrlHelper->baseUrl('/contribuinte/dms/emissao-manual-saida-salvar'));
    
    // Remove elementos
    $this->removeElement('natureza_operacao');
    $this->removeElement('situacao_documento');
    $this->removeElement('tipo_documento');
    $this->removeElement('s_imposto_retido');
    $this->removeElement('s_data');

    // Adiciona elementos
    $oElm = $this->createElement('hidden', 'natureza_operacao');
    $oElm->setValue(1); // Somente "dentro do município"
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 's_imposto_retido');
    $oElm->setValue(0);
    $this->addElement($oElm);
    
    $oElm = $this->createElement('hidden', 'situacao_documento');
    $oElm->setValue('N'); // Somente "normal"
    $this->addElement($oElm);
    
    $oElm = $this->createElement('text', 'tipo_documento_descricao', array('divspan' => '10'));
    $oElm->setLabel('Tipo de Documento:');
    $oElm->setAttrib('class', 'span5');
    $oElm->setOrder(3);
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oGrupo = $this->getDisplayGroup('dados_declarante');
    $oGrupo->addElement($oElm);
    
    // Ajuste layout
    $oElm = $this->createElement('text', 's_data', array('divspan' => '8'));
    $oElm->setLabel('Data:');
    $oElm->setAttrib('class', 'span2 mask-data');
    $oElm->setOrder(0);
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_Date(array('locale' => 'pt-Br')));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);
    
    $oGrupo = $this->getDisplayGroup('dados_servico');
    $oGrupo->addElement($oElm);
    
    // Outros ajustes
    $oElm = $this->getElement('s_servico_prestado');
    $oElm->setAttrib('data-url', $oBaseUrlHelper->getBaseUrl('/contribuinte/dms/emissao-manual-buscar-dados-servico/'));
    $oElm->setAttrib('class', 'span7');
    
    self::setServico();
    
    return $this;
  }
  
  /**
   * Popula o combo de serviços
   *
   * @param integer $iCodigoServico código do serviço
   * @return $this|void
   */
  public function setServico($iCodigoServico = NULL) {
    
    $aServicos = Contribuinte_Model_Servico::getAll();
    $aDados    = array('' => '-- Escolha o Serviço --');
    
    if (is_array($aServicos)) {
      
      foreach ($aServicos as $oServico) {
        
        $sAtividade                               = strtolower($oServico->attr('atividade'));
        $aDados[$oServico->attr('cod_atividade')] = DBSeller_Helper_String_Format::wordsCap($sAtividade);
      }
    }
    
    $this->s_servico_prestado->addMultiOptions($aDados);
    $this->s_servico_prestado->setValue($iCodigoServico);
  }  
}