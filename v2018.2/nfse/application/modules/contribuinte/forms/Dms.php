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
 * Formulário para emissão manual de serviços - DMS
 *
 * @package Contribuinte/Forms
 * @see     Twitter_Bootstrap_Form_Horizontal
 */

/**
 * @package Contribuinte/Forms
 * @see     Twitter_Bootstrap_Form_Horizontal
 */
class Contribuinte_Form_Dms extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Contribuinte logado no sistema
   *
   * @var Contribuinte_Model_Contribuinte
   */
  protected $oContribuinte;

  /**
   * Construtor da classe
   *
   * @return $this|void
   */
  public function init() {

    $oBaseUrlHelper      = new Zend_View_Helper_BaseUrl();
    $oSessao             = new Zend_Session_Namespace('nfse');
    $this->oContribuinte = $oSessao->contribuinte;

    // Dados do DMS
    $oElm = $this->createElement('hidden', 'id_dms');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'codigo_planilha');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'data_operacao');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'numpre');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'mes_comp');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'ano_comp');
    $this->addElement($oElm);

    // Dados da Nota
    $oElm = $this->createElement('hidden', 'id');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 's_dados_cod_cnae');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'natureza_operacao', array('divspan' => '10'));
    $oElm->setLabel('Natureza da Operação:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'situacao_documento', array('divspan' => '4'));
    $oElm->setLabel('Situação do Documento:');
    $oElm->setAttrib('class', 'span3');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'tipo_documento', array('divspan' => '4'));
    $oElm->setLabel('Tipo de Documento:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_nota_data', array('divspan' => '8'));
    $oElm->setLabel('Data:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setAttrib('data-url', $oBaseUrlHelper->baseUrl('/contribuinte/dms/verificar-contribuinte-optante-simples'));
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_Date(array('locale' => 'pt-Br')));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_nota', array('divspan' => '4'));
    $oElm->setLabel('Número:');
    $oElm->setAttrib('class', 'span2 mask-numero');
    $oElm->setAttrib('maxlength', 15);
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_nota_serie', array('divspan' => '3'));
    $oElm->setLabel('Série:');
    $oElm->setAttrib('class', 'span1');
    $oElm->setAttrib('maxlength', 5);
    $this->addElement($oElm);

    $this->addDisplayGroup(array(
                             'natureza_operacao',
                             'tipo_documento',
                             'situacao_documento',
                             's_nota_data',
                             's_nota',
                             's_nota_serie'
                           ),
                           'dados_declarante',
                           array('legend' => 'Dados da Nota'));

    // Dados do Tomador
    $oElm = $this->createElement('text', 's_inscricao_municipal', array('divspan' => '9'));
    $oElm->setLabel('Inscrição Municipal:');
    $oElm->setAttrib('class', 'span2 mask-numero');
    $oElm->setAttrib('maxlength', '15');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_cpf_cnpj', array('divspan' => '4'));
    $oElm->setLabel('CPF/CNPJ:');
    $oElm->setAttrib('class', 'span2 mask-cpf-cnpj');
    $oElm->setAttrib('maxlength', '14');
    $oElm->setAttrib('data-url', $oBaseUrlHelper->baseUrl('/contribuinte/empresa/dados-cgm/'));
    $oElm->addValidator(new DBSeller_Validator_CpfCnpj());
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_razao_social', array('divspan' => '6'));
    $oElm->setLabel('Razão Social:');
    $oElm->setAttrib('class', 'span5');
    $oElm->setAttrib('maxlength', 150);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = new Twitter_Bootstrap_Form_Element_Button('s_btn_cadastro_tomador');
    $oElm->setLabel('Cadastrar Empresa');
    $oElm->setAttrib('class', 'btn span2 hidden');
    $oElm->setAttrib('href', '#myModal');
    $oElm->setAttrib('role', 'button');
    $oElm->setAttrib('data-toggle', 'modal');
    $oElm->setAttrib('modal-url', $oBaseUrlHelper->baseUrl('/contribuinte/empresa'));
    $oElm->setAttrib('modal-width', '700');
    $oElm->setAttrib('modal-height', '600');
    $oElm->setDecorators(array(
                           'ViewHelper',
                           'Label',
                           array(
                             array('out' => 'HtmlTag'),
                             array('tag' => 'div', 'class' => 'span9', 'style' => 'margin-left:180px')
                           )
                         ));
    $oElm->setIgnore(TRUE);
    $this->addElement($oElm);

    $this->addDisplayGroup(array(
                             's_inscricao_municipal',
                             's_cpf_cnpj',
                             's_razao_social',
                             's_btn_cadastro_tomador'
                           ),
                           'dados_tomador',
                           array('legend' => 'Dados do Tomador'));

    // Dados do Serviço
    $oElm = $this->createElement('text', 's_data', array('divspan' => '5'));
    $oElm->setLabel('Data:');
    $oElm->setAttrib('class', 'span2 mask-data');
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_Date(array('locale' => 'pt-Br')));
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('checkbox', 's_imposto_retido', array('divspan' => '5'));
    $oElm->setLabel('Imposto Retido:');
    $oElm->setAttrib('readonly', TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_valor_bruto', array('prepend' => 'R$', 'divspan' => '5'));
    $oElm->setLabel('Valor do Serviço:');
    $oElm->setAttrib('class', 'span2 mask-valores');
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_Float(new Zend_Locale('pt-br')));
    $oElm->addValidator(new Zend_Validate_GreaterThan(array('min' => 0, 'locale' => new Zend_Locale('pt-br'))));
    $oElm->addFilter(new Zend_Filter_Digits());
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_valor_deducao', array('prepend' => 'R$', 'divspan' => '5'));
    $oElm->setLabel('Dedução:');
    $oElm->setAttrib('class', 'span2 mask-valores');
    $oElm->addValidator(new Zend_Validate_Float(new Zend_Locale('pt-br')));
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_condicionado', array('prepend' => 'R$', 'divspan' => '5'));
    $oElm->setLabel('Desconto Condicional:');
    $oElm->setAttrib('class', 'span2 mask-valores');
    $oElm->addValidator(new Zend_Validate_Float(new Zend_Locale('pt-br')));
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_vl_desc_incondicionado', array('prepend' => 'R$', 'divspan' => '5'));
    $oElm->setLabel('Desconto Incondicional:');
    $oElm->setAttrib('class', 'span2 mask-valores');
    $oElm->addValidator(new Zend_Validate_Float(new Zend_Locale('pt-br')));
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_aliquota', array('append' => '%', 'divspan' => '5'));
    $oElm->setLabel('Alíquota:');
    $oElm->setAttrib('class', 'span1 mask-porcentagem');
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_Between(array('min' => 0, 'max' => 9999, 'inclusive' => TRUE)));
    $oElm->addFilter(new Zend_Filter_Digits());
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_base_calculo', array('prepend' => 'R$', 'divspan' => '5'));
    $oElm->setLabel('Base de Cálculo:');
    $oElm->setAttrib('class', 'span2 mask-valores');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->setRequired(TRUE);
    $oElm->addValidator(new Zend_Validate_Float(new Zend_Locale('pt-br')));
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_valor_imposto', array('prepend' => 'R$', 'divspan' => '5'));
    $oElm->setLabel('Valor Imposto:');
    $oElm->setAttrib('class', 'span2 mask-valores');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->addValidator(new Zend_Validate_Float(new Zend_Locale('pt-br')));
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_valor_pagar', array('prepend' => 'R$', 'divspan' => '5'));
    $oElm->setLabel('Valor Líquido:');
    $oElm->setAttrib('class', 'span2 mask-valores');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->addValidator(new Zend_Validate_Float(new Zend_Locale('pt-br')));
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 's_servico_prestado', array('divspan' => '10'));
    $oElm->setLabel('Serviço:');
    $oElm->setAttrib('class', 'span9');
    $oElm->setAttrib('data-url', $oBaseUrlHelper->baseUrl('/contribuinte/dms/emissao-manual-buscar-dados-servico/'));
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('textarea', 's_observacao', array('divspan' => '10'));
    $oElm->setLabel('Descrição do Serviço:');
    $oElm->setAttrib('class', 'span9 exibir-contador-maxlength');
    $oElm->setAttrib('rows', '3');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_codigo_obra', array('divspan' => '3'));
    $oElm->setLabel('Código da Obra:');
    $oElm->setAttrib('class', 'span2');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_art', array('divspan' => '8'));
    $oElm->setLabel('ART:');
    $oElm->setAttrib('class', 'span2');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 's_valor_pagar', array('prepend' => 'R$', 'divspan' => '5'));
    $oElm->setLabel('Valor Líquido:');
    $oElm->setAttrib('class', 'span2 mask-valores');
    $oElm->setAttrib('readonly', TRUE);
    $oElm->addValidator(new Zend_Validate_Float(new Zend_Locale('pt-br')));
    $this->addElement($oElm);

    $oElm = $this->createElement('textarea', 's_informacoes_complementares', array('divspan' => '10'));
    $oElm->setLabel('Outras Informações:');
    $oElm->setAttrib('class', 'span9 exibir-contador-maxlength');
    $oElm->setAttrib('rows', '3');
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    // Ações
    $this->addElement('button', 'btn_lancar_servico', array(
      'divspan'    => 2,
      'label'      => 'Lançar Documento',
      'class'      => 'input-medium',
      'buttonType' => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY,
    ));

    $this->addDisplayGroup(array(
                             's_data',
                             's_imposto_retido',
                             's_valor_bruto',
                             's_valor_deducao',
                             's_vl_condicionado',
                             's_vl_desc_incondicionado',
                             's_aliquota',
                             's_base_calculo',
                             's_valor_imposto',
                             's_valor_pagar',
                             's_servico_prestado',
                             's_observacao',
                             's_codigo_obra',
                             's_art',
                             's_informacoes_complementares',
                             'btn_lancar_servico'
                           ),
                           'dados_servico',
                           array('legend' => 'Dados do Serviço'));

    return $this;
  }

  /**
   * Popula Natureza da Operação
   *
   * @param integer|null $iNaturezaOperacao
   * @return $this
   */
  public function setNaturezaOperacao($iNaturezaOperacao = NULL) {

    $aNaturezaOperacao = array(
      '' => '- Selecione -',
      1  => 'Tributação no Município',
      2  => 'Tributação Fora do Município',
    );

    $this->getElement('natureza_operacao')->addMultiOptions($aNaturezaOperacao)->setValue($iNaturezaOperacao);

    return $this;
  }

  /**
   * Popula o combo situacao_documento
   *
   * @param integer|null $iSituacaoDocumento
   * @return $this
   */
  public function setSituacaoDocumento($iSituacaoDocumento = NULL) {

    $aSitucaoDocumento = array(
      'N' => 'Normal',
      'C' => 'Cancelado',
      'E' => 'Extraviado',
    );

    $this->getElement('situacao_documento')->addMultiOptions($aSitucaoDocumento)->setValue($iSituacaoDocumento);

    return $this;
  }

  /**
   * Popula o combo tipo_documento com dados do e-Cidade
   *
   * @param integer|null $iTipoDocumento
   * @return $this
   */
  public function setTipoDocumento($iTipoDocumento = NULL) {

    $iInscricaoMunicipal       = $this->oContribuinte->getInscricaoMunicipal();
    $aTiposDocumentos          = array();
    $aTiposDocumentosLiberados = Administrativo_Model_RequisicaoAidof::getRequisicoesAidof($iInscricaoMunicipal);

    // Lista tipos de documentos liberados
    if (count($aTiposDocumentosLiberados) > 0) {

      foreach ($aTiposDocumentosLiberados as $oTiposDocumentos) {

        $iCodigoNota   = $oTiposDocumentos->codigo_nota;
        $oAidof        = new Administrativo_Model_Aidof();
        $iNotasEmissao = $oAidof->getQuantidadesNotasEmissao($iInscricaoMunicipal, $iCodigoNota);

        if (empty($iTipoDocumento) && $iNotasEmissao <= 0) {
          continue;
        }

        $sDescricaoNota = DBSeller_Helper_String_Format::wordsCap($oTiposDocumentos->descricao_nota);

        $aTiposDocumentos[$oTiposDocumentos->codigo_nota] = $sDescricaoNota;
      }
    }

    $this->getElement('tipo_documento')->addMultiOptions($aTiposDocumentos)->setValue($iTipoDocumento);

    return $this;
  }

  /**
   * Popula o combo de serviços
   *
   * @param integer|null $iCodigoServico código do serviço
   * @return $this
   */
  public function setServico($iCodigoServico = NULL) {

    $aServicos = Contribuinte_Model_Servico::getByIm($this->oContribuinte->getInscricaoMunicipal());
    $aDados    = array('' => '-- Escolha o Serviço --');

    if (is_array($aServicos)) {

      foreach ($aServicos as $oServico) {

        $sAtividade                               = strtolower($oServico->attr('atividade'));
        $aDados[$oServico->attr('cod_atividade')] = DBSeller_Helper_String_Format::wordsCap($sAtividade);
      }
    }

    $this->getElement('s_servico_prestado')->addMultiOptions($aDados)->setValue($iCodigoServico);

    return $this;
  }
}