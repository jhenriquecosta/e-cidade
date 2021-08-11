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
 * Formulário para authenticação de usuários
 *
 * @package Auth/Form
 */

/**
 * @package Auth/Form
 */
class Auth_form_login_FormLogin extends Twitter_Bootstrap_Form_Vertical {

  protected $idCaptcha = null;

  /**
   * Construtor da classe
   *
   * @see Twitter_Bootstrap_Form_Vertical
   * @return Auth_form_login_FormLogin|void
   */
  public function init() {

    $oTradutor      = $this->getTranslator();
    $oBaseUrlHelper = new Zend_View_Helper_BaseUrl();

    $this->setName('form_login')->setAction($oBaseUrlHelper->baseUrl('/auth/login/post'));

    $oElm = $this->createElement('text', 'login');
    $oElm->setLabel('Login');
    $oElm->setAttrib('class', 'span3');
    $oElm->setAttrib('autofocus', 'autofocus');
    $oElm->setRequired(TRUE);
    $this->addElement($oElm);

    $oElm = $this->createElement('password', 'senha');
    $oElm->setLabel('Senha');
    $oElm->setAttrib('class', 'span3');

    // Obriga senha em ambiente de produção
    if (APPLICATION_ENV == 'production') {
      $oElm->setRequired(TRUE);
    }

    $this->addElement($oElm);

    $iTotalErros = 0;

    if ($oSessao = new Zend_Session_Namespace('captcha')) {
      $iTotalErros = $oSessao->errors;
    }

    if ($iTotalErros > 0 ) {

      $oKeysRecaptcha = Zend_Registry::get('config')->recaptcha;

      if (!empty($oKeysRecaptcha->publicKey) && !empty($oKeysRecaptcha->privateKey)) {

        $oRecaptcha = new Zend_Service_ReCaptcha($oKeysRecaptcha->publicKey, $oKeysRecaptcha->privateKey);
        $oRecaptcha->setOption('theme', 'clean');

        $oCaptcha = new Zend_Form_Element_Captcha(
          'challenge',
          array(
            'captcha'        => 'ReCaptcha',
            'captchaOptions' => array(
              'captcha'      => 'ReCaptcha',
              'service'      => $oRecaptcha
            )
          )
        );
        $oCaptcha->setLabel('Informe as palavras abaixo:');

        $this->addElement($oCaptcha);
      } else {
        $oSessao->errors = 0;
      }
    }

    // Verifica se o captcha está ativo, para exibilo na tela
    $oTentativas = Zend_Session::namespaceGet('tentativas');
    if (isset($oTentativas['ativo'])) {

      $this->setCaptcha();

    }

    $this->addElement('submit', 'submit', array(
      'label'             => 'Entrar',
      'class'             => 'pull-right',
      'data-loading-text' => $oTradutor->_('Aguarde...'),
      'buttonType'        => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY
    ));

    return $this;
  }

  public function setCaptcha() {

    $oCaptchaElm = new DBSeller_Plugin_Captcha();

    $oCaptchaElm->setLabel('Informe as palavras abaixo:');

    $this->addElement($oCaptchaElm);

    return $oCaptchaElm;

  }
}
