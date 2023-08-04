<?php
/**
 * Copyright (c) Ascensio System SIA 2023. All rights reserved.
 * http://www.onlyoffice.com
 */

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');

class OnlyofficeViewEditor extends SugarView
{
    public function display()
    {
        global $mod_strings;

        $smarty = new Sugar_Smarty();
        if (isset($this->view_object_map['error'])) {
            $smarty->assign('error', $this->view_object_map['error']);
            echo $smarty->fetch('modules/Onlyoffice/templates/error.tpl');
            return;
        }

        $smarty->assign('msgCanNotBeReached', $mod_strings['ONLYOFFICE_CAN_NOT_BE_REACHED']);

        $smarty->assign('config', json_encode($this->view_object_map['config']));
        $smarty->assign('documentServerUrl', $this->view_object_map['documentServerUrl']);

        echo $smarty->fetch('modules/Onlyoffice/templates/editor.tpl');
    }
}