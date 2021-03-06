<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (c) 2014  DBSeller Servicos de Informatica
 *                      www.dbseller.com.br
 *                   e-cidade@dbseller.com.br
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

class cl_assentamentojustificativaperiodo extends DAOBasica {

  function __construct() {
    parent::__construct("recursoshumanos.assentamentojustificativaperiodo");
  }

  /**
   * @param array $aCampos
   * @param array $aWhere
   * @param string $sOrdenacao
   * @return string
   * @throws ParameterException
   */
  public function sqlTipoAsse($aCampos = array(), $aWhere = array(), $sOrdenacao = '') {

    if(!is_array($aCampos)) {
      throw new ParameterException('Par?metro dos campos do SQL deve ser um Array.');
    }

    if(!is_array($aWhere)) {
      throw new ParameterException('Par?metro das condi??es do SQL deve ser um Array.');
    }

    $sCampos = !empty($aCampos) ? implode(', ', $aCampos) : '*';
    $sWhere  = !empty($aWhere) ? ' WHERE ' . implode(' AND ', $aWhere) : '';

    $sSql  = "select {$sCampos}";
    $sSql .= "  from assentamentojustificativaperiodo";
    $sSql .= "       inner join assenta  on h16_codigo = rh206_codigo";
    $sSql .= "       inner join tipoasse on h12_codigo = h16_assent";
    $sSql .= " {$sWhere}";
    $sSql .= " {$sOrdenacao}";

    return $sSql;
  }
}