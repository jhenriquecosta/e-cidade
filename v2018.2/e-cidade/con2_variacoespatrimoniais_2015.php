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
require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'fpdf151/assinatura.php';
require_once 'libs/db_utils.php';
require_once 'libs/db_app.utils.php';
require_once 'dbforms/db_funcoes.php';
require_once 'libs/db_libcontabilidade.php';
require_once 'libs/db_liborcamento.php';
require_once 'fpdf151/PDFDocument.php';

$oGet = db_utils::postMemory($_GET);
try {

  if (empty($oGet->db_selinstit)) {
    throw new Exception("Institui??o n?o informada.");
  }

  if (empty($oGet->periodo)) {
    throw new Exception("Per?odo n?o informado.");
  }

  if (empty($oGet->codrel)) {
    throw new Exception("C?digo do relat?rio n?o informado.");
  }

  if (empty($oGet->tipoImpressao)) {
    throw new Exception("Tipo de impress?o n?o informado.");
  }

  if ($oGet->tipoImpressao != VariacaoPatrimonialDCASP2015::TIPO_ANALITICO
      && $oGet->tipoImpressao != VariacaoPatrimonialDCASP2015::TIPO_SINTETICO) {
    throw new Exception("O tipo de impress?o informado ? inv?lido.");
  }

  $lImprimirExercicioAnterior = false;
  if (isset($oGet->imprimirValorExercicioAnterior)) {
    $lImprimirExercicioAnterior = $oGet->imprimirValorExercicioAnterior === "true";
  }

  $oRelatorio = new VariacaoPatrimonialDCASP2015(db_getsession('DB_anousu'), $oGet->codrel, $oGet->periodo);
  $oRelatorio->setInstituicoes(str_replace('-', ',', $oGet->db_selinstit));
  $oRelatorio->setImprimirExercicioAnterior($lImprimirExercicioAnterior);
  $oRelatorio->setTipo($oGet->tipoImpressao);
  $oRelatorio->emitir();

} catch (Exception $e) {
  db_redireciona("db_erros.php?db_erro=" . $e->getMessage());
}