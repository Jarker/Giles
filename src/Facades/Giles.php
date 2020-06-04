<?php
namespace Jarker\Giles\Facades;

use Illuminate\Support\Facades\Facade;

class Giles extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'giles';
    }
}
