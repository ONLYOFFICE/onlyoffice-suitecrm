<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

$db = DBManagerFactory::getInstance();

if (empty($_REQUEST['id']) || empty($_REQUEST['type']) || $_REQUEST['type'] != 'Documents') {
    die("Not a Valid Entry Point");
}
    require_once("data/BeanFactory.php");
    $file_type = '';
    require_once("data/BeanFactory.php");
    ini_set(
        'zlib.output_compression',
        'Off'
    );
    $file_type = strtolower($_REQUEST['type']);
    require('include/modules.php');
    $module = $db->quote($_REQUEST['type']);
    if (empty($beanList[$module])) {
        $module = ucfirst($file_type);
        if (empty($beanList[$module])) {
            die($app_strings['ERROR_TYPE_NOT_VALID']);
        }
    }
    $bean_name = $beanList[$module];
    if ($bean_name == 'aCase') {
        $bean_name = 'Case';
    }
    if (!file_exists('modules/' . $module . '/' . $bean_name . '.php')) {
        die($app_strings['ERROR_TYPE_NOT_VALID']);
    }

    $focus = BeanFactory::newBean($module);
    $focus->retrieve($_REQUEST['id']);
    if (!$focus->ACLAccess('view')) {
        die($mod_strings['LBL_NO_ACCESS']);
    }
    if (isset($focus->object_name) && $focus->object_name == 'Document') {
        $focusRevision = BeanFactory::newBean('DocumentRevisions');
        $focusRevision->retrieve($_REQUEST['id']);

        if (empty($focusRevision->id)) {
            $focusRevision->retrieve($focus->document_revision_id);

            if (!empty($focusRevision->id)) {
                $_REQUEST['id'] = $focusRevision->id;
            }
        }
    }

    if (isset($focus->doc_url) && !empty($focus->doc_url)) {
        header('Location: ' . $focus->doc_url);
        sugar_die("Remote file detected, location header sent.");
    }

    if (isset($focusRevision) && isset($focusRevision->doc_url) && !empty($focusRevision->doc_url)) {
        header('Location: ' . $focusRevision->doc_url);
        sugar_die("Remote file detected, location header sent.");
    }

    $local_location = "upload://{$_REQUEST['id']}";
    if (!file_exists($local_location) || strpos($local_location, "..")) {
        die($app_strings['ERR_INVALID_FILE_REFERENCE']);
    }
    
    $doQuery = true;
    if ($file_type == 'documents') {
        $query = "SELECT filename name FROM document_revisions INNER JOIN documents ON documents.id = document_revisions.document_id ";
        $query .= "WHERE document_revisions.id = '" . $db->quote($_REQUEST['id']) . "' ";
    } elseif ($file_type == 'kbdocuments') {
        $query = "SELECT document_revisions.filename name	FROM document_revisions INNER JOIN kbdocument_revisions ON document_revisions.id = kbdocument_revisions.document_revision_id INNER JOIN kbdocuments ON kbdocument_revisions.kbdocument_id = kbdocuments.id ";
        $query .= "WHERE document_revisions.id = '" . $db->quote($_REQUEST['id']) . "'";
    }

    $mime_type = mime_content_type($local_location);
    switch ($mime_type) {
        case 'text/html':
            $mime_type = 'text/plain';
        break;
        case null:
        case '':
            $mime_type = 'application/octet-stream';
        break;
    }

    if ($doQuery && isset($query)) {
        $rs = DBManagerFactory::getInstance()->query($query);
        $row = DBManagerFactory::getInstance()->fetchByAssoc($rs);
        if (empty($row)) {
            die($app_strings['ERROR_NO_RECORD']);
        }

        $name = $row['name'];
        if (isset($_REQUEST['field'])) {
            $id = $row[$id_field];
            $download_location = "upload://{$id}";
        } else {
            $download_location = "upload://{$_REQUEST['id']}";
        }
    }

    if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT'])) {
        $name = urlencode($name);
        $name = str_replace("+", "_", $name);
    }

    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
    header('Content-type: ' . $mime_type);
    $showPreview = false;

    global $sugar_config;

    $allowedPreview = $sugar_config['allowed_preview'] ?? [];

    if (empty($row['file_ext'])) {
        $row['file_ext'] = pathinfo($name, PATHINFO_EXTENSION);
    }

    if (in_array($row['file_ext'], $allowedPreview, true)) {
        $showPreview = isset($_REQUEST['preview']) && $_REQUEST['preview'] === 'yes' && $mime_type !== 'text/html';
    }

    if ($showPreview === true) {
        header('Content-Disposition: inline; filename="' . $name . '";');
    } else {
        header('Content-Disposition: attachment; filename="' . $name . '";');
    }
    header("X-Content-Type-Options: nosniff");
    header("Content-Length: " . filesize($local_location));
    header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));
    set_time_limit(0);

    // When output_buffering = On, ob_get_level() may return 1 even if ob_end_clean() returns false
    // This happens on some QA stacks. See Bug#64860
    while (ob_get_level() && @ob_end_clean()) {
        ;
    }

    ob_start();
    echo clean_file_output(file_get_contents($download_location), $mime_type);

    $output = ob_get_contents();
    ob_end_clean();

    echo $output;
