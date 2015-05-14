<?php namespace Seansch\Interspire;

use Illuminate\Support\Facades\Facade;

class InterspireFacade extends Facade {

    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'interspire';
    }
}
