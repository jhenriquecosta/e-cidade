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
 * Formulario para Guia de Tomador
 */
class Contribuinte_Form_GuiaTomador extends Twitter_Bootstrap_Form_Horizontal {

    private $cpfcnpj = null;
    private $inscricao = null;
    private $ano_comp = null;
    private $mes_comp = null;
    private $total_iss = null;
    private $total_servico = null;

    public function __construct($cpfcnpj, $inscricao, $ano_comp, $mes_comp, $total_iss, $total_servico, $options = null) {
        $this->cpfcnpj = $cpfcnpj;
        $this->inscricao = $inscricao;
        $this->ano_comp = $ano_comp;
        $this->mes_comp = $mes_comp;
        $this->total_iss = $total_iss;
        $this->total_servico = $total_servico;
        parent::__construct($options);
    }

    public function init() {
      
      $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();
      
        $this->setAction($oBaseUrlHelper->getBaseUrl('/contribuinte/guia/notas-tomador'));
        $this->setMethod(Zend_form::METHOD_POST);
        $this->setAttrib('id', 'nota');
        
        $e = $this->createElement('hidden', 'cpfcnpj')
                ->setValue($this->cpfcnpj);
        $this->addElement($e);
        
        $e = $this->createElement('hidden', 'inscricao')
                ->setValue($this->inscricao);
        $this->addElement($e);
        
        $e = $this->createElement('hidden', 'ano_comp')
                ->setValue($this->ano_comp);
        $this->addElement($e);
        
        $e = $this->createElement('hidden', 'mes_comp')
                ->setValue($this->mes_comp);
        $this->addElement($e);
        
        $e = $this->createElement('text', 'competencia')
                ->setValue($this->mes_comp . '/' . $this->ano_comp)
                ->setLabel('Competência')
                ->setAttrib('readonly', true);
        $this->addElement($e);
        
        $e = $this->createElement('text', 'total_servicos')
                ->setValue('R$ ' . number_format($this->total_servico,2,',','.'))
                ->setLabel('Total de serviços')
                ->setAttrib('readonly', true);
        $this->addElement($e);
        
        $e = $this->createElement('text', 'total_iss')
                ->setValue('R$ ' . number_format($this->total_iss,2,',','.'))
                ->setLabel('Total de ISS')
                ->setAttrib('readonly', true);
        $this->addElement($e);
        
        $e = $this->createElement('text','data_guia')
                ->setLabel('Data do pagamento')
                ->setValidators(array(new Zend_Validate_Date(array('format' => 'dd/mm/yyyy'))));
        $this->addElement($e);
    }

}

?>