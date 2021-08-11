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


use Doctrine\Common\Util\Debug;
/**
 * Classe para importação de arquivo de DMS
 *
 * @package Contribuinte
 * @subpackage Model
 */
class Contribuinte_Model_ImportarDmsEcidade {

  /**
   * Processa o arquivo de importação no ecidade
   *
   * @param integer $iIdUsuario identificador do usuario
   * @param string $sArquivoBase64 Texto do arquivo encodado em base64
   * @return mixed
   */
  public static function processarArquivo($oContador, $oContribuinte, $sArquivoBase64) {

    $sCpfCnpjContador                = NULL;
    $iInscricaoMunicipalContribuinte = NULL;

    if ($oContador instanceof Administrativo_Model_Usuario) {
      $sCpfCnpjContador = $oContador->getCnpj();
    }

    if ($oContribuinte instanceof Contribuinte_Model_ContribuinteAbstract) {
      $iInscricaoMunicipalContribuinte = $oContribuinte->getInscricaoMunicipal();
    }

    /**
     * @todo O parâmetro $iIdUsuario foi inserido para pode importar arquivos por contador, analisar
     * melhor para tratar por um identificador que existam tanto no contador como no contribuinte
     */
    $aParametros = array(
      'sCpfCnpjContador'                => $sCpfCnpjContador,
      'iInscricaoMunicipalContribuinte' => $iInscricaoMunicipalContribuinte,
      'sArquivoEmBase64'                => $sArquivoBase64
    );
    $oRetornoWebService = WebService_Model_Ecidade::processar('processamentoArquivoDMS', $aParametros);

    return $oRetornoWebService;
  }
}