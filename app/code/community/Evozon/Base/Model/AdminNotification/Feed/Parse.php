<?php

/**
 * Admin notification feed parser
 *
 * @package     Evozon_Fpc_Model_Feed
 * @copyright   Copyright (c) Evozon Systems (http://www.evozon.com)
 * @author      Constantin Bejenaru <constantin.bejenaru@evozon.com>
 */
class Evozon_Base_Model_AdminNotification_Feed_Parse
{

    /**
     * Feed model
     *
     * @var Evozon_Base_Model_AdminNotification_Feed
     */
    protected $feed;

    /**
     * Constructor
     *
     * @param Evozon_Base_Model_AdminNotification_Feed $feed
     */
    public function __construct(Evozon_Base_Model_AdminNotification_Feed $feed)
    {
        $this->feed = $feed;
    }

    /**
     * Parse feed
     */
    public function update()
    {
        if (($this->getFrequency() + $this->getLastUpdate()) > time()) {
            return $this;
        }

        $data = array();

        /** @var SimpleXMLElement $feed */
        $feed = $this->fetchFeed();

        if ($feed && $feed->channel && $feed->channel->item) {
            foreach ($feed->channel->item as $item) {
                $data[] = array(
                    'severity'    => isset($item->severity) ? (integer) $item->severity : 4,
                    'date_added'  => $this->getDate(trim((string) $item->pubDate)),
                    'title'       => trim((string) $item->title),
                    'description' => trim((string) $item->description),
                    'url'         => trim((string) $item->link),
                );
            }

            if ($data) {
                Mage::getModel('adminnotification/inbox')->parse(array_reverse($data));
            }
        }
        $this->setLastUpdate();

        return $this;
    }

    /**
     * Retrieve feed data as XML element
     *
     * @return SimpleXMLElement
     */
    protected function fetchFeed()
    {
        $client = new Zend_Http_Client(
            $this->getFeed()->getFeedUrl(),
            array(
                'maxredirects' => 5,
                'timeout'      => 2,
                'useragent'    => 'Evozon_Base_AdminNotification_Feed',
                'httpversion'  => Zend_Http_Client::HTTP_0,
            )
        );

        // default
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?><rss></rss>', LIBXML_NOERROR, false);

        try {
            $response = $client->request();

            if (!$response->isSuccessful()) {
                return $xml;
            }

            $xml = new SimpleXMLElement(
                $response->getBody()
            );
        }
        catch (Exception $exception) {
            return $xml;
        }

        return $xml;
    }

    /**
     * Get last update time
     *
     * @return integer
     */
    protected function getLastUpdate()
    {
        return (integer) Mage::app()->loadCache(
            $this->getCacheKey()
        );
    }

    /**
     * Set last update time
     *
     * @return Evozon_Fpc_Model_AdminNotification_Feed_Parse
     */
    protected function setLastUpdate()
    {
        Mage::app()->saveCache(
            time(), $this->getCacheKey()
        );

        return $this;
    }

    /**
     * Get frequency
     *
     * @return integer
     */
    protected function getFrequency()
    {
        return (integer) ($this->getFeed()->getFrequency() * 3600);
    }

    /**
     * Get formatted date from RSS date
     *
     * @param string $date
     *
     * @return string
     */
    protected function getDate($date)
    {
        return gmdate('Y-m-d H:i:s', strtotime($date));
    }

    /**
     * Get feed
     *
     * @return Evozon_Base_Model_AdminNotification_Feed
     */
    protected function getFeed()
    {
        if (null === $this->feed) {
            $this->feed = Mage::getModel('evozon_base/adminNotification_feed');
        }

        return $this->feed;
    }

    /**
     * Get cache key
     *
     * @return string
     */
    protected function getCacheKey()
    {
        return 'evozon_adminnotifications_feed_parse' . strtolower($this->getFeed()->getFeedUrl());
    }
}
