<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2016  DBSeller Servicos de Informatica
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
 *  $Id: pes1_faixavaloresirrf001.php,v 1.4 2016/06/30 17:49:54 dbrenan.silva Exp $
 */
require_once modification("libs/db_stdlib.php");
require_once modification("libs/db_conecta.php");
require_once modification("libs/db_sessoes.php");
require_once modification("libs/db_usuariosonline.php");
require_once modification("libs/db_app.utils.php");
require_once modification("libs/db_utils.php");
require_once modification("dbforms/db_funcoes.php");
define("M", "recursoshumanos.pessoal.pes1_faixavaloresirrf.");
$oGet      = db_utils::postMemory($_GET);
$oPost     = db_utils::postMemory($_POST);
$db_opcao  = 1;

$sFonteRedireciona  = "pes1_faixavaloresirrf002.php";

require_once("forms/db_frmfaixavaloresirrf.php");

try {
/**
 * Inclus?o
 */
 if(isset($oPost->db149_descricao)){

   db_inicio_transacao();
   $oDaoTabelaValores = new cl_db_tabelavalores();
   $oDaoTabelaValores->db149_descricao            = $oPost->db149_descricao;
   $oDaoTabelaValores->db149_db_tabelavalorestipo = 2;
   $oDaoTabelaValores->incluir(null);

   if($oDaoTabelaValores->erro_status == "0") {
     throw new DBException(_M(M."erro_incluir_tabela"));
   }
   db_fim_transacao(false);

   db_msgbox(_M(M."tabela_incluida"));
   $sDescricao = urlencode($oDaoTabelaValores->db149_descricao);
   db_redireciona("pes1_faixavaloresirrf002.php?db149_sequencial={$oDaoTabelaValores->db149_sequencial}&db149_descricao={$sDescricao}");
   }
} catch(\Exception $e) {
  db_fim_transacao(true);
  db_msgbox($e->getMessage());
}
