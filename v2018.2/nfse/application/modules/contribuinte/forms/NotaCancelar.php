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
 * Formulario para cancelamento da NFSE
 */
class Contribuinte_Form_NotaCancelar extends Twitter_Bootstrap_Form_Vertical {

  /**
   * Cria o formulario
   *
   * @see Zend_Form::init()
   */
  public function init() {

    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('formCancelar');
    $this->setAction($oBaseUrlHelper->baseUrl('/contribuinte/nfse/cancelar-post'));

    $oElm = $this->createElement('hidden', 'id');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'email');
    $oElm->setLabel('Email Tomador:');
    $oElm->setAttrib('style', 'width:95%');
    $oElm->setAttrib('autofocus', 'autofocus');
    $oElm->setRequired(FALSE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    $oElm = $this->createElement('select', 'cancelamento_motivo', array('divspan' => '4'));
    $oElm->setLabel('Motivo:');
    $oElm->setAttrib('style', 'width:95%');
    $oElm->addMultiOptions(array(
                             '9' => 'Outros',
                             '1' => 'Erro na emissão',
                             '2' => 'Serviço não prestado',
                             '3' => 'Duplicidade da nota'
                           ));
    $oElm->setValue('9');
    $oElm->removeDecorator('errors');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('textarea', 'cancelamento_justificativa');
    $oElm->setLabel('Justificativa:');
    $oElm->setAttrib('style', 'width:95%');
    $oElm->setAttrib('rows', '4');
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    return $this;
  }
}