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
 * Description of CadastroController
 *
 * @author guilherme
 */
class Administrativo_CadastroController extends Administrativo_Lib_Controller_AbstractController {
  
  public function indexAction() {
    $this->view->cadastros = Administrativo_Model_Cadastro::getAll();
  }
  
  public function editarAction() {
    
    if ($this->getRequest()->isPost()) {
      
      $oForm = new Administrativo_Form_Cadastro(TRUE);
      $oForm->setAction($this->view->baseUrl('/administrativo/cadastro/editar'));
      $this->view->form = $oForm;
      
      if ($this->_getParam('status') == 'aprovado') {
        $this->view->messages[] = array('success' => 'Usuário aprovado com sucesso.');
      } else if ($this->_getParam('status') == 'recusado') {
        $this->view->messages[] = array('success' => 'Cadastro recusado com sucesso.');
      } else {
        
        $aDados = $this->_getAllParams();
        $oForm->preenche($aDados);
        
        if (isset($aDados['cancel'])) {
          self::recusarUsuario();
        } elseif (isset($aDados['submit']) && 
                  $oForm->isValid($aDados) && 
                  $aDados['senha'] == $aDados['senha_confirma']) {
          
          self::aprovarUsuario();
          
          // Redireciona com status de sucesso
          $this->_request->clearParams()->setPost(array('status' => 'true'));
          $this->_forward('editar', 'cadastro', 'administrativo');
        } else {
          $this->view->messages[] = array('error' => 'Preencha o formulário corretamente.');
        }
      }
    } else {
      
      $id               = $this->_getParam('id');
      $cadastro         = Administrativo_Model_Cadastro::getById($id);
      $this->view->form = $this->cadastroForm($cadastro);
    }
  }
  
  private function aprovarUsuario() {
    
    // Atualiza Cadastro
    $iId       = $this->_getParam('id');
    $oCadastro = Administrativo_Model_Cadastro::getById($iId);
    $oCadastro->setStatus('1');
    $oCadastro->persist();
    
    $oFilterDigits = new Zend_Filter_Digits();
    $oFilterTrim   = new Zend_Filter_StringTrim();
    
    // Cadastra Usuario
    $aDados                 = $this->_getAllParams();
    $aUsuario['id_perfil']  = $oFilterDigits->filter($aDados['id_perfil']);
    $aUsuario['tipo']       = $oFilterDigits->filter($aDados['tipo']);
    $aUsuario['cnpj']       = $oFilterDigits->filter($aDados['cpfcnpj']);
    $aUsuario['login']      = $oFilterTrim->filter($aDados['login']);
    $aUsuario['senha']      = $oFilterTrim->filter($aDados['senha']);
    $aUsuario['nome']       = $oFilterTrim->filter($aDados['nome']);
    $aUsuario['email']      = $oFilterTrim->filter($aDados['email']);
    $aUsuario['fone']       = $oFilterDigits->filter($aDados['telefone']);
    
    $oUsuario  = new Administrativo_Model_Usuario();
    $oUsuario->persist($aUsuario);
  }
  
  private function recusarUsuario() {
    
    // Atualiza Cadastro
    $iId       = $this->_getParam('id');
    $oCadastro = Administrativo_Model_Cadastro::getById($iId);
    $oCadastro->setStatus('0');
    $oCadastro->persist();
    
    // Redireciona URL
    $aParams = array('status' => 'recusado', 'id' => $iId);
    
    $this->_helper->redirector('editar', 'cadastro', 'administrativo', $aParams);
  }    
  
  private function cadastroForm($oCadastro) {
   
    $oForm  = new Administrativo_Form_Cadastro(TRUE);
    $oForm->setAction($this->view->baseUrl('/administrativo/cadastro/editar'));
    $aDados = array(
      'id'             => $oCadastro->getId(),
      'tipo'           => $oCadastro->getTipo(),
      'cpfcnpj'        => $oCadastro->getCpfcnpj(),
      'login'          => $oCadastro->getLogin(),
      'nome'           => $oCadastro->getNome(),
      'nome_fantasia'  => $oCadastro->getNomeFantasia(),
      'estado'         => $oCadastro->getEstado(),
      'cidade'         => $oCadastro->getCidade(),
      'cep'            => $oCadastro->getCep(),
      'cod_bairro'     => $oCadastro->getCodBairro(),
      'bairro'         => $oCadastro->getBairro(),
      'cod_endereco'   => $oCadastro->getCodEndereco(),
      'endereco'       => $oCadastro->getEndereco(),
      'numero'         => $oCadastro->getNumero(),
      'complemento'    => $oCadastro->getComplemento(),
      'telefone'       => $oCadastro->getTelefone(),
      'email'          => $oCadastro->getEmail()
    );
    
    $iCodigoIbge = Administrativo_Model_Prefeitura::getDadosPrefeituraBase()->getIbge();
    
    if ($iCodigoIbge == $aDados['cidade']) {
      
      $aDados['bairro']    = NULL;
      $aDados['endereco']  = NULL;
      
      $elmBairro = $oForm->getElement('bairro');
      $elmBairro->clearErrorMessages();
      $elmBairro->clearValidators();
      $elmBairro->setRequired(FALSE);
      
      $elmEndereco = $oForm->getElement('endereco');
      $elmEndereco->clearErrorMessages();
      $elmEndereco->clearValidators();
      $elmEndereco->setRequired(FALSE);
    } else {
      
      $aDados['cod_bairro']    = NULL;
      $aDados['cod_endereco']  = NULL;
      
      $elmBairro = $oForm->getElement('cod_bairro');
      $elmBairro->clearErrorMessages();
      $elmBairro->clearValidators();
      $elmBairro->setRequired(FALSE);
      
      $elmEndereco = $oForm->getElement('cod_endereco');
      $elmEndereco->clearErrorMessages();
      $elmEndereco->clearValidators();
      $elmEndereco->setRequired(FALSE);
    }
    
    $oForm->preenche($aDados);
    
    return $oForm;
  }
}