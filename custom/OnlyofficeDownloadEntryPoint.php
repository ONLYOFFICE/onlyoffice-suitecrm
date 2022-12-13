<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

if (!isset($_REQUEST['record'])) {
    http_response_code(400);
    die();
}

$record = $_REQUEST['record'];

$document = BeanFactory::getBean('Documents', $record);
if ($document === null) {
    http_response_code(404);
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