<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Service
 * @subpackage DeveloperGarden
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: AccountBalance.php,v 1.3 2013/04/25 17:55:47 e2tiguilherme Exp $
 */

/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage DeveloperGarden
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @author     Marco Kaiser
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_DeveloperGarden_BaseUserService_AccountBalance
{
    /**
     * @var integer
     */
    public $Account = null;

    /**
     * @var integer $Credits
     */
    public $Credits = null;

    /**
     * returns the account id
     *
     * @return integer
     */
    public function getAccount()
    {
        return $this->Account;
    }

    /**
     * returns the credits
     *
     * @return integer
     */
    public function getCredits()
    {
        return $this->Credits;
    }
}
