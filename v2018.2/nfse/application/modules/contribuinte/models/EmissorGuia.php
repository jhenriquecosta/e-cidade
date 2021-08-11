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
 * Modelo para verificar se deve emitir a guia
 *
 * @author Gilton Guma <gilton@dbseller.com.br>
 */

class Contribuinte_Model_EmissorGuia {

  /**
   * Verifica se deve emitir a guia considerando:
   * 1 - as características do contribuinte no alvará
   * 2 - tributação dentro ou fora do municipio
   *
   *
   * @param stdClass $oParametro
   *   $oParametro->inscricao_municipal
   *   $oParametro->data
   * @throws Exception
   * @return boolean
   *
   * @tutorial: Abaixo constam as regras para emissão de guia
   *
   * Regime(4)/Exigibilidade(5) |Exigível(23)|Não Incide(24)|Isento(25)|Export.(26)|Imune(27)|Susp.Judic(28)|Susp.Adm(29)
   * ------------------------------------------------------------------------------------------------------------------
   * (--)Optante Simples        |Não         |Não         |Não       |Não        |Não      |Não           |Não
   * (14)Normal                 |Sim         |Não         |Não       |sim        |Não      |Não           |Não
   * (15)Cooperativa            |Sim         |Não         |Não       |sim        |Não      |Não           |Não
   * (16)EPP                    |Sim         |Não         |Não       |sim        |Não      |Não           |Não
   * (17)Estimativa             |Sim         |Não         |Não       |sim        |Não      |Não           |Não
   * (18)Fixado                 |Não         |Não         |Não       |Não        |Não      |Não           |Não
   * (19)ME municipal           |Sim         |Não         |Não       |sim        |Não      |Não           |Não
   * (20)MEI                    |Não         |Não         |Não       |Não        |Não      |Não           |Não
   * (21)ME                     |Sim         |Não         |Não       |sim        |Não      |Não           |Não
   * (22)Sociedade profissional |Não         |Não         |Não       |Não        |Não      |Não           |Não
   */
  public static function checarEmissaoGuia($oParametro = NULL) {

    $oValidaData = new Zend_Validate_Date();

    if (!is_object($oParametro)) {
      throw new Exception('O parâmetro informado deve ser um objeto.');
    } else if (!isset($oParametro->data) || !isset($oParametro->inscricao_municipal))  {
      throw new Exception('Verifique os parâmetros informados.');
    } else if (!$oValidaData->isValid($oParametro->data)) {
      throw new Exception('Parâmetro "data" inválido.');
    }

    // Busca os dados do contribuinte da sessão
    $oContribuinte = Contribuinte_Model_Contribuinte::getByInscricaoMunicipal($oParametro->inscricao_municipal);

    if (!is_object($oContribuinte)) {
      throw new Exception('Nenhum contribuinte foi encontrado.');
    }

    // Optante pelo simples no período pesquisado, não emite guia
    $oDataSimples = new DateTime(DBSeller_Helper_Date_Date::invertDate($oParametro->data));

    if ($oContribuinte->isOptanteSimples($oDataSimples)) {
      return FALSE;
    }

    // Verifica se deve emitir a guia conforme as regras de emissão
    $iRegimeTributario = $oContribuinte->getRegimeTributario();
    $iExigibilidade    = $oContribuinte->getExigibilidade();

    switch ("{$iRegimeTributario}-{$iExigibilidade}") {

      case '14-23' :
      case '14-26' :
      case '15-23' :
      case '15-26' :
      case '16-23' :
      case '16-26' :
      case '17-23' :
      case '17-26' :
      case '19-23' :
      case '19-26' :
      case '21-23' :
      case '21-26' :
      case '20-23' :
        return TRUE;
        break;

      default:
          return FALSE;

    }

    return FALSE;
  }
}