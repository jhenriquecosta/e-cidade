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
 * Classe para controle do relatório1 do módulo fiscal
 *
 * @package Fiscal/Controllers
 */

/**
 * @package Fiscal/Controllers
 */
class Fiscal_Relatorio1Controller extends Fiscal_Lib_Controller_AbstractController {

  /**
   * Tela para o relatório evolutivo da arrecadação mês a mês por declarante por regime de competência
   */
  public function evolucaoArrecadacaoAction () {

    $oForm = new Fiscal_Form_Relatorio1();
    $oForm->setAction('/fiscal/relatorio1/evolucao-arrecadacao-gerar');

    $this->view->form = $oForm->render(Fiscal_Form_Relatorio1::TIPO4);
    $this->view->headScript()->offsetSetFile(50, $this->view->baseUrl('/fiscal/js/relatorios/script-compartilhado.js'));
    $this->render('view-compartilhada');
  }

  /**
   * Geração do relatório evolutivo da arrecadação mês a mês por declarante por regime de competência
   */
  public function evolucaoArrecadacaoGerarAction() {

    parent::noLayout();

    try {

      $aValidacaoFormulario = self::validarFormulario(Fiscal_Form_Relatorio1::TIPO4);

      if (is_array($aValidacaoFormulario)) {
        exit($this->getHelper('json')->sendJson($aValidacaoFormulario));
      }

      $sNomeArquivo    = 'relatorio_evolucao_arrecadacao' . date('YmdHis').'.pdf';
      $sCaminhoArquivo = APPLICATION_PATH . '/../public/tmp/' . $sNomeArquivo;
      $aParametros     = self::getAllParams();
      $aFiltro         = array(
        'inscricao'    => 'Inscrição Municipal',
        'nome'         => 'Nome',
        'valor'        => 'Valor'
      );
      $sOrdenacao      = 'Crescente';

      if (strtoupper($aParametros['ordem']) == 'DESC') {
        $sOrdenacao = 'Decrescente';
      }

      $sFiltro = "Competência {$aParametros['data_competencia_inicial']} até {$aParametros['data_competencia_final']}";
      $sOrdem  = "{$aFiltro[$aParametros['ordenacao']]} ({$sOrdenacao})";

      $oFpdf = new Fiscal_Model_Relatoriopdfmodelo1('L');
      $oFpdf->setLinhaFiltro('Relatório Evolução de Arrecadação por Inscrição Municipal');
      $oFpdf->setLinhaFiltro('');
      $oFpdf->setLinhaFiltro("FILTRO : {$sFiltro}");
      $oFpdf->setLinhaFiltro("ORDEM : {$sOrdem}");
      $oFpdf->Open($sCaminhoArquivo);
      $oFpdf->carregadados();

      $aDataCompetenciaInicial = explode('/', $aParametros['data_competencia_inicial']);
      $aDataCompetenciaFinal   = explode('/', $aParametros['data_competencia_final']);

      $sSql  = "SELECT  CASE WHEN documento_emite_guia = TRUE
                        THEN CAST(prestador_inscricao_municipal AS INTEGER)
                        ELSE CAST(tomador_inscricao_municipal   AS INTEGER)
                        END                       AS inscricao_municipal,

                        CASE WHEN documento_emite_guia = TRUE
                        THEN prestador_razao_social
                        ELSE tomador_razao_social
                        END                       AS razao_social,

                        documento_competencia_ano AS ano_competencia,
                        documento_competencia_mes AS mes_competencia,
                        SUM(servico_valor_iss)    AS valor_imposto
                  FROM  view_nota_mais_dms tab1
                 WHERE  documento_emite_guia          = TRUE
                   AND  prestador_inscricao_municipal IS NOT NULL
                   AND  tomador_inscricao_municipal   IS NOT NULL
                   AND  documento_situacao            NOT IN ('c', 'e')
                   AND  documento_status_cancelamento = FALSE
                   AND (documento_competencia_ano || LPAD(cast(documento_competencia_mes AS VARCHAR), 2, '0'))
                        BETWEEN ?  AND ?
               GROUP BY ano_competencia,
                        mes_competencia,
                        razao_social,
                        inscricao_municipal ";

      $oEntityManager = Zend_Registry::get('em');
      $oConexao       = $oEntityManager->getConnection();
      $oPesquisa      = $oConexao->prepare($sSql);
      $oPesquisa->execute(array(
                            "{$aDataCompetenciaInicial[1]}{$aDataCompetenciaInicial[0]}",
                            "{$aDataCompetenciaFinal[1]}{$aDataCompetenciaFinal[0]}"));

      if ($oPesquisa->rowCount() < 1) {
        throw new Exception($this->translate->_('Nenhum registro encontrado.'));
      }

      $aDadosRelatorio = array();
      $sIndice         = NULL;

      while ($aResultado = $oPesquisa->fetch()) {

        $sIndice = md5($aResultado['inscricao_municipal'].trim($aResultado['razao_social']));

        if (!isset($aDadosRelatorio[$sIndice])) {

          $aDadosRelatorio[$sIndice] = array(
            'inscricao'      => $aResultado['inscricao_municipal'],
            'razao_social'   => trim($aResultado['razao_social'])
          );
        }

        if (!isset($aDadosRelatorio[$sIndice]['totalAnoMes'][$aResultado['ano_competencia']][$aResultado['mes_competencia']])) {
          $aDadosRelatorio[$sIndice]['totalAnoMes'][$aResultado['ano_competencia']][$aResultado['mes_competencia']] = 0;
        }

        $aDadosRelatorio[$sIndice]['totalAnoMes'][$aResultado['ano_competencia']][$aResultado['mes_competencia']] += $aResultado['valor_imposto'];

        if (!isset($aDadosRelatorio[$sIndice]['totalAcumulado'])) {
          $aDadosRelatorio[$sIndice]['totalAcumulado'] = 0;
        }

        $aDadosRelatorio[$sIndice]['totalAcumulado'] += $aResultado['valor_imposto'];
      }

      switch ($aParametros['ordenacao']) {

        case 'inscricao' :
          $sOrdenacao = 'inscricao';
          break;

        case 'nome' :
          $sOrdenacao = 'razao_social';
          break;

        case 'valor' :
          $sOrdenacao = 'totalAcumulado';
          break;
      }

      $iComprimentoPagina = $oFpdf->w - $oFpdf->rMargin - $oFpdf->lMargin;
      $aDadosRelatorio    = DBSeller_Helper_Array_Abstract::ordenarPorIndice($aDadosRelatorio,
                                                                             $sOrdenacao,
                                                                             $aParametros['ordem'],
                                                                             TRUE);

      // Percorre os registros do relatório
      foreach ($aDadosRelatorio as $aRegistro) {

        $sDadosEmpresa = "Inscrição: {$aRegistro['inscricao']} - {$aRegistro['razao_social']}";

        $oFpdf->SetFont('Arial','B', 8);
        $oFpdf->Cell($iComprimentoPagina, 5, utf8_decode($sDadosEmpresa) , 0 , 0, 'J');
        $oFpdf->Ln();

        $aMeses      = DBSeller_Helper_Date_Date::getMesesArray();
        $iTamanhoMes = $iComprimentoPagina / count($aMeses);

        // Ordena a lista pelo índice
        ksort($aRegistro['totalAnoMes']);

        // Percorre a lista pelo total por ano/mes
        foreach ($aRegistro['totalAnoMes'] as $iAno => $aAnos) {

          // Percorre os meses para gerar o cabeçalho de meses
          foreach ($aMeses as $iMes => $sDescricaoMes) {

            $oFpdf->SetFont('Arial','B', 8);
            $oFpdf->Cell($iTamanhoMes , 5, utf8_decode(substr($aMeses[$iMes],0,3)).'/'.$iAno . '(R$)' , 1, 0, 'C');
          }

          $oFpdf->ln();

          // Percorre os meses para gerar os dados por mês
          foreach ($aMeses as $iMes => $sMes) {

            $oFpdf->SetFont('Arial','', 8);

            if (!empty($aAnos[$iMes])) {
              $oFpdf->Cell($iTamanhoMes , 5, DBSeller_Helper_Number_Format::toMoney($aAnos[$iMes], 2), 1, 0, 'R');
            } else {
              $oFpdf->Cell($iTamanhoMes , 5, 'S / M', 1, 0, 'C');
            }
          }

          $oFpdf->proximaPagina(1);

          if (!$oFpdf->lQuebrouPagina) {
            $oFpdf->Ln(6);
          }
        }

        if (!$oFpdf->lQuebrouPagina) {
          $oFpdf->Ln(2);
        }
      }

      $oFpdf->Output();

      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['url']     = $this->view->baseUrl('tmp/' . $sNomeArquivo);
      $aRetornoJson['success'] = $this->translate->_('Relatório gerado com sucesso.');

    } catch (Exception $oErro) {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['error'][] = $this->translate->_($oErro->getMessage());
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Tela para o relatório de valores por atividade / serviço
   */
  public function valoresAtividadeServicoAction () {

    $oForm = new Fiscal_Form_Relatorio1();
    $oForm->setAction('/fiscal/relatorio1/valores-atividade-servico-gerar');

    $this->view->form = $oForm->render(Fiscal_Form_Relatorio1::TIPO5);
    $this->view->headScript()->appendFile($this->view->baseUrl('/fiscal/js/relatorios/script-compartilhado.js'));
    $this->render('view-compartilhada');
  }

  /**
   * Geração do relatório de valores por atividade / serviço
   */
  public function valoresAtividadeServicoGerarAction() {

    parent::noLayout();

    try {

      $aValidacaoFormulario = self::validarFormulario(Fiscal_Form_Relatorio1::TIPO5);

      if (is_array($aValidacaoFormulario)) {
        exit($this->getHelper('json')->sendJson($aValidacaoFormulario));
      }

      $sNomeArquivo    = 'evolucao_arrecadacao_ ' . date('YmdHis').'.pdf';
      $sCaminhoArquivo = APPLICATION_PATH . "/../public/tmp/{$sNomeArquivo}";
      $aParametros     = $this->getRequest()->getParams();
      $aFiltros        = array('atividade_servico' => 'Atividade / Serviço');
      $sOrdenacao      = 'Crescente';

      if (strtoupper($aParametros['ordem']) == 'DESC') {
        $sOrdenacao = 'Decrescente';
      }

      $sFiltro = "Competência {$aParametros['data_competencia_inicial']} até {$aParametros['data_competencia_final']}";
      $sOrdem  = $aFiltros[$aParametros['ordenacao']] . " ({$sOrdenacao})";

      $oFpdf = new Fiscal_Model_Relatoriopdfmodelo1('L');
      $oFpdf->setLinhaFiltro('Relatório Evolução de Arrecadação por Atividade/Serviço');
      $oFpdf->setLinhaFiltro('');
      $oFpdf->setLinhaFiltro("FILTRO : {$sFiltro}");
      $oFpdf->setLinhaFiltro("ORDEM : {$sOrdem}");
      $oFpdf->Open($sCaminhoArquivo);
      $oFpdf->carregadados();

      $aDataCompetenciaInicial = explode('/', $aParametros['data_competencia_inicial']);
      $aDataCompetenciaFinal   = explode('/', $aParametros['data_competencia_final']);

      $sSql = "SELECT SUM(servico_valor_iss) AS valor_imposto,
                          servico_codigo_cnae,
                          documento_competencia_ano,
                          documento_competencia_mes
                     FROM view_nota_mais_dms
                    WHERE documento_emite_guia = TRUE
                     AND (dms_operacao = 's' OR dms_operacao IS NULL)
                     AND  documento_situacao NOT IN ('c', 'e')
                     AND  documento_status_cancelamento = FALSE
                     AND (documento_competencia_ano || LPAD(CAST(documento_competencia_mes AS VARCHAR), 2, '0'))
                          BETWEEN ? AND ?
                 GROUP BY servico_codigo_cnae,
                          documento_competencia_ano,
                          documento_competencia_mes ";

      $aDadosRelatorio = array();
      $oEntityManager  = Zend_Registry::get('em');
      $oConexao        = $oEntityManager->getConnection();
      $oStatement      = $oConexao->prepare($sSql);
      $oStatement->execute(array(
                             "{$aDataCompetenciaInicial[1]}{$aDataCompetenciaInicial[0]}",
                             "{$aDataCompetenciaFinal[1]}{$aDataCompetenciaFinal[0]}"
                           ));

      if ($oStatement->rowCount() < 1) {
        throw new Exception ('Nenhum Registro encontrado.');
      }

      while ($aNota = $oStatement->fetch()) {

        $oServicos = Contribuinte_Model_Servico::getServicoPorCnae($aNota['servico_codigo_cnae']);

        if (!$oServicos) {
          throw new Exception("Erro: {$aNota['servico_codigo_cnae']}");
        }

        $sIndice = md5($aNota['servico_codigo_cnae'] . $oServicos->attr('atividade'));

        $aDadosRelatorio[$sIndice]['estrutural'] = $oServicos->attr('estrutural');
        $aDadosRelatorio[$sIndice]['descricao']  = DBSeller_Helper_String_Format::wordsCap($oServicos->attr('atividade'));

        if (!isset($aDadosRelatorio[$sIndice]
                                   ['totalAnoMes']
                                   [$aNota['documento_competencia_ano']]
                                   [$aNota['documento_competencia_mes']])) {

          $aDadosRelatorio[$sIndice]
                          ['totalAnoMes']
                          [$aNota['documento_competencia_ano']]
                          [$aNota['documento_competencia_mes']] = 0;
        }

        $aDadosRelatorio[$sIndice]
                        ['totalAnoMes']
                        [$aNota['documento_competencia_ano']]
                        [$aNota['documento_competencia_mes']] += $aNota['valor_imposto'];

        if (!isset($aDadosRelatorio[$sIndice]['totalAcumulado'])) {
          $aDadosRelatorio[$sIndice]['totalAcumulado'] = 0;
        }

        $aDadosRelatorio[$sIndice]['totalAcumulado'] += $aNota['valor_imposto'];
      }

      switch ($aParametros['ordenacao']) {

        case 'atividade_servico' :
          $sOrdenacao = 'estrutural';
          break;

        case 'valor_total' :
          $sOrdenacao = 'totalAcumulado';
          break;
      }

      $iComprimentoPagina = $oFpdf->w - $oFpdf->rMargin - $oFpdf->lMargin;
      $aDadosRelatorio    = DBSeller_Helper_Array_Abstract::ordenarPorIndice($aDadosRelatorio,
                                                                             $sOrdenacao,
                                                                             $aParametros['ordem'],
                                                                             TRUE);

      // Percorre os registros do relatório
      foreach ($aDadosRelatorio as $aRegistro) {

        $sAtividadeServico = "Atividade / Serviço: {$aRegistro['estrutural']} - {$aRegistro['descricao']}";

        $oFpdf->SetFont('Arial','B',8);
        $oFpdf->Cell($iComprimentoPagina, 5, utf8_decode($sAtividadeServico) , 0 , 1, 'J');
        $oFpdf->SetFont('Arial', '', 8);

        $aMeses      = DBSeller_Helper_Date_Date::getMesesArray();
        $iTamanhoMes = $iComprimentoPagina / count($aMeses);

        // Ordena a lista pelo índice
        ksort($aRegistro['totalAnoMes']);

        // Percorre a lista pelo total por ano/mes
        foreach ($aRegistro['totalAnoMes'] as $iAno => $aAnos) {

          // Percorre os meses para gerar o cabeçalho de meses
          foreach ($aMeses as $iMes => $sDescricaoMes) {

            $oFpdf->SetFont('Arial','B', 8);
            $oFpdf->Cell($iTamanhoMes , 5, utf8_decode(substr($aMeses[$iMes],0,3)).'/'.$iAno . '(R$)' , 1, 0, 'C');
          }

          $oFpdf->ln();

          // Percorre os meses para gerar os dados por mês
          foreach ($aMeses as $iMes => $sMes) {

            $oFpdf->SetFont('Arial','', 8);

            if (!empty($aAnos[$iMes])) {
              $oFpdf->Cell($iTamanhoMes , 5, DBSeller_Helper_Number_Format::toMoney($aAnos[$iMes], 2), 1, 0, 'R');
            } else {
              $oFpdf->Cell($iTamanhoMes , 5, 'S / M', 1, 0, 'C');
            }
          }

          $oFpdf->proximaPagina(1);

          if (!$oFpdf->lQuebrouPagina) {
            $oFpdf->Ln(6);
          }
        }

        if (!$oFpdf->lQuebrouPagina) {
          $oFpdf->Ln(2);
        }
      }

      $oFpdf->Output();

      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['url']     = $this->view->baseUrl('tmp/' . $sNomeArquivo);
      $aRetornoJson['success'] = $this->translate->_('Relatório gerado com sucesso.');

    } catch (Exception $oErro) {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['error'][] = $this->translate->_($oErro->getMessage());
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Método abstrato para validar o formulário em ambos os relatórios
   *
   * @param integer $iRelatorio Tipo de Relatório a ser validado
   * @return Array  $aRetornoErros
   */
  protected function validarFormulario($iRelatorio) {

    $aDados        = $this->getRequest()->getPost();
    $aRetornoErros = array();
    $oForm         = new Fiscal_Form_Relatorio1();
    $oForm->render($iRelatorio);

    // Verifica se os parâmetros do formulário são válidos
    if ($oForm->isValid($aDados)) {

      // Parâmetros do formulário
      $sCompetenciaInicial = $this->getRequest()->getParam('data_competencia_inicial', NULL);
      $sCompetenciaFinal   = $this->getRequest()->getParam('data_competencia_final',   NULL);

      $oValidaCompetencia = new DBSeller_Validator_Competencia();
      $oValidaCompetencia->setCompetenciaInicial($sCompetenciaInicial);
      $oValidaCompetencia->setCompetenciaFinal($sCompetenciaFinal);

      // Valida a competência inicial e final
      if (!$oValidaCompetencia->isValid($sCompetenciaInicial)) {

        $aMensagensErro = $oValidaCompetencia->getMessages();
        $aIndicesErro   = array_keys($aMensagensErro);

        $aRetornoErros['status']  = FALSE;
        $aRetornoErros['fields']  = array('data_competencia_inicial', 'data_competencia_final');

        foreach ($aIndicesErro as $sIndiceErro) {

          if (array_key_exists($sIndiceErro, $aMensagensErro)) {
            $aRetornoErros['error'][] = $this->translate->_($aMensagensErro[$sIndiceErro]);
          }
        }

        return $aRetornoErros;
      }

      return TRUE;
    } else {

      $aCamposComErro = array_keys($oForm->getMessages());
      $sMensagemErro  = 'Preencha os dados corretamente.';

      if (count($aCamposComErro) > 1) {
        $sMensagemErro = 'Preencha os dados corretamente.';
      } else if (in_array('data_competencia_final', $aCamposComErro)) {
        $sMensagemErro = 'Informe a Competência Final corretamente.';
      } else if (in_array('data_competencia_inicial', $aCamposComErro)) {
        $sMensagemErro = 'Informe a Competência Inicial corretamente.';
      }

      $aRetornoErros['status']  = FALSE;
      $aRetornoErros['fields']  = array_keys($oForm->getMessages());
      $aRetornoErros['error'][] = $this->translate->_($sMensagemErro);
    }

    return $aRetornoErros;
  }

  /**
   * Força o download do arquivo
   */
  public function downloadAction() {

    parent::noLayout();
    parent::download($this->getRequest()->getParam('arquivo'));
  }
}