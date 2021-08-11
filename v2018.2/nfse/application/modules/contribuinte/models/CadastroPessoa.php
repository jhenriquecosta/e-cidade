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

/**
 * Arquivo para controle da classe
 * @author Gilton Guma <gilton@dbseller.com.br>
 * @author Iuri Guntchigg <iuri@dbseller.com.br>
 */

/**
 * Classe para controle dos cadastros eventuais de pessoas no sistema.
 */
class Contribuinte_Model_CadastroPessoa extends Contribuinte_Lib_Model_Doctrine {

  static protected $entityName = 'Contribuinte\CadastroPessoa';
  static protected $className  = __CLASS__;
  
  /**
   * Libera apenas a criacao do CGM
   * @var integer
   */
  const TIPO_LIBERACAO_USUARIO = 2;
  
  /**
   * Liberacao a criacao do usuario e um novo cgm para esse cadastro
   * @var integer
   */
  const TIPO_LIBERACAO_USUARIO_CGM = 1;
  
  /**
   * Bloqueia o Cadastro do Usuario
   * @var integer
   */
  const TIPO_LIBERACAO_USUARIO_BLOQUEADO = 3;
  
  protected $oPerfil;
  
  /**
   * Instancia um novo cadastro de pessoa
   *
   * É possível instanciar os dados de três formas:
   *  não passando id: Ira construir uma instancia vazia;
   *  Um inteiro, ira instanciar os dados do cadastro pelo Id;
   *  um Instancia da entidade \Contribuinte\CadastroPessoa
   * @param mixed $mId codigo da pessa
   */
  public function __construct($mId = null) {
    
    if (!is_object($mId)) {
       
      $this->entity = new Contribuinte\CadastroPessoa();
      if (!empty($mId)) {
        
        $this->entity = parent::getEntityByPrimaryKey($mId);
        if (empty($this->entity)) {
          throw new Exception('Cadastro não existe no banco de dados.');
        }
      }
    } else {
      
      $this->entity = $mId;
    }
  }
  
  /**
   * Define o perfil do cadastro
   * @param Administrativo_Model_Perfil $oPerfil Instancia do perfil do usuario
   */
  public function setPerfil(Administrativo_Model_Perfil $oPerfil) {
    
    $this->oPerfil = $oPerfil;
    $this->entity->setPerfil($oPerfil->getEntity());
  }
  
  /**
   * Retorna o pefil vinculado ao usuario
   * @return Administrativo_Model_Perfil
   */
  public function getPerfil() {
    
    if (empty($this->oPerfil)) {
      $this->oPerfil = Administrativo_Model_Perfil::getById($this->getEntity()->getPerfil()->getId());
    }
    return $this->oPerfil;
  }
  
  
  /**
   * Seta os dados para gravar a entidade
   * @param array $aDados dados para definir os dados da entidade
   */
  public function setDadosEventual (array $aDados) {
    
    $oFiltro = new Zend_Filter_Digits();
    
    if (!empty($aDados['id_perfil'])) {
      $this->setPerfil(Administrativo_Model_Perfil::getById($aDados['id_perfil']));
    }
    
    if (!empty($aDados['cnpjcpf'])) {
      $this->setCpfcnpj($oFiltro->filter($aDados['cnpjcpf']));
    }
    
    if (!empty($aDados['nome'])) {
      $this->setNome($aDados['nome']);
    }
    if (!empty($aDados['nome_fantasia'])) {
      $this->setNomeFantasia($aDados['nome_fantasia']);
    }
    if (!empty($aDados['cep'])) {
      $this->setCep($oFiltro->filter($aDados['cep']));
    }
    if (!empty($aDados['estado'])) {
      $this->setEstado($aDados['estado']);
    }
    if (!empty($aDados['cidade'])) {
      $this->setCidade($aDados['cidade']);
    }
    if (!empty($aDados['bairro'])) {
      $this->setBairro($aDados['bairro']);
    }
    
    if (!empty($aDados['cod_bairro'])) {
      $this->setCodBairro($aDados['cod_bairro']);
    }
    
    if (!empty($aDados['endereco'])) {
      $this->setEndereco($aDados['endereco']);
    }
    
    if (!empty($aDados['cod_endereco'])) {
      $this->setCodEndereco($aDados['cod_endereco']);
    }
    
    if (!empty($aDados['numero'])) {
      $this->setNumero($aDados['numero']);
    }
    
    if (!empty($aDados['complemento'])) {
      $this->setComplemento($aDados['complemento']);
    }
    
    if (!empty($aDados['telefone'])) {
      $this->setTelefone($oFiltro->filter($aDados['telefone']));
    }
    
    if (!empty($aDados['email'])) {
      $this->setEmail($aDados['email']);
    }
    
    if (!empty($aDados['hash'])) {
      $this->setHash($aDados['hash']);
    }
    
    if (!empty($aDados['tipo_liberacao'])) {
      $this->setTipoLiberacao($aDados['tipo_liberacao']);
    }
    
    if (!empty($aDados['data_cadastro'])) {
      $this->setDataCadastro($aDados['data_cadastro']);
    } else {
      $this->setDataCadastro(new DateTime());
    }
    
    return true;
  }
  
  
  /**
   * Persiste as mundanças no banco de dados
   */
  public function persist() {
    
    self::getEm()->persist($this->getEntity());
    self::getEm()->flush();
  }
  
  /**
   * Retorna todos os cadastros eventuais que estão pendentes de liberacao
   * @return Contribuinte_Model_CadastroPessoa
   */
  public static function getCadastrosParaLiberacao() {
    
    $aCadastrosParaLiberar = self::getByAttribute('tipo_liberacao', null, 'is null');
    if (!is_array($aCadastrosParaLiberar) && $aCadastrosParaLiberar != null) {
      $aCadastrosParaLiberar = array($aCadastrosParaLiberar);
    }
    return $aCadastrosParaLiberar;
  }
  
  /**
   * Realizar a Liberacao do Cadastro para o Usuario
   * @param integer $iTipoLiberacao Tipo da Liberacao do usuario
   * @param string $sHash Hash para a liberacao do usuario
   * @return true;
   */
  public function LiberarCadastro($iTipoLiberacao, $sHash) {
    
    $this->setTipoLiberacao($iTipoLiberacao);
    $this->setHash($sHash);
    $this->persist();
    return true;
  }
  
  /**
   * Realizar o bloqueio do cadastro do usuário.
   * @param string $sJustificativa justificativa da recusa do cadastro
   * @return boolean
   */
  public function bloquearCadastro($sJustificativa) {
    
    $this->setTipoLiberacao(Contribuinte_Model_CadastroPessoa::TIPO_LIBERACAO_USUARIO_BLOQUEADO);
    $this->setHash('');
    $this->setRecusaJustificativa($sJustificativa);
    $this->persist();
    return true;
  }
  
  /**
   * Criar um hash para liberação do usuario ou para a troca de senha de acesso do mesmo
   * @throws Exception teste
   * @return string
   */
  public function criarHashParaLiberacao() {
    
    if ($this->getCpfcnpj() == '' || $this->getEmail() == '') {
      throw new Exception('Dados incompletos para a geração do código de liberação do usuário');
    }
    $sHash = hash( 'whirlpool', $this->getCpfcnpj() . time() . $this->getEmail());
    return $sHash;
  }
}