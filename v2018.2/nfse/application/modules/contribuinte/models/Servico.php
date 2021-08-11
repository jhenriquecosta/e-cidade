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
 * Classe responsável pela manipuação de serviços/atividades
 *
 * @package Contribuinte/Model
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */

class Contribuinte_Model_Servico extends WebService_Model_Ecidade {

  /**
   * Busca as atividades por inscricao municipal
   *
   * @param integer $iInscricaoMunicipal
   * @param bool    $lLerDaSessao
   *
   * @return array
   * @throws Exception
   */
  public static function getByIm($iInscricaoMunicipal, $lLerDaSessao = TRUE) {

    try {

      // Sessão
      $oSessaoServicosContribuinte = new Zend_Session_Namespace('webservice_contribuinte_servicos');

      // Retorna os serviços do contribuinte na sessão, caso exista
      if ($iInscricaoMunicipal && isset($oSessaoServicosContribuinte->lista[$iInscricaoMunicipal]) && $lLerDaSessao) {
        return $oSessaoServicosContribuinte->lista[$iInscricaoMunicipal];
      }

      $aCampos = array(
        'inscricao',
        'cod_atividade',
        'atividade',
        'deducao',
        'dt_inicio',
        'dt_fim',
        'situacao',
        'estrut_cnae',
        'desc_cnae',
        'cod_item_servico',
        'desc_item_servico',
        'aliq',
        'tributacao_municipio',
        'tributacao_fixada',
        'exercicio',
        'tributacao_nao_incide'
      );

      $aRetorno   = array();
      $aFiltro    = array('inscricao' => $iInscricaoMunicipal);
      $aResultado = parent::consultar('getAtividadesEmpresa', array($aFiltro, $aCampos));

      if (is_array($aResultado)) {

        foreach ($aResultado as $uResultado) {
          $aRetorno[] = new self($uResultado);
        }
      }

      // Salva na sessão para evitar consultas no web service
      if (count($aRetorno) > 0) {
        $oSessaoServicosContribuinte->lista[$iInscricaoMunicipal] = $aRetorno;
      }

      return $aRetorno;
    } catch (Exception $e) {
      throw $e;
    }
  }

  /**
   * Busca a atividade pelo codigo
   *
   * @param integer $iCodigoAtividade
   * @param bool    $lLerDaSessao
   * @return Contribuinte_Model_Servico[]
   */
  public static function getByCodServico($iCodigoAtividade, $lLerDaSessao = TRUE) {

    // Sessão
    $oSessaoServico = new Zend_Session_Namespace('webservice_servicos');

    // Retorna os serviços do contribuinte na sessão, caso exista
    if ($iCodigoAtividade && isset($oSessaoServico->codigo_atividade[$iCodigoAtividade]) && $lLerDaSessao) {
      return $oSessaoServico->codigo_atividade[$iCodigoAtividade];
    }

    $aCampos    = array(
      'cod_atividade',
      'atividade',
      'deducao',
      'estrut_cnae',
      'desc_cnae',
      'cod_item_servico',
      'desc_item_servico',
      'aliq',
      'tributacao_municipio',
      'tributacao_nao_incide',
      'exercicio'
    );
    $aRetorno   = array();
    $aFiltro    = array('atividade' => $iCodigoAtividade);
    $aResultado = parent::consultar('getDadosEmissaoNF', array($aFiltro, $aCampos));

    if (is_array($aResultado)) {

      foreach ($aResultado as $uResultado) {
        $aRetorno[] = new self($uResultado);
      }
    }

    // Salva na sessão para evitar consultas no web service
    if (count($aRetorno) > 0) {
      $oSessaoServico->codigo_atividade[$iCodigoAtividade] = $aRetorno;
    }

    return $aRetorno;
  }

  /**
   * Busca a lista de serviços
   *
   * @param bool $lLerDaSessao
   * @return Contribuinte_Model_Servico[]
   */
  public static function getAll($lLerDaSessao = TRUE) {

    // Sessão
    $oSessaoServicos = new Zend_Session_Namespace('webservice_servicos');

    // Retorna os serviços do contribuinte na sessão, caso exista
    if (isset($oSessaoServicos->lista) && $lLerDaSessao) {
      return $oSessaoServicos->lista;
    }

    $aCampos    = array(
      'cod_atividade',
      'atividade',
      'deducao',
      'estrut_cnae',
      'desc_cnae',
      'aliq',
      'estrutural'
    );
    $aRetorno   = array();
    $aFiltro    = array();
    $aResultado = parent::consultar('getServicos', array($aFiltro, $aCampos));

    if (is_array($aResultado)) {

      foreach ($aResultado as $uResultado) {
        $aRetorno[] = new self($uResultado);
      }
    }

    // Salva na sessão para evitar consultas no web service
    $oSessaoServicos->lista = $aRetorno;

    return $aRetorno;
  }

  /**
   * Verifica se é um serviço válido para o contribuinte através do código de atividade
   *
   * @param integer $iInscricaoMunicipal
   * @param integer $iCodigoItemServico
   * @param bool    $lLerDaSessao
   * @param integer $iCodigoCnae
   * @return Contribuinte_Model_Servico|null
   */
  public static function getServicoPorAtividade($iInscricaoMunicipal, $iCodigoItemServico, $lLerDaSessao = TRUE, $iCodigoAtividade = NULL, $iCodigoCnae = NULL) {

    $oServico            = NULL;
    $oServicoSelecionado = NULL;
    $aListaServicos      = self::getByIm($iInscricaoMunicipal, $lLerDaSessao);

    if (empty($aListaServicos)) {
      return NULL;
    }

    foreach ($aListaServicos as $oServico) {

      if ($oServico->attr('cod_item_servico') == $iCodigoItemServico) {

        if (is_null($iCodigoCnae) && is_null($iCodigoAtividade)) {

          $oServicoSelecionado = $oServico;
          break;
        }

        if (!is_null($iCodigoCnae) && substr($oServico->attr('estrut_cnae'), 1)  == $iCodigoCnae) {

          $oServicoSelecionado = $oServico;
          break;
        }

        if (!is_null($iCodigoAtividade) && substr('cod_atividade')  == $iCodigoAtividade) {

          $oServicoSelecionado = $oServico;
          break;
        }

      }
    }
    return $oServicoSelecionado;
  }

  /**
   * Retorna o serviço pelo código CNAE
   *
   * @param string $sCnae
   * @param bool   $lLerDaSessao
   * @return Contribuinte_Model_Servico|null
   */
  public static function getServicoPorCnae($sCnae, $lLerDaSessao = TRUE) {

    $oServico       = NULL;
    $aListaServicos = self::getAll($lLerDaSessao);

    foreach ($aListaServicos as $oServico) {

      if ($oServico->attr('estrut_cnae') == $sCnae) {
        break;
      }
    }

    return $oServico;
  }

  /**
   * Busca a atividade pelo CNAE
   *
   * @param integer $iCnae
   * @return Contribuinte_Model_Servico[]
   */
  public static function getByCnae($iCnae) {

    // Sessão
    $oSessaoServico = new Zend_Session_Namespace('webservice_servicos');

    // Retorna os serviços do contribuinte na sessão, caso exista
    // if ($iCodigoAtividade && isset($oSessaoServico->codigo_atividade[$iCodigoAtividade]) && $lLerDaSessao) {
    //   return $oSessaoServico->codigo_atividade[$iCodigoAtividade];
    // }

    $aCampos    = array(
      'cod_atividade',
      'atividade',
      'deducao',
      'estrut_cnae',
      'desc_cnae',
      'cod_item_servico',
      'desc_item_servico',
      'aliq',
      'tributacao_municipio',
      'tributacao_nao_incide'
    );
    $aRetorno   = array();
    $aFiltro    = array('estrut_cnae' => $iCnae);
    $aResultado = parent::consultar('getAtividadeCnae', array($aFiltro, $aCampos));

    if (is_array($aResultado)) {

      foreach ($aResultado as $uResultado) {
        $aRetorno[] = new self($uResultado);
      }
    } else {
      $aRetorno = new self($aResultado);
    }

    // Salva na sessão para evitar consultas no web service
    // if (count($aRetorno) > 0) {
    //   $oSessaoServico->codigo_atividade[$iCodigoAtividade] = $aRetorno;
    // }

    return $aRetorno;
  }

  /**
   * Obtem a lista de serviços do exercicio
   * @param  array   $aServicos  array de serviços
   * @param  integer $iExercicio ano de exercicio
   * @return array               array de serviços
   */
  public static function getServicosByExercicio($aServicos, $iExercicio) {

    $aRetorno = array();

    if (!empty($aServicos)) {
      foreach ($aServicos as $oServico) {
        if ($oServico->attr('exercicio') == $iExercicio) {
          $aRetorno[] = $oServico;
        }

      }
    }

    return $aRetorno;

  }



}