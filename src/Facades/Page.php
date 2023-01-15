<?php

namespace Performing\View\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Performing\View\Page
 */
class Page extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Performing\View\Page::class;
    }
}
