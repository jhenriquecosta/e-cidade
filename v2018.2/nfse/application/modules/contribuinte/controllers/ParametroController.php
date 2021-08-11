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
 * Classe controller para as acoes de cadastro de parametros dos contribuintes do municpio
 *
 * @author dbseller
 * @package Contribuinte
 * @subpackage Controller
 */
class Contribuinte_ParametroController extends Contribuinte_Lib_Controller_AbstractController {

  /**
   * Metodo para renderizar o formulario de cadastro/alteracao dos parametros do contribuinte.
   *
   * Retorna para a view a instancia do formulario Contribuinte_Form_ParametrosContribuinte
   */
  public function contribuinteAction() {

    $oForm                  = new Contribuinte_Form_ParametrosContribuinte();
    $oContribuinte          = $this->_session->contribuinte;
    $iInscricaoMunicipal    = $oContribuinte->getInscricaoMunicipal();
    $oParametroContribuinte = $this->buscarParametroContribuinte($oContribuinte->getIdUsuarioContribuinte(), $iInscricaoMunicipal);
    $aDados                 = $this->getRequest()->getPost();

    if ($this->getRequest()->isPost() && $oForm->isValid($aDados)) {

      try {

        $oDoctrine = Zend_Registry::get('em');
        $oDoctrine->getConnection()->beginTransaction();

        // Parametros Gerais
        $oParametroContribuinte->setAvisofimEmissaoNota($aDados["avisofim_emissao_nota"]);
        $oParametroContribuinte->setCofins(DBSeller_Helper_Number_Format::toDataBase($aDados["cofins"]));
        $oParametroContribuinte->setCsll(DBSeller_Helper_Number_Format::toDataBase($aDados["csll"]));
        $oParametroContribuinte->setIdContribuinte($oContribuinte->getIdUsuarioContribuinte());
        $oParametroContribuinte->setInss(DBSeller_Helper_Number_Format::toDataBase($aDados["inss"]));
        $oParametroContribuinte->setIr(DBSeller_Helper_Number_Format::toDataBase($aDados["ir"]));
        $oParametroContribuinte->setMaxDeducao(DBSeller_Helper_Number_Format::toDataBase($aDados["max_deducao"]));
        $oParametroContribuinte->setPis(DBSeller_Helper_Number_Format::toDataBase($aDados["pis"]));
        $oParametroContribuinte->setValorIssFixo(DBSeller_Helper_Number_Format::toDataBase($aDados["valor_iss_fixo"]));
        $oParametroContribuinte->salvar();

        // Parametro de Tributos
        if (empty($aDados["codigo_parametro_tributacao"])) {

          // Carrega a entidade do UsuarioContribuinte
          $rsUsuarioContribuinte = Administrativo_Model_UsuarioContribuinte::getByAttribute('id', $oContribuinte->getContribuintes());
          if (is_array($rsUsuarioContribuinte)) {
            $oUsuarioContribuinte = $rsUsuarioContribuinte[0]->getEntity();
          } else {
            $oUsuarioContribuinte = $rsUsuarioContribuinte->getEntity();
          }

          $oParametrosTributacao = new Contribuinte_Model_ParametroContribuinteTributos();
          $oParametrosTributacao->setContribuinte($oUsuarioContribuinte);
        } else {

          // Carrega os parametros de tributacao existente
          $oParametrosTributacao = Contribuinte_Model_ParametroContribuinteTributos::getParametroById($aDados["codigo_parametro_tributacao"]);
        }

        // Só salva os parâmetros se for informado um percentual de tributos
        if (!empty($aDados["percentual_tributos"])) {

          $oParametrosTributacao->setAno($aDados["ano"]);
          $oParametrosTributacao->setPercentualTributos(DBSeller_Helper_Number_Format::toFloat($aDados["percentual_tributos"]));
          $oParametrosTributacao->setFonteTributacao($aDados["fonte_tributacao"]);
          $oParametrosTributacao->salvar();
        }

        $oDoctrine->getConnection()->commit();
        $this->view->messages[] = array('success' => 'Parâmetros modificados com sucesso.');

        $oArquivoUpload = new Zend_File_Transfer();
        $oArquivoUpload->receive();

        Administrativo_Model_Empresa::setLogoByIm($iInscricaoMunicipal, $oArquivoUpload->getFileInfo());
      } catch (Exception $oErro) {
        
        $oDoctrine->getConnection()->rollback();
        $this->view->messages[] = array('error' => $oErro->getMessage());
      }
    }

    $oDados = new StdClass();
    $oDados->im                    = $iInscricaoMunicipal;
    $oDados->nome_contribuinte     = $oContribuinte->getNome();
    $oDados->avisofim_emissao_nota = $oParametroContribuinte->getAvisofimEmissaoNota();
    $oDados->cofins                = $oParametroContribuinte->getCofins();
    $oDados->csll                  = $oParametroContribuinte->getCsll();
    $oDados->inss                  = $oParametroContribuinte->getInss();
    $oDados->ir                    = $oParametroContribuinte->getIr();
    $oDados->max_deducao           = $oParametroContribuinte->getMaxDeducao();
    $oDados->pis                   = $oParametroContribuinte->getPis();
    $oDados->valor_iss_fixo        = $oParametroContribuinte->getValorIssFixo();
    $oForm->preenche($oDados);

    $this->view->sLogoPrestador    = Administrativo_Model_Empresa::getLogoByIm($oDados->im);
    $this->view->form              = $oForm;
  }
  
  /**
   * Realiza a busca dos dados do contribuinte
   */
  public function buscaContribuinteAction() {
    
    $this->setAjaxContext('getContribuinte');
    
    $dados = Contribuinte_Model_Contribuinte::getByIm($this->getRequest()->getParam('term'));
    
    if (empty($dados) || $dados == null) {
      
      echo json_encode(null);
      
      return;
    }

    $iIdContribuinte = $this->view->contribuinte->getIdUsuarioContribuinte();
    $parametro       = $this->buscarParametroContribuinte($iIdContribuinte, $dados[0]->attr('inscricao'));
    
    if ($parametro === null || empty($parametro)) {
      
      echo json_encode(null);
      
      return;
    }
    
    $retorno = new stdClass();
    
    $retorno->dados      = $dados[0]->toArray();
    $retorno->parametros = $parametro->toJson();
    
    echo json_encode($retorno);
  }

  /**
   * Retorna o parametro cadastrado para contribuinte
   * @param $iCodigoContribuinte integer
   * @param $im integer
   * @return Contribuinte_Model_ParametroContribuinte|mixed
   */
  public static function buscarParametroContribuinte($iCodigoContribuinte, $im) {
    
    $parametro = Contribuinte_Model_ParametroContribuinte::getById($iCodigoContribuinte);

    if ($parametro == null) {
      
      $parametro = new Contribuinte_Model_ParametroContribuinte();
      $parametro->setIm($im);
    }
    
    return $parametro;
  }

  /**
   * Busca as configurações de tributação cadastrada para preencher os dados no form
   */
  public function buscarTributacaoAction() {

    parent::noTemplate();

    if ($this->getRequest()->isPost()) {

      try {

        $iAnoConfTributacao = $this->getRequest()->getParam('ano');

        if (empty($iAnoConfTributacao)) {
          throw new Exception('Informe o ano no parâmetro de tributos!');
        }

        // Carrega os parametros de tributacao
        $oParametrosTributacao = Contribuinte_Model_ParametroContribuinteTributos::getParametroByContribuinteAno(
          $this->_session->contribuinte,
          $iAnoConfTributacao
        );

        if (!empty($oParametrosTributacao)) {

          $aRetornoJson['data'] = array(
            'codigo_parametro_tributacao' => $oParametrosTributacao->getId(),
            'percentual_tributos' => $oParametrosTributacao->getPercentualTributos(),
            'fonte_tributacao' => $oParametrosTributacao->getFonteTributacao()
          );
        }

        $aRetornoJson['success'] = TRUE;
      } catch (Exception $oErro) {

        $aRetornoJson['success'] = FALSE;
        $aRetornoJson['message'] = $oErro->getMessage();
      }
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
}