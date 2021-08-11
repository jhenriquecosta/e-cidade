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
 * Class Fiscal_Form_AberturaCompetencia
 *
 * @package Fiscal/Forms
 */
class Fiscal_Form_ProcedimentoAberturaCompetencia extends Twitter_Bootstrap_Form_Horizontal {

  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $sBaseUrlAction = $oBaseUrlHelper->baseUrl("/fiscal/procedimento/abertura-competencia");

    $this->setName("form-procedimento-abertura-competencia");
    $this->setAction($sBaseUrlAction);
    $this->setMethod(Zend_form::METHOD_POST);

    $oElm = $this->createElement("select", "id_contribuinte", array("divspan" => "12", "multiOptions" => $this->getContribuintes()));
    $oElm->setLabel("Contribuinte:");
    $oElm->setAttrib("class", "input-xlarge");
    $oElm->setRequired(true);
    $oElm->removeDecorator("errors");
    $this->addElement($oElm);

    $aAnos = array(
      date('Y') - 0  => date('Y') - 0,
      date('Y') - 1  => date('Y') - 1,
      date('Y') - 2  => date('Y') - 2,
      date('Y') - 3  => date('Y') - 3,
      date('Y') - 4  => date('Y') - 4,
      date('Y') - 5  => date('Y') - 5,
      date('Y') - 6  => date('Y') - 6,
      date('Y') - 7  => date('Y') - 7,
      date('Y') - 8  => date('Y') - 8,
      date('Y') - 9  => date('Y') - 9,
      date('Y') - 10 => date('Y') - 10
    );

    $oElm = $this->createElement("select", "ano_competencia", array("divspan" => "12", "multiOptions" => $aAnos));
    $oElm->setLabel("Ano:");
    $oElm->setAttrib("class", "input-xlarge");
    $oElm->setAttrib("style", "width: 285px");
    $oElm->setRequired(true);
    $oElm->removeDecorator("errors");
    $this->addElement($oElm);

    $aMeses = DBSeller_Helper_Date_Date::getMesesArray();

    $oElm = $this->createElement("select", "mes_competencia", array("divspan" => "12", "multiOptions" => $aMeses));
    $oElm->setLabel("Mês:");
    $oElm->setAttrib("class", "input-xlarge");
    $oElm->setAttrib("style", "width: 285px");
    $oElm->setValue(date("m"));
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
            "ano_competencia",
            "mes_competencia",
            "btn_confirma"),
      "group_abertura-competencia",
      array("legend" => "Abertura de Competência")
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