<?php


/**
 * Admin notification observer model
 *
 * @package     Evozon_Base_Model_AdminNotification
 * @copyright   Copyright (c) Evozon Systems (http://www.evozon.com)
 * @author      Constantin Bejenaru <constantin.bejenaru@evozon.com>
 */
class Evozon_Base_Model_AdminNotification_Observer
{

    /**
     * Update admin notification with new feed data
     *
     * @event admin_session_user_login_success
     */
    public function update()
    {
        if (!Mage::getSingleton('admin/session')->isLoggedIn()) {
            return;
        }

        /** @var Mage_Core_Model_Config_Element $feeds */
        $feeds = Mage::getConfig()->getNode('global/evozon/adminnotification/feeds');

        foreach ($feeds->children() as $child) {

            /** @var Evozon_Base_Model_AdminNotification_Feed $feed */
            $feed = Mage::getModel('evozon_base/adminNotification_feed', $child->asArray());

            /** @var Evozon_Base_Model_AdminNotification_Feed_Parse $parse */
            $parse = Mage::getModel('evozon_base/adminNotification_feed_parse', $feed);
            $parse->update();
        }
    }
}
