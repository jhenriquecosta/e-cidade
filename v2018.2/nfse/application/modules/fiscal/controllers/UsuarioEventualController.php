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
 * Controller para controle de solicitações de usuários eventuais no sistema,
 * 
 * @package Fiscal/Controller
 */

/**
 * @package Fiscal/Controller
 * @author Iuri Guntchnigg <iuri@dbseller.com.br>
 */
class Fiscal_UsuarioEventualController extends Fiscal_Lib_Controller_AbstractController {
  
  /**
   * Utilizado pelo Zend como construtor da classe
   * 
   * @return void
   */
  public function init() {
    
    parent::init();
    
    $this->sHost     = Zend_Registry::get('config')->ecidadeonline2->endereco;
    $this->oDoctrine = Zend_Registry::get('em');
  }

  /**
   * Retorna a lista de Usuários nao liberados pelo fiscal
   * 
   * @return void
   */
  public function listarNovosCadastrosAction() {
    
    $aListaCadastrosLiberar            = Contribuinte_Model_CadastroPessoa::getCadastrosParaLiberacao();
    $this->view->aListaCadastroLiberar = $aListaCadastrosLiberar;
  }

  /**
   * Modal para liberação do cadastro de usuário
   * 
   * @throws Exception
   */
  public function liberarCadastroAction() {
    
    parent::noTemplate();
    
    $aDados = $this->getRequest()->getParams();
    $oForm  = new Fiscal_Form_CadastroPessoaLiberacao();
    $oForm->populate($aDados);
    
    if (!is_numeric($aDados['id'])) {
      throw new Exception($this->translate->_('Identificador de cadastro inválido.'));
    }
    
    $oCadastroPessoa = new Contribuinte_Model_CadastroPessoa($aDados['id']);
    
    if (!is_object($oCadastroPessoa) || is_null($oCadastroPessoa)) {
      throw new Exception($this->translate->_('Cadastro não encontrado no sistema.'));
    }
    
    $oCgm = Contribuinte_Model_Cgm::getDadosCgm($oCadastroPessoa->getCpfcnpj());
    
    // Se o usuário já possuir um CGM, oculta a geração de CGM no eCidade
    $oForm->carregarTipoLiberacao(is_object($oCgm));
    
    $this->view->form = $oForm;
  }
  
  /**
   * Realiza a liberação do cadastro do pessoa
   * 
   * @throws Exception
   * @return void
   */
  public function liberarCadastroSalvarAction() {
    
    parent::noLayout();
    
    $aDados = $this->getRequest()->getParams();
    $oCgm   = Contribuinte_Model_Cgm::getDadosCgm($aDados['cnpjcpf']);
    $oForm  = new Fiscal_Form_CadastroPessoaLiberacao();
    $oForm->carregarTipoLiberacao(is_object($oCgm));
    $oForm->populate($aDados);
    
    // Valida o formulario e gera a requisicao
    if ($oForm->isValid($aDados)) {
      
      try {
        
        $this->oDoctrine->getConnection()->beginTransaction();

        $oCadastroPessoa = new Contribuinte_Model_CadastroPessoa($aDados['id']);

        $this->validarLiberacaoUsuario($oCadastroPessoa);

        $sHashLiberacao = $oCadastroPessoa->criarHashParaLiberacao();
        $sHost          = "/default/cadastro-eventual/verificacao/hash/{$sHashLiberacao}";

        if ($oCadastroPessoa->LiberarCadastro($aDados['tipo_liberacao'], $sHashLiberacao)) {
        
          $this->view->sTextoEmail  = 'Vimos através deste, renovar os votos de apreço e informar-lhe que para liberar ';
          $this->view->sTextoEmail .= 'seu acesso as facilidades do Portal da NFs-e, deverá clicar no link abaixo:';
          $this->view->sLinkSenha   = $this->view->serverUrl($sHost);
          $this->view->setScriptPath(APPLICATION_PATH.'/modules/default/views/scripts/cadastro-eventual/');
          
          $sTextoEmail = $this->view->render('email-aviso-contribuinte.phtml');
          $lEmail      = DBSeller_Helper_Mail_Mail::send(
            $oCadastroPessoa->getEmail(),
            $this->translate->_('ECidadeOnline2 - Confirmação de Cadastro'),
            $sTextoEmail
          );
          
          if (!$lEmail) {
            throw new Exception($this->translate->_('Email não enviado. Favor Contate Suporte Prefeitura.'));
          }
        }
        
        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['reload']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('Liberação do cadastro efetuada com sucesso.');
        
        $this->oDoctrine->getConnection()->commit();
      } catch (Exception $eErro) {
        
        $this->oDoctrine->getConnection()->rollback();
        
        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $eErro->getMessage();
      }
    } else {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = 'Preencha os dados corretamente.';
    }
    
    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
  
  /**
   * Modal para recusa do cadastro de pessoa
   * 
   * @return void
   */
  public function recusarCadastroAction() {
    
    parent::noTemplate();
    
    $aDados = $this->getRequest()->getParams();
    $oForm  = new Fiscal_Form_CadastroPessoaRecusa();
    $oForm->populate($aDados);
    
    $this->view->form = $oForm;
  }
  
  /**
   * Realiza a recusa do cadastro da pessoa
   * 
   * @throws Exception
   * @return void
   */
  public function recusarCadastroSalvarAction() {
    
    parent::noLayout();
    
    $aDados       = $this->getRequest()->getParams();
    $aRetornoJson = NULL;
    $oForm        = new Fiscal_Form_CadastroPessoaRecusa();
    $oForm->populate($aDados);

    // Valida o formulario e gera a requisicao
    if ($oForm->isValid($aDados)) {
    
      try {
        
        $this->oDoctrine->getConnection()->beginTransaction();
        
        $oCadastroPessoa = new Contribuinte_Model_CadastroPessoa($aDados['id']);
        
        $this->validarLiberacaoUsuario($oCadastroPessoa);
        
        if ($oCadastroPessoa->bloquearCadastro($aDados['justificativa'])) {
          
          $this->view->setScriptPath(APPLICATION_PATH.'/modules/default/views/scripts/cadastro-eventual/');
          
          $this->view->sTextoRecusa = $aDados['justificativa'];
          $sTextoEmail              = $this->view->render('email-aviso-recusa-cadastro.phtml');
          
          $lEmail = DBSeller_Helper_Mail_Mail::send(
            $oCadastroPessoa->getEmail(),
            $this->translate->_('ECidadeOnline2 - Retorno de Solicitação de Cadastro'),
            $sTextoEmail
          );
          
          if (!$lEmail) {
            throw new Exception($this->translate->_('Email não enviado. Favor Contate Suporte Prefeitura.'));
          }
          
          $aRetornoJson['status']  = TRUE;
          $aRetornoJson['reload']  = TRUE;
          $aRetornoJson['success'] = $this->translate->_(
            'A Recusa do cadastro foi efetuada. Um email com a justificativa foi enviado ao contribuinte.'
          );
        }
        
        $this->oDoctrine->getConnection()->commit();
      } catch (Exception $eErro) {
        
        $this->oDoctrine->getConnection()->rollback();
        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $eErro->getMessage();
      }
    } else {
      
      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = 'Preencha os dados corretamente.';
    }
    
    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
  
  /**
   * Retorna os dados do cadastro da pessoa e do CGM para avaliacao dos dados
   * 
   * @return void
   */
  public function compararAction() {
    
    parent::noTemplate();
    
    $oDadosRequisicao = $this->getRequest();
    
    if ($oDadosRequisicao->getParam('id') != '') {
      
      $oCadastroPessoa = new Contribuinte_Model_CadastroPessoa($oDadosRequisicao->getParam('id'));
      $oCgm            = Contribuinte_Model_Cgm::getDadosCgm($oCadastroPessoa->getCpfcnpj());
      
      $this->view->oCadastroPessoa = $oCadastroPessoa;
      $this->view->oCGM            = $oCgm ? $oCgm : new Contribuinte_Model_Cgm();
    }
  }
    
  /**
   * Verifica se o cadastro está apto a ser liberado/bloqueado
   * 
   * @param Contribuinte_Model_CadastroPessoa $oCadastroPessoa
   * @throws Exception
   * @return void
   */
  protected function validarLiberacaoUsuario(Contribuinte_Model_CadastroPessoa $oCadastroPessoa) {
    
    if ($oCadastroPessoa->getEntity()->getTipoLiberacao() != '') {
      
      $sTextoLiberacao = '';
      
      switch ($oCadastroPessoa->getEntity()->getTipoLiberacao()) {
        
        case Contribuinte_Model_CadastroPessoa::TIPO_LIBERACAO_USUARIO:
        case Contribuinte_Model_CadastroPessoa::TIPO_LIBERACAO_USUARIO_CGM:
          
          $sTextoLiberacao = ' já consta como liberado. Procedimento cancelado';
          break;
          
        case Contribuinte_Model_CadastroPessoa::TIPO_LIBERACAO_USUARIO_BLOQUEADO:
          
          $sTextoLiberacao = ' já consta como bloqueado. Procedimento cancelado';
          break;
      }
      
      $sErroMensagem = "Cadastro do Contribuinte {$oCadastroPessoa->getEntity()->getNome()} {$sTextoLiberacao}";
      
      throw new Exception($sErroMensagem);
    }
  }
}