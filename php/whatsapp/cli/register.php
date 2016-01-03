<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 29.12.15
 * Time: 23:16
 *
 * @see https://github.com/WHAnonymous/Chat-API/wiki/WhatsAPI-Documentation#sending-messages
 */

use Thomblin\Whatsapp\Db\Pdo;
use Thomblin\Whatsapp\Repository\Credentials;

require_once __DIR__ . '/../../vendor/autoload.php';

$username = readline("Enter whatsapp phone number (with region code, like 49178123456): ");

$r = new Registration($username);
$r->codeRequest('sms');

$smsCode = readline("You got a sms. Enter provided code (number): ");

$response = $r->codeRegister($smsCode);

if (isset($response->pw) ) {

    $nickname = readline("Enter a nickname for your account: ");

    $credentials = new Credentials(new Pdo());

    $credentials->addCredential(new \Thomblin\Whatsapp\Db\Model\Credential([
        'protocol' => Credentials::PROTOCOL_WHATSAPP,
        'username' => $username,
        'nickname' => $nickname,
        'password' => $response->pw
    ]));

    echo "Registration completed\n";
} else {
    echo "\n Registration was NOT successful. Please check response and documentation! response: \n";
    print_r($response);
    exit(1);
}

exit(0);