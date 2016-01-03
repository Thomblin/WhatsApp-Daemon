<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 03.01.16
 * Time: 01:51
 */

namespace Thomblin\Whatsapp\Log;

use Core_Worker_Mediator;

class CoreWorkerMediator implements Logger
{
    /**
     * @var Core_Worker_Mediator
     */
    private $mediator;

    /**
     * Core_Worker_Mediator constructor.
     * @param Core_Worker_Mediator $mediator
     */
    public function __construct(Core_Worker_Mediator $mediator)
    {
        $this->mediator = $mediator;
    }

    /**
     * @param string $message
     */
    public function log($message)
    {
        $this->mediator->log($message);
    }


}