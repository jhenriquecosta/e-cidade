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
 * Modelo para o contribuinte do município
 *
 * @author  Roberto Carneiro <roberto@dbseller.com.br>
 * @package Contribuinte/Models
 * @see     Contribuinte_Model_ContribuinteAbstract
 * @see     Contribuinte_Interface_Contribuinte
 */

class Contribuinte_Model_Contribuinte extends Contribuinte_Model_ContribuinteAbstract
  implements Contribuinte_Interface_Contribuinte {

  /**
   * Campos retornados do webservice
   *
   * @var array
   */
  private static $aCampos = array(
    'getDadosCadastroNotas' => array(
      'tipo',
      'cgccpf',
      'nome',
      'nome_fanta',
      'identidade',
      'inscr_est',
      'tipo_lograd',
      'lograd',
      'numero',
      'complemento',
      'bairro',
      'cod_ibge',
      'munic',
      'uf',
      'cod_pais',
      'pais',
      'cep',
      'telefone',
      'fax',
      'celular',
      'email',
      'inscricao',
      'data_inscricao',
      'data_inscricao_baixa',
      'tipo_classificacao',
      'optante_simples',
      'optante_simples_baixado',
      'tipo_emissao',
      'exigibilidade',
      'subst_tributaria',
      'regime_tributario',
      'incentivo_fiscal',
      'numero_cgm',
      'optante_simples_categoria'
    ),
    'getDadosEmpresa'       => array(
      'razao_social',
      'codigo_empresa',
      'cnpj',
      'endereco',
      'cgm'
    ),
    'getCadastroSimplesNacional' => array(
      'sequencial',
      'inscricao_municipal',
      'data_inicial',
      'categoria',
      'data_baixa',
      'motivo_baixa'
    )
  );

  /**
   * Retorna os dados do contribuinte
   *
   * @param integer $iInscricaoMunicipal
   * @return object
   */
  public static function getDadosContribuinteEcidade($iInscricaoMunicipal) {

    $oContribuinteWebService = NULL;

    if ($iInscricaoMunicipal != NULL) {
      $aParametros   = array(array('inscricao' => $iInscricaoMunicipal), self::$aCampos['getDadosCadastroNotas']);
      $aContribuinte = WebService_Model_Ecidade::consultar('getDadosCadastroNotas', $aParametros);
      if (is_array($aContribuinte) && count($aContribuinte) > 0) {
        $oContribuinteWebService = $aContribuinte[0];
      }
    }

    return $oContribuinteWebService;
  }

  /**
   * Retorna contribuinte pela inscrição municipal
   *
   * @param $iInscricaoMunicipal
   * @return Contribuinte_Model_Contribuinte|null|object
   */
  public static function getByInscricaoMunicipal($iInscricaoMunicipal) {

    $oContribuinteWebService = NULL;

    if ($iInscricaoMunicipal != NULL) {

      $oContribuinteWebService = self::getDadosContribuinteEcidade($iInscricaoMunicipal);
      $iUsuarioLogadoSessao    = Zend_Auth::getInstance()->getIdentity();
      $iUsuarioLogado          = Administrativo_Model_Usuario::getById($iUsuarioLogadoSessao['id']);
      $oUsuarioContribuinte    = Administrativo_Model_UsuarioContribuinte::getByUsuarioContribuinte($iUsuarioLogado,
                                                                                                    $iInscricaoMunicipal);

      // verifica se tá cadastrado e se tem contribuinte vinculado no nota.
      if (empty($oUsuarioContribuinte) || (is_array($oUsuarioContribuinte) && count($oUsuarioContribuinte) == 1)) {

        $oContribuinte = self::preencherInstanciaContribuinte($oContribuinteWebService);

        // caso não exista ela não está cadastrado no nota então ele não tem id ainda
        if (!empty($oUsuarioContribuinte)) {
          $oContribuinte->setIdUsuarioContribuinte($oUsuarioContribuinte[0]->getId());
        }

        return $oContribuinte;
      }
    }

    return NULL;
  }

  /**
   * Retorna contribuinte pelo CNPJ
   *
   * @param string $sCnpj
   * @return Contribuinte_Model_Contribuinte|object
   */
  public static function getByCpfCnpj($sCnpj) {

    $oContribuinteWebService = NULL;

    if ($sCnpj != NULL) {

      // Limpa máscaras
      $sCnpj = DBSeller_Helper_Number_Format::getNumbers($sCnpj);

      // Consulta WebService
      $aParametros   = array(array('cnpj' => $sCnpj), self::$aCampos['getDadosEmpresa']);
      $aContribuinte = WebService_Model_Ecidade::consultar('getDadosEmpresa', $aParametros);

      if (is_array($aContribuinte) && !empty($aContribuinte)) {
        $oContribuinteWebService = $aContribuinte[0];
      }
    }

    return self::preencherInstanciaContribuinte($oContribuinteWebService);
  }

  /**
   * Retorna uma instancia de Contribuinte atravéz do código do contribuinte.
   *
   * @param $iCodigoContribuinte
   * @return Contribuinte_Model_Contribuinte|null|object
   */
  public static function getById($iCodigoContribuinte) {

    $oUsuarioContribuinte    = Administrativo_Model_UsuarioContribuinte::getById($iCodigoContribuinte);
    $oContribuinteWebService = self::getDadosContribuinteEcidade($oUsuarioContribuinte->getIm());

    if (empty($oContribuinteWebService)) {
      return NULL;
    }

    $oContribuinte = self::preencherInstanciaContribuinte($oContribuinteWebService);
    $oContribuinte->setIdUsuarioContribuinte($iCodigoContribuinte);

    return $oContribuinte;
  }

  /**
   * Preenche os dados do contribuinte
   * @param null $oContribuinteWebService
   *
   * @return Contribuinte_Model_Contribuinte|null
   */
  public static function preencherInstanciaContribuinte($oContribuinteWebService = NULL) {

    $oContribuinte = NULL;

    if (is_object($oContribuinteWebService)) {

      $oContribuinte = new Contribuinte_Model_Contribuinte();

      if (isset($oContribuinteWebService->razao_social)) {
        $oContribuinte->setRazaoSocial($oContribuinteWebService->razao_social);
      }

      if (isset($oContribuinteWebService->codigo_empresa)) {
        $oContribuinte->setInscricaoMunicipal($oContribuinteWebService->codigo_empresa);
      }

      if (isset($oContribuinteWebService->endereco)) {
        $oContribuinte->setEndereco($oContribuinteWebService->endereco);
      }

      if (isset($oContribuinteWebService->cgm)) {
        $oContribuinte->setCgm($oContribuinteWebService->cgm);
      }

      if (isset($oContribuinteWebService->tipo)) {
        $oContribuinte->setTipoPessoa($oContribuinteWebService->tipo);
      }

      if (isset($oContribuinteWebService->cnpj)) {
        $oContribuinte->setCgcCpf($oContribuinteWebService->cnpj);
      }

      if (isset($oContribuinteWebService->cgccpf)) {
        $oContribuinte->setCgcCpf($oContribuinteWebService->cgccpf);
      }

      if (isset($oContribuinteWebService->nome)) {
        $oContribuinte->setNome($oContribuinteWebService->nome);
      }

      if (isset($oContribuinteWebService->nome_fanta)) {
        $oContribuinte->setNomeFantasia($oContribuinteWebService->nome_fanta);
      }

      if (isset($oContribuinteWebService->identidade)) {
        $oContribuinte->setIdentidade($oContribuinteWebService->identidade);
      }

      if (isset($oContribuinteWebService->inscr_est)) {
        $oContribuinte->setInscricaoEstadual($oContribuinteWebService->inscr_est);
      }

      if (isset($oContribuinteWebService->tipo_lograd)) {
        $oContribuinte->setTipoLogradouro($oContribuinteWebService->tipo_lograd);
      }

      if (isset($oContribuinteWebService->lograd)) {
        $oContribuinte->setDescricaoLogradouro($oContribuinteWebService->lograd);
      }

      if (isset($oContribuinteWebService->numero)) {
        $oContribuinte->setLogradouroNumero($oContribuinteWebService->numero);
      }

      if (isset($oContribuinteWebService->complemento)) {
        $oContribuinte->setLogradouroComplemento($oContribuinteWebService->complemento);
      }

      if (isset($oContribuinteWebService->bairro)) {
        $oContribuinte->setLogradouroBairro($oContribuinteWebService->bairro);
      }

      if (isset($oContribuinteWebService->cod_ibge)) {
        $oContribuinte->setCodigoIbgeMunicipio($oContribuinteWebService->cod_ibge);
      }

      if (isset($oContribuinteWebService->munic)) {
        $oContribuinte->setDescricaoMunicipio($oContribuinteWebService->munic);
      }

      if (isset($oContribuinteWebService->uf)) {
        $oContribuinte->setEstado($oContribuinteWebService->uf);
      }

      if (isset($oContribuinteWebService->cod_pais)) {
        $oContribuinte->setCodigoPais($oContribuinteWebService->cod_pais);
      }

      if (isset($oContribuinteWebService->pais)) {
        $oContribuinte->setDescricaoPais($oContribuinteWebService->pais);
      }

      if (isset($oContribuinteWebService->cep)) {
        $oContribuinte->setCep($oContribuinteWebService->cep);
      }

      if (isset($oContribuinteWebService->telefone)) {
        $oContribuinte->setTelefone($oContribuinteWebService->telefone);
      }

      if (isset($oContribuinteWebService->fax)) {
        $oContribuinte->setFax($oContribuinteWebService->fax);
      }

      if (isset($oContribuinteWebService->celular)) {
        $oContribuinte->setCelular($oContribuinteWebService->celular);
      }

      if (isset($oContribuinteWebService->email)) {
        $oContribuinte->setEmail(strtolower($oContribuinteWebService->email));
      }

      if (isset($oContribuinteWebService->inscricao)) {
        $oContribuinte->setInscricaoMunicipal($oContribuinteWebService->inscricao);
      }

      if (isset($oContribuinteWebService->data_inscricao)) {
        $oContribuinte->setDataInscricao(new DateTime($oContribuinteWebService->data_inscricao));
      }

      if (isset($oContribuinteWebService->data_inscricao_baixa)) {
        $oContribuinte->setDataInscricaoBaixa(new DateTime($oContribuinteWebService->data_inscricao_baixa));
      }

      if (isset($oContribuinteWebService->tipo_classificacao)) {
        $oContribuinte->setTipoClassificacao($oContribuinteWebService->tipo_classificacao);
      }

      if (isset($oContribuinteWebService->optante_simples)) {
        $oContribuinte->setOptanteSimples((trim($oContribuinteWebService->optante_simples) == 'Sim') ? 1 : 0);
      }

      if (isset($oContribuinteWebService->optante_simples_baixado)) {
        $oContribuinte->setOptanteSimplesBaixado($oContribuinteWebService->optante_simples_baixado);
      }

      if (isset($oContribuinteWebService->tipo_emissao)) {
        $oContribuinte->setTipoEmissao($oContribuinteWebService->tipo_emissao);
      }

      if (isset($oContribuinteWebService->exigibilidade)) {
        $oContribuinte->setExigibilidade($oContribuinteWebService->exigibilidade);
      }

      if (isset($oContribuinteWebService->subst_tributaria)) {
        $oContribuinte->setSubstituicaoTributaria($oContribuinteWebService->subst_tributaria);
      }

      if (isset($oContribuinteWebService->regime_tributario)) {
        $oContribuinte->setRegimeTributario($oContribuinteWebService->regime_tributario);
      }

      if (isset($oContribuinteWebService->incentivo_fiscal)) {
        $oContribuinte->setIncentivoFiscal($oContribuinteWebService->incentivo_fiscal);
      }

      if (isset($oContribuinteWebService->optante_simples) && isset($oContribuinteWebService->optante_simples_baixado)) {

        $oContribuinteWebService->optante_simples = utf8_decode($oContribuinteWebService->optante_simples);
        $oContribuinteWebService->optante_simples_baixado = utf8_decode($oContribuinteWebService->optante_simples_baixado);

        $oContribuinte->setDescricaoOptanteSimples(trim($oContribuinteWebService->optante_simples));
        $oContribuinte->setOptanteSimplesCategoria(trim($oContribuinteWebService->optante_simples_categoria));

        if (trim($oContribuinteWebService->optante_simples_baixado) == 'Sim') {
          $oContribuinte->setDescricaoOptanteSimples('Não');
        }
      }

      if (isset($oContribuinteWebService->subst_tributaria)) {

        $oContribuinte->setDescricaoSubstituicaoTributaria(
          Contribuinte_Model_SubstitutoTributario::getById($oContribuinteWebService->subst_tributaria)
        );

        $oContribuinte->setDescricaoExigibilidade(
          Contribuinte_Model_Exigeiss::getById($oContribuinteWebService->exigibilidade)
        );

        $oContribuinte->setDescricaoIncentivoFiscal(
          Contribuinte_Model_IncentivoFiscal::getById($oContribuinteWebService->incentivo_fiscal)
        );

        $oContribuinte->setDescricaoRegimeTributario(
          Contribuinte_Model_Tributacao::getById($oContribuinteWebService->regime_tributario)
        );

        $oContribuinte->setDescricaoTipoClassificacao(
          Contribuinte_Model_TipoEmpresa::getById($oContribuinteWebService->tipo_classificacao)
        );

        $oContribuinte->setDescricaoTipoEmissao(
          Contribuinte_Model_TipoEmissao::getById($oContribuinteWebService->tipo_emissao)
        );
      }
    }

    return $oContribuinte;
  }

  /**
   * Retorna o tipo de emissão do contribuinte (DMS ou NFSE)
   *
   * @return integer|null
   */
  public function getTipoEmissao() {

    $aParametros   = array(
      array('inscricao' => $this->getInscricaoMunicipal()),
      self::$aCampos['getDadosCadastroNotas']
    );
    $aContribuinte = WebService_Model_Ecidade::consultar('getDadosCadastroNotas', $aParametros);
    $iTipoEmissao  = NULL;

    if (is_array($aContribuinte)) {
      $iTipoEmissao = $aContribuinte[0]->tipo_emissao;
    }

    return $iTipoEmissao;
  }

  /**
   * Verifica via webservice se o contribuinte é optante pelo simples na data especificada
   *
   * @param DateTime $oData
   * @throws Exception
   * @return boolean
   */
  public function isOptanteSimples(DateTime $oData) {

    try {

      $aFiltro     = array('inscricao_municipal' => $this->getInscricaoMunicipal(), 'data' => $oData->format('Y-m-d'));
      $aCampos     = array('optante_simples');
      $oWebService = new WebService_Model_Ecidade();
      $uRetorno    = $oWebService->consultar('getEmpresaOptanteSimples', array($aFiltro, $aCampos));

      $oRetorno = NULL;
      if (!empty($uRetorno) && is_array($uRetorno)) {
        $oRetorno = reset($uRetorno);
      }

      if (isset($oRetorno->optante_simples) && $oRetorno->optante_simples = 't') {
        return TRUE;
      } else {
        return FALSE;
      }
    } catch (Exception $oError) {
      DBSeller_Plugin_Notificacao::addErro('W008', "Erro ao verificar se o contribuinte é optante pelo simples: {$oError->getMessage()}");
      throw new Exception("Erro ao verificar se o contribuinte é optante pelo simples: {$oError->getMessage()}");
    }
  }

  /**
   * Método que busca do e-cidade os dados da empresa agruapada por Inscrição Municipal
   * @param  string $sCnpj
   * @return array  $aContribuinte
   * @throws Exception
   */
  public function getInscricaoMunicipalByCpjCnpj($sCnpj){

    try {

      if ($sCnpj != NULL) {

        // Limpa máscaras
        $iCnpj = DBSeller_Helper_Number_Format::getNumbers($sCnpj);

        // Consulta WebService
        $aParametros   = array(array('cnpj' => $iCnpj), self::$aCampos['getDadosEmpresa']);
        $aContribuinte = WebService_Model_Ecidade::consultar('getDadosEmpresa', $aParametros);

        return $aContribuinte;
      }
    } catch(Exception $oError) {
      DBSeller_Plugin_Notificacao::addErro('W009', "Erro ao consultar as Inscrições Municipais do Contribuinte: {$oError->getMessage()}");
      throw new Exception("Erro ao consultar as Inscrições Municipais do Contribuinte: {$oError->getMessage()}");
    }
  }

  /**
   * Método que retorna se o contribuinte é de Regime Tributario tipo MEI
   * @return boolean
   */
  public function isRegimeTributarioMei(){

    $sPeriodo = new DateTime();
    $sPeriodo = $sPeriodo->format('Y-m-d');
    $oDataSimples = new DateTime(DBSeller_Helper_Date_Date::invertDate($sPeriodo, '-'));
    $iOptanteSimples   = $this->isOptanteSimples($oDataSimples);
    $iCategoriaSimples = $this->getOptanteSimplesCategoria();

    if ($iOptanteSimples && $iCategoriaSimples  == Contribuinte_Model_ContribuinteAbstract::OPTANTE_SIMPLES_TIPO_MEI) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Método que retorna se o contribuinte é de Regime Tributario tipo SOCIEDADE DE PROFISSIONAIS
   * @return boolean
   */
  public function isRegimeTributarioSociedadeProfissionais(){

    $iRegimeTributario = $this->getRegimeTributario();

    if ($iRegimeTributario  == Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_SOCIEDADE_PROFISSIONAIS) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Método que retorna se o contribuinte é de Regime Tributario tipo FIXADO
   * @return boolean
   */
  public function isRegimeTributarioFixado(){

    $iRegimeTributario = $this->getRegimeTributario();

    if ($iRegimeTributario  == Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_FIXADO) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Método que retorna se o contribuinte é de Regime Tributario tipo MEI e Optante pelo Simples Nacional
   * @return boolean
   * @throws Exception
   */
  public function isMEIAndOptanteSimples() {

    $oDataAtual           = new DateTime();
    $bOptanteSimples      = Contribuinte_Model_Contribuinte::isOptanteSimples($oDataAtual);
    $bRegimeTributarioMei = Contribuinte_Model_Contribuinte::isRegimeTributarioMei();

    if ($bOptanteSimples && $bRegimeTributarioMei) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Método que retorna se o contribuinte tem exegibilidade igual a isenção ou imunidade
   * @return boolean
   */
  public function isExegibilidadeIsentoImuni(){

    $iExigibilidade = $this->getExigibilidade();

    if(   $iExigibilidade == Contribuinte_Model_Contribuinte::EXIGIBILIDADE_ISENTO
       || $iExigibilidade == Contribuinte_Model_Contribuinte::EXIGIBILIDADE_IMUNE
    ){
      return true;
    }

    return false;
  }

  /**
   * Método que retorna se o contribuinte é de Regime Tributario tipo Estimativa
   * @return boolean
   */
  public function isRegimeTributarioEstimativa(){

    $iRegimeTributario = $this->getRegimeTributario();

    if($iRegimeTributario == Contribuinte_Model_ContribuinteAbstract::REGIME_TRIBUTARIO_ESTIMATIVA){
      return true;
    }

    return false;
  }

  /**
   * Calcula quantos dias no passado a nota pode ser emitida
   *
   * @param object $oContribuinte
   *
   * @return array
   * @throws Exception
   */
  public static function getDiasRetroativosEmissao($oContribuinte) {

    $oParametrosPrefeitura       = Administrativo_Model_Prefeitura::getDadosPrefeituraBase();
    $iDiasRetroativosEmissaoNota = $oParametrosPrefeitura->getNotaRetroativa();
    $oDataCorrente               = new DateTime();
    $iMaxNota                    = 0;
    $iMaxGuia                    = 0;
    $oUltimaGuia                 = Contribuinte_Model_Guia::getUltimaGuiaNota($oContribuinte);
    $uDataUltimaNota             = Contribuinte_Model_Nota::getUltimaNotaEmitidaByContribuinte(
      $oContribuinte->getContribuintes()
    );

    if ($uDataUltimaNota != null) {

      $oDiff    = $oDataCorrente->diff(new DateTime($uDataUltimaNota), TRUE);
      $iMaxNota = ($oDiff->days < $iDiasRetroativosEmissaoNota) ? $oDiff->days : $iDiasRetroativosEmissaoNota;
    }

    if (!empty($oUltimaGuia)) {

      $iMes = $oUltimaGuia->getMesComp();
      $iAno = $oUltimaGuia->getAnoComp();

      if (($oUltimaGuia->getMesComp() + 1) > 12) {
        $iMes = 1;
      }

      $iMes = str_pad($iMes, 2, '0', STR_PAD_LEFT);
      $uDataUltimoDiaCompetencia = new Zend_Date("01/{$iMes}/{$iAno}");
      $uDataUltimoDiaCompetencia->sub(-1, Zend_date::MONTH);
      $oDiff    = $oDataCorrente->diff(new DateTime($uDataUltimoDiaCompetencia->get('Y-M-d')), TRUE);
      $iMaxGuia = ($oDiff->days < $iDiasRetroativosEmissaoNota) ? $oDiff->days : $iDiasRetroativosEmissaoNota;
    }

    if ($iMaxNota > $iMaxGuia && $iMaxGuia > 0) {
      $iDiasRetroativosEmissaoNota = $iMaxGuia;
    } else if ($iMaxNota > 0) {
      $iDiasRetroativosEmissaoNota = $iMaxNota;
    } else if (!$iDiasRetroativosEmissaoNota || $iMaxNota == 0) {
      $iDiasRetroativosEmissaoNota = 0;
    }

    $oDataCorrente = new DateTime();
    $oDataCorrente = $oDataCorrente->sub(date_interval_create_from_date_string("{$iDiasRetroativosEmissaoNota} days"));

    // Vetor com os dias em que a nota pode ser emitida
    $aDiasEmissao = array();
    $oDia         = new DateTime();

    do {
      $aDiasEmissao[$oDia->format('Y-m-d')] = $oDia->format('d/m/Y');
      $oDia                                 = $oDia->sub(new DateInterval('P1D'));
    } while ($oDia->format('Ymd') >= $oDataCorrente->format('Ymd'));

    return $aDiasEmissao;
  }

  /**
   * Busca todos os contribuintes que são Prestadores NFSE
   * @return array
   */
  public static function getContribuinteEmissoresNfse() {

    $oQueryBuilder = Contribuinte_Lib_Model_Doctrine::getQuery();
    $oQueryBuilder->select('uc.id')->distinct(TRUE);
    $oQueryBuilder->from('Administrativo\Usuario', 'u');
    $oQueryBuilder->join('u.usuarios_contribuintes', 'uc');
    $oQueryBuilder->where('u.perfil in(1,2)');
    $oQueryBuilder->andWhere('u.tipo in(1,2)');
    $oQueryBuilder->andWhere('u.habilitado = true');
    $oQueryBuilder->groupBy('uc.id');

    $aUsuariosEmissoresNfse = $oQueryBuilder->getQuery()->getArrayResult();

    return $aUsuariosEmissoresNfse;
  }

  public static function getContribuinteByCnpjCpf($sCnpjCpf) {

    $oQueryBuilder = Contribuinte_Lib_Model_Doctrine::getQuery();
    $oQueryBuilder->select("uc");
    $oQueryBuilder->from("Administrativo\UsuarioContribuinte", "uc");
    $oQueryBuilder->andWhere("uc.cnpj_cpf = '{$sCnpjCpf}'");
    $oQueryBuilder->setMaxResults(1);

    $oContribuinte = $oQueryBuilder->getQuery()->getResult();
    return $oContribuinte[0];
  }

  /**
   * Obtem a atividade com a data de inicio mais antiga (inicio das atividades da empresa)
   * @param  Contribuinte_Model_Contribuinte $oContribuinte
   * @return   DateTime | false
   */
  public static function getInicioAtividades(Contribuinte_Model_Contribuinte $oContribuinte)
  {

    if (!$oContribuinte instanceof Contribuinte_Model_Contribuinte){
      return false;
    }

    $aAtividades = Contribuinte_Model_Servico::getByIm($oContribuinte->getInscricaoMunicipal(), FALSE);

    if (empty($aAtividades)) {
      return false;
    }

    $oMenorDataAtividade = new DateTime();

    foreach ($aAtividades as $oAtividade) {

      if ($oMenorDataAtividade > new DateTime($oAtividade->attr('dt_inicio'))) {
        $oMenorDataAtividade = new DateTime($oAtividade->attr('dt_inicio'));
      }

    }

    return $oMenorDataAtividade;
  }

  /**
   * Obtem o cadastro do simples nacional do contribuinte
   */
  public function getCadastroSimplesNacional()
  {
    $aParametros   = array(
      array('inscricao_municipal' => $this->getInscricaoMunicipal()),
      self::$aCampos['getCadastroSimplesNacional']
    );
    $aCadastroSimplesNacional = WebService_Model_Ecidade::consultar('getCadastroSimplesNacional', $aParametros);

    return $aCadastroSimplesNacional;
  }
}
