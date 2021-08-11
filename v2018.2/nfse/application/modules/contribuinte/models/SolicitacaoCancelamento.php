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
 * Modelo responsável da solicitação de cancelamento ao fiscal
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
class Contribuinte_Model_SolicitacaoCancelamento extends Contribuinte_Lib_Model_Doctrine {

  static protected $entityName = 'Contribuinte\SolicitacaoCancelamento';
  static protected $className  = __CLASS__;

  public function persist() {

    self::getEm()->persist($this->getEntity());
    self::getEm()->flush();
  }

  /**
   * Método que grva a solicitação de cancelamento	
   * @param  \Contribuinte\Nota $oNota,
   * @param  \Administrativo\Usuario $oUsuario
   * @param  array $aDados
   * @throws Exception
   */
  public function solicitar($oNota, array $aDados, $oUsuario) {

  	try {

  		$oDateSolicitacao = new DateTime();
  		$sEmailTomador 		= isset($aDados['email']) ? $aDados['email'] : null;

  		$this->setNota($oNota);
  		$this->setDtSolicitacao($oDateSolicitacao);
  		$this->setJustificativa($aDados['cancelamento_justificativa']);
  		$this->setUsuario($oUsuario);
  		$this->setMotivo($aDados['cancelamento_motivo']);
  		$this->setEmailTomador($sEmailTomador);
  		$this->persist();

  	} catch (Exception $oError) {
  		throw $oError;
  	}
  }
}