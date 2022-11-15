<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
header('Content-Type: application/json');

require_once 'include/upload_file.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
   echo json_encode(array(
      "error" => 1,
   ));
} else {
   $entityBody = json_decode(file_get_contents('php://input'));
   $record = $_REQUEST['record'];

   if ($entityBody->status == 2) {
	$document = BeanFactory::getBean('Documents', $record);
	$targetPath = 'upload/' .  $document->document_revision_id;
	file_put_contents($targetPath, file_get_contents($entityBody->url));

	$db = DBManagerFactory::getInstance();
	$date = date('Y-m-d H:i:s');
    	$documentsSql = "UPDATE documents SET date_modified = ('$date') WHERE id = ('$record')";
    	$db->query($documentsSql);
	
	echo json_encode(array(
		"error" => 0,
	));
   } else {
     	echo json_encode(array(
       		"error" => 0,
     	));
   }
}




