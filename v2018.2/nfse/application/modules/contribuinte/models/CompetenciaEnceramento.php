<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2016  DBSeller Servicos de Informatica
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

final class Contribuinte_Model_CompetenciaEnceramento
{

  /**
   * Constante com índices do array estático das observação de cancelmento do ecidade
   *
   * LEBRE QUE O ECIDADE UTILIZA ESSES VALORES EXATAMENTE COMO ESTÃO, PORTANTO
   * QUALQUER ALTERAÇÃO NELES TERÁ IMPACTOS NO ECIDADE
   *
   * TENHA CERTEZA DO QUE ESTÁ FAZENDO!!!!
   */
  const DESCRICAO_SEM_MOVIMENTO           = "SEM_MOVIMENTO";
  const DESCRICAO_SEM_IMPOSTO             = "SEM_IMPOSTO";

  private $oContribuinte;

  private $iAno;

  private $iMes;

  private $oDataPagamento;

  private $oCompetencia;

  public function __construct(Contribuinte_Model_ContribuinteAbstract $oContribuinte, $iAno, $iMes, $oDataPagamento = null)
  {
    $this->oContribuinte  = $oContribuinte;
    $this->iAno           = $iAno;
    $this->iMes           = $iMes;
    $this->oDataPagamento = $oDataPagamento;
    $this->oCompetencia   = new Contribuinte_Model_Competencia($this->iAno, $this->iMes, $this->oContribuinte);

  }

  private function getEntityManager()
  {
    return Zend_Registry::get('em');
  }

  public function encerrar()
  {
    $oDataInscricaoBaixa = $this->oContribuinte->getDataInscricaoBaixa();

    if(!empty($oDataInscricaoBaixa)){

      if(  ($oDataInscricaoBaixa->format('Y') < $this->iAno)
        or ($oDataInscricaoBaixa->format('Y') == $this->iAno and (integer)$oDataInscricaoBaixa->format('m') < $this->iMes)){
        throw new Exception("Inscrição baixada em ".$oDataInscricaoBaixa->format('d/m/Y').", portanto não é possível encerrar esta competência!");
      }
    }

    $aCompetenciaAberto = $this->oCompetencia->getAbertoByContribuinte();

    if (empty($aCompetenciaAberto)) {
      throw new Exception("Competência não esta em aberto.");
    }

    $this->oCompetencia = $aCompetenciaAberto[0];

    $oRetorno = new StdClass;
    $oRetorno->lGuia = false;

    try {

      $oDoctrine = Zend_Registry::get('em');
      $oDoctrine->getConnection()->beginTransaction();

      $iSituacao = $this->oCompetencia->getSituacao();

      $iSituacaoCompetenciaEncerrada = $this->geraEncerramentoCompetencia();

      if ($iSituacao == Contribuinte_Model_Competencia::SITUACAO_EM_ABERTO) {

        $oGuia = $this->geraEncerramentoCompetenciaEmAberto();

        $this->geraVinculoCompetenciaGuia($oGuia->codigo_guia);

        $oRetorno->lGuia = true;
        $oRetorno->oGuia = $oGuia;
      } elseif (   $iSituacao == Contribuinte_Model_Competencia::SITUACAO_EM_ABERTO_SEM_MOVIMENTO
                or $iSituacao == Contribuinte_Model_Competencia::SITUACAO_EM_ABERTO_SEM_IMPOSTO
      ) {

        $lGuiaCancelada = false;

        if(    !$this->oContribuinte->isRegimeTributarioMei()
           and !$this->oContribuinte->isRegimeTributarioFixado()
           and !$this->oContribuinte->isRegimeTributarioSociedadeProfissionais()
           and !$this->oContribuinte->isRegimeTributarioEstimativa()
           and !(    $this->oContribuinte->isOptanteSimples(new DateTime($this->iAno."-".$this->iMes."-01"))
                 and $iSituacaoCompetenciaEncerrada != Contribuinte_Model_Competencia::SITUACAO_ENCERRANDO_SEM_IMPOSTO
                 and $iSituacaoCompetenciaEncerrada != Contribuinte_Model_Competencia::SITUACAO_ENCERRANDO_SEM_MOVIMENTO)
        ) {

          $lGuiaCancelada = true;
        }

        if ($lGuiaCancelada) {

          // Se houver débito no e-cidade, cancela
          $this->processaCancelamentoDebito();
        }

        // pega numpre do debito no e-cidade
        $iNumpre = $this->getNumpreDebitoCompetencia();

        $this->geraGuiaCompetencia($lGuiaCancelada, $iNumpre, $this->oDataPagamento);
      }

      $oDoctrine->getConnection()->commit();
    } catch (Exception $oError) {

      $oDoctrine->getConnection()->rollback();
      throw new Exception($oError->getMessage());
    }

    return $oRetorno;
  }

  private function geraEncerramentoCompetenciaEmAberto()
  {
    $oGuia = Contribuinte_Model_GuiaEcidade::gerarGuiaNFSE($this->oContribuinte, $this->oCompetencia, $this->oDataPagamento);

    if (is_string($oGuia)) {
      throw new Exception($oGuia);
    }

    if (empty($oGuia->arquivo_guia)) {
      throw new Exception('Ocorreu algum problema na geração da guia de pagamento!');
    }

    return $oGuia;
  }

  private function getNumpreDebitoCompetencia()
  {
    $aCampos = array(
      'numpre',
      'inscricao',
      'ano'
    );

    $aFiltro = array(
      'inscricao' => $this->oContribuinte->getInscricaoMunicipal(),
      'ano'       => $this->iAno
    );

    $aRetorno = WebService_Model_Ecidade::consultar('getNumpreCompetencia', array($aFiltro, $aCampos));
    $iNumpre  = null;

    if (!empty($aRetorno)) {
      $iNumpre = $aRetorno[0]->numpre;
    }

    return $iNumpre;
  }

  private function geraGuiaCompetencia($lGuiaCancelada, $iNumpre = null, $oDataPagamento = null)
  {
    $sSituacao = Contribuinte_Model_Guia::$ABERTA;

    if ($lGuiaCancelada) {
      $sSituacao      = Contribuinte_Model_Guia::$CANCELADA;
      $oDataPagamento = new DateTime;
    }

    $oGuia = new Contribuinte_Model_GuiaCompetencia($this->oContribuinte, $this->oCompetencia);
    $oGuia->setNumpre($iNumpre);
    $oGuia->setDataFechamento(new DateTime);
    $oGuia->setVencimento($oDataPagamento);
    $oGuia->setSituacao($sSituacao);
    $oGuia->setTipo(Contribuinte_Model_Guia::$PRESTADOR);
    $oGuia->setTipoDocumentoOrigem(Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE);
    $oGuia->gerarGuia();

    return $oGuia;
  }

  private function geraEncerramentoCompetencia()
  {
    $this->oCompetencia->setId_contribuinte($this->oContribuinte->getIdUsuarioContribuinte());
    $this->oCompetencia->setTipo(Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE);
    $this->oCompetencia->setMes($this->iMes);
    $this->oCompetencia->setAno($this->iAno);
    $this->oCompetencia->setData_fechamento(new DateTime);
    $iSituacao = $this->oCompetencia->processSituacaoParaFechado();
    $this->oCompetencia->persist();

    return $iSituacao;
  }

  private function geraVinculoCompetenciaGuia($iCodigoGuia)
  {
    $oGuia = Contribuinte_Model_GuiaCompetencia::getById($iCodigoGuia);
    $oGuia->setCompetencia($this->oCompetencia->getEntityCompetencia());
    $oGuia->persist();
  }

  private function processaCancelamentoDebito(){

    if ($this->oCompetencia->getSituacao() == Contribuinte_Model_Competencia::SITUACAO_EM_ABERTO_SEM_MOVIMENTO) {
      $sDecricao = self::DESCRICAO_SEM_MOVIMENTO;
    } elseif ($this->oCompetencia->getSituacao() == Contribuinte_Model_Competencia::SITUACAO_EM_ABERTO_SEM_IMPOSTO) {
      $sDecricao = self::DESCRICAO_SEM_IMPOSTO;
    }

    $aParams  = array(
      'inscricaomunicipal' => $this->oContribuinte->getInscricaoMunicipal(),
      'mes'                => $this->iMes,
      'ano'                => $this->iAno,
      'descricao'          => $sDecricao
    );

    $oRetorno = WebService_Model_Ecidade::processar('CancelamentoISSQNVariavel', $aParams);
  }
}