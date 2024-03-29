<?php
/**
 * Copyright (c) Ascensio System SIA 2023. All rights reserved.
 * http://www.onlyoffice.com
 */

$manifest = array(
   'name' => 'ONLYOFFICE',
   'description' => 'Edit and collaborate on office files within SuiteCRM Documents.',
   'version' => '1.0.0',
   'author' => 'Ascensio System SIA',
   'type' => 'module',
   'is_uninstallable' => true,
   'readme' => 'README.md'
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
        'from' => '<basepath>/module/',
        'to' => 'modules/Onlyoffice'
      )
    )
);