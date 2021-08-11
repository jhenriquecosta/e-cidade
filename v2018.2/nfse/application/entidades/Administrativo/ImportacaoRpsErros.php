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
 * Importação RPS erros (Mensagens de Retorno)
 */
namespace Administrativo;

/**
 * @Entity
 * @Table(name="importacao_rps_erros")
 */
class ImportacaoRpsErros {
  
 /**
  * @var int
  * @Id
  * @Column(type="integer")
  */
 protected $id = NULL;
 
  /**
   * @var int
   * @Column(type="integer")
   */
  protected $modelo = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $codigo_erro = NULL;
  
  /**
   * @var string
   * @Column(type="string")
   */
  protected $mensagem = NULL;
  
  /**
   * @var string
   * @Column(type="string")
   */
  protected $solucao = NULL;
  
  /**
   * Retorna o código modelo de importação
   * 
   * @return string
   */
  public function getModelo() {
    return $this->modelo;
  }

  /**
   * Define o código modelo de importação
   * 
   * @param string $sModelo
   */
  public function setModelo($sModelo) {
    $this->modelo = $sModelo;
  }

  /**
   * Retorna Código do Erro
   * 
   * @return string
   */
  public function getCodigoErro() {
    return $this->codigo_erro;
  }

  /**
   * Define o Código do Erro
   * 
   * @param string $sCodigoErro
   */
  public function setCodigoErro($sCodigoErro) {
    $this->codigo_erro = $sCodigoErro;
  }

  /**
   * Retorna a Mensagem de erro
   * 
   * @return string
   */
  public function getMensagem() {
    return $this->mensagem;
  }
  
  /**
   * Define a mensagem de erro
   * 
   * @param string $sMensagem
   */
  public function setMensagem($sMensagem) {
    $this->mensagem = $sMensagem;
  }

  /**
   * Retorna a solução do erro
   * 
   * @return string
   */
  public function getSolucao() {
    return $this->solucao;
  }
  
  /**
   * Define a solução do erro
   * 
   * @param string $sSolucao
   */
  public function setSolucao($sSolucao) {
    $this->solucao = $sSolucao;
  }
}