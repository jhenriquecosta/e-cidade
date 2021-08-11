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
 * @Table(name="protocolo")
 * @HasLifecycleCallbacks
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Protocolo {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = null;

  /**
   * Código do protocolo
   * @var string
   * @Column(type="string")
   */
  protected $protocolo = null;

  /**
   * Tipo da mensagem retornada
   * @var integer
   * @Column(type="integer")
   */
  protected $tipo = null;

  /**
   * Mensagem retornada
   * @var string
   * @Column(type="string")
   */
  protected $mensagem = null;

  /**
   * Sistema onde foi gerado
   * @var string
   * @Column(type="string")
   */
  protected $sistema = null;

  /**
   * @var Usuario
   * @ManyToOne(targetEntity="Administrativo\Usuario", inversedBy="protocolo")
   * @JoinColumn(name="id_usuario", referencedColumnName="id")
   **/
  protected $usuario = null;
  
  /**
   * Data do processamento
   * @var string
   * @Column(type="datetime")
   */
  protected $data_processamento = null;

  /**
   * @return number
   */
  public function getId() {
    return $this->id;
  }
  
  /**
   * @param integer $iId
   */
  public function setId($iId) {
    $this->id = $iId;
  }
  
  /**
   * @return string
   */
  public function getProtocolo() {
    return $this->protocolo;
  }
  
  /**
   * @param string $sProtocolo
   */
  public function setProtocolo($sProtocolo) {
    $this->protocolo = $sProtocolo;
  }
  
  /**
   * @return integer
   */
  public function getTipo() {
    return $this->tipo;
  }
  
  /**
   * @param integer $iTipo
   */
  public function setTipo($iTipo) {
    $this->tipo = $iTipo;
  }
  
  /**
   * @return string
   */
  public function getMensagem() {
    return $this->mensagem;
  }
  
  /**
   * @param string $sMensagem
   */
  public function setMensagem($sMensagem) {
    $this->mensagem = $sMensagem;
  }
  
  /**
   * @return string
   */
  public function getSistema() {
    return $this->sistema;
  }
  
  /**
   * @param string $sSistema
   */
  public function setSistema($sSistema) {
    $this->sistema = $sSistema;
  }
  
  /**
   * @return \Administrativo\Usuario
   */
  public function getUsuario() {
    return $this->usuario;
  }

  /**
   * @param \Administrativo\Usuario $usuario Instancia da entidade Administrativo\Usuario
   */
  public function setUsuario(\Administrativo\Usuario $usuario) {
    $this->usuario = $usuario;
  }
  
  /**
   * @return string
   */
  public function getDataProcessamento() {
    return $this->data_processamento;
  }
  
  /**
   * @param date $sDataProcessamento
   */
  public function setDataProcessamento($sDataProcessamento) {
    $this->data_processamento = $sDataProcessamento;
  }
}