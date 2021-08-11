<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

/**
 * Modelo responsável pela inserção das contas da ABRASF
 * @author Davi Busanello <davi@dbseller.com.br>
 */
class Contribuinte_Model_PlanoContaAbrasf extends Contribuinte_Lib_Model_Doctrine {

  static protected $entityName = 'Contribuinte\PlanoContaAbrasf';
  static protected $className = __CLASS__;

  public function persist() {

    self::getEm()->persist($this->getEntity());
    self::getEm()->flush();
  }

  /**
   * Método para salvar as contas que são obrigatórias
   *
   * @param array $aContas
   *
   * @return boolean
   * @throws Exception
   */
  public function salvarObrigatorio(array $aContas = null) {

    if (!is_array($aContas)) {
      throw new Exception('Erro ao salvar as Contas Obrigatórias!');
    }

    $oDoctrine = Zend_Registry::get('em');

    try {

      $oDoctrine->getConnection()->beginTransaction();

      if (!empty($aContas)) {

        $aParams = array('sets'  => array('obrigatorio' => 'true'),
                         'where' => array('id' => $aContas)
        );

        Contribuinte_Model_PlanoContaAbrasf::update($aParams['sets'], $aParams['where']);
      }

      $oDoctrine->getConnection()->commit();

      return TRUE;
    } catch (Exception $oErro) {

      $oDoctrine->getConnection()->rollback();
      throw new Exception('Erro ao salvar as Contas Obrigatórias!' . $oErro->getMessage());
    }
  }
}