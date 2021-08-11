<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2016  DBSeller Servicos de Informatica
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
 * Formulário de encerramento da competência
 */
class Contribuinte_Form_CompetenciaEncerramento extends Twitter_Bootstrap_Form_Horizontal {

  public $sMensagemSituacao;

  public function init() {

    $this->setName('encerramento-competencia');

    $oElm = $this->createElement('hidden', 'ano');
    $this->addElement($oElm);

    $oElm = $this->createElement('hidden', 'mes');
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'total_servico');
    $oElm->setLabel('Total de Serviços:');
    $oElm->setAttrib('readonly', true);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'total_iss');
    $oElm->setLabel('Total de ISS:');
    $oElm->setAttrib('readonly', true);
    $this->addElement($oElm);

    $oElm = $this->createElement('text', 'data_guia');
    $oElm->setLabel('Data de Pagamento:');
    $oElm->setAttrib('class', 'mask-data');
    $oElm->setValidators(array(new Zend_Validate_Date(array('format' => 'dd/mm/yyyy'))));
    $oElm->setRequired(true);
    $oElm->removeDecorator('errors');
    $this->addElement($oElm);

    return $this;
  }

  public function preenche($oContribuinte, $oCompetencia){

    if($oCompetencia->getSituacao() == Contribuinte_Model_Competencia::SITUACAO_EM_ABERTO_SEM_MOVIMENTO){

      $this->sMensagemSituacao  = "<b>Atenção:</b> Ao encerrar a competência, a mesma será declarada ";
      $this->sMensagemSituacao .= "<b>Sem Movimentação</b>, pois não houve emissão de notas.";

      $this->getElement('total_servico')->setAttribs(array('style' => 'display: none'))
           ->getDecorator('Label')->setOption('style', 'display: none');

      $this->getElement('total_iss')->setAttribs(array('style' => 'display: none'))
           ->getDecorator('Label')->setOption('style', 'display: none');

      $this->getElement('data_guia')->setAttribs(array('style' => 'display: none'))
           ->getDecorator('Label')->setOption('style', 'display: none');

    }elseif(   $oContribuinte->isOptanteSimples(new DateTime)
            or $oContribuinte->isRegimeTributarioMei()
            or $oContribuinte->isRegimeTributarioFixado()
            or $oContribuinte->isRegimeTributarioSociedadeProfissionais()
            or $oContribuinte->isRegimeTributarioEstimativa()
            or $oContribuinte->isExegibilidadeIsentoImuni()
    ){

      $this->getElement('total_iss')->setAttribs(array('style' => 'display: none'))
           ->getDecorator('Label')->setOption('style', 'display: none');

      $this->getElement('data_guia')->setAttribs(array('style' => 'display: none'))
           ->getDecorator('Label')->setOption('style', 'display: none');

    }elseif($oCompetencia->getSituacao() == Contribuinte_Model_Competencia::SITUACAO_EM_ABERTO_SEM_IMPOSTO){

      $this->sMensagemSituacao = "<b>Atenção:</b> Nesta competência não houve imposto a pagar.";

      $this->getElement('total_iss')->setAttribs(array('style' => 'display: none'))
           ->getDecorator('Label')->setOption('style', 'display: none');

      $this->getElement('data_guia')->setAttribs(array('style' => 'display: none'))
           ->getDecorator('Label')->setOption('style', 'display: none');
    }

    $this->total_servico->setValue($oCompetencia->getFormatedTotalServico());
    $this->total_iss->setValue($oCompetencia->getFormatedTotalIss());

    $this->ano->setValue($oCompetencia->getAnoComp());
    $this->mes->setValue($oCompetencia->getMesComp());

    return $this;
  }
}