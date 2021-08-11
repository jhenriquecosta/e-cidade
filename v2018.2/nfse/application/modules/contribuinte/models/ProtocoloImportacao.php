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
 * Model responsável pelo vinculo dos dados entre o Protocolo e a Importação
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Contribuinte_Model_ProtocoloImportacao extends Administrativo_Lib_Model_Doctrine {
  
  static protected $entityName = 'Contribuinte\ProtocoloImportacao';
  static protected $className  = __CLASS__;

  /**
   * Salva os dados do protocolo importacao
   * @throws Exception
   */
  public function persist() {

      $this->em->persist($this->getEntity());
      $this->em->flush();
  }


  public function getNotasImportadas() {

    $aNotas = array();

    /**
    $oQueryImportacao = $this->getEm()->createQueryBuilder();
    $oQueryImportacao->select('impdoc')
                     ->from('Contribuinte\ImportacaoArquivo', 'ia')
                     ->join('Contribuinte\ImportacaoArquivoDocumento', 'impdoc')
                     ->where("ia.id = {$this->getEntity()->getImportacao()}");

    return $oQueryImportacao->getQuery()->getResult();
     */
    $oImportacao = $this->getEntity()->getImportacao();

    foreach ($oImportacao->getImportacaoArquivoDocumentos() as $oDocumento) {

      $aNotaEntity = $oDocumento->getNotas();
      if (count($aNotaEntity) > 0) {
        $aNotas[] = new Contribuinte_Model_Nota($aNotaEntity[0]);
      }
    }
    return $aNotas;
  }
}