<?php 

namespace cmsabelita\UserAuth\Models;
use DB;
use Carbon\Carbon;

class UserAuthModel{

    public function createSession($data){
        return DB::transaction(function () use ($data){
            return DB::table('sessions')
                    ->insert($data);
        });
    }

    public function checkActiveSession($id){
        return DB::transaction(function () use($id){
            return DB::table('sessions')
                    ->select('*')
                    ->where('id', $id)
                    ->whereDate('expiry_date' ,">", Carbon::now())
                    ->delete();
        });
    }

    public function validateUser($payload){
        return DB::table('sessions')
                ->select('*')
                ->leftjoin('users_departments', 'users_departments.user_id', '=', 'sessions.user_id')
                ->leftjoin('departments', 'departments.id', '=', 'users_departments.department_id')
                ->where('payload', $payload)
                // ->where('sessions.user_id', $id)
                ->first();
    }

    public function getAuthType($client_id, $client_secret){
        return DB::table('user_auth_client')
                ->select('*')
                ->where('id', $client_id)
                ->where('secret', $client_secret)
                ->first();
    }
}