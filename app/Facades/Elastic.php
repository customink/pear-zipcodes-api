<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Illuminate\Hashing\BcryptHasher
 */
class Elastic extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ESClient';
    }
}