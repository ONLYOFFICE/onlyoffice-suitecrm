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
}