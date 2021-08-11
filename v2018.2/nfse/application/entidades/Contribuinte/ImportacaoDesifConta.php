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
 * Entidade da tabela 'importacao_desif_contas'
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
namespace Contribuinte;

/**
 * @Entity
 * @Table(name="importacao_desif_contas")
 */
class ImportacaoDesifConta {

  /**
   * @var int
   * @Id
   * @OneToMany(targetEntity="ImportacaoDesifConta", mappedBy="parent")
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @var \Administrativo\UsuarioContribuinte
   * @OneToOne(targetEntity="\Administrativo\UsuarioContribuinte")
   * @JoinColumn(name="id_contribuinte", referencedColumnName="id")
   */
  protected $contribuinte = NULL;

  /**
   * @ManyToOne(targetEntity="ImportacaoDesifConta", inversedBy="id")
   * @JoinColumn(name="id_importacao_desif_conta", referencedColumnName="id")
   */
  protected $importacao_desif_conta = NULL;

  /**
   * @Column(type="string") 
   */
  protected $conta = NULL;

  /**
   * @Column(type="string")
   */
  protected $nome = NULL;

  /**
   * @Column(type="string")
   */
  protected $descricao_conta = NULL;

  /**
   * @var \Contribuinte\PlanoContaAbrasf
   * @ManyToOne(targetEntity="PlanoContaAbrasf", inversedBy="importacao_desif_conta")
   * @JoinColumn(name="id_plano_conta_abrasf", referencedColumnName="id")
   **/
  protected $plano_conta_abrasf = NULL;

  /**
   * Método construtor
   */
  public function __construct() {
    $this->id = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Altera o id da conta
   * @param integer $iId
   */
  public function setId($iId) {
    $this->id = $iId;
  }
  
  /**
   * Retorna o id da conta
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return \Administrativo\UsuarioContribuinte
   */
  public function getContribuinte() {
    return $this->contribuinte;
  }

  /**
   * @param \Administrativo\UsuarioContribuinte $oContribuinte
   */
  public function setContribuinte(\Administrativo\UsuarioContribuinte $oContribuinte) {

    $this->contribuinte = $oContribuinte;
  }

  /**
   * @return ImportacaoDesifConta
   */
  public function getImportacaoDesifConta() {
    return $this->importacao_desif_conta;
  }

  /**
   * @param ImportacaoDesifConta $oImportacaoDesifConta
   */
  public function setImportacaoDesifConta(\Contribuinte\ImportacaoDesifConta $oImportacaoDesifConta) {

    $this->importacao_desif_conta = $oImportacaoDesifConta;
  }

  /**
   * Altera o código da conta
   * @param string $sConta
   */
  public function setConta($sConta) {
    $this->conta = $sConta;
  }
  
  /**
   * Retorna o código da conta
   * @return string
   */
  public function getConta() {
    return $this->conta;
  }
  
  /**
   * Altera o nome da conta
   * @param string $sNome
   */
  public function setNome($sNome) {
    $this->nome = $sNome;
  }
  
  /**
   * Retorna o nome da conta
   * @return string
   */
  public function getNome() {
    return $this->nome;
  }

  /**
   * Altera a descrição da conta
   * @param string $sDescricaoConta
   */
  public function setDescricaoConta($sDescricaoConta) {
    $this->descricao_conta = $sDescricaoConta;
  }
  
  /**
   * Retorna a descrição da conta
   * @return string
   */
  public function getDescricaoConta() {
    return $this->descricao_conta;
  }
  
  /**
   * Retorna conta vinculada do plano de contas da abrasf
   * @return \Contribuinte\PlanoContaAbrasf
   */
  public function getPlanoContaAbrasf() {
    return $this->plano_conta_abrasf;
  }
  
  /**
   * Altera Conta do plano de contas da abrasf a ser vinculada
   * @param \Contribuinte\PlanoContaAbrasf $oPlanoContaAbrasf
   */
  public function setPlanoContaAbrasf(\Contribuinte\PlanoContaAbrasf $oPlanoContaAbrasf) {
  
    $this->plano_conta_abrasf = $oPlanoContaAbrasf;
  }
}