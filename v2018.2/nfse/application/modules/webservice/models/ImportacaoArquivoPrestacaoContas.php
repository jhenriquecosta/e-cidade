<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2016  DBSeller Servicos de Informatica
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
 * Classe responsável pela validação e interpretação do xml na consulta dos valores movimentados dos contribuintes para a prestação de contas
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
class WebService_Model_ImportacaoArquivoPrestacaoContas extends WebService_Lib_Models_ModeloImportacao implements WebService_Lib_Interfaces_ModeloImportacao {

  /**
   * Processa xml para object
   * @return object
   */
  public function processaXmlEntradaWebservice(){

    $oXml = new stdClass;
    $oXml->sDataInicio = (string) trim($this->oXml->Filtros->DataInicio);
    $oXml->sDataFim    = (string) trim($this->oXml->Filtros->DataFim);
    $oXml->aCnpj       = (array) $this->oXml->Filtros->GrupoCnpj;
    $oXml->aCnpj       = $oXml->aCnpj["Cnpj"];

    return $oXml;
  }

  /**
   * Processa object para xml
   * @param  object $oEntity
   * @return string
   */
  public function processaXmlSaidaWebservice($aNotas){

    $oXml                  = new DOMDocument("1.0", "UTF-8");
    $oXmlPrestacaoDeContas = $oXml->createElement("PrestacaoContas");
    $oXmlPrestacaoDeContas->setAttribute("xmlns:ii", "urn:DBSeller");

    /* Trata quando não há informaçoes de retorno na consulta */
    if(empty($aNotas)){

      $oXmlMenssagem = $oXml->createElement("erro_mensagem", "Nenhum registro encontrado para o(s) filtro(s) selecionado(s)");
      $oXmlPrestacaoDeContas->appendChild($oXmlMenssagem);
    }

    /**
     * Montamos o xml de resposta com os dados retornados da consulta
     */
    foreach($aNotas as $aNota) {

      $oXmlNota = $oXml->createElement("Nota");

      $oXmlUF                    = $oXml->createElement("UF",                    $aNota['uf']);
      $oXmlCnpjTomador           = $oXml->createElement("CnpjTomador",           $aNota['tomador_cnpj']);
      $oXmlTipoPrestador         = $oXml->createElement("TipoPrestador",         $aNota['tipo_pessoa']);
      $oXmlCnpjPrestador         = $oXml->createElement("CnpjPrestador",         $aNota['prestador_cnpj']);
      $oXmlNaturezaOperacao      = $oXml->createElement("NaturezaOperacao",      $aNota['natureza_operacao']);
      $oXmlDataEmissao           = $oXml->createElement("DataEmissao",           $aNota['data_nota']);
      $oXmlNumeroNota            = $oXml->createElement("NumeroNota",            $aNota['numero_nota']);
      $oXmlNumeroNotaSubstituida = $oXml->createElement("NumeroNotaSubstituida", $aNota['numero_nota_substituida']);
      $oXmlValor                 = $oXml->createElement("Valor",                 $aNota['valor_nota']);

      $oXmlNota->appendChild($oXmlUF);
      $oXmlNota->appendChild($oXmlCnpjTomador);
      $oXmlNota->appendChild($oXmlTipoPrestador);
      $oXmlNota->appendChild($oXmlCnpjPrestador);
      $oXmlNota->appendChild($oXmlNaturezaOperacao);
      $oXmlNota->appendChild($oXmlDataEmissao);
      $oXmlNota->appendChild($oXmlNumeroNota);
      $oXmlNota->appendChild($oXmlNumeroNotaSubstituida);
      $oXmlNota->appendChild($oXmlValor);

      $oXmlPrestacaoDeContas->appendChild($oXmlNota);
    }

    $oXml->appendChild($oXmlPrestacaoDeContas);

    return $oXml->saveXML();
  }
}
