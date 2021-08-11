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
 * Classe para listar as ruas cadastradas na prefeitura
 */
class Default_Model_Cadenderrua extends WebService_Model_Ecidade {

  private static $aCampos = array('logradouro', 'cod_logradouro');

  /**
   * Retorna todos os estados de um pais
   *
   * @return array
   */
  public static function getRuas() {

    $aRuas    = parent::consultar('getRuas', array(array(), self::$aCampos));
    $aRetorno = array();

    if (count($aRuas) > 0) {

      foreach($aRuas as $oRua) {
        $aRetorno[trim($oRua->cod_logradouro)] = trim($oRua->logradouro);
      }
    }

    return $aRetorno;
  }
}

?>