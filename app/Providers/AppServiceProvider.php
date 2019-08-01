<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use App\Resolvers\SocialUserResolver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public $bindings = [
        SocialUserResolverInterface::class => SocialUserResolver::class,
    ];
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
