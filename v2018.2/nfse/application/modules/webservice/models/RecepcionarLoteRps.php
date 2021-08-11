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
 * Modelo responsável pelo processamento dos métodos solicitados pelo cliente SOAP
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */
class WebService_Model_RecepcionarLoteRps {

  /**
   * Nome do arquivo xml sendo criado para processamento
   * @var string
   */
  private $sNomeArquivo = NULL;

  /**
   * Caminho completo do arquivo
   * @var string
   */
  private $sCaminhoNomeArquivo = NULL;

  /**
   * Modelo de importação dos dados
   * @var object
   */
  private $oModeloImportacao = NULL;

  /**
   * Dados do usuário que está tentando processar o arquivo
   * @var Object
   */
  private $oDadosUsuario = NULL;

  /**
   * Dados do Contribuinte que está sendo processado
   * @var Object
   */
  private $oContribuinte = NULL;

  /**
   * Construtor da classe
   */
  public function __construct() {
    $this->oModeloImportacao = new Contribuinte_Model_ImportacaoArquivoRpsModelo1();
  }

  /**
   * Prepara os dados para processar o arquivo do webservice
   *
   * @param string $sArquivo
   * @return bool
   * @throws Exception
   */
  public function preparaDados($sArquivo) {

    try {

      // Foi comentado o if de verificação pois estava ocorrendo um problema na emissão e retornava um arquivo em branco.
      // Somente em ambiente de desenvolvimento
      //if (APPLICATION_ENV == 'development') {

        $oDomDocument  = new DOMDocument();
        $oDomDocument->loadXml($sArquivo);

        $oData                 = new Zend_Date();
        $this->sNomeArquivo    = "/RecepcionarLote-{$oData->getTimestamp()}.xml";
        $this->sCaminhoArquivo = TEMP_PATH;

        /**
         * Verifica se o caminho do arquivo não existe recria a pasta
         */
        if (!file_exists($this->sCaminhoArquivo)) {
          mkdir($this->sCaminhoArquivo, 0777);
        }

        /**
         * Escreve os dados no arquivo
         */
        $this->sCaminhoNomeArquivo = $this->sCaminhoArquivo . $this->sNomeArquivo;
        $aArquivo                  = fopen($this->sCaminhoNomeArquivo, 'w');
        fputs($aArquivo, print_r($sArquivo, TRUE));
        fclose($aArquivo);
      //}

      $oValidacao = new DBSeller_Helper_Xml_AssinaturaDigital($sArquivo);

      /**
      * Validação digital do arquivo
      */
      if (!$oValidacao->validar()) {
        throw new Exception($oValidacao->getLastError());
      }
      $aAtributosUsuario = array(
                             'cnpj' => $oValidacao->getCnpj(),
                             'principal' => 'true'
                           );
      $aUsuario = Administrativo_Model_Usuario::getByAttributes($aAtributosUsuario);
      $oUsuario = $aUsuario[0];

      if (!is_object($oUsuario)) {
        throw new Exception('Usuário contribuinte não existe!', 157);
      }

      /**
       * Busca usuário contribuinte através do usuário cadastrado
       */
      $aUsuarioContribuinte = Administrativo_Model_UsuarioContribuinte::getByAttributes(
        array(
          'usuario'  => $oUsuario->getId(),
          'cnpj_cpf' => $oUsuario->getCnpj()
        )
      );

      if (!is_object($aUsuarioContribuinte[0])) {
        throw new Exception('Usuário contribuinte não encontrado!', 160);
      }

      /**
       * Seta os dados do contribuinte
       */
      $this->oDadosUsuario                         = $oUsuario;
      $this->oContribuinte->sCpfCnpj               = $aUsuarioContribuinte[0]->getCnpjCpf();
      $this->oContribuinte->iCodigoUsuario         = $oUsuario->getId();
      $this->oContribuinte->iIdUsuarioContribuinte = $aUsuarioContribuinte[0]->getId();

      /**
       * Atualiza os dados do contribuinte na sessão
       */
      $oSessao               = new Zend_Session_Namespace('nfse');
      $oSessao->contribuinte = Contribuinte_Model_Contribuinte::getById($this->oContribuinte->iIdUsuarioContribuinte);

      return TRUE;
    } catch (Exception $oErro) {
      throw new Exception($oErro->getMessage(), $oErro->getCode());
    }
  }

  /**
   * Processa o arquivo Webservice
   *
   * @return string
   * @throws Exception
   */
  public function processamentoArquivo() {

    try {

      /**
       * Verifica o nome do arquivo
       */
      if (!$this->sNomeArquivo) {
        $this->oModeloImportacao->setMensagemErro('E160');
      }

      /**
       * Verifica se existe algum registro de usuário
       */
      if (!is_object($this->oDadosUsuario)) {
        throw new Exception('Usuario não encontrado!', 157);
      }

      /**
       * Verifica se o usuário está autenticado
       */
      if (!$this->autenticaUsuario($this->oDadosUsuario->getLogin())) {
        $this->oModeloImportacao->setMensagemErro('E157', 'Usuario: ' . $this->oDadosUsuario->getLogin());
      }

      $this->oModeloImportacao->setArquivoCarregado($this->sCaminhoNomeArquivo);

      $oArquivoCarregado = $this->oModeloImportacao->carregar();

      /**
       * Verifica se o modelo está válido e processa o arquivo de importação
       */
      if ($oArquivoCarregado && !$this->oModeloImportacao->getErro() && $this->oModeloImportacao->validaArquivoCarregado()) {

        /**
         * Valida as regras de negócio e processa a importação
         */
        $oImportacaoProcessamento = new Contribuinte_Model_ImportacaoArquivoProcessamento();

        $oImportacaoProcessamento->setCodigoUsuarioLogado($this->oDadosUsuario->getId());

        $oImportacaoProcessamento->setArquivoCarregado($oArquivoCarregado);

        /**
         * Processa a importação
         */
        $oDadosImportacao = $oImportacaoProcessamento->processarImportacaoRps();

        return $this->oModeloImportacao->processaSucessoWebService($oDadosImportacao);
      } else {
        return $this->oModeloImportacao->processaErroWebService($oArquivoCarregado->lote->numero);
      }
    } catch (Exception $oErro) {
      throw new Exception($oErro->getMessage(), $oErro->getCode());
    }
  }

  /**
   * Carrega a autenticação do usuario de acordo com o retorno da validação do certificado
   *
   * @param string $sLoginUsuario
   * @throws Exception
   * @return boolean
   */
  public function autenticaUsuario($sLoginUsuario) {

    try {

      $oEntityManager = Zend_Registry::get('em');

      $oAuthAdapter   = new Doctrine_Auth_Adapter($oEntityManager, 'Administrativo\Usuario', 'login', 'senha');
      $oAuthAdapter->setIdentity($sLoginUsuario);
      $oAuthAdapter->setCredential('');

      $oAuth   = Zend_Auth::getInstance();
      $iStatus = $oAuth->authenticate($oAuthAdapter)->getCode();

      if (in_array($iStatus, array(1, -3))) {

        $sLogin = $oAuth->getIdentity();
        $oUser  = Administrativo_Model_Usuario::getByAttribute('login', $sLoginUsuario);

        if ($oUser && $oUser->getHabilitado()) {

          Zend_Auth::getInstance()->getStorage()->write(array('id' => $oUser->getId(), 'login' => $sLoginUsuario));
        } else {

          $this->oModeloImportacao->setMensagemErro('E157', 'Usuário não habilitado');
        }
      } else {
        $this->oModeloImportacao->setMensagemErro('E157', 'Usuário Inválido');
      }

      /**
       * Verifica se ocorreu algum erro no processamentos dos dados na importacao
       */
      if ($this->oModeloImportacao->getErro()) {
        return $this->oModeloImportacao->processaErroWebService(NULL);
      }

      /**
       * Reecreve os dados e permissões de sessão na ACL
       */
      new DBSeller_Acl_Setup(TRUE);

      /**
       * Verifica a permissão de execução da ação conforme liberação do usuário
      */
      $sAmbiente = Zend_Controller_Front::getInstance()->getRequest()->getActionName();

      if (!DBSeller_Plugin_Auth::checkPermission("webservice/{$sAmbiente}/recepcionar-lote-rps")) {
        return FALSE;
      }

      return TRUE;
    } catch (Exception $oErro) {
      throw new Exception($oErro->getMessage(), $oErro->getCode());
    }
  }
}