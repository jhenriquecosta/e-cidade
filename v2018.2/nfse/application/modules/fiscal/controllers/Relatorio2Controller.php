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
 * Classe para controle do relatório2 do módulo fiscal
 *
 * @package Fiscal/Controllers
 */

/**
 * @package Fiscal/Controllers
 */
class Fiscal_Relatorio2Controller extends Fiscal_Lib_Controller_AbstractController {

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
  public function declaracoesSemMovimentoAction() {

    $oForm = new Fiscal_Form_Relatorio2();
    $oForm->setAction('/fiscal/relatorio2/declaracoes-sem-movimento-gerar');

    $this->view->form = $oForm->render(Fiscal_Form_Relatorio2::TIPO6);
    $this->view->headScript()->offsetSetFile(50, $this->view->baseUrl('/fiscal/js/relatorios/script-compartilhado.js'));
    $this->render('view-compartilhada');
  }

  /**
   * Geração do relatório de declarações sem movimento
   */
  public function declaracoesSemMovimentoGerarAction() {

    parent::noLayout();

    $aValidacaoFormulario = self::validarFormulario(Fiscal_Form_Relatorio2::TIPO6);

    if (is_array($aValidacaoFormulario)) {
      exit($this->getHelper('json')->sendJson($aValidacaoFormulario));
    }

    try {

      // Parâmetros do formulário
      $sOrdenacaoCampo        = $this->getRequest()->getParam('ordenacao');
      $sOrdenacaoDirecao      = $this->getRequest()->getParam('ordem');
      $sCompetenciaInicial    = $this->getRequest()->getParam('data_competencia_inicial');
      $sCompetenciaFinal      = $this->getRequest()->getParam('data_competencia_final');

      // Separa os meses e anos
      $iCompetenciaInicialMes = intval(substr($sCompetenciaInicial, 0, 2));
      $iCompetenciaFinalMes   = intval(substr($sCompetenciaFinal,   0, 2));
      $iCompetenciaInicialAno = intval(substr($sCompetenciaInicial, -4));
      $iCompetenciaFinalAno   = intval(substr($sCompetenciaFinal,   -4));
      $sNomeArquivo           = 'relatorio_declaracao_sem_movimento_' . date('YmdHis') . '.pdf';
      $aDescricaoFiltros      = array(
        'inscricao_municipal' => 'Inscrição Municipal',
        'nome'                => 'Nome',
        'asc'                 => 'Crescente',
        'desc'                => 'Descrescente'
      );

      $oPdf = new Fiscal_Model_Relatoriopdfmodelo1('L');
      $oPdf->Open(TEMP_PATH . "/{$sNomeArquivo}");
      $oPdf->setLinhaFiltro('Relatório de Declarações Sem Movimento');
      $oPdf->setLinhaFiltro('');
      $oPdf->setLinhaFiltro("FILTRO: Competência de {$sCompetenciaInicial} até {$sCompetenciaFinal}");
      $oPdf->setLinhaFiltro("ORDEM: {$aDescricaoFiltros[$sOrdenacaoCampo]} ({$aDescricaoFiltros[$sOrdenacaoDirecao]})");
      $oPdf->carregaDados();

      $aUsuarioContribuintes              = Administrativo_Model_UsuarioContribuinte::getContribuintes();
      $aInscricoesMunicipaisContribuintes = array();

      foreach ($aUsuarioContribuintes as $oContribuinte) {
        $aInscricoesMunicipaisContribuintes[$oContribuinte->getEntity()->getIm()] = $oContribuinte->getEntity()->getIm();
      }

      $sInscricoesMunicipaisContribuintes = implode("','", $aInscricoesMunicipaisContribuintes);

      $aDeclaracaoIsento = Contribuinte_Model_Competencia::getDeclaracaoSemMovimentoPorContribuintes(
        $sInscricoesMunicipaisContribuintes
      );

      // Valida se existem contribuintes cadastrados no sistema
      if (!is_array($aDeclaracaoIsento)) {
        throw new Exception($this->translate->_('Nenhum contribuinte foi encontrado no sistema'));
      };

      // Varre a lista de contribuintes cadastrados no sistema
      foreach ($aDeclaracaoIsento as $oDeclaracaoIsento) {

        $oDadosContribuinte = Administrativo_Model_UsuarioContribuinteComplemento::getByAttribute(
          'inscricao_municipal',
          $oDeclaracaoIsento->inscricao_municipal
        );

        if (!is_object($oDadosContribuinte)) {

          $sMensagemErro = sprintf(
            'Não foi encontrado os dados complementares do contribuinte %s.',
            $oDeclaracaoIsento->inscricao_municipal
          );

          throw new Exception($sMensagemErro);
        }

        // Lista de declarações
        $aDeclaracaoIsentoValidos[$oDeclaracaoIsento->ano]
                                 [$oDeclaracaoIsento->mes]
                                 [$oDeclaracaoIsento->inscricao_municipal] = array(
          'inscricao_municipal' => $oDadosContribuinte->getInscricaoMunicipal(),
          'nome'                => $oDadosContribuinte->getRazaoSocial(),
          'endereco'            => $oDadosContribuinte->getEnderecoDescricao(),
          'telefone'            => $oDadosContribuinte->getContatoTelefone(),
          'competencia_ano'     => $oDeclaracaoIsento->ano,
          'competencia_mes'     => $oDeclaracaoIsento->mes
        );
      }

      // Varre os anos
      for ($iAno = 0; $iAno <= ($iCompetenciaFinalAno - $iCompetenciaInicialAno); $iAno++) {

        $iAnoLoop = intval($iCompetenciaInicialAno) + $iAno;

        // Varre os meses
        for ($iMesLoop = 1; $iMesLoop <= 12; $iMesLoop++) {

          // Ignora os meses anteriores e seguintes aos meses inicial e final
          if ($iAnoLoop == $iCompetenciaInicialAno && $iMesLoop < $iCompetenciaInicialMes ||
              $iAnoLoop == $iCompetenciaFinalAno   && $iMesLoop > $iCompetenciaFinalMes) {
            continue;
          }

          // Ordena o array pelo índice informado
          if (isset($aDeclaracaoIsentoValidos[$iAnoLoop][$iMesLoop])) {

            // Formata para mês por extenso
            $sMesExtenso = DBSeller_Helper_Date_Date::mesExtenso($iMesLoop);

            $oPdf->SetFont('Arial', 'B', 8);
            $oPdf->Cell(20, 5, utf8_decode('Competência:'));

            $oPdf->SetFont('Arial', NULL, 8);
            $oPdf->Cell(0,  5, utf8_decode("{$sMesExtenso}/{$iAnoLoop}"));
            $oPdf->Ln(5);

            $oPdf->SetFont('Arial', 'B', 8);
            $oPdf->Cell(28,  5, utf8_decode('Inscrição Municipal'), 1);
            $oPdf->Cell(100, 5, utf8_decode('Nome'),                1);
            $oPdf->Cell(117, 5, utf8_decode('Endereço'),            1);
            $oPdf->Cell(32,  5, utf8_decode('Telefone'),            1);
            $oPdf->Ln(5);

            $aDeclaracaoIsentoOrdenado = DBSeller_Helper_Array_Abstract::ordenarPorIndice(
              $aDeclaracaoIsentoValidos[$iAnoLoop][$iMesLoop],
              $sOrdenacaoCampo,
              $sOrdenacaoDirecao,
              TRUE
            );

            $oPdf->SetFont('Arial', NULL, 8);

            foreach ($aDeclaracaoIsentoOrdenado as $oDeclaracaoIsentoOrdenado) {

              $oPdf->Cell(28,  5, utf8_decode($oDeclaracaoIsentoOrdenado['inscricao_municipal']), 1);
              $oPdf->Cell(100, 5, utf8_decode($oDeclaracaoIsentoOrdenado['nome']),                1);
              $oPdf->Cell(117, 5, utf8_decode($oDeclaracaoIsentoOrdenado['endereco']),            1);
              $oPdf->Cell(32,  5, utf8_decode($oDeclaracaoIsentoOrdenado['telefone']),            1);
              $oPdf->Ln(5);
            }

            $oPdf->Ln(5);
            $oPdf->proximaPagina(10);
          }
        }
      }

      $oPdf->Output();

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
   * Tela para o relatório de empresas omissas
   */
  public function empresasOmissasAction () {

    $oForm = new Fiscal_Form_Relatorio2();
    $oForm->setAction('/fiscal/relatorio2/empresas-omissas-gerar');

    $this->view->form = $oForm->render(Fiscal_Form_Relatorio2::TIPO7);
    $this->view->headScript()->appendFile($this->view->baseUrl('/fiscal/js/relatorios/script-compartilhado.js'));
    $this->render('view-compartilhada');
  }

  /**
   * Geração do relatório de empresas omissas
   */
  public function empresasOmissasGerarAction() {

    parent::noLayout();

    $aValidacaoFormulario = self::validarFormulario(Fiscal_Form_Relatorio2::TIPO6);

    if (is_array($aValidacaoFormulario)) {
      exit($this->getHelper('json')->sendJson($aValidacaoFormulario));
    }

    try {

      // Parâmetros do formulário
      $sOrdenacaoCampo        = $this->getRequest()->getParam('ordenacao');
      $sOrdenacaoDirecao      = $this->getRequest()->getParam('ordem');
      $sCompetenciaInicial    = $this->getRequest()->getParam('data_competencia_inicial');
      $sCompetenciaFinal      = $this->getRequest()->getParam('data_competencia_final');

      // Separa os meses e anos
      $iCompetenciaInicialMes = intval(substr($sCompetenciaInicial, 0, 2));
      $iCompetenciaFinalMes   = intval(substr($sCompetenciaFinal,   0, 2));
      $iCompetenciaInicialAno = intval(substr($sCompetenciaInicial, -4));
      $iCompetenciaFinalAno   = intval(substr($sCompetenciaFinal,   -4));
      $sNomeArquivo           = 'relatorio_empresas_omissas_' . date('YmdHis') . '.pdf';
      $aDescricaoFiltros      = array(
        'inscricao_municipal' => 'Inscrição Municipal',
        'nome'                => 'Nome',
        'asc'                 => 'Crescente',
        'desc'                => 'Decrescente'
      );

      $oPdf = new Fiscal_Model_Relatoriopdfmodelo1('L');
      $oPdf->Open(APPLICATION_PATH . "/../public/tmp/{$sNomeArquivo}");
      $oPdf->setLinhaFiltro('Relatório de Empresas Omissas');
      $oPdf->setLinhaFiltro('');
      $oPdf->setLinhaFiltro("FILTRO: Competência de {$sCompetenciaInicial} até {$sCompetenciaFinal}");
      $oPdf->setLinhaFiltro("ORDEM: {$aDescricaoFiltros[$sOrdenacaoCampo]} ({$aDescricaoFiltros[$sOrdenacaoDirecao]})");
      $oPdf->carregaDados();

      $aUsuarioContribuintes              = Administrativo_Model_UsuarioContribuinte::getPrestadores();
      $aInscricoesMunicipaisContribuintes = array();

      // Verifica se existem usuários contribuinte cadastrados
      if (count($aUsuarioContribuintes) == 0) {
        throw new Exception($this->translate->_('Não existem contribuintes cadastrados no sistema.'));
      }

      $aDeclaracaoIsentoValidos = array();

      for ($iAno = 0; $iAno <= ($iCompetenciaFinalAno - $iCompetenciaInicialAno); $iAno++) {

        $iAnoLoop = intval($iCompetenciaInicialAno) + $iAno;

        // Varre os meses
        for ($iMesLoop = 1; $iMesLoop <= 12; $iMesLoop++) {

          // Ignora os meses anteriores e seguintes aos meses inicial e final
          if ($iAnoLoop == $iCompetenciaInicialAno && $iMesLoop < $iCompetenciaInicialMes ||
            $iAnoLoop == $iCompetenciaFinalAno   && $iMesLoop > $iCompetenciaFinalMes) {
            continue;
          }

          // Varre a lista de usuários contribuintes, verificando quem tem movimentações
          foreach ($aUsuarioContribuintes as $oContribuinte) {

            // Verifica se tem movimentação
            $sSql = "SELECT 1 AS existe_movimento
                     FROM   view_nota_mais_dms
                      WHERE (dms_operacao     = 's' OR dms_operacao IS NULL)   AND
                            prestador_cnpjcpf = '{$oContribuinte->getCnpjCpf()}' AND
                            documento_competencia_ano = $iAnoLoop AND
                            documento_competencia_mes = $iMesLoop";

            $oStatement = $this->oConexao->prepare($sSql);
            $oStatement->execute();

            // Adiciona na lista somente os contribuinte sem movimentação no sistema
            if ($oStatement->rowCount() == 0) {

              // Informações complementares do contribuinte
              $oDadosContribuinteComplemento = Administrativo_Model_UsuarioContribuinteComplemento::getById(
                $oContribuinte->getCnpjCpf()
              );

              // Variaveis do contribuinte
              $iInscricaoMunicipal = $oContribuinte->getIm();
              $sRazaoSocial        = $oDadosContribuinteComplemento->getRazaoSocial();
              $sEndereco           = $oDadosContribuinteComplemento->getEnderecoDescricao();

              if (strlen(trim($iInscricaoMunicipal)) > 0) {

                // Dados dos contribuintes
                $aDeclaracaoIsentoValidos[$iAnoLoop][$iMesLoop][$iInscricaoMunicipal] = array(
                  'inscricao_municipal' => $iInscricaoMunicipal,
                  'nome'                => DBSeller_Helper_String_Format::wordsCap($sRazaoSocial),
                  'endereco'            => DBSeller_Helper_String_Format::wordsCap($sEndereco),
                  'telefone'            => $oDadosContribuinteComplemento->getContatoTelefone(),
                  'competencia_ano'     => $iAnoLoop,
                  'competencia_mes'     => $iMesLoop,
                );

              }

              // Lista para consulta no webservice
              $aInscricoesMunicipaisContribuintes[$iInscricaoMunicipal] = $iInscricaoMunicipal;
            }
          }
        }
      }

      // Mosta a lista de inscrições do contribuintes para verificação no webservice (separados por vírgula)
      $sInscricoesMunicipaisContribuintes = implode("','", $aInscricoesMunicipaisContribuintes);

      // Retorna apenas os contribuintes com declaração de insento
      $aDeclaracaoIsento = Contribuinte_Model_Competencia::getDeclaracaoSemMovimentoPorContribuintes(
        $sInscricoesMunicipaisContribuintes
      );

      // Limpa as inscricoes com declaração de isenção
      foreach ($aDeclaracaoIsento as $oDeclaracaoIsento) {

        unset($aDeclaracaoIsentoValidos[$oDeclaracaoIsento->ano]
                                       [$oDeclaracaoIsento->mes]
                                       [$oDeclaracaoIsento->inscricao_municipal]);

        // Limpa dados do mes, caso não possua registros
        if (isset($aDeclaracaoIsentoValidos[$oDeclaracaoIsento->ano][$oDeclaracaoIsento->mes]) &&
            count($aDeclaracaoIsentoValidos[$oDeclaracaoIsento->ano][$oDeclaracaoIsento->mes]) == 0) {
          unset($aDeclaracaoIsentoValidos[$oDeclaracaoIsento->ano][$oDeclaracaoIsento->mes]);
        }

        // Limpa dados do ano, caso não possua registros
        if (isset($aDeclaracaoIsentoValidos[$oDeclaracaoIsento->ano]) &&
            count($aDeclaracaoIsentoValidos[$oDeclaracaoIsento->ano]) == 0) {
          unset($aDeclaracaoIsentoValidos[$oDeclaracaoIsento->ano]);
        }
      }

      if (count($aDeclaracaoIsentoValidos) == 0) {

        $sMensagemErro = 'Nenhuma informação foi encontrada neste período para geração do relatório.';
        throw new Exception($this->translate->_($sMensagemErro));
      }

      // Varre os anos
      for ($iAno = 0; $iAno <= ($iCompetenciaFinalAno - $iCompetenciaInicialAno); $iAno++) {

        $iAnoLoop = intval($iCompetenciaInicialAno) + $iAno;

        // Varre os meses
        for ($iMesLoop = 1; $iMesLoop <= 12; $iMesLoop++) {

          // Ignora os meses anteriores e seguintes aos meses inicial e final
          if ($iAnoLoop == $iCompetenciaInicialAno && $iMesLoop < $iCompetenciaInicialMes ||
              $iAnoLoop == $iCompetenciaFinalAno   && $iMesLoop > $iCompetenciaFinalMes) {
            continue;
          }

          // Ordena o array pelo índice informado
          if (isset($aDeclaracaoIsentoValidos[$iAnoLoop][$iMesLoop])) {

            // Formata para mês por extenso
            $sMesExtenso = DBSeller_Helper_Date_Date::mesExtenso($iMesLoop);

            $oPdf->SetFont('Arial', 'B', 8);
            $oPdf->Cell(20, 5, utf8_decode('Competência:'));

            $oPdf->SetFont('Arial', NULL, 8);
            $oPdf->Cell(0,  5, utf8_decode("{$sMesExtenso}/{$iAnoLoop}"));
            $oPdf->Ln(5);

            $oPdf->SetFont('Arial', 'B', 8);
            $oPdf->Cell(28,  5, utf8_decode('Inscrição Municipal'), 1);
            $oPdf->Cell(100, 5, utf8_decode('Nome'),                1);
            $oPdf->Cell(117, 5, utf8_decode('Endereço'),            1);
            $oPdf->Cell(32,  5, utf8_decode('Telefone'),            1);
            $oPdf->Ln(5);

            $aDeclaracaoIsentoOrdenado = DBSeller_Helper_Array_Abstract::ordenarPorIndice(
              $aDeclaracaoIsentoValidos[$iAnoLoop][$iMesLoop],
              $sOrdenacaoCampo,
              $sOrdenacaoDirecao,
              TRUE
            );

            $oPdf->SetFont('Arial', NULL, 8);

            foreach ($aDeclaracaoIsentoOrdenado as $oDeclaracaoIsentoOrdenado) {

              $oPdf->Cell(28,  5, utf8_decode($oDeclaracaoIsentoOrdenado['inscricao_municipal']), 1);
              $oPdf->Cell(100, 5, utf8_decode($oDeclaracaoIsentoOrdenado['nome']),                1);
              $oPdf->Cell(117, 5, utf8_decode($oDeclaracaoIsentoOrdenado['endereco']),            1);
              $oPdf->Cell(32,  5, utf8_decode($oDeclaracaoIsentoOrdenado['telefone']),            1);
              $oPdf->Ln(5);
            }

            $oPdf->Ln(5);
            $oPdf->proximaPagina(10);
          }
        }
      }

      $oPdf->Output();

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
   * @param integer $iRelatorio Tipo de Relatório a ser validado
   * @return array|bool
   */
  protected function validarFormulario($iRelatorio) {

    $aDados        = $this->getRequest()->getPost();
    $aRetornoErros = array();
    $oForm         = new Fiscal_Form_Relatorio2();
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

        $aRetornoErros['status']  = FALSE;
        $aRetornoErros['fields']  = array('data_competencia_inicial', 'data_competencia_final');

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
}