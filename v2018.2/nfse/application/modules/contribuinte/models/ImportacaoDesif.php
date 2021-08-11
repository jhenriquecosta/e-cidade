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
 * Model responsável pelo modelo de abstração do dados da estrutura principal do DES-IF
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 * @author Roberto <roberto@dbseller.com.br>
 */
class Contribuinte_Model_ImportacaoDesif extends Contribuinte_Lib_Model_Doctrine {

  static protected $entityName = 'Contribuinte\ImportacaoDesif';
  static protected $className  = __CLASS__;

  public function persist() {

    $oEntidade = $this->getEntity();
    $this->getEm()->persist($oEntidade);
    $this->getEm()->flush();
  }

  /**
   * Retorna os totalizadores da importação para geraçao das guias
   *
   * @param integer $iCodigoImportacaoDesif
   * @param bool    $lDetalhes
   * @param null    $fAliquota
   * @return array
   */
  public static function getTotalReceitasGuia($iCodigoImportacaoDesif, $lDetalhes = FALSE, $fAliquota = NULL) {

    $aReceitaAgrupadas = array();
    $aParametros       = array(
      'importacao_desif' => $iCodigoImportacaoDesif,
      'guia' => NULL
    );

    $aReceitaAgrupadas     = NULL;
    //$aContasImportacaoGuia = Contribuinte_Model_DesifContaGuia::getByAttributes($aParametros);

    $aReceitaAgrupadas['total_receita'] = 0;
    $aReceitaAgrupadas['total_iss'] = 0;

    /**
     * Percorre as contas selecionadas que irá gerar as guias
     */
    //foreach ($aContasImportacaoGuia as $oDesifContaGuia) {

      /*$aParametros = array(
        'importacao_desif' => $iCodigoImportacaoDesif,
        'importacao_desif_conta' => $oDesifContaGuia->getImportacaoDesifConta()->getId()
      );*/

      $aParametros = array(
        'importacao_desif' => $iCodigoImportacaoDesif
      );


      /**
       * Filtro por aliquota
       */
      if (!empty($fAliquota)) {
        $aParametros['aliq_issqn'] = "{$fAliquota}";
      }

      $aDesifReceita = Contribuinte_Model_ImportacaoDesifReceita::getByAttributes($aParametros);
      $fValorTotal = 0;
      $fValorIss = 0;

      /**
       * Percore as receitas de cada importação
       */
      foreach ($aDesifReceita as $oDesifReceita) {

        $fValor     = $oDesifReceita->getEntity()->getBaseCalc();
        $fAliqIssqn = DBSeller_Helper_Number_Format::toFloat($oDesifReceita->getEntity()->getAliqIssqn());

        /**
         * Soma os totais por aliquota com detalhamento
         */
        if ($lDetalhes) {

          if (isset($aAliqIssqnAgrupadas[$fAliqIssqn])) {
            $aAliqIssqnAgrupadas[$fAliqIssqn]['total_receita'] = $aAliqIssqnAgrupadas[$fAliqIssqn]['total_receita'] + $fValor;
          } else {
            $aAliqIssqnAgrupadas[$fAliqIssqn]['total_receita'] = $fValor;
          }

          $fValorTotal = $aAliqIssqnAgrupadas[$fAliqIssqn]['total_receita'];
          $aAliqIssqnAgrupadas[$fAliqIssqn]['total_iss'] = ($fValorTotal * ($fAliqIssqn/100));

          $aReceitaAgrupadas['id_importacao_desif']         = $iCodigoImportacaoDesif;
          $aReceitaAgrupadas['id_importacao_desif_conta'][] = $oDesifReceita->getEntity()->getImportacaoDesifConta()->getId();
          $aReceitaAgrupadas['data_importacao']             = $oDesifReceita->getEntity()->getImportacaoDesif()->getDataImportacao();
          $aReceitaAgrupadas['aliquotas_issqn']             = $aAliqIssqnAgrupadas;
        } else {

          $fValorTotal = $fValorTotal + $fValor;
          $fValorIss   = $fValorIss + ($fValor * ($fAliqIssqn/100));
        } 
      }

      /**
       * Retorna os valores totais das receitas e iss totalizadas
       */
      if (!$lDetalhes) {

        $aReceitaAgrupadas['total_receita'] = $aReceitaAgrupadas['total_receita'] + $fValorTotal ;
        $aReceitaAgrupadas['total_iss']     = $aReceitaAgrupadas['total_iss']     + $fValorIss;
      }
    //}

    return $aReceitaAgrupadas;
  }

  /**
   * Retorna as receitas para a geração de guias desif
   *
   * @param Contribuinte_Model_Contribuinte $oContribuinte
   * @param integer                         $iIdImportacaoDesif
   * @param null                            $fAliquota
   * @return array
   */
  public static function getTotalReceitaGuiaDesif(Contribuinte_Model_Contribuinte $oContribuinte,
                                                  $iIdImportacaoDesif,
                                                  $fAliquota = NULL) {

    $aDadosEmitirGuia = array();
    $aParametros      = array(
      'id' => $iIdImportacaoDesif,
      'contribuinte' => $oContribuinte->getContribuintes()
    );

    $aImportacaoDesif = Contribuinte_Model_ImportacaoDesif::getByAttributes($aParametros);

    /**
     * Verifica se retornou uma importacao desif
     */
    if (isset($aImportacaoDesif[0])) {

      $oImportacaoDesif = $aImportacaoDesif[0]->getEntity();
      $aDadosEmitirGuia = Contribuinte_Model_ImportacaoDesif::getTotalReceitasGuia($oImportacaoDesif->getId(),
                                                                                   FALSE,
                                                                                   $fAliquota);

      $aDadosEmitirGuia['ano_competencia'] = substr($oImportacaoDesif->getCompetenciaInicial(), 0, 4);
      $aDadosEmitirGuia['mes_competencia'] = substr($oImportacaoDesif->getCompetenciaInicial(), 4, 2);
    }

    return (object) $aDadosEmitirGuia;
  }

  /**
   * @param Contribuinte_Model_Contribuinte $oContribuinte
   * @param                                 $iAno
   * @param                                 $iMes
   * @param null                            $fAliquota
   * @return object
   */
  public static function getTotalReceitasCompetencia(Contribuinte_Model_Contribuinte $oContribuinte,
                                                     $iAno,
                                                     $iMes,
                                                     $fAliquota = NULL) {

    $aReceitasGuia = array();
    $aParametros   = array(
      'contribuinte'        => $oContribuinte->getContribuintes(),
      'competencia_inicial' => "{$iAno}{$iMes}"
    );

    $aImportacaoDesif = Contribuinte_Model_ImportacaoDesif::getByAttributes($aParametros);

    /**
     * Verifica se retornou uma importacao desif
     */
    if (isset($aImportacaoDesif[0])) {

      $oImportacaoDesif = $aImportacaoDesif[0]->getEntity();
      $aReceitasGuia = Contribuinte_Model_ImportacaoDesif::getTotalReceitasGuia($oImportacaoDesif->getId(),
                                                                                TRUE,
                                                                                $fAliquota);
    }

    return (object) $aReceitasGuia;
  }

  /**
   * Método que busca as importaçoes DES-IF por competencia e contribuinte
   *
   * @param  array     $aIdContribuinte
   * @param  integer   $iCompetenciaInicial
   * @param  integer   $iCompetenciaFinal
   * @throws Exception
   */
  public static function getImportacaoPorCompetencia($aIdContribuinte, 
                                                     $iCompetenciaInicial,
                                                     $iCompetenciaFinal) {

    try {

      $oEntityManager = parent::getEm();
      $oQuery         = $oEntityManager->createQueryBuilder();

      $oQuery->select('n');
      $oQuery->from('Contribuinte\ImportacaoDesif', 'n');
      $oQuery->where('n.contribuinte in(?1)');
      $oQuery->setParameters(array('1' => $aIdContribuinte));

      if (!is_null($iCompetenciaInicial)) {
        
        $oQuery->andWhere('n.competencia_inicial >= ?2');
        $oQuery->setParameter('2', $iCompetenciaInicial);
      }

      if (!is_null($iCompetenciaFinal)) {

        $oQuery->andWhere('n.competencia_final <= ?3');
        $oQuery->setParameter('3', $iCompetenciaFinal);      
      }

      $aResultado = $oQuery->getQuery()->getResult();

      return $aResultado;

    } catch(Exception $oErro) {
      throw $oErro;
    }
  }
}