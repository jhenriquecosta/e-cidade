<?php
/**
 * Form decorator definition
 *
 * @category Forms
 * @package Twitter_Bootstrap_Form
 * @subpackage Decorator
 * @author Christian Soronellas <csoronellas@emagister.com>
 */

/**
 * Defines a decorator to wrap all the Bootstrap form elements
 *
 * @category Forms
 * @package Twitter_Bootstrap_Form
 * @subpackage Decorator
 * @author Christian Soronellas <csoronellas@emagister.com>
 */
class Twitter_Bootstrap_Form_Decorator_Wrapper extends Zend_Form_Decorator_Abstract
{
    /**
     * Renders a form element decorating it with the Twitter's Bootstrap markup
     *
     * @param $content
     *
     * @return string
     */
    public function render($content)
    {
        $hasErrors = $this->getElement()->hasErrors();

        $divSpan = $this->getElement()->getAttrib('divspan');
        
        $preDiv = $posDiv = '';
        if($divSpan !== null) {
            $preDiv = '<div class="span' . $divSpan . '">';
            $posDiv = "</div>";
        }
       
        $this->getElement()->setAttrib('divspan', null);
        
        return $preDiv . '<div class="control-group' . (($hasErrors) ? ' error' : '') . '">' . $content . '</div>' . $posDiv ;
    }
}
