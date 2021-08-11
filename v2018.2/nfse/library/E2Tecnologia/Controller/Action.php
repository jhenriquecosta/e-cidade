<?php

class E2Tecnologia_Controller_Action extends Zend_Controller_Action {
  
  public function init() {
    
    $this->view->messages     = $this->_helper->getHelper('FlashMessenger')->getMessages();
    $this->_redirector        = $this->_helper->getHelper('Redirector');
    $this->_ajaxContext       = $this->_helper->getHelper('AjaxContext');
    
    // pega login do usuario para mostrar no layout
    $login = Zend_Auth::getInstance()->getIdentity();
    $this->view->user         = Administrativo_Model_Usuario::getByAttribute('login', $login['login']);
    $this->view->moduleName   = $this->getRequest()->getModuleName();
    
    // inicializa variavel sessao
    $this->_session           = new Zend_Session_Namespace('nfse');
    $this->view->contribuinte = $this->_session->contribuinte;
    
    // verifica quantidade de notificações para o usuário logado
    if ($this->view->user !== null) {
      
      $notificacoes = Default_Model_Notificacao::getNotificacoesUsuario($this->view->user);
      $this->view->qtd_notif  = count($notificacoes) == 0 ? '' : count($notificacoes);
      
    }
    
  }
  
  protected function checkIdentity() {
    
    if (!Zend_Auth::getInstance()->hasIdentity()) {
      
      $this->_helper->getHelper('FlashMessenger')->addMessage(array('error' => 'Você precisa estar logado para acessar essa página'));
      $this->_redirector->gotoSimple('login', 'index', 'default');
      
    }
  }
  
  /**
   * Seta o contexto da action e muda o layout da visao
   *
   * @param string $action Nome da action
   * @param string $method Metodo da action (JSON ou HTML)
   * @param string $layout Layout que sera usado no visao da action (so faz sentido quando o metodo e HTML)
   */
  protected function setAjaxContext($action, $method = 'json', $layout = null) {
    
    $this->_ajaxContext->addActionContext($action, $method)->initContext();
    
    if ($layout === null) {
      
      $this->_helper->viewRenderer->setNoRender();
      $this->_helper->layout->disableLayout();
      
    } else {
      
      $this->_helper->layout->setLayout($layout);
      
    }
    
  }
  
  protected function renderPdf($html, $filename, $options) {
    
    $this->_helper->viewRenderer->setNoRender();
    
    $margin_left   = isset($options['margins']['left'])    ? $options['margins']['left']   : 15;
    $margin_right  = isset($options['margins']['right'])   ? $options['margins']['right']  : 15;
    $margin_top    = isset($options['margins']['top'])     ? $options['margins']['top']    : 15;
    $margin_bottom = isset($options['margins']['bottom'])  ? $options['margins']['bottom'] : 15;
    $margin_header = isset($options['margins']['header'])  ? $options['margins']['header'] : 15;
    $margin_footer = isset($options['margins']['footer'])  ? $options['margins']['footer'] : 15;
    $format        = isset($options['format'])             ? $options['format']            : 'A4-L';
    $output_mode   = isset($options['output'])             ? $options['output']            : 'D';
    
    define('_MPDF_URI', APPLICATION_PATH . '/../library/MPDF54/');
    define('_MPDF_TEMP_PATH', '/var/www/tm/');
    
    require_once(APPLICATION_PATH . "/../library/MPDF54/mpdf.php");
    
    /* argumentos:
     * mode: codificacao (basicamente)
     * format: formato da pagina (pode ser adicionado -L depois do formato para forcar modo paisagem
     * tamanho da fonte: e passado 0 para que o tamanho seja setado no arquivo CSS
     * fonte
     * margin_left
     * margin_right
     * margin_top
     * margin_bottom
     * margin_header
     * margin_footer
     */
    $mpdf = new mPDF(
      'utf-8',
      $format,
      0,
      '',
      $margin_left,
      $margin_right,
      $margin_top,
      $margin_bottom,
      $margin_header,
      $margin_footer
    );
    $mpdf->ignore_invalid_utf8 = true;
    $mpdf->charset_in = 'utf-8';
    $mpdf->SetDisplayMode('fullpage', 'two');
    $mpdf->WriteHTML($mpdf->purify_utf8($html));
    $mpdf->Output($filename . '.pdf', $output_mode);
    exit();
    
  }
   
}
