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
 * Classe que controla as notificacoes de um usuario
 *
 * @author guilherme
 */
class Default_Model_Notificacao  {
    
  /**
   * Usuario que quer ler as notificacoes
   * @var Administrativo_Model_Usuario
   */
  private $usuario = null;
  
  /**
   * Tipo da notificacao
   * @var string
   */
  private $tipo = null;
  
  /**
   * Objeto relacionado a notificacao
   * @var type 
   */
  private $objeto = null;
  
  /**
   * @param Administrativo_Model_Usuario $usuario Usuario que quer ler suas notificacoes
   */
  public function __construct(Administrativo_Model_Usuario $usuario, $tipo, $objeto) {
    $this->usuario = $usuario;
    $this->tipo = $tipo;
    $this->objeto = $objeto;
  }
  
  /**
   * La todas as notificacoes referentes ao usuario
   * @param Administrativo_Model_Usuario $usuario
   */
  public static function getNotificacoesUsuario(Administrativo_Model_Usuario $usuario) {
    
    $notificacoes = array();
    
    if ($usuario->getAdministrativo()) {
      
      $notificacoes = array_merge(self::getNotificacoesCadastro($usuario), 
                                  self::getNotificacoesRequisicaoRps($usuario));
      }
      
    return $notificacoes;
  }
  
  /**
   * La as notificacoes referentes ao cadastro pendentes
   * @param Administrativo_Model_Usuario $usuario
   */
  public static function getNotificacoesCadastro($usuario) {
    $cadastros = Administrativo_Model_Cadastro::getAll();                
    return self::arrayToNotificacao($usuario, $cadastros, 'CADASTRO');
  }

   /**
   * La as notificacoes referentes a requisicao de RPS
   * @param Administrativo_Model_Usuario $usuario
   */
  public static function getNotificacoesRequisicaoRps($usuario) {
    $requisicoes = Administrativo_Model_Aidof::getRequisicoesPendentes(null,'r');
    return self::arrayToNotificacao($usuario, $requisicoes, 'REQUISICAO RPS');
  }
  
  /**
   * Gera um vetor de notificacoes baseado no argumento $vetor
   * @param Administrativo_Model_Usuario $usuario
   * @param array $vetor
   * @param string $tipo
   * @return Default_Model_Notificacao[]
   */
  private static function arrayToNotificacao($usuario,$vetor,$tipo) {
    
    $notificacoes = array();
    
    foreach($vetor as $v) {
      $notificacoes[] = new Default_Model_Notificacao($usuario,$tipo,$v);
    }
    return $notificacoes;
  }
  
  public function getUsuario() {
    return $this->usuario;
  }
  
  public function getTipo() {
    return $this->tipo;
  }
  
  public function getObjeto() {
    return $this->objeto;
  }
  
  public function getStatus() {
    
    $status = '';
    
    switch ($this->getTipo()) {
      case 'CADASTRO':
          $status = $this->getObjeto()->getNome();
          break;
          
      case 'REQUISICAO NOTA':
          $contribuinte = $this->getObjeto()->getContribuinte();
          $status = $contribuinte->attr('nome');
          break;
          
      case 'REQUISICAO RPS':
          $contribuinte =$this->getObjeto()->getContribuinte();
          $status = $contribuinte->attr('nome');
          break;
          
      default:
          $status = '--';
          break;
    }        
    
    return $status;
  }
  
  public function getUrl() {
    $url = '';
    
    switch($this->getTipo()) {
      case 'CADASTRO':
          $url = 'administrativo/cadastro/editar/id/' . $this->getObjeto()->getId();
          break;
          
      case 'REQUISICAO NOTA':
          $url = 'administrativo/liberacao/index/req/' . $this->getObjeto()->getId();
          break;
          
      case 'REQUISICAO RPS':
          $url = 'administrativo/liberacao/rps/req/' . $this->getObjeto()->getId();
          break;
          
      default:
          $url = '#';
          break;
    }        
    
    return $url;
  }
}