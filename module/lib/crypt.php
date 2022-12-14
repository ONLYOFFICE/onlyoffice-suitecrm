<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class Crypt
{
    public static function GetHash($object)
    {
        return \Firebase\JWT\JWT::encode($object, self::GetCryptKey(), 'HS256');
    }

    public static function ReadHash($token)
    {
        $key = new \Firebase\JWT\Key(self::GetCryptKey(), 'HS256');

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

    private static function GetCryptKey()
    {
        return $GLOBALS['sugar_config']['unique_key'];
    }
}