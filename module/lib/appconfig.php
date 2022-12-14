<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'modules/Administration/Administration.php';

class AppConfig
{
    private $administration;

    private $retrived;

    private $_category = 'onlyoffice';

    private $_documentServerUrl = 'documentServerUrl';

    public function __construct() {
        $this->administration = new Administration();
        $this->retrived = false;
    }

    public function GetDocumentServerUrl() {
        $this->Retrieve();

        $result = $this->administration->settings[$this->_category . '_' . $this->_documentServerUrl] ?? '';
        return $result;
    }

    public function SetDocumentServerUrl($value) {
        $result = $this->administration->saveSetting($this->_category, $this->_documentServerUrl, $value);
        $this->retrived = false;
    }

    public function GetFormats() {
        return $this->formats;
    }

    private function Retrieve() {
        if (count($this->administration->settings) === 0 || !$this->retrived) {
            $this->administration->retrieveSettings($this->_category);
            $this->retrived = true;
        }
    }

    private $formats = [
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