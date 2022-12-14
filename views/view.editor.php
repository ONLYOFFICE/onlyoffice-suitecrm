<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');

class OnlyofficeViewEditor extends SugarView
{
    public function display()
    {
        $smarty = new Sugar_Smarty();

        $smarty->assign('config', json_encode($this->view_object_map['config']));
        $smarty->assign('documentServerUrl', $this->view_object_map['documentServerUrl']);

        echo $smarty->fetch('modules/Onlyoffice/templates/editor.tpl');
    }
}