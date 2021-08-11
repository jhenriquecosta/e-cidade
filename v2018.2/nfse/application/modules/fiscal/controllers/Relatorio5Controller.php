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
 * Classe para controle do relatório 11 do módulo fiscal
 *
 * @package Fiscal/Controllers
 */

/**
 * @package Fiscal/Controllers
 */
class Fiscal_Relatorio5Controller extends Fiscal_Lib_Controller_AbstractController {

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
   * Tela para o relatório de insconstências nas declarações
   */
  public function inconsistenciasDeclaracoesAction() {

    $oForm = new Fiscal_Form_Relatorio5();
    $oForm->setAction('/fiscal/relatorio5/inconsistencias-declaracoes-gerar');

    $this->view->form = $oForm->render();
    $this->view->headScript()->offsetSetFile(50, $this->view->baseUrl('/fiscal/js/relatorios/script-compartilhado.js'));
  }

  /**
   * Geração do relatório de insconstências nas declarações
   */
  public function inconsistenciasDeclaracoesGerarAction() {

    parent::noLayout();

    $aValidacaoFormulario = self::validarFormulario();

    if (is_array($aValidacaoFormulario)) {
      exit($this->getHelper('json')->sendJson($aValidacaoFormulario));
    }

    try {

      // Parâmetros do formulário
      $sCompetencia = $this->getRequest()->getParam('data_competencia_inicial');

      // Separa os meses e anos
      $iCompetenciaMes = intval(substr($sCompetencia, 0, 2));
      $iCompetenciaAno = intval(substr($sCompetencia, -4));
      $sNomeArquivo    = 'relatorio_inconsistencias_declaracoes_' . date('YmdHis') . '.pdf';

      $oPdf = new Fiscal_Model_Relatoriopdfmodelo1('P');
      $oPdf->SetFillColor(220, 220, 220);
      $oPdf->Open(APPLICATION_PATH . "/../public/tmp/{$sNomeArquivo}");
      $oPdf->setLinhaFiltro('Relatório de Inconsistências nas Declarações');
      $oPdf->setLinhaFiltro('');
      $oPdf->setLinhaFiltro("FILTRO: Competência {$sCompetencia}");
      $oPdf->carregaDados();

      $oEntityManager = Zend_Registry::get('em');
      $oConexao       = $oEntityManager->getConnection();

      try {

        $sSql       = self::getSqlRelatorio();
        $oStatement = $oConexao->prepare($sSql);
        $oStatement->execute(array($iCompetenciaMes, $iCompetenciaAno));

        if ($oStatement->rowCount() < 1) {
          throw new Exception($this->translate->_('Nenhum registro encontrado.'));
        }

        $aRelatorio = NULL;

        // Monta os dados do relatório com o índice para ordenação
        do {

          $aRelatorio = $oStatement->fetch();

          if (empty($aRelatorio)) {
            continue;
          }

          // Dados do Prestador
          $sPrestadorCnpjCpf            = $aRelatorio['prestador_cnpjcpf'];
          $sPrestadorCnpjCpf            = DBSeller_Helper_Number_Format::maskCPF_CNPJ($sPrestadorCnpjCpf);
          $sPrestadorRazaoSocial        = $aRelatorio['prestador_razao_social'];
          $sPrestadorRazaoSocial        = DBSeller_Helper_String_Format::wordsCap($sPrestadorRazaoSocial);
          $sPrestadorMunicipioUf        = $aRelatorio['prestador_endereco_municipio'];
          $sPrestadorMunicipioUf        = DBSeller_Helper_String_Format::wordsCap($sPrestadorMunicipioUf);
          $sPrestadorMunicipioUf        = "{$sPrestadorMunicipioUf}/{$aRelatorio['prestador_endereco_uf']}";
          $sPrestadorTelefone           = $aRelatorio['prestador_contato_telefone'];
          $sPrestadorTelefone           = DBSeller_Helper_Number_Format::maskPhoneNumber($sPrestadorTelefone);
          $sPrestadorDocumentoNumero    = $aRelatorio['prestador_documento_numero'];
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
          $sTomadorRazaoSocial        = $aRelatorio['tomador_razao_social'];
          $sTomadorRazaoSocial        = DBSeller_Helper_String_Format::wordsCap($sTomadorRazaoSocial);
          $sTomadorMunicipioUf        = $aRelatorio['tomador_endereco_municipio'];
          $sTomadorMunicipioUf        = DBSeller_Helper_String_Format::wordsCap($sTomadorMunicipioUf);
          $sTomadorMunicipioUf        = "{$sTomadorMunicipioUf}/{$aRelatorio['tomador_endereco_uf']}";
          $sTomadorTelefone           = $aRelatorio['tomador_contato_telefone'];
          $sTomadorTelefone           = DBSeller_Helper_Number_Format::maskPhoneNumber($sTomadorTelefone);
          $sTomadorDocumentoNumero    = $aRelatorio['tomador_documento_numero'];
          $sTomadorDocumentoTipo      = $aRelatorio['tomador_documento_tipo'];
          $sTomadorDocumentoValor     = $aRelatorio['tomador_valor_servico'];
          $sTomadorDocumentoValor     = DBSeller_Helper_Number_Format::toMoney($sTomadorDocumentoValor, 2);
          $sTomadorDocumentoAliquota  = $aRelatorio['tomador_valor_aliquota'];
          $sTomadorDocumentoAliquota  = DBSeller_Helper_Number_Format::toMoney($sTomadorDocumentoAliquota, 2);
          $sTomadorDocumentoIss       = $aRelatorio['tomador_valor_iss'];
          $sTomadorDocumentoIss       = DBSeller_Helper_Number_Format::toMoney($sTomadorDocumentoIss, 2);
          $sTomadorDocumentoIssRetido = $aRelatorio['tomador_iss_retido'] ? 'Sim' : 'Não';

          // Pega a descrição do documento tomado, pois NFSE não tem tipo definido
          $sPrestadorDocumentoTipo = $sPrestadorDocumentoTipo ? : $sTomadorDocumentoTipo;

          // Descrição do tipo de documento
          $oPrestadorDocumentoTipo = Contribuinte_Model_Nota::getTipoNota($sPrestadorDocumentoTipo);
          $sPrestadorDocumentoTipo = DBSeller_Helper_String_Format::wordsCap($oPrestadorDocumentoTipo->descricao);
          $oTomadorDocumentoTipo   = Contribuinte_Model_Nota::getTipoNota($sTomadorDocumentoTipo);
          $sTomadorDocumentoTipo   = DBSeller_Helper_String_Format::wordsCap($oTomadorDocumentoTipo->descricao);

          // Indice para evitar a repetição do cabeçalho por prestador+tomador
          $sIndiceRelatorio = "{$aRelatorio['prestador_cnpjcpf']}_{$aRelatorio['tomador_cnpjcpf']}";

          // Dados do relatório
          $aDadosRelatorio[$sIndiceRelatorio]['prestador_cnpjcpf']      = utf8_decode($sPrestadorCnpjCpf);
          $aDadosRelatorio[$sIndiceRelatorio]['prestador_razao_social'] = utf8_decode($sPrestadorRazaoSocial);
          $aDadosRelatorio[$sIndiceRelatorio]['prestador_municipio_uf'] = utf8_decode($sPrestadorMunicipioUf);
          $aDadosRelatorio[$sIndiceRelatorio]['prestador_telefone']     = utf8_decode($sPrestadorTelefone);
          $aDadosRelatorio[$sIndiceRelatorio]['tomador_cnpjcpf']        = utf8_decode($sTomadorCnpjCpf);
          $aDadosRelatorio[$sIndiceRelatorio]['tomador_razao_social']   = utf8_decode($sTomadorRazaoSocial);
          $aDadosRelatorio[$sIndiceRelatorio]['tomador_municipio_uf']   = utf8_decode($sTomadorMunicipioUf);
          $aDadosRelatorio[$sIndiceRelatorio]['tomador_telefone']       = utf8_decode($sTomadorTelefone);
          $aDadosRelatorio[$sIndiceRelatorio]['documentos'][]           = array(
            'prestador_doc_numero'         => utf8_decode($sPrestadorDocumentoNumero),
            'prestador_doc_tipo'           => utf8_decode($sPrestadorDocumentoTipo),
            'prestador_doc_valor_servico'  => utf8_decode($sPrestadorDocumentoValor),
            'prestador_doc_valor_aliquota' => utf8_decode($sPrestadorDocumentoAliquota),
            'prestador_doc_valor_iss'      => utf8_decode($sPrestadorDocumentoIss),
            'prestador_doc_iss_retido'     => utf8_decode($sPrestadorDocumentoIssRetido),
            'tomador_doc_numero'           => utf8_decode($sTomadorDocumentoNumero),
            'tomador_doc_tipo'             => utf8_decode($sTomadorDocumentoTipo),
            'tomador_doc_valor_servico'    => utf8_decode($sTomadorDocumentoValor),
            'tomador_doc_valor_aliquota'   => utf8_decode($sTomadorDocumentoAliquota),
            'tomador_doc_valor_iss'        => utf8_decode($sTomadorDocumentoIss),
            'tomador_doc_iss_retido'       => utf8_decode($sTomadorDocumentoIssRetido)
          );
        } while ($aRelatorio);

        // Ordena os dados do relatorio
        if (isset($aDadosRelatorio) && is_array($aDadosRelatorio)) {
          $aDadosRelatorio = DBSeller_Helper_Array_Abstract::ordenarPorIndice($aDadosRelatorio, 'prestador_cnpjcpf');
        } else {
          throw new Exception($this->translate->_('Erro ao gerar o relatório.'));
        }

        $iMeiaPaginaX = $oPdf->w / 2 - $oPdf->lMargin;

        // Percorre os dados do relatório
        foreach ($aDadosRelatorio as $aRelatorioOrdenado) {

          $oPdf->SetFont('Arial', 'B', 8);
          $oPdf->Cell($iMeiaPaginaX, 5, 'PRESTADOR');
          $oPdf->Cell($iMeiaPaginaX, 5, 'TOMADOR');
          $oPdf->Ln();
          $oPdf->Rect($oPdf->GetX(), $oPdf->GetY(), $iMeiaPaginaX, 15);
          $oPdf->Rect($iMeiaPaginaX + $oPdf->lMargin, $oPdf->GetY(), $iMeiaPaginaX, 15);
          $oPdf->Ln(2);
          $oPdf->SetFont('Arial', 'B', 8);
          $oPdf->Cell(20, 4, 'CPNJ/CPF:');
          $oPdf->SetFont('Arial', '', 8);
          $oPdf->Cell($iMeiaPaginaX - 20, 4, $aRelatorioOrdenado['prestador_cnpjcpf']);
          $oPdf->SetFont('Arial', 'B', 8);
          $oPdf->Cell(20, 4, 'CPNJ/CPF:');
          $oPdf->SetFont('Arial', '', 8);
          $oPdf->Cell($iMeiaPaginaX - 20, 4, $aRelatorioOrdenado['tomador_cnpjcpf']);
          $oPdf->Ln();
          $oPdf->SetFont('Arial', 'B', 8);
          $oPdf->Cell(20, 4, utf8_decode('Razão Social'));
          $oPdf->SetFont('Arial', '', 8);
          $oPdf->Cell($iMeiaPaginaX - 20, 4, $aRelatorioOrdenado['prestador_razao_social']);
          $oPdf->SetFont('Arial', 'B', 8);
          $oPdf->Cell(20, 4, utf8_decode('Razão Social'));
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

          if (count($aRelatorioOrdenado['documentos']) > 0) {

            $aLarguraColuna = array(28, 15, 64, 26, 19, 27, 11);

            $oPdf->SetFont('Arial', 'B', 8);
            $oPdf->Cell($aLarguraColuna[0], 5, utf8_decode('Nº do Documento'), 1, 0, 'C', 1);
            $oPdf->Cell($aLarguraColuna[1], 5, utf8_decode('Origem'), 1, 0, 'L', 1);
            $oPdf->Cell($aLarguraColuna[2], 5, utf8_decode('Tipo de Documento'), 1, 0, 'L', 1);
            $oPdf->Cell($aLarguraColuna[3], 5, utf8_decode('Valor Serviço (R$)'), 1, 0, 'R', 1);
            $oPdf->Cell($aLarguraColuna[4], 5, utf8_decode('Alíquota (%)'), 1, 0, 'R', 1);
            $oPdf->Cell($aLarguraColuna[5], 5, utf8_decode('Valor Imposto (R$)'), 1, 0, 'R', 1);
            $oPdf->Cell($aLarguraColuna[6], 5, utf8_decode('Subst.'), 1, 0, 'L', 1);
            $oPdf->Ln(5);

            $iFundo = 0; // Alterador do fundo da linha (Zebra)

            // Percorre os documentos do relatório
            foreach ($aRelatorioOrdenado['documentos'] as $aDocumento) {

              $lFundoLinha = ($iFundo++ % 2 == 0) ? 0 : 1;

              $oPdf->SetFont('Arial', '', 8);
              $oPdf->MultiCell($aLarguraColuna[0], 10, $aDocumento['prestador_doc_numero'], 1, 'C', $lFundoLinha);
              $oPdf->SetY($oPdf->getY() - 10);
              $oPdf->SetX($oPdf->getX() + $aLarguraColuna[0]);
              $oPdf->Cell($aLarguraColuna[1], 5, 'Prestador', 1, 0, 'L', $lFundoLinha);
              $oPdf->Cell($aLarguraColuna[2], 5, $aDocumento['prestador_doc_tipo'], 1, 0, 'L', $lFundoLinha);
              $oPdf->Cell($aLarguraColuna[3], 5, $aDocumento['prestador_doc_valor_servico'], 1, 0, 'R', $lFundoLinha);
              $oPdf->Cell($aLarguraColuna[4], 5, $aDocumento['prestador_doc_valor_aliquota'], 1, 0, 'R', $lFundoLinha);
              $oPdf->Cell($aLarguraColuna[5], 5, $aDocumento['prestador_doc_valor_iss'], 1, 0, 'R', $lFundoLinha);
              $oPdf->Cell($aLarguraColuna[6], 5, $aDocumento['prestador_doc_iss_retido'], 1, 0, 'L', $lFundoLinha);
              $oPdf->Ln(5);
              $oPdf->Cell($aLarguraColuna[0], 5, '');
              $oPdf->Cell($aLarguraColuna[1], 5, 'Tomador', 1, 0, 'L', $lFundoLinha);
              $oPdf->Cell($aLarguraColuna[2], 5, $aDocumento['tomador_doc_tipo'], 1, 0, 'L', $lFundoLinha);
              $oPdf->Cell($aLarguraColuna[3], 5, $aDocumento['tomador_doc_valor_servico'], 1, 0, 'R', $lFundoLinha);
              $oPdf->Cell($aLarguraColuna[4], 5, $aDocumento['tomador_doc_valor_aliquota'], 1, 0, 'R', $lFundoLinha);
              $oPdf->Cell($aLarguraColuna[5], 5, $aDocumento['tomador_doc_valor_iss'], 1, 0, 'R', $lFundoLinha);
              $oPdf->Cell($aLarguraColuna[6], 5, $aDocumento['tomador_doc_iss_retido'], 1, 0, 'L', $lFundoLinha);
              $oPdf->Ln(5);
            }

            $oPdf->Ln();
          }
        }
      } catch (Exception $oErro) {
        throw new Exception($oErro->getMessage());
      }

      $oPdf->Output();

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

    $oForm = new Fiscal_Form_Relatorio5();
    $oForm->render();

    // Verifica se os parâmetros do formulário são válidos
    if ($oForm->isValid($aDados)) {

      // Parâmetros do formulário
      $sCompetencia       = $this->getRequest()->getParam('data_competencia_inicial', NULL);
      $oValidaCompetencia = new DBSeller_Validator_Competencia();
      $oValidaCompetencia->setCompetenciaInicial($sCompetencia);
      $oValidaCompetencia->setCompetenciaFinal($sCompetencia);

      // Valida a competência inicial e final
      if (!$oValidaCompetencia->isValid($sCompetencia)) {

        $aRetornoErros['status'] = FALSE;
        $aRetornoErros['fields'] = array('data_competencia_inicial');
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
      } else if (in_array('data_competencia', $aCamposComErro)) {
        $sMensagemErro = $this->translate->_('Informe a Competência corretamente.');
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
   * @return string
   */
  private static function getSqlRelatorio() {

    return " SELECT servico_prestado.prestador_cnpjcpf            AS prestador_cnpjcpf
                   ,servico_prestado.prestador_razao_social       AS prestador_razao_social
                   ,servico_prestado.prestador_endereco_uf        AS prestador_endereco_uf
                   ,servico_prestado_municipio.nome               AS prestador_endereco_municipio
                   ,servico_prestado.prestador_contato_telefone   AS prestador_contato_telefone
                   ,servico_prestado.documento_numero             AS prestador_documento_numero
                   ,servico_prestado.documento_tipo               AS prestador_documento_tipo
                   ,servico_prestado.servico_valor_servicos       AS prestador_valor_servico
                   ,servico_prestado.servico_valor_aliquota       AS prestador_valor_aliquota
                   ,servico_prestado.servico_valor_iss            AS prestador_valor_iss
                   ,servico_prestado.servico_iss_retido           AS prestador_iss_retido
                   ,servico_tomado.tomador_cnpjcpf                AS tomador_cnpjcpf
                   ,servico_tomado.tomador_razao_social           AS tomador_razao_social
                   ,servico_tomado.prestador_endereco_uf          AS tomador_endereco_uf
                   ,servico_tomado_municipio.nome                 AS tomador_endereco_municipio
                   ,servico_tomado.tomador_contato_telefone       AS tomador_contato_telefone
                   ,servico_tomado.documento_numero               AS tomador_documento_numero
                   ,servico_tomado.documento_tipo                 AS tomador_documento_tipo
                   ,servico_tomado.servico_valor_servicos         AS tomador_valor_servico
                   ,servico_tomado.servico_valor_aliquota         AS tomador_valor_aliquota
                   ,servico_tomado.servico_valor_iss              AS tomador_valor_iss
                   ,servico_tomado.servico_iss_retido             AS tomador_iss_retido
               FROM view_nota_mais_dms servico_prestado
          LEFT JOIN view_nota_mais_dms servico_tomado ON (
                    servico_prestado.prestador_cnpjcpf             = servico_tomado.prestador_cnpjcpf
                AND servico_prestado.tomador_cnpjcpf               = servico_tomado.tomador_cnpjcpf
                AND servico_prestado.documento_numero              = servico_tomado.documento_numero
                AND servico_prestado.documento_grupo               = servico_tomado.documento_grupo
                AND servico_prestado.documento_id_contribuinte    != servico_tomado.documento_id_contribuinte
               AND (servico_prestado.servico_valor_servicos       != servico_tomado.servico_valor_servicos
                 OR servico_prestado.servico_valor_aliquota       != servico_tomado.servico_valor_aliquota
                 OR servico_prestado.servico_valor_base_calculo   != servico_tomado.servico_valor_base_calculo
                 OR servico_prestado.servico_valor_condicionado   != servico_tomado.servico_valor_condicionado
                 OR servico_prestado.servico_valor_incondicionado != servico_tomado.servico_valor_incondicionado)
                AND servico_prestado.documento_id_contribuinte    != servico_tomado.documento_id_contribuinte)
          LEFT JOIN municipios servico_prestado_municipio ON (
                    servico_prestado.prestador_endereco_municipio_codigo || '' = servico_prestado_municipio.cod_ibge)
          LEFT JOIN municipios servico_tomado_municipio   ON (
                    servico_tomado.prestador_endereco_municipio_codigo || ''   = servico_tomado_municipio.cod_ibge)
             WHERE (servico_prestado.dms_operacao                 != 'e' OR servico_prestado.dms_operacao IS NULL)
                AND servico_prestado.documento_competencia_mes     = ?
                AND servico_prestado.documento_competencia_ano     = ?
               AND (servico_prestado.documento_status_cancelamento = FALSE
                 OR servico_prestado.documento_status_cancelamento IS NULL)
                AND servico_prestado.documento_situacao            NOT IN ('C', 'E')
                AND servico_prestado.documento_natureza_operacao   = 1
                AND servico_tomado.documento_numero                IS NOT NULL
           ORDER BY servico_prestado.prestador_cnpjcpf
                   ,servico_tomado.prestador_cnpjcpf
                   ,servico_prestado.documento_grupo
                   ,servico_prestado.documento_numero";
  }
}