<?php

$manifest = array(
   'name' => 'ONLYOFFICE',
   'description' => 'ONLYOFFICE Editor',
   'version' => '1.0.0',
   'author' => 'ASCENSIO SYSTEM',
   'type' => 'module',
   'is_uninstallable' => true,
   'readme' => 'README.txt'
);
$installdefs = array(
    'id' => 'onlyoffice',
    'copy' => array(
      0 =>
      array(
        'from' => '<basepath>/custom/',
        'to' => 'custom'
      ),
      1 =>
      array(
        'from' => '<basepath>/',
        'to' => 'modules/Onlyoffice'
      )
    )
);