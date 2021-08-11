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
 *
 */

/**
 * Classe de tratamento de Exceptions do WebService
 *
 * @category Exception
 * @package WebService/Library
 * @see WebService_Lib_Exception
 * @author Davi Busanello <davi@dbseller.com.br>
 */
class WebService_Lib_Exception extends Zend_Exception {

/**
 * array de erros catalogados
 */
  private $aErros = array(
                          'W01' => 'Não houve retorno do WebService do E-Cidade!',
                          'W02' => 'WebService com problemas!',
                          'W03' => 'Não existe o arquivo de configuração para o WebService do E-Cidade!'
                         );

  /**
   * @param string    $sMensagem Mensagem de erro
   * @param Exception $oExcecao  null
   * @param string    $iCodErro  Código de um erro já mapeado no WebService
   */
  public function __construct($sMensagem = '', Exception $oExcecao = NULL, $iCodErro = NULL) {

    $iCodErro = (!empty($iCodErro)) ? $iCodErro : 'W500';

    if (getenv('APPLICATION_ENV') == 'development' || Zend_Registry::get('config')->webservice->logging) {

      $oDataTime    = new Zend_Date;
      $sErrorString = "{$oDataTime->toString()} - Erro {$iCodErro} - {$sMensagem} - ".self::getTraceAsString();
      file_put_contents(APPLICATION_PATH."/../logs/webservice.log", $sErrorString."\n", FILE_APPEND);
      unset($oDataTime);
    }

    if (array_key_exists($iCodErro, $this->aErros) && (empty($sMensagem) || is_null($sMensagem))) {
      $sMensagem = $this->aErros[$iCodErro];
    } else if (empty($sMensagem) || is_null($sMensagem)) {
      $sMensagem = 'Erro na comunicação com o webservice ou problema de compatibilidade de versão!';
    }

    if (version_compare(PHP_VERSION, '5.3.0', '<')) {
        parent::__construct($sMensagem, 500);
    } else {
        parent::__construct($sMensagem, 500, $oExcecao);
    }
  }
}