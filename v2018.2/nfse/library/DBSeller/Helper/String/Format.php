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

class DBSeller_Helper_String_Format extends Zend_View_Helper_Abstract {

  /**
   * Retorna string formata com a primeira letra maiscula de cada palavra
   *
   * @param string $sString
   * @return string
   */
  public static function wordsCap($sString) {

    $sPreposicaoMaiscula  = array(' E ', ' De ', ' Da ', ' Do ', ' Das ', ' Dos ');
    $sPreposicaoMinuscula = array(' e ', ' de ', ' da ', ' do ', ' das ', ' dos ');
    $sCharsetErro         = array('Ç', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Á', 'Â', 'Ê', 'Ô', 'Ã', 'Õ');
    $sCharsetAcerto       = array('ç', 'á', 'é', 'í', 'ó', 'ú', 'à', 'â', 'ê', 'ô', 'ã', 'õ');
    $sString              = ucwords(strtolower(trim($sString)));
    $sString              = str_replace($sPreposicaoMaiscula, $sPreposicaoMinuscula, $sString);
    $sString              = str_replace($sCharsetErro,        $sCharsetAcerto,       $sString);

    return $sString;
  }

  /**
   * Retorna a versão do NFS-e formatada
   *
   * @param string $sNfseConfig
   * @return string
   */
  public static function versionNfse($sNfseConfig) {

    $sVersaoPrincipal   = substr($sNfseConfig,1,2);
    $sVersaoAtualizacao = substr($sNfseConfig,3,2);
    $sVersaoCorrecao    = substr($sNfseConfig,5,2);

    return "V {$sVersaoPrincipal}.{$sVersaoAtualizacao}.{$sVersaoCorrecao}";
  }

  /**
   * Metodo para limpar strings de caracteres invalidos
   * @param  string $sString String de origem
   * @return string          retorno
   */
  public static function sanitize($sString) {

    $aBusca = array('<', '>');
    $sString = str_replace($aBusca, ' ', $sString);

    return $sString;

  }
}