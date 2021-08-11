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
 * Class Contribuinte_Model_CancelamentoNota
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Contribuinte_Model_CancelamentoNota extends Contribuinte_Lib_Model_Doctrine {

  static protected $entityName = "Contribuinte\CancelamentoNota";
  static protected $className  = __CLASS__;

  // Constantes para identificar os motivos de cancelamento
  const CANCELAMENTO_ERRO_EMISSAO          = 1;
  const CANCELAMENTO_SERVICO_NAO_PRESTADO  = 2;
  const CANCELAMENTO_NOTA_DUPLICADA        = 3;
  const CANCELAMENTO_OUTROS                = 9;

  // Propriedades do modelo Contribuinte_Model_Nota
  private $oNota = null;

  /**
   * Adiciona a nota cancelada
   *
   * @param Contribuinte_Model_Nota $oNota
   */
  public function setNotaCancelada(Contribuinte_Model_Nota $oNota) {
    $this->oNota = $oNota;
  }

  /**
   * Adiciona o usuario que efetuou o cancelamento
   *
   * @param Administrativo_Model_Usuario $oUsuario
   */
  public function setUsuarioCancelamento(Administrativo_Model_Usuario $oUsuario) {
    $this->setUsuario($oUsuario->getEntity());
  }

  /**
   * Adiciona a justificativa de cancelamento
   *
   * @param $sJustificativa
   * @throws Exception
   */
  public function setJustificativa($sJustificativa) {

    if (strlen(trim($sJustificativa)) < 1) {
      throw new Exception('Justificativa do cancelamento não informada.');
    }

    $this->oNota->setCancelamentoJustificativa($sJustificativa);
  }

  /**
   * Adiciona o motivo de cancelamento
   *
   * @param $iMotivo
   */
  public function setMotivoCancelmento($iMotivo) {
    $this->setMotivo($iMotivo);
  }

  /**
   * Adiciona a data e hora do cancelamento
   *
   * @param DateTime $oDataHora
   */
  public function setDataHora(\DateTime $oDataHora) {

    $this->setData($oDataHora);
    $this->setHora($oDataHora);
  }

  /**
   * Salva os dados do cancelamento da nota
   *
   * @throws Exception
   */
  public function salvar() {

    if (!$this->oNota->getId()) {
      throw new Exception('Identificador da nota não encontrado.');
    }

    $this->oNota->setCancelada(TRUE);
    $this->oNota->persist($this->oNota->getEntity());

    $this->setNota($this->oNota->getEntity());
    $this->getEm()->persist($this->getEntity());
    $this->getEm()->flush();
  }

  /**
   * Retorna a data em que o cancelamento foi efeutado
   * @return DateTime;
   */

  public function getData() {
    return $this->getEntity()->getData();
  }

  /**
   * Retorna a hora do cancelamento
   * @return DateTime
   */
  public function getHora() {
    return $this->getEntity()->getHora();
  }

  /**
   * Retorna o Motivo do cancelamento da nota
   * @return integer
   */
  public function getMotivo() {
    return $this->getEntity()->getMotivo();
  }

}