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


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Liberacao
 *
 * @author guilherme
 */
class Administrativo_Model_Liberacao extends E2Tecnologia_Model_Doctrine {

    static protected $entityName = "Administrativo\Liberacao";
    static protected $className = __CLASS__;

    public static function getRequisicoesPendentes($im = null) {
        $em = self::getEm();
        $params = array();

        $dql = "SELECT e FROM Administrativo\Liberacao e WHERE e.data_liberacao IS NULL";

        if ($im !== null) {
            $dql .= " AND e.im = :im";
            $params['im'] = $im;
        }
        $dql .= " ORDER BY e.id DESC";

        $result = $em->createQuery($dql)->setParameters($params)->getResult();

        $a = array();
        foreach ($result as $r) {
            $a[] = new static::$className($r);
        }
        return $a;
    }

    public static function getLiberacao($im) {
        $em = self::getEm();

        $query = $em->createQueryBuilder();
        $query->select('e');
        $query->from('Administrativo\Liberacao', "e");

        $query->where("e.im = :im");
        $query->setParameter('im', $im);
        $query->orderBy('e.id', 'DESC');
        $result = $query->getQuery()->setMaxResults(1)->getResult();
        
        if(empty($result)) {
            return null;
        }
        
        return new self::$className($result[0]);
    }

    public static function getLiberacoes($im) {
      
        $em = self::getEm();
        
        $query = $em->createQueryBuilder();
        $query->select('e');
        $query->from(static::$entityName, "e");
        $query->where("e.im = ?1");
        $query->andWhere("e.data_liberacao IS NOT NULL");
        
        $query->setParameter(1, $im);
        $query->orderBy('e.id', 'DESC');
        
        $result = $query->getQuery()->getResult();
        
        if (count($result) == 0)
          return null;
        
        $a = array();
        foreach ($result as $r) {
            $a[] = new static::$className($r);
        }
        
        return $a;
    }

    public function persist($attrs) {
        if (isset($attrs['im'])) {
            $this->setIm($attrs['im']);
        }
        if (isset($attrs['data_requisicao'])) {
            $this->setDataRequisicao($attrs['data_requisicao']);
        }
        if (isset($attrs['data_liberacao'])) {
            $this->setDataLiberacao($attrs['data_liberacao']);
        }
        if (isset($attrs['data_limite']) && $attrs['data_limite'] != '') {
            if (is_string($attrs['data_limite'])) {
                $d = explode('/', $attrs['data_limite']);
                $attrs['data_limite'] = new DateTime($d[2] . '-' . $d[1] . '-' . $d[0]);
            }
            $this->setDataLimite($attrs['data_limite']);
        } else {
            $this->setDataLimite(null);
        }
        if (isset($attrs['nota_limite']) && $attrs['nota_limite'] != '') {
            $this->setNotaLimite($attrs['nota_limite']);
        } else {
            $this->setNotaLimite(null);
        }

        $this->em->persist($this->entity);
        $this->em->flush();
    }

    public function getDataLiberacaoString() {
        if ($this->getDataLiberacao() === null)
            return "Pendente";
        return $this->getDataLiberacao()->format("d/m/Y");
    }

    public function getDataRequisicaoString() {
        if ($this->getDataRequisicao() === null)
            return "-";
        return $this->getDataRequisicao()->format("d/m/Y");
    }

    public function getDataLimiteString() {
         if ($this->getDataLimite() === null)
            return "-";
        return $this->getDataLimite()->format("d/m/Y");
    }
    
    public function getContribuinte() {
        $contribuinte = Administrativo_Model_Contribuinte::getByIm($this->getIm());
        return $contribuinte[0];
    }

    public function getStatus() {
        if ($this->getDataLiberacao() !== null) {
            if ($this->getDataLimite() != null) {
                $msg = 'Data limite modificada para: <b>' . $this->getDataLimiteString() . '</b>';
            } else {
                $msg = 'Limite de notas modificado para: <b>' . $this->getNotaLimite() . '</b>';
            }
        } else {
            $msg = "Requisição para emissão: <b>" . $this->getNotaLimite() . "</b>";
        }
        return $msg;
    }

}

?>