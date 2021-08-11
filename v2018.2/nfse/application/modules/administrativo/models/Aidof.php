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
 * Model Aidof consultas via webservice
 *
 * @author Gilton Guma <gilton@dbseller.com.br>
 */
class Administrativo_Model_Aidof {

  /**
   * Método que retorna a quantidade de Notas Emitidas
   *
   * @param  integer $iInscricaoMunicipal
   * @param  integer $iTipoNota
   * @param  string  $sGrupoNota
   * @throws Exception
   * @return integer
   */
  public function getQuantidadesNotasEmissao($iInscricaoMunicipal, $iTipoNota = NULL, $sGrupoNota = NULL) {

    if (!$iInscricaoMunicipal) {
      throw new Zend_Exception('Informe uma Inscrição Municipal.');
    }

    if (!$iTipoNota && !$sGrupoNota) {
      throw new Zend_Exception('Informe o Tipo de Nota ou Grupo de Nota.');
    }

    if ($iTipoNota) {

      $oWebService = new WebService_Model_Ecidade();
      $aFiltro     = array('inscricao_municipal' => $iInscricaoMunicipal, 'tipo_nota' => $iTipoNota);
      $aCampos     = array('quantidade_notas_liberadas');
      $aRetorno    = $oWebService::consultar('getQuantidadeNotasLiberadas', array($aFiltro, $aCampos));
    } else {

      $oWebService = new WebService_Model_Ecidade();
      $aFiltro     = array('inscricao_municipal' => $iInscricaoMunicipal, 'grupo_nota' => $sGrupoNota);
      $aCampos     = array('quantidade_notas_liberadas');
      $aRetorno    = $oWebService::consultar('getQuantidadeAidofsLiberadasPorGrupoDocumento', array($aFiltro, $aCampos));
    }

    if (is_array($aRetorno)) {

      $iQuantidadeNotasEmitidas = Contribuinte_Model_DmsNota::getQuantidadeNotasEmitidas($iInscricaoMunicipal, $iTipoNota);

      return $aRetorno[0]->quantidade_notas_liberadas - $iQuantidadeNotasEmitidas;
    }

    DBSeller_Plugin_Notificacao::addAviso('Aidof01', "Não houve retorno do WebService do E-Cidade!");
    return 0;
  }

  /**
   * Verifica se a numeração do documento consta na numeração liberada nos AIDOFs
   *
   * @param  integer $iInscricaoMunicipal
   * @param  integer $iNumeroNota
   * @param  integer $iTipoNota
   * @throws Exception
   * @return boolean
   */
  public function verificarNumeracaoValidaParaEmissaoDocumento($iInscricaoMunicipal, $iNumeroNota, $iTipoNota) {

    if (!$iInscricaoMunicipal) {
      throw new Exception('Informe a inscrição municipal.');
    }

    if (!$iNumeroNota) {
      throw new Exception('Informe o número do documento.');
    }

    if (!$iTipoNota) {
      throw new Exception('Informe o tipo de documento.');
    }

    $aFiltro     = array('inscricao' => $iInscricaoMunicipal, 'tipo_nota' => $iTipoNota);
    $aCampos     = array('nota_inicial', 'nota_final');
    $aWebService = WebService_Model_Ecidade::consultar('getAidofNumeracaoValidaParaEmissaoNotas', array($aFiltro, $aCampos));

    if (!is_array($aWebService)) {
      throw new Exception('Ocorreu um erro ao verificar numeração do documento no WebService.');
    }

    $iNumeroNota       = DBSeller_Helper_Number_Format::getNumbers($iNumeroNota);
    $iNumeracaoInicial = isset($aWebService[0]->nota_inicial) ? $aWebService[0]->nota_inicial : 0;
    $iNumeracaoFinal   = isset($aWebService[0]->nota_final)   ? $aWebService[0]->nota_final   : 0;

    return ($iNumeroNota >= $iNumeracaoInicial && $iNumeroNota <= $iNumeracaoFinal);
  }
}
