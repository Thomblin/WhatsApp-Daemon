<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 03.01.16
 * Time: 00:26
 */

namespace Thomblin\Whatsapp\Client;

use Thomblin\Whatsapp\Log\Logger;
use Thomblin\Whatsapp\Repository\Credentials;
use Thomblin\Whatsapp\Repository\Messages;

class Transmitter
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
     * @var Messages
     */
    private $repository;

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

    }

    public function sendMessages()
    {
        $messages = $this->repository->getUnsentMessages(
            Credentials::PROTOCOL_WHATSAPP,
            $this->whatsprot->getPhoneNumber()
        );

        foreach ($messages as $message)
        {
            switch($message['type']) {
                case 'text':
                    $msgID = $this->whatsprot->sendMessage($message['to'], htmlentities($message['body']));
                    break;
                default:
                    $msgID = null;
                    break;
            }

            if (empty($msgID)) {
                $this->logger->log("could not send message #" . $message['id']);
            } else {
                $this->logger->log("message #" . $message['id'] . " delivered");
                $this->repository->markMessageSent($message['id'], $msgID);
            }
        }
    }
}