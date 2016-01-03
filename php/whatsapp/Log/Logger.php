<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 03.01.16
 * Time: 01:50
 */

namespace Thomblin\Whatsapp\Log;

interface Logger
{
    /**
     * @param string $message
     */
    public function log($message);
}