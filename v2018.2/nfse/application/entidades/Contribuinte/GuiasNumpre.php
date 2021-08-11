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
 * @author dbseller
 * @package Entidades\Contribuinte\GuiasNumpre
 */
namespace Contribuinte;

/**
 * @Entity
 * @Table(name="guias_numpre")
 */
class GuiasNumpre {
  
  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  protected $id = null;
  
  /**
   * @var \Contribuinte\Guia
   * @ManyToOne(targetEntity="\Contribuinte\Guia", inversedBy="guias_numpre")
   * @JoinColumn(name="id_guia", referencedColumnName="id")
   */
  protected $guia = NULL;
  
  /**
   * Numpre do débito gerado da guia
   * @Column(type="integer")
   */
  protected $numpre = NULL;
  

  /**
   * Código Unico
   * @return number
   */
  public function getId() {
    return $this->id;
  }
  
  /**
   * @return Contribuinte\Guia
   */
  public function getGuia() {
    return $this->guia;
  }
  
  /**
   * @param Contribuinte\Guia $guia
   */
  public function setGuia($guia) {
    $this->guia = $guia;
  }

  /**
   * @Column(type="integer")
   */
  public function getNumpre() {
    return $this->numpre;
  }
  
  /**
   * @param integer $iNumpre
   */
  public function setNumpre($iNumpre) {
    $this->numpre = $iNumpre;
  }
}