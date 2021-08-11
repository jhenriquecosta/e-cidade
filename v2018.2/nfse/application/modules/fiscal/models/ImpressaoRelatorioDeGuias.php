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
 * Classe para importação de arquivo de DMS
 *
 * @package Contribuinte
 * @subpackage Model
 *
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
require_once(APPLICATION_PATH . '/../library/FPDF/Fpdf2File.php');

class Fiscal_Model_ImpressaoRelatorioDeGuias extends Fpdf2File {

  /**
   *  Amviente do sistema
   */
  private $setAmbiente;

  /**
   * Dados do relatório
   */
  private $aDados;

  /**
   * Número de páginas do relatóriao
   */
  private $iNumeroPagina;

  /**
   * Número de páginas do relatóriao
   */
  private $sPrefeitura;

  /**
   * Busca a Prefeitura
   * @return string
   */
  public function getPrefeitura() {
    return $this->sPrefeitura;
  }

  /**
   * Muda a Prefeitura
   * @param string $sPrefeitura
   */
  public function setPrefeitura($sPrefeitura) {
    $this->sPrefeitura = $sPrefeitura;
  }

  /**
   * Busca o ambiente
   * @return string
   */
  public function getAmbiente() {
    return $this->sAmbiente;
  }

  /**
   * Muda o ambiente
   * @param string $sAmbiente
   */
  public function setAmbiente($sAmbiente) {
    $this->sAmbiente = $sAmbiente;
  }

  /**
   * Busca os dados do relatório
   * @return array
   */
  public function getDados() {
    return $this->aDados;
  }

  /**
   * Muda os dados do relatório
   * @param array $aDados
   */
  public function setDados($aDados) {
    $this->aDados = $aDados;
  }

  /**
   * Método que monta o pdf para o relatório de guias
   *
   * @return array $aRetorno
   */
  public function montaRelatorio() {

    $sNomeArquivo    = '/relatorio_guias_' . date('YmsdHis') . '.pdf';
    $sCaminhoArquivo = TEMP_PATH . $sNomeArquivo;
    $this->Open($sCaminhoArquivo);
    $this->AddPage();

    $this->SetFont('Arial', 'B', 8);
    $this->Cell(20, 6, utf8_decode('Competência'), "T L R B", 0, 'C');
    $this->Cell(23, 6, utf8_decode('Valor Total'), "T L R B", 0, 'C');
    $this->Cell(23, 6, utf8_decode('Valor ISS'), "T L R B", 0, 'C');
    $this->Cell(70, 6, utf8_decode('Contribuinte'), "T L R B", 0, 'C');
    $this->Cell(20, 6, utf8_decode('Inscrição'), "T L R B", 0, 'C');
    $this->Cell(35, 6, utf8_decode('CPF/CNPJ'), "T L R B", 1, 'C');

    $this->SetFont('Arial', '', 8);

    foreach ($this->aDados as $oDados) {

      $oDados->cnpj = DBSeller_Helper_Number_Format::maskCPF_CNPJ($oDados->cnpj);


      if (strlen($oDados->razaoSocial) > 35) {
        $oDados->razaoSocial = trim(substr($oDados->razaoSocial, 0, 35)) . "...";
      }

      $this->Cell(20, 6, utf8_decode($oDados->competencia), "T L R B", 0, 'C');
      $this->Cell(23, 6, utf8_decode($oDados->valorTotal), "T L R B", 0, 'C');
      $this->Cell(23, 6, utf8_decode($oDados->valorIss), "T L R B", 0, 'C');
      $this->Cell(70, 6, utf8_decode(trim($oDados->razaoSocial)), "T L R B", 0, 'L');
      $this->Cell(20, 6, utf8_decode($oDados->im), "T L R B", 0, 'C');
      $this->Cell(35, 6, utf8_decode($oDados->cnpj), "T L R B", 1, 'C');
    }

    $this->Output();

    // Opções de retorno
    $aRetorno = array(
        'location' => $sCaminhoArquivo,
        'filename' => $sNomeArquivo,
        'type'     => 'application/pdf'
    );

    return $aRetorno;
  }

  /**
   * Imprime o cabeçalho do relatório
   *
   * @see FPDF::Header()
   */
  public function Header() {

    $sLogotipoPrefeitura   = APPLICATION_PATH . '/../public/global/img/brasao.jpg';

    if (file_exists($sLogotipoPrefeitura)) {
      $this->Image($sLogotipoPrefeitura, 12, 10);
    }

    $this->SetFont('Arial', '', 12);
    $this->Cell(0, 8, utf8_decode($this->sPrefeitura),0, 1, 'C');
    $this->Cell(0, 8, utf8_decode('RELATÓRIO DE GUIAS A SEREM EMITIDAS'), 0, 0, 'C');
    $this->Ln(15);

    $sTarjaSemValorFiscal  = APPLICATION_PATH . '/../public/administrativo/img/nfse/tarja_sem_valor.png';

    if (file_exists($sTarjaSemValorFiscal) && $this->sAmbiente != 'production') {
      $this->Image($sTarjaSemValorFiscal, 40, 20);
    }
  }

  /**
   * Imprime o rodapé do relatório
   *
   * @see FPDF::Footer()
   */
  public function Footer() {

    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 7);
    $this->Cell(0, 5, utf8_decode('Página ') . ++$this->iNumeroPagina, NULL, NULL, 'R');
  }
}