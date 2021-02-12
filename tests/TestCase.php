<?php

declare(strict_types=1);

namespace Tipoff\Reviews\Tests;

use Laravel\Nova\NovaCoreServiceProvider;
use Tipoff\Reviews\ReviewsServiceProvider;
use Tipoff\Reviews\Tests\Support\Providers\NovaTestbenchServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            NovaCoreServiceProvider::class,
            NovaTestbenchServiceProvider::class,
            SupportServiceProvider::class,
            ReviewsServiceProvider::class,
        ];
    }
}
