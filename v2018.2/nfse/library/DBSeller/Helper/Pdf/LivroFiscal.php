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

require_once(APPLICATION_PATH . '/../library/FPDF/Fpdf2File.php');

/**
 * Classe para geração do livro fiscal (pdf)
 *
 * @package DBSeller/Helper/Pdf
 * @see     Fpdf2File
 */
class DBSeller_Helper_Pdf_LivroFiscal extends Fpdf2File {

  /**
   * Flag que define se deve mostrar o número da página
   *
   * @var bool
   */
  private $lImprimePaginas = TRUE;

  /**
   * Diretório do arquivo
   *
   * @var string
   */
  private $sDiretorioArquivo;

  /**
   * Nome do arquivo
   *
   * @var string
   */
  private $sNomeArquivo;

  /**
   * Número da página
   *
   * @var int
   */
  private $iNumeroPagina = 0;
  
  /**
   * Ambiente da aplicação: homologation/production/development
   * 
   * @var string
   */
  private $sAmbiente;

  /**
   * Define o Diretório do arquivo
   *
   * @param string $sDiretorioArquivo
   */
  public function setDiretorioArquivo($sDiretorioArquivo) {

    $this->sDiretorioArquivo = $sDiretorioArquivo;
  }

  /**
   * Retorn o diretório do arquivo
   *
   * @return string
   */
  public function getDiretorioArquivo() {

    return $this->sDiretorioArquivo;
  }

  /**
   * Define o nome do arquivo
   *
   * @param string $sNomeArquivo
   */
  public function setNomeArquivo($sNomeArquivo = 'livro_fiscal.pdf') {

    $this->sNomeArquivo = $sNomeArquivo;
  }

  /**
   * Retorna o nome do arquivo
   *
   * @return string
   */
  public function getNomeArquivo() {

    return $this->sNomeArquivo;
  }

  /**
   * Retorna o número da página
   *
   * @return int
   */
  public function getNumeroPagina() {

    return $this->iNumeroPagina;
  }

  /**
   * Define o número da página
   *
   * @param int $iNumeroPagina
   */
  public function setNumeroPagina($iNumeroPagina) {

    $this->iNumeroPagina = $iNumeroPagina;
  }
  
  /**
   * Define ambiente da aplicação
   * 
   * @param String $sAmbiente
   */
  public function setAmbiente($sAmbiente) {
    
    $this->sAmbiente = $sAmbiente;
  }
  
  /**
   * Retorna ambiente da aplicação
   * 
   * @return string
   */
  public function getAmbiente() {
    
    return $this->sAmbiente;
  } 

  /**
   * Abre o PDF para escrita
   */
  public function openPdf() {

    // Configura o diretório
    if (empty($this->sDiretorioArquivo)) {
      $this->sDiretorioArquivo = TEMP_PATH . '/';
    }

    $this->Open("{$this->sDiretorioArquivo}/{$this->sNomeArquivo}");
    $this->AliasNbPages();
    $this->SetCreator(utf8_decode('DBSeller Serviços de Informática Ltda'));
  }

  /**
   * Define os dados para o termo de abertura/fechamento do livro fiscal
   *
   * @param $oParametros
   * @tutorial
   *        Contribuinte_Model_Contribuinte $oParametros->oContribuinte
   *        int                             $oParametros->iAno
   *        int                             $oParametros->iCompetenciaInicialMes
   *        int                             $oParametros->iCompetenciaInicialAno
   *        int                             $oParametros->iCompetenciaFinalMes
   *        int                             $oParametros->iCompetenciaFinalAno
   *        boolean                         $oParametros->lFechamento
   */
  public function setDadosAberturaFechamento($oParametros) {

    $this->AddPage();
    $this->lImprimePaginas = FALSE;

    // Ignora os meses anteriores e seguintes aos meses inicial e final
    if ($oParametros->iCompetenciaInicialAno != $oParametros->iCompetenciaFinalAno) {

      if ($oParametros->iAno > $oParametros->iCompetenciaInicialAno) {
        $oParametros->iCompetenciaInicialMes = 1;
      }

      if ($oParametros->iAno < $oParametros->iCompetenciaFinalAno) {
        $oParametros->iCompetenciaFinalMes = 12;
      }
    }

    // Verifica qual o título de termo, se abertura ou fechamento
    if (isset($oParametros->lFechamento) && $oParametros->lFechamento == TRUE) {
      $sTexto = 'Termo de Fechamento';
    } else {
      $sTexto = 'Termo de Abertura';
    }

    // Converte os meses para 2 casas
    $oParametros->iCompetenciaInicialMes = str_pad($oParametros->iCompetenciaInicialMes, 2, '0', STR_PAD_LEFT);
    $oParametros->iCompetenciaFinalMes   = str_pad($oParametros->iCompetenciaFinalMes, 2, '0', STR_PAD_LEFT);

    // Formata as datas inicial e final
    $oDataInicial = new DateTime();
    $oDataInicial->setDate($oParametros->iAno, $oParametros->iCompetenciaInicialMes, '01');

    $oDataFinal = new DateTime();
    $oDataFinal->setDate($oParametros->iAno, $oParametros->iCompetenciaFinalMes, '01');

    $sDataInicial = $oDataInicial->format('d/m/Y');
    $sDataFinal   = $oDataFinal->format('t/m/Y');

    // Imprime os dados de abertura/fechamento
    $this->SetFont('Arial', 'B', 10);
    $this->Cell(0, 10, utf8_decode('REGISTRO DE SERVIÇOS PRESTADOS A TERCEIROS'), 0, 0, 'C');
    $this->Ln();
    $this->SetFont('Arial', 'U', 10);
    $this->Cell(0, 10, utf8_decode($sTexto), 0, 0, 'C');
    $this->Ln(30);

    $this->SetFont('Arial', 'B', 10);
    $this->Cell(12, 5, utf8_decode('CNPJ:'));
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, DBSeller_Helper_Number_Format::maskCPF_CNPJ($oParametros->oContribuinte->getCgcCpf()));
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);
    $this->Cell(25, 5, utf8_decode('Razão Social:'));
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, utf8_decode($oParametros->oContribuinte->getNome()));
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);
    $this->Cell(34, 5, utf8_decode('Inscrição Estadual:'));
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, utf8_decode($oParametros->oContribuinte->getInscricaoEstadual()));
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);
    $this->Cell(36, 5, utf8_decode('Inscrição Municipal:'));
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, utf8_decode($oParametros->oContribuinte->getInscricaoMunicipal()));
    $this->Ln();

    $sTexto = trim($oParametros->oContribuinte->getDescricaoLogradouro());
    $sTexto .= ", {$oParametros->oContribuinte->getLogradouroNumero()}";

    $this->SetFont('Arial', 'B', 10);
    $this->Cell(20, 5, utf8_decode('Endereço:'));
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, utf8_decode($sTexto));
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);
    $this->Cell(26, 5, utf8_decode('Complemento:'));
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, utf8_decode($oParametros->oContribuinte->getLogradouroComplemento()));
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);
    $this->Cell(13, 5, utf8_decode('Bairro:'), 0, 0, 'L');
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, utf8_decode($oParametros->oContribuinte->getLogradouroBairro()));
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);
    $this->Cell(10, 5, utf8_decode('CEP:'));
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, utf8_decode($oParametros->oContribuinte->getCep()));
    $this->Ln();

    $sTexto = $oParametros->oContribuinte->getDescricaoMunicipio() . '/' . $oParametros->oContribuinte->getEstado();

    $this->SetFont('Arial', 'B', 10);
    $this->Cell(20, 5, utf8_decode('Município:'));
    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, utf8_decode($sTexto));
    $this->Ln(30);
    $this->Cell(0, 5, '_________________________________________________________________', 0, 0, 'C');
    $this->Ln();

    $sTexto = $oParametros->oContribuinte->getDescricaoMunicipio() . ', ' . DBSeller_Helper_Date_Date::getDataExtenso();

    $this->SetFont('Arial', '', 10);
    $this->Cell(0, 5, utf8_decode($sTexto), 0, 0, 'C');
    $this->Ln();

    $this->SetFont('Arial', 'I', 7);
    $this->Cell(0, 5, utf8_decode('(Assinatura do contribuinte ou seu representante legal)'), 0, 0, 'C');
    $this->Ln(20);

    $this->SetFont('Arial', '', 10);

    $sTexto = "Contém este relatório {$this->iNumeroPagina} folha(s) numerada(s) eletronicamente e seguidamente ";
    $sTexto .= "do nº 1 ao nº {$this->iNumeroPagina} e serviu para ";

    $this->Cell(0, 5, utf8_decode($sTexto), 0, 0, 'C');
    $this->Ln();

    $sTexto = " o lançamento das operações próprias no período de {$sDataInicial} a {$sDataFinal} ";
    $this->Cell(0, 5, utf8_decode($sTexto), 0, 0, 'C');
    $this->Ln();

    $sTexto = 'do estabelecimento do contribuinte abaixo identificado.';
    $this->Cell(0, 5, utf8_decode($sTexto), 0, 0, 'C');
    $this->Ln();
  }

  /**
   * Define os dados da prefeitura
   *
   * @param Administrativo_Model_ParametroPrefeitura $oDadosPrefeitura
   * @param bool                                     $lLivroFiscal
   */
  public function setDadosPrefeitura(Administrativo_Model_ParametroPrefeitura $oDadosPrefeitura, $lLivroFiscal = TRUE) {

    if ($lLivroFiscal) {
      $this->AddPage();  
    }
    
    $this->lImprimePaginas = TRUE;
    $sLogotipoPrefeitura   = APPLICATION_PATH . '/../public/global/img/brasao.jpg';
    
    if (file_exists($sLogotipoPrefeitura)) {
      $this->Image($sLogotipoPrefeitura, 8, 7);
    }

    $sTitulo = 'Livro Fiscal Serviços Prestados Mensal';
    if (!$lLivroFiscal) {
      $sTitulo = 'DECLARAÇÃO DE RECEITAS';
    }

    $this->SetFont('Arial', 'B', 10);
    $this->Cell(0, 5, utf8_decode($oDadosPrefeitura->getNome()), 0, 0, 'C');
    $this->Ln();
    $this->Cell(0, 5, 'SECRETARIA MUNICIPAL DA FAZENDA', 0, 0, 'C');
    $this->Ln();
    $this->Ln();
    $this->Cell(0, 5, utf8_decode($sTitulo), 0, 0, 'C');
    $this->Ln(15);
  }

  /**
   * Define os dados do contribuinte
   *
   * @param Contribuinte_Model_Contribuinte $oContribuinte
   * @param                                 $iMesCompetencia
   * @param                                 $iAnoCompetencia
   * @param bool                            $lLivroFiscal
   */
  public function setDadosContribuinte(Contribuinte_Model_Contribuinte $oContribuinte,
                                       $iMesCompetencia,
                                       $iAnoCompetencia,
                                       $lLivroFiscal = TRUE) {
    
    if (!$lLivroFiscal) {
      $this->AddPage();
    }

    // Mês e ano da competnência por extenso
    $sCompetencia = DBSeller_Helper_Date_Date::mesExtenso($iMesCompetencia) . "/{$iAnoCompetencia}";
    $sCompetencia = utf8_decode($sCompetencia);

    // Mostra os campos referentes à guia somente para contribuintes NFSe
    if ($oContribuinte->getTipoEmissao() == Contribuinte_Model_Contribuinte::TIPO_EMISSAO_NOTA || !$lLivroFiscal) {

      // Situação da Guia
      $sDataFechamentoGuia = '-';
      $sSituacaoGuia       = 'Em aberto';
      $oGuia               = new Contribuinte_Model_Guia();
      $aGuia               = $oGuia->getByCompetenciaAndContribuinte($iAnoCompetencia,
                                                                     $iMesCompetencia,
                                                                     $oContribuinte,
                                                                     Contribuinte_Model_Guia::$PRESTADOR);

      if (count($aGuia) > 0) {

        $oGuia = $aGuia[0]->getEntity();

        $sDataFechamentoGuia = $oGuia->getDataFechamento()->format('d/m/Y');
        $sSituacaoGuia       = Contribuinte_Model_Guia::$SITUACAO[$oGuia->getSituacao()];
      }

      $aLarguraCelulas = array(57, 55, 55, 55, 55, 45, 50);

      $this->SetFont('Arial', 'B', 8);

      if ($lLivroFiscal) {

         // Mostra CGM ou Inscrição Municipal
        if ($oContribuinte->getCgm()) {
          $this->Cell($aLarguraCelulas[0], 5, utf8_decode('CGM / Inscrição Municipal:'), 1);
        } else {
          $this->Cell($aLarguraCelulas[0], 5, utf8_decode('Inscrição Municipal:'), 1);
        }

        $this->Cell($aLarguraCelulas[1], 5, utf8_decode('CPF / CNPJ:'), 1);
        $this->Cell($aLarguraCelulas[2], 5, utf8_decode('Mês Referência:'), 1);
        $this->Cell($aLarguraCelulas[3], 5, utf8_decode('Situação:'), 1);
        $this->Cell($aLarguraCelulas[4], 5, utf8_decode('Encerramento:'), 1);
        $this->Ln();

        $this->SetFont('Arial', NULL, 8);

        // Mostra CGM ou Inscrição Municipal
        if ($oContribuinte->getCgm()) {
          $this->Cell($aLarguraCelulas[0], 5, $oContribuinte->getCgm(), 1);
        } else {
          $this->Cell($aLarguraCelulas[0], 5, $oContribuinte->getInscricaoMunicipal(), 1);
        }

        $sCpfCnpjContribuinte = DBSeller_Helper_Number_Format::maskCPF_CNPJ($oContribuinte->getCgcCpf());

        $this->Cell($aLarguraCelulas[1], 5, $sCpfCnpjContribuinte, 1);
        $this->Cell($aLarguraCelulas[2], 5, $sCompetencia, 1);
        $this->Cell($aLarguraCelulas[3], 5, $sSituacaoGuia, 1);
        $this->Cell($aLarguraCelulas[4], 5, $sDataFechamentoGuia, 1);
        $this->Ln(6);
      } else {

        // Mostra CGM ou Inscrição Municipal
        if ($oContribuinte->getCgm()) {
          $this->Cell($aLarguraCelulas[1], 5, utf8_decode('CGM / Inscrição Municipal:'), 1);
        } else {
          $this->Cell($aLarguraCelulas[1], 5, utf8_decode('Inscrição Municipal:'), 1);
        }

        $this->Cell($aLarguraCelulas[6], 5, utf8_decode('CPF / CNPJ:'), 1);
        $this->Cell($aLarguraCelulas[5], 5, utf8_decode('Competencia Inicial:'), 1);
        $this->Cell($aLarguraCelulas[5], 5, utf8_decode('Competencia Final:'), 1);
        $this->Cell($aLarguraCelulas[5], 5, utf8_decode('Situação:'), 1);
        $this->Cell(0, 5, utf8_decode('Encerramento:'), 1);
        $this->Ln();

        $this->SetFont('Arial', NULL, 8);

        // Mostra CGM ou Inscrição Municipal
        if ($oContribuinte->getCgm()) {
          $this->Cell($aLarguraCelulas[1], 5, $oContribuinte->getCgm(), 1);
        } else {
          $this->Cell($aLarguraCelulas[1], 5, $oContribuinte->getInscricaoMunicipal(), 1);
        }

        $sCpfCnpjContribuinte = DBSeller_Helper_Number_Format::maskCPF_CNPJ($oContribuinte->getCgcCpf());

        $sCompetenciaInicial = $iMesCompetencia['inicial'] . '/' . $iAnoCompetencia['inicial'];
        $sCompetenciaFinal   = $iMesCompetencia['final'] . '/' . $iAnoCompetencia['final'];

        $this->Cell($aLarguraCelulas[6], 5, $sCpfCnpjContribuinte, 1);
        $this->Cell($aLarguraCelulas[5], 5, $sCompetenciaInicial, 1);
        $this->Cell($aLarguraCelulas[5], 5, $sCompetenciaFinal, 1);
        $this->Cell($aLarguraCelulas[5], 5, $sSituacaoGuia, 1);
        $this->Cell(0, 5, $sDataFechamentoGuia, 1);
        $this->Ln(6);
      }
    } else {

      $aLarguraCelulas = array(93, 92, 92);

      $this->SetFont('Arial', 'B', 8);

      // Mostra CGM ou Inscrição Municipal
      if ($oContribuinte->getCgm()) {
        $this->Cell($aLarguraCelulas[0], 5, utf8_decode('CGM / Inscrição Municipal:'), 1);
      } else {
        $this->Cell($aLarguraCelulas[0], 5, utf8_decode('Inscrição Municipal:'), 1);
      }

      $this->Cell($aLarguraCelulas[1], 5, utf8_decode('CPF / CNPJ:'), 1);
      $this->Cell($aLarguraCelulas[2], 5, utf8_decode('Mês Referência:'), 1);
      $this->Ln();
      $this->SetFont('Arial', NULL, 8);

      // Mostra CGM ou Inscrição Municipal
      if ($oContribuinte->getCgm()) {
        $this->Cell($aLarguraCelulas[0], 5, $oContribuinte->getCgm(), 1);
      } else {
        $this->Cell($aLarguraCelulas[0], 5, $oContribuinte->getInscricaoMunicipal(), 1);
      }

      $this->Cell($aLarguraCelulas[1], 5, DBSeller_Helper_Number_Format::maskCPF_CNPJ($oContribuinte->getCgcCpf()), 1);
      $this->Cell($aLarguraCelulas[2], 5, $sCompetencia, 1);
      $this->Ln(6);
    }

    $this->SetFont('Arial', 'B', 8);
    $this->Cell(0, 5, utf8_decode('Razão Social:'), 1);
    $this->Ln();
    $this->SetFont('Arial', NULL, 8);
    $this->Cell(0, 5, utf8_decode($oContribuinte->getNome()), 1);
    $this->Ln(6);

    $this->SetFont('Arial', 'B', 8);
    $this->Cell(242, 5, utf8_decode('Endereço:'), 1);
    $this->Cell(35, 5, utf8_decode('Número:'), 1);
    $this->Ln();
    $this->SetFont('Arial', NULL, 8);
    $this->Cell(242, 5, utf8_decode($oContribuinte->getDescricaoLogradouro()), 1);
    $this->Cell(35, 5, utf8_decode($oContribuinte->getLogradouroNumero()), 1);
    $this->Ln(6);

    $this->SetFont('Arial', 'B', 8);
    $this->Cell(90, 5, utf8_decode('Complemento:'), 1);
    $this->Cell(80, 5, utf8_decode('Bairro:'), 1);
    $this->Cell(72, 5, utf8_decode('Cidade:'), 1);
    $this->Cell(35, 5, utf8_decode('Estado:'), 1);
    $this->Ln();
    $this->SetFont('Arial', NULL, 8);
    $this->Cell(90, 5, utf8_decode($oContribuinte->getLogradouroComplemento()), 1);
    $this->Cell(80, 5, utf8_decode($oContribuinte->getLogradouroBairro()), 1);
    $this->Cell(72, 5, utf8_decode($oContribuinte->getDescricaoMunicipio()), 1);
    $this->Cell(35, 5, utf8_decode($oContribuinte->getEstado()), 1);
    $this->Ln(6);

    $oDataAtual  = new DateTime();
    $sEnderecoIp = $_SERVER['REMOTE_ADDR'];

    $this->SetFont('Arial', 'B', 8);
    $this->Cell(139, 5, utf8_decode("Endereço IP: {$sEnderecoIp}"), 1);
    $this->Cell(138, 5, utf8_decode("Data da impressão: {$oDataAtual->format('d/m/Y H:i:s')}"), 1);
    $this->Ln(7);
  }

  /**
   * Define os dados dos documentos válidos
   *
   * @param \Doctrine\DBAL\Statement $oStatement
   * @param  array                   $aParametros
   * @throws Exception
   */
  public function setDadosDocumentosValidos(Doctrine\DBAL\Statement $oStatement, array $aParametros) {

    // Notas Válidas
    $this->SetFont('Arial', 'B', 8);
    $this->SetFillColor(201, 201, 201);
    $this->Cell(0, 5, utf8_decode('LANÇAMENTOS VÁLIDOS'), 1, 1, 'C', TRUE);
    $this->Ln(1);

    $aLarguraCelulas = array(6, 13, 10, 50, 25, 9, 12, 20, 20, 27, 85);

    $this->SetFillColor(230, 230, 230);
    $this->Cell($aLarguraCelulas[0], 5, utf8_decode('Dia'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[1], 5, utf8_decode('Número'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[2], 5, utf8_decode('Série'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[3], 5, utf8_decode('Tipo'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[4], 5, utf8_decode('Situação'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[5], 5, utf8_decode('Cod.'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[6], 5, utf8_decode('Aliq.(%)'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[7], 5, utf8_decode('Base(R$)'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[8], 5, utf8_decode('ISS(R$)'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[9], 5, utf8_decode('CNPJ Tomador'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[10], 5, utf8_decode('Razão Tomador'), 1, NULL, NULL, TRUE);
    $this->SetFont('Arial', NULL, 8);

    try {

      $oStatement->execute($aParametros);

      if ($oStatement->rowCount() > 0) {

        $fTotalBase = 0;
        $fTotalIss  = 0;

        while ($aNota = $oStatement->fetch()) {

          $sDiaEmissaoDocumento = substr($aNota['documento_data'], -2);

          $this->Ln();
          $this->Cell($aLarguraCelulas[0], 5, $sDiaEmissaoDocumento, 1, 0, 'C');
          $this->Cell($aLarguraCelulas[1], 5, $aNota['documento_numero'], 1, 0, 'R');
          $this->Cell($aLarguraCelulas[2], 5, $aNota['documento_serie'], 1, 0, 'R');

          // Tipo de documento
          if ($aNota['documento_classe'] == 'nfse') {

            $sTipoNota = 'NFSe';

            if ($aNota['documento_tipo']) {
              $oTipoNota = Administrativo_Model_ParametroPrefeituraRps::getByTipoEcidade($aNota['documento_tipo']);
              $sTipoNota = $oTipoNota->getTipoNfseDescricao();
            }

            $this->Cell($aLarguraCelulas[3], 5, utf8_decode($sTipoNota), 1);
          } else if ($aNota['documento_classe'] == 'dms' && $aNota['documento_tipo']) {

            if ($aNota['documento_tipo_descricao']) {
              $sTipoNota = $aNota['documento_tipo_descricao'];
            } else {

              $oTipoNota = Administrativo_Model_ParametroPrefeituraRps::getByTipoEcidade($aNota['documento_tipo']);
              $sTipoNota = $oTipoNota->getTipoNfseDescricao();
            }

            $this->Cell($aLarguraCelulas[3], 5, utf8_decode($sTipoNota), 1);
          } else {
            $this->Cell($aLarguraCelulas[3], 5, '-', 1);
          }

          // Formata dados
          $sServicoValorAliquota    = DBSeller_Helper_Number_Format::toMoney($aNota['servico_valor_aliquota']);
          $sServicoValorBaseCalculo = DBSeller_Helper_Number_Format::toMoney($aNota['servico_valor_base_calculo']);
          $sServicoValorIss         = DBSeller_Helper_Number_Format::toMoney($aNota['servico_valor_iss']);
          $sTomadorCnpjCpf          = DBSeller_Helper_Number_Format::maskCPF_CNPJ($aNota['tomador_cnpjcpf']);
          $sTomadorRazaoSocial      = utf8_decode($aNota['tomador_razao_social']);
          $sTomadorRazaoSocial      = substr($sTomadorRazaoSocial, 0, 50);

          // Verifica se é tomador não identificado
          if (!$sTomadorCnpjCpf) {
            $sTomadorRazaoSocial = utf8_decode('Não identificado');
          }

          // Trata a situação do documento
          switch (strtoupper($aNota['documento_situacao'])) {

            case 'T'  :
              $sSituacaoDocumento = utf8_decode('Tributado');
              break;
            case 'R'  :
              $sSituacaoDocumento = utf8_decode('Retido');
              break;
            case 'IS' :
              $sSituacaoDocumento = utf8_decode('Isento');
              break;
            case 'E'  :
              $sSituacaoDocumento = utf8_decode('Extraviado');
              break;
            default   :
              $sSituacaoDocumento = '-';
          }

          // ALtera a situação do documento quando a natureza for fora do município
          if ($aNota['documento_natureza_operacao'] == 2) {
            $sSituacaoDocumento = utf8_decode('Fora do Município');
          }

          // Nota cancelada
          if ($aNota['documento_status_cancelamento'] == 't' || $aNota['documento_situacao'] == 'c') {

            $sSituacaoDocumento       = utf8_decode('Cancelado');
            $sServicoValorBaseCalculo = '-';
            $sServicoValorIss         = '-';
          }

          // Nota substituida
          if (!empty($aNota['documento_id_nota_substituta'])) {

            $sSituacaoDocumento       = utf8_decode('Substituida');
            $sServicoValorBaseCalculo = '-';
            $sServicoValorIss         = '-';
          }

          // Verifica se a nota foi substituida ou cancelada não soma os valores totais
          if ($aNota['documento_status_cancelamento'] != 't' && empty($aNota['documento_id_nota_substituta'])) {

            $fTotalBase += $aNota['servico_valor_base_calculo'];
            $fTotalIss  += $aNota['servico_valor_iss'];
          }

          $this->Cell($aLarguraCelulas[4], 5, $sSituacaoDocumento, 1, 0, 'L', NULL);
          $this->Cell($aLarguraCelulas[5], 5, $aNota['servico_item_lista_servico'], 1, 0, 'L', NULL);
          $this->Cell($aLarguraCelulas[6], 5, $sServicoValorAliquota, 1, 0, 'R', NULL);
          $this->Cell($aLarguraCelulas[7], 5, $sServicoValorBaseCalculo, 1, 0, 'R', NULL);
          $this->Cell($aLarguraCelulas[8], 5, $sServicoValorIss, 1, 0, 'R', NULL);
          $this->Cell($aLarguraCelulas[9], 5, $sTomadorCnpjCpf, 1, 0, 'L', NULL);
          $this->Cell($aLarguraCelulas[10], 5, $sTomadorRazaoSocial, 1, 0, 'L', NULL);
        }

        $this->SetFont('Arial', 'B', 8);
        $this->Ln();
        $this->Cell(113);
        $this->Cell($aLarguraCelulas[6], 5, 'Total:', 1);
        $this->Cell($aLarguraCelulas[7], 5, DBSeller_Helper_Number_Format::toMoney($fTotalBase), 1, 0, 'R');
        $this->Cell($aLarguraCelulas[8], 5, DBSeller_Helper_Number_Format::toMoney($fTotalIss), 1, 0, 'R');
      } else {

        $this->Ln();
        $this->Cell(0, 5, utf8_decode('Sem Lançamentos no Período'), 1, NULL, 'C');
      }

      $oStatement->closeCursor();
    } catch (Exception $oErro) {
      throw new Exception($oErro->getMessage());
    }
  }

  /**
   * Define os dados dos documentos substituídos
   *
   * @param \Doctrine\DBAL\Statement $oStatement
   * @param array                    $aParametros
   * @throws Exception
   */
  public function setDadosDocumentosSubstituidos(Doctrine\DBAL\Statement $oStatement, array $aParametros) {

    $this->SetFont('Arial', 'B', 8);
    $this->SetFillColor(201, 201, 201);
    $this->Cell(0, 5, utf8_decode('LANÇAMENTOS RETIDOS'), 1, 1, 'C', TRUE);
    $this->Ln(1);

    $aLarguraCelulas = array(6, 13, 10, 50, 25, 9, 12, 20, 20, 27, 85);

    $this->SetFillColor(230, 230, 230);
    $this->Cell($aLarguraCelulas[0], 5, utf8_decode('Dia'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[1], 5, utf8_decode('Número'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[2], 5, utf8_decode('Série'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[3], 5, utf8_decode('Tipo'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[4], 5, utf8_decode('Situação'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[5], 5, utf8_decode('Cod.'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[6], 5, utf8_decode('Aliq.(%)'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[7], 5, utf8_decode('Base(R$)'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[8], 5, utf8_decode('ISS(R$)'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[9], 5, utf8_decode('CNPJ Tomador'), 1, NULL, NULL, TRUE);
    $this->Cell($aLarguraCelulas[10], 5, utf8_decode('Razão Tomador'), 1, NULL, NULL, TRUE);
    $this->SetFont('Arial', NULL, 8);

    try {

      // Processa o query
      $oStatement->execute($aParametros);

      if ($oStatement->rowCount() > 0) {

        $fTotalBase = 0;
        $fTotalIss  = 0;

        // Varre a lista de documentos
        while ($aNota = $oStatement->fetch()) {

          // Define o dia da emissão do documento
          $sDiaEmissaoDocumento = substr($aNota['documento_data'], -2);

          $this->Ln();
          $this->Cell($aLarguraCelulas[0], 5, $sDiaEmissaoDocumento, 1, 0, 'C');
          $this->Cell($aLarguraCelulas[1], 5, $aNota['documento_numero'], 1, 0, 'R');
          $this->Cell($aLarguraCelulas[2], 5, $aNota['documento_serie'], 1, 0, 'R');

          // Tipo de documento
          if ($aNota['documento_classe'] == 'nfse') {

            $sTipoNota = 'NFSe';

            if ($aNota['documento_tipo']) {
              $aTipoNota = Contribuinte_Model_Nota::getDescricaoTipoNota($aNota['documento_tipo']);
              $sTipoNota = $aTipoNota[$aNota['documento_tipo']];
            }

            $this->Cell($aLarguraCelulas[3], 5, $sTipoNota, 1);
          } else if ($aNota['documento_classe'] == 'dms' && $aNota['documento_tipo']) {

            if ($aNota['documento_tipo_descricao']) {
              $sTipoNota = $aNota['documento_tipo_descricao'];
            } else {

              $aTipoNota = Contribuinte_Model_Nota::getDescricaoTipoNota($aNota['documento_tipo']);
              $sTipoNota = $aTipoNota[$aNota['documento_tipo']];
            }

            $this->Cell($aLarguraCelulas[3], 5, $sTipoNota, 1);
          } else {
            $this->Cell($aLarguraCelulas[3], 5, '-', 1);
          }

          // Formata dados
          $sServicoValorAliquota    = DBSeller_Helper_Number_Format::toMoney($aNota['servico_valor_aliquota']);
          $sServicoValorBaseCalculo = DBSeller_Helper_Number_Format::toMoney($aNota['servico_valor_base_calculo']);
          $sServicoValorIss         = DBSeller_Helper_Number_Format::toMoney($aNota['servico_valor_iss']);
          $sTomadorCnpjCpf          = DBSeller_Helper_Number_Format::maskCPF_CNPJ($aNota['tomador_cnpjcpf']);
          $sTomadorRazaoSocial      = utf8_decode($aNota['tomador_razao_social']);
          $sTomadorRazaoSocial      = substr($sTomadorRazaoSocial, 0, 50);

          // Trata a situação do documento
          switch (strtoupper($aNota['documento_situacao'])) {

            case 'T'  :
              $sSituacaoDocumento = utf8_decode('Tributado');
              break;
            case 'R'  :
              $sSituacaoDocumento = utf8_decode('Retido');
              break;
            case 'IS' :
              $sSituacaoDocumento = utf8_decode('Isento');
              break;
            case 'E'  :
              $sSituacaoDocumento = utf8_decode('Extraviado');
              break;
            default   :
              $sSituacaoDocumento = '-';
          }

          // ALtera a situação do documento quando a natureza for fora do município
          if ($aNota['documento_natureza_operacao'] == 2) {
            $sSituacaoDocumento = utf8_decode('Fora do Município');
          }

          // Nota cancelada
          if ($aNota['documento_status_cancelamento'] == 't' || $aNota['documento_situacao'] == 'c') {
            $sSituacaoDocumento = utf8_decode('Cancelado');
          }

          // Nota substituida
          if (!empty($aNota['documento_id_nota_substituta'])) {
            $sSituacaoDocumento = utf8_decode('Substituida');
          }

          // Verifica se a nota foi substituida ou cancelada não soma os valores totais
          if ($aNota['documento_status_cancelamento'] != 't' && empty($aNota['documento_id_nota_substituta'])) {

            $fTotalBase += $aNota['servico_valor_base_calculo'];
            $fTotalIss  += $aNota['servico_valor_iss'];
          }

          $this->Cell($aLarguraCelulas[4], 5, $sSituacaoDocumento, 1, 0, 'L', NULL);
          $this->Cell($aLarguraCelulas[5], 5, $aNota['servico_item_lista_servico'], 1, 0, 'L', NULL);
          $this->Cell($aLarguraCelulas[6], 5, $sServicoValorAliquota, 1, 0, 'R', NULL);
          $this->Cell($aLarguraCelulas[7], 5, $sServicoValorBaseCalculo, 1, 0, 'R', NULL);
          $this->Cell($aLarguraCelulas[8], 5, $sServicoValorIss, 1, 0, 'R', NULL);
          $this->Cell($aLarguraCelulas[9], 5, $sTomadorCnpjCpf, 1, 0, 'L', NULL);
          $this->Cell($aLarguraCelulas[10], 5, $sTomadorRazaoSocial, 1, 0, 'L', NULL);
        }

        $this->SetFont('Arial', 'B', 8);
        $this->Ln();
        $this->Cell(113);
        $this->Cell($aLarguraCelulas[6], 5, 'Total:', 1);
        $this->Cell($aLarguraCelulas[7], 5, DBSeller_Helper_Number_Format::toMoney($fTotalBase), 1, 0, 'R');
        $this->Cell($aLarguraCelulas[8], 5, DBSeller_Helper_Number_Format::toMoney($fTotalIss), 1, 0, 'R');
      } else {

        $this->Ln();
        $this->Cell(0, 5, utf8_decode('Sem Lançamentos no Período'), 1, NULL, 'C');
      }

      $oStatement->closeCursor();
    } catch (Exception $oErro) {
      throw new Exception($oErro->getMessage());
    }
  }

  /**
   * Imprime o rodapé do relatório
   *
   * @see FPDF::Footer()
   */
  public function Footer() {

    // Verifica se deve imprimir o número de páginas
    if ($this->lImprimePaginas) {

      $this->SetY(-15);
      $this->SetFont('Arial', 'I', 7);
      $this->Cell(0, 5, utf8_decode('Página ') . ++$this->iNumeroPagina, NULL, NULL, 'R');
    }
  }

  /**
   * Imprime o cabeçalho do relatório
   *
   * @see FPDF::Header()
   */
  public function Header() {

    $sTarjaSemValorFiscal  = APPLICATION_PATH . '/../public/administrativo/img/nfse/tarja_sem_valor.png';
    
    if (file_exists($sTarjaSemValorFiscal) && $this->sAmbiente != 'production') {
      $this->Image($sTarjaSemValorFiscal, 70, 20);
    }
  }
}