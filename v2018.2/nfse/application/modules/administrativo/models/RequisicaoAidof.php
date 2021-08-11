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


/**
 * Classe responsável pela comunicação com o Ecidade
 * referentes à Requisições de Aidof
 *
 * @author Gilton Guma <gilton@dbseller.com.br>
 */
class Administrativo_Model_RequisicaoAidof extends WebService_Model_Ecidade {

  /**
   * Gera requisição de aidof
   *
   * @param integer $iTipoDocumento
   * @param integer $iInscricaoMunicipal
   * @param integer $iCgmGrafica
   * @param integer $iQuantidadeSolicitada
   * @return StdClass
   */
  public static function gerar($iTipoDocumento, $iInscricaoMunicipal, $iCgmGrafica, $iQuantidadeSolicitada) {

    $aValores = array(
      'tipodocumento'        => $iTipoDocumento,
      'inscricaomunicipal'   => $iInscricaoMunicipal,
      'cgmgrafica'           => $iCgmGrafica,
      'quantidadesolicitada' => $iQuantidadeSolicitada
    );

    return parent::processar('gerarRequisicaoAidof', $aValores);
  }

  /**
   * Cancela requisição de aidof
   *
   * @param integer $iCodigoRequisicao
   * @return StdClass
   */
  public static function cancelar($iCodigoRequisicao) {

    $aValores = array('codigorequisicao' => $iCodigoRequisicao);

    return parent::processar('cancelarRequisicaoAidof', $aValores);
  }

  /**
   * Lista de requisicoes de aidof emitidas
   * pela empresa conforme tipo de documento
   *
   * @param string  $iInscricaoMunicipal
   * @param integer $iTipoDocumento
   * @param string  $sGrupoNotaIss
   * @throws Zend_Exception
   * @return array|NULL
   */
  public static function getRequisicoesAidof($iInscricaoMunicipal = NULL,
                                             $iTipoDocumento      = NULL,
                                             $sGrupoNotaIss       = NULL) {

    if (!$iInscricaoMunicipal) {
      return NULL;
    }

    if ($iTipoDocumento) {
      $aFiltro['tipo_nota'] = $iTipoDocumento;
    }

    if ($sGrupoNotaIss) {
      $aFiltro['codigo_grupo_notaiss'] = $sGrupoNotaIss;
    }

    $aFiltro['inscricao_municipal'] = $iInscricaoMunicipal;

    $aCampos  = array(
      'codigo_requisicaoaidof',
      'inscricao_municipal',
      'data_lancamento',
      'quantidade_solicitada',
      'quantidade_liberada',
      'status',
      'observacao',
      'tipo_nota',
      'cgm_grafica',
      'nome_grafica',
      'codigo_usuario',
      'nome_usuario',
      'descricao_nota',
      'codigo_nota'
    );

    $aRetorno = parent::consultar('getRequisicoesAidof', array($aFiltro, $aCampos));

    if (is_array($aRetorno)) {
      return $aRetorno;
    }

    return NULL;
  }


  /**
   * Lista de requisicoes e aidofs emitidas
   * pela empresa conforme tipo de documento
   *
   * @param string  $iInscricaoMunicipal
   * @param integer $iTipoDocumento
   * @param string  $sGrupoNotaIss
   * @throws Zend_Exception
   * @return array|NULL
   */
  public static function getRequisicoeseAidofs($iInscricaoMunicipal, $iTipoDocumento = NULL, $sGrupoNotaIss) {

    if (!$iInscricaoMunicipal) {
      throw new Zend_Exception('Informe a inscrição municipal');
    }

    if ($sGrupoNotaIss) {
      $aFiltro['codigo_grupo'] = $sGrupoNotaIss;
    }

    $aFiltro['inscricao_municipal'] = $iInscricaoMunicipal;

    $aCampos = array(
      'codigo_requisicaoaidof',
      'inscricao_municipal',
      'data_lancamento',
      'quantidade_solicitada',
      'quantidade_liberada',
      'status',
      'observacao',
      'tipo_nota',
      'cgm_grafica',
      'nome_grafica',
      'codigo_usuario',
      'nome_usuario',
      'descricao_nota',
      'codigo_nota',
      'nota_inicial',
      'nota_final',
    );

    $aRetorno = parent::consultar('getRequisicoeseAidofs', array($aFiltro, $aCampos));

    return is_array($aRetorno) ? $aRetorno : NULL;
  }

  /**
   * Verifica se existem requisicoes com status "P = Pendente"
   *
   * @param  integer $iInscricaoMunicipal
   * @param  integer $iTipoDocumento
   * @param  integer $iGrupoNotaIss
   * @return integer
   */
  public static function verificarRequisicaoPendente($iInscricaoMunicipal, $iTipoDocumento, $iGrupoNotaIss = NULL) {

    $aRequisicoesAidof        = self::getRequisicoesAidof($iInscricaoMunicipal, $iTipoDocumento, $iGrupoNotaIss);

    $iQuantRequisicaoPendente = 0;

    if (is_array($aRequisicoesAidof)) {

      foreach ($aRequisicoesAidof as $oRequisicao) {

        if ($oRequisicao->status == 'P') {
          $iQuantRequisicaoPendente = ++$iQuantRequisicaoPendente;
        }
      }
    }

    return $iQuantRequisicaoPendente;
  }

  /**
   * Verifica se possui algum bloqueio para a requisição de aidof
   *
   * @param object $oContribuinte
   * @param integer $iGrupoNota
   * @return bool|string
   * @throws Exception
   */
  public static function verificaBloqueio($oContribuinte, $iGrupoNota) {

    $oRetorno                = new StdClass();
    $oRetorno->bloqueado_msg = FALSE;

    $iInscricaoMunicipal = $oContribuinte->getInscricaoMunicipal();
    $iIdContribuinte     = $oContribuinte->getIdUsuarioContribuinte();

    $iQuantidadeNotasEmissao = Contribuinte_Model_NotaAidof::getQuantidadeNotasPendentes($oContribuinte, NULL, $iGrupoNota);

    // Verifica a quantidade de aidof liberada
    if ($iQuantidadeNotasEmissao == 0) {
      $oRetorno->bloqueado_msg = 'Limite de notas para emissão atingido, faça uma nova requisição.';
    }

    $oParamContribuinte = Contribuinte_Model_ParametroContribuinte::getById($iIdContribuinte);
    $sMensagem = 'Você possui "%s" notas para emissão. É importante gerar uma nova requisição.';

    // Verifica a quantidade de notas pela configuracao do Contribuinte
    if (is_object($oParamContribuinte) && $oParamContribuinte->getAvisofimEmissaoNota() > 0) {

      if ($iQuantidadeNotasEmissao <= $oParamContribuinte->getAvisofimEmissaoNota()) {
        $oRetorno->message = sprintf($sMensagem, $iQuantidadeNotasEmissao);
      }
    } else {

      $oParamPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();

      if (is_object($oParamPrefeitura) && $oParamPrefeitura->getQuantidadeAvisoFimEmissao() > 0) {

        if ($iQuantidadeNotasEmissao <= $oParamPrefeitura->getQuantidadeAvisoFimEmissao()) {
          $oRetorno->message = sprintf($sMensagem, $iQuantidadeNotasEmissao);
        }
      }
    }

    return $oRetorno;
  }

  /**
   * Verifica se o parâmetro geral de configuração das requisições de nfse está habilitado
   *
   * @return mixed
   * @throws Exception
   */
  public static function permiteRequisicaoAidofNfse() {

    $oParametro = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();

    return $oParametro->getRequisicaoNfse();
  }
}