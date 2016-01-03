<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 03.01.16
 * Time: 00:51
 */

namespace Thomblin\Whatsapp\Client;

use Thomblin\Whatsapp\Db\Model\Credential;
use Thomblin\Whatsapp\Db\Pdo;
use Thomblin\Whatsapp\Log\Logger;
use Thomblin\Whatsapp\Repository\Messages;

class Client
{
    /**
     * @var Receiver
     */
    private $receiver;
    /**
     * @var Transmitter
     */
    private $transmitter;

    /**
     * Client constructor.
     * @param Credential $credential
     * @param Pdo $pdo
     * @param Logger $logger
     */
    public function __construct(Credential $credential, Pdo $pdo, Logger $logger)
    {
        $whatsprot = new WhatsProt(
            $credential->username,
            $credential->nickname
        );

        $repository = new Messages($pdo);

        $this->receiver = new Receiver($whatsprot, $repository, $logger);
        $this->transmitter = new Transmitter($whatsprot, $repository, $logger);

        $this->receiver->registerCallbacks();
        $this->transmitter->registerCallbacks();

        $logger->log("connect to Whatsapp as {$credential->username}");

        $whatsprot->connect();
        $whatsprot->loginWithPassword($credential->password);

        $whatsprot->sendGetClientConfig();
        $whatsprot->sendGetServerProperties();
        $whatsprot->sendGetGroups();
        $whatsprot->sendGetBroadcastLists();
    }

    public function pollMessages()
    {
        $this->receiver->pollMessages();
    }

    public function sendMessages()
    {
        $this->transmitter->sendMessages();
    }

    /**
     * @param string $to
     * @param string $text
     * @return string
     */
    public function createMessage($to, $text)
    {
        return $this->transmitter->createMessage($to, $text);
    }
}