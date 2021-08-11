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
 * Classe responsável pela comunicação com o Ecidade dos dados referentes as Gráficas
 *
 * @package Administrativo/Model
 */

/**
 * @package Administrativo/Model
 */
class Administrativo_Model_Grafica extends WebService_Model_Ecidade {

  /**
   * Retorna uma lista de gráficas em array de objetos
   *
   * @return array|null
   */
  public static function listar() {

    $aFiltro  = array();
    $aCampos  = array('cgm_grafica', 'nome_grafica');
    $aRetorno = parent::consultar('getGraficas', array($aFiltro, $aCampos));

    return is_array($aRetorno) ? $aRetorno : NULL;
  }

  /**
   * Retorna uma lista de gráficas em array
   *
   * @return array
   */
  public static function listarEmArray() {

    $aArrayObject = self::listar();
    $aRetorno     = array();

    foreach ($aArrayObject as $oObjeto) {
      $aRetorno[$oObjeto->cgm_grafica] = DBSeller_Helper_String_Format::wordsCap($oObjeto->nome_grafica);
    }

    return $aRetorno;
  }
}