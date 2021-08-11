<?php

class Administrativo_Model_Contribuinte extends E2Tecnologia_Model_WebService {

  private static $aCampos = array(
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
    'tipo_classificacao',
    'optante_simples',
    'optante_simples_baixado',
    'tipo_emissao',
    'exigibilidade',
    'subst_tributaria',
    'regime_tributario',
    'incentivo_fiscal'
  );
  
  public function __construct($o = NULL) {
    
    parent::__construct($o);
    
    if (isset($o->subst_tributaria)) {
      
      // Adiciona atributos definidos por outros modelos
      $o->descr_subst_tributaria  = Contribuinte_Model_SubstitutoTributario::getById($o->subst_tributaria);
      $o->descr_exibilidade       = Contribuinte_Model_Exigeiss::getById($o->exigibilidade);
      $o->descr_incentivo_fiscal  = Contribuinte_Model_IncentivoFiscal::getById($o->incentivo_fiscal);
      $o->descr_regime_tributario = Contribuinte_Model_Tributacao::getById($o->regime_tributario);
      $o->descr_tipo_classificao  = Contribuinte_Model_TipoEmpresa::getById($o->tipo_classificacao);
      $o->descr_tipo_emissao      = Contribuinte_Model_TipoEmissao::getById($o->tipo_emissao);
      
      if ($o->optante_simples == 'Sim' &&  $o->optante_simples_baixado == 'Sim') {
        $o->descr_optante_simples = 'Não';
      } else if ($o->optante_simples == 'Sim') {
        $o->descr_optante_simples = 'Sim';
      } else {
        $o->descr_optante_simples = 'Não';
      }
    }
  }  
  
  /**
   * Retorna dados do contribuinte
   * 
   * @param array $aFiltro
   * @return Ambigous <NULL, object>
   */
  private static function get($aFiltro) {
    return parent::consultar('getDadosCadastroNotas', array($aFiltro, self::$aCampos));
  }
  
  /**
   * Retorna contribuinte pela inscrição municipal 
   * 
   * @param integer $iInscricaoMunicipal
   * @return Ambigous <NULL, Administrativo_Model_Contribuinte>
   */
  public static function getByIm($iInscricaoMunicipal) {
    
    if ($iInscricaoMunicipal != NULL) {
      
      $sFiltro       = array('inscricao' => $iInscricaoMunicipal);
      $aContribuinte = self::get($sFiltro);
      
      if (is_array($aContribuinte)) {
        
        foreach ($aContribuinte as $oContribuinte) {
          $aRetorno[] = new Administrativo_Model_Contribuinte($oContribuinte);
        }
      }
    }
    
    return isset($aRetorno) ? $aRetorno : NULL;
  }
  
  /**
   * Retorna contribuinte pelo CNPJ
   * 
   * @param string $cnpj
   * @return Ambigous <NULL, Administrativo_Model_Contribuinte>
   */
  public static function getByCnpj($cnpj) {
    
    if ($cnpj != NULL) {
    
      $aCampos = array(
        'razao_social',
        'codigo_empresa',
        'cnpj',
        'endereco',
        'cgm'
      );
      
      $aFiltro    = array('cnpj' => $cnpj);
      $aResultado = parent::consultar('getDadosEmpresa', array($aFiltro, $aCampos));
      
      if (is_array($aResultado)) {
        
        foreach ($aResultado as $r) {
          $aRetorno[] = new Administrativo_Model_Contribuinte($r);
        }
      }
    }
    
    return isset($aRetorno) ? $aRetorno : NULL;
  }
  
  /**
   * Retorna o tipo de emissão do contribuinte (DMS ou NFSE)
   * 
   * @param integer $iInscricaoMunicipal
   * @return Ambiguos <NULL, object>
   */
  public static function getTipoEmissao ($iInscricaoMunicipal) {
    
    $oRetorno = self::getByIm($iInscricaoMunicipal);
    
    if (is_object($oRetorno[0]) && $oRetorno[0]->attr('tipo_emissao')) {
      return $oRetorno[0]->attr('tipo_emissao');
    }
    
    return NULL;
  }
}
