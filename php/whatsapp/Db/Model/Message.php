<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 03.01.16
 * Time: 15:23
 */

namespace Thomblin\Whatsapp\Db\Model;

class Message extends Model
{
    /**
     * @var int
     */
    public $protocol;
    /**
     * @var string
     */
    public $msgId;
    /**
     * @var string
     */
    public $from;
    /**
     * @var string
     */
    public $nickname;
    /**
     * @var string
     */
    public $to;
    /**
     * @var int
     */
    public $time;
    /**
     * @var string
     */
    public $type;
    /**
     * @var string
     */
    public $body;
    /**
     * @var bool
     */
    public $new;
}