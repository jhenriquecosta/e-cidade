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
 * Classe para controle do relatório 12 do módulo fiscal
 *
 * @package Fiscal/Controllers
 */

/**
 * @package Fiscal/Controllers
 */
class Fiscal_Relatorio6Controller extends Fiscal_Lib_Controller_AbstractController {

  /**
   * Conexão doctrine com a base de dados
   *
   * @var /Doctrine/DBAL/Connection
   */
  private $oConexao;

  /**
   * Método construtor da classe
   */
  public function init() {

    parent::init();

    $oEntityManager = Zend_Registry::get('em');
    $this->oConexao = $oEntityManager->getConnection();

    Zend_Loader::loadClass('Fpdf2File', APPLICATION_PATH . '/../library/FPDF/');
  }

  /**
   * Tela para o relatório de NFSe's
   */
  public function nfseAction() {

    $oForm = new Fiscal_Form_Relatorio6();
    $oForm->setAction('/fiscal/relatorio6/nfse-gerar');

    $this->view->form = $oForm->render();
    $this->view->headScript()->offsetSetFile(50, $this->view->baseUrl('/fiscal/js/relatorios/script-compartilhado.js'));
  }

  /**
   * Geração do relatório de NFSe's
   */
  public function nfseGerarAction() {

    parent::noLayout();

    $aValidacaoFormulario = self::validarFormulario();

    if (is_array($aValidacaoFormulario)) {
      exit($this->getHelper('json')->sendJson($aValidacaoFormulario));
    }

    try {

      // Parâmetros do formulário
      $sCompetenciaInicial = $this->getRequest()->getParam('data_competencia_inicial');
      $sCompetenciaFinal   = $this->getRequest()->getParam('data_competencia_final');
      $sPrestadorCnpj      = $this->getRequest()->getParam('prestador_cnpj');
      $lGuiaEmitida        = $this->getRequest()->getParam('guia_emitida') == 1 ? TRUE : FALSE;
      $sGuiaEmitida        = ($lGuiaEmitida) ? 'Sim' : 'Não';

      // Prestador
      $oPrestador = Contribuinte_Model_Contribuinte::getByCpfCnpj($sPrestadorCnpj);

      // Separa os meses e anos
      $iCompetenciaInicialMes = intval(substr($sCompetenciaInicial, 0, 2));
      $iCompetenciaFinalMes   = intval(substr($sCompetenciaFinal, 0, 2));
      $iCompetenciaInicialAno = intval(substr($sCompetenciaInicial, -4));
      $iCompetenciaFinalAno   = intval(substr($sCompetenciaFinal, -4));
      $sNomeArquivo           = 'relatorio_nfse_' . date('YmdHis') . '.pdf';

      $oPdf = new Fiscal_Model_Relatoriopdfmodelo1('P');
      $oPdf->Open(APPLICATION_PATH . "/../public/tmp/{$sNomeArquivo}");
      $oPdf->setLinhaFiltro('Relatório de NFSe');
      $oPdf->setLinhaFiltro('');
      $oPdf->setLinhaFiltro('FILTROS:');
      $oPdf->setLinhaFiltro("  CNPJ Prestador {$sPrestadorCnpj}");
      $oPdf->setLinhaFiltro("  Competência de {$sCompetenciaInicial} à {$sCompetenciaFinal}");
      $oPdf->setLinhaFiltro("  Guia Emitida? {$sGuiaEmitida}");
      $oPdf->carregaDados();

      $oEntityManager = Zend_Registry::get('em');
      $oConexao       = $oEntityManager->getConnection();

      try {

        $lExistemRegistros = FALSE;

        // Prepara a consulta na base de dados
        $sSql       = self::getSqlRelatorio($lGuiaEmitida);
        $oStatement = $oConexao->prepare($sSql);

        // Limpa as máscaras do CNPJ
        $sPrestadorCnpj = DBSeller_Helper_Number_Format::getNumbers($sPrestadorCnpj);

        // Varre os anos
        for ($iAno = 0; $iAno <= ($iCompetenciaFinalAno - $iCompetenciaInicialAno); $iAno++) {

          $iAnoLoop = intval($iCompetenciaInicialAno) + $iAno;

          // Varre os meses
          for ($iMesLoop = 1; $iMesLoop <= 12; $iMesLoop++) {

            // Ignora os meses anteriores e seguintes aos meses inicial e final
            if ($iAnoLoop == $iCompetenciaInicialAno &&
              $iMesLoop < $iCompetenciaInicialMes ||
              $iAnoLoop == $iCompetenciaFinalAno &&
              $iMesLoop > $iCompetenciaFinalMes
            ) {
              continue;
            }

            // Executa a consulta na base de dados com os parâmetros: cnpj, mês e ano da competência
            $oStatement->execute(array($iMesLoop, $iAnoLoop, $sPrestadorCnpj));

            // Ignora loop caso não possua registros
            if ($oStatement->rowCount() < 1) {
              continue;
            }

            $lExistemRegistros = TRUE;

            // Zera os dados
            $aRelatorio      = NULL;
            $aDadosRelatorio = NULL;

            // Monta os dados do relatório com o índice para ordenação
            do {

              // Busca os dados na base de dados
              $aRelatorio = $oStatement->fetch();

              // Ignora a busca caso não existam resultados
              if (empty($aRelatorio)) {
                continue;
              }

              // Dados do Prestador
              $sPrestadorCnpjCpf            = $aRelatorio['prestador_cnpjcpf'];
              $sPrestadorCnpjCpf            = DBSeller_Helper_Number_Format::maskCPF_CNPJ($sPrestadorCnpjCpf);
              $sPrestadorInscricaoMunicipal = $aRelatorio['prestador_inscricao_municipal'];
              $sPrestadorRazaoSocial        = $aRelatorio['prestador_razao_social'];
              $sPrestadorRazaoSocial        = DBSeller_Helper_String_Format::wordsCap($sPrestadorRazaoSocial);
              $sPrestadorMunicipioUf        = $aRelatorio['prestador_endereco_municipio'];
              $sPrestadorMunicipioUf        = DBSeller_Helper_String_Format::wordsCap($sPrestadorMunicipioUf);
              $sPrestadorMunicipioUf        = "{$sPrestadorMunicipioUf}/{$aRelatorio['prestador_endereco_uf']}";
              $sPrestadorTelefone           = $aRelatorio['prestador_contato_telefone'];
              $sPrestadorTelefone           = DBSeller_Helper_Number_Format::maskPhoneNumber($sPrestadorTelefone);
              $sPrestadorDocumentoNumero    = $aRelatorio['prestador_documento_numero'];
              $oPrestadorDocumentoData      = new DateTime($aRelatorio['prestador_documento_data']);
              $sPrestadorDocumentoTipo      = $aRelatorio['prestador_documento_tipo'];
              $sPrestadorDocumentoValor     = $aRelatorio['prestador_valor_servico'];
              $sPrestadorDocumentoValor     = DBSeller_Helper_Number_Format::toMoney($sPrestadorDocumentoValor, 2);
              $sPrestadorDocumentoAliquota  = $aRelatorio['prestador_valor_aliquota'];
              $sPrestadorDocumentoAliquota  = DBSeller_Helper_Number_Format::toMoney($sPrestadorDocumentoAliquota, 2);
              $sPrestadorDocumentoIss       = $aRelatorio['prestador_valor_iss'];
              $sPrestadorDocumentoIss       = DBSeller_Helper_Number_Format::toMoney($sPrestadorDocumentoIss, 2);
              $sPrestadorDocumentoIssRetido = $aRelatorio['prestador_iss_retido'] ? 'Sim' : 'Não';

              // Dados Tomador
              $sTomadorCnpjCpf            = $aRelatorio['tomador_cnpjcpf'];
              $sTomadorCnpjCpf            = DBSeller_Helper_Number_Format::maskCPF_CNPJ($sTomadorCnpjCpf);
              $sTomadorInscricaoMunicipal = $aRelatorio['tomador_inscricao_municipal'];
              $sTomadorRazaoSocial        = $aRelatorio['tomador_razao_social'];
              $sTomadorRazaoSocial        = DBSeller_Helper_String_Format::wordsCap($sTomadorRazaoSocial);
              $sTomadorMunicipioUf        = $aRelatorio['tomador_endereco_municipio'];
              $sTomadorMunicipioUf        = DBSeller_Helper_String_Format::wordsCap($sTomadorMunicipioUf);
              $sTomadorMunicipioUf        = "{$sTomadorMunicipioUf}/{$aRelatorio['tomador_endereco_uf']}";
              $sTomadorTelefone           = $aRelatorio['tomador_contato_telefone'];
              $sTomadorTelefone           = DBSeller_Helper_Number_Format::maskPhoneNumber($sTomadorTelefone);
              $sTomadorDocumentoNumero    = $aRelatorio['tomador_documento_numero'];
              $oTomadorDocumentoData      = new DateTime($aRelatorio['tomador_documento_data']);
              $sTomadorDocumentoTipo      = $aRelatorio['tomador_documento_tipo'];
              $sTomadorDocumentoValor     = $aRelatorio['tomador_valor_servico'];
              $sTomadorDocumentoValor     = DBSeller_Helper_Number_Format::toMoney($sTomadorDocumentoValor, 2);
              $sTomadorDocumentoAliquota  = $aRelatorio['tomador_valor_aliquota'];
              $sTomadorDocumentoAliquota  = DBSeller_Helper_Number_Format::toMoney($sTomadorDocumentoAliquota, 2);
              $sTomadorDocumentoIss       = $aRelatorio['tomador_valor_iss'];
              $sTomadorDocumentoIss       = DBSeller_Helper_Number_Format::toMoney($sTomadorDocumentoIss, 2);
              $sTomadorDocumentoIssRetido = $aRelatorio['tomador_iss_retido'] ? 'Sim' : 'Não';

              // Descrição do tipo de documento
              $oPrestadorDocumentoTipo = Contribuinte_Model_Nota::getTipoNota($sPrestadorDocumentoTipo);
              $sPrestadorDocumentoTipo = DBSeller_Helper_String_Format::wordsCap($oPrestadorDocumentoTipo->descricao);
              $oTomadorDocumentoTipo   = Contribuinte_Model_Nota::getTipoNota($sTomadorDocumentoTipo);
              $sTomadorDocumentoTipo   = DBSeller_Helper_String_Format::wordsCap($oTomadorDocumentoTipo->descricao);

              // Indice para evitar a repetição do cabeçalho por prestador+tomador
              $sIndiceRelatorio = "{$aRelatorio['prestador_cnpjcpf']}_{$aRelatorio['tomador_cnpjcpf']}";

              // Dados do relatório
              $aDadosRelatorio[$sIndiceRelatorio]['prestador_cnpjcpf']             = $sPrestadorCnpjCpf;
              $aDadosRelatorio[$sIndiceRelatorio]['prestador_inscricao_municipal'] = $sPrestadorInscricaoMunicipal;

              $aDadosRelatorio[$sIndiceRelatorio]['prestador_razao_social'] = utf8_decode($sPrestadorRazaoSocial);
              $aDadosRelatorio[$sIndiceRelatorio]['prestador_municipio_uf'] = utf8_decode($sPrestadorMunicipioUf);

              $aDadosRelatorio[$sIndiceRelatorio]['prestador_telefone']          = $sPrestadorTelefone;
              $aDadosRelatorio[$sIndiceRelatorio]['tomador_cnpjcpf']             = $sTomadorCnpjCpf;
              $aDadosRelatorio[$sIndiceRelatorio]['tomador_inscricao_municipal'] = $sTomadorInscricaoMunicipal;

              $aDadosRelatorio[$sIndiceRelatorio]['tomador_razao_social'] = utf8_decode($sTomadorRazaoSocial);
              $aDadosRelatorio[$sIndiceRelatorio]['tomador_municipio_uf'] = utf8_decode($sTomadorMunicipioUf);

              $aDadosRelatorio[$sIndiceRelatorio]['tomador_telefone'] = $sTomadorTelefone;
              $aDadosRelatorio[$sIndiceRelatorio]['documentos'][]     = array(
                'prestador_doc_numero'         => utf8_decode($sPrestadorDocumentoNumero),
                'prestador_doc_data'           => $oPrestadorDocumentoData,
                'prestador_doc_tipo'           => utf8_decode($sPrestadorDocumentoTipo),
                'prestador_doc_valor_servico'  => utf8_decode($sPrestadorDocumentoValor),
                'prestador_doc_valor_aliquota' => utf8_decode($sPrestadorDocumentoAliquota),
                'prestador_doc_valor_iss'      => utf8_decode($sPrestadorDocumentoIss),
                'prestador_doc_iss_retido'     => utf8_decode($sPrestadorDocumentoIssRetido),
                'tomador_doc_numero'           => utf8_decode($sTomadorDocumentoNumero),
                'tomador_doc_data'             => $oTomadorDocumentoData,
                'tomador_doc_tipo'             => utf8_decode($sTomadorDocumentoTipo),
                'tomador_doc_valor_servico'    => utf8_decode($sTomadorDocumentoValor),
                'tomador_doc_valor_aliquota'   => utf8_decode($sTomadorDocumentoAliquota),
                'tomador_doc_valor_iss'        => utf8_decode($sTomadorDocumentoIss),
                'tomador_doc_iss_retido'       => utf8_decode($sTomadorDocumentoIssRetido)
              );
            } while ($aRelatorio);

            // Ordena a lista de documentos por número
            $aDocumentosOrdenados = DBSeller_Helper_Array_Abstract::ordenarPorIndice(
                                                                  $aDadosRelatorio[$sIndiceRelatorio]['documentos'],
                                                                  'prestador_doc_numero');

            $aDadosRelatorio[$sIndiceRelatorio]['documentos'] = $aDocumentosOrdenados;

            // Ordena os dados do relatorio
            if (isset($aDadosRelatorio) && is_array($aDadosRelatorio)) {

              $aDadosRelatorio = DBSeller_Helper_Array_Abstract::ordenarPorIndice($aDadosRelatorio,
                                                                                  'prestador_cnpjcpf');
            } else {
              throw new Exception($this->translate->_('Erro ao gerar o relatório.'));
            }

            // Calcula a metade da página
            $iMeiaPaginaX = $oPdf->w / 2 - $oPdf->lMargin;

            // Percorre os dados do relatório
            foreach ($aDadosRelatorio as $aRelatorioOrdenado) {

              // Formata o texto da competência
              $sCompetencia = str_pad($iMesLoop, 2, 0, STR_PAD_LEFT) . "/{$iAnoLoop}";

              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell(20, 5, utf8_decode('Competência: '));
              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell(22, 5, $sCompetencia);

              // Dados da guia do prestador
              if ($lGuiaEmitida) {

                $oGuiaPrestador = Contribuinte_Model_Guia::getByCompetenciaAndContribuinte(
                                                         $iAnoLoop,
                                                         $iMesLoop,
                                                         $oPrestador,
                                                         Contribuinte_Model_Guia::$PRESTADOR);

                if (is_array($oGuiaPrestador) &&
                  count($oGuiaPrestador) > 0 &&
                  $oGuiaPrestador[0] instanceof Contribuinte_Model_Guia
                ) {

                  $oGuiaPrestador = reset($oGuiaPrestador);

                  $oPdf->SetFont('Arial', 'B', 8);
                  $oPdf->Cell(13, 5, utf8_decode('Numpre: '));
                  $oPdf->SetFont('Arial', '', 8);
                  $oPdf->Cell(20, 5, $oGuiaPrestador->getNumpre());
                }
              }

              $oPdf->Ln();

              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell($iMeiaPaginaX, 5, 'PRESTADOR', 1, 0, 'L', 1);
              $oPdf->Cell($iMeiaPaginaX, 5, 'TOMADOR', 1, 0, 'L', 1);
              $oPdf->Ln();

              $oPdf->Rect($oPdf->GetX(), $oPdf->GetY(), $iMeiaPaginaX, 25);
              $oPdf->Rect($iMeiaPaginaX + $oPdf->lMargin, $oPdf->GetY(), $iMeiaPaginaX, 25);
              $oPdf->Ln(2);

              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell(28, 4, utf8_decode('Inscrição Municipal:'));
              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell($iMeiaPaginaX - 28, 4, $aRelatorioOrdenado['prestador_inscricao_municipal']);
              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell(28, 4, utf8_decode('Inscrição Municipal:'));
              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell($iMeiaPaginaX - 28, 4, $aRelatorioOrdenado['tomador_inscricao_municipal']);
              $oPdf->Ln();

              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell(16, 4, 'CPNJ/CPF:');
              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell($iMeiaPaginaX - 16, 4, $aRelatorioOrdenado['prestador_cnpjcpf']);
              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell(16, 4, 'CPNJ/CPF:');
              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell($iMeiaPaginaX - 16, 4, $aRelatorioOrdenado['tomador_cnpjcpf']);
              $oPdf->Ln();

              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell(20, 4, utf8_decode('Razão Social:'));
              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell($iMeiaPaginaX - 20, 4, $aRelatorioOrdenado['prestador_razao_social']);
              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell(20, 4, utf8_decode('Razão Social:'));
              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell($iMeiaPaginaX - 20, 4, $aRelatorioOrdenado['tomador_razao_social']);
              $oPdf->Ln();

              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell(20, 4, utf8_decode('Município/UF:'));
              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell($iMeiaPaginaX - 20, 4, $aRelatorioOrdenado['prestador_municipio_uf']);
              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell(20, 4, utf8_decode('Município/UF:'));
              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell($iMeiaPaginaX - 20, 4, $aRelatorioOrdenado['tomador_municipio_uf']);
              $oPdf->Ln(5);

              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell(14, 4, utf8_decode('Telefone:'));
              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell($iMeiaPaginaX - 14, 4, $aRelatorioOrdenado['prestador_telefone']);
              $oPdf->SetFont('Arial', 'B', 8);
              $oPdf->Cell(14, 4, utf8_decode('Telefone:'));
              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell($iMeiaPaginaX - 14, 4, $aRelatorioOrdenado['tomador_telefone']);
              $oPdf->Ln(5);

              if (count($aRelatorioOrdenado['documentos']) > 0) {

                $aLarguraColuna = array(25, 14, 16, 51, 26, 18, 27, 13);

                $oPdf->SetFont('Arial', 'B', 8);
                $oPdf->Cell($aLarguraColuna[0], 5, utf8_decode('Nº do Documento'), 1, 0, 'C', 1);
                $oPdf->Cell($aLarguraColuna[1], 5, utf8_decode('Origem'), 1, 0, 'L', 1);
                $oPdf->Cell($aLarguraColuna[2], 5, utf8_decode('Data'), 1, 0, 'L', 1);
                $oPdf->Cell($aLarguraColuna[3], 5, utf8_decode('Tipo de Documento'), 1, 0, 'L', 1);
                $oPdf->Cell($aLarguraColuna[4], 5, utf8_decode('Valor Serviço (R$)'), 1, 0, 'R', 1);
                $oPdf->Cell($aLarguraColuna[5], 5, utf8_decode('Alíquota (%)'), 1, 0, 'R', 1);
                $oPdf->Cell($aLarguraColuna[6], 5, utf8_decode('Valor Imposto (R$)'), 1, 0, 'R', 1);
                $oPdf->Cell($aLarguraColuna[7], 5, utf8_decode('Subst.'), 1, 0, 'L', 1);
                $oPdf->Ln(5);

                // Flag para exibir a cor de fundo nas células
                $iFundoLinha = 0;

                // Percorre a lista de documentos
                foreach ($aRelatorioOrdenado['documentos'] as $aDocumento) {

                  $lFundoLinha = ($iFundoLinha++ % 2 == 0) ? 0 : 1; // Cor de fundo das linhas (zebra)

                  $oPdf->SetFont('Arial', '', 8);
                  $oPdf->MultiCell($aLarguraColuna[0], 10, $aDocumento['prestador_doc_numero'], 1, 'C', $lFundoLinha);
                  $oPdf->SetY($oPdf->getY() - 10);
                  $oPdf->SetX($oPdf->getX() + $aLarguraColuna[0]);
                  $oPdf->Cell($aLarguraColuna[1], 5, 'Prestador', 1, 0, 'L', $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[2], 5, $aDocumento['prestador_doc_data']->format('d/m/Y'), 1, 0, 'L',
                              $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[3], 5, $aDocumento['prestador_doc_tipo'], 1, 0, 'L', $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[4], 5, $aDocumento['prestador_doc_valor_servico'], 1, 0, 'R',
                              $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[5], 5, $aDocumento['prestador_doc_valor_aliquota'], 1, 0, 'R',
                              $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[6], 5, $aDocumento['prestador_doc_valor_iss'], 1, 0, 'R', $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[7], 5, $aDocumento['prestador_doc_iss_retido'], 1, 0, 'L', $lFundoLinha);
                  $oPdf->Ln(5);

                  $oPdf->Cell($aLarguraColuna[0], 5, '');
                  $oPdf->Cell($aLarguraColuna[1], 5, 'Tomador', 1, 0, 'L', $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[2], 5, $aDocumento['tomador_doc_data']->format('d/m/Y'), 1, 0, 'L',
                              $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[3], 5, $aDocumento['tomador_doc_tipo'], 1, 0, 'L', $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[4], 5, $aDocumento['tomador_doc_valor_servico'], 1, 0, 'R', $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[5], 5, $aDocumento['tomador_doc_valor_aliquota'], 1, 0, 'R',
                              $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[6], 5, $aDocumento['tomador_doc_valor_iss'], 1, 0, 'R', $lFundoLinha);
                  $oPdf->Cell($aLarguraColuna[7], 5, $aDocumento['tomador_doc_iss_retido'], 1, 0, 'L', $lFundoLinha);
                  $oPdf->Ln(5);
                }

                $oPdf->Ln();
              }
            }
          }
        }
      } catch (Exception $oErro) {
        throw new Exception($oErro->getMessage());
      }

      // Verifica se existem registro para gerar o relatório
      if ($lExistemRegistros) {
        $oPdf->Output();
      } else {
        throw new Exception($this->translate->_('Nenhum registro encontrado.'));
      }

      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['url']     = $this->view->baseUrl("tmp/{$sNomeArquivo}");
      $aRetornoJson['success'] = $this->translate->_('Relatório gerado com sucesso.');
    } catch (Exception $oErro) {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['error'][] = $oErro->getMessage();
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Método abstrato para validar o formulário em ambos os relatórios
   *
   * @return array|boolean
   */
  protected function validarFormulario() {

    $aDados        = $this->getRequest()->getPost();
    $aRetornoErros = array();

    $oForm = new Fiscal_Form_Relatorio6();
    $oForm->render();

    // Verifica se os parâmetros do formulário são válidos
    if ($oForm->isValid($aDados)) {

      // Parâmetros do formulário
      $sCompetenciaInicial = $oForm->getValue('data_competencia_inicial');
      $sCompetenciaFinal   = $oForm->getValue('data_competencia_final');
      $sPrestadorCnpj      = $oForm->getValue('prestador_cnpj');

      // Valida se é cadastrado e se é prestador de servico
      $oPrestador = Contribuinte_Model_Contribuinte::getByCpfCnpj($sPrestadorCnpj);

      if (!$oPrestador instanceof Contribuinte_Model_Contribuinte) {

        $sMensagemErro            = $this->translate->_('Contribuinte não cadastrado no sistema.');
        $aRetornoErros['status']  = FALSE;
        $aRetornoErros['fields']  = array('prestador_cnpj');
        $aRetornoErros['error'][] = $this->translate->_($sMensagemErro);

        return $aRetornoErros;
      } else if (!Contribuinte_Model_Servico::getByIm($oPrestador->getInscricaoMunicipal())) {

        $sMensagemErro            = $this->translate->_('O contribuinte não é prestador de serviços.');
        $aRetornoErros['status']  = FALSE;
        $aRetornoErros['fields']  = array('prestador_cnpj');
        $aRetornoErros['error'][] = $this->translate->_($sMensagemErro);

        return $aRetornoErros;
      }

      // Objeto para validação das competências inicial e final
      $oValidaCompetencia = new DBSeller_Validator_Competencia();
      $oValidaCompetencia->setCompetenciaInicial($sCompetenciaInicial);
      $oValidaCompetencia->setCompetenciaFinal($sCompetenciaFinal);

      // Valida a competência inicial e final
      if (!$oValidaCompetencia->isValid($sCompetenciaInicial)) {

        $aRetornoErros['status'] = FALSE;
        $aRetornoErros['fields'] = array('data_competencia_inicial', 'data_competencia_final');
        $aMensagensErro          = $oValidaCompetencia->getMessages();
        $aIndicesErro            = array_keys($aMensagensErro);

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
      $sMensagemErro  = $this->translate->_('Preencha os dados corretamente.');

      if (count($aCamposComErro) > 1) {
        $sMensagemErro = $this->translate->_('Preencha os dados corretamente.');
      } else if (in_array('data_competencia_final', $aCamposComErro)) {
        $sMensagemErro = $this->translate->_('Informe a Competência Final corretamente.');
      } else if (in_array('data_competencia_inicial', $aCamposComErro)) {
        $sMensagemErro = $this->translate->_('Informe a Competência Inicial corretamente.');
      }

      $aRetornoErros['status']  = FALSE;
      $aRetornoErros['fields']  = array_keys($oForm->getMessages());
      $aRetornoErros['error'][] = $this->translate->_($sMensagemErro);
    }

    return $aRetornoErros;
  }

  /**
   * Força o download dos relatórios
   */
  public function downloadAction() {

    parent::noLayout();
    parent::download($this->getRequest()->getParam('arquivo'));
  }

  /**
   * Retorna o script sql para geração do relatório
   *
   * @param boolean $lGuiaEmitida
   * @return string
   */
  private static function getSqlRelatorio($lGuiaEmitida = FALSE) {

    $sGuiaEmitida = $lGuiaEmitida ? ' IS NOT NULL ' : ' IS NULL ';

    return "SELECT servico_prestado.prestador_cnpjcpf             AS prestador_cnpjcpf
                  ,servico_prestado.prestador_razao_social        AS prestador_razao_social
                  ,servico_prestado.prestador_inscricao_municipal AS prestador_inscricao_municipal
                  ,servico_prestado.prestador_endereco_uf         AS prestador_endereco_uf
                  ,servico_prestado_municipio.nome                AS prestador_endereco_municipio
                  ,servico_prestado.prestador_contato_telefone    AS prestador_contato_telefone
                  ,servico_prestado.documento_numero              AS prestador_documento_numero
                  ,servico_prestado.documento_data                AS prestador_documento_data
                  ,servico_prestado.documento_tipo                AS prestador_documento_tipo
                  ,servico_prestado.servico_valor_servicos        AS prestador_valor_servico
                  ,servico_prestado.servico_valor_aliquota        AS prestador_valor_aliquota
                  ,servico_prestado.servico_valor_iss             AS prestador_valor_iss
                  ,servico_prestado.servico_iss_retido            AS prestador_iss_retido
                  ,servico_tomado.tomador_cnpjcpf                 AS tomador_cnpjcpf
                  ,servico_tomado.tomador_razao_social            AS tomador_razao_social
                  ,servico_tomado.tomador_inscricao_municipal     AS tomador_inscricao_municipal
                  ,servico_tomado.prestador_endereco_uf           AS tomador_endereco_uf
                  ,servico_tomado_municipio.nome                  AS tomador_endereco_municipio
                  ,servico_tomado.tomador_contato_telefone        AS tomador_contato_telefone
                  ,servico_tomado.documento_numero                AS tomador_documento_numero
                  ,servico_tomado.documento_data                  AS tomador_documento_data
                  ,servico_tomado.documento_tipo                  AS tomador_documento_tipo
                  ,servico_tomado.servico_valor_servicos          AS tomador_valor_servico
                  ,servico_tomado.servico_valor_aliquota          AS tomador_valor_aliquota
                  ,servico_tomado.servico_valor_iss               AS tomador_valor_iss
                  ,servico_tomado.servico_iss_retido              AS tomador_iss_retido
              FROM view_nota_mais_dms servico_prestado
         LEFT JOIN view_nota_mais_dms servico_tomado ON (
                   servico_prestado.documento_classe              = 'nfse'
               AND servico_prestado.prestador_cnpjcpf             = servico_tomado.prestador_cnpjcpf
               AND servico_prestado.tomador_cnpjcpf               = servico_tomado.tomador_cnpjcpf
               AND servico_prestado.documento_numero              = servico_tomado.documento_numero
               AND servico_prestado.documento_id_contribuinte    != servico_tomado.documento_id_contribuinte
               AND servico_prestado.documento_id_nota_substituta  IS NULL
              AND (servico_prestado.documento_status_cancelamento = FALSE
                OR servico_prestado.documento_status_cancelamento IS NULL)
               AND servico_prestado.documento_competencia_mes     = ?
               AND servico_prestado.documento_competencia_ano     = ?
               AND servico_prestado.prestador_cnpjcpf             = ?)
         LEFT JOIN municipios servico_prestado_municipio ON (
                   servico_prestado.prestador_endereco_municipio_codigo || '' = servico_prestado_municipio.cod_ibge)
         LEFT JOIN municipios servico_tomado_municipio ON (
                   servico_tomado.prestador_endereco_municipio_codigo || '' = servico_tomado_municipio.cod_ibge)
         LEFT JOIN guias_notas servico_prestador_guia_numpre ON (
                   servico_prestador_guia_numpre.id_nota = servico_prestado.documento_id)
             WHERE
                   servico_tomado.documento_numero IS NOT NULL
               AND servico_prestador_guia_numpre.id_guia {$sGuiaEmitida}
          ORDER BY servico_prestado.prestador_cnpjcpf
                  ,servico_tomado.prestador_cnpjcpf
                  ,servico_prestado.documento_numero";
  }
}