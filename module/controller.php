<?php

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'modules/Onlyoffice/lib/appconfig.php';
require_once 'modules/Onlyoffice/lib/documentutility.php';
require_once 'modules/Onlyoffice/lib/crypt.php';

class OnlyofficeController extends SugarController
{
    public function action_settings() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $documentServerUrl = isset($_POST['documentServerUrl']) ? $_POST['documentServerUrl'] : '';
            $secretKey = isset($_POST['secretKey']) ? $_POST['secretKey'] : '';
            $jwtHeader = isset($_POST['jwtHeader']) ? $_POST['jwtHeader'] : '';

            AppConfig::SetDocumentServerUrl($documentServerUrl);
            AppConfig::SetDocumentSecretKey($secretKey);
            AppConfig::SetJwtHeader($jwtHeader);
        }

        $this->view_object_map['documentServerUrl'] = AppConfig::GetDocumentServerUrl();
        $this->view_object_map['secretKey'] = AppConfig::GetDocumentSecretKey();
        $this->view_object_map['jwtHeader'] = AppConfig::GetJwtHeader();

        $this->view = 'settings';
    }

    public function action_editor() {
        $this->view = 'editor';

        $record = $_REQUEST['record'] ?? '';

        $documentServerUrl = AppConfig::GetDocumentServerUrl();
        if (empty($documentServerUrl)) {
            $this->view_object_map['error'] = 'ONLYOFFICE app is not configured. Please contact admin';
            return;
        }

        $document = BeanFactory::getBean('Documents', $record);
        if ($document === null) {
            $this->view_object_map['error'] = 'File not found';
            return;
        }

        $user = $GLOBALS['current_user'];

        if (!$document->ACLAccess('view')) {
            $this->view_object_map['error'] = 'You do not have enough permissions to view the file';
            return;
        }

        $ext = strtolower(pathinfo($document->filename, PATHINFO_EXTENSION));
        $format = AppConfig::GetFormats()[$ext] ?? null;
        if (empty($format)) {
            $this->view_object_map['error'] = 'Format is not supported';
            return;
        }

        $key = DocumentUtility::GetKey($document);

        $hash = Crypt::GetHash(['record' => $record, 'userId' => $user->id]);

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
        $allowEdit = $document->ACLAccess('edit');

        $config['document']['permissions']['edit'] = $allowEdit;
        if ($canEdit && $allowEdit) {
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