<?php
/**
 * Copyright (c) Ascensio System SIA 2023. All rights reserved.
 * http://www.onlyoffice.com
 */

$admin_option_defs = array();
$admin_option_defs['Administration']['ONLYOFFICE'] = array(
    'Onlyoffice',
    'ONLYOFFICE_LINK_NAME',
    'ONLYOFFICE_LINK_DESCRIPTION',
    './index.php?module=Onlyoffice&action=settings',
    'system-settings',
);

$admin_group_header[] = array(
    'ONLYOFFICE_SECTION_HEADER',
    '',
    false,
    $admin_option_defs,
    'ONLYOFFICE_SECTION_DESCRIPTION'
);
