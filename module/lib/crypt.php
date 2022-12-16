<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'modules/Onlyoffice/lib/appconfig.php';

class Crypt
{
    public static function GetHash($object)
    {
        return \Firebase\JWT\JWT::encode($object, AppConfig::GetSecretKey(), 'HS256');
    }

    public static function ReadHash($token)
    {
        $key = new \Firebase\JWT\Key(AppConfig::GetSecretKey(), 'HS256');

        $result = null;
        $error = null;
        if (empty($token)) {
            return [$result, 'token is empty'];
        }
        try {
            $result = \Firebase\JWT\JWT::decode($token, $key);
        } catch (\UnexpectedValueException $e) {
            $error = $e->getMessage();
        }

        return [$result, $error];
    }
}