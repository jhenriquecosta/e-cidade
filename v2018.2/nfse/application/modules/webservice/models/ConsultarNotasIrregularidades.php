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
 * Model responsável pelo processamento dos métodos solicitados no SOAP service
 * @author Lucas Dumer <lucas.dumer@dbseller.com.br>
 */
class WebService_Model_ConsultarNotasIrregularidades extends WebService_Lib_Models_Consultar implements WebService_Lib_Interfaces_Consultar {

  /**
   * Construtor da classe
   * @param object
   */
  public function __construct($oModeloImportacao) {
    parent::__construct($oModeloImportacao, 'NotasIrregularidades');
  }

  /**
   * Consulta conforme informações processadas
   * @param  object
   * @return array
   */
  public function getByObject($oXml) {

    $aContribuinteNotasIrregularidades = $this->getContribuintesNotasIrregulares($oXml->dataEmissao->inicio,
                                                                                 $oXml->dataEmissao->fim,
                                                                                 $oXml->inscricaoMunicipal);

    return $aContribuinteNotasIrregularidades;
  }

  /**
   * Ontem as notas Irregulares
   * @param  string  $sDataInicio         Data formato Y-m-d
   * @param  string  $sDataFim            Data formato Y-m-d
   * @param  integer $iInscricaoMunicipal Inscricao Municipal
   * @return arrray                       Array de Notas irregulares
   */
  public function getContribuintesNotasIrregulares($sDataInicio = NULL, $sDataFim = NULL, $iInscricaoMunicipal = NULL) {

    $oQueryBuilder = Global_Lib_Model_Doctrine::getQuery();
    $oQueryBuilder->select("n.id, n.nota, n.dt_nota, u.nome, uc.im, uc.cnpj_cpf, 'Teste' As situacao, ni.descricao, n.id_contribuinte");

    $oQueryBuilder->from('Contribuinte\Nota', 'n');

    $oQueryBuilder->innerJoin('Contribuinte\NotaIrregularidade', 'ni', 'WITH', 'ni.id_nota = n.id');
    $oQueryBuilder->innerJoin('Administrativo\UsuarioContribuinte', 'uc', 'WITH', 'uc.id = n.id_contribuinte');
    $oQueryBuilder->innerJoin('Administrativo\Usuario', 'u', 'WITH', 'u.id = uc.id_usuario');

    if (!empty($sDataInicio) && !empty($sDataFim)) {
      $oQueryBuilder->andWhere("n.dt_nota between '{$sDataInicio}' and '{$sDataFim}'");
    } else {
      if (!empty($sDataInicio)) {
        $oQueryBuilder->andWhere("n.dt_nota between '{$sDataInicio}' and '".date('Y-m-d')."'");
      }
    }

    if (!empty($iInscricaoMunicipal) && $iInscricaoMunicipal != 0) {
      $oQueryBuilder->andWhere("uc.im  = {$iInscricaoMunicipal}");
    }
    $oQueryBuilder->orderBy('u.nome, n.id', 'ASC');

    return $oQueryBuilder->getQuery()->getArrayResult();

  }
}