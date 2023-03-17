<?php
/**
 * Copyright (c) Ascensio System SIA 2023. All rights reserved.
 * http://www.onlyoffice.com
 */

    $admin_option_defs = array();
    $admin_option_defs['Administration']['ONLYOFFICE'] = array(
        //Icon name. Available icons are located in ./themes/default/images
        'Onlyoffice',

        //Link name label 
        'ONLYOFFICE_LINK_NAME',

        //Link description label
        'ONLYOFFICE_LINK_DESCRIPTION',

        //Link URL - For Sidecar modules
        './index.php?module=Onlyoffice&action=settings',

        //Alternatively, if you are linking to BWC modules
        'system-settings',
    );

    $admin_group_header[] = array(
        //Section header label
        'ONLYOFFICE_SECTION_HEADER',

        //$other_text parameter for get_form_header()
        '',

        //$show_help parameter for get_form_header()
        false,

        //Section links
        $admin_option_defs, 

        //Section description label
        'ONLYOFFICE_SECTION_DESCRIPTION'
    );
