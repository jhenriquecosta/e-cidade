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

class Administrativo_Model_Versao extends E2Tecnologia_Model_Doctrine {

  static protected $entityName = "Administrativo\Versao";
  static protected $className = __CLASS__;

  /**
   * Método para atualizar a versão do nota
   *
   * @param string $sVersaoNfseAtualizar
   * @return mixed
   * @throws Exception
   */
  public static function atualizaVersaoNfse($sVersaoNfseAtualizar, $sVersaoAtual = 'V010100') {

    try {

      // Verifica se foi informado uma versão para o NFS-e
      if (empty($sVersaoNfseAtualizar)) {
        throw new Exception('Informe a versão que deseja atualizar!');
      }

      $sVersaoSistemaAtualizacao = (int) str_replace('V', '', trim($sVersaoNfseAtualizar));
      $sVersaoSistemaImplantacao = (int) str_replace('V', '', trim($sVersaoAtual));

      // Verifica se a versão do nota informada é menor ou igual a primeira versão implantada
      if ($sVersaoSistemaAtualizacao < $sVersaoSistemaImplantacao) {

        $sMensagem  = "Versão do NFS-e atualizada não é maior que a última modificação encontrada.<br>";
        $sMensagem .= "Versão NFS-e atualizada: {$sVersaoNfseAtualizar}<br>";
        $sMensagem .= "Versão NFS-e atual: {$sVersaoAtual}";

        throw new Exception($sMensagem);
      }

      /* Melhoria no controle de atualização de versões do NFS-e */
      if (substr($sVersaoSistemaAtualizacao, -2) != '00') {

        $oVersaoNfse = Administrativo_Model_Versao::getByAttribute('ecidadeonline2', trim($sVersaoNfseAtualizar));

        if (empty($oVersaoNfse)) {

          $oEntidade     = self::getEm();
          $oQueryBuilder = $oEntidade->createQueryBuilder();
          $oQueryVersao  = $oQueryBuilder->update('Administrativo\Versao', 'v')
            ->set('v.ecidadeonline2', '?1')
            ->where('v.ecidadeonline2 = ?2')
            ->setParameter(1, trim($sVersaoNfseAtualizar))
            ->setParameter(2, trim($sVersaoAtual))
            ->getQuery();

          $bRetorno = $oQueryVersao->execute();

          return $bRetorno;
        }
      }

      return TRUE;
    } catch (Exception $oErro) {
      throw new WebService_Lib_Exception($oErro->getMessage(), $oErro, 'E01');
    }
  }

  /**
   * Retorna a maior versão cadastrada
   * @return mixed
   */
  public static function getVersaoAtual() {

    $oEntidade    = self::getEm();
    $sSql         = 'SELECT MAX(v.ecidadeonline2) FROM Administrativo\Versao v';
    $oQuery       = $oEntidade->createQuery($sSql);
    $sVersaoAtual = $oQuery->getSingleScalarResult();

    return $sVersaoAtual;
  }
}