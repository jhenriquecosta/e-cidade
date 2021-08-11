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
 * Interface para os documentos de notas
 */

/**
 * @package Contribuinte
 * @subpackage Interface
 * @author Gilton Guma <gilton@dbseller.com.br>
 */
interface Contribuinte_Interface_DocumentoNota {
  
  /**
   * Retorna o identificador
   *
   * @return integer
   */
  public function getId();
  
  /**
   * Retorna o mes de competencia
   *
   * @return integer
   */
  public function getCompetenciaMes();

  /**
   * Retorna o ano de competencia
   *
   * @return integer
   */
  public function getCompetenciaAno();

  /**
   * Retorna o codigo da planilha
   *
   * @return integer
   */
  public function getCodigoNotaPlanilha();

  /**
   * Retorna o numero da nota
   *
   * @return string
   */
  public function getNotaNumero();

  /**
   * Retorna a data da nota
   *
   * @return datetime
   */
  public function getNotaData();

  /**
   * Retorna o percentual de aliquota do servico
   *
   * @return float
   */
  public function getServicoAliquota();

  /**
   * Retorna se o imposto esta sendo retido
   *
   * @return boolean
   */
  public function getServicoImpostoRetido();

  /**
   * Retorna o valor da base de calculo
   *
   * @return float
   */
  public function getServicoBaseCalculo();

  /**
   * Retorna o valor da deducao de imposto
   *
   * @return float
   */
  public function getServicoValorDeducao();
  
  /**
   * Retorna o valor do imposto (ISS)
   *
   * @return float
   */
  public function getServicoValorImposto();

  /**
   * Retorna o valor do servico
   *
   * @return float
   */
  public function getServicoValorPagar();

  /**
   * Retorna a situacao do documento
   *
   * @return string
   */
  public function getSituacaoDocumento();

  /**
   * Retorna a descricao do servico
   *
   * @return string
   */
  public function getDescricaoServico();

  /**
   * Retorna o CPF / CNPJ do prestador do servico
   *
   * @return string
   */
  public function getPrestadorCpfCnpj();

  /**
   * Retorna a inscricao municipal do prestador do servico
   *
   * @return string
   */
  public function getPrestadorInscricaoMunicipal();

  /**
   * Retorna a razao social do prestador do servico
   *
   * @return string
   */
  public function getPrestadorRazaoSocial();

  /**
   * Retorna o CPF / CNPJ do tomador do servico
   *
   * @return string
   */
  public function getTomadorCpfCnpj();

  /**
   * Retorna a inscricao municipal do tomador do servico
   *
   * @return string
   */
  public function getTomadorInscricaoMunicipal();

  /**
   * Retorna a razao social do tomador do servico
   *
   * @return string
   */
  public function getTomadorRazaoSocial();
  
  /**
   * Retorna a operacao da Dms_Nota
   *
   * @return string
   */
  public function getOperacao();
  
  
  
  
}