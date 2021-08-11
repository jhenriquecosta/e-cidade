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

class Contribuinte_Model_ImpressaoAidof extends Fpdf2File {

  /**
   * Método que monta o pdf para Aidof
   *
   * @param  array $aDadosAidof
   * @return array $aRetorno
   */
  public function montarelatorio($aDadosAidof) {

    $sNomeArquivo    = '/aidof_' . date('YmsdHis') . '.pdf';
    $sCaminhoArquivo = TEMP_PATH . $sNomeArquivo;
    $this->Open($sCaminhoArquivo);

    for ($i = $aDadosAidof['inicial']; $i <=  $aDadosAidof['final']; $i++) {

      //For para gerar duas vias de cada Aidof
      for($j=0; $j<2; $j++) {

        $this->AddPage();
        $this->lImprimePaginas = TRUE;
        $sLogotipoPrefeitura   = APPLICATION_PATH . '/../public/global/img/brasao.jpg';
        $sTarjaSemValorFiscal  = APPLICATION_PATH . '/../public/administrativo/img/nfse/tarja_sem_valor.png';

        if (file_exists($sLogotipoPrefeitura)) {
          $this->Image($sLogotipoPrefeitura, 12, 10);
        }

        if(file_exists($sTarjaSemValorFiscal) && $aDadosAidof['ambiente'] != 'production'){
          $this->Image($sTarjaSemValorFiscal, 30, 50);
        }

        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, utf8_decode($aDadosAidof['nome_prefeitura']),0, 1, 'C');
        $this->Cell(0, 8, utf8_decode('RECIBO PROVISÓRIO DE SERVIÇOS - RPS'), 0, 0, 'C');
        $this->Ln(15);

        $this->Cell(25, 6, utf8_decode('   RPS - Nr: '), 0, 0, 'L');
        $this->Cell(40, 6, $i, 0, 0, 'L');
        $this->Cell(30, 6, utf8_decode(($j == 0)? "1ª VIA" : "2ª VIA"), 0, 0, 'L');
        $this->Cell(95, 6, utf8_decode('   DATA:_____/____/_______   '), 0, 1, 'L');
        $this->Ln(8);

        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(0, 6, utf8_decode('Prestador de Serviços'), "T L R", 1, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(30, 6, utf8_decode('Inscrição Municipal:'), "L", 0, 'L');
        $this->Cell(160, 6, utf8_decode($aDadosAidof['incricao_municipal']), "R", 1, 'L');
        $this->Cell(30, 6, utf8_decode('Nome/Razão Social:'), "L", 0, 'L');
        $this->Cell(160, 6, utf8_decode($aDadosAidof['nome_razao']), "R", 1, 'L');
        $this->Cell(10, 6, utf8_decode('CNPJ:'), "L", 0, 'L');
        $this->Cell(180, 6, utf8_decode($aDadosAidof['cnpj']), "R", 1, 'L');
        $this->Cell(20, 6, utf8_decode('Endereço:'), "L", 0, 'L');
        $this->Cell(170, 6, utf8_decode($aDadosAidof['endereco']), "R", 1, 'L');
        $this->Cell(20, 6, utf8_decode('Município:   '), "L", 0, 'L');
        $this->Cell(90, 6, utf8_decode($aDadosAidof['municipio']), 0, 0, 'L');
        $this->Cell(10, 6, utf8_decode('UF:   '), 0, 0, 'L');
        $this->Cell(20, 6, utf8_decode($aDadosAidof['uf']), 0, 0, 'L');
        $this->Cell(10, 6, utf8_decode('CEP:   '), 0, 0, 'L');
        $this->Cell(40, 6, utf8_decode($aDadosAidof['cep']), "R", 1, 'L');
        $this->Cell(20, 6, utf8_decode('Email:   '), "LB", 0, 'L');
        $this->Cell(90, 6, utf8_decode($aDadosAidof['email']), "B", 0, 'L');
        $this->Cell(10, 6, utf8_decode('Fone:   '), "B", 0, 'L');
        $this->Cell(70, 6, utf8_decode($aDadosAidof['fone']), 'RB', 1, 'L');
        $this->Ln(6);

        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(0, 6, utf8_decode('Tomador de Serviços'), "T L R", 1, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 6, utf8_decode('Nome/Razão Social:'), "LB R", 1, 'L');
        $this->Cell(0, 6, utf8_decode('CNPJ:'), "L RB", 1, 'L');
        $this->Cell(0, 6, utf8_decode('Endereço:'), "L BR", 1, 'L');
        $this->Cell(85, 6, utf8_decode('Município:'), "BL", 0, 'L');
        $this->Cell(45, 6, utf8_decode('UF:'), "B", 0, 'L');
        $this->Cell(60, 6, utf8_decode('CEP:'), "BR", 1, 'L');
        $this->Cell(0, 6, utf8_decode('Email:'), "B RL", 1, 'L');
        $this->Ln(6);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 6, utf8_decode('Município onde foi realizado o serviço:'), "TRBL", 1, 'L');
        $this->Ln(6);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 6, utf8_decode('Descrição dos Serviços:'), "TLR", 1, 'L');
        $this->Cell(0, 57, "", "BLR", 1, 'L');
        $this->Ln(6);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 6, utf8_decode('Valor(es) de Retenção(ões)'), "T L R", 1, 'L');
        $this->SetFont('Arial', '', 8);
        $this->Cell(47, 6, utf8_decode('INSS:'), "LB", 0, 'L');
        $this->Cell(45, 6, utf8_decode('IR:'), 'B', 0, 'L');
        $this->Cell(47, 6, utf8_decode('CSLL:'), 'B', 0, 'L');
        $this->Cell(51, 6, utf8_decode('COFINS:'), 'BR', 1, 'L');
        $this->Cell(47, 6, utf8_decode('PIS:'), "BL", 0, 'L');
        $this->Cell(45, 6, utf8_decode('ISS:'), 'B', 0, 'L');
        $this->Cell(98, 6, utf8_decode('Outras:'), 'BR', 1, 'L');
        $this->Ln(6);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 6, utf8_decode('Valor do serviço:R$'), "TRBL", 1, 'L');
        $this->Ln(6);

        $sInformacaoComp  = "Este RPS deverá ser convertido em NF-e até o décimo dia subseqüente a sua emissão, ";
        $sInformacaoComp .= "conforme o que determina a Legislação vigente. Concordo que a minha responsabilidade por ";
        $sInformacaoComp .= "este RPS continua em vigor, tornando-me responsável no caso em que a pessoa, companhia ";
        $sInformacaoComp .= "ou associação indicada deixe de pagar parcial ou totalmente a soma das despesas aqui ";
        $sInformacaoComp .= "especificadas." . PHP_EOL;
        $sInformacaoComp .= "Consultas no site da Prefeitura {$aDadosAidof['url_prefeitura']}";

        $this->SetFont('Arial', '', 7);
        $this->MultiCell(0, 5, utf8_decode($sInformacaoComp), "TLRB");
      }
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
}