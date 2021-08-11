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


require_once(APPLICATION_PATH . '/../library/FPDF/Fpdf2File.php');

/**
 * Class Administrativo_Model_RelatorioPdfModelo1
 *
 * @use Fpdf2File (FPDF)
 * @package Administrativo/Model
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Administrativo_Model_RelatorioPdfModelo1 extends Fpdf2File {

  /**
   * Dados da Prefeitura para exibir
   *
   * @var object
   */
  private $oDadosPrefeitura = NULL;

  /**
   * Identifica se tem quebra de página
   *
   * @var boolean
   */
  public $lQuebrouPagina = FALSE;

  /**
   * Dados do Usuario Logado a exibir
   *
   * @var stdClass
   */
  private $oDadosUsuario = NULL;

  /**
   * Descrição e filtros do relatório
   *
   * @var stdClass
   */
  private $oCabecalho = NULL;

  /**
   * Adiciona linhas no filtro do cabeçalho
   *
   * @param $sFiltro
   */
  public function setLinhaFiltro($sFiltro) {

    $this->oCabecalho->aLinhas[] = $sFiltro;
  }

  /**
   * Construtor da classe Modelo Relatório
   */
  public function carregaDados() {

    $aIdentity              = Zend_Auth::getInstance()->getIdentity();
    $this->oDadosPrefeitura = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    $this->oDadosUsuario    = Administrativo_Model_Usuario::getById($aIdentity['id']);
    $this->SetFillColor(220, 220, 220);
    $this->AddPage();
    $this->SetAutoPageBreak(TRUE, 12);
  }

  /**
   * Cabeçalho do relatórios
   *
   * @throws Exception
   */
  public function Header() {

    $this->SetCreator(utf8_decode('Sistema: EcidadeOnline2 - DBSeller Sistemas Integrados'));

    $sLogotipoPrefeitura = APPLICATION_PATH . '/../public/global/img/brasao.jpg';

    if (file_exists($sLogotipoPrefeitura)) {
      $this->Image($sLogotipoPrefeitura, $this->rMargin, $this->tMargin, 20);
    }

    $sNomePrefeitura = utf8_decode($this->oDadosPrefeitura->getNome());
    $sRua            = utf8_decode(trim($this->oDadosPrefeitura->getEndereco()));
    $sNumero         = utf8_decode(trim($this->oDadosPrefeitura->getNumero()));
    $sMunicipio      = utf8_decode(trim($this->oDadosPrefeitura->getMunicipio()));
    $sEstado         = utf8_decode(trim($this->oDadosPrefeitura->getUf()));
    $sTelefone       = utf8_decode(trim($this->oDadosPrefeitura->getTelefone()));
    $sTelefone       = DBSeller_Helper_Number_Format::maskPhoneNumber($sTelefone);
    $sCnpj           = utf8_decode(trim($this->oDadosPrefeitura->getCnpj()));
    $sCnpj           = DBSeller_Helper_Number_Format::maskCPF_CNPJ($sCnpj);
    $sUrl            = utf8_decode(trim($this->oDadosPrefeitura->getUrl()));
    $sEmail          = utf8_decode(trim($this->oDadosPrefeitura->getEmail()));

    if (strlen($sNomePrefeitura) > 42) {
      $iTamanhoFonte = 8;
    } else {
      $iTamanhoFonte = 9;
    }

    $this->SetFont('Arial', 'BI', $iTamanhoFonte);
    $this->Text($this->rMargin + 22, $this->tMargin + 5, $sNomePrefeitura);
    $this->SetFont('Arial', 'I', 8);

    $sComplento = '';

    if ($this->oDadosPrefeitura->getComplemento()) {
      $sComplento = ', ' . substr(trim($this->oDadosPrefeitura->getComplemento()), 0, 20);
    }

    $this->Text($this->rMargin + 22, $this->tMargin + 8, "{$sRua}, {$sNumero} {$sComplento}");
    $this->Text($this->rMargin + 22, $this->tMargin + 11, "{$sMunicipio} - {$sEstado}");
    $this->Text($this->rMargin + 22, $this->tMargin + 14, "{$sTelefone} - CNPJ : {$sCnpj}");
    $this->Text($this->rMargin + 22, $this->tMargin + 17, $sEmail);
    $this->Text($this->rMargin + 22, $this->tMargin + 20, $sUrl);
    $this->SetFont('Arial', '', 7);

    $iComprimento = ($this->w - $this->rMargin - $this->lMargin);

    if ($this->CurOrientation == 'L') {

      $iTamanhoRetangulo = $iComprimento - 200;
      $iRMargemRetangulo = $this->rMargin + 200;
      $iComprimento      = $iComprimento - 6;
    } else {

      $iTamanhoRetangulo = $iComprimento - 120;
      $iRMargemRetangulo = $this->rMargin + 120;
    }

    $this->line($this->rMargin, $this->tMargin + 25, $iComprimento + $this->rMargin, $this->tMargin + 25);
    $this->setfillcolor(255);

    if (!empty($this->oCabecalho)) {

      if (count($this->oCabecalho->aLinhas) > 7) {
        throw new Exception ('Número de Registro do Header é maior que o permitido.');
      }

      foreach ($this->oCabecalho->aLinhas as $iLinha => $sHeader) {

        $this->SetXY($iComprimento - 60, $this->tMargin + 2 + ($iLinha * 3));
        $this->Cell(70, 3, utf8_decode($sHeader), 0, 1, 'J', TRUE);
      }
    }

    $this->Rect($iRMargemRetangulo, $this->tMargin, $iTamanhoRetangulo, 25);
    $this->setY(35);
    $this->ln(5);
  }

  /**
   * Pula para a próxima página caso a soma das linhas ultrapasse o valor informado
   *
   * @param integer $iTamanho Colocar a soma da altura das linhas que somadas com a posição atual devem pular página
   */
  public function proximaPagina($iTamanho) {

    $this->lQuebrouPagina = FALSE;

    $iTamanhoCabecalho    = $this->tMargin + 10;
    $iTamanhoRodape       = $this->bMargin + 5;
    $iTamanhoPagina       = intval($this->h - $iTamanhoCabecalho - $iTamanhoRodape);
    $iPosicaoAtual        = $this->GetY();

    if (($iPosicaoAtual + $iTamanho) >= $iTamanhoPagina) {

      $this->addPage();
      $this->lQuebrouPagina = TRUE;
    }
  }

  /**
   * Reescrita do Metodo Footer da Classe FPDF
   *
   * @see FPDF::Footer()
   */
  public function Footer() {

    $this->SetFont('Arial', 'I', 6);
    $this->SetY(-10);

    $sRodape = "Sistema: EcidadeOnline2 - Login: {$this->oDadosUsuario->getLogin()}";
    $sRodape.= " ({$this->oDadosUsuario->getNome()}) ";
    $sRodape.= 'Data/Hora: ' . date('d-m-Y/H:i:s');
    $sPagina = utf8_decode("Página: {$this->PageNo()}");

    $this->Cell(0, 5, $sRodape, 'T', 0, 'L');
    $this->Cell(0, 5, $sPagina, 0, 1, 'R');
  }
}