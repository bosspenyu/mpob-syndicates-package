<?php

namespace Mpob\Syndicates;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mpob\Syndicates\Skeleton\SkeletonClass
 */
class SyndicatesFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'syndicates';
    }
}
