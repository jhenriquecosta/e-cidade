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
 * Class Fiscal_Model_ProcedimentoAlterarRegimeNotaSimples
 * @author Davi Busanello <davi@dbseller.com.br>
 * @package Fiscal/Model
  */
class Fiscal_Model_ProcedimentoAlterarRegimeNotaSimples {

  private $oEmpresa = null;

  private $aCadastroSimplesNacional = null;

  private $aIdsContribuintes = array();

  private $aNotas = null;

  private $aCompetenciasCorrigidas = array();

  private $aNotasAlteradas = array();

  private $aNotasNaoAlteradas = array();

  /**
   * Exigibilidades que não tem incidencia de iss
   * emite_guia = false
   */
  private $ExigibilidadesSemTributacao = array(
                               Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_ESTIMATIVA,
                               Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_FIXADO,
                               Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_MEI,
                               Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_SOCIEDADE_PROFISSIONAIS,
                               Contribuinte_Model_ContribuinteAbstract::EXIGIBILIDADE_ISENTO,
                               Contribuinte_Model_ContribuinteAbstract::EXIGIBILIDADE_IMUNE
                               );

  public function __construct(Contribuinte_Model_Contribuinte $oEmpresa) {

    $this->oEmpresa = $oEmpresa;

  }

  /**
   * Obtem o cadastro do simples nacional no e-Cidade
   * e define na propriedade de classe
   */
  private function obtemCadastroSimplesNacional()
  {
    /* Obtem cadastro do simples nacional */
      $aCadastroSimplesNacional = $this->oEmpresa->getCadastroSimplesNacional();

      if (empty($aCadastroSimplesNacional)) {
        throw new Zend_Controller_Exception('Contribuinte sem cadastro no Simples Nacional.');
      }

      $this->aCadastroSimplesNacional = $aCadastroSimplesNacional;
  }

  /**
   * Obtem todas as notas emitidas pelo contribuinte
   */
  private function obtemNotasContribuinte()
  {

    $oNotaModel = new Contribuinte_Model_Nota();
    $this->aNotas = $oNotaModel->getNotasPrestador($this->oEmpresa->getInscricaoMunicipal());

  }

  private function setIdsContribuinte() {
    $this->aIdsContribuintes = $this->oEmpresa->getContribuintes();
  }

  /**
   * Valida se a nota pertence ao simples nacional
   * @param  Contribuinte_Model_Nota $oNota Nota
   * @return object|bool                        Cadastro do simples ou FALSE
   */
  private function verificaNotaCadastroSimples(Contribuinte_Model_Nota $oNota)
  {

    $oDataNota = new Zend_Date($oNota->getNotaData()->format('Y-m-d'));

    /* Percorre o cadastro do Simples */
    foreach ($this->aCadastroSimplesNacional as $oCadastroSimplesNacional) {

      $oDataInicio = new Zend_Date($oCadastroSimplesNacional->data_inicial);
      $oDataFim   = new Zend_Date(($oCadastroSimplesNacional->data_baixa ?$oCadastroSimplesNacional->data_baixa : date('Y-m-d')));

      if (($oDataNota->getTimestamp() >= $oDataInicio->getTimestamp()) && ($oDataNota->getTimestamp() <= $oDataFim->getTimestamp())) {
        return $oCadastroSimplesNacional;
        break;
      }
    }

    return FALSE;
  }

  /**
   * Valida se a nota do simples está correta
   * @param  Contribuinte_Model_Nota $oNota                    Nota
   * @param  object                              $oCadastroSimples Cadastro do Simples Nacional do Periodo
   * @return   boolean
   */
  private function validaNotaSimples(Contribuinte_Model_Nota $oNota, $oCadastroSimples)
  {

    if ($oNota->getS_dec_simples_nacional() == 1 && $oNota->getP_categoria_simples_nacional() == $oCadastroSimples->categoria) {
      return TRUE;
    }

    return false;
  }

  /**
   * Corrige a nota para o simples
   * @param  Contribuinte_Model_Nota $oNota                    Nota
   * @param  object                              $oCadastroSimples Cadastro do Simples Nacional do Periodo
   * @return   boolean
   */
  private function corrigeNotaSimpes(Contribuinte_Model_Nota $oNota, $oCadastroSimples)
  {

    try {

      $aParams = array('sets'  => array('s_dec_simples_nacional' => 1, 'p_categoria_simples_nacional' => $oCadastroSimples->categoria),
                           'where' => array('id' => $oNota->getId())
      );

      if (Contribuinte_Model_Nota::update($aParams['sets'], $aParams['where'])) {
        $this->aNotasAlteradas[] = $oNota->getId();
        return true;
      }

    } catch (Exception $oError) {
      $this->aNotasNaoAlteradas[] = $oNota->getNotaNumero();
      return true;
    }
  }

  private function corrigeNotaNormal(Contribuinte_Model_Nota $oNota)
  {

    try {

      $aParams = array('sets'  => array('s_dec_simples_nacional' => 2, 'p_categoria_simples_nacional' => (int) 0),
                           'where' => array('id' => $oNota->getId())
      );


      if (in_array((int) $oNota->getS_dados_exigibilidadeiss(), $this->ExigibilidadesSemTributacao)
          || ((int) $oNota->getS_dados_iss_retido() == 2)
          || (int) $oNota->getNatureza_operacao() == 2) {
        $aParams['sets']['emite_guia'] = "'f'";
      } else {
        $aParams['sets']['emite_guia'] = "'t'";
      }

      if (Contribuinte_Model_Nota::update($aParams['sets'], $aParams['where'])) {
        $this->aNotasAlteradas[] = $oNota->getId();
        return true;
      }

    } catch (Exception $oError) {
      error_log('AlterarRegimeNormal: '. $oError->getMessage(), 0);
      $this->aNotasNaoAlteradas[] = $oNota->getNotaNumero();
      return true;
    }


  }

  /**
   * Obtem todas as competencias corrigidas
   * @return array Array de competencias
   */
  private function obtemCompetenciasCorrigidas()
  {

    if (empty($this->aNotasAlteradas)) {
      return array();
    }
    $oEm = Zend_Registry::get('em');
    $query = $oEm->createQueryBuilder();
    $query->select(array('e.mes_comp', 'e.ano_comp'));
    $query->from('Contribuinte\Nota', 'e');
    $query->where("e.id IN(:ids)");
    $query->setParameter('ids', array_values($this->aNotasAlteradas));
    $query->groupBy('e.ano_comp');
    $query->addGroupBy('e.mes_comp');
    $query->orderBy('e.ano_comp');
    $query->addOrderBy('e.mes_comp');
    $aCompetenciasCorrigidas = $query->getQuery()->getArrayResult();

    return $aCompetenciasCorrigidas;

  }

  public function processaAlteracaoRegime()
  {
    $oDoctrine               = Zend_Registry::get('em');
    $oRetornoProcessamento = new stdClass();

    try {
      $oDoctrine->getConnection()->beginTransaction();

      $this->obtemCadastroSimplesNacional();
      $this->setIdsContribuinte();
      $this->obtemNotasContribuinte();

      if (count($this->aNotas) <= 0) {
        throw new Zend_Exception('Contribuinte sem notas emitidas pelo sistema.');
      }

      foreach ($this->aNotas as $oNota) {

        /* Verifica se a nota pertence a algum cadastro do simples nacional */
        $oCadastroSimples = $this->verificaNotaCadastroSimples($oNota);

        if (is_object($oCadastroSimples)) {
          /* Se for do simples verifica se a nota precisa ser corrigida */
          if (!$this->validaNotaSimples($oNota, $oCadastroSimples)) {
            $this->corrigeNotaSimpes($oNota, $oCadastroSimples);

          }

          continue;
        } else {

          if ($oNota->getS_dec_simples_nacional() == 1) {
            /* Precisa corrigir a nota */
            $bCorrigiuNotaNormal = $this->corrigeNotaNormal($oNota);
          }

          continue;
        }
      }

      $oRetornoProcessamento->notas_corrigidas = $this->aNotasAlteradas;
      $oRetornoProcessamento->inconsistencias   = $this->aNotasNaoAlteradas;
      $oRetornoProcessamento->competencias     = $this->obtemCompetenciasCorrigidas();
      $oRetornoProcessamento->mensagem         = (empty($this->aNotasAlteradas) ? 'Não hà notas para corrigir!' : 'Correção efetuada com sucesso!');
      $oRetornoProcessamento->sucesso              = TRUE;

      $oDoctrine->getConnection()->commit();

    } catch (Zend_Exception $oError) {

      $oRetornoProcessamento->notas_corrigidas = $this->aNotasAlteradas;
      $oRetornoProcessamento->inconsistencias   = $this->aNotasNaoAlteradas;
      $oRetornoProcessamento->competencias     = $this->obtemCompetenciasCorrigidas();
      $oRetornoProcessamento->mensagem         = (empty($this->aNotasAlteradas) ? 'Não hà notas corrigidas!' : 'Correção efetuada com sucesso!');
      $oRetornoProcessamento->sucesso              = TRUE;

      $oDoctrine->getConnection()->commit();

    } catch (Exception $oError) {

      $oRetornoProcessamento->notas_corrigidas = array();
      $oRetornoProcessamento->inconsistencias   = array();
      $oRetornoProcessamento->competencias     = array();
      $oRetornoProcessamento->mensagem         = 'Não foi possivel efetuar a correção, contate o suporte. </br>';
      error_log('AlterarRegimeSimples: '. $oError->getMessage(), 0);
      $oRetornoProcessamento->sucesso              = FALSE;

      $oDoctrine->getConnection()->rollback();

    }

    return $oRetornoProcessamento;
  }
}