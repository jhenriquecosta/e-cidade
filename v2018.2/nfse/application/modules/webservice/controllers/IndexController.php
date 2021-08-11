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
 * Classe para controle do módulo do WebService
 *
 * @package WebService/Controllers
 * @see Webservice_Lib_Controller_AbstractController
 * @author Everton Catto Heckler <everton.heckler@dbseller.com.br>
 */

class WebService_IndexController extends WebService_Lib_Controller_AbstractController{

  /**
   * Executa os métodos no ambiente de produção do webservice SOAP
   */
  public function producaoAction() {

    $this->noLayout();

    ini_set('soap.wsdl_cache_enabled', '0');

    $sWsdl  = $this->view->baseUrl('/webservice/wsdlValidations/producao/modelo1.wsdl');
    $server = new SoapServer(
      $sWsdl,
      array(
        'soap_version' => SOAP_1_1,
        'uri'          => $this->view->baseUrl('/webservice/index/producao/'),
        'trace'        => TRUE
      )
    );

    $server->setClass('WebService_Model_Processar');
    $server->addFunction('RecepcionarLoteRps');
    $server->addFunction('ConsultarSituacaoLoteRps');
    $server->addFunction('ConsultarNfsePorRps');
    $server->addFunction('CancelarNfse');

    $server->handle();
  }

  /**
   * Executa os métodos no ambiente de homologação do webservice SOAP
   */
  public function homologacaoAction() {

    $this->noLayout();

    ini_set('soap.wsdl_cache_enabled', '0');

    $sWsdl  = $this->view->baseUrl('/webservice/wsdlValidations/homologacao/modelo1.wsdl');
    $server = new SoapServer(
      $sWsdl,
      array(
       'soap_version' => SOAP_1_1,
       'uri'          => $this->view->baseUrl('/webservice/index/homologacao/'),
       'trace'        => TRUE
      )
    );

    $server->setClass('WebService_Model_Processar');
    $server->addFunction('RecepcionarLoteRps');
    $server->addFunction('ConsultarSituacaoLoteRps');
    $server->addFunction('ConsultarNfsePorRps');
    $server->addFunction('ConsultarLoteRps');
    $server->addFunction('CancelarNfse');
    $server->addFunction('ConsultarNfse');

    $server->handle();
  }

  /**
   * Disponibiliza webservice SOAP para integração de informações no NFS-e
   */
  public function integracaoAction() {

    $this->noLayout();

    ini_set('soap.wsdl_cache_enabled', '0');

    $sWsdl  = $this->view->baseUrl('/webservice/wsdlValidations/integracao/modelo1.wsdl');
    $server = new SoapServer(
      $sWsdl,
      array(
       'soap_version' => SOAP_1_1,
       'uri'          => $this->view->baseUrl('/webservice/index/integracao/'),
       'trace'        => TRUE
      )
    );

    $server->setClass('WebService_Model_Integracao');
    $server->addFunction('Acesso');
    $server->addFunction('NotasIrregularidades');
    $server->addFunction('RpsForaPrazo');
    $server->addFunction('QuantidadeRps');
    $server->addFunction('ComparativoRetencao');
    $server->addFunction('PrestacaoContas');

    $server->handle();
  }

  /**
   * Metodo para consultar o status da conexão de webservice do NFS-e com o eCidade
   * @return string true|false
   */
  public function statusNfseEcidadeAction(){

    $this->noLayout();

    try{

      $oDadosPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraWebService();

      if (is_object($oDadosPrefeitura) && property_exists($oDadosPrefeitura, 'sDescricao') && !empty($oDadosPrefeitura->sDescricao)) {
        echo 'true';
      } else {
        echo 'false';
      }

      return;

    }catch(Exception $oErro) {
      echo 'false';
      return;
    }

  }
}