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
 * Classe auxiliar para geração de Validações Captchas no sistema
 *
 * @category Captcha
 * @package Lib/DBSeller
 * @see Lib_DBSeller_Plugin_Captcha
 * @author Davi Busanello <davi@dbseller.com.br>
 */
class DBSeller_Plugin_Captcha extends Zend_Form_Element_Captcha{

  public function __construct() {

    $oBaseUrl = new Zend_View_Helper_BaseUrl();
    $sCaptchaUrl = $oBaseUrl->baseUrl('tmp/captcha');

    parent::__construct('Captcha',
                        array(
                          'captcha' => array(
                            'captcha' => 'Image',
                            'wordlen' => 6,
                            'imgUrl' => $sCaptchaUrl,
                            'imgdir' => PUBLIC_PATH . "/tmp/captcha",
                            'gcfreq' => 10,
                            // 'expiration' => 60,
                            'timeout' => 15,
                            'height' => 45,
                            'width' => 200,
                            'linenoiselevel' => 3,
                            'dotnoiselevel' => 2,
                            'fontsize' => 20,
                            'font' => PUBLIC_PATH . "/default/font/FreeSansBold.ttf"
                         )
                        )
                      );

    return $this;

  }

  public function geraCaptcha() {

    parent::setWordlen(8);
    parent::setImgDir(PUBLIC_PATH . "/tmp/captcha");
    parent::setGcFreq(10);
    parent::setExpiration(30);
    parent::setHeight(35);
    parent::setWidth(200);
    parent::setLineNoiseLevel(3);
    parent::setDotNoiseLevel(2);
    parent::setFontSize(15);
    parent::setFont(PUBLIC_PATH . "/default/font/FreeSansBold.ttf");
    return parent::generate();

  }
}