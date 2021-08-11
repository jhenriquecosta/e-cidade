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
 * Classe responsável pela instalação do sistema
 *
 * @package Administrativo
 * @see     Administrativo_Lib_Controller_AbstractController
 */

class Administrativo_InstalacaoController extends Administrativo_Lib_Controller_AbstractController {

  /**
   * Página inicial
   */
  public function indexAction() {

    // Verifica se o parametro da aplicação não for de ambiente de desenvolvimento
    if (APPLICATION_ENV != 'development') {
      $this->_redirector->gotoSimple('index', 'logout', 'auth');
    }

    $aConfiguracoes   = Zend_Registry::get('config')->doctrine->connectionParameters;
    $this->view->form = new Administrativo_Form_ParametrosConexao($aConfiguracoes);

    try {

      if ($this->getRequest()->isPost()) {

        $aDados = $this->getRequest()->getPost();

        if ($this->view->form->isValid($aDados)) {

          // Verifica a conexão com os parametros informados para testar se existe a base informada
          if (!$oConexao = new PDO("pgsql:host={$aDados['servidor']} port={$aDados['porta']}", $aDados['usuario'], $aDados['senha'])) {
            throw new Exception("Conexão inválida! Verifique as configurações informadas.");
          }

          // Prepara o arquivo de configuração
          $aParametrosAlterar = array(
            'doctrine.connectionParameters.host' => $aDados['servidor'],
            'doctrine.connectionParameters.user' => $aDados['usuario'],
            'doctrine.connectionParameters.password' => $aDados['senha'],
            'doctrine.connectionParameters.dbname' => $aDados['base_dados'],
            'doctrine.connectionParameters.port' => $aDados['porta'],
            'webservice.client.url' => $aDados['client_url'],
            'webservice.client.location' => $aDados['client_location'],
            'webservice.client.uri' => $aDados['client_uri']
          );

          $sNomeArquivo = APPLICATION_PATH . '/configs/application.ini';
          $oArquivo = file($sNomeArquivo);
          $sLinhaArquivoNovo = array();

          foreach ($oArquivo as $ikey => $sLinha) {

            $aParametro = explode('=', $sLinha);
            $aParametro = reset($aParametro);

            if (array_key_exists(trim($aParametro), $aParametrosAlterar)) {
              $sLinhaArquivoNovo[$ikey] = trim($aParametro) . " = " . trim($aParametrosAlterar[trim($aParametro)]) . "\n";
            } else {
              $sLinhaArquivoNovo[$ikey] = trim($sLinha) . "\n";
            }
          }

          $oArquivo = implode($sLinhaArquivoNovo);

          if (is_writable($sNomeArquivo)) {

            if (!$handle = fopen($sNomeArquivo, 'w+')) {
              throw new Exception("Não foi possível abrir o arquivo ({$sNomeArquivo})!");
            }

            if (fwrite($handle, $oArquivo) === FALSE) {
              throw new Exception("Não foi possível escrever no arquivo ($sNomeArquivo)!");
            }

            fclose($handle);

            $this->_helper->getHelper('FlashMessenger')->addMessage(array('success' => 'Configurações alteradas com sucesso.'));
            $this->_redirector->gotoSimple ('index', 'instalacao', 'administrativo');
          } else {
            throw new Exception("O arquivo {$sNomeArquivo} não pode ser alterado! Verifique a permissão!");
          }
        }
      } else {
        $this->view->form->preenche();
      }
    } catch (Exception $e) {

      if ($e->getCode() == 7) {
        $sMensagem = 'Erro na conexão, verifique sua conexão!';
      } else {
        $sMensagem = $e->getMessage();
      }

      $this->_helper->getHelper('FlashMessenger')->addMessage(array('error' => $sMensagem));
      $this->_redirector->gotoSimple ('index', 'instalacao', 'administrativo');
    } catch (PDOException $e) {

      $this->_helper->getHelper('FlashMessenger')->addMessage(array('error' => $e->getMessage()));
      $this->_redirector->gotoSimple ('index', 'instalacao', 'administrativo');
    }
  }
}