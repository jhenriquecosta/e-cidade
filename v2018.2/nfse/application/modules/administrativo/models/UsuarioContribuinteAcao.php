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


class Administrativo_Model_UsuarioContribuinteAcao extends E2Tecnologia_Model_Doctrine {

    static protected $entityName = "Administrativo\\UsuarioContribuinteAcao";
    static protected $className = __CLASS__;

    public static function getByUsuarioContribuinteAcao($usuario, $contribuinte, $acao) {
        $em = parent::getEm();
        
        $query = $em->createQueryBuilder();
        $query->select('uca')
                ->from(self::$entityName, 'uca')
                ->join('uca.usuario_contribuinte', 'uc');

        if ($usuario !== null) {
            $query->andWhere('uc.usuario = ' . $usuario->getId());
        }
        if ($acao !== null) {
            $query->andWhere('uca.acao = ' . $acao->getId());
        }
        if ($contribuinte !== null) {
            $query->andWhere('uc.im = ' . $contribuinte);
        }

        $r = $query->getQuery()->getResult();  
        return $r;
        
    }

    public function persist(array $attrs) {

      $this->entity->setUsuarioContribuinte($attrs['usuario_contribuinte']);
      $this->entity->setAcao($attrs['acao']);
      $this->em->persist($this->entity);
      $this->em->flush();
    }

    public function remove() {

      $this->em->remove($this->entity);
      $this->em->flush();
    }
}