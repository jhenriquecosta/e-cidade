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
 *
 */

/**
 * Classe para a central de notificações do sistema
 *
 * @category Notificacoes
 * @package Lib/DBSeller
 * @see Lib_DBSeller_Plugin_Notificacao
 * @author Davi Busanello <davi@dbseller.com.br>
 */

class DBSeller_Plugin_Notificacao  {

  const TIPO_SUCESSO = 'sucesso';
  const TIPO_AVISO   = 'alerta';
  const TIPO_ERRO    = 'erro';

  /**
   * Adiciona uma notificação do tipo SUCESSO
   *
   * @param string $sCodigo
   * @param string $sMensagem
   * @return bool
   */
  public static function addSucesso($sCodigo, $sMensagem) {

    $oNotificacoesNamespace = new Zend_Session_Namespace('notificacoes');

    if (isset($oNotificacoesNamespace->sucesso)) {

      $aParametros                     = array("{$sCodigo}" => str_replace("\\n", '', $sMensagem));
      $aSucessos                       = array_merge($oNotificacoesNamespace->sucesso, $aParametros);
      $oNotificacoesNamespace->sucesso = $aSucessos;
    } else {
      $oNotificacoesNamespace->sucesso = array();
    }

    return TRUE;
  }

  /**
   * Adiciona uma notificação do tipo AVISO
   *
   * @param string $sCodigo
   * @param string $sMensagem
   * @return bool
   */
  public static function addAviso($sCodigo, $sMensagem) {

    $oNotificacoesNamespace = new Zend_Session_Namespace('notificacoes');

    if (isset($oNotificacoesNamespace->alerta)) {

      $aParametros                    = array("{$sCodigo}" => str_replace("\\n", '', $sMensagem));
      $aAvisos                        = array_merge($oNotificacoesNamespace->alerta, $aParametros);
      $oNotificacoesNamespace->alerta = $aAvisos;
    } else {
      $oNotificacoesNamespace->alerta = array();
    }

    return TRUE;
  }

  /**
   * Adiciona uma notificação do tipo ERRO
   *
   * @param string $sCodigo
   * @param string $sMensagem
   * @return bool
   */
  public static function addErro($sCodigo, $sMensagem) {

    $oNotificacoesNamespace = new Zend_Session_Namespace('notificacoes');

    if (isset($oNotificacoesNamespace->erro)) {

      $aParametros                  = array("{$sCodigo}" => str_replace("\\n", '', $sMensagem));
      $aErros                       = array_merge($oNotificacoesNamespace->erro, $aParametros);
      $oNotificacoesNamespace->erro = $aErros;
    } else {
      $oNotificacoesNamespace->erro = array();
    }

    return TRUE;
  }

  /**
   * Remove uma notificação
   *
   * @param string $sTipo
   * @param string $sCodigo
   * @return bool
   */
  public static function remove($sTipo, $sCodigo) {

    unset($_SESSION['notificacoes'][$sTipo][$sCodigo]);

    return TRUE;
  }

  /**
   * Limpa todas as notificações
   *
   * @return boolean
   */
  public static function limpar() {

    $oSessaoNotificacao = new Zend_Session_Namespace('notificacoes');
    $oSessaoNotificacao->__unset(self::TIPO_SUCESSO);
    $oSessaoNotificacao->__unset(self::TIPO_AVISO);
    $oSessaoNotificacao->__unset(self::TIPO_ERRO);

    return TRUE;
  }

  /**
   * Obtem todas as notificações setadas no sistema
   *
   * @return array todas as notificações
   */
  public static function getAll() {

    $aSessaoNotificacao = Zend_Session::namespaceGet('notificacoes');

    return $aSessaoNotificacao;
  }

  /**
   * Obtem todas as notificações do tipo Sucesso
   *
   * @return array notificações do tipo sucesso
   */
  public static function getSucesso() {

    $aSessaoNotificacao = self::getAll();

    return (!empty($aSessaoNotificacao[self::TIPO_SUCESSO]) ? $aSessaoNotificacao[self::TIPO_SUCESSO] : array());
  }

  /**
   * Obtem todas as notificações do tipo Aviso
   *
   * @return array notificações do tipo erro
   */
  public static function getAviso() {

    $aSessaoNotificacao = self::getAll();

    return (!empty($aSessaoNotificacao[self::TIPO_AVISO]) ? $aSessaoNotificacao[self::TIPO_AVISO] : array());
  }

  /**
   * Obtem todas as notificações de erro
   *
   * @return array notificaçõs do tipo erro
   */
  public static function getErro() {

    $aSessaoNotificacao = self::getAll();

    return (!empty($aSessaoNotificacao[self::TIPO_ERRO]) ? $aSessaoNotificacao[self::TIPO_ERRO] : array());
  }

  /**
   * Obtem o total de notificações
   *
   * @return integer Total
   */
  public static function getCountAll() {

    $iCount  = 0;
    $iCount += count(self::getErro());
    $iCount += count(self::getAviso());
    $iCount += count(self::getSucesso());

    return $iCount;
  }

  /**
   * Obtem o total de notificações pelo Tipo
   *
   * @param string $sTipo
   * @return mixed
   */
  public static function getCountTipo($sTipo) {

    $aSessaoNotificacao = self::getAll();
    $iCountTipo         = 0;

    if (isset($aSessaoNotificacao[$sTipo])) {
      $iCountTipo = count($aSessaoNotificacao[$sTipo]);
    }

    return $iCountTipo;
  }
}