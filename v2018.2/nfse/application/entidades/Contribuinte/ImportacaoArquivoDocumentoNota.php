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
 * Classe responsável pela manipulação do banco de dados nos documentos da importação de arquivos do tipo nota
 */
namespace Contribuinte;

/**
 * @Entity
 * @Table(name="importacao_arquivo_documento_nota")
 */
class ImportacaoArquivoDocumentoNota {
  
  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id_importacao_arquivo_documento = NULL;
  
  /**
   * @Column(type="integer")
   */
  protected $id_nota = NULL;
  
  /**
   * Retorna o id do documento de importação
   * 
   * @return integer
   */
  public function getIdImportacaoArquivoDocumento() {
    return $this->id_importacao_arquivo_documento;
  }
  
  /**
   * Define o id do arquivo de importação
   * 
   * @param integer $iIdImportacaoArquivoDocumento
   */
  public function setIdImportacaoArquivoDocumento($iIdImportacaoArquivoDocumento) {
    $this->id_importacao_arquivo_documento = $iIdImportacaoArquivoDocumento;
  }
  
  /**
   * Retorna o id da nota
   */
  public function getIdNota() {
    return $this->id_nota;
  }
  
  /**
   * Define o id da nota
   *  
   * @param integer $iIdNota
   */
  public function setIdNota($iIdNota) {
    $this->id_nota = $iIdNota;
  }
}