<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 03.01.16
 * Time: 00:26
 */

namespace Thomblin\Whatsapp\Client;

use Thomblin\Whatsapp\Db\Model\Message;
use Thomblin\Whatsapp\Log\Logger;
use Thomblin\Whatsapp\Repository\Credentials;
use Thomblin\Whatsapp\Repository\Messages;

class Receiver
{
    /**
     * @var WhatsProt
     */
    private $whatsprot;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * Receiver constructor.
     * @param WhatsProt $whatsprot
     * @param Messages $repository
     * @param Logger $logger
     */
    public function __construct(WhatsProt $whatsprot, Messages $repository, Logger $logger)
    {
        $this->whatsprot = $whatsprot;
        $this->logger = $logger;
        $this->repository = $repository;
    }

    public function registerCallbacks()
    {
        $this->registerEventFallback();
        $this->registerMessageReceived();
    }

    private function registerEventFallback()
    {
        $logger = $this->logger;

        $this->whatsprot->setEventFallback(function ($event, $parameters) use ($logger) {
            $logger->log("new event: $event " . serialize($parameters));
        });
    }

    private function registerMessageReceived()
    {
        $logger = $this->logger;

        $repository = $this->repository;

        $this->whatsprot->eventManager()->bind("onGetMessage", function (
            $mynumber, $from, $id, $type, $time, $name, $body
        ) use ($logger, $repository) {
            $message = new Message(array(
                'protocol' => Credentials::PROTOCOL_WHATSAPP,
                'to' => $mynumber,
                'from' => $from,
                'time' => $time,
                'msgId' => $id,
                'type' => $type,
                'nickname' => $name,
                'body' => $body
            ));

            $logger->log("got message: " . serialize($message));

            if (!$repository->storeMessage($message)) {
                $logger->log("unable to store message");
            }
        });
    }

    public function pollMessages()
    {
        $this->whatsprot->pollMessage();
        $this->whatsprot->sendPing();
    }
}