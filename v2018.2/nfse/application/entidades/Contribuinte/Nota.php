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


namespace Contribuinte;

/**
 * @Entity
 * @Table(name="notas")
 */
class Nota {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @var int
   * @Column(type="integer")
   */
  protected $nota = NULL;

  /**
   * @Column(type="date")
   */
  protected $dt_nota = NULL;

  /**
   * @Column(type="time")
   */
  protected $hr_nota = NULL;

  /**
   * @Column(type="string")
   */
  protected $cod_verificacao = NULL;

  /**
   * @Column(type="text")
   */
  protected $s_dados_discriminacao = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_servicos = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_deducoes = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_bc = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_iss = NULL;

  /**
   * Tipo de nota (equivalente ao "notasiss" do eCidade)
   *
   * @Column(type="integer")
   */
  protected $tipo_nota = NULL;

  /**
   * Grupo de nota (equivalente ao "gruponotaiss" do eCidade)
   *
   * @Column(type="integer")
   */
  protected $grupo_nota = NULL;

  /**
   * @Column(type="integer")
   */
  protected $ano_comp = NULL;

  /**
   * @Column(type="integer")
   */
  protected $mes_comp = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_pis = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_cofins = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_inss = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_ir = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_csll = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_cnpjcpf = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_im = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_ie = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_razao_social = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_nome_fantasia = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_endereco = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_endereco_numero = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_endereco_comp = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_bairro = NULL;

  /**
   * @Column(type="integer")
   */
  protected $p_cod_municipio = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_uf = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_cod_pais = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_cep = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_telefone = NULL;

  /**
   * @Column(type="string")
   */
  protected $p_email = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_cnpjcpf = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_im = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_ie = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_razao_social = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_nome_fantasia = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_endereco = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_endereco_numero = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_endereco_comp = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_bairro = NULL;

  /**
   * @Column(type="integer")
   */
  protected $t_cod_municipio = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_uf = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_cod_pais = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_cep = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_telefone = NULL;

  /**
   * @Column(type="string")
   */
  protected $t_email = NULL;

  /**
   * @Column(type="float")
   */
  protected $vl_liquido_nfse = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_outras_retencoes = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_aliquota = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_desc_incondicionado = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_condicionado = NULL;

  /**
   * @Column(type="integer")
   */
  protected $s_dados_iss_retido = NULL;

  /**
   * @Column(type="integer")
   */
  protected $s_dados_resp_retencao = NULL;

  /**
   * @Column(type="string")
   */
  protected $s_dados_item_lista_servico = NULL;

  /**
   * @Column(type="string")
   */
  protected $s_dados_cod_cnae = NULL;

  /**
   * @Column(type="string")
   */
  protected $s_dados_cod_tributacao = NULL;

  /**
   * @Column(type="integer")
   */
  protected $s_dados_cod_municipio = NULL;

  /**
   * @Column(type="string")
   */
  protected $s_dados_cod_pais = NULL;

  /**
   * @Column(type="integer")
   */
  protected $s_dados_exigibilidadeiss = NULL;

  /**
   * @Column(type="integer")
   */
  protected $s_dados_municipio_incidencia = NULL;

  /**
   * @Column(type="string")
   */
  protected $s_dados_num_processo = NULL;

  /**
   * @Column(type="string")
   */
  protected $s_dec_cc_cod_obra = NULL;

  /**
   * @Column(type="string")
   */
  protected $s_dec_cc_art = NULL;

  /**
   * @Column(type="integer")
   */
  protected $s_dec_reg_esp_tributacao = NULL;

  /**
   * @Column(type="integer")
   */
  protected $s_dec_incentivo_fiscal = NULL;

  /**
   * @Column(type="integer")
   */
  protected $s_dec_simples_nacional = NULL;

  /**
   * @Column(type="integer")
   */
  protected $vl_credito = NULL;

  /**
   * @Column(type="text")
   */
  protected $outras_informacoes = NULL;

  /**
   * @Column(type="date")
   */
  protected $data_rps = NULL;

  /**
   * @Column(type="integer")
   */
  protected $n_rps = NULL;

  /**
   * @ManyToMany(targetEntity="Guia", mappedBy="notas")
   * @var \Contribuinte_Model_Guia
   */
  protected $guia = NULL;

  /**
   * Código Obra
   * @Column(type="string")
   */
  protected $s_codigo_obra = NULL;

  /**
   * Anotação de Responsabilide Técnica
   * @Column(type="string")
   */
  protected $s_art = NULL;

  /**
   * Informações Complementares
   * @Column(type="string")
   */
  protected $s_informacoes_complementares = NULL;

  /**
   * Código Natureza da Operação (Dentro / Fora Prefeitura)
   * @Column(type="integer")
   */
  protected $natureza_operacao = NULL;

  /**
   * Flag para verificar se deve incluir a nota na guia de pagamento
   *
   * @Column(type="boolean", nullable=false)
   */
  protected $emite_guia = FALSE;

  /**
   * Status para NFSE cancelada
   * @Column(type="boolean")
   */
  protected $cancelada = FALSE;

  /**
   * Justificativa para o cancelamento
   * @Column(type="string")
   */
  protected $cancelamento_justificativa = NULL;

  /**
   * Identificador da nota substituida por esta nota
   *
   * @var integer
   * @Column(type="integer")
   */
  protected $id_nota_substituida = NULL;

  /**
   * Identificador da nota substituta desta nota
   *
   * @var integer
   * @Column(type="integer")
   */
  protected $id_nota_substituta = NULL;

  /**
   * Identificador do contribuinte
   * @Column(type="integer")
   */
  protected $id_contribuinte = NULL;

  /**
   * Identificador do usuário
   * @Column(type="integer")
   */
  protected $id_usuario = NULL;

  /**
   * Identificador se a Nota foi importada de outro sistema
   * @Column(type="boolean")
   */
  protected $importada = FALSE;

  /**
   * Status para serviço não incide tributação
   * @Column(type="boolean")
   */
  protected $s_nao_incide = FALSE;

  /**
   * Identificador se a nota foi emitida pelo webservice.
   * @Column(type="boolean")
   */
  protected $webservice = FALSE;

  /**
   * Identificador da categoria do simples nacional
   * @Column(type="integer")
   */
  protected $p_categoria_simples_nacional = NULL;


  /**
   * Identificador se a nota foi emitida com requisição de aidof para notas.
   * @Column(type="boolean")
   */
  protected $requisicao_aidof = FALSE;

  /**
   * Identifica cidade e estado do tomador quando de fora do Brasil.
   * @Column(type="string")
   */
  protected $t_cidade_estado = NULL;

  /**
   * Identifica cidade e estado de incidencia do servico fora do pais.
   * @Column(type="string")
   */
  protected $s_dados_cidade_estado = NULL;

  /**
   * Identifica se incide tributacao quando servico/tomador for fora do pais.
   * @Column(type="boolean")
   */
  protected $s_dados_fora_incide = FALSE;

  /**
   * Identifica se tomador é um cooperado
   * @Column(type="boolean")
   */
  protected $t_cooperado = FALSE;

  /**
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return int
   */
  public function getNota() {
    return $this->nota;
  }

  /**
   * @param $nota
   */
  public function setNota($nota) {
    $this->nota = $nota;
  }

  /**
   * @return null
   */
  public function getDt_nota() {
    return $this->dt_nota;
  }

  /**
   * @param $dt_nota
   */
  public function setDt_nota($dt_nota) {
    $this->dt_nota = $dt_nota;
  }

  /**
   * @return null
   */
  public function getHr_nota() {
    return $this->hr_nota;
  }

  /**
   * @param $hr_nota
   */
  public function setHr_nota($hr_nota) {
    $this->hr_nota = $hr_nota;
  }

  /**
   * @return null
   */
  public function getCod_verificacao() {
    return $this->cod_verificacao;
  }

  /**
   * @param $cod_verificacao
   */
  public function setCod_verificacao($cod_verificacao) {
    $this->cod_verificacao = $cod_verificacao;
  }

  /**
   * @return null
   */
  public function getS_dados_discriminacao() {
    return $this->s_dados_discriminacao;
  }

  /**
   * @param $s_dados_discriminacao
   */
  public function setS_dados_discriminacao($s_dados_discriminacao) {
    $this->s_dados_discriminacao = $s_dados_discriminacao;
  }

  /**
   * @return null
   */
  public function getS_vl_servicos() {
    return $this->s_vl_servicos;
  }

  /**
   * @param $s_vl_servicos
   */
  public function setS_vl_servicos($s_vl_servicos) {
    $this->s_vl_servicos = $s_vl_servicos;
  }

  /**
   * @return null
   */
  public function getS_vl_deducoes() {
    return $this->s_vl_deducoes;
  }

  /**
   * @param $s_vl_deducoes
   */
  public function setS_vl_deducoes($s_vl_deducoes) {
    $this->s_vl_deducoes = $s_vl_deducoes;
  }

  /**
   * @return null
   */
  public function getS_vl_bc() {
    return $this->s_vl_bc;
  }

  /**
   * @param $s_vl_bc
   */
  public function setS_vl_bc($s_vl_bc) {
    $this->s_vl_bc = $s_vl_bc;
  }

  /**
   * @return null
   */
  public function getS_vl_iss() {
    return $this->s_vl_iss;
  }

  /**
   * @param $s_vl_iss
   */
  public function setS_vl_iss($s_vl_iss) {
    $this->s_vl_iss = $s_vl_iss;
  }

  /**
   * Retorna o tipo de nota (equivalente ao "notasiss" do eCidade)
   *
   * @return integer
   */
  public function getTipo_nota() {
    return $this->tipo_nota;
  }

  /**
   * Define o tipo de nota (equivalente ao "notasiss" do eCidade)
   *
   * @param $iTipoNota
   */
  public function setTipo_nota($iTipoNota) {
    $this->tipo_nota = $iTipoNota;
  }

  /**
   * Retorna o grupo de nota (equivalente ao "grupo_notasiss" do eCidade)
   *
   * @return integer
   */
  public function getGrupo_nota() {
    return $this->grupo_nota;
  }

  /**
   * Define o grupo de nota (equivalente ao "grupo_notasiss" do eCidade)
   *
   * @param integer $iGrupoNota
   */
  public function setGrupo_nota($iGrupoNota) {
    $this->grupo_nota = $iGrupoNota;
  }

  /**
   * @return null
   */
  public function getS_vl_pis() {
    return $this->s_vl_pis;
  }

  /**
   * @param $s_vl_pis
   */
  public function setS_vl_pis($s_vl_pis) {
    $this->s_vl_pis = $s_vl_pis;
  }

  /**
   * @return null
   */
  public function getS_vl_cofins() {
    return $this->s_vl_cofins;
  }

  /**
   * @param $s_vl_cofins
   */
  public function setS_vl_cofins($s_vl_cofins) {
    $this->s_vl_cofins = $s_vl_cofins;
  }

  /**
   * @return null
   */
  public function getS_vl_inss() {
    return $this->s_vl_inss;
  }

  /**
   * @param $s_vl_inss
   */
  public function setS_vl_inss($s_vl_inss) {
    $this->s_vl_inss = $s_vl_inss;
  }

  /**
   * @return null
   */
  public function getS_vl_ir() {
    return $this->s_vl_ir;
  }

  /**
   * @param $s_vl_ir
   */
  public function setS_vl_ir($s_vl_ir) {
    $this->s_vl_ir = $s_vl_ir;
  }

  /**
   * @return null
   */
  public function getS_vl_csll() {
    return $this->s_vl_csll;
  }

  /**
   * @param $s_vl_csll
   */
  public function setS_vl_csll($s_vl_csll) {
    $this->s_vl_csll = $s_vl_csll;
  }

  /**
   * @return null
   */
  public function getP_cnpjcpf() {
    return $this->p_cnpjcpf;
  }

  /**
   * @param $p_cnpjcpf
   */
  public function setP_cnpjcpf($p_cnpjcpf) {
    $this->p_cnpjcpf = $p_cnpjcpf;
  }

  /**
   * @return null
   */
  public function getP_im() {
    return $this->p_im;
  }

  /**
   * @param $p_im
   */
  public function setP_im($p_im) {
    $this->p_im = $p_im;
  }

  /**
   * @return null
   */
  public function getP_ie() {
    return $this->p_ie;
  }

  /**
   * @param $p_ie
   */
  public function setP_ie($p_ie) {
    $this->p_ie = $p_ie;
  }

  /**
   * @return null
   */
  public function getP_razao_social() {
    return $this->p_razao_social;
  }

  /**
   * @param $p_razao_social
   */
  public function setP_razao_social($p_razao_social) {
    $this->p_razao_social = $p_razao_social;
  }

  /**
   * @return null
   */
  public function getP_nome_fantasia() {
    return $this->p_nome_fantasia;
  }

  /**
   * @param $p_nome_fantasia
   */
  public function setP_nome_fantasia($p_nome_fantasia) {
    $this->p_nome_fantasia = $p_nome_fantasia;
  }

  /**
   * @return null
   */
  public function getP_endereco() {
    return $this->p_endereco;
  }

  /**
   * @param $p_endereco
   */
  public function setP_endereco($p_endereco) {
    $this->p_endereco = $p_endereco;
  }

  /**
   * @return null
   */
  public function getP_endereco_numero() {
    return $this->p_endereco_numero;
  }

  /**
   * @param $p_endereco_numero
   */
  public function setP_endereco_numero($p_endereco_numero) {
    $this->p_endereco_numero = $p_endereco_numero;
  }

  /**
   * @return null
   */
  public function getP_endereco_comp() {
    return $this->p_endereco_comp;
  }

  /**
   * @param $p_endereco_comp
   */
  public function setP_endereco_comp($p_endereco_comp) {
    $this->p_endereco_comp = $p_endereco_comp;
  }

  /**
   * @return null
   */
  public function getP_bairro() {
    return $this->p_bairro;
  }

  /**
   * @param $p_bairro
   */
  public function setP_bairro($p_bairro) {
    $this->p_bairro = $p_bairro;
  }

  /**
   * @return null
   */
  public function getP_cod_municipio() {
    return $this->p_cod_municipio;
  }

  /**
   * @param $p_cod_municipio
   */
  public function setP_cod_municipio($p_cod_municipio) {
    $this->p_cod_municipio = $p_cod_municipio;
  }

  /**
   * @return null
   */
  public function getP_uf() {
    return $this->p_uf;
  }

  /**
   * @param $p_uf
   */
  public function setP_uf($p_uf) {
    $this->p_uf = $p_uf;
  }

  /**
   * @return null
   */
  public function getP_cod_pais() {
    return $this->p_cod_pais;
  }

  /**
   * @param $p_cod_pais
   */
  public function setP_cod_pais($p_cod_pais) {
    $this->p_cod_pais = $p_cod_pais;
  }

  /**
   * @return null
   */
  public function getP_cep() {
    return $this->p_cep;
  }

  /**
   * @param $p_cep
   */
  public function setP_cep($p_cep) {
    $this->p_cep = $p_cep;
  }

  /**
   * @return null
   */
  public function getP_telefone() {
    return $this->p_telefone;
  }

  /**
   * @param $p_telefone
   */
  public function setP_telefone($p_telefone) {
    $this->p_telefone = $p_telefone;
  }

  /**
   * @return null
   */
  public function getP_email() {
    return $this->p_email;
  }

  /**
   * @param $p_email
   */
  public function setP_email($p_email) {
    $this->p_email = $p_email;
  }

  /**
   * @return null
   */
  public function getT_cnpjcpf() {
    return $this->t_cnpjcpf;
  }

  /**
   * @param $t_cnpjcpf
   */
  public function setT_cnpjcpf($t_cnpjcpf) {
    $this->t_cnpjcpf = $t_cnpjcpf;
  }

  /**
   * @return null
   */
  public function getT_im() {
    return $this->t_im;
  }

  /**
   * @param $t_im
   */
  public function setT_im($t_im) {
    $this->t_im = $t_im;
  }

  /**
   * @return null
   */
  public function getT_ie() {
    return $this->t_ie;
  }

  /**
   * @param $t_ie
   */
  public function setT_ie($t_ie) {
    $this->t_ie = $t_ie;
  }

  /**
   * @return null
   */
  public function getT_razao_social() {
    return $this->t_razao_social;
  }

  /**
   * @param $t_razao_social
   */
  public function setT_razao_social($t_razao_social) {
    $this->t_razao_social = $t_razao_social;
  }

  /**
   * @return null
   */
  public function getT_endereco() {
    return $this->t_endereco;
  }

  /**
   * @param $t_endereco
   */
  public function setT_endereco($t_endereco) {
    $this->t_endereco = $t_endereco;
  }

  /**
   * @return null
   */
  public function getT_endereco_numero() {
    return $this->t_endereco_numero;
  }

  /**
   * @param $t_endereco_numero
   */
  public function setT_endereco_numero($t_endereco_numero) {
    $this->t_endereco_numero = $t_endereco_numero;
  }

  /**
   * @return null
   */
  public function getT_endereco_comp() {
    return $this->t_endereco_comp;
  }

  /**
   * @param $t_endereco_comp
   */
  public function setT_endereco_comp($t_endereco_comp) {
    $this->t_endereco_comp = $t_endereco_comp;
  }

  /**
   * @return null
   */
  public function getT_bairro() {
    return $this->t_bairro;
  }

  /**
   * @param $t_bairro
   */
  public function setT_bairro($t_bairro) {
    $this->t_bairro = $t_bairro;
  }

  /**
   * @return null
   */
  public function getT_cod_municipio() {
    return $this->t_cod_municipio;
  }

  /**
   * @param $t_cod_municipio
   */
  public function setT_cod_municipio($t_cod_municipio) {
    $this->t_cod_municipio = $t_cod_municipio;
  }

  /**
   * @return null
   */
  public function getT_uf() {
    return $this->t_uf;
  }

  /**
   * @param $t_uf
   */
  public function setT_uf($t_uf) {
    $this->t_uf = $t_uf;
  }

  /**
   * @return null
   */
  public function getT_cod_pais() {
    return $this->t_cod_pais;
  }

  /**
   * @param $t_cod_pais
   */
  public function setT_cod_pais($t_cod_pais) {
    $this->t_cod_pais = $t_cod_pais;
  }

  /**
   * @return null
   */
  public function getT_cep() {
    return $this->t_cep;
  }

  /**
   * @param $t_cep
   */
  public function setT_cep($t_cep) {
    $this->t_cep = $t_cep;
  }

  /**
   * @return null
   */
  public function getT_telefone() {
    return $this->t_telefone;
  }

  /**
   * @param $t_telefone
   */
  public function setT_telefone($t_telefone) {
    $this->t_telefone = $t_telefone;
  }

  /**
   * @return null
   */
  public function getT_email() {
    return $this->t_email;
  }

  /**
   * @param $t_email
   */
  public function setT_email($t_email) {
    $this->t_email = $t_email;
  }

  /**
   * @return null
   */
  public function getVl_liquido_nfse() {
    return $this->vl_liquido_nfse;
  }

  /**
   * @param $vl_liquido_nfse
   */
  public function setVl_liquido_nfse($vl_liquido_nfse) {
    $this->vl_liquido_nfse = $vl_liquido_nfse;
  }

  /**
   * @return null
   */
  public function getS_vl_outras_retencoes() {
    return $this->s_vl_outras_retencoes;
  }

  /**
   * @param $s_vl_outras_retencoes
   */
  public function setS_vl_outras_retencoes($s_vl_outras_retencoes) {
    $this->s_vl_outras_retencoes = $s_vl_outras_retencoes;
  }

  /**
   * @return null
   */
  public function getS_vl_aliquota() {
    return $this->s_vl_aliquota;
  }

  /**
   * @param $s_vl_aliquota
   */
  public function setS_vl_aliquota($s_vl_aliquota) {
    $this->s_vl_aliquota = $s_vl_aliquota;
  }

  /**
   * @return null
   */
  public function getS_vl_desc_incondicionado() {
    return $this->s_vl_desc_incondicionado;
  }

  /**
   * @param $s_vl_desc_incondicionado
   */
  public function setS_vl_desc_incondicionado($s_vl_desc_incondicionado) {
    $this->s_vl_desc_incondicionado = $s_vl_desc_incondicionado;
  }

  /**
   * @return null
   */
  public function getS_vl_condicionado() {
    return $this->s_vl_condicionado;
  }

  /**
   * @param $s_vl_condicionado
   */
  public function setS_vl_condicionado($s_vl_condicionado) {
    $this->s_vl_condicionado = $s_vl_condicionado;
  }

  /**
   * @return null
   */
  public function getS_dados_iss_retido() {
    return $this->s_dados_iss_retido;
  }

  /**
   * @param $s_dados_iss_retido
   */
  public function setS_dados_iss_retido($s_dados_iss_retido) {
    $this->s_dados_iss_retido = $s_dados_iss_retido;
  }

  /**
   * @return null
   */
  public function getS_dados_resp_retencao() {
    return $this->s_dados_resp_retencao;
  }

  /**
   * @param $s_dados_resp_retencao
   */
  public function setS_dados_resp_retencao($s_dados_resp_retencao) {
    $this->s_dados_resp_retencao = $s_dados_resp_retencao;
  }

  /**
   * @return null
   */
  public function getS_dados_item_lista_servico() {
    return $this->s_dados_item_lista_servico;
  }

  /**
   * @param $s_dados_item_lista_servico
   */
  public function setS_dados_item_lista_servico($s_dados_item_lista_servico) {
    $this->s_dados_item_lista_servico = $s_dados_item_lista_servico;
  }

  /**
   * @return null
   */
  public function getS_dados_cod_cnae() {
    return $this->s_dados_cod_cnae;
  }

  /**
   * @param $s_dados_cod_cnae
   */
  public function setS_dados_cod_cnae($s_dados_cod_cnae) {
    $this->s_dados_cod_cnae = $s_dados_cod_cnae;
  }

  /**
   * @return null
   */
  public function getS_dados_cod_tributacao() {
    return $this->s_dados_cod_tributacao;
  }

  /**
   * @param $s_dados_cod_tributacao
   */
  public function setS_dados_cod_tributacao($s_dados_cod_tributacao) {
    $this->s_dados_cod_tributacao = $s_dados_cod_tributacao;
  }

  /**
   * @return null
   */
  public function getS_dados_cod_municipio() {
    return $this->s_dados_cod_municipio;
  }

  /**
   * @param $s_dados_cod_municipio
   */
  public function setS_dados_cod_municipio($s_dados_cod_municipio) {
    $this->s_dados_cod_municipio = $s_dados_cod_municipio;
  }

  /**
   * @return null
   */
  public function getS_dados_cod_pais() {
    return $this->s_dados_cod_pais;
  }

  /**
   * @param $s_dados_cod_pais
   */
  public function setS_dados_cod_pais($s_dados_cod_pais) {
    $this->s_dados_cod_pais = $s_dados_cod_pais;
  }

  /**
   * @return null
   */
  public function getS_dados_exigibilidadeiss() {
    return $this->s_dados_exigibilidadeiss;
  }

  /**
   * @param $s_dados_exigibilidadeiss
   */
  public function setS_dados_exigibilidadeiss($s_dados_exigibilidadeiss) {
    $this->s_dados_exigibilidadeiss = $s_dados_exigibilidadeiss;
  }

  /**
   * @return null
   */
  public function getS_dados_municipio_incidencia() {
    return $this->s_dados_municipio_incidencia;
  }

  /**
   * @param $s_dados_municipio_incidencia
   */
  public function setS_dados_municipio_incidencia($s_dados_municipio_incidencia) {
    $this->s_dados_municipio_incidencia = $s_dados_municipio_incidencia;
  }

  /**
   * @return null
   */
  public function getS_dados_num_processo() {
    return $this->s_dados_num_processo;
  }

  /**
   * @param $s_dados_num_processo
   */
  public function setS_dados_num_processo($s_dados_num_processo) {
    $this->s_dados_num_processo = $s_dados_num_processo;
  }

  /**
   * @return null
   */
  public function getS_dec_cc_cod_obra() {
    return $this->s_dec_cc_cod_obra;
  }

  /**
   * @param $s_dec_cc_cod_obra
   */
  public function setS_dec_cc_cod_obra($s_dec_cc_cod_obra) {
    $this->s_dec_cc_cod_obra = $s_dec_cc_cod_obra;
  }

  /**
   * @return null
   */
  public function getS_dec_cc_art() {
    return $this->s_dec_cc_art;
  }

  /**
   * @param $s_dec_cc_art
   */
  public function setS_dec_cc_art($s_dec_cc_art) {
    $this->s_dec_cc_art = $s_dec_cc_art;
  }

  /**
   * @return null
   */
  public function getS_dec_reg_esp_tributacao() {
    return $this->s_dec_reg_esp_tributacao;
  }

  /**
   * @param $s_dec_reg_esp_tributacao
   */
  public function setS_dec_reg_esp_tributacao($s_dec_reg_esp_tributacao) {
    $this->s_dec_reg_esp_tributacao = $s_dec_reg_esp_tributacao;
  }

  /**
   * @return null
   */
  public function getS_dec_incentivo_fiscal() {
    return $this->s_dec_incentivo_fiscal;
  }

  /**
   * @param $s_dec_incentivo_fiscal
   */
  public function setS_dec_incentivo_fiscal($s_dec_incentivo_fiscal) {
    $this->s_dec_incentivo_fiscal = $s_dec_incentivo_fiscal;
  }

  /**
   * @return null
   */
  public function getS_dec_simples_nacional() {
    return $this->s_dec_simples_nacional;
  }

  /**
   * @param $s_dec_simples_nacional
   */
  public function setS_dec_simples_nacional($s_dec_simples_nacional) {
    $this->s_dec_simples_nacional = $s_dec_simples_nacional;
  }

  /**
   * @return null
   */
  public function getVl_credito() {
    return $this->vl_credito;
  }

  /**
   * @param $vl_credito
   */
  public function setVl_credito($vl_credito) {
    $this->vl_credito = $vl_credito;
  }

  /**
   * @return null
   */
  public function getOutras_informacoes() {
    return $this->outras_informacoes;
  }

  /**
   * @param $outras_informacoes
   */
  public function setOutras_informacoes($outras_informacoes) {
    $this->outras_informacoes = $outras_informacoes;
  }

  /**
   * @return null
   */
  public function getT_nome_fantasia() {
    return $this->t_nome_fantasia;
  }

  /**
   * @param $t_nome_fantasia
   */
  public function setT_nome_fantasia($t_nome_fantasia) {
    $this->t_nome_fantasia = $t_nome_fantasia;
  }

  /**
   * @return null
   */
  public function getData_rps() {
    return $this->data_rps;
  }

  /**
   * @param $data_rps
   */
  public function setData_rps($data_rps) {
    $this->data_rps = $data_rps;
  }

  /**
   * @return null
   */
  public function getN_rps() {
    return $this->n_rps;
  }

  /**
   * @param $n_rps
   */
  public function setN_rps($n_rps) {
    $this->n_rps = $n_rps;
  }

  /**
   * @return null
   */
  public function getAno_comp() {
    return $this->ano_comp;
  }

  /**
   * @param $ano_comp
   */
  public function setAno_comp($ano_comp) {
    $this->ano_comp = $ano_comp;
  }

  /**
   * @return null
   */
  public function getMes_comp() {
    return $this->mes_comp;
  }

  /**
   * @param $mes_comp
   */
  public function setMes_comp($mes_comp) {
    $this->mes_comp = $mes_comp;
  }

  /**
   * Retorna o código da obra
   *
   * @return string
   */
  public function getS_codigo_obra() {
    return $this->s_codigo_obra;
  }

  /**
   * Define o código da obra
   *
   * @param string $s_codigo_obra
   */
  public function setS_codigo_obra($s_codigo_obra) {
    $this->s_codigo_obra = $s_codigo_obra;
  }

  /**
   * Retorna a ART (Anotação de Responsabilidade Técnica)
   *
   * @return string
   */
  public function getS_art() {
    return $this->s_art;
  }

  /**
   * Define a ART (Anotação de Responsabilidade Técnica)
   *
   * @param string $s_art
   */
  public function setS_art($s_art) {
    $this->s_art = $s_art;
  }

  /**
   * Retorna as informações complementares do documento
   *
   * @return string
   */
  public function getS_informacoes_complementares() {
    return $this->s_informacoes_complementares;
  }

  /**
   * Define as informações complementares do documento
   *
   * @param string $s_informacoes_complementares
   */
  public function setS_informacoes_complementares($s_informacoes_complementares) {
    $this->s_informacoes_complementares = $s_informacoes_complementares;
  }

  /**
   * Retorna a natureza da operação do documento (se dentro ou fora do município)
   *
   * @return integer
   */
  public function getNatureza_operacao() {
    return $this->natureza_operacao;
  }

  /**
   * Define a natureza da operação do documento (se dentro ou fora do município)
   *
   * @param integer $iNaturezaOperacao
   */
  public function setNatureza_operacao($iNaturezaOperacao) {
    $this->natureza_operacao = $iNaturezaOperacao;
  }

  /**
   * Retorna o flag que informa se a nota está incluída na guia de pagamento
   *
   * @return boolean
   */
  public function getEmite_guia() {
    return $this->emite_guia;
  }

  /**
   * Define se a nota deve ser incluída na guia de pagamento
   *
   * @param bool $lEmiteGuia
   */
  public function setEmite_guia($lEmiteGuia) {
    $this->emite_guia = $lEmiteGuia;
  }

  /**
   * Retorna se o documento está cancelado
   *
   * @return boolean
   */
  public function getCancelada() {
    return $this->cancelada;
  }

  /**
   * Define se o documento está cancelado
   * @param boolean $lCancelada
   */
  public function setCancelada($lCancelada) {
    $this->cancelada = $lCancelada;
  }

  /**
   * Retorna a justificativa do cancelamento do documento
   * @return string
   */
  public function getCancelamentoJustificativa() {
    return $this->cancelamento_justificativa;
  }

  /**
   * Define a justificativa do cancelamento do documento
   * @param string $sCancelamentoJustificativa
   */
  public function setCancelamentoJustificativa($sCancelamentoJustificativa) {
    $this->cancelamento_justificativa = $sCancelamentoJustificativa;
  }

  /**
   * Define o identificador da nota substituida por esta nota
   *
   * @param int $id_nota_substituida
   */
  public function setIdNotaSubstituida($id_nota_substituida) {
    $this->id_nota_substituida = $id_nota_substituida;
  }

  /**
   * Retorna o identificador da nota substituida por esta nota
   *
   * @return int
   */
  public function getIdNotaSubstituida() {
    return $this->id_nota_substituida;
  }

  /**
   * Define o identificador da nota substituta desta nota
   *
   * @param integer $id_nota_substituta
   */
  public function setIdNotaSubstituta($id_nota_substituta) {
    $this->id_nota_substituta = $id_nota_substituta;
  }

  /**
   * Retorna o identificador da nota substituta desta nota
   *
   * @return integer
   */
  public function getIdNotaSubstituta() {
    return $this->id_nota_substituta;
  }

  /**
   * Retorna o identificador do contribuinte
   *
   * @return integer
   */
  public function getId_contribuinte() {
    return $this->id_contribuinte;
  }

  /**
   * Define o identificador do contribuinte
   * @param integer $iIdContribuinte
   */
  public function setId_contribuinte($iIdContribuinte) {
    $this->id_contribuinte = $iIdContribuinte;
  }

  /**
   * Retorna o identificador do usuário
   *
   * @return integer
   */
  public function getId_usuario() {
    return $this->id_usuario;
  }

  /**
   * Define o identificador do usuário
   *
   * @param $iIdUsuario
   */
  public function setId_usuario($iIdUsuario) {
    $this->id_usuario = $iIdUsuario;
  }

  /**
   * Retorna se a nota foi importada de outro sistema
   *
   * @return boolean
   */
  public function getImportada() {
    return $this->importada;
  }

  /**
   * Define se a nota foi importada de outro sistema
   *
   * @param boolean $lImportada
   */
  public function setImportada($lImportada) {
    $this->importada = $lImportada;
  }

  /**
   * Retorna se o serviço não incide
   *
   * @return boolean
   */
  public function getS_nao_incide() {
    return $this->s_nao_incide;
  }

  /**
   * Define se o serviço não incide
   * @param boolean $lNaoIncide
   */
  public function setS_nao_incide($lNaoIncide) {
    $this->s_nao_incide = $lNaoIncide;
  }

  /**
   * Retorna a categoria do simples nacional
   * @return integer
   */
  public function getP_categoria_simples_nacional() {
    return $this->p_categoria_simples_nacional;
  }

  /**
   * Define a categoria do simples nacional
   * @param integer $iCategoriaSimplesNacional
   */
  public function setP_categoria_simples_nacional($iCategoriaSimplesNacional) {
    $this->p_categoria_simples_nacional = $iCategoriaSimplesNacional;
  }

  /**
   * Retorna se a nota foi emitida pelo webservice
   * @return boolean
   */
  public function getWebservice() {
    return $this->webservice;
  }

  /**
   * Define se a nota foi emitida pelo webservice
   * @param boolean $bWebservice
   */
  public function setWebservice($bWebservice) {
    $this->webservice = $bWebservice;
  }

  /**
   * Retorna se a nota foi emitida com requisição de aidof para notas.
   * @return boolean
   */
  public function getRequisicao_aidof() {
    return $this->requisicao_aidof;
  }

  /**
   * Define se a nota foi emitida com requisição de aidof para notas.
   * @param boolean $bRequisicaoAidof
   */
  public function setRequisicao_aidof($bRequisicaoAidof = FALSE) {
    $this->requisicao_aidof = $bRequisicaoAidof;
  }

  /**
   * Retorna Identificação cidade e estado do tomador quando de fora do Brasil.
   * @return string
   */
  public function getT_cidade_estado() {
      return $this->t_cidade_estado;
  }

  /**
   * Identifica cidade e estado do tomador quando de fora do Brasil.
   * @param string $t_cidade_estado
   */
  public function setT_cidade_estado($t_cidade_estado = NULL) {
      $this->t_cidade_estado = $t_cidade_estado;
  }

  /**
   * Retorna cidade e estado de incidencia do servico fora do pais.
   * @return string
   */
  public function getS_dados_cidade_estado() {
      return $this->s_dados_cidade_estado;
  }

  /**
   * Identifica cidade e estado de incidencia do servico fora do pais.
   * @param string $s_dados_cidade_estado
   */
  public function setS_dados_cidade_estado($s_dados_cidade_estado = NULL) {
      $this->s_dados_cidade_estado = $s_dados_cidade_estado;
  }

  /**
   * Retorna se incide tributacao quando servico/tomador for fora do pais.
   * @return boolean
   */
  public function getS_dados_fora_incide() {
    return $this->s_dados_fora_incide;
  }

  /**
   * Identifica se incide tributacao quando servico/tomador for fora do pais.
   * @param boolean $s_dados_fora_incide
   */
  public function setS_dados_fora_incide($s_dados_fora_incide = FALSE) {
    $this->s_dados_fora_incide = $s_dados_fora_incide;
  }

  /**
   * Identifica quando tomador é cooperado
   * @param boolean $t_cooperado
   */
  public function setT_cooperado($t_cooperado = FALSE) {
    $this->t_cooperado = $t_cooperado;
  }

  /**
   * Retorna quando tomador é cooperado
   * @return boolean
   */
  public function getT_cooperado(){
    return $this->t_cooperado;
  }
}