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
 * Modelo responsável pelo Tipo de Usuário
 * @author Everton Heckler <dbeverton.heckler>
 */
class Administrativo_Model_TipoUsuario {

  /**
   * Tipo de usuário contribuinte
   * @var integer
   */
  public static $CONTRIBUINTE   = 1;
  public static $CONTADOR       = 2;
  public static $ADMINISTRATIVO = 3;
  
  /**
   * Lista com os tipos de usuário
   * @var array
   */
  private static $lista = array(
    1 => "Contribuinte",
    2 => "Contador",
    3 => "Administrativo/Fiscal"
  );

  /**
   * Retorna a lista com os tipos de usuário
   * @return array
   */
  public static function getLista() {
    return self::$lista;
  }

  /**
   * Retonar a descrição do tipo de usuário
   * @param integer $id
   * @return string
   */
  public static function getById($id) {
    return self::$lista[$id];
  }
}