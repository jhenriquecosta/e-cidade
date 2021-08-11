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
 * Classe responsável pela manipulação dos parâmetros da prefeitura
 *
 * @author dbeverton.heckler
 */
class Administrativo_Model_ParametroPrefeitura extends Administrativo_Lib_Model_Doctrine {

  /**
   * Nome da entidade doctrine
   *
   * @var string
   */
  static protected $entityName = 'Administrativo\ParametroPrefeitura';

  /**
   * Nome da classe
   *
   * @var string
   */
  static protected $className = __CLASS__;

  /**
   * Construtor da classe
   *
   * @param string $entity
   */
  public function __construct($entity = NULL) {
    parent::__construct($entity);
  }

  /**
   * Grava os parâmetros da prefeitura na base de dados
   *
   * @param array $aDados
   */
  public function persist(array $aDados) {

    $oEntity = $this->getEm();

    if (isset($aDados['ibge'])) {
      $this->setIbge($aDados['ibge']);
    }

    if (isset($aDados['nome'])) {
      $this->setNome($aDados['nome']);
    }

    if (isset($aDados['controle_aidof'])) {
      $this->setControleAidof($aDados['controle_aidof']);
    }

    if (isset($aDados['avisofim_emissao_nota'])) {
      $this->setQuantidadeAvisoFimEmissao($aDados['avisofim_emissao_nota']);
    }

    if (isset($aDados['verifica_autocadastro'])) {
      $this->setVerificaAutocadastro($aDados['verifica_autocadastro']);
    }

    if (isset($aDados['nota_retroativa'])) {
      $this->setNotaRetroativa($aDados['nota_retroativa']);
    }

    if (isset($aDados['cnpj'])) {
      $this->setCnpj($aDados['cnpj']);
    }

    if (isset($aDados['nome_relatorio'])) {
      $this->setNomeRelatorio($aDados['nome_relatorio']);
    }

    if (isset($aDados['endereco'])) {
      $this->setEndereco($aDados['endereco']);
    }

    if (isset($aDados['numero'])) {
      $this->setNumero($aDados['numero']);
    }

    if (isset($aDados['complemento'])) {
      $this->setComplemento($aDados['complemento']);
    }

    if (isset($aDados['bairro'])) {
      $this->setBairro($aDados['bairro']);
    }

    if (isset($aDados['municipio'])) {
      $this->setMunicipio($aDados['municipio']);
    }

    if (isset($aDados['uf'])) {
      $this->setUf($aDados['uf']);
    }

    if (isset($aDados['cep'])) {
      $this->setCep($aDados['cep']);
    }

    if (isset($aDados['telefone'])) {
      $this->setTelefone($aDados['telefone']);
    }

    if (isset($aDados['fax'])) {
      $this->setFax($aDados['fax']);
    }

    if (isset($aDados['email'])) {
      $this->setEmail($aDados['email']);
    }

    if (isset($aDados['url'])) {
      $this->setUrl($aDados['url']);
    }

    if (isset($aDados['modelo_impressao_nfse'])) {
      $this->setModeloImpressaoNfse($aDados['modelo_impressao_nfse']);
    }

    if (isset($aDados['informacoes_complementares_nfse'])) {
      $this->setInformacoesComplementaresNfse($aDados['informacoes_complementares_nfse']);
    }

    if (isset($aDados['modelo_importacao_rps'])) {
      $this->setModeloImportacaoRps($aDados['modelo_importacao_rps']);
    }

    if (isset($aDados['setor'])) {
      $this->setSetor($aDados['setor']);
    }

    if (isset($aDados['secretaria'])) {
      $this->setSecretaria($aDados['secretaria']);
    }

    if (isset($aDados['valor_iss_fixo'])) {
      $this->setValorIssFixo(DBSeller_Helper_Number_Format::toFloat($aDados['valor_iss_fixo']));
    }

    if (isset($aDados['solicita_cancelamento'])) {
      $this->setSolicitaCancelamento($aDados['solicita_cancelamento']);
    }

    if (isset($aDados['reter_pessoa_fisica'])) {
      $this->setReterPessoaFisica($aDados['reter_pessoa_fisica']);
    }

    if (isset($aDados['requisicao_nfse'])) {
      $this->setRequisicaoNfse($aDados['requisicao_nfse']);
    }

    if (isset($aDados['tempo_bloqueio'])) {
      $this->setTempoBloqueio($aDados['tempo_bloqueio']);
    }

    // Registra na base de dados
    $oEntity->persist($this->entity);

    // Confirma a gravação na base de dados
    $oEntity->flush();
  }
}