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
   * Class Administrativo_Model_Acao
   */
class Administrativo_Model_Acao extends E2Tecnologia_Model_Doctrine {

  static protected $entityName = "Administrativo\Acao";
  static protected $className = __CLASS__;
    
  public function getControle() {
    return new Administrativo_Model_Controle($this->entity->getControle());
  }
  
  public function persist($dados) {
    
    if (isset($dados['nome'])) 
      $this->setNome($dados['nome']);
    
    if (isset($dados['sub_acoes']))
      $this->setSubAcoes($dados['sub_acoes']);
    
    if (isset($dados['acaoacl']))
      $this->setAcaoAcl($dados['acaoacl']);

    if (isset($dados['gerador_dados']))
      $this->setGeradorDados($dados['gerador_dados']);

    $this->em->persist($this->entity);
    $this->em->flush();
  }

  
  /**
   * verifica se existe ação para determinado caminho (modulo, controle)
   * @param string $sAcao
   * @param string $sControle
   * @param string $sModulo
   * @return boolean $lReturn
   */
  public static function verificaAcaoAction ($sAcao = NULL, $sControle = NULL, $sModulo = NULL) {
    
    $aAcoes = Administrativo_Model_Acao::getAll();
    
    foreach ($aAcoes as $oAcao) {
      
      $sAcaoModulo   = trim($oAcao->getControle()->getModulo()->getIdentidade());
      $sAcaoControle = trim($oAcao->getControle()->getIdentidade());
      
      if (($sAcaoModulo != $sModulo && $sAcaoControle != $sControle) || empty($sAcao)) {
        continue;
      }
      
      if ($sModulo == $sAcaoModulo && $sControle == $sAcaoControle) {
        
        $aAcoesExtra = explode(',', trim($oAcao->getSubAcoes()));
        $aAcoesExtra = array_merge($aAcoesExtra, array(trim($oAcao->getAcaoAcl())));
        
        if (in_array($sAcao, $aAcoesExtra)) {
          return true;
        }
      }
    }
    return false;
  }
}