<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'modules/Administration/Administration.php';

class AppConfig
{
    private static $administration;

    private static $retrived;

    private static $_category = 'onlyoffice';

    private static $_documentServerUrl = 'documentServerUrl';

    private static $_secretKey = 'secretKey';

    private static $_jwtHeader = 'jwtHeader';

    private static function GetAdministration() {
        if (!isset(self::$administration)) {
            self::$administration = new Administration();
            self::$retrived = false;
        }

        return self::$administration;
    }

    public static function GetDocumentServerUrl() {
        return self::GetAppValue(self::$_documentServerUrl);
    }

    public static function SetDocumentServerUrl($value) {
        self::SetAppValue(self::$_documentServerUrl, $value);
    }

    public static function GetDocumentSecretKey() {
        return self::GetAppValue(self::$_secretKey);
    }

    public static function SetDocumentSecretKey($value) {
        self::SetAppValue(self::$_secretKey, $value);
    }

    public static function GetJwtHeader() {
        return self::GetAppValue(self::$_jwtHeader);
    }

    public static function SetJwtHeader($value) {
        self::SetAppValue(self::$_jwtHeader, $value);
    }

    public static function GetSecretKey() {
        $value = self::GetDocumentSecretKey();
        if (empty($value)) {
            $value = $GLOBALS['sugar_config']['unique_key'];
        }

        return $value;
    }

    public static function GetFormats() {
        return self::$formats;
    }

    private static function GetAppValue($key, $default = '') {
        if (!isset(self::$retrived) || !self::$retrived) {
            self::GetAdministration()->retrieveSettings(self::$_category);
            self::$retrived = true;
        }

        $result = self::GetAdministration()->settings[self::$_category . '_' . $key] ?? $default;
        return $result;
    }

    private static function SetAppValue($key, $value) {
        self::GetAdministration()->saveSetting(self::$_category, $key, $value);
        self::$retrived = false;
    }

    private static $formats = [
        "djvu" => ["type" => 'word'],
        "doc" => ["type" => 'word'],
        "docm" => ["type" => 'word'],
        "docx" => ["type" => 'word', "edit" => true],
        "dot" => ["type" => 'word'],
        "dotm" => ["type" => 'word'],
        "dotx" => ["type" => 'word'],
        "epub" => ["type" => 'word'],
        "fb2" => ["type" => 'word'],
        "fodt" => ["type" => 'word'],
        "html" => ["type" => 'word'],
        "mht" => ["type" => 'word'],
        "odt" => ["type" => 'word'],
        "ott" => ["type" => 'word'],
        "oxps" => ["type" => 'word'],
        "pdf" => ["type" => 'word'],
        "rtf" => ["type" => 'word'],
        "txt" => ["type" => 'word'],
        "xps" => ["type" => 'word'],
        "xml" => ["type" => 'word'],

        "csv" => ["type" => 'cell'],
        "fods" => ["type" => 'cell'],
        "ods" => ["type" => 'cell'],
        "ots" => ["type" => 'cell'],
        "xls" => ["type" => 'cell'],
        "xlsm" => ["type" => 'cell'],
        "xlsx" => ["type" => 'cell', "edit" => true],
        "xlt" => ["type" => 'cell'],
        "xltm" => ["type" => 'cell'],
        "xltx" => ["type" => 'cell'],

        "fodp" => ["type" => 'slide'],
        "odp" => ["type" => 'slide'],
        "otp" => ["type" => 'slide'],
        "pot" => ["type" => 'slide'],
        "potm" => ["type" => 'slide'],
        "potx" => ["type" => 'slide'],
        "pps" => ["type" => 'slide'],
        "ppsm" => ["type" => 'slide'],
        "ppsx" => ["type" => 'slide'],
        "ppt" => ["type" => 'slide'],
        "pptm" => ["type" => 'slide'],
        "pptx" => ["type" => 'slide', "edit" => true],
    ];
}