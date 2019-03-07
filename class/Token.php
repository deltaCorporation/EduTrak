<?php

class Token{

    public static function generateAccount(){
        return Session::put(Config::get('session/token_account'), md5(uniqid()));
    }

    public static function generateLogin(){
        return Session::put(Config::get('session/token_login'), md5(uniqid()));
    }

    public static function generateLead(){
        return Session::put(Config::get('session/token_lead'), md5(uniqid()));
    }

    public static function generateContact(){
        return Session::put(Config::get('session/token_contact'), md5(uniqid()));
    }

    public static function generateCustomer(){
        return Session::put(Config::get('session/token_customer'), md5(uniqid()));
    }

    public static function checkAccount($token){
        $tokenName = Config::get('session/token_account');

        if(Session::exists($tokenName) && $token === Session::get($tokenName)){
            Session::delete($tokenName);

            return true;
        }

        return false;
    }

    public static function checkLogin($token){
        $tokenName = Config::get('session/token_login');

        if(Session::exists($tokenName) && $token === Session::get($tokenName)){
            Session::delete($tokenName);

            return true;
        }

        return false;
    }

    public static function checkLead($token){
        $tokenName = Config::get('session/token_lead');

        if(Session::exists($tokenName) && $token === Session::get($tokenName)){
            Session::delete($tokenName);

            return true;
        }

        return false;
    }

    public static function checkContact($token){
        $tokenName = Config::get('session/token_contact');

        if(Session::exists($tokenName) && $token === Session::get($tokenName)){
            Session::delete($tokenName);

            return true;
        }

        return false;
    }

    public static function checkCustomer($token){
        $tokenName = Config::get('session/token_customer');

        if(Session::exists($tokenName) && $token === Session::get($tokenName)){
            Session::delete($tokenName);

            return true;
        }

        return false;
    }
}