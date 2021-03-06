<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2015  DBseller Servicos de Informatica
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

require_once (modification("libs/db_stdlib.php"));
require_once (modification("libs/db_utils.php"));
require_once (modification("libs/db_app.utils.php"));
require_once (modification("libs/db_conecta.php"));
require_once (modification("libs/db_sessoes.php"));
require_once (modification("dbforms/db_funcoes.php"));
require_once (modification("libs/JSON.php"));

$oJson       = new services_json(0, true);
$oParametros = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oRetorno           = new stdClass();
$oRetorno->erro     = false;
$oRetorno->sMessage = null;

try {

  switch ($oParametros->sExecucao) {

    case "geralFinanceiraDebitosRequest":

      // Remove indice sExecucao do array de debitos
      unset($oParametros->sExecucao);

      $oGetalFinanceiraDebitos = new GeralFinanceiraDebitosRequest();

      // Armazena a requisicao dos debitos
      $oGetalFinanceiraDebitos->setDebitos($oParametros);

      // DEBUG PARA VISUALIZAR A MANUTEN??O DAS INFORMA??ES ENCAPSULADAS NA SESSION
      // file_put_contents('/var/www/dbportal_prj/tmp/debug.log', print_r($_SESSION, true));
      // $oGetalFinanceiraDebitos->clearDebitos();
      // file_put_contents('/var/www/dbportal_prj/tmp/debug2.log', print_r($_SESSION, true));

      break;

    case "getDadosBoleto":

      $oReciboPago = new ReciboPago;

      $aReciboPago = $oReciboPago->getDadosBoleto($oParametros->iNumpre, $oParametros->iNumpar, $oParametros->iReceit);
      
      $oDados = new stdClass();
      $oDados->aLinhas = $aReciboPago;

      $oRetorno->oDados = DBString::utf8_encode_all($oDados);
      break;
  }

} catch (Exception $oErro){

  $oRetorno->erro = true;
  $oRetorno->sMensagem = urlencode($oErro->getMessage());
}

echo $oJson->encode($oRetorno);