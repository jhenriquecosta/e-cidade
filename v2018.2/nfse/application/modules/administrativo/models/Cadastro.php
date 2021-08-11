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
 *
 * @author guilherme
 */
class Administrativo_Model_Cadastro extends E2Tecnologia_Model_Doctrine {
  
  static protected $entityName = "Administrativo\Cadastro";
  static protected $className = __CLASS__;
  
  public function persist($attrs = NULL) {
    
    if (is_array($attrs)) {
      
      if (isset($attrs['tipo']))
        $this->setTipo($attrs['tipo']);
      
      if (isset($attrs['cpfcnpj']))
        $this->setCpfcnpj($attrs['cpfcnpj']);
      
      if (isset($attrs['login']))
        $this->setLogin($attrs['login']);
      
      if (isset($attrs['nome']))
        $this->setNome($attrs['nome']);
      
      if (isset($attrs['nome_fantasia']))
        $this->setNomeFantasia($attrs['nome_fantasia']);
      
      if (isset($attrs['senha']))
        $this->setSenha($attrs['senha']);
      
      if (isset($attrs['estado']))
        $this->setEstado($attrs['estado']);
      
      if (isset($attrs['cidade']))
        $this->setCidade($attrs['cidade']);
      
      if (isset($attrs['cep']))
        $this->setCep($attrs['cep']);
      
      if (isset($attrs['cod_bairro']))
        $this->setCodBairro($attrs['cod_bairro']);
      
      if (isset($attrs['bairro']))
        $this->setBairro($attrs['bairro']);
      
      if (isset($attrs['cod_endereco']))
        $this->setCodEndereco($attrs['cod_endereco']);
      
      if (isset($attrs['endereco']))
        $this->setEndereco($attrs['endereco']);
      
      if (isset($attrs['numero']))
        $this->setNumero($attrs['numero']);
      
      if (isset($attrs['complemento']))
        $this->setComplemento($attrs['complemento']);
      
      if (isset($attrs['telefone']))
        $this->setTelefone($attrs['telefone']);
      
      if (isset($attrs['email']))
        $this->setEmail($attrs['email']);
      
      if (isset($attrs['status']))
        $this->setStatus($attrs['status']);
      
      if (isset($attrs['comentario']))
        $this->setComentario($attrs['comentario']);
      
    }
    
    $this->em->persist($this->entity);
    $this->em->flush();
    
  }

  /**
   * Busca por atributos
   * 
   * @author Gilton Guma
   * @param String $attrName
   * @param String $value
   * @param string $mode [Default: '=']
   * @return NULL|multitype:ObjectType
   */
  public static function getByAtrib($attrName, $value, $mode = '=') {
    
    $em = self::getEm();
    
    $query = $em->createQueryBuilder();
    $query->select('e');
    $query->from(static::$entityName, 'e');
    
    if (is_array($value)) {
      
      switch ($mode) {
      
        case 'NOT' :
          $query->where("e.{$attrName} {$mode} IN (?1)");
          $query->setParameter(1, $value);
          break;
        
        default:
          $query->where("e.{$attrName} IN (?1)");
          $query->setParameter(1, $value);
      }
      
    } else {
      
      switch ($mode) {
        
        case 'IS NULL' :
          $query->where("e.{$attrName} IS NULL");
          break;
      
        case 'IS NOT NULL' :
          $query->where("e.{$attrName} IS NOT NULL");
          break;
      
        default:
          $query->where("e.{$attrName} {$mode} ?1");
          $query->setParameter(1, $value);
          
      }
    } 
    
    $result = $query->getQuery()->getResult();
    
    if (count($result) == 0)
      return NULL;
    
    $a = array();
    
    foreach ($result as $r) {
      
      $a[] = new static::$className($r);
      
    }
    
    return $a;
  }
  
}

?>