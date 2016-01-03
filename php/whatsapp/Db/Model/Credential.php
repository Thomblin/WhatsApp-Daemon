<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 03.01.16
 * Time: 15:23
 */

namespace Thomblin\Whatsapp\Db\Model;

class Credential extends Model
{
    /**
     * @var int
     */
    public $protocol;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $nickname;
    /**
     * @var string
     */
    public $password;
}