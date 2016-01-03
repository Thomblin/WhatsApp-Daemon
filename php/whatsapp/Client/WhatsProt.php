<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 02.01.16
 * Time: 22:16
 */

namespace Thomblin\Whatsapp\Client;

class WhatsProt extends \WhatsProt
{
    /**
     * Default class constructor.
     *
     * @param string $number
     *   The user phone number including the country code without '+' or '00'.
     * @param string $nickname
     *   The user name.
     * @param $debug
     *   Debug on or off, false by default.
     * @param $log
     *  Enable log, false by default.
     * @param $datafolder
     *  The folder for whatsapp data like MEDIA, PICTURES etc.. By default that is wadata in src folder
     */
    public function __construct($number, $nickname, $debug = false, $log = false, $datafolder = null)
    {

        parent::__construct($number, $nickname, $debug, $log, $datafolder);

        $this->eventManager = new WhatsApiEventsManager();
    }

    /**
     * @param callback $callback
     */
    public function setEventFallback($callback)
    {
       $this->eventManager()->setEventFallback($callback);
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
}