<?php

/**
 * Class Twitter_Bootstrap_View_Helper_FormImg
 */
class Twitter_Bootstrap_View_Helper_FormImg extends Zend_View_Helper_FormElement {

  public function formImg($name, $value, $attribs = null) {

    $info = $this->_getInfo($name, $value, $attribs);
    $xHtml = '<img'
      . $this->_htmlAttribs($attribs)
      . ' />';

    return $xHtml;
  }
}