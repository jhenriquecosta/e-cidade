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
 * Model Responsável por retornar os erros da importacao Rps 
 * seguindo as mensagens de retorno definidas em manuais
 *
 * @author  dbeverton.heckler
 * @package Administrativo/Models
 */
class Administrativo_Model_ImportacaoRpsErros extends Global_Lib_Model_Doctrine {

  static protected $entityName = "Administrativo\ImportacaoRpsErros";
  static protected $className = __CLASS__;
  
  /**
   * Retorna os erros cadastrados por Código de Modelo
   * 
   * @param integer $iCodigoModelo
   * @throws Exception
   * @return array
   */
  public static function getMensagensPorModelo($iCodigoModelo) {

    if (empty($iCodigoModelo) || !is_int($iCodigoModelo)) {
      throw new Exception('Código de Modelo Informado está inválido');
    }
    
    $aDadosMensagemErro = self::getByAttribute('modelo', $iCodigoModelo, '=', self::TIPO_RETORNO_ARRAY);
  
    unset($aRetornoMensagens);
    
    foreach ($aDadosMensagemErro as $oDadosMensagemErro) {
      
      $aRetornoMensagens[$oDadosMensagemErro['codigo_erro']]->sMensagem = $oDadosMensagemErro['mensagem'];
      $aRetornoMensagens[$oDadosMensagemErro['codigo_erro']]->sSolucao  = $oDadosMensagemErro['solucao'];
    }
    
    return $aRetornoMensagens;
  }
}