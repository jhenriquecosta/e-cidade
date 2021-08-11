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

namespace Contribuinte;

/**
 * @Entity
 * @Table(name="plano_contas_abrasf")
 */
class PlanoContaAbrasf {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $conta_abrasf = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $titulo_contabil_desc = NULL;

  /**
   * @var string
   * @Column(type="string")
   */
  protected $versao = NULL;

  /**
   * @var boolean
   * @Column(type="boolean")
   */
  protected $tributavel = FALSE;

  /**
   * @var boolean
   * @Column(type="boolean")
   */
  protected $obrigatorio = FALSE;

  /**
   * @param string $conta_abrasf
   */
  public function setContaAbrasf($conta_abrasf) {

    $this->conta_abrasf = $conta_abrasf;
  }

  /**
   * @return string
   */
  public function getContaAbrasf() {

    return $this->conta_abrasf;
  }

  /**
   * @param int $id
   */
  public function setId($id) {

    $this->id = $id;
  }

  /**
   * @return int
   */
  public function getId() {

    return $this->id;
  }

  /**
   * @param boolean $obrigatorio
   */
  public function setObrigatorio($obrigatorio) {

    $this->obrigatorio = $obrigatorio;
  }

  /**
   * @return boolean
   */
  public function getObrigatorio() {

    return $this->obrigatorio;
  }

  /**
   * @param string $titulo_contabil_desc
   */
  public function setTituloContabilDesc($titulo_contabil_desc) {

    $this->titulo_contabil_desc = $titulo_contabil_desc;
  }

  /**
   * @return string
   */
  public function getTituloContabilDesc() {

    return $this->titulo_contabil_desc;
  }

  /**
   * @param boolean $tributavel
   */
  public function setTributavel($tributavel) {

    $this->tributavel = $tributavel;
  }

  /**
   * @return boolean
   */
  public function getTributavel() {

    return $this->tributavel;
  }

  /**
   * @param string $versao
   */
  public function setVersao($versao) {

    $this->versao = $versao;
  }

  /**
   * @return string
   */
  public function getVersao() {

    return $this->versao;
  }
}