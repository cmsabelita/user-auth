<?php
namespace cmsabelita\UserAuth;
use Illuminate\Support\Facades\Facade;
use cmsabelita\UserAuth\Http\UserAuthController;

class UserAuthFacade extends Facade{
    protected static function getFacadeAccessor(){
        return UserAuthController::class;
    }
}