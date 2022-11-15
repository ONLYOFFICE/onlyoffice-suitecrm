<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');

class DocumentsViewOnlyofficeSettings extends SugarView
{
    public function display()
    {
       $smarty = new Sugar_Smarty();
       $onlyofficePage = $smarty->fetch('custom/modules/Documents/templates/onlyoffice_settings.tpl');
       echo $onlyofficePage;
    }
}
