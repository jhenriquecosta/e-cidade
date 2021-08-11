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
 * Classe para controle do relatório3 do módulo fiscal
 *
 * @package Fiscal/Controllers
 */

/**
 * @package Fiscal/Controllers
 */
class Fiscal_Relatorio3Controller extends Fiscal_Lib_Controller_AbstractController {

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
   * Tela para o relatório de declarações sem movimento
   */
  public function comparativoDeclaracoesAction() {

    $oForm = new Fiscal_Form_Relatorio3();
    $oForm->setAction('/fiscal/relatorio3/comparativo-declaracoes-gerar');

    $this->view->form = $oForm->render();
    $this->view->headScript()->offsetSetFile(50, $this->view->baseUrl('/fiscal/js/relatorios/script-compartilhado.js'));
  }

  /**
   * Geração do relatório de declarações sem movimento
   */
  public function comparativoDeclaracoesGerarAction() {

    parent::noLayout();

    $aValidacaoFormulario = self::validarFormulario();

    if (is_array($aValidacaoFormulario)) {
      exit($this->getHelper('json')->sendJson($aValidacaoFormulario));
    }

    try {

      // Parâmetros do formulário
      $sOrdenacaoCampo   = $this->getRequest()->getParam('ordenacao');
      $sOrdenacaoDirecao = $this->getRequest()->getParam('ordem');
      $sCompetencia      = $this->getRequest()->getParam('data_competencia_inicial');

      // Separa os meses e anos
      $iCompetenciaMes   = intval(substr($sCompetencia, 0, 2));
      $iCompetenciaAno   = intval(substr($sCompetencia, -4));
      $sNomeArquivo      = 'relatorio_comparativo_declaracoes_' . date('YmdHis') . '.pdf';
      $aDescricaoFiltros = array(
        'tomador_cnpjcpf'      => 'CPF/CNPJ',
        'tomador_razao_social' => 'Nome/Razão Social Tomador',
        'asc'                  => 'Crescente',
        'desc'                 => 'Decrescente'
      );

      $oPdf = new Fiscal_Model_Relatoriopdfmodelo1('L');
      $oPdf->Open(APPLICATION_PATH . "/../public/tmp/{$sNomeArquivo}");
      $oPdf->setLinhaFiltro('Relatório Comparativo de Declarações');
      $oPdf->setLinhaFiltro('');
      $oPdf->setLinhaFiltro("FILTRO: Competência {$sCompetencia}");
      $oPdf->setLinhaFiltro("ORDEM: {$aDescricaoFiltros[$sOrdenacaoCampo]} ({$aDescricaoFiltros[$sOrdenacaoDirecao]})");
      $oPdf->carregaDados();

      $oEntityManager = Zend_Registry::get('em');
      $oConexao       = $oEntityManager->getConnection();

      try {

        $sSql       = self::getSqlRelatorio();
        $oStatement = $oConexao->prepare($sSql);
        $oStatement->execute(array(Contribuinte_Model_Dms::ENTRADA, $iCompetenciaMes, $iCompetenciaAno));

        if ($oStatement->rowCount() < 1) {
          throw new Exception('Nenhum registro encontrado.');
        }

        $aRelatorio = NULL;

        // Monta o array com o registros formatados
        do {

          $aRelatorio = $oStatement->fetch();

          if (empty($aRelatorio)) {
            continue;
          }

          // Tipo de documento
          $oDocumentoTipo = Contribuinte_Model_Nota::getTipoNota($aRelatorio['documento_tipo']);
          $sDocumentoTipo = DBSeller_Helper_String_Format::wordsCap($oDocumentoTipo->descricao);

          // Formata os dados
          $iTomadorCnpj          = $aRelatorio['tomador_cnpjcpf'];
          $sTomadorRazaoSocial   = DBSeller_Helper_String_Format::wordsCap($aRelatorio['tomador_razao_social']);
          $sPrestadorCnpjCpf     = DBSeller_Helper_Number_Format::maskCPF_CNPJ($aRelatorio['prestador_cnpjcpf']);
          $sPrestadorRazaoSocial = DBSeller_Helper_String_Format::wordsCap($aRelatorio['prestador_razao_social']);
          $sPrestadorTelefone    = $aRelatorio['prestador_contato_telefone'];
          $sPrestadorTelefone    = DBSeller_Helper_Number_Format::maskPhoneNumber($sPrestadorTelefone);
          $sValorServico         = DBSeller_Helper_Number_Format::toMoney($aRelatorio['servico_valor_servicos'], 2);

          // Dados do relatorio organizado por índice
          $aDadosRelatorio[$iTomadorCnpj]['tomador_cnpjcpf']      = $iTomadorCnpj;
          $aDadosRelatorio[$iTomadorCnpj]['tomador_razao_social'] = $sTomadorRazaoSocial;
          $aDadosRelatorio[$iTomadorCnpj]['documentos'][]         = array(
            'documento_numero'           => $aRelatorio['documento_numero'],
            'documento_tipo'             => $sDocumentoTipo,
            'prestador_cnpjcpf'          => $sPrestadorCnpjCpf,
            'prestador_razao_social'     => $sPrestadorRazaoSocial,
            'prestador_contato_telefone' => $sPrestadorTelefone,
            'servico_valor_servicos'     => $sValorServico
          );
        } while ($aRelatorio);

        // Dados do relatorio na ordem informada
        $aDadosRelatorioOrdenado = DBSeller_Helper_Array_Abstract::ordenarPorIndice($aDadosRelatorio,
                                                                                    $sOrdenacaoCampo,
                                                                                    $sOrdenacaoDirecao,
                                                                                    FALSE);

        // Percorre os dados do relatório, já ordenado
        foreach ($aDadosRelatorioOrdenado as $aRelatorioOrdenado) {

          $sCpfCnpjTomador = DBSeller_Helper_Number_Format::maskCPF_CNPJ($aRelatorioOrdenado['tomador_cnpjcpf']);
          $sRazaoTomador   = $aRelatorioOrdenado['tomador_razao_social'];

          // Divisor com as informações do tomador
          $oPdf->SetFont('Arial', 'B', 8);
          $oPdf->Cell(29, 5, utf8_decode('CPNJ/CPF Tomador:'));
          $oPdf->SetFont('Arial', '', 8);
          $oPdf->Cell(30, 5, utf8_decode($sCpfCnpjTomador));
          $oPdf->SetFont('Arial', 'B', 8);
          $oPdf->Cell(32, 5, utf8_decode('Razão Social Tomador:'));
          $oPdf->SetFont('Arial', '', 8);
          $oPdf->Cell(0, 5, utf8_decode($sRazaoTomador));
          $oPdf->Ln();

          // Cabeçalho com a lista de documentos do tomador
          if (count($aRelatorioOrdenado['documentos']) > 0) {

            $oPdf->SetFont('Arial', 'B', 8);
            $oPdf->Cell(28, 5, utf8_decode('Nº do Documento'), 1, 0, 'C');
            $oPdf->Cell(50, 5, utf8_decode('Tipo de Documento'), 1, 0, 'L');
            $oPdf->Cell(35, 5, utf8_decode('CNPJ/CPF do Prestador'), 1, 0, 'L');
            $oPdf->Cell(110, 5, utf8_decode('Razão Social do Prestador'), 1, 0, 'L');
            $oPdf->Cell(30, 5, utf8_decode('Telefone'), 1, 0, 'L');
            $oPdf->Cell(24, 5, utf8_decode('Valor (R$)'), 1, 0, 'R');
            $oPdf->Ln(5);

            // Percorre os documentos do tomador
            foreach ($aRelatorioOrdenado['documentos'] as $aRelatorioDocumento) {

              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell(28, 5, utf8_decode($aRelatorioDocumento['documento_numero']), 1, 0, 'C');
              $oPdf->Cell(50, 5, utf8_decode($aRelatorioDocumento['documento_tipo']), 1, 0, 'L');
              $oPdf->Cell(35, 5, utf8_decode($aRelatorioDocumento['prestador_cnpjcpf']), 1, 0, 'L');
              $oPdf->Cell(110, 5, utf8_decode($aRelatorioDocumento['prestador_razao_social']), 1, 0, 'L');
              $oPdf->Cell(30, 5, utf8_decode($aRelatorioDocumento['prestador_contato_telefone']), 1, 0, 'L');
              $oPdf->Cell(24, 5, utf8_decode($aRelatorioDocumento['servico_valor_servicos']), 1, 0, 'R');
              $oPdf->Ln(5);
            }

            $oPdf->Ln();
          }
        }
      } catch (Exception $oErro) {
        throw new Exception($oErro->getMessage());
      }

      // Renderiza o arquivo PDF
      $oPdf->Output();

      // Mensagem de retorno com o link do arquivo PDF
      $aRetornoJson['status']  = TRUE;
      $aRetornoJson['url']     = $this->view->baseUrl("tmp/{$sNomeArquivo}");
      $aRetornoJson['success'] = $this->translate->_('Arquivo importado com sucesso.');
    } catch (Exception $oErro) {

      $aRetornoJson['status']  = FALSE;
      $aRetornoJson['error'][] = $oErro->getMessage();
    }

    echo $this->getHelper('json')->sendJson($aRetornoJson);
  }

  /**
   * Método abstrato para validar o formulário em ambos os relatórios
   *
   * @return array|bool
   */
  protected function validarFormulario() {

    $aDados        = $this->getRequest()->getPost();
    $aRetornoErros = array();
    $oForm         = new Fiscal_Form_Relatorio3();
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

        $aMensagensErro = $oValidaCompetencia->getMessages();
        $aIndicesErro   = array_keys($aMensagensErro);

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

    return " SELECT servico_tomado.documento_numero              AS documento_numero
                   ,servico_tomado.documento_tipo                AS documento_tipo
                   ,servico_tomado.tomador_cnpjcpf               AS tomador_cnpjcpf
                   ,servico_tomado.tomador_razao_social          AS tomador_razao_social
                   ,servico_tomado.prestador_cnpjcpf             AS prestador_cnpjcpf
                   ,servico_tomado.prestador_razao_social        AS prestador_razao_social
                   ,servico_tomado.prestador_contato_telefone    AS prestador_contato_telefone
                   ,servico_tomado.servico_valor_servicos        AS servico_valor_servicos
               FROM view_nota_mais_dms servico_tomado
          LEFT JOIN view_nota_mais_dms servico_prestado ON (
                    servico_prestado.prestador_cnpjcpf            = servico_tomado.prestador_cnpjcpf
                AND servico_prestado.tomador_cnpjcpf              = servico_tomado.tomador_cnpjcpf
                AND servico_prestado.documento_numero             = servico_tomado.documento_numero
                AND servico_prestado.documento_grupo              = servico_tomado.documento_grupo
                AND servico_prestado.documento_id_contribuinte   != servico_tomado.documento_id_contribuinte)
              WHERE servico_tomado.dms_operacao                   IS NOT NULL
                AND servico_tomado.dms_operacao                   = ?
                AND servico_prestado.documento_numero             IS NULL
                AND servico_prestado.documento_id_nota_substituta IS NULL
                AND servico_tomado.documento_competencia_mes      = ?
                AND servico_tomado.documento_competencia_ano      = ?
                AND servico_tomado.documento_natureza_operacao    = 1
                AND servico_tomado.documento_tipo                 IS NOT NULL
               AND (servico_tomado.documento_status_cancelamento  = FALSE
                 OR servico_tomado.documento_status_cancelamento  IS NULL)
                AND servico_tomado.documento_situacao             NOT IN ('C', 'E')
           ORDER BY servico_tomado.prestador_cnpjcpf
                   ,servico_tomado.documento_grupo
                   ,servico_tomado.documento_numero ";
  }
}