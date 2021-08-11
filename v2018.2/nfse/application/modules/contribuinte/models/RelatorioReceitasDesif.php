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

require_once(LIBRARY_PATH . '/DBSeller/Helper/Pdf/LivroFiscal.php');

/**
 * Classe para geração do relatório de importacao DES-IF (pdf)
 *
 * @package Contribuinte/Model
 * @see     DBSeller_Helper_Pdf_LivroFiscal
 */
class Contribuinte_Model_RelatorioReceitasDesif extends DBSeller_Helper_Pdf_LivroFiscal {

	/**
	 * Dados da Prefeitura
	 */
	private $oPrefeitura;

	/**
	 * Dados do ambiente
	 */
	private $sAmbiente;

	/**
	 * Retorna o ambiente da aplicação
	 * @return string $this->sAmbiente
	 */
	public function getAmbiente() {
		return $this->sAmbiente;
	}

	/**
	 * Altera o ambiente
	 * @param string $sAmbiente
	 */
	public function setAmbiente($sAmbiente) {
		$this->sAmbiente = $sAmbiente;
	}

	/**
	 * Retorna um objeto da prefeitura
	 * @return object $this->oPrefeitura
	 */
	public function getPrefeitura() {
		return $this->oPrefeitura;
	}

	/**
	 * Altera a prefeitura
	 * @param object $oPrefeitura
	 */
	public function setPrefeitura($oPrefeitura) {
		$this->oPrefeitura = $oPrefeitura;
	}

	/**
	 * Método que cria relatório de importação DES-If
	 * @param array $aReceitas
	 */
	public function setDadosReceitas($aReceitas) {

		// Notas Válidas
		$this->SetFont('Arial', 'B', 8);
		$this->SetFillColor(201, 201, 201);
		$this->Cell(0, 5, utf8_decode('RECEITAS'), 1, 1, 'C', TRUE);
		$this->Ln(1);

		$aLarguraCelulas = array(25, 77);

		$this->SetFillColor(230, 230, 230);
		$this->Cell($aLarguraCelulas[0], 5, utf8_decode('Código Cosif'), 1, NULL, NULL, TRUE);
		$this->Cell($aLarguraCelulas[1], 5, utf8_decode('Descrição da Conta'), 1, NULL, NULL, TRUE);
		$this->Cell($aLarguraCelulas[0], 5, utf8_decode('Aliq.(%)'), 1, NULL, NULL, TRUE);
		$this->Cell($aLarguraCelulas[0], 5, utf8_decode('Ins. Fiscal(R$)'), 1, NULL, NULL, TRUE);
		$this->Cell($aLarguraCelulas[0], 5, utf8_decode('Total Cred.(R$)'), 1, NULL, NULL, TRUE);
		$this->Cell($aLarguraCelulas[0], 5, utf8_decode('Total Debto.(R$)'), 1, NULL, NULL, TRUE);
		$this->Cell($aLarguraCelulas[0], 5, utf8_decode('Receita (R$)'), 1, NULL, NULL, TRUE);
		$this->Cell($aLarguraCelulas[0], 5, utf8_decode('Ded. Receita(R$)'), 1, NULL, NULL, TRUE);
		$this->Cell($aLarguraCelulas[0], 5, utf8_decode('Base(R$)'), 1, NULL, NULL, TRUE);
		$this->SetFont('Arial', NULL, 8);

		if (count($aReceitas) > 0) {

			foreach ($aReceitas as $iChave => $oReceita) {

				if (strlen($oReceita['descricao_conta']) >= 40) {
					$oReceita['descricao_conta'] = substr($oReceita['descricao_conta'], 0, 40) . "...";
				}

				$oReceita['aliq_issqn'] 		= DBSeller_Helper_Number_Format::toMoney($oReceita['aliq_issqn'], 2, NULL, '%');
				$oReceita['inct_fisc'] 			= DBSeller_Helper_Number_Format::toMoney($oReceita['inct_fisc'], 2, 'R$');
				$oReceita['valr_cred_mens'] = DBSeller_Helper_Number_Format::toMoney($oReceita['valr_cred_mens'], 2, 'R$');
				$oReceita['valr_debt_mens'] = DBSeller_Helper_Number_Format::toMoney($oReceita['valr_debt_mens'], 2, 'R$');
				$oReceita['rece_decl'] 			= DBSeller_Helper_Number_Format::toMoney($oReceita['rece_decl'], 2, 'R$');
				$oReceita['dedu_rece_decl'] = DBSeller_Helper_Number_Format::toMoney($oReceita['dedu_rece_decl'], 2, 'R$');
				$oReceita['base_calc'] 			= DBSeller_Helper_Number_Format::toMoney($oReceita['base_calc'], 2, 'R$');

				$this->Ln();
				$this->Cell($aLarguraCelulas[0], 5, utf8_decode($oReceita['conta_abrasf']), 1, NULL, NULL);
				$this->Cell($aLarguraCelulas[1], 5, utf8_decode($oReceita['descricao_conta']), 1, NULL, NULL);
				$this->Cell($aLarguraCelulas[0], 5, utf8_decode($oReceita['aliq_issqn']), 1, NULL, NULL);
				$this->Cell($aLarguraCelulas[0], 5, utf8_decode($oReceita['inct_fisc']), 1, NULL, NULL);
				$this->Cell($aLarguraCelulas[0], 5, utf8_decode($oReceita['valr_cred_mens']), 1, NULL, NULL);
				$this->Cell($aLarguraCelulas[0], 5, utf8_decode($oReceita['valr_debt_mens']), 1, NULL, NULL);
				$this->Cell($aLarguraCelulas[0], 5, utf8_decode($oReceita['rece_decl']), 1, NULL, NULL);
				$this->Cell($aLarguraCelulas[0], 5, utf8_decode($oReceita['dedu_rece_decl']), 1, NULL, NULL);
				$this->Cell($aLarguraCelulas[0], 5, utf8_decode($oReceita['base_calc']), 1, NULL, NULL);
			}
		} else {

			$this->Ln();
			$this->Cell(0, 5, utf8_decode('Sem receitas neste Período'), 1, NULL, 'C');
		}
	}

	/**
   * Imprime o cabeçalho do relatório
   *
   * @see DBSeller_Helper_Pdf_LivroFiscal::Header()
   */
  public function Header() {

    $sTarjaSemValorFiscal  = APPLICATION_PATH . '/../public/administrativo/img/nfse/tarja_sem_valor.png';

    if (file_exists($sTarjaSemValorFiscal) && $this->getAmbiente() != 'production') {
      $this->Image($sTarjaSemValorFiscal, 70, 20);
    }

    $this->setDadosPrefeitura($this->oPrefeitura, FALSE);
  }
}