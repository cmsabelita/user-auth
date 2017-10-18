<?php
namespace cmsabelita\UserAuth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use cmsabelita\markauth\Http\UserAuthController;

class UserAuthServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    
     
    /**
     * Register any package services.
     *
     * @return void
    */
    
    public function register()
    {
 
        $this->app->singleton(UserAuthController::class, function($app){
            return new UserAuthController();
        });
        
    }
    /**
     * Perform post-registration booting of services.
     *
     * @return void
    */
    public function boot()
    {
        
    }

    
}