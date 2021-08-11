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
 * Model responsável pela abstração dos dados do Protocolo
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */
class Contribuinte_Model_Protocolo extends Contribuinte_Lib_Model_Doctrine {
  
    static protected $entityName = "Contribuinte\Protocolo";
    static protected $className  = __CLASS__;
    
    public static $TIPO_ERRO    = 1;
    public static $TIPO_SUCESSO = 2;
    public static $TIPO_AVISO   = 3;

    /**
     * Tipo de mensagem
     * @var array
     */
    private static $aTiposProtocolo = array(
        1 => "Erro",
        2 => "Sucesso",
        3 => "Aviso"
    );
    
    /**
     * Retorna a descrição do tipo de mensagem
     * @param integer $iTipo
     * @return string
     */
    public function retornaDescricaoTipo($iTipo) {
      return self::$aTiposProtocolo[$iTipo];
    }

  /**
   * Cria um novo protocolo
   * @param int  $iTipo
   * @param string $sMensagem
   * @param null $sCaminhoSistema
   * @return null|object
   * @throws Exception
   */
  public function criaProtocolo($iTipo = 3, $sMensagem, $sCaminhoSistema = NULL) {
      
      if (!$sMensagem) {
        throw new Exception('Informe uma mensagem!');
      }
      
      if (empty(self::$aTiposProtocolo[$iTipo])) {
        throw new Exception('Tipo de Protocolo está inválido!');
      }
      
      try {
        
        /**
         * Monta a rota executada pelo sistema
         */
        if (empty($sCaminhoSistema)) { 
          
          $sSistemaEmUso   = Zend_Controller_Front::getInstance()->getRequest();
          $sCaminhoSistema = $sSistemaEmUso->getModuleName()     . '/' .
                             $sSistemaEmUso->getControllerName() . '/' .
                             $sSistemaEmUso->getActionName();
        }
        
        $oDataProcessamento = new DateTime();
        $sLoginUsuario      = Zend_Auth::getInstance()->getIdentity();
        $oUsuario           = Administrativo_Model_Usuario::getByAttribute('login', $sLoginUsuario['login']);
        $sData              = $oDataProcessamento->format('Y-m-d\TH:i:s');
        $sCodigoProtocolo   = SHA1(rand() . $sData . $oUsuario->getId() . time());
        
        $this->setProtocolo($sCodigoProtocolo);
        $this->setTipo($iTipo);
        $this->setMensagem(trim($sMensagem));
        $this->setSistema(trim($sCaminhoSistema));
        $this->setUsuario($oUsuario->getEntity());
        $this->setDataProcessamento($oDataProcessamento);
        
        $this->getEm()->persist($this->getEntity());
        $this->getEm()->flush();
      } catch (Exception $oErro) {
        throw new Exception($oErro->getMessage());
      }
      
      return $this->getEntity();
    }

  /**
   * Retornar os dados no formato de um array associativo
   * @return array
   */
  public function toArray() {

      $oProtocolo = $this->getEntity();
      $oUsuario   = $oProtocolo->getUsuario();
      $aDadosProtocolo = array(
        'id'                 => $oProtocolo->getId(),
        'protocolo'          => $oProtocolo->getProtocolo(),
        'tipo'               => $oProtocolo->getTipo(),
        'descricao_tipo'     => $this->retornaDescricaoTipo($oProtocolo->getTipo()),
        'mensagem'           => $oProtocolo->getMensagem(),
        'sistema'            => $oProtocolo->getSistema(),
        'data_processamento' => $oProtocolo->getDataProcessamento()->format('d/m/Y'),
        'usuario'            => array(
          'id'   => $oUsuario->getId(),
          'nome' => $oUsuario->getNome()
        )
      );

      return $aDadosProtocolo;
    }
}