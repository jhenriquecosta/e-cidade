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
 * Configuração dos parâmetros da prefeitura
 * 
 * @package Contribuinte/Controller
 */

/**
 * @package Contribuinte/Controller
 */
class Administrativo_ParametroController extends Administrativo_Lib_Controller_AbstractController {
  
  /**
   * Parametros da prefeitura
   */
  public function prefeituraAction() {
    
    $oFormPrefeitura = new Administrativo_Form_ParametroPrefeitura();
    $oFormGeral      = new Administrativo_Form_ParametroPrefeituraGeral();
    $oFormNfse       = new Administrativo_Form_ParametroPrefeituraNfse();
    $oFormRps        = new Administrativo_Form_ParametroPrefeituraRps();
    
    $oParametros     = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    $oFormPrefeitura->preenche($oParametros);
    $oFormGeral->preenche($oParametros);
    $oFormNfse->preenche($oParametros);
    
    $aParametrosRps  = Administrativo_Model_ParametroPrefeituraRps::getAll();
    $oFormRps->preenche($aParametrosRps);
    
    $this->view->formPrefeitura = $oFormPrefeitura;
    $this->view->formGeral      = $oFormGeral;
    $this->view->formNfse       = $oFormNfse;
    $this->view->formRps        = $oFormRps;
    
    $this->view->administrativo = $this->view->user->getAdministrativo();
  }
  
  /**
   * Salva os parametros da prefeitura da aba "Dados da Prefeitura" sincorinizados com o WebService [Json]
   */
  public function prefeituraSalvarAction() {
    
    $oParametros = Administrativo_Model_Prefeitura::getDadosPrefeituraWebService();
    
    $aDados['ibge']           = $oParametros->sIbge;
    $aDados['cnpj']           = $oParametros->sCnpj;
    $aDados['nome']           = $oParametros->sDescricao;
    $aDados['nome_relatorio'] = $oParametros->sDescricaoAbreviada;
    $aDados['endereco']       = $oParametros->sLogradouro;
    $aDados['numero']         = $oParametros->sNumero;
    $aDados['complemento']    = $oParametros->sComplemento;
    $aDados['bairro']         = $oParametros->sBairro;
    $aDados['municipio']      = $oParametros->sMunicipio;
    $aDados['uf']             = $oParametros->sUf;
    $aDados['cep']            = $oParametros->sCep;
    $aDados['telefone']       = $oParametros->sTelefone;
    $aDados['fax']            = $oParametros->sFax;
    $aDados['email']          = $oParametros->sEmail;
    $aDados['url']            = $oParametros->sSite;
    $aDados['logo']           = '/global/img/brasao.jpg';
    
    // Formulario
    $oForm = new Administrativo_Form_ParametroPrefeitura();
    $oForm->populate($aDados);
    
    // Valida o formulario
    if ($oForm->isValid($aDados)) {
      
      $oParametros = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
      $oParametros->persist($aDados);
      
      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['success'] = $this->translate->_('Parâmetros configurados com sucesso.');
      $aRetornoJson['dados']   = $aDados;
    } else {
      
      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = $this->translate->_('Ocorreu um erro ao sincronizar com o WebService.');
      $aRetornoJson['dados']   = $aDados;
    }
    
    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
  
  /**
   * Salva os parametros da prefeitura da aba "Geral" [Json]
   */
  public function prefeituraSalvarGeralAction() {
    
    // Dados Request
    $aDados = $this->getRequest()->getParams();

    // Formulario
    $oForm = new Administrativo_Form_ParametroPrefeituraGeral();
    $oForm->populate($aDados);
    
    // Valida o formulario
    if ($oForm->isValid($aDados)) {

      $oParametros = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
      $oParametros->persist($aDados);

      // Gera as permissões para os usuário do tipo Prestador NFSE poder visualizar as Requisições Aidof
      if ((int) $aDados['requisicao_nfse'] == 1) {
        Administrativo_Model_Prefeitura::geraPermissoesPrestadorNfse();
      } else {
        Administrativo_Model_Prefeitura::removePermissoesPrestadorNfse();
      }

      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['success'] = $this->translate->_('Parâmetros configurados com sucesso.');
    } else {
      
      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = $this->translate->_('Preencha os dados corretamente.');
    }
    
    echo $this->getHelper('json')->sendJson($aRetornoJson);
  } 
   
  /**
   * Salva os parametros da prefeitura [Json]
   */
  public function prefeituraSalvarNfseAction() {
  
    // Dados Request
    $aDados = $this->getRequest()->getParams();
  
    // Formulario
    $oForm = new Administrativo_Form_ParametroPrefeituraNfse();
    $oForm->setModelosImpressao($oForm->modelo_impressao_nfse);
    $oForm->populate($aDados);
  
    // Valida o formulario
    if ($oForm->isValid($aDados)) {
  
      $oParametros = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
      $oParametros->persist($aDados);
  
      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['success'] = $this->translate->_('Parâmetros configurados com sucesso.');
    } else {
  
      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['fields']  = array_keys($oForm->getMessages());
      $aRetornoJson['error'][] = $this->translate->_('Preencha os dados corretamente.');
    }
  
    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }  
  
  /**
   * Salva os parâmetros da prefeitura
   */
  public function prefeituraSalvarRpsAction () {
    
    $aDados = $this->getRequest()->getParams();
    
    try {
      
      if (isset($aDados['parametros_prefeitura_rps']) && is_array($aDados['parametros_prefeitura_rps'])) {
        
        self::atualizarParametrosRps($aDados['parametros_prefeitura_rps'], TRUE);
        self::atualizarParametrosRps($aDados['parametros_prefeitura_rps']);
        
        $aRetornoJson['status']  = TRUE;
        $aRetornoJson['success'] = $this->translate->_('Parâmetros configurados com sucesso.');
      }
    } catch (Exception $oErro) {
      
      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['error'][] = $this->translate->_('Preencha os dados corretamente.');
      $aRetornoJson['error'][] = $this->translate->_('Os parâmetros informados não podem se repetir.');
    }
    
    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
  
  /**
   * Atualiza a lista de parâmetros do RPS com os código de tipo de RPS do ecidade,
   * limpa os códigos do ecidade se o paraêmtro para limpar for informado
   * 
   * @param array $aParametros
   * @param boolean (default: FALSE) $lLimpar
   * @see Administrativo_ParametroController::prefeituraSalvarRpsAction()
   * @return boolean
   */
  private function atualizarParametrosRps($aParametros, $lLimpar = FALSE) {
    
    if (!is_array($aParametros)) {
      return FALSE;
    }
    
    // Varre a lista de parametros
    foreach ($aParametros as $iIdParametroPrefeituraRps => $iTipoEcidade) {
    
      $oParametrosPrefeituraRps = Administrativo_Model_ParametroPrefeituraRps::getById($iIdParametroPrefeituraRps);
      
      // Limpar para poder salvar 
      if ($lLimpar) {
        $oParametrosPrefeituraRps->setTipoEcidade(NULL);
      } else {
        $oParametrosPrefeituraRps->setTipoEcidade(empty($iTipoEcidade) ? NULL : $iTipoEcidade);
      }
      
      $oParametrosPrefeituraRps->persist();
    }
    
    return TRUE;
  } 
}