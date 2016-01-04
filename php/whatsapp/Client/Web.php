<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 01.01.16
 * Time: 17:40
 */

namespace Thomblin\Whatsapp\Client;

use Thomblin\Whatsapp\Db\Model\Message;
use Thomblin\Whatsapp\Db\Model\Credential;
use Thomblin\Whatsapp\Repository\Credentials;
use Thomblin\Whatsapp\Repository\Messages;

class Web
{
    const ONE_SECOND = 1;

    /**
     * @var Credential
     */
    private $credential;
    /**
     * @var Messages
     */
    private $repository;

    /**
     * Communicator constructor.
     * @param Credential $credential
     * @param Messages $repository
     */
    public function __construct(Credential $credential, Messages $repository)
    {
        $this->credential = $credential;
        $this->repository = $repository;
    }

    /**
     * @param $target
     * @param $message
     *
     * @return string
     */
    public function sendMessage($target, $message)
    {
        return $this->repository->createMessage(new Message([
            'protocol' => Credentials::PROTOCOL_WHATSAPP,
            'from' => $this->credential->username,
            'nickname' => $this->credential->nickname,
            'to' => $target,
            'body' => $message
        ]));
    }

    public function loadNewMessages()
    {
        $messages = $this->repository->getUnreadMessages(Credentials::PROTOCOL_WHATSAPP, $this->credential->username);

        if (0 < count($messages)) {
            $this->repository->markMessagesRead(array_column($messages, 'id'));
        }

        return $messages;
    }

    public function getUsername()
    {
        return $this->credential->username;
    }
}