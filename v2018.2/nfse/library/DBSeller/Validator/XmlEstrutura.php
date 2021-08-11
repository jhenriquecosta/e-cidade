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
 * Classe para validação de esquemas com XSD nos arquivos XML
 * 
 * @package DBSeller/Validator 
 */

class DBSeller_Validator_XmlEstrutura extends Zend_Validate_Abstract {
  
  /**
   * Índice do erro
   * 
   * @var string
   */
  const FORMAT_INVALIDO = 'formato_invalido';
  
  /**
   * Nome do arquivo schema que será utilizado para validar o Xml (Caminho + Nome)
   * 
   * @var string
   */
  private $sArquivoSchema;
  
  /**
   * Método construtor
   *
   * @param string $sArquivoSchema
   */
  public function __construct($sArquivoSchema) {
  
    if (empty($sArquivoSchema) || !is_string($sArquivoSchema)) {
      throw new Exception('Informe o Schema.');
    }
    
    $this->sArquivoSchema = $sArquivoSchema;
  }
  
  /**
   * Função para fazer a validação do arquivo com o schema
   * 
   * (non-PHPdoc)
   * @see Zend_Validate_Interface::isValid()
   */
  public function isValid($sArquivo) {
    
    if (!is_file($sArquivo)) {
      throw new Exception('Arquivo inválido.');
    }
    
    libxml_use_internal_errors(TRUE);
    
    $oXml = new DOMDocument();
    $oXml->load($sArquivo);
     
    if ($oXml->schemaValidate($this->sArquivoSchema)) {
      return TRUE;
    }
    
    foreach (libxml_get_errors() as $oErro) {
      
      $sNameSpace = '{http://www.abrasf.org.br/ABRASF/arquivos/nfse.xsd}';
      $sErro      = str_replace($sNameSpace, NULL, "Linha {$oErro->line}: {$oErro->message}");
      
      $this->_errors[] = $sErro;
    }
    
    return FALSE;
  }
}