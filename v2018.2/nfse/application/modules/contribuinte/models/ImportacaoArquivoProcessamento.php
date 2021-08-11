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


use Doctrine\ORM\EntityNotFoundException;
/**
 * Classe para manipulação da importação de arquivos no sistema
 *
 * @package Contribuinte/Model
 */

/**
 * @package Contribuinte/Model
 */
class Contribuinte_Model_ImportacaoArquivoProcessamento {

  /**
   * Objeto com as informações do retorno da importação
   *
   * @var stdClass
   */
  private $oRetornoImportacao;

  /**
   * Instância stdClass de importação de RPS
   *
   * @var stdClass
   */
  private $oImportacao;

  /**
   * Dados da prefeitura
   * @var Administrativo_Model_ParametroPrefeitura
   */
  private $oDadosPrefeitura;

  /**
   * Código do Usuario que está processando o arquivo
   * @var Integer
   */
  private $iUsuarioLogado;

  /**
   * Define o objeto de importação de RPS
   *
   * @param stdClass $oArquivoRps
   */
  public function setArquivoCarregado(stdClass $oImportacao) {
    $this->oImportacao = $oImportacao;
  }

  /**
   * Define o Usuario Logado que está processando o arquivo
   * @param Integer $iUsuarioLogado
   */
  public function setCodigoUsuarioLogado($iUsuarioLogado) {
    $this->iUsuarioLogado = $iUsuarioLogado;
  }

  /**
   * Retorno do processamento Realizado
   * @return stdClass
   */
  public function getMensagemRetorno () {
    return $this->oRetornoImportacao->aMensagem;
  }

  /**
   * Valida e salva as informações do RPS na base de dados
   *
   * @throws Exception
   * @return integer|NULL
   */
  public function processarImportacaoRps() {

    // Dados da sessão
    $oSessao = new Zend_Session_Namespace('nfse');

    $oDoctrine = Zend_Registry::get('em');
    $oDoctrine->getConnection()->beginTransaction();

    try {

      // Dados da importação
      $oImportacao = new \Contribuinte\ImportacaoArquivo();
      $oImportacao->setData(new DateTime());
      $oImportacao->setHora(new DateTime());
      $oImportacao->setTipo('RPS');
      $oImportacao->setQuantidadeDocumentos($this->oImportacao->lote->quantidade_rps);
      $oImportacao->setVersaoLayout('modelo1');
      $oImportacao->setIdUsuario($this->iUsuarioLogado);
      $oImportacao->setNumeroLote($this->oImportacao->lote->numero);

      // Totalizadores
      $fValorTotalServico  = 0;
      $fValorTotalImpostos = 0;

      // Processa a lista de rps
      foreach ($this->oImportacao->rps as $oRps) {

        if ($oRps->servico->valores->valor_iss_retido > 0) {

          $oRps->servico->valores->valor_iss  = $oRps->servico->valores->valor_iss_retido;
          $oRps->servico->valores->iss_retido = 1;
        }

        $oContribuinte = Contribuinte_Model_Contribuinte::getContribuinteByCnpjCpf($oRps->prestador->cnpj);
        $iInscricaoMunicipal = $oContribuinte->getIm();

	    // Valida se a inscrição municipal informada no xml é do cnpj
        if ($oRps->prestador->inscricao_municipal != $iInscricaoMunicipal) {
          throw new Exception('A inscrição municipal informada está incorreta.');
        }

        // Dados dos Usuários
        $aDados['id_contribuinte'] = $oSessao->contribuinte->getIdUsuarioContribuinte();
        $aDados['id_usuario'] = $this->iUsuarioLogado;

        // Dados da RPS
        $aDados['grupo_nota']        = Contribuinte_Model_Nota::GRUPO_NOTA_RPS;
        $aDados['tipo_nota']         = $oRps->tipo;
        $aDados['n_rps']             = $oRps->numero;
        $aDados['data_rps']          = $oRps->data_emissao;
        $aDados['dt_nota']           = $oRps->data_emissao;
        $aDados['hr_nota']           = $oRps->data_emissao;
        $aDados['ano_comp']          = $oRps->data_emissao->format('Y');
        $aDados['mes_comp']          = $oRps->data_emissao->format('m');
        $aDados['natureza_operacao'] = $oRps->natureza_operacao;

        // Apartir da versão 01.08.00 foi adicionado um campo na nota para saber quando a RPS é importada (webservice)
        $aDados['webservice'] = TRUE;

        // Dados do Prestador
        $aDados['p_im'] = $iInscricaoMunicipal;
        $aDados['p_cnpjcpf'] = $oRps->prestador->cnpj;

        // Apartir da versão 01.08.00 foi adicionado um campo na nota para saber qual a categoria do optante pelo simples nacional
        $sDataEmissao = $oRps->data_emissao->format('Y-m-d');
        $aDados['p_categoria_simples_nacional'] = Contribuinte_Model_Contribuinte::getInformacaoContribuinteAtual($oSessao->contribuinte,
                                                                                                                  'optante_simples_categoria',
                                                                                                                  $sDataEmissao);

        // Dados do Tomador
        $aDados['t_cnpjcpf']         = $oRps->tomador->cpf_cnpj;

        // Ontem a Inscricao Municipal do tomador
        $aDados['t_im']              = $oRps->tomador->im;

        $aDados['t_razao_social']    = $oRps->tomador->razao_social;
        $aDados['t_cep']             = $oRps->tomador->endereco->cep;
        $aDados['t_endereco']        = $oRps->tomador->endereco->descricao;
        $aDados['t_endereco_numero'] = $oRps->tomador->endereco->numero;
        $aDados['t_endereco_comp']   = $oRps->tomador->endereco->complemento;
        $aDados['t_bairro']          = $oRps->tomador->endereco->bairro;
        $aDados['t_cod_municipio']   = (!empty($oRps->tomador->endereco->ibge_municipio)) ? $oRps->tomador->endereco->ibge_municipio : null;
        $aDados['t_uf']              = $oRps->tomador->endereco->uf;
        $aDados['t_telefone']        = $oRps->tomador->contato->telefone;
        $aDados['t_email']           = $oRps->tomador->contato->email;
        $aDados['s_art']             = $oRps->construcao_civil->art;

        // Regra de negocio referente ao tomador cooperado/associado
        $aDados['t_cooperado']       = false;

        // Dados da construção civil
        $aDados['s_codigo_obra']                = $oRps->construcao_civil->codigo_obra;

        $aDados['s_dados_item_lista_servico']   = $oRps->servico->atividade;
        $aDados['s_dados_cod_tributacao']       = $oRps->servico->codigo_cnae;
        $aDados['descricao']                    = $oRps->servico->discriminacao;
        $aDados['s_dados_cod_municipio']        = $oRps->servico->ibge_municipio;
        $aDados['s_dados_municipio_incidencia'] = $oRps->servico->ibge_municipio;
        $aDados['s_dados_cod_pais']             = 1058; //brasil

        // Verifica se o tomador retem o ISS
        $aDados['s_dados_iss_retido'] = ($oRps->servico->valores->iss_retido == 1) ? TRUE : FALSE;
        $fAliquota = $oRps->servico->valores->aliquota;

        // Valores do Serviço
        $aDados['s_vl_servicos']            = self::converterValor($oRps->servico->valores->valor_servicos);
        $aDados['s_vl_deducoes']            = self::converterValor($oRps->servico->valores->valor_deducoes);
        $aDados['s_vl_pis']                 = self::converterValor($oRps->servico->valores->valor_pis);
        $aDados['s_vl_cofins']              = self::converterValor($oRps->servico->valores->valor_cofins);
        $aDados['s_vl_inss']                = self::converterValor($oRps->servico->valores->valor_inss);
        $aDados['s_vl_ir']                  = self::converterValor($oRps->servico->valores->valor_ir);
        $aDados['s_vl_csll']                = self::converterValor($oRps->servico->valores->valor_csll);
        $aDados['s_vl_iss']                 = self::converterValor($oRps->servico->valores->valor_iss);
        $aDados['s_vl_outras_retencoes']    = self::converterValor($oRps->servico->valores->outras_retencoes);
        $aDados['s_vl_bc']                  = self::converterValor($oRps->servico->valores->base_calculo);
        $aDados['s_vl_aliquota']            = self::converterValor(($fAliquota < 1 && $fAliquota > 0) ? ($fAliquota * 100) : $fAliquota);
        $aDados['s_vl_liquido']             = self::converterValor($oRps->servico->valores->valor_liquido);
        $aDados['vl_liquido_nfse']          = self::converterValor($oRps->servico->valores->valor_liquido);
        $aDados['s_vl_condicionado']        = self::converterValor($oRps->servico->valores->desconto_condicionado);
        $aDados['s_vl_desc_incondicionado'] = self::converterValor($oRps->servico->valores->desconto_incondicionado);

        // Verificar se a aliquota foi informada com valor zerado
        if (empty($aDados['s_vl_aliquota'])) {
          throw new Exception('Aliquota com valor 0,00, favor verificar com a prefeitura informando o serviço prestado!');
        }

        // Salva o RPS

        $oNotaRps = new Contribuinte_Model_Nota();
        $oNotaRps->setIrregularidadeInterface(new Contribuinte_Model_NotaIrregularidadeWebservice);
        $oNotaRps->persist($aDados);

        // Adiciona os documento aos dados da importação
        $oImportacaoArquivoDocumento = new \Contribuinte\ImportacaoArquivoDocumento();
        $oImportacaoArquivoDocumento->setImportacaoDms($oImportacao);
        $oImportacaoArquivoDocumento->addNota($oNotaRps->getEntity());
        $oImportacaoArquivoDocumento->setValorImposto($oRps->servico->valores->valor_iss);
        $oImportacaoArquivoDocumento->setValorTotal($oRps->servico->valores->valor_servicos);

        // Vincula o documento aos dados da importação
        $oImportacao->addImportacaoArquivoDocumentos($oImportacaoArquivoDocumento);

        // Incrementa os totalizadores
        $fValorTotalServico  += $oRps->servico->valores->valor_servicos;
        $fValorTotalImpostos += $oRps->servico->valores->valor_iss;
      }

      // Completa e salva os dados da importação
      $oImportacao->setValorTotal($fValorTotalServico);
      $oImportacao->setValorImposto($fValorTotalImpostos);

      $oDoctrine->persist($oImportacao);
      $oDoctrine->flush();

      $oDoctrine->getConnection()->commit();

      return $oImportacao;
    } catch (Exception $oErro) {

      $oDoctrine->getConnection()->rollback();
      throw new Exception('Ocorreu um erro ao importar o arquivo: ' . $oErro->getMessage());
    }

  }

  /**
   * Converte o valor para o formato: 999.999.999,99
   *
   * @param string $sValor
   * @return string
   */
  private function converterValor($sValor) {
    return DBSeller_Helper_Number_Format::toMoney($sValor);
  }
}
