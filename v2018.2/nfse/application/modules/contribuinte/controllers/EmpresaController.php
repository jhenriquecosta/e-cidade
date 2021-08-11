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
 * Controle para empresa
 */
class Contribuinte_EmpresaController extends Contribuinte_Lib_Controller_AbstractController {

  public function init() {
    parent::init();
  }

  public function indexAction() {

    $this->_helper->layout->setLayoutPath(APPLICATION_PATH.'/modules/contribuinte/views/scripts/layouts');
    $this->_helper->layout->setLayout('layout-modal');

    $oForm = new Contribuinte_Form_Empresa();

    if ($this->getRequest()->isPost()) {

      $aDados = $this->getRequest()->getPost();

      $oForm->preenche($aDados);

      if (!$oForm->isValid($aDados)) {

        $this->view->form = $oForm;
        $this->getResponse()->setHttpResponseCode(406); // Evita o Fechamento da Modal JS
      } else {

        $iCodigoIbge = Administrativo_Model_Prefeitura::getDadosPrefeituraBase()->getIbge();

        if ($aDados['z01_munic'] == $iCodigoIbge) {

          $aDados['z01_bairro'] = $aDados['z01_bairro_munic'];
          $aDados['z01_ender']  = $aDados['z01_ender_munic'];
        } else {

          $aDados['z01_bairro'] = $aDados['z01_bairro_fora'];
          $aDados['z01_ender']  = $aDados['z01_ender_fora'];
        }

        // Salva Nova Empresa (NFSE)
        $aDadosEmpresa                      = array();
        $aDadosEmpresa['t_cnpjcpf']         = DBSeller_Helper_Number_Format::getNumbers($aDados['z01_cgccpf']);
        $aDadosEmpresa['t_razao_social']    = $aDados['z01_nome'];
        $aDadosEmpresa['t_cod_pais']        = $aDados['z01_nome'];
        $aDadosEmpresa['t_uf']              = $aDados['z01_uf'];
        $aDadosEmpresa['t_cod_municipio']   = $aDados['z01_munic'];
        $aDadosEmpresa['t_cep']             = $aDados['z01_cep'];
        $aDadosEmpresa['t_bairro']          = $aDados['z01_bairro_fora'];
        $aDadosEmpresa['t_endereco']        = $aDados['z01_ender_fora'];
        $aDadosEmpresa['t_endereco_numero'] = $aDados['z01_numero'];
        $aDadosEmpresa['t_endereco_comp']   = $aDados['z01_compl'];
        $aDadosEmpresa['t_telefone']        = $aDados['z01_telef'];
        $aDadosEmpresa['t_email']           = $aDados['z01_email'];

        $oEmpresa = new Contribuinte_Model_EmpresaBase();
        $oEmpresa->persist($aDadosEmpresa);

        $this->_helper->getHelper('FlashMessenger')->addMessage(array('success' => 'Empresa cadastrada com sucesso.'));

        return TRUE;
      }
    } else {
      $this->view->form = $oForm;
    }
  }

  /**
   * Consulta detalhes da empresa
   *
   * @return json
   */
  public function dadosCgmAction() {

    $oContribuinte = $this->_session->contribuinte;

    $bSubstituto = $this->_getParam('substituto', FALSE);
    $sCgcCpf     = $this->_getParam('term', NULL);
    $sCgcCpf     = DBSeller_Helper_Number_Format::getNumbers($sCgcCpf);

	 // Se tentar informar o próprio CNPJ/CPF
    if ($oContribuinte->getCgcCpf() == $sCgcCpf) {

      $aRetornoJson = array( 'message' => 'Não é possível informar o próprio CNPJ/CPF!',
                             'success' => FALSE );

    } else {

      $aData       = Contribuinte_Model_Empresa::getByCgcCpf($sCgcCpf);
      $aRetornoJson = array(new StdClass());
      
      if (!empty($aData)) {

        if (!empty($aData->eCidade)) {
          $aData = $aData->eCidade;
        } else if (!empty($aData->eNota)) {
          $aData = $aData->eNota;
        }

        $aRetornoJson = array_map(function($v) { return $v->toObject(); }, $aData);
      }

      if (strlen($sCgcCpf) < 14) {
        $aRetornoJson[0]->isCpf = true;
      } else {
        $aRetornoJson[0]->isCpf = false;
      }

    // Ajusta o encode errado no endereço
      if (isset($aRetornoJson[0]->endereco)) {
        $aRetornoJson[0]->endereco = utf8_decode($aRetornoJson[0]->endereco);
      }

    // Retorna apenas o primeiro resultado
      if (count($aRetornoJson) > 1) {
        $aRetornoJson = $aRetornoJson[0];
      }
    }



    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }
}
