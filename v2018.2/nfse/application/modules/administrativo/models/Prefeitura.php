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
 * Model Responsavel por retornar os dados da prefeitura
 *
 * @author  dbeverton.heckler
 * @package Administrativo/Models
 */

/**
 * @author  dbeverton.heckler
 * @package Administrativo/Models
 */
class Administrativo_Model_Prefeitura {

  /**
   * Retorna os dados da prefeitura do webservice
   *
   * @tutorial Campos de Retorno para exemplo:
   *           $oRetorno->sDescricao                = PREFEITURA MUNICIPAL DE TESTE DO SUL
   *           $oRetorno->sDescricaoAbreviada       = PM TESTE DO SUL
   *           $oRetorno->sCnpj                     = XXXXXXXXXXXXXXX
   *           $oRetorno->sLogradouro               = LOGRADOURO DA PREFEITURA
   *           $oRetorno->sMunicipio                = MUNICIPIO
   *           $oRetorno->sBairro                   = BAIRRO
   *           $oRetorno->sTelefone                 = XX XXXXXXXX
   *           $oRetorno->sSite                     = www.prefeitura.rs.gov.br
   *           $oRetorno->sEmail                    = contato@prefeitura.rs.gov.br
   *           $oRetorno->iCodigoMunicipio          = 531654
   *           $oRetorno->iNumeroCgm                = 5
   *           $oRetorno->sLogoPrefeituraBaseEncode = files/imagens/brasao_5249e01492774.jpg
   * @return mixed
   * @throws Exception
   */
  public static function getDadosPrefeituraWebService() {

    try {

      $aValores      = array('lprefeitura' => TRUE);
      $oDadosRetorno = WebService_Model_Ecidade::processar('DadosPrefeitura', $aValores);

      if ($oDadosRetorno->sLogoPrefeituraBaseEncode != '') {

        $sImagem      = $oDadosRetorno->sLogoPrefeituraBaseEncode;
        $sImagem      = str_replace('data:image/png;base64,', '', $sImagem);
        $sImagem      = str_replace(' ', '+', $sImagem);
        $oImagemDados = base64_decode($sImagem);
        $sNomeArquivo = 'brasao.jpg';
        $lSucesso     = file_put_contents('global/img/' . $sNomeArquivo, $oImagemDados);

        unset($oDadosRetorno->sLogoPrefeituraBaseEncode);

        if (!$lSucesso) {
          DBSeller_Plugin_Notificacao::addErro('W005', 'Problemas ao importar o arquivo logo da prefeitura.');
          throw new Exception('Problemas ao importar o arquivo logo da prefeitura.');
        }
      }

      return $oDadosRetorno;
    } catch (Exception $oErro) {
      DBSeller_Plugin_Notificacao::addErro('W006', "Erro para carregar dados da Prefeitura: {$oErro->getMessage()}");
      throw new Exception("Erro para carregar dados da Prefeitura: {$oErro->getMessage()}");
    }
  }

  /**
   * Retorna os dados da prefeitura
   *
   * @return mixed
   * @throws Exception
   */
  public static function getDadosPrefeituraBase() {

    $oDadosPrefeitura = Administrativo_Model_ParametroPrefeitura::getAll();

    if (count($oDadosPrefeitura) > 1) {
      throw new Exception('Cadastro de Prefeitura Inconsistente. Favor entre em contato com o Suporte');
    }

    return $oDadosPrefeitura[0];
  }

  /**
   * Adiciona as permissoes de requisiçao para cada usuário do tipo Pestador NFSE
   *
   * @return bool
   * @throws Exception
   */
  public static function geraPermissoesPrestadorNfse() {

    $aUsuariosEmissorNfse = Contribuinte_Model_Contribuinte::getContribuinteEmissoresNfse();

    if (is_array($aUsuariosEmissorNfse)) {

      // Consulta as ações de menu da NFSE
      $oQueryBuilder = Contribuinte_Lib_Model_Doctrine::getQuery();
      $oQueryBuilder->select('a');
      $oQueryBuilder->from('Administrativo\Acao', 'a');
      $oQueryBuilder->join('a.controle', 'c');
      $oQueryBuilder->where('c.controle = \'NFSe\'');
      $oQueryBuilder->andWhere('c.modulo = 2');
      $oQueryBuilder->andWhere('a.acaoacl = \'requisicao\'');

      $aDadosAcao = $oQueryBuilder->getQuery()->getResult();
      $oAcao = Administrativo_Model_Acao::getById($aDadosAcao[0]->getId());

      // Percorre os dados dos usuário encontrados
      foreach ($aUsuariosEmissorNfse as $aDadosUsuarioContribuinte) {

        if (is_array($aDadosUsuarioContribuinte) && !empty($aDadosUsuarioContribuinte['id'])) {

          // Adiciona as permissoes de cada usuário do tipo Pestador NFSE
          $oUsuarioContribuinte = Administrativo_Model_UsuarioContribuinte::getById($aDadosUsuarioContribuinte['id']);

          // Consulta ações do usuário contribuinte
          $oAcaoUsuarioContribuinte = Administrativo_Model_UsuarioContribuinteAcao::getByAttributes(array(
            'usuario_contribuinte' => $oUsuarioContribuinte->getEntity(),
            'acao' => $oAcao->getEntity()
          ));

          // Verifica se não existe permissão da ação vinculada ao contribuinte
          if (empty($oAcaoUsuarioContribuinte)) {

            // Salva a ação do usuário contribuinte
            $oAcaoUsuarioContribuinte = new Administrativo_Model_UsuarioContribuinteAcao();
            $oAcaoUsuarioContribuinte->persist(array(
               'usuario_contribuinte' => $oUsuarioContribuinte->getEntity(),
               'acao' => $oAcao->getEntity()
             ));
          }
        }
      }
    }

    return TRUE;
  }

  /**
   * Remove as permissoes de requisiçao para cada usuário do tipo Pestador NFSE
   *
   * @return bool
   * @throws Exception
   */
  public static function removePermissoesPrestadorNfse() {

    // Consulta as permissões de acesso de menu da NFSE
    $oQueryBuilder = Contribuinte_Lib_Model_Doctrine::getQuery();
    $oQueryBuilder->select('uca');
    $oQueryBuilder->from('Administrativo\UsuarioContribuinteAcao', 'uca');
    $oQueryBuilder->join('uca.acao', 'a');
    $oQueryBuilder->join('a.controle', 'c');
    $oQueryBuilder->where('c.controle = \'NFSe\'');
    $oQueryBuilder->andWhere('c.modulo = 2');
    $oQueryBuilder->andWhere('a.acaoacl = \'requisicao\'');

    $aUsuarioContribuinteAcao = $oQueryBuilder->getQuery()->getArrayResult();

    foreach ($aUsuarioContribuinteAcao as $aDados) {

      $oUsuarioContribuinteAcao = Administrativo_Model_UsuarioContribuinteAcao::getByAttribute('id', $aDados['id']);
      $oUsuarioContribuinteAcao->remove();
    }

    return TRUE;
  }

  /**
   * Consulta o CGM da prefeitura
   *
   * @return null|integer
   * @throws Exception
   */
  public static function getCgmPrefeitura() {

    $aRetorno = WebService_Model_Ecidade::consultar('getDadosPrefeitura', array(array(), array(
      'numcgm'
    )));

    $iCgmPrefeitura = (isset($aRetorno[0]->numcgm)) ? $aRetorno[0]->numcgm : NULL;

    if (empty($iCgmPrefeitura)) {
      throw new Exception('CGM da prefeitura não configurado no E-cidade!');
    }

    return $iCgmPrefeitura;
  }
}