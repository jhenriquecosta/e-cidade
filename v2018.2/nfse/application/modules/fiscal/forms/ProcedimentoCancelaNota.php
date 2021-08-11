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
 * Class Fiscal_Form_ProcedimentoCancelaNota
 *
 * @package Fiscal/Forms
 */
class Fiscal_Form_ProcedimentoCancelaNota extends Twitter_Bootstrap_Form_Horizontal {

  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $sBaseUrlAction = $oBaseUrlHelper->baseUrl("/fiscal/procedimento/cancela-nota");

    $this->setName("form-procedimento-cancela-nota");
    $this->setAction($sBaseUrlAction);
    $this->setMethod(Zend_form::METHOD_POST);

    $oElm = $this->createElement("select", "id_contribuinte", array("divspan" => "12", "multiOptions" => $this->getContribuintes()));
    $oElm->setLabel("Contribuinte:");
    $oElm->setAttrib("class", "input-xlarge");
    $oElm->setRequired(true);
    $oElm->removeDecorator("errors");
    $this->addElement($oElm);

    $oElm = $this->createElement("text", "nota", array("divspan" => "12"));
    $oElm->setLabel("Número da Nota:");
    $oElm->setAttrib("class", "input-xlarge mask-numero");
    $oElm->setAttrib("maxlength", "15");
    $oElm->setRequired(true);
    $oElm->removeDecorator("errors");
    $this->addElement($oElm);

    $aMotivoMultiOptions = array(
      ""  => "",
      "3" => "Duplicidade da nota",
      "1" => "Erro na emissão",
      "2" => "Serviço não prestado",
      "9" => "Outros"
    );

    $oElm = $this->createElement("select", "motivo", array("divspan" => "12"));
    $oElm->setLabel("Motivo:");
    $oElm->setAttrib("class", "input-xlarge");
    $oElm->setAttrib("style", "width: 285px");
    $oElm->addMultiOptions($aMotivoMultiOptions);
    $oElm->setRequired(true);
    $oElm->removeDecorator("errors");
    $this->addElement($oElm);

    $oElm = $this->createElement("textarea", "justificativa", array("divspan" => "12"));
    $oElm->setLabel("Justificativa:");
    $oElm->setAttrib("rows", "4");
    $oElm->setAttrib("style", "width: 271px");
    $oElm->setRequired(true);
    $oElm->removeDecorator("errors");
    $this->addElement($oElm);

    $this->addElement("submit", "btn_confirma", array(
      "divspan"    => "12",
      "label"      => "Confirmar",
      "class"      => "input-medium",
      "style"      => "margin-top: 10px",
      "buttonType" => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY,
    ));

    $this->addDisplayGroup(
      array("id_contribuinte",
            "nota",
            "motivo",
            "justificativa",
            "btn_confirma"),
      "group_cancela_nota",
      array("legend" => "Cancelamento de NFS-e")
    );
  }

  public function getContribuintes()
  {
    $aContribuintes = array("" => "");

    $aUsuariosContribuintes = Administrativo_Model_UsuarioContribuinte::getAll();

    foreach ($aUsuariosContribuintes as $oUsuariosContribuintes) {

      if ($oUsuariosContribuintes->getUsuario()->getTipo() == Administrativo_Model_TipoUsuario::$CONTRIBUINTE) {

        $iCodigo  = $oUsuariosContribuintes->getId();
        $sNome    = trim(DBSeller_Helper_String_Format::wordsCap($oUsuariosContribuintes->getUsuario()->getNome()));
        $sCnpjCpf = DBSeller_Helper_Number_Format::maskCPF_CNPJ($oUsuariosContribuintes->getUsuario()->getLogin());

        $aContribuintes[$iCodigo] = "{$sNome} ({$sCnpjCpf})";
      }
    }

    return $aContribuintes;
  }
}