<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'modules/Onlyoffice/lib/appconfig.php';
require_once 'modules/Onlyoffice/lib/documentutility.php';
require_once 'modules/Onlyoffice/lib/crypt.php';

class OnlyofficeController extends SugarController
{
    public function action_settings() {
        $appConfig = new AppConfig();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $documentServerUrl = isset($_POST['documentServerUrl']) ? $_POST['documentServerUrl'] : '';

            $appConfig->SetDocumentServerUrl($documentServerUrl);
        }

        $this->view_object_map['documentServerUrl'] = $appConfig->GetDocumentServerUrl();

        $this->view = 'settings';
    }

    public function action_editor() {
        $this->view = 'editor';

        $appConfig = new AppConfig();

        $documentServerUrl = $appConfig->GetDocumentServerUrl();

        $record = '';
        if (isset($_REQUEST['record'])) {
           $record = $_REQUEST['record'];
        }

        $document = BeanFactory::getBean('Documents', $record);

        $user = $GLOBALS['current_user'];

        $ext = strtolower(pathinfo($document->filename, PATHINFO_EXTENSION));

        $format = $appConfig->GetFormats()[$ext] ?? null;

        $key = DocumentUtility::GetKey($document);

        $hash = Crypt::GetHash(['record' => $record]);

        $config = [
            'document' => [
                'fileType' => $ext,
                'key' => $key,
                'title' => $document->filename,
                'url' => $this->getUrl() . 'index.php?entryPoint=onlyofficeDownload&hash=' . $hash
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
            $config['editorConfig']['callbackUrl'] = $this->getUrl() . 'index.php?entryPoint=onlyofficeCallback&hash=' . $hash;
        } else {
            $config["editorConfig"]["mode"] = "view";
        }

        $this->view_object_map['config'] = $config;
        $this->view_object_map['documentServerUrl'] = $documentServerUrl;
    }

    private function getUrl() {
        return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    }
}