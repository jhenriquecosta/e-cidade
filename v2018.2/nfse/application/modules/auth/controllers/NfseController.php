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
 * Controle das autenticações de NFSe's
 *
 * @package Auth/Controllers
 */

/**
 * @package Auth/Controllers
 */
class Auth_NfseController extends Auth_Lib_Controller_AbstractController {

  /**
   * Construtor da classe
   *
   * @see Auth_Lib_Controller_AbstractController::init()
   */
  public function init() {

    parent::init();
  }

  /**
   * Tela para autenticação de NFSe
   */
  public function autenticarAction() {

    $this->view->form = new Auth_Form_nfse_FormAutenticacao();
  }

  /**
   * Processa a autenticação de NFSe
   */
  public function autenticarPostAction() {

    $aDadosRequest          = $this->getRequest()->getParams();
    $aRetornoJson['status'] = FALSE;
    $oForm                  = new Auth_Form_nfse_FormAutenticacao();
    $oForm->populate($aDadosRequest);

    // Valida o "codigo de verificação" ou "número da RPS" está preenchido
    if (!$oForm->getElement('codigo_verificacao')->getValue() && !$oForm->getElement('numero_rps')->getValue()) {

      $aRetornoJson['fields']  = array('codigo_verificacao', 'numero_rps');
      $aRetornoJson['error'][] = $this->translate->_('Informe o Número do RPS ou o Código de Verificação.');

      echo $this->getHelper('json')->sendJson($aRetornoJson);
    }

    // Valida o restante do formulário
    if ($oForm->isValid($aDadosRequest)) {

      $sPrestadorCnpj     = $oForm->getElement('prestador_cnpjcpf')->getValue();
      $sNumeroRps         = $oForm->getElement('numero_rps')->getValue();
      $sCodigoVerificacao = $oForm->getElement('codigo_verificacao')->getValue();

      if ($sCodigoVerificacao) {
        $uNota = Contribuinte_Model_Nota::getByPrestadorAndCodigoVerificacao($sPrestadorCnpj, $sCodigoVerificacao);
      } else {
        $uNota = Contribuinte_Model_Nota::getByPrestadorAndNumeroRps($sPrestadorCnpj, $sNumeroRps);
      }

      if (is_object($uNota) || is_array($uNota)) {

        // Url criptografada
        $aUrlVerificacao = DBSeller_Helper_Url_Encrypt::encrypt(array('module'     => 'default',
                                                                      'controller' => 'index',
                                                                      'action'     => 'autentica',
                                                                      'url'        => $aDadosRequest));
        $aRetornoJson['status'] = TRUE;
        $aRetornoJson['url']    = $aUrlVerificacao;
      } else {

        $sMensagemErro           = 'Nenhum registro foi encontrado, verifique os dados informados e tente novamente.';
        $aRetornoJson['error'][] = $this->translate->_($sMensagemErro);
      }
    } else {

      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = $this->translate->_('Preencha os dados corretamente.');
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
}