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

namespace ECidade\RecursosHumanos\ESocial\Migracao;

/**
 * Efetuar a migra??o das respostas de um formul?rio do Empregador para um novo layout
 *
 * @package ECidade\RecursosHumanos\ESocial\Migracao
 * @author  Andrio Costa - andrio.costa@dbseller.com.br
 */
class Empregador extends Migracao implements MigracaoInterface
{

    protected $nomeFormulario = 'Empregador';

    /**
     * Busca o ultimo preenchimento que o Empregador respondeu o formul?rio
     *
     * @param integer $codigoFormulario
     * @return \stdClass[]
     */
    public function buscarUltimoPreenchimento($codigoFormulario)
    {
        $where = " db101_sequencial = {$codigoFormulario} ";
        $group = " group by eso03_cgm";
        $campos = 'eso03_cgm as cgm, max(db107_sequencial) as preenchimento';
        $dao = new \cl_avaliacaogruporespostacgm;
        $sql = $dao->sql_avaliacao_preenchida(null, $campos, null, $where . $group);
        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos dos formul?rios dos empregadores.");
        }

        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * Cria um novo preenchimento para o Empregador
     *
     * @param \stdClass $preenchimento
     * @throws \Exception
     * @return integer
     */
    protected function criarNovoPreenchimento($preenchimento)
    {
        $novoPreenchimento = parent::criarNovoPreenchimento($preenchimento);

        $dao = new \cl_avaliacaogruporespostacgm;
        $dao->eso03_avaliacaogruporesposta = $novoPreenchimento;
        $dao->eso03_cgm = $preenchimento->cgm;
        $dao->incluir(null);
        if ($dao->erro_status == 0) {
            throw new \Exception("Ocorreu um erro ao vincular o cgm ao question?rio.");
        }

        return $novoPreenchimento;
    }
}
