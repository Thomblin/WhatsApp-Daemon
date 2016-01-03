<?php

namespace Thomblin\Base;
use Base;

/**
 * Created by PhpStorm.
 * User: seeb
 * Date: 01.01.16
 * Time: 14:34
 */
abstract class Controller
{
    /**
     * @var Base
     */
    protected $base;

    /**
     * Controller constructor.
     * @param Base $base
     */
    public function __construct(Base $base)
    {
        $this->base = $base;
    }

    public function render($template)
    {
        echo $this->base->get('BLADE')->view()->make($template)->render();
    }
}