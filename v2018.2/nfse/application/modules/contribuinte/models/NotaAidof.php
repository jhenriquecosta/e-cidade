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
 * Classe para consulta das Aidof
 *
 * @package Contribuinte
 * @subpackage Model
 *
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */

class Contribuinte_Model_NotaAidof {

  /**
   * Método que retorna as quantidades de notas pendentes do contribuinte
   *
   * @params Contribuinte_Model_Contribuinte $oContribuinte
   * @params integer $iTipoNota
   * @params string $sGrupoNota
   * @return integer $iQuantidadeNotasEmissao
   */
  public static function getQuantidadeNotasPendentes($oContribuinte, $iTipoNota = NULL, $iGrupoNota = NULL) {

    $iInscricaoMunicipal = $oContribuinte->getInscricaoMunicipal();

    if ($iGrupoNota == Contribuinte_Model_Nota::GRUPO_NOTA_NFSE) {
      $iQuantidadeNotas         = Contribuinte_Model_Nota::getQuantidadeNotasAidofContribuinte($oContribuinte);
    } else {
      $iQuantidadeNotas         = Contribuinte_Model_Nota::getNotasEmitidas($iInscricaoMunicipal, $iTipoNota, $iGrupoNota);
    }

    $iQuantidadeNotasLiberadas = Administrativo_Model_Aidof::getQuantidadesNotasEmissao($iInscricaoMunicipal, $iTipoNota, $iGrupoNota);
    $iQuantidadeNotasEmissao   = $iQuantidadeNotasLiberadas - $iQuantidadeNotas;
    $iQuantidadeNotasEmissao   = $iQuantidadeNotasEmissao > 0 ? $iQuantidadeNotasEmissao : 0;

    return $iQuantidadeNotasEmissao;
  }
}