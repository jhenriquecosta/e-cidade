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
 */

/**
 * Classe responsável pelas atualizações existentes no sistema
 *
 * @package Default/Controllers
 * @author Luiz Marcelo Schmitt <luiz.marcelo@dbseller.com.br>
 */

class Default_AtualizacaoController extends Default_Lib_Controller_AbstractController {


  private $versoes = array(
                        '1-5-0' => '1.5.0',
                        '1-6-0' => '1.6.0',
                        '1-7-0' => '1.7.0',
                        '1-8-0' => '1.8.0',
                        '1-9-0' => '1.9.0',
                        '1-10-0' => '1.10.0',
                        '1-11-0' => '1.11.0',
                        '1-12-0' => '1.12.0',
                        '1-15-0' => '1.15.0',
                        '1-16-0' => '1.16.0'
                        );
  /**
   * Mostra as atualizações existentes da versão
   */
  public function versaoAction() {

    $pVersao = $this->getRequest()->getParam('v');

    $this->view->versoes = $this->versoes;

    if (!is_null($pVersao)) {
      $this->_helper->viewRenderer('versao-'. $pVersao);
    } else {
      end($this->versoes);
      $this->_helper->viewRenderer('versao-'. key($this->versoes));
    }

  }
}