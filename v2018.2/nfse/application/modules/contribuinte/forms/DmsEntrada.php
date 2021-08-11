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
 * Formulário para emissão de DMS de serviços tomados
 *
 * @package Contribuinte/Form
 * @see Contribuinte_Form_Dms
 */

/**
 * @package Contribuinte/Form
 * @see Contribuinte_Form_Dms
 */
class Contribuinte_Form_DmsEntrada extends Contribuinte_Form_Dms {

  /**
   * Construtor
   *
   * @return $this|void
   */
  public function init() {

    parent::init();

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setAction($oBaseUrlHelper->baseUrl('/contribuinte/dms/emissao-manual-entrada-salvar'));

    // Atributos utilizadas no JS, para manter o controle de URL no lado server
    $this->setAttrib('sUrlCalculaValoresDms',
                     $oBaseUrlHelper->baseUrl('/contribuinte/dms/emissao-manual-calcula-valores-dms'));
    $this->setAttrib('sUrlVerificaDocumento',
                     $oBaseUrlHelper->baseUrl('/contribuinte/dms/emissao-manual-entrada-verificar-documento'));

    if (isset($this->s_cpf_cnpj)) {

      $this->getElement('s_cpf_cnpj')->setLabel('CPF / CNPJ:');
      $this->getElement('s_cpf_cnpj')->setAttrib('class', 'span2 mask-cpf-cnpj');
      $this->getElement('s_cpf_cnpj')->setRequired(TRUE);
    }

    if (isset($this->s_razao_social)) {
      $this->getElement('s_razao_social')->setRequired(TRUE);
    }

    // Remove o campo de inscricao municipal
    $this->removeElement('s_inscricao_municipal');
    $this->removeElement('s_servico_prestado');

    // Ajusta mascara para porcentagem
    $oElm = $this->getElement('s_aliquota');
    $oElm->setAttrib('class', $oElm->getAttrib('class') . ' mask-porcentagem');

    // Altera o texto do fieldset do prestador
    $oFieldsetDadosTomador = $this->getDisplayGroup('dados_tomador');
    $oFieldsetDadosTomador->setLegend('Dados do Prestador');

    // Carrega combo
    parent::setNaturezaOperacao();
    parent::setSituacaoDocumento();
    self::setTipoDocumento();

    return $this;
  }

  /**
   * Popula o combo tipo_documento com dados do e-Cidade
   *
   * @param integer $iTipoDocumento
   * @return $this|void
   */
  public function setTipoDocumento($iTipoDocumento = NULL) {

    $oNota            = new Contribuinte_Model_Nota();
    $aTiposDocumentos = $oNota->getTiposNota($oNota::GRUPO_NOTA_ALL);

    $this->getElement('tipo_documento')->addMultiOptions($aTiposDocumentos)->setValue($iTipoDocumento);

    return $this;
  }
}