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
 * Formulário da competência da Guia
 *
 * @package Contribuinte/Form
 * @see Twitter_Bootstrap_Form_Horizontal
 */

/**
 * @package Contribuinte/Form
 * @see Twitter_Bootstrap_Form_Horizontal
 */
class Contribuinte_Form_GuiaCompetencia extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Equivalente ao construtor da classe
   *
   * @return $this|void
   */
  public function init() {

    $this->setName('fechar-competencia');

    $oElm = $this->createElement('hidden', 'ano');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'mes');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'aliq_issqn');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'total_servico');
    $oElm->setLabel('Total de Serviços:');
    $oElm->setAttrib('readonly', TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'total_iss');
    $oElm->setLabel('Total de ISS:');
    $oElm->setAttrib('readonly', TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'data_guia');
    $oElm->setLabel('Data de Pagamento:');
    $oElm->setAttrib('class', 'mask-data');
    $oElm->setValidators(array(new Zend_Validate_Date(array('format' => 'dd/mm/yyyy'))));
    $oElm->setRequired(TRUE);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    return $this;
  }

  /**
   * Preenche os campos com os valores passados
   *
   * @param $oCompetencia
   * @param $oGuia
   * @return $this
   */
  public function preenche($oCompetencia = NULL, $oGuia = NULL) {

    if (is_object($oCompetencia)) {

      $bPagamentoParcial = false;

      if (is_object($oGuia) && $oGuia->getId()) {

        $oElm = $this->createElement('hidden', 'guia');
        $oElm->setValue($oGuia->getId());
        $this->addElement($oElm);

        $bPagamentoParcial = $oGuia->getPagamentoParcial();

        // Desconta o valor pago do original quando for um pagamento parcial
        if ($bPagamentoParcial && $oGuia->getValorPago() < $oGuia->getValorOrigem()) {
          $nValorDebito = $oGuia->getValorOrigem() - $oGuia->getValorPago();
        }
      }

      if ($oCompetencia->getAnoComp()) {
        $this->ano->setValue($oCompetencia->getAnoComp());
      }

      if ($oCompetencia->getMesComp()) {
        $this->mes->setValue($oCompetencia->getMesComp());
      }

      if ($oCompetencia->getFormatedTotalServico() && isset($this->total_servico)) {
        $this->total_servico->setValue($oCompetencia->getFormatedTotalServico());
      }

      // Verifica se foi feito algum pagamento parcial desconta o valor pago do valor de origem
      if ($bPagamentoParcial) {
        $this->total_iss->setValue(DBSeller_Helper_Number_Format::toMoney($nValorDebito, 2, 'R$ '));
      } else {

        if ($oCompetencia->getFormatedTotalIss() && isset($this->total_iss)) {
          $this->total_iss->setValue($oCompetencia->getFormatedTotalIss());
        }
      }
    }

    return $this;
  }

  /**
   * Preenche os campos referentes ao DMS com os valores passados
   *
   * @param $oGuia
   * @return $this
   */
  public function preencheDms($oGuia = null) {

    if ($oGuia->getId()) {

      $oElm = $this->createElement('hidden', 'guia');
      $oElm->setValue($oGuia->getId());
      $this->addElement($oElm);
    }

    if ($oGuia->getAnoComp() && isset($this->ano)) {
      $this->getElement('ano')->setValue($oGuia->getAnoComp());
    }

    if ($oGuia->getMesComp() && isset($this->mes)) {
      $this->getElement('mes')->setValue($oGuia->getMesComp());
    }

    if ($oGuia->getValorCorrigido() && isset($this->total_servico)) {
      $this->getElement('total_servico')->setValue($oGuia->getValorCorrigido());
    }

    if ($oGuia->getValorHistorico() && isset($this->total_iss)) {
      $this->getElement('total_iss')->setValue($oGuia->getValorHistorico());
    }

    return $this;
  }
}