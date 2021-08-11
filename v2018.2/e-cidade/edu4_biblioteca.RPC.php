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
require_once (modification("libs/db_stdlib.php"));
require_once (modification("libs/db_utils.php"));
require_once (modification("libs/db_app.utils.php"));
require_once (modification("libs/db_conecta.php"));
require_once (modification("libs/db_sessoes.php"));
require_once (modification("dbforms/db_funcoes.php"));
require_once (modification("libs/JSON.php"));

define('MSG_EDU4_BIBLIOTECARPC', "educacao.biblioteca.edu4_bibliotecaRPC.");

$oJson                  = new services_json();
$oParam                 = JSON::create()->parse(str_replace("\\","",$_POST["json"]));
$oRetorno               = new stdClass();
$oRetorno->iStatus      = 1;
$oRetorno->sMessage     = '';

$iDepartamento = db_getsession("DB_coddepto");

try {

  db_inicio_transacao();

  switch ($oParam->exec) {

    case "buscaCategoriaDeCarteira":

      $oRetorno->aCategorias = array();

      $sWhere  = " biblioteca.bi17_coddepto = {$iDepartamento} ";
      $sCampos = "bi07_codigo as codigo, bi07_nome as categoria ";

      $oDao = new cl_leitorcategoria;
      $sSql = $oDao->sql_query(null, $sCampos, "bi07_nome", $sWhere);
      $rs   = db_query($sSql);

      if ( !$rs ) {
        throw new DBException( _M(MSG_EDU4_BIBLIOTECARPC . "erro_buscar_categoria_carteira") );
      }

      if (pg_num_rows($rs) == 0 ) {
        throw new Exception( _M(MSG_EDU4_BIBLIOTECARPC . "nenhuma_categoria_carteira_cadastrada") );
      }

      $oRetorno->aCategorias = db_utils::getCollectionByRecord($rs);
      break;
  }

  db_fim_transacao(false);


} catch (Exception $eErro){

  db_fim_transacao(true);
  $oRetorno->iStatus  = 2;
  $oRetorno->sMessage = $eErro->getMessage();
}
$oRetorno->erro = $oRetorno->iStatus == 2;
echo JSON::create()->stringify($oRetorno);