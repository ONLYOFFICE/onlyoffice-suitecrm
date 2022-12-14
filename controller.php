<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'modules/Administration/Administration.php';

class OnlyofficeController extends SugarController
{
    public function action_settings() {
        $administration = new Administration();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $documentServerUrl = isset($_POST['documentServerUrl']) ? $_POST['documentServerUrl'] : '';

            $administration->saveSetting('onlyoffice', 'documentServerUrl', $documentServerUrl);
        }

        $administration->retrieveSettings('onlyoffice');

        $documentServerUrl = $administration->settings['onlyoffice_documentServerUrl'];
        if (!isset($documentServerUrl)) {
            $documentServerUrl = '';
        }

        $this->view_object_map['documentServerUrl'] = $documentServerUrl;

        $this->view = 'settings';
    }

    public function action_editor() {
        $this->view = 'editor';

        $administration = new Administration();
        $administration->retrieveSettings('onlyoffice');

        $documentServerUrl = $administration->settings['onlyoffice_documentServerUrl'];

        $record = '';
        if (isset($_REQUEST['record'])) {
           $record = $_REQUEST['record'];
        }

        $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

        $document = BeanFactory::getBean('Documents', $record);

        $user = $GLOBALS['current_user'];

        $ext = strtolower(pathinfo($document->filename, PATHINFO_EXTENSION));

        $format = self::FORMATS[$ext];

        $config = [
            'document' => [
                'fileType' => $ext,
                'key' => $document->document_revision_id . strtotime($document->date_modified),
                'title' => $document->filename,
                'url' => $root . 'index.php?entryPoint=onlyofficeDownload&record=' . $record
            ],
            'documentType' => $format["type"],
            'editorConfig' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->full_name
                ]
            ]
        ];

        $canEdit = isset($format["edit"]) && $format["edit"];
        $config['document']['permissions']['edit'] = true;
        if ($canEdit) {
            $config['editorConfig']['callbackUrl'] = $root . 'index.php?entryPoint=onlyofficeCallback&record=' . $record;
        } else {
            $config["editorConfig"]["mode"] = "view";
        }

        $this->view_object_map['config'] = $config;
        $this->view_object_map['documentServerUrl'] = $documentServerUrl;
    }

    private const FORMATS = [
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