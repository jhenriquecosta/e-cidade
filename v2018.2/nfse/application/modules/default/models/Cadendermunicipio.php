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
 * Classe responsável pela manipulação dos dados do município
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */
class Default_Model_Cadendermunicipio extends Global_Lib_Model_Doctrine {

  static protected $entityName = 'Geral\Municipio';
  static protected $className  = __CLASS__;

  /**
   * Retorna todas as cidades de um estado
   * @param integer $iEstado
   * @return array
   */
  public static function getByEstado($iEstado) {

    $sSql       = 'SELECT m FROM Geral\Municipio m WHERE m.uf = :uf ORDER BY m.uf, m.nome';
    $aResultado = self::getEm()->createQuery($sSql)->setParameter('uf', $iEstado)->getResult();
    $aRetorno   = array();

    if ($aResultado === NULL) {
      return NULL;
    }

    foreach ($aResultado as $oRetorno) {
      $aRetorno[trim($oRetorno->getCodIbge())] = trim($oRetorno->getNome());
    }

    return $aRetorno;
  }

  /**
   * Retorna os dados do município pelo código IBGE
   */
  public static function getByCodIBGE ($iCodIBGE) {
    return parent::getByAttribute('cod_ibge', $iCodIBGE);
  }
}
