<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2017  DBSeller Servicos de Informatica
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
 * Class Fiscal_Form_ProcedimentoAlteracaoRegimeNotaSimples
 *
 * @package Fiscal/Forms
 */
class Fiscal_Form_ProcedimentoAlteracaoRegimeNotaSimples extends Twitter_Bootstrap_Form_Horizontal {

  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $sBaseUrlAction = '';

    $this->setName("form-procedimento-alteracao-regime-notas-simples");
    $this->setAction($sBaseUrlAction);
    $this->setMethod(Zend_form::METHOD_POST);

    $oElm = $this->createElement("select", "id_usuario", array("divspan" => "12", "multiOptions" => $this->getContribuintes()));
    $oElm->setLabel("Contribuinte:");
    $oElm->setAttrib("class", "input-xlarge");
    $oElm->setRequired(true);
    $oElm->removeDecorator("errors");
    $this->addElement($oElm);

    $this->addElement("button", "btn_consultar", array(
      "divspan"    => "6",
      "label"      => "Consultar",
      "class"      => "input-medium",
      "style"      => "margin-top: 10px",
      "buttonType" => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY,
    ));

    $this->addElement("button", "btn_processar", array(
      "divspan"    => "6",
      "label"      => "Processar",
      "class"      => "input-medium",
      "style"      => "margin-top: 10px",
      "disable"   => "true",
      "buttonType" => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY,
    ));

    $this->addDisplayGroup(
      array("id_usuario",
            "btn_consultar",
            "btn_processar"),
      "group_alteracao-regime-notas-simples",
      array("legend" => "Alteração de Regime de Notas para Simples")
    );
  }

  /**
   * Obtem todos os usuarios que são contribuintes
   * @return array array para popular o select
   */
  public function getContribuintes()
  {
    $aContribuintes = array("" => "");

    $aParametros = array (
      'habilitado' => true,
      'tipo'       => array(
         1, 2
      )
    );

    $aOrdem = array (
      'nome' => 'ASC'
    );

    $aUsuarios = Administrativo_Model_Usuario::getByAttributes($aParametros, $aOrdem);

    foreach ($aUsuarios as $oUsuario) {

      $iCodigo  = $oUsuario->getId();
      $sNome    = trim(DBSeller_Helper_String_Format::wordsCap($oUsuario->getNome()));
      $sCnpjCpf = DBSeller_Helper_Number_Format::maskCPF_CNPJ($oUsuario->getLogin());

      $aContribuintes[$iCodigo] = "{$sNome} ({$sCnpjCpf})";
    }

    return $aContribuintes;
  }
}