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
 * Classe auxiliar para lidar com datas
 *
 * @package DBSeller/Helper/Date
 * @see     Zend_View_Helper_Abstract
 */

/**
 * @package DBSeller/Helper/Date
 * @see     Zend_View_Helper_Abstract
 */
class DBSeller_Helper_Date_Date extends Zend_View_Helper_Abstract {

  /**
   * Lista dos meses por extenso
   *
   * @var array
   */
  protected static $aMeses = array(
    1  => 'Janeiro',
    2  => 'Fevereiro',
    3  => 'Março',
    4  => 'Abril',
    5  => 'Maio',
    6  => 'Junho',
    7  => 'Julho',
    8  => 'Agosto',
    9  => 'Setembro',
    10 => 'Outubro',
    11 => 'Novembro',
    12 => 'Dezembro'
  );

  /**
   * Retorna a data invertida
   *
   * @param string $_date
   * @param string $_newSeparator
   * @return string
   */
  public static function invertDate($_date, $_newSeparator = '-') {

    return implode($_newSeparator, array_reverse(explode('/', (str_replace(array('/', '-', '.'), '/', $_date)))));
  }

  /**
   * Retorna o mês por extenso
   *
   * @param string $sMes
   * @return string
   */
  public static function mesExtenso($sMes) {

    return isset(self::$aMeses[(int) $sMes]) ? self::$aMeses[(int) $sMes] : '-';
  }

  /**
   * Retorna a lista de meses
   *
   * @return array
   */
  public static function getMesesArray() {

    return self::$aMeses;
  }

  /**
   * Retorna os meses seguintes ao mês informado, incluindo o mês informado
   *
   * @param int $iMes
   * @return array
   */
  public static function getMesesSeguintesArray($iMes = 0) {

    $aMeses = self::$aMeses;

    foreach ($aMeses as $iMesValida => $sValue) {

      if ($iMesValida < (int) $iMes) {
        unset($aMeses[(int) $iMesValida]);
      }
    }

    return $aMeses;
  }

  /**
   * Retorna os meses anteriores ao mês informado, incluindo o mês informado
   *
   * @param int $iMes
   * @return array
   */
  public static function getMesesAnterioresArray($iMes = 0) {

    $aMeses = self::$aMeses;

    foreach ($aMeses as $iMesValida => $sValue) {
      if ($iMesValida > (int) $iMes && (int) $iMes != (int) 0) {
        unset($aMeses[(int) $iMesValida]);
      }
    }

    return $aMeses;
  }

  /**
   * Retorna a data por extenso
   *
   * @param DateTime|null $oData Se não informada, pega a data atual do servidor
   * @return string
   */
  public static function getDataExtenso(DateTime $oData = NULL) {

    if (!$oData instanceof DateTime) {
      $oData = new DateTime();
    }

    return $oData->format('d') . ' de ' . self::mesExtenso($oData->format('m')) . ' de ' . $oData->format('Y');
  }
}