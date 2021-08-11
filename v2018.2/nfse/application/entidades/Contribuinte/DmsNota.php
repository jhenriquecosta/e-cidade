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
 * @Table(name="dms_nota")
 */
class DmsNota {
  
  /**
   * @var \Contribuinte\Dms
   * @ManyToOne(targetEntity="Dms", inversedBy="dms_nota")
   * @JoinColumn(name="id_dms", referencedColumnName="id")
   */
  protected $dms = NULL;
  
  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;
  
  /**
   * @Column(type="integer")
   */
  protected $id_dms = NULL;
  
  /**
   * @Column(type="date")
   */
  protected $dt_nota = NULL;
  
  /**
   * @Column(type="time")
   */
  protected $hr_nota = NULL;
  
  /**
   * @Column(type="date")
   */
  protected $s_data = NULL;
  
  /**
   * @Column(type="text")
   */
  protected $s_dados_discriminacao = NULL;
  
  /**
   * @Column(type="integer")
   */
  protected $s_dados_cod_tributacao = NULL;  
  
  /**
   * @Column(type="string")
   */
  protected $s_dados_cod_cnae = NULL;
  
  /**
   * @Column(type="boolean")
   */
  protected $s_dados_iss_retido = FALSE;
  
  /**
   * @Column(type="integer")
   */
  protected $s_dados_cod_municipio = NULL;
  
  /**
   * @Column(type="integer")
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
   * @Column(type="float")
   */
  protected $s_vl_servicos = NULL;

  /**
   * @Column(type="float")
   */
  protected $s_vl_aliquota = NULL;
  
  /**
   * @Column(type="float")
   */
  protected $s_vl_inss = NULL;
  
  /**
   * @Column(type="float")
   */
  protected $s_vl_outras_retencoes = NULL;
  
  /**
   * @Column(type="float")
   */
  protected $s_vl_desc_incondicionado = NULL;
  
  /**
   * @Column(type="float")
   */
  protected $s_vl_condicionado = NULL;
  
  /**
   * @Column (type="integer")
   */
  protected $s_retido = NULL;
     
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
   * @Column(type="integer")
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
  protected $t_nome_fantasia = NULL;
  
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
  protected $t_endereco = NULL;
  
  /**
   * @Column(type="integer")
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
   * @Column (type="float")
   */
  protected $s_vl_base_calculo = NULL;
  
  /**
   * @Column(type="integer")
   */
  protected $nota = NULL;
  
  /**
   * @Column(type="string")
   */
  protected $serie = NULL;
  
  /**
   * @Column(type="integer")
   */
  protected $s_codigo_servico = NULL;  

  /**
   * @Column(type="integer")
   */
  protected $numpre = NULL;
  
  /**
   * @Column(type="integer")
   */
  protected $codigo_nota_planilha = NULL;
  
  /**
   * Mesmo Código definido na nota (ecidade)
   * @Column(type="integer")
   */
  protected $status = NULL;

  /**
   * Mesmo Código do grupo de nota (ecidade)
   * @Column(type="integer")
   */
  protected $grupo_documento = NULL;

  /**
   * Mesmo Código de documento (ecidade)
   * @Column(type="integer")
   */
  protected $tipo_documento = NULL;
  
  /**
   * Descrição documento, utilizado apenas para contribuinte eventual
   * @Column(type="string")
   */
  protected $tipo_documento_descricao = NULL;
  
  /**
   * Situação do documento
   * @Column(type="string")
   */
  protected $situacao_documento = NULL;
  
  /**
   * Emite Guia
   * @Column(type="boolean")
   */
  protected $emite_guia = FALSE;
  
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
   * @Column(type="text")
   */
  protected $s_informacoes_complementares = NULL;
  
  /**
   * Código Natureza da Operação (Dentro / Fora Prefeitura)
   * @Column(type="integer")
   */
  protected $natureza_operacao = NULL;
  
  /**
   * Código do usuário logado no sistema 
   * @Column(type="integer")
   */
  protected $id_usuario = NULL;
  
  /**
   * Código do contribuinte responsável pelo DMS
   * @Column(type="integer")
   */
  protected $id_contribuinte = NULL;
  
  /**
   * @return \Contribuinte\Dms
   */
  public function getDms() {
    return $this->dms;
  }
  
  /**
   * @param \Contribuinte\Dms $oDms
   */
  public function setDms(\Contribuinte\Dms $oDms) {
    $this->dms = $oDms;
  }
  
  public function getCodigoNota() {
    return $this->id;
  }

  public function setCodigoNota($iCodigoNota) {
    $this->id = $iCodigoNota;
  }

  public function getNotaData() {
    return $this->dt_nota;
  }

  public function setNotaData($sNotaData) {
    $this->dt_nota = $sNotaData;
  }

  public function getNotaHora() {
    return $this->hr_nota;
  }
  
  public function setNotaHora($sNotaHora) {
    $this->hr_nota = $sNotaHora;
  }
  
  public function getServicoData() {
    return $this->s_data;
  }
  
  public function setServicoData($sServicoData) {
    $this->s_data = $sServicoData;
  }
  
  public function getDescricaoServico() {
    return $this->s_dados_discriminacao;
  }  

  public function setDescricaoServico($sDescricaoServico) {
    $this->s_dados_discriminacao = $sDescricaoServico;
  }
  
  public function getServicoCodigoTributacao() {
    return $this->s_dados_cod_tributacao;
  }
  
  public function setServicoCodigoTributacao($iServicoCodigoTributacao) {
    $this->s_dados_cod_tributacao = $iServicoCodigoTributacao;
  }

  public function getServicoCodigoCnae() {
    return $this->s_dados_cod_cnae;
  }
  
  public function setServicoCodigoCnae($sServicoCodigoCnae) {
    $this->s_dados_cod_cnae = $sServicoCodigoCnae;
  }
  
  public function getServicoImpostoRetido() {
    return $this->s_dados_iss_retido;
  }

  public function setServicoImpostoRetido($lServicoImpostoRetido) {
    $this->s_dados_iss_retido = $lServicoImpostoRetido;
  }

  public function getServicoLocalPrestacao() {
    return $this->s_dados_cod_municipio;
  }

  public function setServicoLocalPrestacao($sServicoLocalPrestacao) {
    $this->s_dados_cod_municipio = $sServicoLocalPrestacao;
  }

  public function getServicoCodigoPais() {
    return $this->s_dados_cod_pais;
  }
  
  public function setServicoCodigoPais($iServicoCodigoPais) {
    $this->s_dados_cod_pais = $iServicoCodigoPais;
  }
  
  public function getServicoExegibilidadeIss() {
    return $this->s_dados_exigibilidadeiss;
  }
  
  public function setServicoExegibilidadeIss($iServicoExigibilidadeiss) {
    $this->s_dados_exigibilidadeiss = $iServicoExigibilidadeiss;
  }
  
  public function getServicoMunicipioIncidencia() {
    return $this->s_dados_municipio_incidencia;
  }
  
  public function setServicoMunicipioIncidencia($iServicoMunicipioIncidencia) {
    $this->s_dados_municipio_incidencia = $iServicoMunicipioIncidencia;
  }
    
  public function getServicoValorPagar() {
    return $this->s_vl_servicos;
  }

  public function setServicoValorPagar($fServicoValorPagar) {
    $this->s_vl_servicos = $fServicoValorPagar;
  }

  public function getServicoAliquota() {
    return $this->s_vl_aliquota;
  }
  
  public function setServicoAliquota($fServicoAliquota) {
    return $this->s_vl_aliquota = $fServicoAliquota;
  }

  public function setServicoValorAliquota($fServicoValorAliquota) {
    $this->s_vl_aliquota = $fServicoValorAliquota;
  }

  public function getServicoValorImposto() {
    return $this->s_vl_inss;
  }

  public function setServicoValorImposto($fServicoValorImposto) {
    $this->s_vl_inss = $fServicoValorImposto;
  }

  public function getServicoDescontoIncondicionado() {
    return $this->s_vl_desc_incondicionado;
  }

  public function setServicoDescontoIncondicionado($fServicoValorDescontoIncondicionado) {
    $this->s_vl_desc_incondicionado = $fServicoValorDescontoIncondicionado;
  }

  public function getServicoValorCondicionado() {
    return $this->s_vl_condicionado;
  }

  public function setServicoValorCondicionado($fServicoValorCondicionado) {
    $this->s_vl_condicionado = $fServicoValorCondicionado;
  }

  public function getServicoValorDeducao() {
    return $this->s_vl_outras_retencoes;
  }
  
  public function setServicoValorDeducao($fServicoValorDeducao) {
    $this->s_vl_outras_retencoes = $fServicoValorDeducao;
  }
  
  public function getServicoRetido() {
    return $this->s_retido;
  }
  
  public function setServicoRetido($iServicoRetido) {
    $this->s_retido = $iServicoRetido;
  }
  
  public function getPrestadorCpfCnpj() {
    return $this->p_cnpjcpf;
  }

  public function setPrestadorCpfCnpj($iPrestadorCpfCnpj) {
    $this->p_cnpjcpf = $iPrestadorCpfCnpj;
  }

  public function getPrestadorInscricaoMunicipal() {
    return $this->p_im;
  }

  public function setPrestadorInscricaoMunicipal($iPrestadorInscricaoMunicipal) {
    $this->p_im = $iPrestadorInscricaoMunicipal;
  }

  public function getPrestadorInscricaoEstadual() {
    return $this->p_ie;
  }

  public function setPrestadorInscricaoEstadual($iPrestadorInscricaoEstadual) {
    $this->p_ie = $iPrestadorInscricaoEstadual;
  }

  public function getPrestadorRazaoSocial() {
    return $this->p_razao_social;
  }

  public function setPrestadorRazaoSocial($sPrestadorRazaoSocial) {
    $this->p_razao_social = $sPrestadorRazaoSocial;
  }

  public function getPrestadorNomeFantasia() {
    return $this->p_nome_fantasia;
  }

  public function setPrestadorNomeFantasia($sPrestadorNomeFantasia) {
    $this->p_nome_fantasia = $sPrestadorNomeFantasia;
  }

  public function getPrestadorEnderecoRua() {
    return $this->p_endereco;
  }

  public function setPrestadorEnderecoRua($sPrestadorEnderecoRua) {
    $this->p_endereco = $sPrestadorEnderecoRua;
  }

  public function getPrestadorEnderecoNumero() {
    return $this->p_endereco_numero;
  }

  public function setPrestadorEnderecoNumero($sPrestadorEnderecoNumero) {
    $this->p_endereco_numero = $sPrestadorEnderecoNumero;
  }

  public function getPrestadorEnderecoComplemento() {
    return $this->p_endereco_comp;
  }

  public function setPrestadorEnderecoComplemento($sPrestadorEnderecoComplemento) {
    $this->p_endereco_comp = $sPrestadorEnderecoComplemento;
  }

  public function getPrestadorEnderecoBairro() {
    return $this->p_bairro;
  }

  public function setPrestadorEnderecoBairro($sPrestadorEnderecoBairro) {
    $this->p_bairro = $sPrestadorEnderecoBairro;
  }

  public function getPrestadorEnderecoCodigoMunicipio() {
    return $this->p_cod_municipio;
  }

  public function setPrestadorEnderecoCodigoMunicipio($iPrestadorEnderecoMunicipio) {
    $this->p_cod_municipio = $iPrestadorEnderecoMunicipio;
  }

  public function getPrestadorEnderecoEstado() {
    return $this->p_uf;
  }

  public function setPrestadorEnderecoEstado($sPrestadorEnderecoEstado) {
    $this->p_uf = $sPrestadorEnderecoEstado;
  }

  public function getPrestadorEnderecoCodigoPais() {
    return $this->p_cod_pais;
  }

  public function setPrestadorEnderecoCodigoPais($iPrestadorCodigoPais) {
    $this->p_cod_pais = $iPrestadorCodigoPais;
  }

  public function getPrestadorEnderecoCEP() {
    return $this->p_cep;
  }

  public function setPrestadorEnderecoCEP($iPrestadorEnderecoCEP) {
    $this->p_cep = $iPrestadorEnderecoCEP;
  }

  public function getPrestadorTelefone() {
    return $this->p_telefone;
  }

  public function setPrestadorTelefone($iPrestadorTelefone) {
    $this->p_telefone = $iPrestadorTelefone;
  }

  public function getPrestadorEmail() {
    return $this->p_email;
  }

  public function setPrestadorEmail($sPrestadorEmail) {
    $this->p_email = $sPrestadorEmail;
  }

  public function getTomadorCpfCnpj() {
    return $this->t_cnpjcpf;
  }
  
  public function setTomadorCpfCnpj($iTomadorCpfCnpj) {
    $this->t_cnpjcpf = $iTomadorCpfCnpj;
  }
  
  public function getTomadorInscricaoMunicipal() {
    return $this->t_im;
  }
  
  public function setTomadorInscricaoMunicipal($iTomadorInscricaoMunicipal) {
    $this->t_im = $iTomadorInscricaoMunicipal;
  }
  
  public function getTomadorInscricaoEstadual() {
    return $this->t_ie;
  }
  
  public function setTomadorInscricaoEstadual($iTomadorInscricaoEstadual) {
    $this->t_ie = $iTomadorInscricaoEstadual;
  }
  
  public function getTomadorRazaoSocial() {
    return $this->t_razao_social;
  }
  
  public function setTomadorRazaoSocial($sTomadorRazaoSocial) {
    $this->t_razao_social = $sTomadorRazaoSocial;
  }
  
  public function getTomadorNomeFantasia() {
    return $this->t_nome_fantasia;
  }
  
  public function setTomadorNomeFantasia($sTomadorNomeFantasia) {
    $this->t_nome_fantasia = $sTomadorNomeFantasia;
  }
  
  public function getTomadorEnderecoRua() {
    return $this->t_endereco;
  }
  
  public function setTomadorEnderecoRua($sTomadorEnderecoRua) {
    $this->t_endereco = $sTomadorEnderecoRua;
  }
  
  public function getTomadorEnderecoNumero() {
    return $this->t_endereco_numero;
  }
  
  public function setTomadorEnderecoNumero($sTomadorEnderecoNumero) {
    $this->t_endereco_numero = $sTomadorEnderecoNumero;
  }
  
  public function getTomadorEnderecoComplemento() {
    return $this->t_endereco_comp;
  }
  
  public function setTomadorEnderecoComplemento($sTomadorEnderecoComplemento) {
    $this->t_endereco_comp = $sTomadorEnderecoComplemento;
  }
  
  public function getTomadorEnderecoBairro() {
    return $this->t_bairro;
  }
  
  public function setTomadorEnderecoBairro($sTomadorEnderecoBairro) {
    $this->t_bairro = $sTomadorEnderecoBairro;
  }
  
  public function getTomadorEnderecoCodigoMunicipio() {
    return $this->t_cod_municipio;
  }
  
  public function setTomadorEnderecoCodigoMunicipio($iTomadorEnderecoMunicipio) {
    $this->t_cod_municipio = $iTomadorEnderecoMunicipio;
  }
  
  public function getTomadorEnderecoEstado() {
    return $this->t_uf;
  }
  
  public function setTomadorEnderecoEstado($sTomadorEnderecoEstado) {
    $this->t_uf = $sTomadorEnderecoEstado;
  }
  
  public function getTomadorEnderecoCodigoPais() {
    return $this->t_cod_pais;
  }
  
  public function setTomadorEnderecoCodigoPais($iTomadorCodigoPais) {
    $this->t_cod_pais = $iTomadorCodigoPais;
  }
  
  public function getTomadorEnderecoCEP() {
    return $this->t_cep;
  }
  
  public function setTomadorEnderecoCEP($iTomadorEnderecoCEP) {
    $this->t_cep = $iTomadorEnderecoCEP;
  }
  
  public function getTomadorTelefone() {
    return $this->t_telefone;
  }
  
  public function setTomadorTelefone($iTomadorTelefone) {
    $this->t_telefone = $iTomadorTelefone;
  }
  
  public function getTomadorEmail() {
    return $this->t_email;
  }
  
  public function setTomadorEmail($sTomadorEmail) {
    $this->t_email = $sTomadorEmail;
  }
  
  public function getServicoValorLiquido() {
    return $this->vl_liquido_nfse;
  }
  
  public function setServicoValorLiquido($fServicoValorLiquido) {
    $this->vl_liquido_nfse = $fServicoValorLiquido;
  }
  
  public function getServicoBaseCalculo() {
    return $this->s_vl_base_calculo;
  }
  
  public function setServicoBaseCalculo($fServicoBaseCalculo) {
    $this->s_vl_base_calculo = $fServicoBaseCalculo;
  }  
  
  public function getNotaNumero() {
    return $this->nota;
  }
  
  public function setNotaNumero($iNotaNumero) {
    $this->nota = $iNotaNumero;
  }
  
  public function getNotaSerie() {
    return $this->serie;
  }
  
  public function setNotaSerie($iNotaSerie) {
    $this->serie = $iNotaSerie;
  }
  
  public function getServicoCodigoServico() {
    return $this->s_codigo_servico;
  }
  
  public function setServicoCodigoServico($iServicoCodigoServico) {
    $this->s_codigo_servico = $iServicoCodigoServico;
  }
  
  public function getNumpre() {
    return $this->numpre;
  }
  
  public function setNumpre($numpre) {
    $this->numpre = $numpre;
  }
  
  public function getCodigoNotaPlanilha() {
    return $this->codigo_nota_planilha;
  }
  
  public function setCodigoNotaPlanilha($iCodigoNotaPlanilha) {
    $this->codigo_nota_planilha = $iCodigoNotaPlanilha;
  }
  
  public function getStatus() {
    return $this->status;
  }
  
  public function setStatus($iStatus) {
    $this->status = $iStatus;
  }

  /**
   * Define o grupo de documento (ecidade)
   *
   * @param integer $iGrupoDocumento
   */
  public function setGrupoDocumento($iGrupoDocumento) {
    $this->grupo_documento = $iGrupoDocumento;
  }

  /**
   * Retorna o grupo de documento (ecidade)
   *
   * @return integer
   */
  public function getGrupoDocumento() {
    return $this->grupo_documento;
  }

  public function getTipoDocumento() {
    return $this->tipo_documento;
  }
  
  public function setTipoDocumento($iTipoDocumento) {
    $this->tipo_documento = $iTipoDocumento;
  }
  
  public function getTipoDocumentoDescricao() {
    return $this->tipo_documento_descricao;
  }
  
  public function setTipoDocumentoDescricao($sTipoDocumentoDescricao) {
    $this->tipo_documento_descricao = $sTipoDocumentoDescricao;
  }
  
  public function getSituacaoDocumento() {
    return $this->situacao_documento;
  }
  
  public function setSituacaoDocumento($sSituacaoDocumento) {
    $this->situacao_documento = $sSituacaoDocumento;
  }
  
  public function getEmiteGuia() {
    return $this->emite_guia;
  }
  
  public function setEmiteGuia($lEmiteGuia) {
    $this->emite_guia = $lEmiteGuia;
  }
  
  public function getServicoCodigoObra() {
    return $this->s_codigo_obra;
  }
  
  public function setServicoCodigoObra($s_codigo_obra) {
    $this->s_codigo_obra = $s_codigo_obra;
  }
  
  public function getServicoArt() {
    return $this->s_art;
  }
  
  public function setServicoArt($s_art) {
    $this->s_art = $s_art;
  }
  
  public function getServicoInformacoesComplementares() {
    return $this->s_informacoes_complementares;
  }
  
  public function setServicoInformacoesComplementares($s_informacoes_complementares) {
    $this->s_informacoes_complementares = $s_informacoes_complementares;
  }
  
  public function getNaturezaOperacao() {
    return $this->natureza_operacao;
  }
  
  public function setNaturezaOperacao($iNaturezaOperacao) {
    $this->natureza_operacao = $iNaturezaOperacao;
  }
  
  public function getIdUsuario() {
    return $this->id_usuario;
  }
  
  public function setIdUsuario($iIdUsuario) {
    $this->id_usuario = $iIdUsuario;
  }
  
  public function getIdContribuinte() {
    return $this->id_contribuinte;
  }
  
  public function setIdContribuinte($iIdContribuinte) {
    $this->id_contribuinte = $iIdContribuinte;
  }
}