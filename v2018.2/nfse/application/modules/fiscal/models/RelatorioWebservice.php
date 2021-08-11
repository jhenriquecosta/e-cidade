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
 * Class Fiscal_Model_RelatorioWebservice
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 * @package Fiscal/Model
 * @see     Fiscal_Model_Relatoriopdfmodelo1 (FPDF)
 */
class Fiscal_Model_RelatorioWebservice extends Fiscal_Model_Relatoriopdfmodelo1{

	private $sAmbiente;

	/**
	 * Busca o ambiente
	 * @return $this->sAmbiente
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
	 * Cria o relatório
	 * @param array $aContribuintes
	 * @param string $sAmbiente
	 */
	public function gerarPdf($aContribuintes, $sAmbiente) {

		$this->Addpage();
		$this->SetFont('Arial', '', 10);
		$this->SetFillColor(201, 201, 201);
    $this->Cell(50, 5, utf8_decode('INSCRIÇÃO MUNICIPAL'), 1, NULL, NULL, TRUE);
    $this->Cell(0, 5, utf8_decode('PRESTADOR'), 1, 'C', NULL, TRUE);
    $this->Ln();

    foreach ($aContribuintes as $aContribuinte) {
    	$this->Cell(50, 5, utf8_decode($aContribuinte['im']), 1);
    	$this->Cell(0, 5, utf8_decode($aContribuinte['nome']), 1);
    	$this->Ln();
    }
	}

	/**
   * Reescrita do Metodo Header da Classe FPDF
   *
   * @see FPDF::Header()
   */
	public function Header() {

		$sLogotipoPrefeitura   = APPLICATION_PATH . '/../public/global/img/brasao.jpg';
		$sTarjaSemValorFiscal  = APPLICATION_PATH . '/../public/administrativo/img/nfse/tarja_sem_valor.png';

		if (file_exists($sLogotipoPrefeitura)) {
		  $this->Image($sLogotipoPrefeitura, 12, 10);
		}

		if(file_exists($sTarjaSemValorFiscal) && getenv("APPLICATION_ENV") != 'production'){
		  $this->Image($sTarjaSemValorFiscal, 30, 50);
		}

		$oParametrosPrefeitura = Administrativo_Model_ParametroPrefeitura::getAll();


		$this->SetFont('Arial', '', 12);
		$this->Cell(0, 8, utf8_decode($oParametrosPrefeitura[0]->getNome()),0, 1, 'C');
		$this->Cell(0, 8, utf8_decode('RELATÓRIO DE CONTRIBUINTES COM PERMISSÃO AO WEBSERVICE'), 0, 1, 'C');
		$this->SetFont('Arial', 'U', 12);
		$this->Cell(0, 8, utf8_decode($this->sAmbiente), 0, 1, 'C');
		$this->Ln(20);
	}

	/**
   * Reescrita do Metodo Footer da Classe FPDF
   *
   * @see FPDF::Footer()
   */
  public function Footer() {

    $this->SetFont('Arial', 'I', 6);
    $this->SetY(-10);

    $sPagina = utf8_decode("Página: {$this->PageNo()}");

    $this->Cell(0, 5, $sPagina, 0, 1, 'R');
  }
}