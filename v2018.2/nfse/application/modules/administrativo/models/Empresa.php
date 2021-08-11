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
 * Class Administrativo_Model_Empresa
 *
 * @package Contribuinte/Controllers
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */

class Administrativo_Model_Empresa extends WebService_Model_Ecidade {

  private static $aCampos = array('inscricao', 'cgm', 'nome', 'cnpj', 'tipo_emissao');

  private static function get($sFiltro) {

    return parent::consultar('getContadoresEmpresas', array($sFiltro, self::$aCampos));
  }

  /**
   * Busca empresa por cnpj
   *
   * @param string $sCnpj
   * @return array
   */
  public static function getByCnpj($sCnpj) {

    $aEmpresas = self::get(array('contador' => $sCnpj));

    if ($aEmpresas == null)
      return array();

    $aRetorno = array();

    foreach ($aEmpresas as $oEmpresa) {
      $aRetorno[] = new self($oEmpresa);
    }

    return $aRetorno;
  }

  /**
   * Retorna o logotipo da empresa no eCidade
   *
   * @param integer $iInscricaoMunicipal
   * @return mixed|null|string
   */
  public static function getLogoByIm($iInscricaoMunicipal) {

    $aParametros = array('inscricao_municipal' => $iInscricaoMunicipal);
    $sLogotipo   = parent::processar('EmpresaFotoPrincipal', $aParametros);
    $sLogotipo   = base64_decode($sLogotipo);
    $sArquivo    = NULL;

    if ($sLogotipo) {

      $sArquivo = APPLICATION_PATH . "/../public/tmp/ImgLogo_{$iInscricaoMunicipal}_ts_.jpg";

      fopen($sArquivo, "wb+");
      file_put_contents($sArquivo, $sLogotipo);

      $sArquivo = end(explode('/', $sArquivo));
    }

    return $sArquivo;
  }

  /**
   * Método para alterar o logo do contribuinte no e-cidade
   *
   * @param $iInscricaoMunicipal
   * @param $aFiles
   *
   * @return bool
   */
  public static function setLogoByIm($iInscricaoMunicipal, $aFiles) {

    $bRetorno = TRUE;

    if (is_array($aFiles)) {

      $aArquivoLogo = array();
      $aImagemLogo  = $aFiles['imagem_logo'];
      $iFileSize    = (!empty($aImagemLogo['size'])) ? $aImagemLogo['size'] : 0;

      if ($iFileSize > 0) {

        $aArquivoLogo['encode'] = base64_encode(file_get_contents($aImagemLogo['tmp_name']));
        $aParametros            = array(
                                        'inscricao_municipal' => $iInscricaoMunicipal,
                                        'arquivo'             => $aArquivoLogo['encode']
                                       );

        $bRetorno = parent::processar('setEmpresaFotoPrincipal', $aParametros);
        if (empty($sRetorno)) {
          $bRetorno = FALSE;
        }
      }
    }

    return $bRetorno;
  }
}