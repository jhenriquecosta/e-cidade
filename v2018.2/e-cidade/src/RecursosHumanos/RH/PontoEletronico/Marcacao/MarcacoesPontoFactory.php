<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2016  DBseller Servicos de Informatica
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

namespace ECidade\RecursosHumanos\RH\PontoEletronico\Marcacao;

use ECidade\RecursosHumanos\RH\PontoEletronico\Marcacao\MarcacaoPonto;
use ECidade\RecursosHumanos\RH\PontoEletronico\Marcacao\MarcacaoPontoSaida;


/**
 * Classe respons?vel por montar uma cole??o de marca??es
 * Class MarcacoesPontoFactory
 * @package ECidade\RecursosHumanos\RH\PontoEletronico\Collection
 * @author Renan Silva <renan.silva@dbseller.com.br>
 */
class MarcacoesPontoFactory {

  public static function create($oMarcacao, $iTipo, $iCodigo) {

    $oInstaciaMarcacao = null;

    switch ($iTipo) {

      case MarcacaoPonto::ENTRADA_1:
      case MarcacaoPonto::ENTRADA_2:
      case MarcacaoPonto::ENTRADA_3:

        $oInstaciaMarcacao = new MarcacaoPonto($oMarcacao, $iTipo);
        $oInstaciaMarcacao->setCodigo($iCodigo);
        break;
      
      case MarcacaoPonto::SAIDA_1:
      case MarcacaoPonto::SAIDA_2:
      case MarcacaoPonto::SAIDA_3:

        $oInstaciaMarcacao = new MarcacaoPontoSaida($oMarcacao, $iTipo);
        $oInstaciaMarcacao->setCodigo($iCodigo);
        break;
    }

    return $oInstaciaMarcacao;
  }
}
