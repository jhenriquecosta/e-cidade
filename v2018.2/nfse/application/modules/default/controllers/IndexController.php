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
 * Class Default_IndexController
 *
 * @package Default/Controller
 * @see     Default_Lib_Controller_AbstractController
 */

/**
 * @package Default/Controller
 * @see     Default_Lib_Controller_AbstractController
 */
class Default_IndexController extends Default_Lib_Controller_AbstractController {

  /**
   * Página inicial do módulo padrão
   */
  public function indexAction() {

    // Verifica se o usuário está logado
    parent::checkIdentity();

    // Zera as permissões do contribuinte
    $oSessao                  = new Zend_Session_Namespace('nfse');
    $oSessao->contribuinte    = NULL;
    $this->view->contribuinte = NULL;
    $this->_session->id       = NULL;
    $this->view->iUsuarioEscolhido     = $oSessao->iUsuarioEscolhido;

    $aAuth = Zend_Session::namespaceGet('Zend_Auth');
    $oUsuario = Administrativo_Model_Usuario::getById($aAuth['storage']['id']);

    if ($oUsuario->getTipo() == 3) {

      $oBaseUrl = new Zend_View_Helper_BaseUrl();
      // Verifica se possui cadastros eventuais
      $aCadastrosEventuais = Contribuinte_Model_CadastroPessoa::getCadastrosParaLiberacao();

      if (count($aCadastrosEventuais) > 0) {

        $sMensagem = "Hà " . count($aCadastrosEventuais) . " Cadastros Eventuais Pendentes <br/>";
        $sMensagem .= " <a href=". $oBaseUrl->baseUrl("/fiscal/usuario-eventual/listar-novos-cadastros") ."> Verificar </a>";
        DBSeller_Plugin_Notificacao::addAviso('F001', $sMensagem);

      }

      // Verifica se possui solicitações de cancelamento
      $aSolicitacoesCancelamento = Contribuinte_Model_SolicitacaoCancelamento::getAll();

      if (count($aSolicitacoesCancelamento) > 0) {

        $sMensagem = "Hà " . count($aSolicitacoesCancelamento) . " Solicitações de cancelamento de NFS-e <br/>";
        $sMensagem .= " <a href=". $oBaseUrl->baseUrl("/fiscal/cancelamento-nfse/consultar") ."> Verificar </a>";
        DBSeller_Plugin_Notificacao::addAviso('F002', $sMensagem);

      }

    }

    // Tiver apenas um módulo redireciona para a default/index
    if (isset($this->view->user) && count($this->view->user->getModulos()) == 1) {

      $aModulos = each($this->view->user->getModulos());
      $sModulo  = strtolower($aModulos['value']->getNome());

      $this->_redirector->gotoSimple('index', 'index', $sModulo);
    }

    // Recria as permissões do usuário
    new DBSeller_Acl_Setup(TRUE);
  }

  /**
   * Página para autenticação de notas
   */
  public function autenticaAction() {

    // Desabilita o layout do sistema
    parent::noLayout();

    $sPrestadorCnpjCpf  = parent::getParam('prestador_cnpjcpf');
    $sNumeroRps         = parent::getParam('numero_rps');
    $sCodigoVerificacao = parent::getParam('codigo_verificacao');
    $sCodVer            = parent::getParam('cod_ver');
    $sCpfCnpj           = parent::getParam('cpfcnpj');

    if (!empty($sCodigoVerificacao) && !empty($sPrestadorCnpjCpf)) {
      $oNota = Contribuinte_Model_Nota::getByPrestadorAndCodigoVerificacao($sPrestadorCnpjCpf, $sCodigoVerificacao);
    } else if (!empty($sCodVer) && !empty($sCpfCnpj)) {
      $oNota = Contribuinte_Model_Nota::getByPrestadorAndCodigoVerificacao($sCodVer, $sCpfCnpj);
    } else {
      $oNota = Contribuinte_Model_Nota::getByPrestadorAndNumeroRps($sPrestadorCnpjCpf, $sNumeroRps);
    }

    $oPrefeitura            = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    $this->view->aDadosNota = Contribuinte_Model_Nota::getDadosEmissao($sCodigoVerificacao, $oNota, $oPrefeitura);

    $this->view->setBasePath(APPLICATION_PATH . '/modules/contribuinte/views/');

    $sHtml = $this->view->render("pdf/nota_modelo_{$oPrefeitura->getModeloImpressaoNfse()}.phtml");

    echo $sHtml;
  }

  /**
   * Renderiza a tela para Cadastro de Pessoa [View]
   */
  public function cadastroAction() {

    $this->view->form = new Administrativo_Form_CadastroPessoa();
  }

  /**
   * Processa o submit do cadastro de pessoa [ajax]
   */
  public function cadastroSalvarAction() {

    $aDados = $this->getRequest()->getPost();

    $oForm = new Administrativo_Form_CadastroPessoa();
    $oForm->carregarCidades($aDados['estado'], $aDados['cidade']);

    // Verifica se deve validar o combo ou campo texto para o bairro e endereço
    if (isset($aDados['cod_bairro']) && !empty($aDados['cod_bairro'])) {

      $oForm->getElement('bairro')->setRequired(FALSE);
      $oForm->carregarBairros($aDados['cidade']);
      $oForm->carregarEnderecos($aDados['cod_bairro']);
    }

    if (isset($aDados['bairro']) && !empty($aDados['bairro'])) {
      $oForm->getElement('cod_bairro')->setRequired(FALSE);
    }

    // Popula o formulario
    $oForm->populate($aDados);

    // Valida o formulario
    if ($oForm->isValid($aDados)) {

      $oCadastro = new Administrativo_Model_Cadastro();
      $oCadastro->persist($aDados);

      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['success'] = 'Requisição de emissão de DMS enviada.';
    } else {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = 'Preencha os dados corretamente.';
    }

    // Retorna um json com mensagens de erro ou sucesso
    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Exibe o arquivo de Nota em PDF
   *
   * @todo Verificar locais de chamada do metodo e alterar para um nome relacionado a funcao
   */
  public function getAction() {

    $this->_helper->viewRenderer->setNoRender();
    $this->_helper->layout->disableLayout();

    $sNomeArquivo = $this->getRequest()->getParam('file');
    $sNomeArquivo = TEMP_PATH . "/{$sNomeArquivo}";
    $oPonteiro    = fopen($sNomeArquivo, 'r');
    $oArquivo     = fread($oPonteiro, filesize($sNomeArquivo));
    $oResponse    = $this->getResponse();
    $oResponse->setHeader('Content-type', 'application/pdf', TRUE);
    $oResponse->setBody($oArquivo);
    $oResponse->outputBody();
  }

  /**
   * Retorna as notificações do usuár
   */
  public function notificacoesAction() {

    parent::checkIdentity();

    $this->view->notif = Default_Model_Notificacao::getNotificacoesUsuario($this->view->user);
  }
}