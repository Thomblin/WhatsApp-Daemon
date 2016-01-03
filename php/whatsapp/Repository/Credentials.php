<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 03.01.16
 * Time: 15:20
 */

namespace Thomblin\Whatsapp\Repository;

use Thomblin\Whatsapp\Db\Model\Credential;
use Thomblin\Whatsapp\Db\Pdo;

class Credentials extends Repository
{
    const PROTOCOL_WHATSAPP = 1;

    /**
     * @param Credential $credential
     */
    public function addCredential(Credential $credential)
    {
        $this->pdo->execute("
            REPLACE INTO
              credentials
              (protocol, username, nickname, password)
              VALUES
              (:protocol, :username, :nickname, :password)
            ",
            $credential->toArray()
        );
    }

    /**
     * @param string $protocol
     * @return Credential[]
     */
    public function getCredentials($protocol)
    {
        $results = $this->pdo->fetchAll("
            SELECT
              protocol, username, nickname, password
            FROM
              credentials
            WHERE
              protocol=:protocol
          ",
            array(
                'protocol' => $protocol
            )
        );

        $credentials = array();

        foreach ($results as $row) {
            $credentials[] = new Credential($row);
        }

        return $credentials;
    }
}