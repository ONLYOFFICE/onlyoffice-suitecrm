<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'modules/Onlyoffice/lib/crypt.php';

$hash = $_REQUEST['hash'] ?? '';

list($hashData, $error) = Crypt::ReadHash($hash);
if ($hashData === null) {
    http_response_code(401);
    die();
}

$record = $hashData->record;
$userId = $hashData->userId;

$document = BeanFactory::getBean('Documents', $record);
if ($document === null) {
    http_response_code(404);
    die();
}

global $current_user;

$user = new \User();
$user->retrieve($userId);

$current_user = $user;

if (!$document->ACLAccess('view')) {
    http_response_code(401);
    die();
}

$filePath = "upload/" . $document->document_revision_id;
if (($content = file_get_contents($filePath)) === false) {
    http_response_code(404);
    die();
}

header('Content-type: application/octet-stream');
header("Content-Length: " . filesize($filePath));
header('Content-Disposition: attachment; filename="' . $document->filename . '"');

echo $content;