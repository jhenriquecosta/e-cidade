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
 * Classe para controle de competencias de impostos
 *
 * @package    Contribuinte
 * @subpackage Forms
 * @see        Twitter_Bootstrap_Form_Horizontal
 */

/**
 * @package    Contribuinte
 * @subpackage Forms
 * @see        Twitter_Bootstrap_Form_Horizontal
 */
class Contribuinte_Form_DmsCompetencia extends Twitter_Bootstrap_Form_Horizontal {

  /**
   * Método construtor
   *
   * @return $this|void
   */
  public function init() {

    $this->setMethod(Zend_Form::METHOD_GET);
    $this->setName('form_competencia');

    $aMeses = DBSeller_Helper_Date_Date::getMesesArray();

    $oElm = $this->createElement('select', 'mes_competencia', array('divspan' => '3', 'multiOptions' => $aMeses));
    $oElm->setLabel('Mês:');
    $oElm->setAttrib('class', 'span2');
    $oElm->setValue(date('m'));
    $this->addElement($oElm);

    $aAnos = array(
      date('Y') - 0 => date('Y') - 0,
      date('Y') - 1 => date('Y') - 1,
      date('Y') - 2 => date('Y') - 2,
      date('Y') - 3 => date('Y') - 3,
      date('Y') - 4 => date('Y') - 4
    );

    $oElm = $this->createElement('select', 'ano_competencia', array('divspan' => '3', 'multiOptions' => $aAnos));
    $oElm->setLabel('Ano:');
    $oElm->setAttrib('class', 'span2');
    $this->addElement($oElm);

    // Ações
    $this->addElement('submit',
                      'btn_competencia',
                      array(
                        'divspan'    => 3,
                        'label'      => 'Digitar',
                        'class'      => 'span2',
                        'buttonType' => Twitter_Bootstrap_Form_Element_Submit::BUTTON_SUCCESS
                      ));

    $this->addDisplayGroup(array('mes_competencia', 'ano_competencia', 'btn_competencia'),
                           'group_competencia',
                           array('legend' => 'Escolha a competência'));

    return $this;
  }

  /**
   * Remove todos os meses que o usuario possui declaracao sem movimento
   *
   * @return $this
   */
  public function removerMesesComDeclaracao() {

    $oSession                = new Zend_Session_Namespace('nfse');
    $oCompetencia            = new Contribuinte_Model_Competencia(date('Y'), NULL, $oSession->im);
    $iMesCompetencia         = date('m') - 1;
    $aDeclaracaoSemMovimento = $oCompetencia->getDeclaracaoSemMovimento($iMesCompetencia);
    $aMeses                  = DBSeller_Helper_Date_Date::getMesesAnterioresArray();

    // Remove os meses que já tem declaracao sem movimento
    if (count($aDeclaracaoSemMovimento) > 0) {

      foreach ($aDeclaracaoSemMovimento as $oDeclaracaoSemMovimento) {
        unset($aMeses[$oDeclaracaoSemMovimento->mes]);
      }
    }

    // Desabilita geração quando não possuir meses válidos
    if (count($aMeses) == 0) {

      $this->getElement('mes_competencia')->setAttrib('disabled', TRUE);
      $this->getElement('btn_competencia')->setAttrib('disabled', TRUE);
    }

    $this->getElement('mes_competencia')->setMultiOptions($aMeses);

    return $this;
  }

  /**
   * Remove os Meses que existe movimentacao ou foi declarado sem movimento
   *
   * @return $this
   */
  public function removerMesesComMovimentacaoDeNotas() {

    $oSession                = new Zend_Session_Namespace('nfse');
    $iMesCompetencia         = (int) date('m') - 1;
    $iAnoCompetencia         = (int) ((int) date('m') == 1 ? date('Y') -1 : date('Y'));
    $oContribuinte           = $oSession->contribuinte;
    $oCompetencia            = new Contribuinte_Model_Competencia($iAnoCompetencia, $iMesCompetencia, $oContribuinte);
    $aMeses                  = DBSeller_Helper_Date_Date::getMesesAnterioresArray($iMesCompetencia);
    $aDeclaracaoSemMovimento = $oCompetencia->getDeclaracaoSemMovimento();

    // Remove os meses que já tem declaracao sem movimento
    if (count($aDeclaracaoSemMovimento) > 0) {

      foreach ($aDeclaracaoSemMovimento as $oDeclaracaoSemMovimento) {
        unset($aMeses[$oDeclaracaoSemMovimento->mes]);
      }
    }

    // Verifica se existem notas lancadas no NFSE
    if (count($aMeses) > 0) {

      foreach ($aMeses as $iMes => $sMes) {

        $aResultadoDms = Contribuinte_Model_Dms::getDadosPorCompetencia($oContribuinte->getContribuintes(),
                                                                        $iAnoCompetencia,
                                                                        $iMes,
                                                                        Contribuinte_Model_Dms::SAIDA);

        // Verifica se tem NFSe lancadas na competência
        $oParametros       = new stdClass();
        $oParametros->iMes = $iMes;
        $oParametros->iAno = $iAnoCompetencia;

        $aResultadoNota = Contribuinte_Model_Nota::getByContribuinteAndCompetencia(
                                                 $oContribuinte->getContribuintes(),
                                                 $oParametros);

        // Limpa os meses
        if (count($aResultadoDms) > 0 || count($aResultadoNota) > 0) {
          unset($aMeses[$iMes]);
        }
      }
    }

    // Desabilita geração quando não possuir meses válidos
    if (count($aMeses) == 0) {

      $this->getElement('mes_competencia')->setAttrib('disabled', TRUE);
      $this->getElement('btn_competencia')->setAttrib('disabled', TRUE);
    }

    $this->getElement('mes_competencia')->setMultiOptions($aMeses);

    return $this;
  }
}