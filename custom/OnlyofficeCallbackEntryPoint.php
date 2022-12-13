<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

const TrackerStatus_Editing = 1;
const TrackerStatus_MustSave = 2;
const TrackerStatus_Corrupted = 3;
const TrackerStatus_Closed = 4;

if (!isset($_REQUEST['record'])) {
    http_response_code(400);
    die();
}

$record = $_REQUEST['record'];

if (($bodyStream = file_get_contents('php://input')) === false) {
    http_response_code(400);
    die();
}

if (($data = json_decode($bodyStream)) === null) {
    http_response_code(400);
    die();
}

$status = $data->status;

$result = 1;
switch ($status) {
    case TrackerStatus_MustSave:
    case TrackerStatus_Corrupted:
        $document = BeanFactory::getBean('Documents', $record);
        if ($document === null) {
            http_response_code(404);
            die(json_encode(['error' => $result]));
        }

        if (($newContent = file_get_contents($data->url)) === false) {
            http_response_code(400);
            die(json_encode(['error' => $result]));
        }

        $filePath = 'upload/' .  $document->document_revision_id;

        if (file_put_contents($filePath, $newContent) === false) {
            http_response_code(500);
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

http_response_code(200);
echo(json_encode(['error' => $result]));