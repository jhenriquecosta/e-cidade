<?php
/**
  *     E-cidade Software Publico para Gestao Municipal
  *  Copyright (C) 2016  DBSeller Servicos de Informatica
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
 * Model responsavel pela consulta de competencias encerradas
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
class WebService_Model_ConsultarPrestacaoContas extends WebService_Lib_Models_Consultar implements WebService_Lib_Interfaces_Consultar {

  /**
   * Construtor da class
   * @param object
   */
  public function __construct($oModeloImportacao) {
    parent::__construct($oModeloImportacao, 'PrestacaoContas');
  }

  /**
   * Realiza a consulta de comparativo de retenções
   * @param  object $oXml
   * @return array
   */
  public function getByObject($oXml){

    $aComparativoRetencao = $this->getPrestacaoContas($oXml->sDataInicio, $oXml->sDataFim, $oXml->aCnpj);

    return $aComparativoRetencao;
  }

  /**
   * Consulta competencias encerradas
   * @param  string  $sCompetenciaMes
   * @param  string  $sCompetenciaAno
   * @param  integer $iSituacao
   * @return array
   */
  private function getPrestacaoContas($sDataInicio = null, $sDataFim = null, $aCnpj = null ){

    $oEntityManager = Zend_Registry::get('em');

    $sWhereAnd = " where ";

    $sSql .= " select municipios.uf,                                                                      ";
    $sSql .= "        nota.t_cnpjcpf as tomador_cnpj,                                                     ";
    $sSql .= "        case                                                                                ";
    $sSql .= "          when length(nota.p_cnpjcpf) = 14 then                                            ";
    $sSql .= "            'J'                                                                             ";
    $sSql .= "          else                                                                              ";
    $sSql .= "            'F'                                                                             ";
    $sSql .= "        end as tipo_pessoa,                                                                 ";
    $sSql .= "        nota.p_cnpjcpf as prestador_cnpj,                                                   ";
    $sSql .= "        'Serviço' as natureza_operacao,                                                     ";
    $sSql .= "        nota.dt_nota as data_nota,                                                          ";
    $sSql .= "        nota.nota as numero_nota,                                                           ";
    $sSql .= "        nota_substituida.nota as numero_nota_substituida,                                   ";
    $sSql .= "        nota.s_vl_bc as valor_nota                                                          ";
    $sSql .= "   from notas nota                                                                          ";
    $sSql .= "        left  join notas nota_substituida on nota.id_nota_substituida = nota_substituida.id ";
    $sSql .= "        inner join municipios on nota.s_dados_municipio_incidencia::varchar = municipios.cod_ibge ";

    if ( !empty($sDataInicio) ) {

      $sSql     .= " $sWhereAnd nota.dt_nota >= '$sDataInicio' ";
      $sWhereAnd = " and ";
    }

    if ( !empty($sDataFim) ) {

      $sSql     .= " $sWhereAnd nota.dt_nota <= '$sDataFim' ";
      $sWhereAnd = " and ";
    }

    if ( !empty($aCnpj) ) {

      $sCnpj = implode("','", $aCnpj);
      $sSql .= " $sWhereAnd nota.t_cnpjcpf in ('$sCnpj') ";
    }

    $sSql .= " {$sWhereAnd} nota.cancelada is false ";

    $sSql .= "order by nota.t_cnpjcpf desc,";
    $sSql .= "         nota.dt_nota desc";


    $oConnection = $oEntityManager->getConnection();
    $oStatement  = $oConnection->query($sSql);

    return $oStatement->fetchAll();
  }
}
?>
