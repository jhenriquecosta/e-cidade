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
 * Modelo responsável pela abstração do dados da estrutura de receitas do DES-IF
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 * @author Roberto <roberto@dbseller.com.br>
 */
class Contribuinte_Model_ImportacaoDesifReceita extends Contribuinte_Lib_Model_Doctrine {

  static protected $entityName = 'Contribuinte\ImportacaoDesifReceita';
  static protected $className  = __CLASS__;

  public function persist() {

    $oEntidade = $this->getEntity();
    $this->getEm()->persist($oEntidade);
    $this->getEm()->flush();
  }

  /**
   * Método que pega os valores das receitas de um importação para Relatório
   * @param  integer $iIdImportacao
   * @return array
   * @throws Exception
   */
  public static function getReceitasContasByImportacao($iIdImportacao) {

  	try {
  		
	  	$em 				= self::getEm();
	    $sDql       = 'SELECT p.conta_abrasf,
	    										 	c.descricao_conta,
	    										 	r.valr_cred_mens,
	    										 	r.valr_debt_mens,
	    										 	r.rece_decl,
	    										 	r.dedu_rece_decl,
	    										 	r.base_calc,
	    										 	r.aliq_issqn,
	    										 	r.inct_fisc
	    							 FROM Contribuinte\ImportacaoDesifReceita r 
	    							 INNER JOIN Contribuinte\ImportacaoDesifConta c WITH c.id = r.importacao_desif_conta
	    							 INNER JOIN Contribuinte\PlanoContaAbrasf p WITH p.id = c.plano_conta_abrasf
	    							 WHERE r.importacao_desif = :i';
	    $oQuery     = $em->createQuery($sDql)->setParameters(array('i' => $iIdImportacao));
	    $aResultado = $oQuery->getResult();

	    return $aResultado;
  	} catch (Exception $oError) {
  		throw $oError;
  	}
  }
}
