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
 * Classe responsável pelo processamento das consultas solicitadas no SOAP server
 * @author Lucas Dumer <lucas.dumer@dbseller.com.br>
 */
final class WebService_Model_Integracao extends WebService_Lib_Models_Webservice {

  /**
   * Verifica se usuário e senha da conexão no SOAP server estão corretos
   * @return boolean
   */
  protected function acessoAutenticacaoUsuarioSenhaSoap(){

    if((empty($_SERVER['PHP_AUTH_USER']) || empty($_SERVER['PHP_AUTH_PW'])) ||
        $_SERVER['PHP_AUTH_USER'] != hash('sha256', 'ecidade') ||
        $_SERVER['PHP_AUTH_PW']   != hash('sha256', 'integracao')
      ){
      throw new SoapFault('Usuário da conexão inválido!', 101);
    }

    return true;
  }

  /**
   * Verifica se acesso é autenticado
   * @return boolean
   */
  protected function acessoAutenticado(){

    if($this->lAutenticacao != true){
      throw new Exception('Autenticação negada!', 104);
    }

    return $this->lAutenticacao;
  }

  /**
   * Autenticação do token enviado por header na conexão SOAP
   * @param string $sToken
   */
  public function Autenticacao($sToken){

    try {

      $this->lAutenticacao = false;

      if($this->acessoAutenticacaoUsuarioSenhaSoap()){

        $sCookie = Administrativo_Model_ParametroPrefeitura::getCookieIntegracao();

        if(empty($sCookie)){
          throw new SoapFault('Chave de acesso temporaria expirou!', 102);
        }

        if($sCookie != $sToken){
          throw new SoapFault("Chave de acesso inválida!\n Comunique o administrador do sistema na instituição.", 103);
        }
      }

      $this->lAutenticacao = true;
    } catch(SoapFault $oErro){
      return new SoapFault($oErro->faultstring, $oErro->faultcode);
    }
  }

  /**
   * Disponibiliza a consulta de token de acesso
   * @param  string $sXml
   * @return string
   */
  public function Acesso($sXml){

    try {

      if($this->acessoAutenticacaoUsuarioSenhaSoap()){

        $oImportacaoArquivoAcessoIntegracao = new WebService_Model_ImportacaoArquivoAcessoIntegracao();
        $oAcessoIntegracao = new WebService_Model_AcessoIntegracao($oImportacaoArquivoAcessoIntegracao);

        $oRetorno = $oAcessoIntegracao->getByXml($sXml);

        return $this->retornoMensagemSucesso($oRetorno);
      }
    } catch(SoapFault $oErro){
      return new SoapFault($oErro->faultcode, $oErro->faultstring);
    }
  }

  /**
   * Disponibiliza a consulta das notas irregulares
   * @param  string $sXml
   * @return string
   */
  public function NotasIrregularidades($sXml){

    try {

      if($this->acessoAutenticado()){

        $oImportacaoArquivoNotasIrregularidades = new WebService_Model_ImportacaoArquivoNotasIrregularidades();
        $oConsultarNotasIrregularidades = new WebService_Model_ConsultarNotasIrregularidades($oImportacaoArquivoNotasIrregularidades);

        $oRetorno = $oConsultarNotasIrregularidades->getByXml($sXml);

        return $this->retornoMensagemSucesso($oRetorno);
      }
    } catch(Exception $oErro){
      return $this->retornoMensagemErro($oErro->getMessage(), $oErro->getCode());
    }
  }

  /**
   * Disponibiliza a consulta de RPS processadas fora do prazo
   * @param  string $sXml
   * @return string
   */
  public function RpsForaPrazo($sXml){

    try {

      if ($this->acessoAutenticado()){

        $oImportacaoArquivoRpsForaPrazo = new WebService_Model_ImportacaoArquivoRpsForaPrazo();
        $oConsultarRpsForaPrazo = new WebService_Model_ConsultarRpsForaPrazo($oImportacaoArquivoRpsForaPrazo);

        $oRetorno = $oConsultarRpsForaPrazo->getByXml($sXml);
        return $this->retornoMensagemSucesso($oRetorno);
      }
    } catch(Exception $oErro){
      return $this->retornoMensagemErro($oErro->getMessage(), $oErro->getCode());
    }
  }

  /**
   * Disponibiliza a consulta de quantidade de RPS emitidas por contribuinte
   * @param  string $sXml
   * @return string
   */
  public function QuantidadeRps($sXml){

    try {

      if ($this->acessoAutenticado()){

        $oImportacaoQuantidadeRps = new WebService_Model_ImportacaoArquivoQuantidadeRps();
        $oQuantidadeRps           = new WebService_Model_ConsultarQuantidadeRps($oImportacaoQuantidadeRps);

        $oRetorno = $oQuantidadeRps->getByXml($sXml);
        return $this->retornoMensagemSucesso($oRetorno);
      }
    } catch(Exception $oErro){
      return $this->retornoMensagemErro($oErro->getMessage(), $oErro->getCode());
    }
  }

  /**
   * Disponibiliza a consulta de comparativo de retenções
   * @param  string $sXml
   * @return string
   */
  public function ComparativoRetencao($sXml) {

    try {

      if ($this->acessoAutenticado()){

        $oImportacaoComparativoRetencao = new WebService_Model_ImportacaoArquivoComparativoRetencao();
        $oComparativoRetencao           = new WebService_Model_ConsultarComparativoRetencao($oImportacaoComparativoRetencao);

        $oRetorno = $oComparativoRetencao->getByXml($sXml);
        return $this->retornoMensagemSucesso($oRetorno);
      }
    } catch(Exception $oErro){
      return $this->retornoMensagemErro($oErro->getMessage(), $oErro->getCode());
    }
  }


  /**
   * Disponibilizamos a consulta de competencias encerradas
   * @param  string  $sXml
   * @return string
   */
  public function CompetenciasEncerradas( $sXml ) {

    try {

      if ( $this->acessoAutenticado() ) {

        $oImportacaoCompetenciasEncerradas = new WebService_Model_ImportacaoArquivoCompetenciasEncerradas();
        $oCompetenciasEncerradas           = new WebService_Model_ConsultarCompetenciasEncerradas($oImportacaoCompetenciasEncerradas);

        $oRetorno = $oCompetenciasEncerradas->getByXml($sXml);
        return $this->retornoMensagemSucesso($oRetorno);
      }

    } catch (Exception $oErro) {
      return $this->retornoMensagemErro($oErro->getMessage(), $oErro->getCode());
    }
  }

  /**
   * Disponibilizamos a consulta dos valores movimentados dos contribuintes para a prestação de contas
   * @param  string  $sXml
   * @return string
   */
  public function PrestacaoContas( $sXml ) {

    try {

      if ( $this->acessoAutenticado() ) {

        $oImportacaoPrestacaoContas = new WebService_Model_ImportacaoArquivoPrestacaoContas();
        $oPrestacaoContas           = new WebService_Model_ConsultarPrestacaoContas($oImportacaoPrestacaoContas);

        $oRetorno = $oPrestacaoContas->getByXml($sXml);
        return $this->retornoMensagemSucesso($oRetorno);
      }

    } catch (Exception $oErro) {
      return $this->retornoMensagemErro($oErro->getMessage(), $oErro->getCode());
    }
  }
}