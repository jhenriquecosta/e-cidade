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
 * Modelo para consulta empresas no e-Cidade por webservice
 */
class Contribuinte_Model_EmpresaEcidade extends WebService_Model_Ecidade {

  /**
   * Lista de campos que serao retornados
   *
   * @var array
   */
  private static $aCampos = array(
    'cpf',
    'nome',
    'nome_fanta',
    'inscr_est',
    'inscricao',
    'tipo_rua',
    'logradouro',
    'numero',
    'complemento',
    'bairro',
    'cod_ibge',
    'municipio',
    'uf',
    'cod_pais',
    'pais',
    'cep',
    'telefone',
    'email',
    'subst_trib'
  );

  /**
   * Busca por CGC ou CPF
   *
   * @param String $sCgcCpf
   * @return multitype:Contribuinte_Model_EmpresaEcidade
   */
  public static function getByCgcCpf($sCgcCpf) {

    $aFiltro = array('cgccpf' => $sCgcCpf);

    return self::get($aFiltro);
  }

  /**
   * Busca generica no webservice
   *
   * @param array $aFiltro
   * @return multitype:Contribuinte_Model_EmpresaEcidade
   */
  private static function get($aFiltro) {

    $aEmpresa = parent::consultar('getDadosTomador', array($aFiltro, self::$aCampos));
    $aRetorno = array();

    if (is_array($aEmpresa)) {

      foreach ($aEmpresa as $oEmpresa) {
        $aRetorno[] = new self($oEmpresa);
      }
    }

    return $aRetorno;
  }
}