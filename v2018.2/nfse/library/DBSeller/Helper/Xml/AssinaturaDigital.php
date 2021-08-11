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
 * Classe para verificação da assinatura digital de um documento XML
 * Class DBSeller_Helper_Xml_AssinaturaDigital
 */
class DBSeller_Helper_Xml_AssinaturaDigital {

  /**
   * Caminho do Arquivo XML
   * @var string
   */
  private $sFile;

  /**
   * Texto do Certificado
   * @var Array
   */
  private $aCertificado;

  /**
   * SCnpj do certificado
   * @var string
   */
  private $sCnpj;

  /**
   * Documento XML
   * @var DOMDocument
   */
  private $oDomDocument;

  private $lastError;

  CONST ERRO_CERTIFICADO_VENCIDO       = 'Certificado informado está vencido!';

  CONST ERRO_INTEGRIDADE_DOCUMENTO     = 'Integridade do arquivo foi violada!';

  CONST ERRO_ASSINATURA_INVALIDA       = 'A assinatura do arquivo não é validade para a certificado informado!';

  CONST ERRO_ASSINATURA_NAO_ENCONTRADA = 'Arquivo sem assinatura!';

  /**
   * Instancia uma nova validacao das Assinaturas Digitais de documentos XML
   *
   * @param string $sFile Arquivo a ser validado
   * @throws Exception
   */
  public function __construct($sFile) {

    if (empty($sFile)) {
      throw new Exception("Arquivo deve ser informado");
    }

    $this->sFile = $sFile;
    $this->oDomDocument  = new DOMDocument();
    $this->oDomDocument->loadXml($sFile);
  }

  /**
   * Retorna o CNPJ encontrado no certificado certificao
   * @return mixed
   */
  public function getCnpj() {

    $sCnpj    = '';
    $aNosCnpj =  $this->oDomDocument->getElementsByTagName('Cnpj');
    if ($aNosCnpj->length > 0) {
        $sCnpj = $aNosCnpj->item(0)->nodeValue;
    }
    return $sCnpj;
  }

  /**
   * Realiza a validação do documento.
   * @param bool $lVerificarIntegridadeDocumento true para validar a integridade do documento
   * @return bool
   */
  public function validar($lVerificarIntegridadeDocumento = true) {

    if ($this->getDataFinal() < new DateTime()) {

      $this->lastError = self::ERRO_CERTIFICADO_VENCIDO;
      return false;
    }
    $oXMLSecDSig = new DBSeller_Helper_Xml_Security_XMLSecurityDSig();
    $oAssinatura = $oXMLSecDSig->locateSignature($this->oDomDocument);
    if (empty($oAssinatura)) {

      $this->lastError = self::ERRO_ASSINATURA_NAO_ENCONTRADA;
      return false;
    }

    $oXMLSecDSig->canonicalizeSignedInfo();
    if ($lVerificarIntegridadeDocumento && !$oXMLSecDSig->validateReference() ) {

      $this->lastError = self::ERRO_INTEGRIDADE_DOCUMENTO;
      return false;
    }

    $oKeyData = $oXMLSecDSig->locateKey();
    if (!$oKeyData) {

      $this->lastError = self::ERRO_ASSINATURA_INVALIDA;
      return false;
    }

    $objKeyInfo = DBSeller_Helper_Xml_Security_XMLSecEnc::staticLocateKeyInfo($oKeyData, $oAssinatura);
    return $oXMLSecDSig->verify($objKeyInfo);
  }

  /**
   * Retorna os dados do Certificado Digital
   * @return array|int
   */
  protected  function getCertificado() {

    if (empty($this->aCertificado)) {

      $aAssinatura  = $this->oDomDocument->getElementsByTagName('Signature');
      if ($aAssinatura->length == 0) {
        return false;
      }

      $oAssinatura  = $aAssinatura->item($aAssinatura->length - 1);
      $oX509Node    = $oAssinatura->getElementsByTagName('X509Certificate');
      $sCertificado  = "-----BEGIN CERTIFICATE-----\n";
      $sCertificado .= chunk_split(str_replace("\n", "", $oX509Node->item(0)->nodeValue));
      $sCertificado .= "-----END CERTIFICATE-----";
      $oX509Certificate = openssl_x509_read($sCertificado);
      if (!empty($oX509Certificate)) {
         $this->aCertificado = openssl_x509_parse($oX509Certificate);
      }
    }
    return $this->aCertificado;
  }


  /**
   * Retorna o o nome de quem está assinado o certificado
   * @return string
   */
  public function getCommonName() {

    $aCertificado = $this->getCertificado();
    if (!empty($aCertificado)) {

      return $aCertificado['subject']['CN'];
    }
    return '';
  }

  /**
   * Retorna a Data final do
   * @return DateTime
   */
  public function getDataFinal() {

    $aCertificado    = $this->getCertificado();
    $sTimeStampFinal = $aCertificado["validTo_time_t"];
    return new DateTime(date("Y-m-d", $sTimeStampFinal));
  }

  public function getLastError() {
    return $this->lastError;
  }
}