<?php
/**
 * Copyright (c) Ascensio System SIA 2023. All rights reserved.
 * http://www.onlyoffice.com
 */

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
        global $mod_strings;
        $this->view = 'editor';

        $record = $_REQUEST['record'] ?? '';

        $documentServerUrl = AppConfig::GetDocumentServerUrl();
        if (empty($documentServerUrl)) {
            $this->view_object_map['error'] = $mod_strings['ONLYOFFICE_APP_NOT_CONFIGURED'];
            LoggerManager::getLogger()->error('Onlyoffice editor: app is not configured');
            return;
        }

        $document = BeanFactory::getBean('Documents', $record);
        if ($document === null) {
            $this->view_object_map['error'] = $mod_strings['ONLYOFFICE_FILE_NOT_FOUND'];
            LoggerManager::getLogger()->error('Onlyoffice editor: file "' . $record . '" not found');
            return;
        }

        $user = $GLOBALS['current_user'];

        if (!$document->ACLAccess('view')) {
            $this->view_object_map['error'] = $mod_strings['ONLYOFFICE_YOU_DO_NOT_HAVE_PERMISSIONS'];
            LoggerManager::getLogger()->error('Onlyoffice editor: user "' . $user->user_name . '" does not have enough permissions to view the file "' . $record .'"');
            return;
        }

        $ext = strtolower(pathinfo($document->filename, PATHINFO_EXTENSION));
        $format = AppConfig::GetFormats()[$ext] ?? null;
        if (empty($format)) {
            $this->view_object_map['error'] = $mod_strings['ONLYOFFICE_FORMAT_IS_NOT_SUPPORTED'];
            LoggerManager::getLogger()->error('Onlyoffice editor: format "' . $ext . '" is not supported');
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
        $canFillForms = isset($format["fillForms"]) && $format["fillForms"];
        $allowEdit = $document->ACLAccess('edit');

        $config['document']['permissions']['edit'] = $allowEdit;
        if (($canEdit || $canFillForms) && $allowEdit) {
            $config['editorConfig']['callbackUrl'] = $this->getUrl() . 'index.php?entryPoint=onlyofficeCallback&hash=' . $hash;
        } else {
            $config["editorConfig"]["mode"] = "view";
        }

        if (!empty(AppConfig::GetDocumentSecretKey())) {
            $token = Crypt::GetHash($config);
            $config['token'] = $token;
        }

        $this->view_object_map['config'] = $config;
        $this->view_object_map['documentServerUrl'] = $documentServerUrl;

        LoggerManager::getLogger()->debug('Onlyoffice editor: config: ' . json_encode($config));
    }

    private function getUrl() {
        return (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
    }
}