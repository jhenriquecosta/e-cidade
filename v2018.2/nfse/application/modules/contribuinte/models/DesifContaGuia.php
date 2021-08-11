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
 * Modelo responsável pela abstração dos vículos entre importacao_desif, importacao_desif_contas e guias
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
class Contribuinte_Model_DesifContaGuia extends Contribuinte_Lib_Model_Doctrine {

  static protected $entityName = 'Contribuinte\DesifContaGuia';
  static protected $className  = __CLASS__;

  public function persist() {

    $oEntidade = $this->getEntity();
    $this->getEm()->persist($oEntidade);
    $this->getEm()->flush();
  }

  /**
   * Método para pegar as Contas pela Competencia escolhida pelo Contribuinte
   * @param  array $aParametrosBusca
   * @return array $aDadosConta
   */
  public static function getContasByCompetencia($iCompetencia) {

  	$oImportacaoDesif         = Contribuinte_Model_ImportacaoDesif::getById($iCompetencia);
    $oImportacaoDesifEntidade = $oImportacaoDesif->getEntity();
    $aImportacaoDesifTarifas  = Contribuinte_Model_ImportacaoDesifTarifa::getByAttribute('importacao_desif', $oImportacaoDesifEntidade);

    // Adicionado valor ao array para validar o mesmo corretamente no array_search
    $aCodigoContas = array(0 => "");

    if (is_array($aImportacaoDesifTarifas)) {

      foreach ($aImportacaoDesifTarifas as $oDesifTarifa) {

        $oDadosConta = $oDesifTarifa->getImportacaoDesifConta();
        
        if (!array_search($oDadosConta->getConta(), $aCodigoContas)) {

          $oConta                  = new StdClass();
          $oConta->id              = $oDadosConta->getId();
          $oConta->conta           = $oDadosConta->getConta();
          $oConta->descricao_conta = $oDadosConta->getDescricaoConta();
          $aCodigoContas[]         = $oConta->conta;
          $oDesifContaGuia         = self::getByAttributes(array(
                                                        'importacao_desif' => $oImportacaoDesifEntidade,
                                                        'importacao_desif_conta' => $oDadosConta,
                                                        ));

          //Verficação de conta já emitida e conta com guia
          if (!empty($oDesifContaGuia)) {

            $oGuia = $oDesifContaGuia[0]->getGuia();

            if (empty($oGuia)) {

              $oConta->isEmitida = TRUE;
              $aDadosConta[]     = $oConta;
            }
          } else {
            
            $oConta->isEmitida = FALSE;
            $aDadosConta[]     = $oConta;
          }
        }
      }
    } else {

      $oDadosConta = $aImportacaoDesifTarifas->getImportacaoDesifConta();

      if (!array_search($oDadosConta->getConta(), $aCodigoContas)) {

        $oConta                  = new StdClass();
        $oConta->id              = $oDadosConta->getId();
        $oConta->conta           = $oDadosConta->getConta();
        $oConta->descricao_conta = $oDadosConta->getDescricaoConta();
        $aCodigoContas[]         = $oConta->conta;
        $oDesifContaGuia         = self::getByAttributes(array(
                                                      'importacao_desif' => $oImportacaoDesifEntidade,
                                                      'importacao_desif_conta' => $oDadosConta,
                                                      ));

        //Verficação de conta já emitida e conta com guia
        if (!empty($oDesifContaGuia)) {

          $oGuia = $oDesifContaGuia[0]->getGuia();

          if (empty($oGuia)) {

            $oConta->isEmitida = TRUE;
            $aDadosConta[]     = $oConta;
          }
        } else {
          
          $oConta->isEmitida = FALSE;
          $aDadosConta[]     = $oConta;
        }
      }
    }
    
    return $aDadosConta;
  }

  /**
   * Método para salvar as Contas preparadas para emissão de Guia
   * @param array $aParametros
   * @return array $aRetorno
   * @return Exception
   */
  public function salvarEmissaoContas(array $aParametro) {
  	
  	$oDoctrine = Zend_Registry::get('em');

    try {

      $oDoctrine->getConnection()->beginTransaction();

      // Prepara parametros a serem removidos da preparação da guia
      $aContasDelete['importacao_desif_conta'] = $aParametro['contasPagina'];
      $aContasDelete['importacao_desif']       = $aParametro['competencia'];
      $aContasDelete['guia']                   = null;
      
      $oImportacaoDesif      = Contribuinte_Model_ImportacaoDesif::getById($aParametro['competencia']);
      $oDesifContaGuiaDelete = Contribuinte_Model_DesifContaGuia::delete($aContasDelete);

      foreach ($aParametro['selecionados'] as $iConta) {

        // Salva contas preparadas para a emissão de guia
        $oImportacaoDesifConta = Contribuinte_Model_ImportacaoDesifConta::getById($iConta);

        $oDesifContaGuia = new Contribuinte_Model_DesifContaGuia();
        $oDesifContaGuia->setImportacaoDesif($oImportacaoDesif->getEntity());
        $oDesifContaGuia->setImportacaoDesifConta($oImportacaoDesifConta->getEntity());
        $oDesifContaGuia->persist();
      }

      $oDoctrine->getConnection()->commit();

      $aRetorno['status']  = TRUE;
      $aRetorno['success'] = 'Emissão atualizada!';
    } catch (Exception $oErro) {

      $oDoctrine->getConnection()->rollback();
      $aRetorno['status']  = FALSE;
      $aRetorno['error'][] = 'Não foi possível atualizar a emissão!'. $oErro->getMessage();
    }

    return $aRetorno;
  }
}