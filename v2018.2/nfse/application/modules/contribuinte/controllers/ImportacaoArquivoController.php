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
 * Classe para importação de importação de arquivos
 * 
 * @package Contribuinte/Controllers
 */

class Contribuinte_ImportacaoArquivoController extends Contribuinte_Lib_Controller_AbstractController {
  
  /**
   * (non-PHPdoc)
   * @see Contribuinte_Lib_Controller_AbstractController::init()
   */
  public function init() {
    parent::init();
  }
  
  /**
   * Tela para importação de RPS
   * 
   * @return void
   */
  public function rpsAction() {
    
    $oForm = new Contribuinte_Form_ImportacaoArquivo();
    $oForm->renderizaCamposRPS();
    $oForm->setAction($this->view->baseUrl('/contribuinte/importacao-arquivo/rps-processar'));
    
    $this->view->oForm = $oForm;
  }
  
  /**
   * Processa os dados do formulário de importação de RPS [json]
   * 
   * @return void
   */
  public function rpsProcessarAction() {
    
    parent::noLayout();
    
    $oForm  = new Contribuinte_Form_ImportacaoArquivo();
    $oForm->renderizaCamposRPS();
    
    // Adiciona a validação do arquivo junto ao restante das mensagens de erro do form
    $aDados = array_merge(
      $this->getRequest()->getPost(),
      array('isUploaded' => $oForm->arquivo->isUploaded())
    );
    
    // Valida o formulario e processa a importação
    if ($this->getRequest()->isPost() && $oForm->arquivo->isUploaded()) {
      
      $oArquivoUpload = new Zend_File_Transfer_Adapter_Http();
      
      try {
        
        $oArquivoUpload->setDestination(APPLICATION_PATH . '/../public/tmp/');
        
        // Confirma o upload e processa o arquivo
        if ($oArquivoUpload->receive()) {
          
          $oImportacaoModelo1 = new Contribuinte_Model_ImportacaoArquivoRpsModelo1();
          $oImportacaoModelo1->setArquivoCarregado($oArquivoUpload->getFileName());
          
          $oArquivoCarregado = $oImportacaoModelo1->carregar();
          
          if ($oArquivoCarregado != NULL && $oImportacaoModelo1->validaArquivoCarregado()) {
            
            // Valida as regras de negócio e processa a importação
            $oImportacaoProcessamento = new Contribuinte_Model_ImportacaoArquivoProcessamento();
            
            $oImportacaoProcessamento->setCodigoUsuarioLogado($this->usuarioLogado->getId());
            $oImportacaoProcessamento->setArquivoCarregado($oArquivoCarregado);
            
            // Processa a importação
            $oImportacao = $oImportacaoProcessamento->processarImportacaoRps();
            
            if ($oImportacao->getId()) {
            
              $sUrlRecibo              = "/contribuinte/importacao-arquivo/rps-recibo/id/{$oImportacao->getId()}";
            
              $aRetornoJson['status']  = TRUE;
              $aRetornoJson['url']     = $this->view->baseUrl($sUrlRecibo);
              $aRetornoJson['success'] = $this->translate->_('Arquivo importado com sucesso.');
              
            } else {
              throw new Exception($this->translate->_('Ocorreu um erro ao importar o arquivo.'));
            }
          } else {
            throw new Exception($oImportacaoModelo1->processaErroSistema());
          }
        }
      } catch (DBSeller_Exception_ImportacaoXmlException $oErro) {
        
        $aRetornoJson['status'] = FALSE;
        $aRetornoJson['error']  = array_merge(
          array('<b>' . $this->translate->_('Ocorreu um erro ao importar o arquivo:') . '</b><br>'),
          $oErro->getErrors()
        );
      } catch (Exception $oErro) {
        
        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $oErro->getMessage();
      }
      
      if (is_file($oArquivoUpload->getFileName())) {
        unlink($oArquivoUpload->getFileName());
      }
    } else {
      
      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = $this->translate->_('Preencha os dados corretamente.');
    }
    
    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
  
  /**
   * Comprovante de importação de RPS
   */
  public function rpsReciboAction() {
    
    parent::noLayout();
    
    $iIdImportacao = $this->_getParam('id');
    $oDoctrine     = Zend_Registry::get('em');
    $oImportacao   = $oDoctrine->find('\Contribuinte\ImportacaoArquivo', $iIdImportacao);
    $oDadosUsuario = Administrativo_Model_Usuario::getById($oImportacao->getIdUsuario());
    $oPrefeitura   = Administrativo_Model_ParametroPrefeitura::getAll();
    
    // Dados da View
    $this->view->oImportacao      = $oImportacao;
    $this->view->oDadosUsuario    = $oDadosUsuario;
    $this->view->oDadosPrefeitura = $oPrefeitura[0];
    $this->view->sNomePrefeitura  = $oPrefeitura[0]->getEntity()->getNome();
    
    // Carrega a view do comprovante
    $sHtml = $this->view->render('importacao-arquivo/comprovante-importacao-rps.phtml');
    
    // Renderiza a view do comprovante
    $this->renderPdf($sHtml, 'comprovante-importacao-rps', array('format' => 'A4'));
  }
}