<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');

class OnlyofficeViewSettings extends SugarView
{
    public function display()
    {
        $smarty = new Sugar_Smarty();

        $smarty->assign('documentServerUrl', $this->view_object_map['documentServerUrl']);
        $smarty->assign('secretKey', $this->view_object_map['secretKey']);
        $smarty->assign('jwtHeader', $this->view_object_map['jwtHeader']);

        echo $smarty->fetch('modules/Onlyoffice/templates/settings.tpl');
    }
}