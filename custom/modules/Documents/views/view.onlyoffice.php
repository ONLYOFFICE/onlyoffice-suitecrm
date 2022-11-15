<?php

if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');

class DocumentsViewOnlyoffice extends SugarView
{
    public function display()
    {
       global $current_user;
       $document = BeanFactory::getBean('Documents', $this->view_object_map['record']);

       $smarty = new Sugar_Smarty();
       $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
       $smarty->assign('root', $root);
       $smarty->assign('user', $current_user);
       $smarty->assign('document', $document);
       $smarty->assign('doc_key', md5($document->date_modified));
       // TODO: Pass OO Docserver URL from 'Administration'
       $smarty->assign('doc_url', 'https://5174-94-51-205-118.ngrok.io');
       $onlyofficePage = $smarty->fetch('custom/modules/Documents/templates/onlyoffice.tpl');
       echo $onlyofficePage;
    }
}
