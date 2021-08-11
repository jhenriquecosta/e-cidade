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
class WebService_Model_ConsultarCompetenciasEncerradas extends WebService_Lib_Models_Consultar implements WebService_Lib_Interfaces_Consultar {

  /**
   * Construtor da class
   * @param object
   */
  public function __construct($oModeloImportacao){
    parent::__construct($oModeloImportacao, 'CompetenciasEncerradas');
  }

  /**
   * Realiza a consulta de comparativo de retenções
   * @param  object $oXml
   * @return array
   */
  public function getByObject($oXml){

    $aComparativoRetencao = $this->getCompetenciasEncerradas($oXml->sCompetenciaMes, $oXml->sCompetenciaAno, $oXml->iSituacao);

    return $aComparativoRetencao;
  }

  /**
   * Consulta competencias encerradas
   * @param  string  $sCompetenciaMes
   * @param  string  $sCompetenciaAno
   * @param  integer $iSituacao
   * @return array
   */
  private function getCompetenciasEncerradas($sCompetenciaMes = null, $sCompetenciaAno = null, $iSituacao = null ){

    $oEntityManager = Zend_Registry::get('em');

    if ( !empty($iSituacao) ) {

      $aSituacoes = array( Contribuinte_Model_Competencia::SITUACAO_ENCERRANDO,
                           Contribuinte_Model_Competencia::SITUACAO_ENCERRANDO_SEM_IMPOSTO,
                           Contribuinte_Model_Competencia::SITUACAO_ENCERRANDO_SEM_MOVIMENTO );

      if ( !in_array($iSituacao, $aSituacoes) ) {
        throw new Exception("Situação de competencia inválida!");
      }
    }

    $sWhereAnd = " where ";

    $sSql  = " select im as inscricao_municipal, ";
    $sSql .= "        cnpj_cpf, ";
    $sSql .= "        competencias.situacao, ";
    $sSql .= "        sum(valor_corrigido) as valor, ";
    $sSql .= "        competencias.mes, ";
    $sSql .= "        competencias.ano ";
    $sSql .= "   from competencias ";
    $sSql .= "        inner join guias on id_competencia = competencias.id ";
    $sSql .= "        inner join usuarios_contribuintes on usuarios_contribuintes.id = competencias.id_contribuinte ";

    if ( !empty($iSituacao) ) {

      $sSql     .= " $sWhereAnd competencias.situacao = $iSituacao ";
      $sWhereAnd = " and ";
    }

    if ( !empty($sCompetenciaAno) ) {

      $sSql     .= " $sWhereAnd competencias.ano = $sCompetenciaAno ";
      $sWhereAnd = " and ";
    }

    if ( !empty($sCompetenciaMes) ) {
      $sSql .= " $sWhereAnd competencias.mes = $sCompetenciaMes ";
    }

    $sSql .= "group by im,";
    $sSql .= "         cnpj_cpf, ";
    $sSql .= "         competencias.situacao, ";
    $sSql .= "         competencias.mes, ";
    $sSql .= "         competencias.ano ";
    $sSql .= "order by competencias.ano desc,";
    $sSql .= "         competencias.mes desc";


    $oConnection = $oEntityManager->getConnection();
    $oStatement  = $oConnection->query($sSql);

    return $oStatement->fetchAll();
  }
}
?>