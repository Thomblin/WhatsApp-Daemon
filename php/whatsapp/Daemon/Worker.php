<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 02.01.16
 * Time: 21:29
 */

namespace Thomblin\Whatsapp\Daemon;

use Thomblin\Whatsapp\Client\Client;
use Thomblin\Whatsapp\Db\Model\Credential;
use Thomblin\Whatsapp\Db\Pdo;
use Thomblin\Whatsapp\Log\CoreWorkerMediator;

class Worker implements \Core_IWorker
{
    /**
     * Provided Automatically
     * @var \Core_Worker_Mediator
     */
    public $mediator;

    public function setup()
    {
    }

    public function teardown()
    {
    }

    /**
     * This is called during object construction to validate any dependencies
     * @return Array    Return array of error messages (Think stuff like "GD Library Extension Required" or
     *                  "Cannot open /tmp for Writing") or an empty array
     */
    public function check_environment(array $errors = array())
    {

    }

    /**
     * Poll the API for updated information -- Simulate an API call of varying duration.
     * @param Credential $credential
     * @return void
     * @throws \ConnectionException
     */
    public function poll(Credential $credential)
    {
        $client = new Client($credential, Pdo::createInstance(), new CoreWorkerMediator($this->mediator));

        try {
            while (true) {
                $client->pollMessages();
                $client->sendMessages();
            }
        } catch (\Exception $e) {
            $this->mediator->log("error: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}