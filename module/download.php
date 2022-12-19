<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'modules/Onlyoffice/lib/crypt.php';

$hash = $_REQUEST['hash'] ?? '';

list($hashData, $error) = Crypt::ReadHash($hash);
if ($hashData === null) {
    http_response_code(401);
    LoggerManager::getLogger()->error('Onlyoffice download entrypoint: hash is invalid or empty');
    die();
}

$record = $hashData->record;
$userId = $hashData->userId;

LoggerManager::getLogger()->debug('Onlyoffice download entrypoint: downloading file "' . $record . '" by "' . $userId . '" in processing');

if (!empty(AppConfig::GetDocumentSecretKey())) {
    $header = getallheaders()[AppConfig::GetAuthHeader()];
    if(empty($header)) {
        http_response_code(401);
        LoggerManager::getLogger()->error('Onlyoffice download entrypoint: authorization header is empty');
        die();
    }

    $header = substr($header, strlen("Bearer "));

    list($hashData, $error) = Crypt::ReadHash($header);
    if ($hashData === null) {
        http_response_code(401);
        LoggerManager::getLogger()->error('Onlyoffice download entrypoint: authorization header is invalid');
        die();
    }
}

$document = BeanFactory::getBean('Documents', $record);
if ($document === null) {
    http_response_code(404);
    LoggerManager::getLogger()->error('Onlyoffice download entrypoint: file "' . $record . '" not found');
    die();
}

global $current_user;

$user = new \User();
$user->retrieve($userId);

$current_user = $user;

if (!$document->ACLAccess('view')) {
    http_response_code(401);
    LoggerManager::getLogger()->error('Onlyoffice download entrypoint: user "' . $userId . '" does not have enough permissions to view the file "' . $record .'"');
    die();
}

$filePath = "upload/" . $document->document_revision_id;
if (($content = file_get_contents($filePath)) === false) {
    http_response_code(404);
    LoggerManager::getLogger()->error('Onlyoffice download entrypoint: reading file "' . $filePath . '" was failed');
    die();
}

header('Content-type: application/octet-stream');
header("Content-Length: " . filesize($filePath));
header('Content-Disposition: attachment; filename="' . $document->filename . '"');

LoggerManager::getLogger()->debug('Onlyoffice download entrypoint: file "' . $record . '" was send');

echo $content;