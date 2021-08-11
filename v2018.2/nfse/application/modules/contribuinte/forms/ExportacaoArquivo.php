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
 * Classe para manipulação do formulário de exportação de arquivo
 *
 * @package Contribuinte/Forms
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Contribuinte_Form_ExportacaoArquivo extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * (non-PHPdoc)
   * @see Zend_Form::init()
   */
  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('form-exportacao-arquivo');
    $this->setMethod(Zend_form::METHOD_POST);
    $this->setAction($oBaseUrlHelper->baseUrl('/contribuinte/exportacao-arquivo/rps-consultar/'));

    $aMeses = DBSeller_Helper_Date_Date::getMesesArray();

    $aAnos = array(
      date('Y') - 0 => date('Y') - 0,
      date('Y') - 1 => date('Y') - 1,
      date('Y') - 2 => date('Y') - 2,
      date('Y') - 3 => date('Y') - 3,
      date('Y') - 4 => date('Y') - 4
    );

    $oElm = $this->createElement('select', 'mes_competencia', array('divspan' => '4', 'multiOptions' => $aMeses));
    $oElm->setLabel('Mês:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setValue(date('m'));
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'ano_competencia', array('divspan' => '6', 'multiOptions' => $aAnos));
    $oElm->setLabel('Ano:');
    $oElm->setAttrib('class', 'span2');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'numero_rps', array('divspan' => '10'));
    $oElm->setLabel('Número da NFS-e:');
    $oElm->setAttrib('class', 'span2');
    $this->addElement($oElm);

    $this->addElement('button', 'btn_consultar', array(
      'divspan'     => 4,
      'label'       => 'Consultar',
      'class'       => 'input-medium btn',
      'buttonType'  => Twitter_Bootstrap_Form_Element_Button::BUTTON_PRIMARY
    ));

    $this->addElement('button', 'btn_exportar', array(
      'divspan'     => 6,
      'label'       => 'Exportar',
      'class'       => 'input-medium btn',
      'disabled'    => TRUE,
      'buttonType'  => Twitter_Bootstrap_Form_Element_Button::BUTTON_SUCCESS
    ));

    $this->addDisplayGroup(
      array(
        'mes_competencia',
        'ano_competencia',
        'numero_rps',
        'btn_consultar',
        'btn_exportar'
      ),
      'dados_consulta',
      array('legend' => 'Parâmetros')
    );

    return $this;
  }
}