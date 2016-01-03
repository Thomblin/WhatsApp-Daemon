<?php
/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 01.01.16
 * Time: 15:16
 */

namespace Thomblin\Whatsapp\Controller;

use Thomblin\Base\Controller as BaseController;

class Index extends BaseController
{
    public function get()
    {
        $this->render('pages/index');
    }
}