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

class Repository
{
    /**
     * @var Pdo
     */
    protected $pdo;

    /**
     * Credentials constructor.
     * @param Pdo $pdo
     */
    public function __construct(Pdo $pdo)
    {
        $this->pdo = $pdo;
    }
}