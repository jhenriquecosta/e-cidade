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
 * Modelo para empresa 
 */
class Contribuinte_Model_Empresa {

  private $oObjeto = NULL;
  
  /**
   * Mapeamento de equivalencia de campos entre os dados recebidos do WebService e da base do sistema
   * 
   * @var Array 
   */
  private static $aMapeamento = array(
    'nome'        => 'NomeRazaoSocial',
    'nome_fanta'  => 'NomeFantasia',
    'inscr_est'   => NULL,
    'inscricao'   => NULL,
    'tipo_rua'    => NULL,
    'endereco'    => 'Endereco',
    'numero'      => 'Numero',
    'complemento' => 'Complemento',
    'bairro'      => 'Bairro',
    'cod_ibge'    => 'Municipio',
    'municipio'   => NULL,
    'uf'          => 'Uf',
    'cod_pais'    => 'Pais',
    'pais'        => NULL,
    'cep'         => 'Cep',
    'telefone'    => 'Telefone',
    'email'       => 'Email',
    'subst_trib'  => NULL
  );

  public function __construct($oObjeto = NULL) {
    $this->oObjeto = $oObjeto;
  }

  /**
   * Busca informações da empresa pelo CGC/CPF
   *
   * @param      $sCgcCpf
   * @param bool $lSubstituto
   * @return null|StdClass
   */
  public static function getByCgcCpf($sCgcCpf, $lSubstituto = FALSE) {
    
    if (!$sCgcCpf) {
      return NULL;
    }
    
    // Busca dados do e-Cidade
    $aEmpresa = Contribuinte_Model_EmpresaEcidade::getByCgcCpf($sCgcCpf);

    if (!empty($aEmpresa)) {

      foreach ($aEmpresa as $oDadosEmpresa) {
        $aDadosRetorno[] = $oDadosEmpresa;
      }

      $oDadosRetorno = new StdClass();
      $oDadosRetorno->eCidade = array(new self($aDadosRetorno[0]));
      
      return $oDadosRetorno;
    }
    
    // Busca dados da Base Local
    $aEmpresa = Contribuinte_Model_EmpresaBase::getByAttribute('cpfcnpj', $sCgcCpf);
    
    if (!empty($aEmpresa)) {

      $oDadosRetorno = new StdClass();
      $oDadosRetorno->eNota = array(new self($aEmpresa));
      
      return $oDadosRetorno;
    }
    
    return NULL;
  }

  /**
   * Retorna dados do atributo especificado
   * 
   * @param string $atributo
   * @return mixed|NULL
   */
  public function attr($atributo) {
    
    if (get_class($this->oObjeto) == 'Contribuinte_Model_EmpresaEcidade') {
      return $this->oObjeto->attr($atributo);
    }
    
    if (self::$aMapeamento[$atributo] != NULL) {
      
      $metodo = 'get' . self::$aMapeamento[$atributo];
      
      return call_user_func_array(array($this->oObjeto, $metodo), array());
    } else {
      return NULL;
    }
  }

  /**
   * Transforma a entidade doctrine em um objeto stdClass como é retornado pelo WebService
   */
  public function toObject() {
    
    $oObjeto = new stdClass();        
    
    if ($this->isEntity()) {
      
      $this->oObjeto                  = is_array($this->oObjeto) ? $this->oObjeto[0] : $this->oObjeto;
      $oObjeto->cpf                   = $this->oObjeto->getCpfcnpj();
      $oObjeto->nome                  = $this->oObjeto->getNomeRazaoSocial();
      $oObjeto->nome_fanta            = $this->oObjeto->getNomeFantasia();
      $oObjeto->inscr_est             = NULL;
      $oObjeto->inscricao             = NULL;
      $oObjeto->tipo_rua              = NULL;
      $oObjeto->endereco              = utf8_encode($this->oObjeto->getEndereco());
      $oObjeto->numero                = $this->oObjeto->getNumero();
      $oObjeto->complemento           = $this->oObjeto->getComplemento();
      $oObjeto->bairro                = $this->oObjeto->getBairro();
      $oObjeto->cod_ibge              = $this->oObjeto->getMunicipio();
      $oObjeto->municipio             = NULL;
      $oObjeto->uf                    = $this->oObjeto->getUf();
      $oObjeto->cod_pais              = $this->oObjeto->getPais();
      $oObjeto->pais                  = NULL;
      $oObjeto->cep                   = $this->oObjeto->getCep();
      $oObjeto->telefone              = $this->oObjeto->getTelefone();
      $oObjeto->email                 = $this->oObjeto->getEmail();
      $oObjeto->substituto_tributario = FALSE;
      $oObjeto->origem                = 'nfse';
    } else {
      
      $oObjeto->cpf                   = $this->oObjeto->attr('cpf');
      $oObjeto->nome                  = $this->oObjeto->attr('nome');
      $oObjeto->nome_fanta            = $this->oObjeto->attr('nome_fanta');
      $oObjeto->inscr_est             = $this->oObjeto->attr('inscr_est');
      $oObjeto->inscricao             = $this->oObjeto->attr('inscricao');
      $oObjeto->tipo_rua              = $this->oObjeto->attr('tipo_rua');
      $oObjeto->logradouro            = $this->oObjeto->attr('logradouro');
      $oObjeto->numero                = $this->oObjeto->attr('numero');
      $oObjeto->complemento           = $this->oObjeto->attr('complemento');
      $oObjeto->bairro                = $this->oObjeto->attr('bairro');
      $oObjeto->cod_ibge              = $this->oObjeto->attr('cod_ibge');
      $oObjeto->municipio             = $this->oObjeto->attr('municipio');
      $oObjeto->uf                    = $this->oObjeto->attr('uf');
      $oObjeto->cod_pais              = $this->oObjeto->attr('cod_pais');
      $oObjeto->pais                  = $this->oObjeto->attr('pais');
      $oObjeto->cep                   = $this->oObjeto->attr('cep');
      $oObjeto->telefone              = $this->oObjeto->attr('telefone');
      $oObjeto->email                 = $this->oObjeto->attr('email');
      $oObjeto->substituto_tributario = ($this->oObjeto->attr('subst_trib')=='SIM');
      $oObjeto->origem                = 'ecidade';
    }
    
    return $oObjeto;
  }

  /**
   * Verifica se é uma entidade doctrine
   * 
   * @return boolean
   */
  public function isEntity() {
    
    if (is_array($this->oObjeto)) {
      return get_class($this->oObjeto[0]) == 'Contribuinte_Model_EmpresaBase';
    } else {
      return get_class($this->oObjeto) == 'Contribuinte_Model_EmpresaBase';
    }
  }

  /**
   * Se o metodo nao for encontrado no modelo, reflete a chamada para a Entidade
   *
   * @param $name
   * @param $arguments
   * @return mixed
   * @throws Exception
   */
  public function __call($name, $arguments) {
    
    if ($this->oObjeto !== NULL) {
      
      if (method_exists($this->oObjeto, $name)) {
        return call_user_func_array(array($this->oObjeto, $name), $arguments);
      } else {
        throw new Exception("Método {$name} não encontrado para a entidade " . get_class($this->oObjeto));
      }
    }
  }
}