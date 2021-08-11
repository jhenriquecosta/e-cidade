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


namespace Administrativo;

/**
 * @Entity
 * @Table(name="versoes")
 * @HasLifecycleCallbacks
 */
class Versao {

  /**
   * Versao do e-CidadeOnline2
   * @Id
   * @var string
   * @Column(type="string")
   */
  protected $ecidadeonline2 = null;

  /**
   * Versao do e-Cidade (dbportal)
   * @var string
   * @Column(type="string")
   */
  protected $ecidade = null;

  /**
   * @return string
   */
  public function getVersaoEcidadeOnline2() {
    return $this->ecidadeonline2;
  }

  /**
   * @param string $ecidadeonline2
   */
  public function setEcidadeonline2($ecidadeonline2) {

    $this->ecidadeonline2 = $ecidadeonline2;
  }

  /**
   * @return string
   */
  public function getVersaoEcidade() {
    return $this->ecidade;
  }

  /**
   * @param string $ecidade
   */
  public function setEcidade($ecidade) {

    $this->ecidade = $ecidade;
  }
}