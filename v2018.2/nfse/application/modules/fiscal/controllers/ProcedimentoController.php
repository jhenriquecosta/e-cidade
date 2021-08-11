<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2017  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa é software livre; voce pode redistribui-lo e/ou
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
 * Class Fiscal_ProcedimentoController
 *
 * @package Fiscal\Controllers\ProcedimentoController
 */
class Fiscal_ProcedimentoController extends Fiscal_Lib_Controller_AbstractController {

  private $PERFIS_PERMITIDOS = array(3, 5);

  /**
   * Metodo para verificar se o usuario tem permissao de usar as rotinas do suporte
   */
  private function autenticaPermissao() {

    $oUsuarioLogado = $this->usuarioLogado;
    if (!in_array($oUsuarioLogado->getPerfil()->getId(), $this->PERFIS_PERMITIDOS) || $oUsuarioLogado->getLogin() !== 'dbseller') {
      $this->_redirector->gotoSimple('index', 'logout', 'auth');
    }

  }

  public function cancelaNotaAction() {

    $lErro = false;
    $sMsg = "";

    $oFormProcedimentoCancelaNota = new Fiscal_Form_ProcedimentoCancelaNota();

    if ($this->getRequest()->isPost()) {

      $oDoctrine = Zend_Registry::get('em');
      $oDoctrine->getConnection()->beginTransaction();

      try {

        $aDados = $this->getRequest()->getParams();

        if (!$oFormProcedimentoCancelaNota->isValid($aDados)) {
          throw new Exception("Necessário preencher todos os campos para efetuar o cancelamento!");
        }

        $iIdContribuinte = $aDados["id_contribuinte"];
        $iNota           = $aDados["nota"];
        $iMotivo         = $aDados["motivo"];
        $sJustificativa  = $aDados["justificativa"];

        $aParametros = array (
          "id_contribuinte" => $iIdContribuinte,
          "nota"            => $iNota
        );

        $aNota = Contribuinte_Model_Nota::getByAttributes($aParametros);

        if (empty($aNota)) {
          throw new Exception("Nota não encontrada para este contribuinte!");
        }

        $oNota = $aNota[0];

        if ($oNota->getCancelada()) {
          throw new Exception("Nota já esta cancelada!");
        }

        $aLoginUsuario     = Zend_Auth::getInstance()->getIdentity();
        $oUsuario          = Administrativo_Model_Usuario::getByAttribute("login", $aLoginUsuario["login"]);
        $oDataCancelamento = new DateTime();

        $oCancelamentoNota = new Contribuinte_Model_CancelamentoNota();

        $oCancelamentoNota->setUsuarioCancelamento($oUsuario);
        $oCancelamentoNota->setNotaCancelada($oNota);
        $oCancelamentoNota->setMotivoCancelmento($iMotivo);
        $oCancelamentoNota->setJustificativa($sJustificativa);
        $oCancelamentoNota->setDataHora($oDataCancelamento);
        $oCancelamentoNota->salvar();

        $oDoctrine->getConnection()->commit();

        $oFormProcedimentoCancelaNota->reset();
        $sMsg = "NFS-e cancelada com sucesso!";
      } catch (Exception $oError) {

        $lErro = true;
        $sMsg = $oError->getMessage();
        $oDoctrine->getConnection()->rollback();
      }
    }

    $this->view->lErro = $lErro;
    $this->view->sMsg = $sMsg;
    $this->view->oFormProcedimentoCancelaNota = $oFormProcedimentoCancelaNota;
  }

  public function aberturaCompetenciaAction() {

    $lErro = false;
    $sMsg = "";

    $oFormProcedimentoAberturaCompetencia = new Fiscal_Form_ProcedimentoAberturaCompetencia();

    if ($this->getRequest()->isPost()) {

      $oDoctrine = Zend_Registry::get("em");
      $oDoctrine->getConnection()->beginTransaction();

      try {

        $aDados = $this->getRequest()->getParams();

        if (!$oFormProcedimentoAberturaCompetencia->isValid($aDados)) {
          throw new Exception("Necessário preencher todos os campos para efetuar o procedimento!");
        }

        $iIdContribuinte = $aDados["id_contribuinte"];
        $iAnoCompetencia = $aDados["ano_competencia"];
        $iMesCompetencia = $aDados["mes_competencia"];

        $oContribuinte = Contribuinte_Model_Contribuinte::getById($iIdContribuinte);

        $lExisteEncerramento = Contribuinte_Model_Competencia::existeEncerramento($oContribuinte, $iMesCompetencia, $iAnoCompetencia);

        if (!$lExisteEncerramento) {
          throw new Exception("Competência informada não está encerrada!");
        }

        $oCompetencia = new Contribuinte_Model_Competencia($iAnoCompetencia, $iMesCompetencia, $oContribuinte);

        $lExisteGuiaEmitida = $oCompetencia->existeGuiaEmitida();

        if ($lExisteGuiaEmitida) {

          $sSql  = " (select u.id                                          ";
          $sSql .= "    from Administrativo\UsuarioContribuinte u          ";
          $sSql .= "   where u.cnpj_cpf = (                                ";
          $sSql .= "          select u2.cnpj_cpf                           ";
          $sSql .= "            from Administrativo\UsuarioContribuinte u2 ";
          $sSql .= "           where u2.id = ".$iIdContribuinte."))        ";

          $oQueryBuilder = $oDoctrine->createQueryBuilder();

          $oQueryBuilder->select("g")
                        ->from("Contribuinte\Guia", "g")
                        ->where("g.id_contribuinte in ".$sSql)
                        ->andWhere("g.tipo_documento_origem = ".Contribuinte_Model_Guia::$DOCUMENTO_ORIGEM_NFSE)
                        ->andWhere("g.mes_comp = ".$iMesCompetencia)
                        ->andWhere("g.ano_comp = ".$iAnoCompetencia);

          $aGuias = $oQueryBuilder->getQuery()->getResult();

          foreach ($aGuias as $iIndex => $oGuia) {
            $aGuias[$iIndex] = new Contribuinte_Model_Guia($oGuia);
          }

          $aGuiasAtualizadas = Contribuinte_Model_Guia::atualizaSituacaoGuias($aGuias, count($aGuias), 1);

          Contribuinte_Model_Guia::atualizaValorPagamentoParcialGuiasEmAberto($aGuiasAtualizadas);

          $aGuias = $oQueryBuilder->getQuery()->getResult();

          foreach ($aGuias as $iIndex => $oGuia) {
            $aGuias[$iIndex] = new Contribuinte_Model_Guia($oGuia);
          }

          $lGuiaPaga = false;

          foreach ($aGuias as $oGuia) {

            if ($oGuia->getPagamentoParcial()
             or $oGuia->getSituacao() == Contribuinte_Model_Guia::$PAGA
             or $oGuia->getValorPago() > 0
            ) {
              $lGuiaPaga = true;
            }
          }

          if ($lGuiaPaga) {

            $oDoctrine->getConnection()->commit();
            throw new Exception("Competência informada possui guia paga!", 666);
          } else {

            $lGuiasZeradas = true;

            foreach ($aGuias as $oGuia) {

              $aParametros = array(
                "numpre"  => $oGuia->getNumpre(),
                "parcela" => $oGuia->getMesComp()
              );

              $lRetornoWebService = WebService_Model_Ecidade::processar("zerarParcelaISSQNVariavel", $aParametros);

              if (!$lRetornoWebService) {
                $lGuiasZeradas = false;
              }
            }

            if ($lGuiasZeradas) {

              foreach ($aGuias as $oGuia) {
                $oGuia->destroy();
              }

            } else {
              throw new Exception("Não foi possível executar o procedimento!");
            }
          }
        }

        $sSql  = " delete from competencias                               ";
        $sSql .= "  where competencias.id_contribuinte in (               ";
        $sSql .= "         select id                                      ";
        $sSql .= "           from usuarios_contribuintes                  ";
        $sSql .= "          where usuarios_contribuintes.cnpj_cpf = (     ";
        $sSql .= "                 select cnpj_cpf                        ";
        $sSql .= "                   from usuarios_contribuintes          ";
        $sSql .= "                  where id = :id_contribuinte           ";
        $sSql .= "                )                                       ";
        $sSql .= "        )                                               ";
        $sSql .= "    and competencias.ano = :ano                         ";
        $sSql .= "    and competencias.mes = :mes                         ";

        $aParametros = array(
          "id_contribuinte" => $iIdContribuinte,
          "ano"             => $iAnoCompetencia,
          "mes"             => $iMesCompetencia
        );

        $oStmt = $oDoctrine->getConnection()->prepare($sSql);
        $oStmt->execute($aParametros);

        $oDoctrine->getConnection()->commit();

        $oFormProcedimentoAberturaCompetencia->reset();
        $sMsg = "Competência aberta com sucesso!";
      } catch (Exception $oError) {

        $lErro = true;
        $sMsg = $oError->getMessage();

        if ($oError->getCode() != 666) {
          $oDoctrine->getConnection()->rollback();
        }
      }
    }

    $this->view->lErro = $lErro;
    $this->view->sMsg = $sMsg;
    $this->view->oFormProcedimentoAberturaCompetencia = $oFormProcedimentoAberturaCompetencia;
  }

  public function alteracaoRegimeNotasSimplesAction ()
  {
    $this->autenticaPermissao();

    $oForm = new Fiscal_Form_ProcedimentoAlteracaoRegimeNotaSimples();

    $this->view->oFormProcedimentoAlteracaoRegimeNotaSimples = $oForm;

  }

  /**
   * Action para consultar o cadastro do simples nacional do contribuinte
   * selectionado e retornar para a view por ajax
   * @return JSON Retorno
   */
  public function consultaCadastroSimplesNacionalUsuarioAction()
  {
    $this->autenticaPermissao();

    parent::noLayout();

    $aRetornoJson = array();
    $aRetornoJson['status']  = FALSE;

    try {

      $aDados = $this->getRequest()->getParams();

      if (empty($aDados['id_usuario'])) {
        throw new Exception('Contribuinte não selecionado');
      }

      /* Consulta os dados da empresa */
      $oUsuario = Administrativo_Model_Usuario::getById((int) $aDados['id_usuario']);
      $aEmpresa = $oUsuario->getContribuintes();

      if (empty($aEmpresa)) {
        throw new Zend_Controller_Exception('Contribuinte não cadastrado no sistema.');
      }

      $oEmpresa = $aEmpresa[key($aEmpresa)];

      /* Obtem cadastro do simples nacional */
      $aCadastroSimplesNacional = $oEmpresa->getCadastroSimplesNacional();
      if (empty($aCadastroSimplesNacional)) {
        throw new Zend_Controller_Exception('Contribuinte sem cadastro no Simples Nacional.');
      }

      $aRetornoCadastroSimples = array();

      /* Formata informações do cadastro */
      foreach ($aCadastroSimplesNacional as $oCadastroSimplesNacional) {

        $oDataInicio = new Zend_Date($oCadastroSimplesNacional->data_inicial);
        $oCadastroSimplesNacional->data_inicial = $oDataInicio->toString('dd/MM/y');

        $sDataBaixa = 'Ativa';
        if (!empty($oCadastroSimplesNacional->data_baixa)) {
          $oDataBaixa = new Zend_Date($oCadastroSimplesNacional->data_baixa);
          $sDataBaixa = $oDataBaixa->toString('dd/MM/y');
        }
        $oCadastroSimplesNacional->data_baixa = $sDataBaixa;

        $oCadastroSimplesNacional->categoria = Contribuinte_Model_ContribuinteAbstract::getCategoriaSimplesByCodigo($oCadastroSimplesNacional->categoria);

        $aRetornoCadastroSimples[] = $oCadastroSimplesNacional;
      }

      $aRetornoJson['status'] = TRUE;
      $aRetornoJson['dados']    = $aRetornoCadastroSimples;

    } catch(Zend_Controller_Exception $oError) {

      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['messages'][] = $oError->getMessage();

    } catch(Exception $oError) {
      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['messages'][] = $oError->getMessage();
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Action para processar a alteracao de Notas
   * @return JSON Retorno
   */
  public function processaAlteracaoRegimeNotasSimplesAction()
  {
    $time_start = microtime(true);
    $this->autenticaPermissao();

    parent::noLayout();

    $aRetornoJson = array();
    $aRetornoJson['status']  = FALSE;

    try {

      $aDados = $this->getRequest()->getParams();

      if (empty($aDados['id_usuario'])) {
        throw new Exception('Contribuinte não selecionado');
      }

      /* Consulta os dados da empresa */
      $oUsuario = Administrativo_Model_Usuario::getById((int) $aDados['id_usuario']);
      $aEmpresa = $oUsuario->getContribuintes();

      if (empty($aEmpresa)) {
        throw new Zend_Controller_Exception('Contribuinte não cadastrado no sistema.');
      }

      $oEmpresa = $aEmpresa[key($aEmpresa)];
      /* Verifica se é uma instancia de Contribuinte_Model_Contribuinte */
      if (!$oEmpresa  instanceof Contribuinte_Model_Contribuinte) {
        throw new Zend_Controller_Exception('Erro ao obter informações do contribuinte.');
      }

      /* Obtem cadastro do simples nacional */
      $aCadastroSimplesNacional = $oEmpresa->getCadastroSimplesNacional();
      if (empty($aCadastroSimplesNacional)) {
        throw new Zend_Controller_Exception('Contribuinte sem cadastro no Simples Nacional.');
      }

      /* Instancia a classe para o procedimento de correcao  */
      $oProcedimentoAlterarRegimeSimples = new Fiscal_Model_ProcedimentoAlterarRegimeNotaSimples($oEmpresa);

      /* Inicia o processamento */
      $oRetornoProcessamento = $oProcedimentoAlterarRegimeSimples->processaAlteracaoRegime();

      if (!$oRetornoProcessamento->sucesso) {
        throw new Zend_Exception($oRetornoProcessamento->mensagem);
      }


      $aRetornoJson['status']                            = TRUE;
      $aRetornoJson['dados']['competencias']   = $oRetornoProcessamento->competencias;
      $aRetornoJson['dados']['inconsistencias'] = $oRetornoProcessamento->inconsistencias;
      $aRetornoJson['messages'][]                    = $oRetornoProcessamento->mensagem;
      if (count($oRetornoProcessamento->inconsistencias) > 0) {
        $aRetornoJson['messages'][]                  = 'Não foi possível efetuar a correção das notas a seguir: ';
      }
      $time_end = microtime(true);
      $execution_time = ($time_end - $time_start);
      $aRetornoJson['time'] = $execution_time;

    } catch(Zend_Controller_Exception $oError) {

      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['messages'][] = $oError->getMessage();

    } catch(Exception $oError) {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['messages'][] = $oError->getMessage();

    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);

  }
}
