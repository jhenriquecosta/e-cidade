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
 * @use mpdf
 */
require_once(APPLICATION_PATH . '/../library/MPDF54/mpdf.php');

/**
 * Classe para geração de PDF
 *
 * @package DBSeller/Helper
 * @see Zend_View_Helper_Abstract
 */

/**
 * @package DBSeller/Helper
 * @see Zend_View_Helper_Abstract
 */
class DBSeller_Helper_Pdf_Pdf extends Zend_View_Helper_Abstract {

  /**
   * Construtor
   */
  public function __construct() {
    
    define('_MPDF_URI', APPLICATION_PATH . '/../library/MPDF54/');
    define('_MPDF_TEMP_PATH', TEMP_PATH . '/');
  }

  /**
   * Gerar PDF
   *
   * @param string $sHtml
   * @param string $sFilename
   * @param array  $aOptions
   * @return string
   */
  public static function renderPdf($sHtml, $sFilename, $aOptions) {
  
    $aOptions['margins']['left']   = isset($aOptions['margins']['left'])    ? $aOptions['margins']['left']   : 5;
    $aOptions['margins']['right']  = isset($aOptions['margins']['right'])   ? $aOptions['margins']['right']  : 5;
    $aOptions['margins']['top']    = isset($aOptions['margins']['top'])     ? $aOptions['margins']['top']    : 5;
    $aOptions['margins']['bottom'] = isset($aOptions['margins']['bottom'])  ? $aOptions['margins']['bottom'] : 5;
    $aOptions['margins']['header'] = isset($aOptions['margins']['header'])  ? $aOptions['margins']['header'] : 5;
    $aOptions['margins']['footer'] = isset($aOptions['margins']['footer'])  ? $aOptions['margins']['footer'] : 5;
    $aOptions['format']            = isset($aOptions['format'])             ? $aOptions['format']            : 'A4-L';
    $aOptions['output']            = isset($aOptions['output'])             ? $aOptions['output']            : 'D';
  
    /**
     * Argumentos:
     * ------------------------------------------------------------------------------------------------
     *   charset: (utf-8)
     *   format: formato da pagina (pode ser adicionado -L depois do formato para forcar modo paisagem
     *   tamanho da fonte: e passado 0 para que o tamanho seja setado no arquivo CSS
     *   fonte
     *   margin_left
     *   margin_right
     *   margin_top
     *   margin_bottom
     *   margin_header
     *   margin_footer
    */
    $oMpdf = new mPDF(
      'utf-8',
      $aOptions['format'],
      0,
      '',
      $aOptions['margins']['left'],
      $aOptions['margins']['right'],
      $aOptions['margins']['top'],
      $aOptions['margins']['bottom'],
      $aOptions['margins']['header'],
      $aOptions['margins']['footer']
    );
    $oMpdf->ignore_invalid_utf8 = true;
    $oMpdf->charset_in = 'utf-8';
    $oMpdf->SetDisplayMode('fullpage', 'two');
    $oMpdf->WriteHTML($oMpdf->purify_utf8($sHtml));
    $oMpdf->Output($sFilename . '.pdf', $aOptions['output']);
  
    return $sFilename;
  }
}