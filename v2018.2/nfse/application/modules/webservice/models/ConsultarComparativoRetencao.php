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
 * Model responsavel pela consulta de comparativo de retenções
 * @author Lucas Dumer <lucas.dumer@dbseller.com.br>
 */
class WebService_Model_ConsultarComparativoRetencao extends WebService_Lib_Models_Consultar implements WebService_Lib_Interfaces_Consultar {

  /**
   * Construtor da class
   * @param object
   */
  public function __construct($oModeloImportacao){
    parent::__construct($oModeloImportacao, 'ComparativoRetencao');
  }

  /**
   * Realiza a consulta de comparativo de retenções
   * @param  object $oXml
   * @return array
   */
  public function getByObject($oXml){

    $aComparativoRetencao = $this->getComparativoRetencao($oXml->iInscricaoMunicipal, $oXml->sCompetenciaMes, $oXml->sCompetenciaAno);

    return $aComparativoRetencao;
  }

  /**
   * Consulta comparativo de retenções
   * @param  integer $iInscricaoMunicipal
   * @param  string  $sCompetenciaMes
   * @param  string  $sCompetenciaAno
   * @return array
   */
  private function getComparativoRetencao($iInscricaoMunicipal = null, $sCompetenciaMes = null, $sCompetenciaAno = null){

    $oEntityManager = Zend_Registry::get('em');

    $sSql  = "select nota_numero,            ";
    $sSql .= "       prestador_cnpj,         ";
    $sSql .= "       prestador_razao_social, ";
    $sSql .= "       prestador_data,         ";
    $sSql .= "       prestador_aliquota,     ";
    $sSql .= "       prestador_valor_base,   ";
    $sSql .= "       prestador_categoria,    ";
    $sSql .= "       tomador_cnpj,           ";
    $sSql .= "       tomador_razao_social,   ";
    $sSql .= "       tomador_data,           ";
    $sSql .= "       tomador_aliquota,       ";
    $sSql .= "       tomador_valor_base      ";
    $sSql .= "  from (                       ";

    // select para caso que exista nota e DMS
    $sSql .= "        select notas.nota                         as nota_numero,            ";
    $sSql .= "               notas.p_cnpjcpf                    as prestador_cnpj,         ";
    $sSql .= "               notas.p_razao_social               as prestador_razao_social, ";
    $sSql .= "               notas.dt_nota                      as prestador_data,         ";
    $sSql .= "               notas.s_vl_aliquota                as prestador_aliquota,     ";
    $sSql .= "               notas.s_vl_bc                      as prestador_valor_base,   ";
    $sSql .= "               notas.p_categoria_simples_nacional as prestador_categoria,    ";
    $sSql .= "               dms_nota.t_cnpjcpf                 as tomador_cnpj,           ";
    $sSql .= "               dms_nota.t_razao_social            as tomador_razao_social,   ";
    $sSql .= "               dms_nota.dt_nota                   as tomador_data,           ";
    $sSql .= "               dms_nota.s_vl_aliquota             as tomador_aliquota,       ";
    $sSql .= "               dms_nota.s_vl_base_calculo         as tomador_valor_base      ";
    $sSql .= "          from notas                                                         ";
    $sSql .= "               inner join usuarios_contribuintes                                on usuarios_contribuintes.id       = notas.id_contribuinte                 ";
    $sSql .= "               inner join usuarios                                              on usuarios.id                     = usuarios_contribuintes.id_usuario     ";
    $sSql .= "               inner join dms_nota                                              on dms_nota.nota                   = notas.nota                            ";
    $sSql .= "                                                                               and dms_nota.p_cnpjcpf              = notas.p_cnpjcpf                       ";
    $sSql .= "                                                                               and dms_nota.t_cnpjcpf              = notas.t_cnpjcpf                       ";
    $sSql .= "                                                                               and (   dms_nota.dt_nota           != notas.dt_nota                         ";
    $sSql .= "                                                                                    or dms_nota.s_vl_aliquota     != notas.s_vl_aliquota                   ";
    $sSql .= "                                                                                    or dms_nota.s_vl_base_calculo != notas.s_vl_bc)                        ";
    $sSql .= "               inner join usuarios_contribuintes as usuarios_contribuintes_dms  on usuarios_contribuintes_dms.id   = dms_nota.id_contribuinte              ";
    $sSql .= "               inner join usuarios               as usuarios_dms                on usuarios_dms.id                 = usuarios_contribuintes_dms.id_usuario ";
    $sSql .= "         where notas.s_dados_iss_retido = 2                                   ";
    $sSql .= "           and notas.natureza_operacao = 1                                    ";
    $sSql .= "           and notas.cancelada = false                                        ";
    $sSql .= "           and notas.t_cnpjcpf not in (select cnpj from parametrosprefeitura) ";

    if(!empty($iInscricaoMunicipal)){
      $sSql .= "         and (   usuarios_contribuintes.im     = {$iInscricaoMunicipal}   ";
      $sSql .= "              or usuarios_contribuintes_dms.im = {$iInscricaoMunicipal} ) ";
    }

    if(!empty($sCompetenciaMes)){
      $sSql .= "         and notas.mes_comp = {$sCompetenciaMes} ";
    }

    if(!empty($sCompetenciaAno)){
      $sSql .= "         and notas.ano_comp = {$sCompetenciaAno} ";
    }

    $sSql .= "         union ";

    // select para caso que exista somente nota
    $sSql .= "        select notas.nota                         as nota_numero,            ";
    $sSql .= "               notas.p_cnpjcpf                    as prestador_cnpj,         ";
    $sSql .= "               notas.p_razao_social               as prestador_razao_social, ";
    $sSql .= "               notas.dt_nota                      as prestador_data,         ";
    $sSql .= "               notas.s_vl_aliquota                as prestador_aliquota,     ";
    $sSql .= "               notas.s_vl_bc                      as prestador_valor_base,   ";
    $sSql .= "               notas.p_categoria_simples_nacional as prestador_categoria,    ";
    $sSql .= "               notas.t_cnpjcpf                    as tomador_cnpj,           ";
    $sSql .= "               notas.t_razao_social               as tomador_razao_social,   ";
    $sSql .= "               null                               as tomador_data,           ";
    $sSql .= "               null                               as tomador_aliquota,       ";
    $sSql .= "               null                               as tomador_valor_base      ";
    $sSql .= "          from notas                                                         ";
    $sSql .= "               inner join usuarios_contribuintes                                on usuarios_contribuintes.id           = notas.id_contribuinte             ";
    $sSql .= "               inner join usuarios                                              on usuarios.id                         = usuarios_contribuintes.id_usuario ";
    $sSql .= "               left  join dms_nota                                              on dms_nota.nota                       = notas.nota                        ";
    $sSql .= "                                                                               and dms_nota.p_cnpjcpf                  = notas.p_cnpjcpf                   ";
    $sSql .= "               left  join usuarios_contribuintes as usuarios_contribuintes_dms  on usuarios_contribuintes_dms.cnpj_cpf = notas.t_cnpjcpf                   ";
    $sSql .= "         where notas.s_dados_iss_retido = 2                                   ";
    $sSql .= "           and notas.natureza_operacao = 1                                    ";
    $sSql .= "           and notas.cancelada = false                                        ";
    $sSql .= "           and dms_nota.nota is null                                          ";
    $sSql .= "           and dms_nota.p_cnpjcpf is null                                     ";
    $sSql .= "           and notas.t_cnpjcpf not in (select cnpj from parametrosprefeitura) ";

    if(!empty($iInscricaoMunicipal)){
      $sSql .= "         and (   usuarios_contribuintes.im = {$iInscricaoMunicipal}       ";
      $sSql .= "              or usuarios_contribuintes_dms.im = {$iInscricaoMunicipal} ) ";
    }

    if(!empty($sCompetenciaMes)){
      $sSql .= "         and notas.mes_comp = {$sCompetenciaMes} ";
    }

    if(!empty($sCompetenciaAno)){
      $sSql .= "         and notas.ano_comp = {$sCompetenciaAno} ";
    }

    $sSql .= "         union ";

    // select para caso que exista somente DMS
    $sSql .= "        select dms_nota.nota              as nota_numero,            ";
    $sSql .= "               dms_nota.p_cnpjcpf         as prestador_cnpj,         ";
    $sSql .= "               dms_nota.p_razao_social    as prestador_razao_social, ";
    $sSql .= "               null                       as prestador_data,         ";
    $sSql .= "               null                       as prestador_aliquota,     ";
    $sSql .= "               null                       as prestador_valor_base,   ";
    $sSql .= "               null                       as prestador_categoria,    ";
    $sSql .= "               dms_nota.t_cnpjcpf         as tomador_cnpj,           ";
    $sSql .= "               dms_nota.t_razao_social    as tomador_razao_social,   ";
    $sSql .= "               dms_nota.dt_nota           as tomador_data,           ";
    $sSql .= "               dms_nota.s_vl_aliquota     as tomador_aliquota,       ";
    $sSql .= "               dms_nota.s_vl_base_calculo as tomador_valor_base      ";
    $sSql .= "          from dms_nota                                              ";
    $sSql .= "               inner join usuarios_contribuintes                                 on usuarios_contribuintes.id            = dms_nota.id_contribuinte          ";
    $sSql .= "               inner join usuarios                                               on usuarios.id                          = usuarios_contribuintes.id_usuario ";
    $sSql .= "               inner join usuarios_contribuintes as usuarios_contribuintes_nota  on usuarios_contribuintes_nota.cnpj_cpf = dms_nota.p_cnpjcpf                ";
    $sSql .= "               left  join notas                                                  on notas.nota                           = dms_nota.nota                     ";
    $sSql .= "                                                                                and notas.p_cnpjcpf                      = dms_nota.p_cnpjcpf                ";
    $sSql .= "         where dms_nota.s_dados_iss_retido = true                                ";
    $sSql .= "           and dms_nota.natureza_operacao = 1                                    ";
    $sSql .= "           and (   (notas.nota is null and notas.p_cnpjcpf is null)              ";
    $sSql .= "                or (notas.nota is not null and notas.cancelada = true))          ";
    $sSql .= "           and dms_nota.p_cnpjcpf not in (select cnpj from parametrosprefeitura) ";

    if(!empty($iInscricaoMunicipal)){
      $sSql .= "         and (   usuarios_contribuintes.im      = {$iInscricaoMunicipal}   ";
      $sSql .= "              or usuarios_contribuintes_nota.im = {$iInscricaoMunicipal} ) ";
    }

    if(!empty($sCompetenciaMes)){
      $sSql .= "         and extract(month from dms_nota.dt_nota) = {$sCompetenciaMes} ";
    }

    if(!empty($sCompetenciaAno)){
      $sSql .= "         and extract(year from dms_nota.dt_nota) = {$sCompetenciaAno} ";
    }

    $sSql .= "       ) as comparativo_retencao ";
    $sSql .= "       where prestador_categoria <> " . Contribuinte_Model_ContribuinteAbstract::OPTANTE_SIMPLES_TIPO_MEI;
    $sSql .= "       order by prestador_razao_social asc, nota_numero desc ";

    $oConnection = $oEntityManager->getConnection();
    $oStatement  = $oConnection->query($sSql);

    return $oStatement->fetchAll();
  }
}