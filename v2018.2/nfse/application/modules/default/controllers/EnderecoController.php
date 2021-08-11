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
 * Controle para Endereco
 */
class Default_EnderecoController extends Default_Lib_Controller_AbstractController {

  public function init() {
    parent::init();
  }
  
  /**
   * Retorna lista dos municipios pela uf dos estados
   * 
   * @param string $uf
   * @return JSON $lista[] Lista de cidades array(cidades "nome" => "nome")
   */
  public function getMunicipiosAction() {
    
    $sUf      = $this->_getParam('uf');
    $aCidades = Default_Model_Cadendermunicipio::getByEstado($sUf);
    
    echo $this->getHelper('json')->sendJson($aCidades);
  }
    
  /**
   * Retorna lista dos estados
   *
   * @param string $cod
   * @return JSON
   */
  public function getEstadosAction() {
    
    $bacen    = $this->getRequest()->getParam('cod');
    $estados  = Default_Model_Cadenderestado::getEstados($bacen);
    
    echo $this->getHelper('json')->sendJson($estados);
  }
    
  /**
   * Retorna lista dos bairros
   *
   * Aviso:
   * - Se o codigo da prefeitura for igual retorna parametro para mostrar campo texto
   *
   * @param string $municipio
   * @return JSON $aBairros[]
   */
  public function getBairrosAction() {
    
    $iCodigoIbge = Administrativo_Model_Prefeitura::getDadosPrefeituraBase()->getIbge();
    $iMunicipio  = $this->_getParam('municipio', NULL);
    
    if ($iCodigoIbge == $iMunicipio) {
      
      $aBairros  = Default_Model_Cadenderbairro::getBairros($iMunicipio);
      
      echo $this->getHelper('json')->sendJson($aBairros);
    } else {
      echo $this->getHelper('json')->sendJson(array('mostra_campo_texto' => TRUE));
    }
  }
  
  /**
   * Retorna lista de todos os enderecos
   *
   * @return JSON $aEnderecos[]
   */
  public function getEnderecosAction() {
    
    $aEnderecos = Default_Model_Cadenderrua::getRuas();
    
    echo $this->getHelper('json')->sendJson($aEnderecos);
  }
}