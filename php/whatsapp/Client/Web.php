<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 01.01.16
 * Time: 17:40
 */

namespace Thomblin\Whatsapp\Client;

use Thomblin\Whatsapp\Db\Pdo;
use Thomblin\Whatsapp\Log\Void;
use Thomblin\Whatsapp\Db\Model\Credential;
use Thomblin\Whatsapp\Repository\Credentials;
use Thomblin\Whatsapp\Repository\Messages;

class Web
{
    const ONE_SECOND = 1;

    /**
     * @var Client
     */
    private $client;
    /**
     * @var Credential
     */
    private $credential;

    /**
     * Communicator constructor.
     * @param Credential $credential
     */
    public function __construct(Credential $credential)
    {
        $this->credential = $credential;
    }

    /**
     * @param $target
     * @param $message
     *
     * @return string
     */
    public function sendMessage($target, $message)
    {
        return $this->getClient()->createMessage($target, $message);
    }

    public function loadNewMessages()
    {
        $repository = new Messages(new Pdo());

        $messages = $repository->getUnreadMessages(Credentials::PROTOCOL_WHATSAPP, $this->credential->username);

        if (0 < count($messages)) {
            $repository->markMessagesRead(array_column($messages, 'id'));
        }

        return $messages;
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        if (null === $this->client) {
            $this->client = new Client($this->credential, new Pdo(), new Void());
        }

        return $this->client;
    }

    public function getUsername()
    {
        return $this->credential->username;
    }
}