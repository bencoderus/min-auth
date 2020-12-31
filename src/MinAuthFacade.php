<?php

namespace Bencoderus\MinAuth;

use Illuminate\Support\Facades\Facade;

class MinAuthFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'min-auth';
    }
}
