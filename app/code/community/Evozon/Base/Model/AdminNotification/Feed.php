<?php

/**
 * Admin notification feed model
 *
 * @package     Evozon_Base_Model_AdminNotification
 * @copyright   Copyright (c) Evozon Systems (http://www.evozon.com)
 * @author      Constantin Bejenaru <constantin.bejenaru@evozon.com>
 *
 * @method Evozon_Base_Model_AdminNotification_Feed setFeedUrl(string $url)
 * @method string getFeedUrl()
 * @method Evozon_Base_Model_AdminNotification_Feed setFrequency(integer $frequency)
 */
class Evozon_Base_Model_AdminNotification_Feed extends Varien_Object
{

    /**
     * Retrieve update frequency
     *
     * @return integer
     */
    public function getFrequency()
    {
        return (integer) parent::getFrequency();
    }
}
