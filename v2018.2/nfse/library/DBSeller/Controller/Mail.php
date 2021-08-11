<?php 

class DBSeller_Controller_Mail extends Zend_Controller_Action_Helper_Abstract {

  const ENCODE                           = 'UTF-8';
  const ERRO_VALIDACAO_CAMPO_OBRIGATORIO = 'Erro no email, campo %s é obrigatório.';
  const SUCESSO_ENVIO                    = 'Email enviado com sucesso!';
  
  /**
   * Instancia da View Conteudo do email
   * @var Zend_View
   */
  private $oViewEmail = NULL;
  
  /**
   * Variaveis para ser utilizada no envio do email
   * @var Array
   */
  private $aVariaveis = array();
  
  /**
   * Nome do Template que será utilizado
   * @var String
   */
  private $sTemplate = NULL;
  
  /**
   * Objeto Email para envio
   * @var Zend_Mail
   */
  private $oEmail = NULL;
  
  /**
   * Arquivos em anexo no email
   * @var Object
   */
  private $oArquivoAnexo = NULL;
  
  /**
   * Dados com a configuração do email
   * @var Object
   */
  private $oConfiguracaoEmail = NULL;
  
  /**
   * Método utilizado para o envio
   * @var Zend_Mail_Transport_Abstract
   */
  private $oMetodoTransporte = NULL;
  
  /**
   * Campos Obrigatórios para envio do email
   * @var array
   */
  private static $aCamposObrigatorios = array('sEmailDestino',
                                                 'sNomeDestino',  
                                                 'sAssunto',
                                                 'sEmailOrigem',
                                                 'sNomeOrigem');
  /**
   * Construtor da Classe
   * @return void
   */
  public function __construct (array $aDadosEnvio) {
    
    $this->setConfiguracaoEmail(Zend_Registry::get('config')->resources->mail);
    $this->setMetodoTrasnporte();
    
    if (count($aDadosEnvio) != 5) {
      
      throw new Zend_Mail_Exception('Quantidade de parâmetros está errada!');
    }  
    
    $this->oViewEmail = new Zend_View();
    $this->oEmail     = new Zend_Mail(self::ENCODE);
    $this->validaCamposObrigatorios($aDadosEnvio);
    
  }
  
  
  /**
   * Define as Variaveis para envio de email
   * @param String $sNome
   * @param String $sValor
   * @return void
   */
  public function setVariaveis ($sNome, $sValor) {
    
    $this->oViewEmail->{$sCampo} = $sValor;
  }
  
  /**
   * Método Responsável pelo Envio
   * @return boolean
   * @throws Zend_Mail_Exception
   */
  public function envia () {
    
    try {
      
      //$oConteudoEmail = $this->oViewEmail->setScriptPath ($this->sTemplate);
      
      //if (isset($this->oDadosView->oArquivoAnexo)) { 
      //  
      //  $this->oEmail->createAttachment ($this->getArquivoAnexo());
      //}
      
      $sConteudoEmail = $this->oViewEmail->render (APPLICATION_PATH . '/../public/templates/' . $this->getTemplate());
      
      if ($this->getConfiguracaoEmail()->formato == 'html') {

        $this->oEmail->setBodyHtml ($sConteudoEmail);
      } else {
        
        $this->oEmail->setBodyText ($sConteudoEmail);
      }
      
      $this->oEmail->setFrom($this->oViewEmail->sEmailOrigem,
                             $this->oViewEmail->sNomeOrigem);

      $this->oEmail->setReplyTo($this->oViewEmail->sEmailOrigem,
                                $this->oViewEmail->sNomeOrigem);
      
      $this->oEmail->addTo($this->oViewEmail->sEmailDestino,
                           $this->oViewEmail->sNomeDestino);
      
      $this->oEmail->setSubject($this->oViewEmail->sAssunto);
      
      $this->oEmail->send($this->getMetodoTransporte());
      
      $oRetorno->mensage = self::SUCESSO_ENVIO;
      $oRetorno->status  = true; 
      
      return $oRetorno;
      
    } catch (Zend_Mail_Exception $oErro) {
      
      throw new Zend_Mail_Exception($oErro);
    }
  }

  /**
   * Define o Template que será utilizado
   * @param unknown $sTemplateNome
   * @return void
   */
  public function setTemplate ($sTemplate) {
  
    if (!empty($sTemplate)) {
      
      $this->sTemplate = $sTemplate;
    } else {
      
      $this->sTemplate = 'padrao.phtml';
    }
  }
  
  
  public function getTemplate () {
    
    return $this->sTemplate;
  }
  
  
  
  /**
   * Define o Arquivo em anexo no email
   * @param String $sArquivo
   * @return void
   */
  public function setArquivoAnexo (String $sArquivo) {
    
    $oArquivo = new stdClass();
    
    $oArquivoAnexo->sFileContents = file_get_contents ($sArquivo);
    $oArquivoAnexo->sNomeArquivo  = "NotaNfseAAHAHHAHAHA.pdf";
    
  }
  
  /**
   * Retorna o Arquivo em Anexo
   * @return Object
   */
  private function getArquivoAnexo () {
    
    return $oArquivoAnexo;
  }

  /**
   * Carrega a configuração definida a partir da configuração do sistema
   * @param Object $oConfiguracaoIni
   * @return void
   * @throws Zend_Mail_Exception
   */
  private function setConfiguracaoEmail ($oConfiguracaoIni) {
    
    if (empty($oConfiguracaoIni)) {
      
      throw new Zend_Mail_Exception('Parametros de email não configurados!');
    }
    
    $this->oConfiguracaoEmail->sHost = $oConfiguracaoIni->host;
    $this->oConfiguracaoEmail->sMetodo = $oConfiguracaoIni->metodo;
    
    $this->setTemplate($oConfiguracaoIni->template);
    
    $this->oConfiguracaoEmail->aDadosLogin = array(
    
      'port'     => "{$oConfiguracaoIni->porta}",
      'username' => "{$oConfiguracaoIni->usuario}",
      'password' => "{$oConfiguracaoIni->senha}"
    );
        
  }
  
  /**
   * Retorna a configuração do email
   * @return Object
   */
  private function getConfiguracaoEmail () {
    
    return $this->oConfiguracaoEmail;
  }

  /**
   * Valida os Dados para envio
   * @param array $aDados
   * @throws Zend_Mail_Exception
   */
  private function validaCamposObrigatorios (array $aDados) {

    foreach(self::$aCamposObrigatorios as $sValor) {
      
      if (empty($aDados[$sValor])) {
        
        throw new Zend_Mail_Exception(
          sprintf(self::VALIDACAO_DADOS_ERRO,
                  $sValor)
        );
      }
    }
    
    return true;
  }
  
  /**
   * Define o Metodo de Envio
   * @return void
   * @throws Zend_Mail_Exception
   */
  private function setMetodoTrasnporte () {
    
    $sMetodo = $this->getConfiguracaoEmail()->sMetodo;
    
    if (empty($sMetodo)) {
      
      throw new Zend_Mail_Exception('Metodo de envio não configurado!');
    }
    
    
    if ($this->getConfiguracaoEmail()->sMetodo == 'smtp') {
      
      $this->oMetodoTransporte =  new Zend_Mail_Transport_Smtp($this->getConfiguracaoEmail()->sHost,
                                                          $this->getConfiguracaoEmail()->aDadosLogin);
    } else {
      
      throw new Zend_Mail_Exception('Metodo de envio definido incorretamente!');
    }
  }
  
  /**
   * Retorna o Metodo de Envio
   * @return Object
   */
  private function getMetodoTransporte () {
    
    return $this->oMetodoTransporte;
  }
  


}