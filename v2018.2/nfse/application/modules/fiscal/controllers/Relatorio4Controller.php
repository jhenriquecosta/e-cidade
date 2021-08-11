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
 * Classe para controle do relatório 9 e 10 do módulo fiscal
 *
 * @package Fiscal/Controllers
 */

/**
 * @package Fiscal/Controllers
 */
class Fiscal_Relatorio4Controller extends Fiscal_Lib_Controller_AbstractController {

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
   * Tela para o relatório de retenções
   */
  public function comparativoRetencoesAction() {

    $oForm = new Fiscal_Form_Relatorio4();
    $oForm->setAction('/fiscal/relatorio4/comparativo-retencoes-gerar');

    $this->view->form = $oForm->render();
    $this->view->headScript()->offsetSetFile(50, $this->view->baseUrl('/fiscal/js/relatorios/script-compartilhado.js'));
  }

  /**
   * Geração do relatório de retenções
   */
  public function comparativoRetencoesGerarAction() {

    parent::noLayout();

    // Parâmetros do formulário
    $sOrdenacaoCampo   = $this->getRequest()->getParam('ordenacao');
    $sOrdenacaoDirecao = $this->getRequest()->getParam('ordem');
    $sTipoRelatorio    = $this->getRequest()->getParam('tipo_relatorio');
    $sCompetencia      = $this->getRequest()->getParam('data_competencia_inicial');

    // Valida formulário
    $aValidacaoFormulario = self::validarFormulario($sTipoRelatorio);

    if (is_array($aValidacaoFormulario)) {
      exit($this->getHelper('json')->sendJson($aValidacaoFormulario));
    }

    try {

      // Separa os meses e anos
      $iCompetenciaMes   = intval(substr($sCompetencia, 0, 2));
      $iCompetenciaAno   = intval(substr($sCompetencia, -4));
      $sNomeArquivo      = 'comparativo_retencoes_' . date('YmdHis') . '.pdf';
      $aDescricaoFiltros = array(
        'cabecalho_contribuinte_cnpjcpf'      => 'CNPJ/CPF',
        'cabecalho_contribuinte_razao_social' => 'Nome/Razão',
        'asc'                                 => 'Crescente',
        'desc'                                => 'Decrescente'
      );
      $aDescricaoRelatorio[Fiscal_Form_Relatorio4::TIPO9] = array(
        'titulo'              => 'Documentos Não retidos pelo Tomador e retidos pelo Prestador',
        'descricao_cabecalho' => 'Tomador',
        'descricao_lista'     => 'Prestador'
      );
      $aDescricaoRelatorio[Fiscal_Form_Relatorio4::TIPO10] = array(
        'titulo'              => 'Documentos Não retidos pelo Prestador e retidos pelo Tomador',
        'descricao_cabecalho' => 'Prestador',
        'descricao_lista'     => 'Tomador'
      );

      $oPdf = new Fiscal_Model_Relatoriopdfmodelo1('L');
      $oPdf->Open(APPLICATION_PATH . "/../public/tmp/{$sNomeArquivo}");
      $oPdf->setLinhaFiltro('Relatório Comparativo de Retenções');
      $oPdf->setLinhaFiltro($aDescricaoRelatorio[$sTipoRelatorio]['titulo']);
      $oPdf->setLinhaFiltro('');
      $oPdf->setLinhaFiltro("FILTRO: Competência {$sCompetencia}");
      $oPdf->setLinhaFiltro("ORDEM: {$aDescricaoFiltros[$sOrdenacaoCampo]} ({$aDescricaoFiltros[$sOrdenacaoDirecao]})");
      $oPdf->carregaDados();

      $oEntityManager = Zend_Registry::get('em');
      $oConexao       = $oEntityManager->getConnection();

      try {

        $sSql       = self::getSqlRelatorio($sTipoRelatorio);
        $oStatement = $oConexao->prepare($sSql);
        $oStatement->execute(array($iCompetenciaMes, $iCompetenciaAno));

        if ($oStatement->rowCount() < 1) {
          throw new Exception($this->translate->_('Nenhum registro encontrado.'));
        }

        $aRelatorio = NULL;

        // Varre os registros do relatório
        do {

          $aRelatorio = $oStatement->fetch();

          if (empty($aRelatorio)) {
            continue;
          }

          $sContribuinteCnpj = $aRelatorio['cabecalho_contribuinte_cnpjcpf'];
          $oTipoNota         = Contribuinte_Model_Nota::getTipoNota($aRelatorio['lista_documento_tipo']);

          $aDadosRelatorio[$sContribuinteCnpj]['cabecalho_contribuinte_cnpjcpf']      = $sContribuinteCnpj;
          $aDadosRelatorio[$sContribuinteCnpj]['cabecalho_contribuinte_razao_social'] = DBSeller_Helper_String_Format::wordsCap($aRelatorio['cabecalho_contribuinte_razao_social']);
          $aDadosRelatorio[$sContribuinteCnpj]['documentos'][]                        = array(
            'lista_documento_numero'              => $aRelatorio['lista_documento_numero'],
            'lista_documento_tipo'                => DBSeller_Helper_String_Format::wordsCap($oTipoNota->descricao),
            'lista_contribuinte_cnpjcpf'          => DBSeller_Helper_Number_Format::maskCPF_CNPJ($aRelatorio['lista_contribuinte_cnpjcpf']),
            'lista_contribuinte_razao_social'     => DBSeller_Helper_String_Format::wordsCap($aRelatorio['lista_contribuinte_razao_social']),
            'lista_contribuinte_contato_telefone' => DBSeller_Helper_Number_Format::maskPhoneNumber($aRelatorio['lista_contribuinte_contato_telefone']),
            'lista_servico_valor_servicos'        => DBSeller_Helper_Number_Format::toMoney($aRelatorio['lista_servico_valor_servicos'], 2)
          );
        } while ($aRelatorio);

        // Dados do relatorio na ordem informada
        if (isset($aDadosRelatorio) && is_array($aDadosRelatorio)) {

          $aDadosRelatorioOrdenado = DBSeller_Helper_Array_Abstract::ordenarPorIndice($aDadosRelatorio,
                                                                                      $sOrdenacaoCampo,
                                                                                      $sOrdenacaoDirecao,
                                                                                      FALSE);
        } else {
          throw new Exception($this->translate->_('Erro ao gerar o relatório.'));
        }

        // Percorre os dados do relatório
        foreach ($aDadosRelatorioOrdenado as $aRelatorioOrdenado) {

          $sContribuinteCnpj   = DBSeller_Helper_Number_Format::maskCPF_CNPJ(
            $aRelatorioOrdenado['cabecalho_contribuinte_cnpjcpf']
          );
          $sContribuinteRazao  = $aRelatorioOrdenado['cabecalho_contribuinte_razao_social'];
          $sDescricaoCabecalho = $aDescricaoRelatorio[$sTipoRelatorio]['descricao_cabecalho'];

          // Divisor com as informações do tomador
          $oPdf->SetFont('Arial', 'B', 8);
          $oPdf->Cell(30, 5, utf8_decode("CPNJ/CPF {$sDescricaoCabecalho}:"));
          $oPdf->SetFont('Arial', '', 8);
          $oPdf->Cell(30, 5, utf8_decode($sContribuinteCnpj));
          $oPdf->SetFont('Arial', 'B', 8);
          $oPdf->Cell(33, 5, utf8_decode("Razão Social {$sDescricaoCabecalho}:"));
          $oPdf->SetFont('Arial', '', 8);
          $oPdf->Cell(0, 5, utf8_decode($sContribuinteRazao));
          $oPdf->Ln();

          if (count($aRelatorioOrdenado['documentos']) > 0) {

            $sDescricaoLista = $aDescricaoRelatorio[$sTipoRelatorio]['descricao_lista'];

            $oPdf->SetFont('Arial', 'B', 8);
            $oPdf->Cell(28, 5, utf8_decode('Nº do Documento'), 1, 0, 'C');
            $oPdf->Cell(50, 5, utf8_decode('Tipo de Documento'), 1, 0, 'L');
            $oPdf->Cell(35, 5, utf8_decode("CNPJ/CPF do {$sDescricaoLista}"), 1, 0, 'L');
            $oPdf->Cell(110, 5, utf8_decode("Razão Social do {$sDescricaoLista}"), 1, 0, 'L');
            $oPdf->Cell(30, 5, utf8_decode('Telefone'), 1, 0, 'L');
            $oPdf->Cell(24, 5, utf8_decode('Valor (R$)'), 1, 0, 'R');
            $oPdf->Ln(5);

            foreach ($aRelatorioOrdenado['documentos'] as $aRelatorioDocumento) {

              $oPdf->SetFont('Arial', '', 8);
              $oPdf->Cell(28, 5, utf8_decode($aRelatorioDocumento['lista_documento_numero']), 1, 0, 'C');
              $oPdf->Cell(50, 5, utf8_decode($aRelatorioDocumento['lista_documento_tipo']), 1, 0, 'L');
              $oPdf->Cell(35, 5, utf8_decode($aRelatorioDocumento['lista_contribuinte_cnpjcpf']), 1, 0, 'L');
              $oPdf->Cell(110, 5, utf8_decode($aRelatorioDocumento['lista_contribuinte_razao_social']), 1, 0, 'L');
              $oPdf->Cell(30, 5, utf8_decode($aRelatorioDocumento['lista_contribuinte_contato_telefone']), 1, 0, 'L');
              $oPdf->Cell(24, 5, utf8_decode($aRelatorioDocumento['lista_servico_valor_servicos']), 1, 0, 'R');
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
   * @param string $sTipoRelatorio
   * @return array|boolean
   */
  protected function validarFormulario($sTipoRelatorio = Fiscal_Form_Relatorio4::TIPO9) {

    $aDados        = $this->getRequest()->getPost();
    $aRetornoErros = array();
    $oForm         = new Fiscal_Form_Relatorio4();
    $oForm->render(NULL, $sTipoRelatorio);

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
   * @param string $sRelatorio
   * @return string
   */
  private static function getSqlRelatorio($sRelatorio = NULL) {

    $sSql = NULL;

    switch ($sRelatorio) {

      case Fiscal_Form_Relatorio4::TIPO10 :

        $sSql = "SELECT servico_prestado.tomador_cnpjcpf              AS cabecalho_contribuinte_cnpjcpf
                       ,servico_prestado.tomador_razao_social         AS cabecalho_contribuinte_razao_social
                       ,servico_prestado.documento_numero             AS lista_documento_numero
                       ,servico_prestado.documento_tipo               AS lista_documento_tipo
                       ,servico_prestado.prestador_cnpjcpf            AS lista_contribuinte_cnpjcpf
                       ,servico_prestado.prestador_razao_social       AS lista_contribuinte_razao_social
                       ,servico_prestado.prestador_contato_telefone   AS lista_contribuinte_contato_telefone
                       ,servico_prestado.servico_valor_servicos       AS lista_servico_valor_servicos
                   FROM view_nota_mais_dms servico_prestado
              LEFT JOIN view_nota_mais_dms servico_tomado ON (
                        servico_tomado.prestador_cnpjcpf               = servico_prestado.prestador_cnpjcpf
                    AND servico_tomado.tomador_cnpjcpf                 = servico_prestado.tomador_cnpjcpf
                    AND servico_tomado.documento_numero                = servico_prestado.documento_numero
                    AND servico_tomado.documento_grupo                 = servico_prestado.documento_grupo
                    AND servico_tomado.documento_id_contribuinte      != servico_prestado.documento_id_contribuinte
                   AND (servico_tomado.documento_status_cancelamento   = FALSE
                     OR servico_tomado.documento_status_cancelamento   IS NULL)
                    AND servico_tomado.documento_situacao              NOT IN ('C', 'E'))
                 WHERE (servico_prestado.dms_operacao                 != 'e' OR servico_prestado.dms_operacao IS NULL)
                    AND servico_prestado.documento_competencia_mes     = ?
                    AND servico_prestado.documento_competencia_ano     = ?
                    AND servico_prestado.servico_iss_retido            = FALSE
                    AND servico_tomado.servico_iss_retido              = TRUE
                   AND (servico_prestado.documento_status_cancelamento = FALSE
                     OR servico_prestado.documento_status_cancelamento IS NULL)
                    AND servico_prestado.documento_situacao            NOT IN ('C', 'E')
                    AND servico_prestado.documento_natureza_operacao   = 1
               ORDER BY servico_prestado.prestador_cnpjcpf
                       ,servico_prestado.documento_grupo
                       ,servico_prestado.documento_numero";
        break;

      case Fiscal_Form_Relatorio4::TIPO9 :

        $sSql = "SELECT servico_tomado.tomador_cnpjcpf               AS cabecalho_contribuinte_cnpjcpf
                       ,servico_tomado.tomador_razao_social          AS cabecalho_contribuinte_razao_social
                       ,servico_tomado.documento_numero              AS lista_documento_numero
                       ,servico_tomado.documento_tipo                AS lista_documento_tipo
                       ,servico_tomado.prestador_cnpjcpf             AS lista_contribuinte_cnpjcpf
                       ,servico_tomado.prestador_razao_social        AS lista_contribuinte_razao_social
                       ,servico_tomado.prestador_contato_telefone    AS lista_contribuinte_contato_telefone
                       ,servico_tomado.servico_valor_servicos        AS lista_servico_valor_servicos
                   FROM view_nota_mais_dms servico_tomado
              LEFT JOIN view_nota_mais_dms servico_prestado ON (
                        servico_prestado.prestador_cnpjcpf            = servico_tomado.prestador_cnpjcpf
                    AND servico_prestado.tomador_cnpjcpf              = servico_tomado.tomador_cnpjcpf
                    AND servico_prestado.documento_numero             = servico_tomado.documento_numero
                    AND servico_prestado.documento_grupo              = servico_tomado.documento_grupo
                    AND servico_prestado.documento_id_contribuinte   != servico_tomado.documento_id_contribuinte)
                  WHERE servico_tomado.dms_operacao                   IS NOT NULL
                    AND servico_tomado.dms_operacao                   = 'e'
                    AND servico_tomado.documento_competencia_mes      = ?
                    AND servico_tomado.documento_competencia_ano      = ?
                    AND servico_tomado.servico_iss_retido             = FALSE
                    AND servico_prestado.servico_iss_retido           = TRUE
                   AND (servico_tomado.documento_status_cancelamento  = FALSE
                     OR servico_tomado.documento_status_cancelamento  IS NULL)
                    AND servico_tomado.documento_situacao             NOT IN ('C', 'E')
                    AND servico_tomado.documento_natureza_operacao    = 1
               ORDER BY servico_tomado.prestador_cnpjcpf
                       ,servico_tomado.documento_grupo
                       ,servico_tomado.documento_numero";
        break;
    }

    return $sSql;
  }
}