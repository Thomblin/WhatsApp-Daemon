<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 01.01.16
 * Time: 15:16
 */

namespace Thomblin\Whatsapp\Controller;

use Thomblin\Base\Controller as BaseController;
use Thomblin\Whatsapp\Client\Web;
use Thomblin\Whatsapp\Db\Pdo;
use Thomblin\Whatsapp\Repository\Credentials;

class Messages extends BaseController
{
    function get()
    {
        $webClient = $this->getWebClient();

        $messages = $webClient->loadNewMessages();

        $this->printJson(
            $messages !== null
                ? ['success' => true, 'messages' => $messages]
                : ['success' => false]
        );
    }

    function post()
    {
        if (!$this->base->exists('POST.number')) {
            $this->fail('target phone number missing');
        }
        if (!$this->base->exists('POST.message')) {
            $this->fail('message missing');
        }

        $number = $this->base->get('POST.number');
        $message = $this->base->get('POST.message');

        $webClient = $this->getWebClient();
        $mId = $webClient->sendMessage(
            $number,
            $message
        );

        $this->printJson([
            'success' => true,
            'msg_id' => $mId,
            'from' => $webClient->getUsername(),
            'to' => $number,
            'body' => $message,
        ]);
    }

    private function fail($errors)
    {
        $this->printJson(['success' => false, 'errors' => $errors]);
        die();
    }

    private function printJson($values)
    {
        header('Content-Type: application/json');

        echo json_encode($values) . "\n";
    }

    /**
     * @return Web
     */
    private function getWebClient()
    {
        // this supports only one worker and one whatsapp account so far

        $repositry = new Credentials(new Pdo());
        $credentials = $repositry->getCredentials(Credentials::PROTOCOL_WHATSAPP);

        $communicator = new Web($credentials[0]);
        return $communicator;
    }
}