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
class Fiscal_RelatorioNfsePeriodoController extends Fiscal_Lib_Controller_AbstractController {

  /**
   * Tela para o relatório evolutivo da arrecadação mês a mês por declarante por regime de competência
   */
  public function indexAction () {

    $oForm = new Fiscal_Form_RelatorioNfsePeriodo();

    $this->view->form = $oForm;
    $this->view->headScript()->offsetSetFile(50, $this->view->baseUrl('/fiscal/js/relatorios/script-compartilhado.js'));
    $this->render('view-compartilhada');
  }

  /**
   * Busca os dados necessários para preencher o relatório
   */
  public function consultarAction() {

    parent::noLayout();

    $oForm = new Fiscal_Form_RelatorioNfsePeriodo();
    $this->view->form = $oForm;

    try {

      $aParametros = $this->getRequest()->getParams();

      if (!$oForm->isValid($aParametros)) {
        throw new Exception('Informe um período válido!');
      }

      $oNotaModel = new Contribuinte_Model_Nota();
      $aNotas     = $oNotaModel->getNotaPorPeriodo($aParametros);

      if (count($aNotas) == 0) {
        throw new Exception('Nenhum registro encontrado!');
      }

      $oArquivoPDF             = $this->gerarPdf($aNotas);
      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['url']     = $this->view->baseUrl("/fiscal/relatorio-nfse-periodo/download/arquivo/{$oArquivoPDF->filename}");
      $aRetornoJson['success'] = $this->translate->_('Relatório gerado com sucesso.');
    } catch (Exception $oErro) {

      $aRetornoJson['status'] = FALSE;
      $aRetornoJson['error'][]  = $this->translate->_($oErro->getMessage());
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Gera pdf apartir dos valores retornados do action
   *
   * @param $aDados
   * @return object
   */
  private function gerarPdf($aDados) {

    $aParametros     = $this->getRequest()->getParams();
    $sNomeArquivo    = 'relatorio_nfse_periodo_' . date('YmdHis') . '.pdf';
    $sCaminhoArquivo = TEMP_PATH . "/{$sNomeArquivo}";

    $sFiltroPeriodo = $this->translate->_("De {$aParametros['data_nota_inicial']} até {$aParametros['data_nota_final']}");

    $oFpdf = new Fiscal_Model_Relatoriopdfmodelo1('L');
    $oFpdf->setLinhaFiltro($this->translate->_('Relatório de NFS-e por Período'));
    $oFpdf->setLinhaFiltro('');
    $oFpdf->setLinhaFiltro($this->translate->_("FILTRO : {$sFiltroPeriodo}"));

    if (!empty($aParametros['natureza_operacao'])) {

      $sLabelNaturezaOperacao = ($aParametros['natureza_operacao'] == 1) ? 'Tributação no Município' : 'Tributação Fora do Município';
      $sFiltroNastureza       = $this->translate->_("Natureza da operação: {$sLabelNaturezaOperacao}");
      $oFpdf->setLinhaFiltro($sFiltroNastureza);
    }

    if (!empty($aParametros['s_dados_iss_retido'])) {

      $sLabelRetido  = ($aParametros['s_dados_iss_retido'] == 1) ? 'Sim' : 'Não';
      $sFiltroRetido = $this->translate->_("Subst. Tributário (Retido): {$sLabelRetido}");
      $oFpdf->setLinhaFiltro($sFiltroRetido);
    }

    $oFpdf->Open($sCaminhoArquivo);
    $oFpdf->carregadados();

    $oFpdf->Ln(2);

    $oFpdf->SetFont('Arial', 'B', 8);
    $oFpdf->Cell(30,  5, utf8_decode($this->translate->_('Inscrição')),     1, 0, 'C', 1);
    $oFpdf->Cell(127, 5, utf8_decode($this->translate->_('Razão Social')),  1, 0, 'C', 1);
    $oFpdf->Cell(40,  5, utf8_decode($this->translate->_('Qtd. Notas')),    1, 0, 'C', 1);
    $oFpdf->Cell(40,  5, utf8_decode($this->translate->_('Valor Serviço')), 1, 0, 'C', 1);
    $oFpdf->Cell(40,  5, utf8_decode($this->translate->_('Valor ISS')),     1, 1, 'C', 1);

    $iFundo         = 0;
    $iTotalLiquido  = 0;
    $iTotalISS      = 0;
    $iTotalQtdNotas = 0;

    foreach ($aDados as $aNota) {

      $lFundoLinha    =  ($iFundo++ % 2 == 0) ? 0 : 1;
      $iTotalQtdNotas = ($iTotalQtdNotas + $aNota['notas']);
      $iTotalLiquido  = ($iTotalLiquido + $aNota['vl_liquido_nfse']);
      $iTotalISS      = ($iTotalISS + $aNota['s_vl_iss']);
      $sValorLiquido  = 'R$ ' . number_format($aNota['vl_liquido_nfse'], 2, ',', '.');
      $sValorISS      = 'R$ ' . number_format($aNota['s_vl_iss'], 2, ',', '.');

      $oFpdf->SetFont('Arial', '', 8);
      $oFpdf->Cell(30,  5, $aNota['p_im'],            1, 0, 'C', $lFundoLinha);
      $oFpdf->Cell(127, 5, $aNota['p_razao_social'],  1, 0, 'L', $lFundoLinha);
      $oFpdf->Cell(40,  5, $aNota['notas'],           1, 0, 'R', $lFundoLinha);
      $oFpdf->Cell(40,  5, $sValorLiquido,            1, 0, 'R', $lFundoLinha);
      $oFpdf->Cell(40,  5, $sValorISS,                1, 1, 'R', $lFundoLinha);

      $oFpdf->proximaPagina(1);

      if ($oFpdf->lQuebrouPagina) {

        $iFundo  =  0;
        $oFpdf->SetFont('Arial', 'B', 8);
        $oFpdf->Cell(30,  5, utf8_decode($this->translate->_('Inscrição')),     1, 0, 'C', 1);
        $oFpdf->Cell(127, 5, utf8_decode($this->translate->_('Razão Social')),  1, 0, 'C', 1);
        $oFpdf->Cell(40,  5, utf8_decode($this->translate->_('Qtd. Notas')),    1, 0, 'C', 1);
        $oFpdf->Cell(40,  5, utf8_decode($this->translate->_('Valor Serviço')), 1, 0, 'C', 1);
        $oFpdf->Cell(40,  5, utf8_decode($this->translate->_('Valor ISS')),     1, 1, 'C', 1);
      }

    }

    $sTotalLiquido = 'R$ ' . number_format($iTotalLiquido, 2, ',', '.');
    $sTotalISS     = 'R$ ' . number_format($iTotalISS, 2, ',', '.');

    $oFpdf->SetFont('Arial', 'B', 8);
    $oFpdf->Cell(157, 5, utf8_decode($this->translate->_('Totais')), 1, 0, 'R', 0);
    $oFpdf->Cell(40,  5, $iTotalQtdNotas,                            1, 0, 'R', 0);
    $oFpdf->Cell(40,  5, $sTotalLiquido,                             1, 0, 'R', 0);
    $oFpdf->Cell(40,  5, $sTotalISS,                                 1, 1, 'R', 0);

    $oFpdf->Output();

    /**
     * Opções de retorno
     */
    $aRetorno = array(
      'location' => $sCaminhoArquivo,
      'filename' => $sNomeArquivo,
      'type'     => 'application/pdf'
    );

    return (object) $aRetorno;
  }

  /**
   * Força o download do arquivo
   */
  public function downloadAction() {

    parent::noLayout();
    parent::download($this->getRequest()->getParam('arquivo'));
  }
}