<?php 

namespace cmsabelita\UserAuth\Http;
use Auth;
use Carbon\Carbon;
use cmsabelita\UserAuth\Models\UserAuthModel;

class UserAuthController{

    public function __construct(){
        $this->user = new UserAuthModel;
    }

    public function loginUser($username, $password, $client_id, $client_secret){
        $result = array();
        
        if(Auth::attempt(['username' => $username, 'password' => $password])){
            unset(Auth::user()->password);
            $session_details = array(
                "user_id" => Auth::id(),
                "payload" => str_random(60),
                "expiry_date" => Carbon::now()->addHours(3)
            );
            
            $session = $this->user->createSession($session_details);
            $valid_key = $this->user->getAuthType($client_id, $client_secret);
            dd('test');
            if($session){
                if($valid_key){
                    $result = array(
                        "status" => true,
                        "key" => true,
                        "message" => "Successfully login",
                        "user" => Auth::user(),
                        "session" => $session_details,
                        "access" => $valid_key,
                    );
                }else{
                    $result = array(
                        "status" => true,
                        "key" => false,
                        "message" => "invalid"
                    );
                }
            }
        }else{
            $result = array(
                "status" => false,
                "message" => "Username / Password is incorrect"
            );
        }
        return $result;
    }

    public function validateUser($payload, $access_level = NULL){
        $result = array();        
        // $this->user->checkActiveSession($id);
        $validate = $this->user->validateUser($payload);

        if($validate){
            if($access_level){
                if($validate->access == $access_level){
                    return true;
                }
                return false;
            }
            return true;
        }
        return false;
    }
}