<?php

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once 'modules/Documents/views/view.detail.php';
require_once 'modules/Onlyoffice/lib/appconfig.php';

class CustomDocumentsViewDetail extends DocumentsViewDetail {
    function display() {
        parent::display();

        if (empty(AppConfig::GetDocumentServerUrl())) {
            LoggerManager::getLogger()->debug('Onlyoffice view actions: document server url is not set');
            return;
        }

        $ext = strtolower(pathinfo($this->bean->filename, PATHINFO_EXTENSION));
        if (empty(AppConfig::GetFormats()[$ext])) {
            LoggerManager::getLogger()->debug('Onlyoffice view actions: format ' . $ext . ' is not supported');
            return;
        }

        $actionTitle = translate('ONLYOFFICE_OPEN_IN_ONLYOFFICE', 'Onlyoffice');

        $js = <<<JS
            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function(){
                    var tab = document.querySelector("#tab-actions .dropdown-menu");
                    var li = document.createElement("li");
                    var input = document.createElement("input");
                    input.className = "button";
                    input.type = "button";
                    input.title = "{$actionTitle}";
                    input.value = "{$actionTitle}";
                    input.onclick = function(){
                        var id = [...document.getElementById("formDetailView").children].find((child) => child.name === "record").value;
                        window.location.href="index.php?module=Onlyoffice&action=editor&record=" + id;
                    };
                    li.appendChild(input);
                    tab.appendChild(li);
                });
            </script>
        JS;

        echo $js;
    }
}