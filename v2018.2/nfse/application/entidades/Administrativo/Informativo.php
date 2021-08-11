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
 * Modelo do Informativo para interação com o db
 * @author Roberto Pereira Carneiro <roberto@dbseller.com.br>
 */

namespace Administrativo;

use Doctrine\DBAL\Types\TextType;
/**
 * @Entity
 * @Table(name="informativo")
 */
class Informativo {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * 
   */
  protected $id = null;
  
  /**
   * Texto informativo
   * @var string
   * @Column(type="string")
   */
  protected $descricao = null;  

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
  public function getDescricao() {
    return $this->descricao;
  }
  
  /**
   * @param string $sDescricao
   */
  public function setDescricao($sDescricao) {
    $this->descricao = $sDescricao;
  }
}