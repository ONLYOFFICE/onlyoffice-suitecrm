<?php
/**
 * Copyright (c) Ascensio System SIA 2023. All rights reserved.
 * http://www.onlyoffice.com
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'modules/Onlyoffice/lib/appconfig.php';
require_once 'modules/Onlyoffice/lib/crypt.php';

const TrackerStatus_Editing = 1;
const TrackerStatus_MustSave = 2;
const TrackerStatus_Corrupted = 3;
const TrackerStatus_Closed = 4;

$hash = $_REQUEST['hash'] ?? '';

list($hashData, $error) = Crypt::ReadHash($hash);
if ($hashData === null) {
    http_response_code(401);
    LoggerManager::getLogger()->error('Onlyoffice callback entrypoint: hash is invalid or empty');
    die();
}

$record = $hashData->record;
$userId = $hashData->userId;

if (($bodyStream = file_get_contents('php://input')) === false) {
    http_response_code(400);
    LoggerManager::getLogger()->error('Onlyoffice callback entrypoint: reading request body was failed');
    die();
}

if (($data = json_decode($bodyStream)) === null) {
    http_response_code(400);
    LoggerManager::getLogger()->error('Onlyoffice callback entrypoint: data body is invalid');
    die();
}

$token = isset($data->token) ? $data->token : null;
$status = $data->status;
$url = isset($data->url) ? $data->url : null;

if (!empty(AppConfig::GetDocumentSecretKey())) {
    if (!empty($token)) {
        list($hashData, $error) = Crypt::ReadHash($token);
        if ($hashData === null) {
            http_response_code(401);
            LoggerManager::getLogger()->error('Onlyoffice callback entrypoint: token in body is invalid');
            die();
        }

        $payload = $hashData;
    } else {
        $header = getallheaders()[AppConfig::GetAuthHeader()];
        if(empty($header)) {
            http_response_code(401);
            LoggerManager::getLogger()->error('Onlyoffice callback entrypoint: authorization header is empty');
            die();
        }

        $header = substr($header, strlen("Bearer "));

        list($hashData, $error) = Crypt::ReadHash($header);
        if ($hashData === null) {
            http_response_code(401);
            LoggerManager::getLogger()->error('Onlyoffice callback entrypoint: authorization header is invalid');
            die();
        }

        $payload = $hashData->payload;
    }

    $status = $payload->status;
    $url = isset($payload->url) ? $payload->url : null;
}

LoggerManager::getLogger()->debug('Onlyoffice callback entrypoint: track action with status ' . $status . ' in processing');

$result = 1;
switch ($status) {
    case TrackerStatus_MustSave:
    case TrackerStatus_Corrupted:
        $document = BeanFactory::getBean('Documents', $record);
        if ($document === null) {
            http_response_code(404);
            LoggerManager::getLogger()->error('Onlyoffice callback entrypoint: file "' . $record . '" not found');
            die(json_encode(['error' => $result]));
        }

        global $current_user;

        $user = new \User();
        $user->retrieve($userId);

        $current_user = $user;

        if (!$document->ACLAccess('edit')) {
            http_response_code(401);
            LoggerManager::getLogger()->error('Onlyoffice callback entrypoint: user "' . $userId . '" does not have enough permissions to write the file "' . $record .'"');
            die(json_encode(['error' => $result]));
        }

        if (($newContent = file_get_contents($url)) === false) {
            http_response_code(500);
            LoggerManager::getLogger()->error('Onlyoffice callback entrypoint: downloading new content was failed');
            die(json_encode(['error' => $result]));
        }

        $filePath = 'upload/' .  $document->document_revision_id;

        if (file_put_contents($filePath, $newContent) === false) {
            http_response_code(500);
            LoggerManager::getLogger()->error('Onlyoffice callback entrypoint: writing file "' . $filePath . '" was failed');
            die(json_encode(['error' => $result]));
        }

        $document->date_modified = date('Y-m-d H:i:s');
        $document->save();

        $result = 0;
        break;

    case TrackerStatus_Editing:
    case TrackerStatus_Closed:
        $result = 0;
        break;
}

LoggerManager::getLogger()->debug('Onlyoffice callback entrypoint: status track ' . $status . ' with error ' . $result . ' is finish');

http_response_code(200);
echo(json_encode(['error' => $result]));