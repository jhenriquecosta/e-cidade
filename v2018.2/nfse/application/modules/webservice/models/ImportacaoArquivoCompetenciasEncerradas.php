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
 * Classe responsável pela validação e interpretação do xml na consulta de comparativo de retenções
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
class WebService_Model_ImportacaoArquivoCompetenciasEncerradas extends WebService_Lib_Models_ModeloImportacao implements WebService_Lib_Interfaces_ModeloImportacao {

  /**
   * Processa xml para object
   * @return object
   */
  public function processaXmlEntradaWebservice(){

    $oXml = new stdClass;
    $oXml->sCompetenciaMes = (string) trim($this->oXml->Filtros->Competencia->Mes);
    $oXml->sCompetenciaAno = (string) trim($this->oXml->Filtros->Competencia->Ano);
    $oXml->iSituacao       = (string) trim($this->oXml->Filtros->Situacao);

    return $oXml;
  }

  /**
   * Processa object para xml
   * @param  object $oEntity
   * @return string
   */
  public function processaXmlSaidaWebservice($aCompetenciasEncerradas){

    $oXml                       = new DOMDocument("1.0", "UTF-8");
    $oXmlCompetenciasEncerradas = $oXml->createElement("CompetenciasEncerradas");
    $oXmlCompetenciasEncerradas->setAttribute("xmlns:ii", "urn:DBSeller");

    /* Trata quando não há informaçoes de retorno na consulta */
    if(empty($aCompetenciasEncerradas)){

      $oXmlMenssagem = $oXml->createElement("erro_menssagem", "Nenhum registro encontrado para o(s) filtro(s) selecionado(s)");
      $oXmlCompetenciasEncerradas->appendChild($oXmlMenssagem);
    }

    /**
     * Monstamos o xml de resposta com os dados retornados da consulta
     */
    foreach($aCompetenciasEncerradas as $aCompetencias) {

      $oXmlCompetencia = $oXml->createElement("Competencia");

      $oXmlInscricaoMunicipal = $oXml->createElement("InscricaoMunicipal", $aCompetencias['inscricao_municipal']);
      $oXmlCnpj               = $oXml->createElement("Cnpj", $aCompetencias['cnpj_cpf']);
      $oXmlSituacao           = $oXml->createElement("Situacao", $aCompetencias['situacao']);
      $oXmlValor              = $oXml->createElement("Valor", $aCompetencias['valor']);
      $oXmlMes                = $oXml->createElement("Mes", $aCompetencias['mes']);
      $oXmlAno                = $oXml->createElement("Ano", $aCompetencias['ano']);

      $oXmlCompetencia->appendChild($oXmlInscricaoMunicipal);
      $oXmlCompetencia->appendChild($oXmlCnpj);
      $oXmlCompetencia->appendChild($oXmlSituacao);
      $oXmlCompetencia->appendChild($oXmlValor);
      $oXmlCompetencia->appendChild($oXmlMes);
      $oXmlCompetencia->appendChild($oXmlAno);

      $oXmlCompetenciasEncerradas->appendChild($oXmlCompetencia);
    }

    $oXml->appendChild($oXmlCompetenciasEncerradas);

    return $oXml->saveXML();
  }
}