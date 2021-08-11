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
 * Classe responsável pelo cadastro de usuários eventuais
 *
 * @package Default/Controllers
 */

/**
 * @package Default/Controllers
 */
class Default_CadastroEventualController extends Default_Lib_Controller_AbstractController {

  /**
   * Construtor da classe
   *
   * @see Default_Lib_Controller_AbstractController::init()
   * @return void
   */
  public function init() {

    parent::init();

    // Altera para utilizar o layout do módulo de "Auth"
    $this->_helper->layout->setLayoutPath(APPLICATION_PATH . '/modules/auth/views/scripts/layouts/');
    $this->_helper->layout->setLayout('layout');
  }

  /**
   * Tela de Cadastro de Usuário Eventual
   *
   * @return void
   */
  public function indexAction() {

    $this->view->oForm = new Administrativo_Form_CadastroPessoa();
  }

  /**
   * Método para persistir os dados do cadastro eventual [Json]
   *
   * @return void
   */
  public function salvarAction() {

    $aDados = $this->getAllParams();
    $oForm  = new Administrativo_Form_CadastroPessoa();

    // Carrega a lista de cidade e seta os selecionados
    if (!empty($aDados['estado']) && !empty($aDados['cidade'])) {
      $oForm->carregarCidades($aDados['estado'], $aDados['cidade']);
    }

    // Se informado o bairro pelo combo, retira a validação do campo texto
    if (isset($aDados['cod_bairro']) && !empty($aDados['cod_bairro'])) {

      $oForm->getElement('bairro')->setRequired(FALSE);
      $oForm->carregarBairros($aDados['cidade']);
    }

    // Se informado o bairro pelo campo texto, retira a validação do combo
    if (isset($aDados['bairro']) && !empty($aDados['bairro'])) {
      $aDados['bairro'] = substr($aDados['bairro'], 0, 40);
      $oForm->getElement('cod_bairro')->setRequired(FALSE);
    }

    // Se informado o bairro pelo combo, retira a validação do campo texto
    if (isset($aDados['cod_endereco']) && !empty($aDados['cod_endereco'])) {

      $oForm->getElement('endereco')->setRequired(FALSE);
      $oForm->carregarEnderecos($aDados['cod_endereco']);
    }

    // Se informado o bairro pelo campo texto, retira a validação do combo
    if (isset($aDados['endereco']) && !empty($aDados['endereco'])) {
      $oForm->getElement('cod_endereco')->setRequired(FALSE);
    }

    // Remove validação se não informar o número do endereço
    if (empty($aDados['numero'])) {
      $oForm->getElement('numero')->setRequired(FALSE);
      $aDados['numero'] = '0';
    }

    if ($aDados['id_perfil'] == 6) {

      $oForm->getElement('cnpjcpf')->removeDecorator('DBSeller_Validator_CpfCnpj');
      $oForm->getElement('cnpjcpf')->addValidator(new DBSeller_Validator_Cnpj());
    } else {
      $oForm->getElement('cnpjcpf')->addValidator(new DBSeller_Validator_CpfCnpj());
    }

    // Popula o formulario
    $oForm->populate($aDados);

    // Valida o formulario
    if ($oForm->isValid($aDados)) {

      // Recupera os parametros, limpando as máscaras com filters do form
      $aDados    = $oForm->getValues();

      // Recupera as configurações do doctrine e inicia a transação
      $oDoctrine = Zend_Registry::get('em');
      $oDoctrine->getConnection()->beginTransaction();

      try {

        $aUsuarioEmail = Administrativo_Model_Usuario::getByAttribute('email', $aDados['email']);

        if (count($aUsuarioEmail) > 0) {

          $sUrl = '<a href="' . $this->view->serverUrl('/auth/login/esqueci-minha-senha/') . '">Clique Aqui</a>';

          $sMensagemErro = 'Já encontramos um cadastro com este email.<br>';
          $sMensagemErro .= "Caso tenha esquecido sua senha. {$sUrl}";

          throw new Exception($this->translate->_($sMensagemErro));
        }

        $aUsuarioSistema = Administrativo_Model_Usuario::getByAttribute('login', $aDados['cnpjcpf']);

        if (count($aUsuarioSistema) > 0) {

          $sMensagemErro = 'Já encontramos um cadastro com essas informações.<br>';
          $sMensagemErro .= 'Entre em contato com a prefeitura para maiores informações.';

          throw new Exception($this->translate->_($sMensagemErro));
        }

        $sHash                = NULL;
        $oParametosPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();

        if (!$oParametosPrefeitura->getVerificaAutocadastro()) {

          $sHash                    = hash('whirlpool', $aDados['cnpjcpf'] . time() . $aDados['email']);
          $aDados['tipo_liberacao'] = Contribuinte_Model_CadastroPessoa::TIPO_LIBERACAO_USUARIO_CGM;
        }

        $aDados['hash'] = $sHash;
        $oCadastro      = new Contribuinte_Model_CadastroPessoa();
        $oCadastro->setDadosEventual($aDados);
        $oCadastro->persist();

        if ($oParametosPrefeitura->getVerificaAutocadastro()) {

          $sTextoEmail      = $this->view->render('cadastro-eventual/email-aviso-fiscal.phtml');
          $aUsuariosFiscais = Administrativo_Model_Usuario::getByAttribute('perfil', 5);

          // Cria um array, mesmo quando for somente um objeto
          if (is_object($aUsuariosFiscais)) {
            $aUsuariosFiscais = array($aUsuariosFiscais);
          }

          if (is_array($aUsuariosFiscais)) {

            foreach ($aUsuariosFiscais as $oUsuarioFiscal) {

              // Envia email apenas para os fiscais habilitados
              if ($oUsuarioFiscal->getHabilitado()) {

                DBSeller_Helper_Mail_Mail::send(
                                         $oUsuarioFiscal->getEmail(),
                                         $this->translate->_('ECidadeOnline2 - Solicitação de Contribuinte Eventual'),
                                         $sTextoEmail);
              }
            }
          }

          // Envio do email para o contribuinte, avisando da  espera do envio do email
          $sTextoEmail = $this->view->render('cadastro-eventual/email-aviso-espera-liberacao-contribuinte.phtml');

          DBSeller_Helper_Mail_Mail::send($aDados['email'],
                                          $this->translate->_('ECidadeOnline2 - Solicitação de Cadastro'),
                                          $sTextoEmail);
        } else {

          //link base do sistema + caminho para geração de senha
          $this->view->sLinkSenha = $this->view->serverUrl("/default/cadastro-eventual/verificacao/hash/{$sHash}");
          $sTextoEmail            = $this->view->render('cadastro-eventual/email-aviso-contribuinte.phtml');

          $lEmail = DBSeller_Helper_Mail_Mail::send($aDados['email'],
                                                    $this->translate->_('ECidadeOnline2 - Confirmação de Cadastro'),
                                                    $sTextoEmail);

          if (!$lEmail) {
            throw new Exception($this->translate->_('Email não enviado. Favor contate o suporte da prefeitura.'));
          }
        }

        $sMensagemErro = 'Cadastro efetuado com sucesso.<br>';
        $sMensagemErro .= 'Siga as instruções enviadas para o seu email para continuar o cadastro.';

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['url']     = $this->view->serverUrl();
        $aRetornoJson['success'] = $this->translate->_($sMensagemErro);

        $oDoctrine->getConnection()->commit();
      } catch (Exception $oErro) {

        $oDoctrine->getConnection()->rollback();

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $oErro->getMessage();
      }
    } else {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = $this->translate->_('Preencha os dados corretamente.');
    }

    // Retorna um json com mensagens de erro ou sucesso
    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Tela para verificação do status da liberação de cadastro
   *
   * @throws Exception
   * @return void
   */
  public function verificacaoAction() {

    $sHash           = $this->_getParam('hash', NULL);
    $oCadastroPessoa = Contribuinte_Model_CadastroPessoa::getByAttribute('hash', $sHash);

    if (empty($oCadastroPessoa)) {
      throw new Exception($this->translate->_('Liberação cancelada ou já efetuada.'));
    }

    $aDados            = $this->getAllParams();
    $aDados['cnpjcpf'] = DBSeller_Helper_Number_Format::maskCPF_CNPJ($oCadastroPessoa->getCpfcnpj());

    $oFormVerificacao = new Default_Form_LiberacaoCadastro();
    $oFormVerificacao->populate($aDados);

    $this->view->form = $oFormVerificacao;
  }

  /**
   * Método para confirmação do usuário eventual [json]
   *
   * @throws Exception
   * @return void
   */
  public function confirmarAction() {

    $oFiltro  = new Zend_Filter_Digits();
    $aDados   = $this->getRequest()->getParams();
    $sCpfCnpj = DBSeller_Helper_Number_Format::unmaskCPF_CNPJ($aDados['cnpjcpf']);

    // Popula o formulario
    $oForm = new Default_Form_LiberacaoCadastro();
    $oForm->populate($aDados);

    // Valida o formulario
    if ($oForm->isValid($aDados)) {

      if ($aDados['hash'] == NULL || $sCpfCnpj == NULL) {
        throw new Exception($this->translate->_('Campo(s) obrigatório(s) não informado(s).'));
      }

      $oDoctrine = Zend_Registry::get('em');
      $oDoctrine->getConnection()->beginTransaction();

      try {

        $oCadastroPessoa = Contribuinte_Model_CadastroPessoa::getByAttribute('hash', $aDados['hash']);

        if ($oCadastroPessoa == NULL) {

          $sMensagemErro = 'Dados informados não encontrados. Favor entrar em contato com o suporte da prefeitura.';
          throw new Exception($this->translate->_($sMensagemErro));
        }

        $iTipoLiberacaoUsuarioBloqueado = Contribuinte_Model_CadastroPessoa::TIPO_LIBERACAO_USUARIO_BLOQUEADO;

        if ($oCadastroPessoa->getTipoLiberacao() == $iTipoLiberacaoUsuarioBloqueado) {

          $sMensagemErro = 'Cadastro foi recusado. Favor entrar em contato com o setor de fiscalização.';
          throw new Exception($this->translate->_($sMensagemErro));
        }

        if ($sCpfCnpj != $oCadastroPessoa->getCpfcnpj()) {
          throw new Exception($this->translate->_('CNPJ/CPF informado não é o mesmo informado no cadastro.'));
        }

        $oUsuarioCadastrado = Administrativo_Model_Usuario::getByAttribute('email', $oCadastroPessoa->getEmail());

        if ($oUsuarioCadastrado instanceof Administrativo_Model_Usuario) {

          $sLink = '<a href="' . $this->view->serverUrl('/auth/login/esqueci-minha-senha/') . '">Clique Aqui</a>';

          $sMensagemErro = "Já encontramos um cadastro com este email.<br>Caso tenha esquecido sua senha. {$sLink}";

          throw new Exception($this->translate->_($sMensagemErro));
        }

        $oCgm = Contribuinte_Model_Cgm::getDadosCgm($sCpfCnpj);

        if ($oCadastroPessoa->getTipoLiberacao() == Contribuinte_Model_CadastroPessoa::TIPO_LIBERACAO_USUARIO &&
          $oCgm == NULL
        ) {

          $sErro = $this->translate->_('Parametros estão inválidos (CGM não existe), ');
          $sErro .= $this->translate->_('favor entrar em contato com o setor de fiscalização.');

          throw new Exception($sErro);
        }

        if ($oCadastroPessoa->getTipoLiberacao() == Contribuinte_Model_CadastroPessoa::TIPO_LIBERACAO_USUARIO_CGM &&
          $oCgm == NULL
        ) {

          $oNovoCgm = new Contribuinte_Model_Cgm();

          if (strlen($oCadastroPessoa->getCpfCnpj()) >= 14) {

            $oNovoCgm->setJuridico(TRUE);
            $oNovoCgm->setCNPJ($oCadastroPessoa->getCpfCnpj());
          } else {

            $oNovoCgm->setJuridico(FALSE);
            $oNovoCgm->setCPF($oCadastroPessoa->getCpfCnpj());
          }

          $sDescricaoMunicipio = Default_Model_Cadendermunicipio::getById($oCadastroPessoa->getCidade())->getNome();

          $oNovoCgm->setNome($oCadastroPessoa->getNome());
          $oNovoCgm->setEmail($oCadastroPessoa->getEmail());
          $oNovoCgm->setCodigoIbgeCidade($oCadastroPessoa->getCidade());
          $oNovoCgm->setDescricaoMunicipio($sDescricaoMunicipio);
          $oNovoCgm->setEstado($oCadastroPessoa->getEstado());
          $oNovoCgm->setTelefone($oFiltro->filter($oCadastroPessoa->getTelefone()));
          $oNovoCgm->setCep($oFiltro->filter($oCadastroPessoa->getCep()));
          $oNovoCgm->setEnderecoEcidade(FALSE);

          if ($oCadastroPessoa->getCodBairro()) {
            $oNovoCgm->setEnderecoEcidade(TRUE);
          }

          $oNovoCgm->setCodigoBairro($oCadastroPessoa->getCodBairro());
          $oNovoCgm->setCodigoLogradouro($oCadastroPessoa->getCodEndereco());
          $oNovoCgm->setDescricaoBairro($oCadastroPessoa->getBairro());
          $oNovoCgm->setDescricaoLogradouro($oCadastroPessoa->getEndereco());
          $oNovoCgm->setNumeroLogradouro($oCadastroPessoa->getNumero());
          $oNovoCgm->setComplemento($oCadastroPessoa->getComplemento());

          $oCodigoCgm = $oNovoCgm->persist();
          $iCodigoCgm = $oCodigoCgm->codigo_cgm;
        } else {
          $iCodigoCgm = $oCgm->getCodigoCgm();
        }

        $aArraTipoLiberacao = array(
          Contribuinte_Model_CadastroPessoa::TIPO_LIBERACAO_USUARIO_CGM,
          Contribuinte_Model_CadastroPessoa::TIPO_LIBERACAO_USUARIO
        );

        if (in_array($oCadastroPessoa->getTipoLiberacao(), $aArraTipoLiberacao)) {

          // Usuário do sistema
          $oUsuarioSistema = new Administrativo_Model_Usuario();
          $oUsuarioSistema->setNome($oCadastroPessoa->getNome());
          $oUsuarioSistema->setTelefone($oFiltro->filter($oCadastroPessoa->getTelefone()));
          $oUsuarioSistema->setLogin($oCadastroPessoa->getCpfCnpj());
          $oUsuarioSistema->setSenha($aDados['senha']);
          $oUsuarioSistema->setEmail($oCadastroPessoa->getEmail());
          $oUsuarioSistema->setHabilitado(TRUE);
          $oUsuarioSistema->setAdministrativo(FALSE);
          $oUsuarioSistema->setTipo(Administrativo_Model_TipoUsuario::$CONTRIBUINTE);
          $oUsuarioSistema->setCgm($iCodigoCgm);
          $oUsuarioSistema->setCnpj($oCadastroPessoa->getCpfCnpj());
          $oUsuarioSistema->setPerfil($oCadastroPessoa->getPerfil()->getEntity());
          $oUsuarioSistema->setTentativa(0);
          $oUsuarioSistema->setPrincipal(1);
          $oUsuarioSistema->adicionaAcoes($oCadastroPessoa->getPerfil()->getAcoes());
          $oUsuarioSistema->persist();

          // Criamos o usuario eventual;
          $oUsuarioEventual = new Administrativo_Model_UsuarioContribuinte();
          $oUsuarioEventual->setCGM($iCodigoCgm);
          $oUsuarioEventual->setHabilitado(TRUE);
          $oUsuarioEventual->setTipoContribuinte(2);
          $oUsuarioEventual->setCnpjCpf($oCadastroPessoa->getCpfCnpj());
          $oUsuarioEventual->setUsuario($oUsuarioSistema->getEntity());
          $oUsuarioEventual->copiaPerfilAcoes($oCadastroPessoa->getPerfil());
          $oUsuarioEventual->persist();

          // Cadastro de Pessoa
          $oCadastroPessoa->setHash(NULL);
          $oCadastroPessoa->persist();
        }

        $oDoctrine->getConnection()->commit();

        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('Cadastro efetuado com sucesso.');
        $aRetornoJson['url']     = $this->view->serverUrl();
      } catch (Exception $oErro) {

        $oDoctrine->getConnection()->rollback();

        if (isset($oCodigoCgm) &&
          isset($oCodigoCgm->codigo_cgm) &&
          Contribuinte_Model_Cgm::removerCgm($oCodigoCgm->codigo_cgm)
        ) {

          $oLog = Zend_Registry::get('logger');
          $oLog->log("Erro ao excluir o CGM: {$oCodigoCgm->codigo_cgm}", Zend_Log::INFO, ' ');
        }

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $oErro->getMessage();
      }
    } else {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = $this->translate->_('Preencha os dados corretamente.');
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
}
