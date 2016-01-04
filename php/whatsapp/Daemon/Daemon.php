<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 02.01.16
 * Time: 21:27
 */

namespace Thomblin\Whatsapp\Daemon;

use Thomblin\Whatsapp\Db\Pdo;
use Thomblin\Whatsapp\Repository\Credentials;

class Daemon extends \Core_Daemon
{
    protected $loop_interval = 0;

    protected function setup()
    {
        // TODO: Implement setup() method.
    }

    protected function execute()
    {
        if (!$this->Worker->is_idle()) {
            return;
        }

        // this supports only one worker and one whatsapp account so far

        $repository = new Credentials(Pdo::createInstance());
        $credentials = $repository->getCredentials(Credentials::PROTOCOL_WHATSAPP);

        $this->Worker->poll($credentials[0]);
    }

    protected function log_file()
    {
        $dir = '/var/log/daemons/whatsapp';
        if (@file_exists($dir) == false)
            @mkdir($dir, 0777, true);

        if (@is_writable($dir) == false)
            $dir = BASE_PATH . '/logs';

        return $dir . '/log_' . date('Ymd');
    }
    /**
     * Create a Lock File plugin to ensure we're not running duplicate processes, and load
     * the config file with all of our API connection details
     */
    protected function setup_plugins()
    {
        $this->plugin('Lock_File');
    }

    protected function setup_workers()
    {
        $this->worker('Worker', new Worker());
        $this->Worker->workers(1);
    }
}