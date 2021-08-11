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
 * Classe responsável pela validação e interpretação do xml na consulta de notas inrregulares
 * @author Lucas Dumer <lucas.dumer@dbseller.com.br>
 */
class WebService_Model_ImportacaoArquivoNotasIrregularidades extends WebService_Lib_Models_ModeloImportacao implements WebService_Lib_Interfaces_ModeloImportacao {

  /**
   * Xml Document de retorno do processamento
   * @var DOMDocument
   */
  private $oXmlSaida = NULL;

  /**
   * Processa xml para object
   * @return object
   */
  public function processaXmlEntradaWebservice() {

    $oXml = new StdClass;
    $oXml->inscricaoMunicipal  = (integer) $this->oXml->Filtros->InscricaoMunicipal;

    $oXml->dataEmissao = new StdClass;
    $oXml->dataEmissao->inicio = (string)  $this->oXml->Filtros->DataEmissao->Inicio;
    $oXml->dataEmissao->fim    = (string)  $this->oXml->Filtros->DataEmissao->Fim;

    return $oXml;
  }

  /**
   * Processa object para xml
   * @param  array  $aNotasIrregularidadesContribuintes
   * @return string
   */
  public function processaXmlSaidaWebservice($aNotasIrregularidadesContribuintes){


    $oXmlNotasIrregularidades = $this->criaXmlIrregularidades();

    /* Trata quando não há informaçoes de retorno na consulta */
    if (empty($aNotasIrregularidadesContribuintes)) {

      $oXmlMenssagem = $this->oXmlSaida->createElement("erro_menssagem", "Nenhum registro encontrado para o(s) filtro(s) selecionado(s)");
      $oXmlNotasIrregularidades->appendChild($oXmlMenssagem);

      $this->oXmlSaida->appendChild($oXmlNotasIrregularidades);

      return $this->oXmlSaida->saveXML();
    }

    /* Processa e monta o XML de retorno para o relatorio */

    $iIdNota    = NULL;
    $iIdContribuinte = NULL;

    foreach ($aNotasIrregularidadesContribuintes as $i => $aNotaIrregularidade) {

      if (empty($iIdContribuinte) || $iIdContribuinte != $aNotaIrregularidade['id_contribuinte']) {

        $iIdContribuinte                    = $aNotaIrregularidade['id_contribuinte'];
        $oXmlContribuinte                   = $this->adicionaContribuinte($aNotaIrregularidade);
        $oXmlNotasIrregularidades->appendChild($oXmlContribuinte);
        $oXmlNotas                          = $this->oXmlSaida->createElement("Notas");
        $oXmlContribuinte->appendChild($oXmlNotas);

      }

      if (empty($iIdNota) || $iIdNota != $aNotaIrregularidade['id']) {

        $iIdNota                            = $aNotaIrregularidade['id'];
        $oXmlNota                           = $this->adicionaNota($aNotaIrregularidade);
        $oXmlNotas->appendChild($oXmlNota);
        $oXmlIrregularidades                = $this->oXmlSaida->createElement("Irregularidades");
        $oXmlNota->appendChild($oXmlIrregularidades);

      }

      $oXmlIrregularidade = $this->adicionaIrregularidade($aNotaIrregularidade);

      $oXmlIrregularidades->appendChild($oXmlIrregularidade);

    }

    return $this->oXmlSaida->saveXML();
  }

  /**
   * Inicia a montagem do XML com DOMDocument
   * @return DOMNode
   */
  private function criaXmlIrregularidades() {

    $this->oXmlSaida = new DOMDocument("1.0", "UTF-8");
    $oXmlNotasIrregularidades = $this->oXmlSaida->createElement("NotasIrregularidades");
    $oXmlNotasIrregularidades->setAttribute("xmlns:ii", "urn:DBSeller");
    $this->oXmlSaida->appendChild($oXmlNotasIrregularidades);

    return $oXmlNotasIrregularidades;
  }

  /**
   * Cria o nodo de contribuinte
   * @param  array $aNotaIrregularidade array de informacoes da consulta
   * @return DOMNode
   */
  private function adicionaContribuinte($aNotaIrregularidade) {

    $oXmlContribuinte = $this->oXmlSaida->createElement("Contribuinte");

    $oXmlNome               = $this->oXmlSaida->createElement("Nome",               $aNotaIrregularidade['nome']);
    $oXmlCnpj               = $this->oXmlSaida->createElement("Cnpj",               $aNotaIrregularidade['cnpj_cpf']);
    $oXmlInscricaoMunicipal = $this->oXmlSaida->createElement("InscricaoMunicipal", $aNotaIrregularidade['im']);

    $oXmlContribuinte->appendChild($oXmlNome);
    $oXmlContribuinte->appendChild($oXmlCnpj);
    $oXmlContribuinte->appendChild($oXmlInscricaoMunicipal);

    return $oXmlContribuinte;
  }

  /**
   * Cria nodo de notas do contribuinte
   * @param  array $aNotaIrregularidade array de informacoes da consulta
   * @return DOMNode
   */
  private function adicionaNota($aNotaIrregularidade) {

    $oXmlNota = $this->oXmlSaida->createElement("Nota");

    $oXmlNumero          = $this->oXmlSaida->createElement("Numero",      $aNotaIrregularidade['nota']);
    $oXmlDataEmissao     = $this->oXmlSaida->createElement("DataEmissao", $aNotaIrregularidade['dt_nota']->format("Y-m-d"));
    $sSituacao = Contribuinte_Model_Nota::getNotaSituacao(NULL, $aNotaIrregularidade['id']);
    $oXmlSituacao        = $this->oXmlSaida->createElement("Situacao", $sSituacao);

    $oXmlNota->appendChild($oXmlNumero);
    $oXmlNota->appendChild($oXmlDataEmissao);
    $oXmlNota->appendChild($oXmlSituacao);

    return $oXmlNota;
  }

  /**
   * Cria nodo da irregularidade da nota
   * @param  array $aNotaIrregularidade array de informacoes da consulta
   * @return DOMNode
   */
  private function adicionaIrregularidade($aNotaIrregularidade) {

    $oXmlIrregularidade = $this->oXmlSaida->createElement("Irregularidade", $aNotaIrregularidade['descricao']);

    return $oXmlIrregularidade;
  }
}