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
 * Formulario para configuracao dos parametros da prefeitura
 */
class Administrativo_Form_ParametroPrefeituraGeral extends Twitter_Bootstrap_Form_Horizontal {

  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('form_parametros_prefeitura_geral');
    $this->setAction($oBaseUrlHelper->baseUrl('/administrativo/parametro/prefeitura-salvar-geral'));

    $aZendValidators = array(
      0 => new Zend_Validate_Float(array('locale' => 'br')),
      1 => new Zend_Validate_LessThan(100),
      2 => new Zend_Validate_GreaterThan(-0.0000001)
    );

    $oElm = $this->createElement('text', 'avisofim_emissao_nota');
    $oElm->setLabel('Nº Requisições Aviso:');
    $oElm->setAttrib('class', 'span1');
    $oElm->setAttrib('maxlength', '2');
    $oElm->setValidators($aZendValidators);
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'nota_retroativa');
    $oElm->setLabel('Dias Emissão Retroativa:');
    $oElm->setAttrib('class', 'span1');
    $oElm->setAttrib('maxlength', '2');
    $oElm->setValidators($aZendValidators);
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $aValores = array('1' => 'Sim', '0' => 'Não');

    $oElm = $this->createElement('checkbox', 'verifica_autocadastro');
    $oElm->setLabel('Verificar Autocadastro:');
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('checkbox', 'solicita_cancelamento');
    $oElm->setLabel('Verificar Cancelamento:');
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('checkbox', 'reter_pessoa_fisica');
    $oElm->setLabel('Reter imposto Pessoa Física:');
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('checkbox', 'requisicao_nfse');
    $oElm->setLabel('Requisição NFS-e:');
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'tempo_bloqueio');
    $oElm->setLabel('Tempo que o Usuário será impedido de logar: (minutos)' );
    $oElm->setAttrib('class', 'span1');
    $oElm->setAttrib('maxlength', '2');
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $this->addElement('submit', 'btn_salvar_geral', array(
      'label'      => 'Salvar',
      'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
    ));

    $this->btn_salvar_geral->setDecorators(array('ViewHelper'));

    return $this;
  }

  /**
   * Preenche dados do formulario
   *
   * @param Administrativo_Model_ParametroPrefeitura() $oParametroPrefeitura
   * @return Administrativo_Form_ParametroPrefeitura
   */
  public function preenche($oParametroPrefeitura) {

    if (!is_object($oParametroPrefeitura)) {
      return $this;
    }

    if (isset($this->avisofim_emissao_nota)) {
      $this->avisofim_emissao_nota->setValue($oParametroPrefeitura->getQuantidadeAvisoFimEmissao());
    }

    if ($oParametroPrefeitura->getVerificaAutocadastro() && isset($this->verifica_autocadastro)) {
      $this->verifica_autocadastro->setValue($oParametroPrefeitura->getVerificaAutocadastro());
    }

    if (is_int($oParametroPrefeitura->getNotaRetroativa()) && isset($this->nota_retroativa)) {
      $this->nota_retroativa->setValue($oParametroPrefeitura->getNotaRetroativa());
    }

    if ($oParametroPrefeitura->getSolicitaCancelamento() && isset($this->solicita_cancelamento)) {
      $this->solicita_cancelamento->setValue($oParametroPrefeitura->getSolicitaCancelamento());
    }

    if ($oParametroPrefeitura->getReterPessoaFisica() && isset($this->reter_pessoa_fisica)) {
      $this->reter_pessoa_fisica->setValue($oParametroPrefeitura->getReterPessoaFisica());
    }

    if ($oParametroPrefeitura->getTempoBloqueio() && isset($this->tempo_bloqueio)) {
      $this->tempo_bloqueio->setValue($oParametroPrefeitura->getTempoBloqueio());
    }

    if ($oParametroPrefeitura->getRequisicaoNfse() && isset($this->requisicao_nfse)) {
      $this->requisicao_nfse->setValue($oParametroPrefeitura->getRequisicaoNfse());
    }

    return $this;
  }
}