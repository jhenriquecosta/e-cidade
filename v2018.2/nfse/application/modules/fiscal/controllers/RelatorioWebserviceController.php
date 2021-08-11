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
 * Classe para controle do relatório de nfse por período do módulo fiscal
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 * @package Fiscal/Controllers
 */
class Fiscal_RelatorioWebserviceController extends Fiscal_Lib_Controller_AbstractController {

  /**
   * Tela para o relatório evolutivo da arrecadação mês a mês por declarante por regime de competência
   */
  public function consultaAction () {

    $oForm = new Fiscal_Form_RelatorioWebservice();

    $this->view->form = $oForm;
    $this->view->headScript()->offsetSetFile(50, $this->view->baseUrl('/fiscal/js/relatorios/script-compartilhado.js'));

    if ($this->getRequest()->isPost()) {

      $aRetornoJson = array();

      try {

        $aParametros = $this->getRequest()->getParams();

        $iIdAcao = $aParametros['ambiente'];

        if ($aParametros['ambiente'] == 51) {
          $sAmbiente = 'Homologação'; 
        } else if ($aParametros['ambiente'] == 52) {
          $sAmbiente = 'Produção'; 
        }

        $aContribuinte = Administrativo_Model_UsuarioContribuinte::getContribuinteByAcao($iIdAcao);

        if (count($aContribuinte) == 0) {
          throw new Exception('Nenhum registro encontrado!');
        }

        $oPdf = new Fiscal_Model_RelatorioWebservice();
        $sNomeArquivo    = 'contribuinte_webs_' . date('YmsdHis') . '.pdf';
        $sCaminhoArquivo = TEMP_PATH . '/' . $sNomeArquivo;
        $oPdf->Open($sCaminhoArquivo);
        $oPdf->setAmbiente($sAmbiente);
        $oPdf->gerarPdf($aContribuinte, $sAmbiente);

        $oPdf->Output();

        $aRetornoJson = array(
          'status'  => TRUE,
          'url'     => $this->view->baseUrl("/fiscal/relatorio-webservice/download/arquivo/{$sNomeArquivo}"),
          'success' => $this->translate->_('Relatório gerado com sucesso.')
        );
      } catch (Exception $oErro) {

        $aRetornoJson['status']  = FALSE;
        $aRetornoJson['error'][] = $this->translate->_($oErro->getMessage());
      }

      echo $this->getHelper('json')->sendJson($aRetornoJson);
    }
  }

  /**
   * Força o download do arquivo
   */
  public function downloadAction() {

    parent::noLayout();
    parent::download($this->getRequest()->getParam('arquivo'));
  }
}