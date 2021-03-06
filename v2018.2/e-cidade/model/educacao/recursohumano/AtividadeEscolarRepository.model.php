<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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
 * Representa uma cole??o de Atividades escolar
 * @package   Educacao
 * @subpackage recursohumano
 * @author    Andrio Costa - andrio.costa@dbseller.com.br
 * @version   $Revision: 1.1 $
 */
class AtividadeEscolarRepository {

  /**
   * Collection de AtividadeEscolar
   * @var array
   */
  private $aAtividadeEscolar = array();

  /**
   * Instancia da classe
   * @var AtividadeEscolarRepository
   */
  private static $oInstance;

  private function __construct() {

  }
  private function __clone() {

  }

  /**
   * Retorno uma instancia de uma atividade escolar
   * @param integer $iCodigo
   * @return AtividadeEscolar
   */
  public static function getByCodigo($iCodigo) {

    if (!array_key_exists($iCodigo, AtividadeEscolarRepository::getInstance()->aAtividadeEscolar)) {
      AtividadeEscolarRepository::getInstance()->aAtividadeEscolar[$iCodigo] = new AtividadeEscolar($iCodigo);
    }
    return AtividadeEscolarRepository::getInstance()->aAtividadeEscolar[$iCodigo];
  }

  /**
   * Retorna a instancia da classe
   * @return AtividadeEscolarRepository
   */
  protected static function getInstance() {

    if (self::$oInstance == null) {

      self::$oInstance = new AtividadeEscolarRepository();
    }
    return self::$oInstance;
  }

  /**
   * Adiciona um AtividadeEscolar ao repositorio
   * @param AtividadeEscolar $oAtividadeEscolar Instancia de AtividadeEscolar
   * @return boolean
   */
  public static function adicionarAtividade(AtividadeEscolar $oAtividadeEscolar) {

    if(!array_key_exists($oAtividadeEscolar->getCodigo(), AtividadeEscolarRepository::getInstance()->aAtividadeEscolar)) {
      AtividadeEscolarRepository::getInstance()->aAtividadeEscolar[$oAtividadeEscolar->getCodigo()] = $oAtividadeEscolar;
    }
    return true;
  }

  /**
   * Remove o AtividadeEscolar passado como parametro do repository
   * @param AtividadeEscolar $oAtividadeEscolar
   * @return boolean
   */
  public static function removerAtividade(AtividadeEscolar $oAtividadeEscolar) {

    if (array_key_exists($oAtividadeEscolar->getCodigo(), AtividadeEscolarRepository::getInstance()->aAtividadeEscolar)) {
      unset(AtividadeEscolarRepository::getInstance()->aAtividadeEscolar[$oAtividadeEscolar->getCodigo()]);
    }
    return true;
  }

}