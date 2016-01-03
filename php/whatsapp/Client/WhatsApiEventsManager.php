<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 02.01.16
 * Time: 22:17
 */

namespace Thomblin\Whatsapp\Client;

class WhatsApiEventsManager extends \WhatsApiEventsManager
{
    /**
     * @var callback
     */
    private $callback;

    private $listed = array();

    public function bind($event, $callback)
    {
        parent::bind($event, $callback);

        $this->listed[$event] = true;
    }

    public function fire($event, array $parameters)
    {
        parent::fire($event, $parameters);

        if ( !isset($this->listed[$event]) && null !== $this->callback) {
            call_user_func_array($this->callback, [$event, $parameters]);
        }
    }

    /**
     * @param callback $callback
     */
    public function setEventFallback($callback)
    {
        $this->callback = $callback;
    }
}