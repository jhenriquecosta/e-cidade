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

class DBSeller_Helper_Mail_Mail {

  /**
   * Envia Email
   *
   * @param string $_to
   * @param string $_subject
   * @param string $_message
   * @param string $_encodeType
   * @example
   *   DBSeller_Helper_Mail_Mail::send('destinatario@email.com', 'Assunto', 'Mensagem');
   *
   * @return boolean
   */
  public static function send($_to = NULL, $_subject = NULL, $_message = NULL, $_encodeType = 'utf-8', $_bcc = NULL) {

    $_email = new Zend_Mail($_encodeType);

    try {

      $_email->addTo($_to);

      // Verifica se foi informado um e-mail de cópia oculta
      if (!empty($_bcc)) {
        $_email->addBcc($_bcc);
      }

      $_email->setSubject($_subject);
      $_email->setBodyHtml($_message);
      $_email->addHeader('Priority',          'urgent');
      $_email->addHeader('X-Priority',        '1');
      $_email->addHeader('X-MSMail-Priority', 'High');
      $_email->addHeader('Importance',        'High');
      $_email->send();

      return TRUE;
    } catch (Exception $e) {
      error_log($e->getMessage(), 0);
      return FALSE;

    }
  }

  /**
   * Envia Email com Anexo
   *
   * @param String $_to
   * @param String $_subject
   * @param String $_message
   * @param Array  $_atachment
   *   array(
   *     'file'    => '/LOCATION_TO_FILE/FILE.png',
   *     'type'    => 'image/png',
   *     'filename => 'teste.png'
   *   )
   * @param String $_bcc
   * @param String $_encodeType
   *
   * @example
   *   DBSeller_Helper_Mail_Mail::sendAttachment(
   *     'destinatario@email.com',
   *     'Assunto',
   *     'Mensagem'
   *     array(
   *       'location' => '/local_do_arquivo/meu_arquivo.pdf',
   *       'type'     => 'application/pdf',
   *       'filename' => 'meu_arquivo.pdf'
   *     )
   *   );
   *
   * @return Boolean
   */
  public static function sendAttachment(
    $_to          = NULL,
    $_subject     = NULL,
    $_message     = NULL,
    $_atachment   = NULL,
    $_bcc         = NULL,
    $_encodeType  = 'utf-8'
  ) {

    $_email = new Zend_Mail($_encodeType);

    try {

      $_attachment              = new Zend_Mime_Part(file_get_contents($_atachment['location']));
      $_attachment->type        = isset($_atachment['type']) ? $_atachment['type'] : 'application/pdf';
      $_attachment->disposition = Zend_Mime::DISPOSITION_INLINE;
      $_attachment->encoding    = Zend_Mime::ENCODING_BASE64;
      $_attachment->filename    = isset($_atachment['filename']) ? $_atachment['filename'] : 'file.pdf';

      // Verifica se foi informado um e-mail de cópia oculta
      if (!empty($_bcc)) {
        $_email->addBcc($_bcc);
      }

      // Mail
      $_email->addTo($_to);
      $_email->setSubject($_subject);
      $_email->setBodyHtml($_message);
      $_email->addHeader('Priority',          'urgent');
      $_email->addHeader('X-Priority',        '1');
      $_email->addHeader('X-MSMail-Priority', 'High');
      $_email->addHeader('Importance',        'High');
      $_email->addAttachment($_attachment);
      $_email->send();

      return TRUE;
    } catch (Exception $e) {
      error_log($e->getMessage(), 0);
      return FALSE;

    }
  }

  /**
   * Envia Email para o Sistema
   *
   * @param String $_to
   * @param String $_subject
   * @param String $_message
   * @param String $_encodeType
   *
   * @return Boolean
   */
  public static function sendToSystem($_to = NULL, $_subject = NULL, $_message = NULL, $_encodeType = 'utf-8') {

    $_email = new Zend_Mail($_encodeType);

    if (!defined(EMAIL_SYSTEM)) {
      throw new Exception('O email do sistema não foi configurado no arquivo INI');
    }

    try {

      $_email->addTo(EMAIL_SYSTEM);
      $_email->setReplyTo($_to);
      $_email->setSubject($_subject);
      $_email->setBodyHtml($_message);
      $_email->addHeader('Priority',          'urgent');
      $_email->addHeader('X-Priority',        '1');
      $_email->addHeader('X-MSMail-Priority', 'High');
      $_email->addHeader('Importance',        'High');
      $_email->send();

      return TRUE;
    } catch (Exception $e) {
      error_log($e->getMessage(), 0);
      return FALSE;

    }
  }
}