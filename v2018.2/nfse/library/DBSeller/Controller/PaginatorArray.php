<?php
/**
 * E-cidade Software Publico para Gestão Municipal
 *   Copyright (C) 2014 DBSeller Serviços de Informática Ltda
 *                          www.dbseller.com.br
 *                          e-cidade@dbseller.com.br
 *   Este programa é software livre; você pode redistribuí-lo e/ou
 *   modificá-lo sob os termos da Licença Pública Geral GNU, conforme
 *   publicada pela Free Software Foundation; tanto a versão 2 da
 *   Licença como (a seu critério) qualquer versão mais nova.
 *   Este programa e distribuído na expectativa de ser útil, mas SEM
 *   QUALQUER GARANTIA; sem mesmo a garantia implícita de
 *   COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
 *   PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
 *   detalhes.
 *   Você deve ter recebido uma cópia da Licença Pública Geral GNU
 *   junto com este programa; se não, escreva para a Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *   02111-1307, USA.
 *   Cópia da licença no diretório licenca/licenca_en.txt
 *                                 licenca/licenca_pt.txt
 */

/**
 *
 * Classe responsável pela paginação de arrays
 *
 * @package DBSeller/Controller
 * @implements Zend_Paginator_Adapter_Interface
 */
class DBSeller_Controller_PaginatorArray implements Zend_Paginator_Adapter_Interface {

  private $aItens = array();

  /**
   * Constroi o objeto da classe e adiciona a quantidade total dos itens
   *
   * @param $aItens
   * @return \DBSeller_Controller_PaginatorArray
   */
  public function __construct($aItens) {

    // Força a sempre passar um array
    if (!is_array($aItens)) {
      $aItens = array();
    }

    $this->aItens = $aItens;
  }

  /**
   * Retorna os itens pagionados de acordo com o offset informado
   * @param int $offset quantidade de itens iniciais do array
   * @param int $itemCountPerPage quantidade de itens por página
   * @return array
   */
  public function getItems($offset, $itemCountPerPage) {

     $aItens          = $this->aItens;
     $aItensPaginados = array_slice($aItens, $offset, $itemCountPerPage);
     return $aItensPaginados;
  }

  /**
   * Retorna o Total de itens no paginator
   * @return int
   */
  public function count() {
    return count($this->aItens);
  }
}